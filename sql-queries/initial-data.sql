INSERT INTO COUNTRY (Cou_Alpha2Code, Cou_Name)
VALUES ('US', 'United States'),
       ('CA', 'Canada'),
       ('GB', 'United Kingdom'),
       ('DE', 'Germany'),
       ('FR', 'France'),
       ('AU', 'Australia'),
       ('JP', 'Japa'),
       ('C', 'China'),
       ('I', 'India'),
       ('IT', 'Italy'),
       ('ES', 'Spai'),
       ('MX', 'Mexico'),
       ('BR', 'Brazil'),
       ('KR', 'South Korea'),
       ('RU', 'Russia'),
       ('ID', 'Indonesia'),
       ('AR', 'Argentina'),
       ('SA', 'Saudi Arabia'),
       ('PL', 'Poland'),
       ('ZA', 'South Africa'),
       ('IR', 'Ira'),
       ('EG', 'Egypt'),
       ('TR', 'Turkey'),
       ('TH', 'Thailand'),
       ('MY', 'Malaysia'),
       ('V', 'Vietnam'),
       ('PH', 'Philippines'),
       ('AL', 'Albania');

INSERT INTO BOOK_LANGUAGE (BoL_Id, BoL_Name)
VALUES (NEXT VALUE FOR SEQ_BOL_ID, 'English'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'French'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Germa'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Spanish'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Italia'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Russia'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Japanese'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Chinese'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Arabic'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Portuguese'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Korea'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Hindi'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Turkish'),
       (NEXT VALUE FOR SEQ_BOL_ID, 'Indonesia');

INSERT INTO ROLE (Rol_Id, Rol_Name)
VALUES (NEXT VALUE FOR SEQ_ROL_ID, 'Administrator'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Employee'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Customer'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Guest'),
       (NEXT VALUE FOR SEQ_ROL_ID, 'Moderator');

INSERT INTO PUBLISHER (Pub_Id, Pub_Name, Pub_Phone)
VALUES (NEXT VALUE FOR SEQ_PUB_ID, 'Penguin Random House', '212-366-2000'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Hachette Book Group', '212-364-1100'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Simon & Schuster', '212-698-7000'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'HarperCollins', '212-207-7000'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Macmillan Publishers', '646-307-5151'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Scholastic', '212-343-6100'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Little, Brown and Company', '617-532-3300'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Random House', '212-782-9000'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'St. Marti''s Press', '212-674-5151'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Workman Publishing', '212-614-7500'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Bloomsbury Publishing', '212-419-5300'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Oxford University Press', '212-743-3800'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'MIT Press', '617-253-5646'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Dover Publications', '973-328-3200'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Princeton University Press', '609-258-4900'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Routledge', '212-216-7800'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Yale University Press', '203-432-0900'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'University of California Press', '510-642-7295'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'University of Chicago Press', '773-702-7700'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'Columbia University Press', '212-459-0600'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'University of Texas Press', '512-471-3500'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'University of Pennsylvania Press', '215-898-6000'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'University of Minnesota Press', '612-627-1931'),
       (NEXT VALUE FOR SEQ_PUB_ID, 'University of Hawaii Press', '808-956-8255');

INSERT INTO GENRE (Gen_Id, Gen_Name)
VALUES (NEXT VALUE FOR SEQ_GEN_ID, 'Mystery'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Science Fictio'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Romance'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Horror'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Fantasy'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Drama'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Comedy'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Actio'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Thriller'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Adventure'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Historical Fictio'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Crime'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Wester'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Non-Fictio'),
       (NEXT VALUE FOR SEQ_GEN_ID, 'Science');

INSERT INTO AUTHOR (Aut_Id, Aut_Name, Aut_Bio)
VALUES (NEXT VALUE FOR SEQ_AUT_ID, 'J.K. Rowling', 'British author and philanthropist'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Stephen King',
        'American author of horror, supernatural fiction, suspense, science fiction, and fantasy'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Agatha Christie', 'British crime novelist, short-story writer, and playwright'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'George Orwell', 'British novelist, essayist, journalist, and critic'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'H.G. Wells',
        'English writer in various genres, including the novel, history, politics, and social commentary'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Jane Auste', 'English novelist known primarily for her six major novels'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Mark Twai', 'American writer and humorist'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Leo Tolstoy',
        'Russian writer who is regarded as one of the greatest authors of all time'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'F. Scott Fitzgerald',
        'American writer, widely regarded as one of the greatest American writers of the 20th century'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Ernest Hemingway',
        'American journalist, novelist, short-story writer, and noted sportsma'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'J.R.R. Tolkie', 'English writer, poet, philologist, and academic'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'John Steinbeck',
        'American author and winner of the 1962 Nobel Prize in Literature'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Nora Roberts', 'American author of romance novels'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Dan Brow',
        'American author best known for his thriller novels, including The Da Vinci Code'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Michael Crichto',
        'American best-selling author, producer, director, and screenwriter'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Veronica Roth', 'American novelist and short-story writer'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Suzanne Collins',
        'American television writer and novelist, best known as the author of The Hunger Games trilogy'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'R.L. Stine', 'American author and editor, best known for his Goosebumps series'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Margaret Atwood',
        'Canadian poet, novelist, literary critic, essayist, and environmental activist'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'Neil Gaima',
        'English author of short fiction, novels, comic books, graphic novels, audio theatre, and films'),
       (NEXT VALUE FOR SEQ_AUT_ID, 'David Baldacci', 'American author of novels for adults and childre');


INSERT INTO SHIPPING_METHOD (ShM_Id, ShM_Name, ShM_Price)
VALUES (NEXT VALUE FOR SEQ_SHM_ID, 'Standard', 5.99),
       (NEXT VALUE FOR SEQ_SHM_ID, 'Expedited', 9.99),
       (NEXT VALUE FOR SEQ_SHM_ID, 'Overnight', 19.99);

INSERT INTO ORDER_STATUS (OrS_Id, OrS_Name)
VALUES (NEXT VALUE FOR SEQ_ORS_ID, 'Pending'),
       (NEXT VALUE FOR SEQ_ORS_ID, 'Shipped'),
       (NEXT VALUE FOR SEQ_ORS_ID, 'Delivered'),
       (NEXT VALUE FOR SEQ_ORS_ID, 'Cancelled'),
       (NEXT VALUE FOR SEQ_ORS_ID, 'Returned');

INSERT INTO EMPLOYEE (Emp_Id, Emp_FirstName, Emp_LastName, Emp_Email, Emp_Pass, Emp_Phone, Rol_Id)
VALUES (NEXT VALUE FOR SEQ_EMP_ID, 'Joh', 'Doe', 'johndoe@email.com',
        '$2y$10$hHQ5JfkN916fVwc/ImJyOu6oz.oNLE05UnT1t.2aFsV7pjTga1aba', '555-555-1212', 2);

INSERT INTO CUSTOMER (Cus_Id, Cus_FirstName, Cus_LastName, Cus_Email, Cus_Pass, Cus_Phone, Rol_Id, Cus_Reg_Date)
VALUES (NEXT VALUE FOR SEQ_CUS_ID, 'Joh', 'Doe', 'johndoe@email.com',
        '$2y$10$hHQ5JfkN916fVwc/ImJyOu6oz.oNLE05UnT1t.2aFsV7pjTga1aba', '555-555-5555', 1, '2022-12-01 12:00:00'),
       (NEXT VALUE FOR SEQ_CUS_ID, 'Jane', 'Doe', 'janedoe@email.com',
        '$2y$10$hHQ5JfkN916fVwc/ImJyOu6oz.oNLE05UnT1t.2aFsV7pjTga1aba', '555-555-5556', 1, '2022-11-01 12:00:00'),
       (NEXT VALUE FOR SEQ_CUS_ID, 'Jim', 'Smith', 'jimsmith@email.com',
        '$2y$10$hHQ5JfkN916fVwc/ImJyOu6oz.oNLE05UnT1t.2aFsV7pjTga1aba', '555-555-5557', 2,
        '2022-11-01 12:00:00');

INSERT INTO ADDRESS (Cus_Id, Add_Id, Add_Street_Name, Add_Zip, Add_City, Cou_Alpha2Code)
VALUES (1, NEXT VALUE FOR SEQ_ADD_ID, '123 Main St', 12345, 'New York', 'US'),
       (2, NEXT VALUE FOR SEQ_ADD_ID, '456 Maple Ave', 98765, 'Toronto', 'CA'),
       (3, NEXT VALUE FOR SEQ_ADD_ID, '789 Elm St', 11111, 'Chicago', 'US');

INSERT INTO BOOK (Boo_ISBN, Pub_Id, BoL_Id, Boo_Title, Boo_Description, Boo_Price, Boo_Pub_Date, Boo_Img_url,
                  Boo_Featured, Boo_QOH)
VALUES ('978-0439136358', 6, 1, 'Harry Potter and the Prisoner of Azkaba',
        'Harry Potter, along with his best friends, Ron and Hermione, is about to start his third year at Hogwarts School of Witchcraft and Wizardry. Harry can&#39;t wait to get back to school after the summer holidays. (Who wouldn&#39;t if they lived with the horrible Dursleys?) But when Harry gets to Hogwarts, the atmosphere is tense. There&#39;s an escaped mass murderer on the loose, and the sinister prison guards of Azkaban have been called in to guard the school...',
        14.6, '2004-04-01',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1630547330i/5.jpg', 0,
        34),
       ('978-0439554930', 11, 1, 'Harry Potter and the Philosophers Stone',
        'Harry Potter thinks he is an ordinary boy - until he is rescued by an owl, taken to Hogwarts School of Witchcraft and Wizardry, learns to play Quidditch and does battle in a deadly duel. The Reason ... HARRY POTTER IS A WIZARD!',
        14.99, '1997-08-30',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1170803558l/72193.jpg',
        1, 15),
       ('978-0547928210', 10, 1, 'The Fellowship of the Ring',
        'In ancient times the Rings of Power were crafted by the Elven-smiths, and Sauron, the Dark Lord, forged the One Ring, filling it with his own power so that he could rule all others. But the One Ring was taken from him, and though he sought it throughout Middle-earth, it remained lost to him. After many ages it fell into the hands of Bilbo Baggins, as told in The Hobbit.',
        18, '2022-08-01',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1654215925i/61215351.jpg',
        1, 69),
       ('978-0618260300', 4, 1, 'The Hobbit',
        'In a hole in the ground there lived a hobbit. Not a nasty, dirty, wet hole, filled with the ends of worms and an oozy smell, nor yet a dry, bare, sandy hole with nothing in it to sit down on or to eat: it was a hobbit-hole, and that means comfort. Written for J.R.R. Tolkiens own children, The Hobbit met with instant critical acclaim when it was first published in 1937. Now recognized as a timeless classic, this introduction to the hobbit Bilbo Baggins, the wizard Gandalf, Gollum, and the spectacular world of Middle-earth recounts of the adventures of a reluctant hero, a powerful and dangerous ring, and the cruel dragon Smaug the Magnificent. The text in this 372-page paperback edition is based on that first published in Great Britain by Collins Modern Classics (1998), and includes a note on the text by Douglas A. Anderson (2001).',
        16, '2002-08-15',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546071216i/5907.jpg', 1,
        25),
       ('978-1408865408', 11, 1, 'Harry Potter and the Chamber of Secrets',
        'Ever since Harry Potter had come home for the summer, the Dursleys had been so mean and hideous that all Harry wanted was to get back to the Hogwarts School for Witchcraft and Wizardry. But just as hes packing his bags, Harry receives a warning from a strange impish creature who says that if Harry returns to Hogwarts, disaster will strike.',
        15.6, '1999-06-02',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1474169725i/15881.jpg',
        0, 32),
       ('9780142437179', 1, 1, 'The Adventures of Huckleberry Fi',
        'A nineteenth-century boy from a Mississippi River town recounts his adventures as he travels down the river with a runaway slave, encountering a family involved in a feud, two scoundrels pretending to be royalty, and Tom Sawyer&#39;s aunt who mistakes him for Tom.',
        14.2, '2002-12-31',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546096879i/2956.jpg', 1,
        654),
       ('9780143039563', 1, 1, 'The Adventures of Tom Sawyer',
        'The Adventures of Tom Sawyer revolves around the youthful adventures of the novel&#39;s schoolboy protagonist, Thomas Sawyer, whose reputation precedes him for causing mischief and strife. Tom lives with his Aunt Polly, half-brother Sid, and cousin Mary in the quaint town of St. Petersburg, just off the shore of the Mississippi River. St. Petersburg is described as a typical small-town atmosphere where the Christian faith is predominant, the social network is close-knit, and familiarity resides.',
        10, '2006-02-28',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1404811979i/24583.jpg',
        1, 78),
       ('9780307277671', 5, 1, 'The Da Vinci Code',
        'While in Paris, Harvard symbologist Robert Langdon is awakened by a phone call in the dead of the night. The elderly curator of the Louvre has been murdered inside the museum, his body covered in baffling symbols. As Langdon and gifted French cryptologist Sophie Neveu sort through the bizarre riddles, they are stunned to discover a trail of clues hidden in the works of Leonardo da Vinciclues visible for all to see and yet ingeniously disguised by the painter.',
        18, '2006-03-28',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1579621267i/968.jpg', 1,
        54),
       ('9780450040184', 14, 1, 'The Shining',
        'Jack Torrance&#39;s new job at the Overlook Hotel is the perfect chance for a fresh start. As the off-season caretaker at the atmospheric old hotel, he&#39;ll have plenty of time to spend reconnecting with his family and working on his writing. But as the harsh winter weather sets in, the idyllic location feels ever more remote...and more sinister. And the only one to notice the strange and terrible forces gathering around the Overlook is Danny Torrance, a uniquely gifted five-year-old.',
        13.6, '1980-06-01',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1353277730i/11588.jpg',
        0, 852),
       ('9780452284234', 14, 1, '1984',
        'The new novel by George Orwell is the major work towards which all his previous writing has pointed. Critics have hailed it as his &#34;most solid, most brilliant&#34; work. Though the story of Nineteen Eighty-Four takes place thirty-five years hence, it is in every sense timely. The scene is London, where there has been no new housing since 1950 and where the city-wide slums are called Victory Mansions. Science has abandoned Man for the State. As every citizen knows only too well, war is peace.',
        18.2, '2022-01-07',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1657781256i/61439040.jpg',
        0, 63),
       ('9780679783268', 5, 1, 'Pride and Prejudice',
        'Since its immediate success in 1813, Pride and Prejudice has remained one of the most popular novels in the English language. Jane Austen called this brilliant work &#34;her own darling child&#34; and its vivacious heroine, Elizabeth Bennet, &#34;as delightful a creature as ever appeared in print.&#34; The romantic clash between the opinionated Elizabeth and her proud beau, Mr. Darcy, is a splendid performance of civilized sparring. And Jane Austen&#39;s radiant wit sparkles as her characters dance a delicate quadrille of flirtation and intrigue, making this books the most superb comedy of manners of Regency England.',
        13, '2000-10-10',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1320399351i/1885.jpg', 0,
        54),
       ('9780684830490', 3, 1, 'The Old Man and the Sea',
        'This short novel, already a modern classic, is the superbly told, tragic story of a Cuban fisherman in the Gulf Stream and the giant Marlin he kills and losesspecifically referred to in the citation accompanying the author&#39;s Nobel Prize for literature in 1954.',
        11.3, '1996-01-01',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1329189714i/2165.jpg', 0,
        2),
       ('9781416524793', 14, 1, 'Angels & Demons',
        'World-renowned Harvard symbologist Robert Langdon is summoned to a Swiss research facility to analyze a cryptic symbol seared into the chest of a murdered physicist. What he discovers is unimaginable: a deadly vendetta against the Catholic Church by a centuries-old underground organization -- the Illuminati. In a desperate race to save the Vatican from a powerful time bomb, Langdon joins forces in Rome with the beautiful and mysterious scientist Vittoria Vetra. Together they embark on a frantic hunt through sealed crypts, dangerous catacombs, and deserted cathedrals, and into the depths of the most secretive vault on earth...the long-forgotten Illuminati lair.',
        16, '2006-04-01',
        'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1639587647i/960.jpg', 1,
        43);

INSERT INTO BOOK_AUTHOR (Boo_ISBN, Aut_Id)
VALUES ('978-0439136358', 1),
       ('978-0439554930', 1),
       ('978-0547928210', 11),
       ('978-0618260300', 11),
       ('978-1408865408', 1),
       ('9780142437179', 7),
       ('9780143039563', 7),
       ('9780307277671', 14),
       ('9780450040184', 2),
       ('9780452284234', 4),
       ('9780679783268', 6),
       ('9780684830490', 10),
       ('9781416524793', 14);

INSERT INTO BOOK_GENRE (Boo_ISBN, Gen_Id)
VALUES ('978-0439136358', 5),
       ('978-0439554930', 5),
       ('978-0547928210', 5),
       ('978-0618260300', 5),
       ('978-1408865408', 5),
       ('9780142437179', 11),
       ('9780143039563', 11),
       ('9780307277671', 1),
       ('9780450040184', 4),
       ('9780452284234', 2),
       ('9780679783268', 3),
       ('9780684830490', 11),
       ('9781416524793', 1);

INSERT INTO CUS_ORDER (Ord_Id, Cus_Id, ShM_Id, Ord_Date, Ord_Tot_Val)
VALUES  (NEXT VALUE FOR SEQ_ORD_ID, 1, 1, '2023-02-01 22:33:12.000', 52),
        (NEXT VALUE FOR SEQ_ORD_ID, 1, 3, '2022-08-05 22:33:47.000', 37.2),
        (NEXT VALUE FOR SEQ_ORD_ID, 2, 3, '2022-08-09 22:34:52.000', 29.59),
        (NEXT VALUE FOR SEQ_ORD_ID, 2, 2, '2022-08-24 22:35:13.000', 47.6),
        (NEXT VALUE FOR SEQ_ORD_ID, 2, 3, '2022-10-01 22:35:35.000', 54),
        (NEXT VALUE FOR SEQ_ORD_ID, 3, 1, '2022-10-02 22:37:49.000', 24.2),
        (NEXT VALUE FOR SEQ_ORD_ID, 3, 3, '2022-11-05 22:38:04.000', 13),
        (NEXT VALUE FOR SEQ_ORD_ID, 3, 3, '2023-01-02 22:38:46.000', 18),
        (NEXT VALUE FOR SEQ_ORD_ID, 3, 3, '2023-01-03 22:38:46.000', 14.99);

INSERT INTO ORDER_HISTORY (OrS_Id, Ord_Id, OrH_Description, OrH_Date)
VALUES  (1, 1, 'Order placed', '2023-02-01 22:33:12.000'),
        (1, 2, 'Order placed', '2022-08-05 22:33:47.000'),
        (1, 3, 'Order placed', '2022-08-09 22:34:52.000'),
        (1, 4, 'Order placed', '2022-08-24 22:35:13.000'),
        (1, 5, 'Order placed', '2022-10-01 22:35:35.000'),
        (1, 6, 'Order placed', '2022-10-02 22:37:49.000'),
        (1, 7, 'Order placed', '2022-11-05 22:38:04.000'),
        (1, 8, 'Order placed', '2023-01-02 22:38:46.000'),
        (1, 9, 'Order placed', '2023-01-03 22:38:46.000');

INSERT INTO ORDER_LINE (Boo_ISBN, Ord_Id, OrL_Quantity, OrL_Tot_Price, OrL_Price)
VALUES  ('978-0439136358', 3, 1, 14.6, 14.6),
        ('978-0439554930', 3, 1, 14.99, 14.99),
        ('978-0439554930', 9, 1, 14.99, 14.99),
        ('978-0547928210', 1, 2, 36, 18),
        ('978-0547928210', 8, 1, 18, 18),
        ('978-0618260300', 1, 1, 16, 16),
        ('9780142437179', 2, 1, 14.2, 14.2),
        ('9780142437179', 6, 1, 14.2, 14.2),
        ('9780143039563', 2, 1, 10, 10),
        ('9780143039563', 6, 1, 10, 10),
        ('9780307277671', 4, 1, 18, 18),
        ('9780307277671', 5, 3, 54, 18),
        ('9780450040184', 4, 1, 13.6, 13.6),
        ('9780679783268', 2, 1, 13, 13),
        ('9780679783268', 7, 1, 13, 13),
        ('9781416524793', 4, 1, 16, 16);