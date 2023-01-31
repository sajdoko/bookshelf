<?php
// Include database connection
  require_once dirname(__FILE__, 3).'/includes/db_conn.php';

  /**
   * Get a list of the most sold books.
   *
   * @param  int  $quantity
   *
   * @return array An array of books.
   */
  function get_dash_best_sellers(int $quantity = 5): array
  {
    // Select most sold books
    $query = 'SELECT TOP (?) BOOK.Boo_ISBN, BOOK.Boo_Title, A.Aut_Name, SUM(OL.OrL_Quantity) AS Quantity, SUM(OL.OrL_Tot_Price) AS Amount
              FROM BOOK
                       LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
                       LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
                       LEFT JOIN ORDER_LINE OL ON BOOK.Boo_ISBN = OL.Boo_ISBN
              WHERE BOOK.Boo_ISBN IN (
                SELECT TOP (?) BOOK.Boo_ISBN
                FROM BOOK
                         INNER JOIN ORDER_LINE ON BOOK.Boo_ISBN = ORDER_LINE.Boo_ISBN
                GROUP BY BOOK.Boo_ISBN
                ORDER BY SUM(ORDER_LINE.OrL_Quantity) DESC
              )
              GROUP BY BOOK.Boo_ISBN, BOOK.Boo_Title, A.Aut_Name
              ORDER BY Quantity DESC';

    return retrieveAllRows($query, [$quantity, $quantity]);
  }

  function get_customers_growth(): array
  {
    $query = 'SELECT COUNT(*) AS Nr_Customers, COUNT(*) -
                     (SELECT COUNT(*)
                      FROM CUSTOMER
                      WHERE Cus_Reg_Date >= DATEADD(month, -1, GETDATE())
                        AND Cus_Reg_Date < GETDATE())
                         AS NewSinceLastMonth
              FROM CUSTOMER';
    return retrieveOneRow($query);
  }

  function get_orders_growth(): array
  {
    $query = 'SELECT COUNT(*) AS Nr_Orders, COUNT(*) -
                     (SELECT COUNT(*)
                      FROM CUS_ORDER
                      WHERE Ord_Date >= DATEADD(month, -1, GETDATE())
                        AND Ord_Date < GETDATE())
                         AS NewSinceLastMonth
              FROM CUS_ORDER';
    return retrieveOneRow($query);
  }

  /**
   * This query uses the DATEPART function to extract the month and year from the Ord_Date column. The WHERE clause is used to filter only the orders
   * from the last 3 months. The query groups the data by month and year, and the SUM function calculates the sum of Ord_Tot_Val for each group.
   * Finally, the query sorts the result by year and month using the ORDER BY clause.
   *
   * @return array
   */
  function get_revenue_last_2_months(): array
  {
    $query = 'SELECT DATEPART(month, Ord_Date) AS Month,
                     DATEPART(year, Ord_Date)  AS Year,
                     SUM(Ord_Tot_Val)          AS Month_Revenue
              FROM CUS_ORDER
              WHERE Ord_Date >= DATEADD(month, -2, GETDATE())
              GROUP BY DATEPART(month, Ord_Date),
                       DATEPART(year, Ord_Date)
              ORDER BY DATEPART(year, Ord_Date) DESC';
    return retrieveAllRows($query);
  }

  /**
   * @return array
   */
  function get_revenue_growth_all_months(): array
  {
    $query = 'WITH revenue_by_month AS (SELECT DATEFROMPARTS(YEAR(Ord_Date), MONTH(Ord_Date), 1) AS month, SUM(Ord_Tot_Val) AS total_revenue
                                        FROM CUS_ORDER
                                        GROUP BY DATEFROMPARTS(YEAR(Ord_Date), MONTH(Ord_Date), 1))
              SELECT month,
                     total_revenue,
                     total_revenue - LAG(total_revenue) OVER (ORDER BY month) AS revenue_growth
              FROM revenue_by_month
              ORDER BY month';
    return retrieveAllRows($query);
  }