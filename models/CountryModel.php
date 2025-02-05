<?php
class CountryModel {
  public static function getAllCountries() {
    $query = 'SELECT * FROM COUNTRY ORDER BY Cou_Name';
    return retrieveAllRows($query);
  }
}