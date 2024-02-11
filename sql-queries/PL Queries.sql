-- Procedure: ReduceBookQOH
-- Description: This procedure reduces the quantity on hand (QOH) of a book in the BOOK table.
-- Parameters:
--   @Boo_ISBN: The ISBN of the book.
--   @QuantitySold: The quantity of the book sold.
CREATE PROCEDURE ReduceBookQOH @Boo_ISBN VARCHAR(20),
                               @QuantitySold INT
AS
BEGIN
    -- Update the QOH of the book by subtracting the quantity sold from the current QOH.
    UPDATE BOOK
    SET Boo_QOH = Boo_QOH - @QuantitySold
    WHERE Boo_ISBN = @Boo_ISBN
END
-- Execute the procedure with a sample ISBN and quantity sold.
EXEC ReduceBookQOH @Boo_ISBN = '978-0439136358', @QuantitySold = 5;
-- Select the ISBN and QOH of the book to verify the update.
SELECT Boo_ISBN, Boo_QOH
FROM BOOK
WHERE Boo_ISBN = '978-0439136358';


-- Procedure: AddBook
-- Description: This procedure adds a new book to the BOOK table.
-- Parameters:
--   @Boo_ISBN: The ISBN of the book.
--   @Pub_ID: The ID of the publisher.
--   @BoL_ID: The ID of the book language.
--   @Boo_Title: The title of the book.
--   @Boo_Description: The description of the book.
--   @Boo_Price: The price of the book.
--   @Boo_Pub_Date: The publication date of the book.
--   @Boo_Img_Url: The URL of the book's image.
--   @Boo_Featured: Whether the book is featured or not.
--   @Boo_QOH: The quantity on hand of the book.
CREATE PROCEDURE AddBook @Boo_ISBN VARCHAR(20),
                         @Pub_ID INT,
                         @BoL_ID INT,
                         @Boo_Title VARCHAR(100),
                         @Boo_Description VARCHAR(500),
                         @Boo_Price DECIMAL(18, 2),
                         @Boo_Pub_Date DATE,
                         @Boo_Img_Url VARCHAR(100),
                         @Boo_Featured BIT,
                         @Boo_QOH INT
AS
BEGIN
    -- Insert a new book into the BOOK table with the provided parameters.
    INSERT INTO BOOK (Boo_ISBN, Pub_ID, BoL_ID, Boo_Title, Boo_Description, Boo_Price, Boo_Pub_Date, Boo_Img_Url,
                      Boo_Featured, Boo_QOH)
    VALUES (@Boo_ISBN, @Pub_ID, @BoL_ID, @Boo_Title, @Boo_Description, @Boo_Price, @Boo_Pub_Date, @Boo_Img_Url,
            @Boo_Featured, @Boo_QOH)
END
-- Execute the procedure with sample parameters.
EXEC AddBook @Boo_ISBN = 'B0001', @Pub_ID = 1, @BoL_ID = 1, @Boo_Title = 'The Hobbit',
     @Boo_Description = 'The Hobbit is a tale of high adventure, undertaken by a company of dwarves in search of dragon-guarded gold.',
     @Boo_Price = 19.99, @Boo_Pub_Date = '1937-09-21',
     @Boo_Img_Url = '#',
     @Boo_Featured = 1, @Boo_QOH = 10;


-- Procedure: UpdateBookPrice
-- Description: This procedure updates the price of a book in the BOOK table.
-- Parameters:
--   @Boo_ISBN: The ISBN of the book.
--   @NewPrice: The new price of the book.
CREATE PROCEDURE UpdateBookPrice @Boo_ISBN VARCHAR(20),
                                 @NewPrice DECIMAL(18, 2)
AS
BEGIN
    -- Update the price of the book with the provided new price.
    UPDATE BOOK
    SET Boo_Price = @NewPrice
    WHERE Boo_ISBN = @Boo_ISBN
END
-- Execute the procedure with a sample ISBN and new price.
EXEC UpdateBookPrice @Boo_ISBN = 'B0001', @NewPrice = 24.99;

-- Trigger: LogBookLanguageUpdate
-- Description: This trigger logs a message whenever a book language is updated in the BOOK_LANGUAGE table.
-- Trigger Event: AFTER UPDATE
CREATE TRIGGER LogBookLanguageUpdate
ON BOOK_LANGUAGE
AFTER UPDATE
AS
BEGIN
    DECLARE @BoL_ID VARCHAR(20), @OldLanguage VARCHAR(50), @NewLanguage VARCHAR(50);

    -- Get the ID and new language name from the updated record.
    SELECT @BoL_ID = INSERTED.BoL_ID, @NewLanguage = INSERTED.BoL_Name
    FROM INSERTED;

    -- Get the old language name from the record before it was updated.
    SELECT @OldLanguage = DELETED.BoL_Name
    FROM DELETED;

    -- If the language name has changed, print a message with the ID and both old and new names.
    IF (@OldLanguage <> @NewLanguage)
    BEGIN
        PRINT 'Book language with ID ' + @BoL_ID + ' was updated from ' + @OldLanguage + ' to ' + @NewLanguage;
    END
END;

-- Update the name of a book language to test the trigger.
UPDATE book_language
SET BoL_Name = 'Shqip'
WHERE BoL_ID = '1';

-- Table: audit_log
-- Description: This table stores log messages with a timestamp.
CREATE TABLE audit_log (
    log_id INT PRIMARY KEY IDENTITY(1,1), -- The ID of the log entry.
    log_message VARCHAR(255), -- The log message.
    log_timestamp DATETIME DEFAULT GETDATE() -- The timestamp of the log entry.
);

-- Trigger: LogNewBookAddition
-- Description: This trigger logs a message whenever a new book is added to the BOOK table.
-- Trigger Event: AFTER INSERT
CREATE TRIGGER LogNewBookAddition
ON BOOK
AFTER INSERT
AS
BEGIN
    DECLARE @Boo_ISBN VARCHAR(20), @Boo_Title VARCHAR(100);

    -- Get the ISBN and title of the new book.
    SELECT @Boo_ISBN = INSERTED.Boo_ISBN, @Boo_Title = INSERTED.Boo_Title
    FROM INSERTED;

    -- Insert a log message into the audit_log table.
    INSERT INTO audit_log (log_message)
    VALUES ('New book added: ISBN = ' + @Boo_ISBN + ', Title = ' + @Boo_Title);
END;

-- Insert a new book to test the trigger.
INSERT INTO book (Boo_ISBN, Pub_ID, BoL_ID, Boo_Title, Boo_Description, Boo_Price, Boo_Pub_Date, Boo_Img_Url, Boo_Featured, Boo_QOH)
VALUES ('B0004', '1', '1', 'Test Book 2', 'This is another test book.', 24.99, '2024-02-15', '#', 0, 75);

-- Select all records from the audit_log table to verify the log message.
SELECT * FROM audit_log;
