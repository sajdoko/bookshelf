<?php
use PHPUnit\Framework\TestCase;
require_once dirname(__DIR__) . '/autoload.php';

class FunctionsTest extends TestCase {
  public function testRetrieveOneRow() {
    // Mock database connection and expected result
    global $conn;
    $conn = $this->createMock(PDO::class);
    $stmt = $this->createMock(PDOStatement::class);

    $query          = 'SELECT * FROM CUSTOMER WHERE Cus_Id = ?';
    $params         = [1];
    $expectedResult = ['Cus_Id' => 1, 'Cus_FirstName' => 'John', 'Cus_LastName' => 'Doe', 'Cus_Email' => 'john.doe@example.com', 'Cus_Pass' => 'password', 'Cus_Phone' => '1234567890', 'Cus_Reg_Date' => '2023-01-01'];

    $stmt->method('execute')->with($params)->willReturn(true);
    $stmt->method('fetch')->willReturn($expectedResult);
    $conn->method('prepare')->with($query)->willReturn($stmt);

    $result = retrieveOneRow($query, $params);
    $this->assertEquals($expectedResult, $result);
  }

  public function testRetrieveAllRows() {
    // Mock database connection and expected result
    global $conn;
    $conn = $this->createMock(PDO::class);
    $stmt = $this->createMock(PDOStatement::class);

    $query          = 'SELECT * FROM CUSTOMER';
    $expectedResult = [
      ['Cus_Id' => 1, 'Cus_FirstName' => 'John', 'Cus_LastName' => 'Doe', 'Cus_Email' => 'john.doe@example.com', 'Cus_Pass' => 'password', 'Cus_Phone' => '1234567890', 'Cus_Reg_Date' => '2023-01-01'],
      ['Cus_Id' => 2, 'Cus_FirstName' => 'Jane', 'Cus_LastName' => 'Doe', 'Cus_Email' => 'jane.doe@example.com', 'Cus_Pass' => 'password', 'Cus_Phone' => '0987654321', 'Cus_Reg_Date' => '2023-01-02'],
    ];

    $stmt->method('execute')->willReturn(true);
    $stmt->method('fetchAll')->willReturn($expectedResult);
    $conn->method('prepare')->with($query)->willReturn($stmt);

    $result = retrieveAllRows($query);
    $this->assertEquals($expectedResult, $result);
  }

  public function testInsertQuery() {
    global $conn;
    $conn = $this->createMock(PDO::class);
    $stmt = $this->createMock(PDOStatement::class);

    $query          = 'INSERT INTO CUSTOMER (Cus_FirstName, Cus_LastName, Cus_Email, Cus_Pass, Cus_Phone, Cus_Reg_Date) VALUES (?, ?, ?, ?, ?, ?)';
    $params         = ['John', 'Doe', 'john.doe@example.com', 'password', '1234567890', '2023-01-01'];
    $expectedResult = 1;

    $conn->expects($this->once())->method('beginTransaction');
    $conn->expects($this->once())->method('rollBack');
    $stmt->method('execute')->with($params)->willReturn(true);
    $stmt->method('rowCount')->willReturn($expectedResult);
    $conn->method('prepare')->with($query)->willReturn($stmt);

    $conn->beginTransaction();
    $result = insertUser($query, $params);
    $conn->rollBack();

    $this->assertEquals($expectedResult, $result);
  }
}
