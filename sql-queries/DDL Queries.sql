CREATE TABLE COUNTRY
(
    Cou_Alpha2Code CHAR(2)     NOT NULL,
    Cou_Name       VARCHAR(50) NOT NULL,
    PRIMARY KEY (Cou_Alpha2Code)
);

CREATE TABLE BOOK_LANGUAGE
(
    BoL_Id   INT PRIMARY KEY,
    BoL_Name VARCHAR(255) NOT NULL
);
CREATE SEQUENCE SEQ_BOL_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE PUBLISHER
(
    Pub_Id    INT PRIMARY KEY,
    Pub_Name  VARCHAR(255) NOT NULL,
    Pub_Phone VARCHAR(255) NOT NULL
);
CREATE SEQUENCE SEQ_PUB_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE GENRE
(
    Gen_Id   INT PRIMARY KEY,
    Gen_Name VARCHAR(255) NOT NULL
);
CREATE SEQUENCE SEQ_GEN_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE AUTHOR
(
    Aut_Id   INT PRIMARY KEY,
    Aut_Name VARCHAR(255) NOT NULL,
    Aut_Bio  VARCHAR(MAX) NOT NULL
);
CREATE SEQUENCE SEQ_AUT_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE SHIPPING_METHOD
(
    ShM_Id    INT PRIMARY KEY,
    ShM_Name  VARCHAR(255) NOT NULL,
    ShM_Price FLOAT        NOT NULL
);
CREATE SEQUENCE SEQ_SHM_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE ORDER_STATUS
(
    OrS_Id   INT PRIMARY KEY,
    OrS_Name VARCHAR(255) NOT NULL
);
CREATE SEQUENCE SEQ_ORS_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE EMPLOYEE
(
    Emp_Id        INT PRIMARY KEY,
    Emp_Type      VARCHAR(255) NOT NULL CHECK ([Emp_Type] IN('Manager', 'Sales_Person')) DEFAULT 'Sales_Person',
    Emp_FirstName VARCHAR(255) NOT NULL,
    Emp_LastName  VARCHAR(255) NOT NULL,
    Emp_Email     VARCHAR(255) NOT NULL,
    Emp_Pass      VARCHAR(255) NOT NULL,
    Emp_Phone     VARCHAR(255) NOT NULL
);
CREATE SEQUENCE SEQ_EMP_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE MANAGER
(
    Emp_Id        INT PRIMARY KEY,
    Department    VARCHAR(255) NOT NULL,
    FOREIGN KEY (Emp_Id) REFERENCES EMPLOYEE(Emp_Id)
);

CREATE TABLE SALES_PERSON
(
    Emp_Id          INT PRIMARY KEY,
    Sls_Commission  FLOAT NOT NULL,
    FOREIGN KEY (Emp_Id) REFERENCES EMPLOYEE(Emp_Id)
);


CREATE TABLE BOOK
(
    Boo_ISBN        VARCHAR(255) PRIMARY KEY,
    Pub_Id          INT          NOT NULL,
    BoL_Id          INT          NOT NULL,
    Boo_Title       VARCHAR(255) NOT NULL,
    Boo_Description VARCHAR(MAX) NOT NULL,
    Boo_Price       FLOAT        NOT NULL,
    Boo_Pub_Date    DATE         NOT NULL,
    Boo_Img_url     VARCHAR(255) NOT NULL,
    Boo_Featured    BIT          NOT NULL,
    Boo_QOH         INT          NOT NULL,
    FOREIGN KEY (Pub_Id) REFERENCES PUBLISHER (Pub_Id),
    FOREIGN KEY (BoL_Id) REFERENCES BOOK_LANGUAGE (BoL_Id)
);

CREATE TABLE CUSTOMER
(
    Cus_Id        INT PRIMARY KEY,
    Cus_FirstName VARCHAR(255) NOT NULL,
    Cus_LastName  VARCHAR(255) NOT NULL,
    Cus_Email     VARCHAR(255) NOT NULL,
    Cus_Pass      VARCHAR(255) NOT NULL,
    Cus_Phone     VARCHAR(255) NOT NULL,
    Cus_Reg_Date  DATETIME     NOT NULL
);
CREATE SEQUENCE SEQ_CUS_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE BOOK_GENRE
(
    Boo_ISBN VARCHAR(255) NOT NULL,
    Gen_Id   INT          NOT NULL,
    PRIMARY KEY (Boo_ISBN, Gen_Id),
    FOREIGN KEY (Boo_ISBN) REFERENCES BOOK (Boo_ISBN) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Gen_Id) REFERENCES GENRE (Gen_Id)
);

CREATE TABLE CUS_ORDER
(
    Ord_Id      INT PRIMARY KEY,
    Cus_Id      INT      NOT NULL,
    ShM_Id      INT      NOT NULL,
    Ord_Date    DATETIME NOT NULL,
    Ord_Tot_Val FLOAT    NOT NULL,
    FOREIGN KEY (Cus_Id) REFERENCES CUSTOMER (Cus_Id),
    FOREIGN KEY (ShM_Id) REFERENCES SHIPPING_METHOD (ShM_Id)
);
CREATE SEQUENCE SEQ_ORD_ID START WITH 1 INCREMENT BY 1 NO CACHE;

CREATE TABLE ORDER_HISTORY
(
    OrS_Id          INT          NOT NULL,
    Ord_Id          INT          NOT NULL,
    OrH_Description VARCHAR(MAX) NOT NULL,
    OrH_Date        DATETIME     NOT NULL,
    PRIMARY KEY (OrS_Id, Ord_Id),
    FOREIGN KEY (OrS_Id) REFERENCES ORDER_STATUS (OrS_Id),
    FOREIGN KEY (Ord_Id) REFERENCES CUS_ORDER (Ord_Id)
);

CREATE TABLE BOOK_AUTHOR
(
    Boo_ISBN VARCHAR(255),
    Aut_Id   INT,
    PRIMARY KEY (Boo_ISBN, Aut_Id),
    FOREIGN KEY (Boo_ISBN) REFERENCES BOOK (Boo_ISBN) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Aut_Id) REFERENCES AUTHOR (Aut_Id)
);

CREATE TABLE ORDER_LINE
(
    Boo_ISBN      VARCHAR(255),
    Ord_Id        INT,
    OrL_Quantity  INT   NOT NULL,
    OrL_Tot_Price FLOAT NOT NULL,
    OrL_Price     FLOAT NOT NULL,
    PRIMARY KEY (Boo_ISBN, Ord_Id),
    FOREIGN KEY (Boo_ISBN) REFERENCES BOOK (Boo_ISBN),
    FOREIGN KEY (Ord_Id) REFERENCES CUS_ORDER (Ord_Id)
);

CREATE TABLE ADDRESS
(
    Cus_Id          INT,
    Add_Id          INT,
    Add_Street_Name VARCHAR(255) NOT NULL,
    Add_Zip         INT          NOT NULL,
    Add_City        VARCHAR(255) NOT NULL,
    Cou_Alpha2Code  CHAR(2)      NOT NULL,
    PRIMARY KEY (Cus_Id, Add_Id),
    FOREIGN KEY (Cus_Id) REFERENCES CUSTOMER (Cus_Id),
    FOREIGN KEY (Cou_Alpha2Code) REFERENCES COUNTRY (Cou_Alpha2Code)
);
CREATE SEQUENCE SEQ_ADD_ID START WITH 1 INCREMENT BY 1 NO CACHE;