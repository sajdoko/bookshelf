-- Inserting records into the COUNTRY table
INSERT INTO COUNTRY (Cou_Alpha2Code, Cou_Name)
VALUES ('DZ', 'Algeria'),
       ('AD', 'Andorra');

-- Inserting records into the BOOK_LANGUAGE table
INSERT INTO BOOK_LANGUAGE (BoL_Id, BoL_Name)
VALUES (NEXT VALUE FOR SEQ_BOL_ID, 'Albanian'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Arabic');

-- Inserting records into the PUBLISHER table
INSERT INTO PUBLISHER (Pub_Id, Pub_Name, Pub_Phone)
VALUES (NEXT VALUE FOR SEQ_PUB_ID, 'Canadian Institute of Technology', '123456789'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Polytechnic University of Tirana', '987654321');

-- Updating a record in the PUBLISHER table
UPDATE PUBLISHER
SET Pub_Name  = 'Doubleday',
    Pub_Phone = '098-765-4321'
WHERE Pub_ID = 1;

-- Deleting a record from the COUNTRY table
DELETE
FROM COUNTRY
WHERE Cou_Alpha2Code = 'AD';

-- Selecting data from BOOK and PUBLISHER tables using INNER JOIN
SELECT BOOK.Boo_Title, PUBLISHER.Pub_Name
FROM BOOK
         INNER JOIN PUBLISHER
                    ON BOOK.pub_id = PUBLISHER.pub_id;

-- Selecting data from BOOK and BOOK_LANGUAGE tables using LEFT JOIN
SELECT BOOK.Boo_Title, BOOK_LANGUAGE.BoL_Name
FROM BOOK
         LEFT JOIN BOOK_LANGUAGE ON BOOK.bol_id = BOOK_LANGUAGE.bol_id;

-- Selecting data from BOOK, BOOK_GENRE and GENRE tables using RIGHT JOIN
SELECT BOOK.Boo_Title, BOOK_GENRE.Boo_ISBN, G.Gen_Name
FROM BOOK
         RIGHT JOIN BOOK_GENRE ON BOOK.boo_isbn = BOOK_GENRE.boo_isbn
         JOIN GENRE G on G.Gen_Id = BOOK_GENRE.Gen_Id;

-- Selecting data from BOOK and BOOK_AUTHOR tables using FULL OUTER JOIN
SELECT BOOK_AUTHOR.Boo_ISBN, BOOK.Boo_Title, BOOK_AUTHOR.Aut_Id
FROM BOOK
         FULL OUTER JOIN BOOK_AUTHOR ON BOOK.boo_isbn = BOOK_AUTHOR.boo_isbn;

-- Selecting data from BOOK table and ranking them based on Boo_Price
SELECT Boo_Title, Boo_Price, RANK() OVER (ORDER BY Boo_Price DESC) as Rank
FROM BOOK;

-- Using CTE to calculate total quantity for each customer and joining it with Customer table
WITH CTE AS (SELECT Cus_Id, SUM(Orl_Quantity) as Total_Quantity
             FROM Order_Line
                      JOIN Cus_Order
                           ON Order_Line.Ord_Id = Cus_Order.Ord_Id
             GROUP BY Cus_Id)
SELECT Customer.Cus_FirstName, Customer.Cus_LastName, Total_Quantity
FROM Customer
         JOIN CTE ON Customer.Cus_Id = CTE.Cus_Id;

-- Starting a transaction to insert a record into SHIPPING_METHOD table and committing the transaction
BEGIN TRANSACTION;
INSERT INTO SHIPPING_METHOD(ShM_Id, ShM_Name, ShM_Price)
VALUES (NEXT VALUE FOR SEQ_SHM_ID, 'Express', 9.99);
COMMIT;

-- Starting a transaction to insert a record into SHIPPING_METHOD table and rolling back the transaction
BEGIN TRANSACTION;
INSERT INTO SHIPPING_METHOD(ShM_Id, ShM_Name, ShM_Price)
VALUES (NEXT VALUE FOR SEQ_SHM_ID, 'Drone', 10.99);
ROLLBACK;
SELECT * FROM SHIPPING_METHOD;


-- Search for Books by Partial Title (Searching Characters)
SELECT Boo_Title, Boo_Description
FROM BOOK
WHERE Boo_Title LIKE '%Potter%';

-- Find Books Published Within a Specific Time Interval
SELECT Boo_Title, Boo_Pub_Date
FROM BOOK
WHERE Boo_Pub_Date BETWEEN '2000-01-01' AND '2010-12-31';

-- Calculate Total Sales for a Book (Mathematical Operators)
SELECT Boo_ISBN, SUM(OrL_Quantity) AS Total_Sales
FROM ORDER_LINE
GROUP BY Boo_ISBN;

-- List Books Priced Above Average (Logical Operators and Aggregate Functions)
SELECT Boo_Title, Boo_Price
FROM BOOK
WHERE Boo_Price > (SELECT AVG(Boo_Price) FROM BOOK);

-- Count Books by Genre (Grouping and Aggregation)
SELECT G.Gen_Name, COUNT(*) AS Num_Books
FROM BOOK_GENRE BG
JOIN GENRE G ON BG.Gen_Id = G.Gen_Id
GROUP BY G.Gen_Name;

-- List Top 5 Bestselling Books (Ranking)
SELECT TOP 5 B.Boo_Title, SUM(OL.OrL_Quantity) AS Total_Sold
FROM ORDER_LINE OL
JOIN BOOK B ON OL.Boo_ISBN = B.Boo_ISBN
GROUP BY B.Boo_Title
ORDER BY Total_Sold DESC;

-- Find Customers with Orders Total Over $100 (Subquery)
SELECT C.Cus_FirstName, C.Cus_LastName
FROM CUSTOMER C
JOIN CUS_ORDER CO ON C.Cus_Id = CO.Cus_Id
WHERE CO.Ord_Id IN (
    SELECT Ord_Id
    FROM ORDER_LINE
    GROUP BY Ord_Id
    HAVING SUM(OrL_Tot_Price) > 100
);

-- Show Monthly Sales Figures (Date Functions and Grouping)
SELECT YEAR(Ord_Date) AS Year, MONTH(Ord_Date) AS Month, COUNT(*) AS Total_Orders
FROM CUS_ORDER
GROUP BY YEAR(Ord_Date), MONTH(Ord_Date)
ORDER BY Year, Month;

-- List Authors with More Than One Book (Having Clause)
SELECT A.Aut_Name, COUNT(*) AS Num_Books
FROM AUTHOR A
JOIN BOOK_AUTHOR BA ON A.Aut_Id = BA.Aut_Id
GROUP BY A.Aut_Name
HAVING COUNT(*) > 1;

-- Average Price of Books by Publisher (Join and Aggregate)
SELECT P.Pub_Name, AVG(B.Boo_Price) AS Avg_Price
FROM BOOK B
JOIN PUBLISHER P ON B.Pub_Id = P.Pub_Id
GROUP BY P.Pub_Name;

-- Average Price of Books by Publisher (Join and Aggregate)
SELECT B.Boo_Title, B.Boo_Price, G.Gen_Name
FROM BOOK B
JOIN BOOK_GENRE BG ON B.Boo_ISBN = BG.Boo_ISBN
JOIN GENRE G ON BG.Gen_Id = G.Gen_Id
WHERE B.Boo_Price > (
    SELECT AVG(B2.Boo_Price)
    FROM BOOK B2
    JOIN BOOK_GENRE BG2 ON B2.Boo_ISBN = BG2.Boo_ISBN
    WHERE BG2.Gen_Id = BG.Gen_Id
);

-- List Customers Who Have Placed Orders for Every Genre
SELECT C.Cus_FirstName, C.Cus_LastName
FROM CUSTOMER C
WHERE NOT EXISTS (
    SELECT *
    FROM GENRE G
    WHERE NOT EXISTS (
        SELECT *
        FROM CUS_ORDER CO
        JOIN ORDER_LINE OL ON CO.Ord_Id = OL.Ord_Id
        JOIN BOOK B ON OL.Boo_ISBN = B.Boo_ISBN
        JOIN BOOK_GENRE BG ON B.Boo_ISBN = BG.Boo_ISBN
        WHERE BG.Gen_Id = G.Gen_Id AND CO.Cus_Id = C.Cus_Id
    )
);

-- Find Publishers Whose Books Have All Been Sold Out
SELECT P.Pub_Name
FROM PUBLISHER P
WHERE NOT EXISTS (
    SELECT *
    FROM BOOK B
    WHERE B.Pub_Id = P.Pub_Id AND B.Boo_QOH > 0
);

-- The COMMIT statement in SQL is used to end a transaction and make permanent all changes made during the transaction.
BEGIN TRANSACTION;
INSERT INTO SHIPPING_METHOD(ShM_Id, ShM_Name, ShM_Price)
VALUES (NEXT VALUE FOR SEQ_SHM_ID, 'Express', 9.99);
COMMIT;

-- Rollback
BEGIN TRANSACTION;
INSERT INTO SHIPPING_METHOD(ShM_Id, ShM_Name, ShM_Price)
VALUES (NEXT VALUE FOR SEQ_SHM_ID, 'Drone', 10.99);
ROLLBACK;
SELECT * FROM SHIPPING_METHOD;

-- Add a foreign key constraint to the BOOK_GENRE table
ALTER TABLE BOOK_GENRE ADD CONSTRAINT fk_book_genre_book_1
FOREIGN KEY (Boo_ISBN) REFERENCES BOOK (Boo_ISBN);