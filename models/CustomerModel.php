<?php
class CustomerModel {

  public static function retrieveCustomerByEmail($email) {
    $query = 'SELECT Cus_Id, Cus_Email, Cus_Pass FROM CUSTOMER WHERE Cus_Email = ?';
    return retrieveOneRow($query, [$email]);
  }

  public static function addOneCustomer( $first_name, $last_name, $email, $password, $phone ) {
    $query = 'INSERT INTO CUSTOMER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?)';
    return insertQuery($query, [$first_name, $last_name, $email, $password, $phone, date('Y-m-d H:i:s')]);
  }

  public static function addCustomerAddress($cus_id, $street, $zip, $city, $country_id) {
    $query = 'INSERT INTO ADDRESS VALUES (?, NEXT VALUE FOR SEQ_ADD_ID, ?, ?, ?, ?)';
    return insertQuery($query, [$cus_id, $street, $zip, $city, $country_id]);
  }

}