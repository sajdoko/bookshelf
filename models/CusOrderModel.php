<?php
class CusOrderModel {

  public static function addCustomerOrder($user_id, $sh_m_id, $order_tot_val) {
    $query = 'INSERT INTO CUS_ORDER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_ORD_ID, ?, ?, ?, ?)';
    return insertQuery($query, [$user_id, $sh_m_id, date('Y-m-d H:i:s'), $order_tot_val]);
  }

  public static function updateCustomerOrder($order_id, $order_status) {
    $query = 'UPDATE CUS_ORDER SET Ord_Status = ? WHERE Ord_Id = ?';
    return executeQuery($query, [$order_id, $order_status]);
  }

  public static function getCustomerOrders($cusId) {
    $query = "SELECT CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name, OS.OrS_Name
              FROM CUS_ORDER
              JOIN SHIPPING_METHOD SM ON CUS_ORDER.ShM_Id = SM.ShM_Id
              LEFT JOIN
                  (SELECT Ord_Id, MAX(OrH_Date) AS OrH_Date FROM ORDER_HISTORY GROUP BY Ord_Id) AS Order_History_Max
                  ON CUS_ORDER.Ord_Id = Order_History_Max.Ord_Id
              LEFT JOIN ORDER_HISTORY OH ON CUS_ORDER.Ord_Id = OH.Ord_Id AND Order_History_Max.OrH_Date = OH.OrH_Date
              LEFT JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id
              WHERE CUS_ORDER.Cus_Id = ?";

    return retrieveAllRows($query, [$cusId]);
  }

  public static function addOrderHistory($orS_Id, $ord_id, $ord_status) {
    $query = 'INSERT INTO ORDER_HISTORY VALUES (?, ?, ?, ?)';
    return insertQuery($query, [$orS_Id, $ord_id, $ord_status, date('Y-m-d H:i:s')]);
  }
}