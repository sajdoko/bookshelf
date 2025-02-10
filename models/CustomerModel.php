<?php
class CustomerModel {

  public static function retrieveCustomerByEmail($email) {
    $query = 'SELECT Cus_Id, Cus_Email, Cus_Pass FROM CUSTOMER WHERE Cus_Email = ?';
    return retrieveOneRow($query, [$email]);
  }

  public static function addOneCustomer($first_name, $last_name, $email, $password, $phone) {
    $query = 'INSERT INTO CUSTOMER (Cus_Id, Cus_FirstName, Cus_LastName, Cus_Email, Cus_Pass, Cus_Phone, Cus_Reg_Date) OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?)';
    return insertQuery($query, [$first_name, $last_name, $email, $password, $phone, date('Y-m-d H:i:s')]);
  }

  public static function addCustomerAddress($cus_id, $street, $zip, $city, $country_id) {
    $query = 'INSERT INTO ADDRESS (Cus_Id, Add_Id, Add_Street_Name, Add_Zip, Add_City, Cou_Alpha2Code) VALUES (?, NEXT VALUE FOR SEQ_ADD_ID, ?, ?, ?, ?)';
    $result = insertQuery($query, [$cus_id, $street, $zip, $city, $country_id]);
    if ($result === false) {
      error_log('Error inserting address: ' . print_r($result, true));
    }
    return $result;
  }

}