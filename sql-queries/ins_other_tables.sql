INSERT INTO COUNTRY (Cou_Name)
VALUES ('United States'), ('Canada'), ('Mexico'), ('Brazil'), ('Argentina');

INSERT INTO ADDRESS (Add_Street_Nr, Add_Street_Name, Add_City, Cou_Id)
VALUES (456, 'Oak St', 'Toronto', 2),
       (789, 'Maple Ave', 'Vancouver', 2),
       (321, 'Pine St', 'Montreal', 2),
       (654, 'Cedar Blvd', 'Calgary', 2),
       (987, 'Birch St', 'Ottawa', 2),
       (12, 'Elm St', 'São Paulo', 4),
       (34, 'Cypress St', 'Buenos Aires', 5),
       (56, 'Willow St', 'Rio de Janeiro', 4);

INSERT INTO ADDRESS_STATUS (AdS_Name)
VALUES ('Active'), ('Inactive'), ('Pending');

INSERT INTO CUSTOMER_ADDRESS (Cus_Id, Add_Id, AdS_Id)
VALUES (1, 1, 1), (1, 2, 1), (2, 3, 1), (3, 4, 1), (4, 5, 1), (5, 3, 1);

INSERT INTO CUS_ORDER (Cus_Id, ShM_Id, Ord_Date, Add_Id)
VALUES (1, 1, '2022-01-01', 1), (2, 2, '2022-01-02', 2), (3, 3, '2022-01-03', 3);

INSERT INTO ORDER_LINE (Boo_ISBN, Ord_Id, OrL_Quantity)
VALUES ('0590353403', 1, 2),
       ('0545139722', 1, 3),
       ('0439064864', 1, 4),
       ('0590353403', 2, 1),
       ('0385472579', 2, 2),
       ('0590353403', 3, 3),
       ('0316015849', 3, 4);

INSERT INTO ORDER_HISTORY (OrS_Id, Ord_Id, OrH_Description, OrH_Date)
VALUES (1, 1, 'Order placed', '2022-01-01'), (2, 2, 'Order shipped', '2022-01-02'), (3, 3, 'Order received', '2022-01-03');

INSERT INTO EMPLOYEE (Emp_FirstName, Emp_LastName, Rol_Id)
VALUES ('John', 'Doe', 2), ('Jane', 'Doe', 2), ('Bob', 'Smith', 1);