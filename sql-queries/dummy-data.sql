INSERT INTO COUNTRY ([Cou_Alpha2Code], [Cou_Name])
VALUES ('US', 'United States'),
       ('CA', 'Canada'),
       ('MX', 'Mexico'),
       ('GB', 'United Kingdom'),
       ('FR', 'France'),
       ('DE', 'Germany'),
       ('IT', 'Italy'),
       ('ES', 'Spain'),
       ('JP', 'Japan'),
       ('CN', 'China');

INSERT INTO BOOK_LANGUAGE (BoL_Id, BoL_Name)
VALUES (NEXT VALUE FOR SEQ_BOL_ID, 'English'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Spanish'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'French'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'German'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Russian');

INSERT INTO ROLE (Rol_Id, Rol_Name)
VALUES (NEXT VALUE FOR SEQ_ROL_ID, 'Administrator'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Employee'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Customer'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Guest'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Moderator');

INSERT INTO PUBLISHER (Pub_Id, Pub_Name, Pub_Phone)
VALUES
  (NEXT VALUE FOR SEQ_PUB_ID, 'Penguin Random House', '555-555-5555'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'HarperCollins', '555-555-5556'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Simon & Schuster', '555-555-5557'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Hachette Book Group', '555-555-5558'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Macmillan Publishers', '555-555-5559'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Random House', '555-555-5560'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Scholastic', '555-555-5561'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Oxford University Press', '555-555-5562'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Bloomsbury Publishing', '555-555-5563'),
  (NEXT VALUE FOR SEQ_PUB_ID, 'Pan Macmillan', '555-555-5564')

INSERT INTO GENRE (Gen_Id, Gen_Name)
VALUES
(NEXT VALUE FOR SEQ_GEN_ID, 'Science Fiction'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Fantasy'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Mystery'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Historical'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Horror'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Romance'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Drama'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Comedy'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Action'),
(NEXT VALUE FOR SEQ_GEN_ID, 'Adventure');

INSERT INTO AUTHOR (Aut_Id, Aut_Name, Aut_Bio)
VALUES
(NEXT VALUE FOR SEQ_AUT_ID, 'Stephen King', 'American author of horror, supernatural fiction, suspense, science fiction, and fantasy novels'),
(NEXT VALUE FOR SEQ_AUT_ID, 'J.K. Rowling', 'British author, philanthropist, film producer, television producer, and screenwriter'),
(NEXT VALUE FOR SEQ_AUT_ID, 'George R.R. Martin', 'American novelist and short-story writer in the science fiction and fantasy genres'),
(NEXT VALUE FOR SEQ_AUT_ID, 'Agatha Christie', 'English writer known for her 66 detective novels and 14 short story collections'),
(NEXT VALUE FOR SEQ_AUT_ID, 'Neil Gaiman', 'English author of short fiction, novels, comic books, graphic novels, nonfiction, audio theatre, and films'),
(NEXT VALUE FOR SEQ_AUT_ID, 'Dan Brown', 'American author of thriller novels, most notably the Robert Langdon stories'),
(NEXT VALUE FOR SEQ_AUT_ID, 'Lee Child', 'British author and creator of the Jack Reacher novels'),
(NEXT VALUE FOR SEQ_AUT_ID, 'Michael Connelly', 'American author of detective novels and other crime fiction'),
(NEXT VALUE FOR SEQ_AUT_ID, 'John Grisham', 'American novelist, attorney, politician, and activist best known for his popular legal thrillers'),
(NEXT VALUE FOR SEQ_AUT_ID, 'Margaret Atwood', 'Canadian poet, novelist, literary critic, essayist, inventor, teacher, and environmental activist')
;

INSERT INTO SHIPPING_METHOD (ShM_Id, ShM_Name, ShM_Price)
VALUES
(NEXT VALUE FOR SEQ_SHM_ID, 'Standard', 5.99),
(NEXT VALUE FOR SEQ_SHM_ID, 'Expedited', 9.99),
(NEXT VALUE FOR SEQ_SHM_ID, 'Overnight', 19.99);

INSERT INTO ORDER_STATUS (OrS_Id, OrS_Name)
VALUES
  (NEXT VALUE FOR SEQ_ORS_ID, 'Pending'),
  (NEXT VALUE FOR SEQ_ORS_ID, 'Shipped'),
  (NEXT VALUE FOR SEQ_ORS_ID, 'Delivered'),
  (NEXT VALUE FOR SEQ_ORS_ID, 'Cancelled'),
  (NEXT VALUE FOR SEQ_ORS_ID, 'Returned');

INSERT INTO EMPLOYEE (Emp_Id, Emp_FirstName, Emp_LastName, Emp_Email, Emp_Pass, Emp_Phone, Rol_Id)
VALUES
    (NEXT VALUE FOR SEQ_EMP_ID, 'John', 'Doe', 'johndoe@email.com', 'password1', '555-555-1212', 2),
    (NEXT VALUE FOR SEQ_EMP_ID, 'Jane', 'Smith', 'janesmith@email.com', 'password2', '555-555-1213', 2),
    (NEXT VALUE FOR SEQ_EMP_ID, 'Bob', 'Johnson', 'bobjohnson@email.com', 'password3', '555-555-1214', 2),
    (NEXT VALUE FOR SEQ_EMP_ID, 'Amy', 'Williams', 'amywilliams@email.com', 'password4', '555-555-1215', 2),
    (NEXT VALUE FOR SEQ_EMP_ID, 'Tom', 'Brown', 'tombrown@email.com', 'password5', '555-555-1216', 2);

INSERT INTO BOOK (Boo_ISBN, Pub_Id, BoL_Id, Boo_Title, Boo_Description, Boo_Price, Boo_Pub_Date, Boo_Img_url, Boo_Featured, Boo_QOH)
VALUES
(9780910972321, 1, 1, 'The Great Gatsby', 'A novel by F. Scott Fitzgerald', 19.99, '2022-01-01', 'https://covers.openlibrary.org/b/id/9367541-L.jpg', 1, 20),
(9788973062010, 2, 2, 'To Kill a Mockingbird', 'A novel by Harper Lee', 15.99, '2022-02-01', 'https://covers.openlibrary.org/b/id/12606568-L.jpg', 1, 15),
(3456789012, 3, 3, 'Pride and Prejudice', 'A novel by Jane Austen', 17.99, '2022-03-01', 'https://covers.openlibrary.org/b/id/12991919-L.jpg', 1, 25),
(4567890123, 4, 1, 'One Hundred Years of Solitude', 'A novel by Gabriel Garcia Marquez', 21.99, '2022-04-01', 'https://covers.openlibrary.org/b/id/40565-L.jpg', 1, 30),
(5678901234, 5, 2, 'Moby-Dick', 'A novel by Herman Melville', 18.99, '2022-05-01', 'https://covers.openlibrary.org/b/id/12022194-L.jpg', 1, 10),
(6789012345, 6, 3, 'The Catcher in the Rye', 'A novel by J.D. Salinger', 16.99, '2022-06-01', 'https://covers.openlibrary.org/b/id/8427258-L.jpg', 1, 5),
(7890123456, 7, 1, 'The Grapes of Wrath', 'A novel by John Steinbeck', 19.99, '2022-07-01', 'https://covers.openlibrary.org/b/id/12715902-L.jpg', 1, 25),
(8901234567, 8, 2, 'The Sun Also Rises', 'A novel by Ernest Hemingway', 20.99, '2022-08-01', 'https://covers.openlibrary.org/b/id/426184-L.jpg', 1, 30),
(9012345678, 9, 3, '1984', 'A novel by George Orwell', 14.99, '2022-09-01', 'https://covers.openlibrary.org/b/id/12525678-L.jpg', 1, 15),
(0123456789, 10, 1, 'The Odyssey', 'An epic poem by Homer', 22.99, '2022-10-01', 'https://covers.openlibrary.org/b/id/10792516-L.jpg', 1, 20);

INSERT INTO CUSTOMER (Cus_Id, Cus_FirstName, Cus_LastName, Cus_Email, Cus_Pass, Cus_Phone, Rol_Id)
VALUES
    (NEXT VALUE FOR SEQ_CUS_ID, 'John', 'Doe', 'johndoe@email.com', 'pass123', '555-555-5555', 1),
    (NEXT VALUE FOR SEQ_CUS_ID, 'Jane', 'Doe', 'janedoe@email.com', 'pass456', '555-555-5556', 1),
    (NEXT VALUE FOR SEQ_CUS_ID, 'Jim', 'Smith', 'jimsmith@email.com', 'pass789', '555-555-5557', 2);

INSERT INTO BOOK_GENRE (Boo_ISBN, Gen_Id)
VALUES
    ('9780910972321', 1),
    ('9788973062010', 2),
    ('3456789012', 3),
    ('4567890123', 4),
    ('5678901234', 5),
    ('6789012345', 1),
    ('7890123456', 7),
    ('8901234567', 3),
    ('9012345678', 9),
    ('123456789', 1);

INSERT INTO CUS_ORDER (Ord_Id, Cus_Id, ShM_Id, Ord_Date)
VALUES
  (NEXT VALUE FOR SEQ_ORD_ID, 1, 1, '2022-12-01 12:00:00'),
  (NEXT VALUE FOR SEQ_ORD_ID, 2, 2, '2022-12-02 14:00:00'),
  (NEXT VALUE FOR SEQ_ORD_ID, 3, 1, '2022-12-03 16:00:00'),
  (NEXT VALUE FOR SEQ_ORD_ID, 1, 2, '2022-12-04 18:00:00'),
  (NEXT VALUE FOR SEQ_ORD_ID, 2, 3, '2022-12-05 20:00:00');

INSERT INTO ORDER_HISTORY (OrS_Id, Ord_Id, OrH_Description, OrH_Date)
VALUES
    (1, 1, 'Order placed', '2022-11-01 10:00:00'),
    (2, 1, 'Order confirmed by seller', '2022-11-02 12:00:00'),
    (3, 1, 'Order shipped', '2022-11-03 14:00:00'),
    (4, 1, 'Order delivered', '2022-11-05 16:00:00'),
    (1, 2, 'Order placed', '2022-11-06 10:00:00'),
    (2, 2, 'Order confirmed by seller', '2022-11-07 12:00:00'),
    (3, 2, 'Order shipped', '2022-11-08 14:00:00'),
    (4, 2, 'Order delivered', '2022-11-09 16:00:00');

INSERT INTO BOOK_AUTHOR (Boo_ISBN, Aut_Id)
VALUES
  ('9780910972321', 1),
  ('9788973062010', 2),
  ('3456789012', 3),
  ('4567890123', 4),
  ('5678901234', 5),
  ('6789012345', 6),
  ('7890123456', 7),
  ('8901234567', 8),
  ('9012345678', 9),
  ('123456789', 10);

INSERT INTO ORDER_LINE (Boo_ISBN, Ord_Id, OrL_Quantity)
VALUES
  ('9780910972321', 1, 2),
  ('9788973062010', 2, 1),
  ('3456789012', 3, 5),
  ('4567890123', 4, 3),
  ('5678901234', 5, 2),
  ('6789012345', 1, 4),
  ('7890123456', 2, 1),
  ('8901234567', 3, 5),
  ('9012345678', 4, 3),
  ('123456789', 5, 2);

INSERT INTO ADDRESS (Cus_Id, Add_Id, Add_Street_Name, Add_Zip, Add_City, Cou_Alpha2Code)
VALUES
    (1, NEXT VALUE FOR SEQ_ADD_ID, '123 Main St', 12345, 'New York', 'US'),
    (2, NEXT VALUE FOR SEQ_ADD_ID, '456 Maple Ave', 98765, 'Toronto', 'CA'),
    (3, NEXT VALUE FOR SEQ_ADD_ID, '789 Elm St', 11111, 'Chicago', 'US');