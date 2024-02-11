# The Bookshelf Database Project

This project is part of a school assignment designed to develop and demonstrate database design and management skills. It encompasses a comprehensive database system named "The Bookshelf," tailored to manage and facilitate bookstore operations and user interactions efficiently.

## Project Overview

The Bookshelf Database system is engineered to cater to the diverse requirements of its users through a multitude of functionalities:

### Key Features
- User Registration and Authentication: Users can create personal accounts, enabling them to sign into the platform to access various features, such as ordering books, tracking orders, and updating account details.
- Exploring Books: The platform offers an extensive browsing experience, allowing users to navigate the book inventory by author, publisher, genre, language, or keywords.
- Detailed Book Insights: Users can view comprehensive information about each book, including cover images, titles, authors, publication details, pricing, and descriptions.
- Placing Orders: Users can add books to their cart, choose shipping options, and provide billing and shipping information to complete their purchases.
- Tracking Order History: The system maintains a record of past orders, enabling users to review their purchase history and monitor current order statuses.
- Account Management: Users can manage their profile information, such as name, email, and contact details, ensuring their information is up-to-date.
- Administrative Oversight: Administrators have control over the platform, managing the book catalog, shipping options, user accounts, orders, and employee roles and permissions.


### Business Rules
- Books can have multiple authors; authors can write multiple books.
- Books can belong to multiple genres; genres can encompass multiple books.
- Each book is associated with one language, but a language can be associated with multiple books.
- Publishers can publish multiple books, but each book is published by only one publisher.
- Customers have a unique address; each address belongs to one customer.
- Customers can place multiple orders; each order is placed by one customer.
- An order comprises multiple order lines; each order line is associated with one order.
- Orders can have various statuses; each status can be applied to multiple orders.
- Each order is assigned one shipping method; a shipping method can be applied to multiple orders.
- Order lines are associated with a specific book; books can be part of multiple order lines.
- Employees can have various roles within the organization.

### Technologies Used

- Microsoft SQL Server: Used for data storage and management.
- Microsoft SQL Server Management Studio 19 (SSMS): Provides an interface for database administration and development.
- PHP: Utilized for server-side scripting to generate dynamic web content.
- HTML: Structures the web page layouts and content.
- JavaScript: Enhances web page interactivity and user experience.
- CSS: Styles the web pages for a visually appealing interface.

## Entity Relationship Design

### Entity-Relationship Diagram
[![Crow's Foot ERD](/screenshots/Crows-Foot-ERD.png)]("Crow's Foot ERD")

### Database Entities
- BOOK: Represents a book with attributes like ISBN, title, price, and publication date.
- CUSTOMER: Represents a customer with attributes like ID, name, and contact information.
- PUBLISHER, GENRE, AUTHOR: Represent the publishing entities, literary genres, and authors, respectively, each with unique identifiers and descriptive attributes.
- BOOK_GENRE, BOOK_LANGUAGE: Represent the relationships between books and their genres and languages.
- SHIPPING_METHOD, ORDER_STATUS: Represent the logistics and status aspects of book orders.
- CUS_ORDER, ORDER_LINE: Represent the orders placed by customers and the details of each order line.
- ADDRESS, COUNTRY: Represent the geographical information associated with customers and publishers.
- EMPLOYEE, MANAGER, SALES_PERSON: Represent the staff involved in bookstore operations, including their roles and responsibilities.

### Entity Relationships
Outlined in the project are various relationships between entities, such as one-to-many, many-to-many, and one-to-one relationships, illustrating the complex interconnections within the bookstore's operations.

### Project Files
The project includes a set of files encompassing the database design documents, SQL scripts for database creation, table definitions, stored procedures, triggers, and sample queries. These files collectively demonstrate the application of database design principles, SQL programming, and data management practices tailored to the requirements of The Bookshelf project.

### Web Application
The project also includes a web application prototype, designed to showcase the database's functionalities and user interactions. The web application is built using HTML, CSS, JavaScript, and PHP, providing a user-friendly interface for browsing books, placing orders, and managing user accounts.

Browse Books
[![Browse Books](/screenshots/browse-books.png)]("Browse Books")

Admin Dashboard
[![Admin Dashboard](/screenshots/admin-dash.png)]("Admin Dashboard")