<?php

use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/../autoload.php'; // Includes global $conn

class IntegrationTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        global $conn;
        $this->conn = $conn; // Use the real connection from autoload.php

        // Ensure CUSTOMER table exists
        $this->conn->exec("
            IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='CUSTOMER' AND xtype='U')
            CREATE TABLE CUSTOMER (
                Cus_Id INT IDENTITY(1,1) PRIMARY KEY,
                Cus_FirstName NVARCHAR(100),
                Cus_LastName NVARCHAR(100),
                Cus_Email NVARCHAR(255) UNIQUE,
                Cus_Pass NVARCHAR(255),
                Cus_Phone NVARCHAR(20),
                Cus_Reg_Date DATETIME
            );
        ");

        // Ensure CUS_ORDER table exists
        $this->conn->exec("
            IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='CUS_ORDER' AND xtype='U')
            CREATE TABLE CUS_ORDER (
                Ord_Id INT IDENTITY(1,1) PRIMARY KEY,
                Cus_Id INT,
                Ord_Date DATETIME,
                Ord_Tot_Val DECIMAL(10,2),
                FOREIGN KEY (Cus_Id) REFERENCES CUSTOMER(Cus_Id)
            );
        ");
    }

    public function testCustomerOrderIntegration() {
        // Customer details
        $first_name = 'John';
        $last_name = 'Doe';
        $email = 'john.doe@example.com';
        $password = 'password123';
        $phone = '1234567890';
        $reg_date = date('Y-m-d H:i:s');

        // Insert a customer using SEQUENCE and OUTPUT INSERTED.*
        $query = 'INSERT INTO CUSTOMER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$first_name, $last_name, $email, $password, $phone, $reg_date]);

        // Fetch the inserted customer
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotEmpty($customer, "Customer insertion failed.");

        $customerId = $customer['Cus_Id'] ?? null;
        $this->assertNotNull($customerId, "Customer ID retrieval failed.");

        // Insert an order linked to the customer
        $orderQuery = 'INSERT INTO CUS_ORDER (Ord_Id, Cus_Id, ShM_Id, Ord_Date, Ord_Tot_Val) OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_ORD_ID, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($orderQuery);
        $stmt->execute([$customerId, 1, date('Y-m-d H:i:s'), 99.99]);

        // Fetch the inserted order
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($order);
        $this->assertNotEmpty($order, "Order insertion failed.");
        $this->assertEquals(99.99, $order['Ord_Tot_Val'], "Order total value mismatch.");
    }

    protected function tearDown(): void {
        // Clean up test data
        $this->conn->exec("DELETE FROM ORDER_LINE;");
        $this->conn->exec("DELETE FROM ORDER_HISTORY;");
        $this->conn->exec("DELETE FROM ADDRESS;");
        $this->conn->exec("DELETE FROM CUS_ORDER;");
        $this->conn->exec("DELETE FROM CUSTOMER;");
    }
}
