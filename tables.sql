CREATE TABLE users(
	username varchar(30) PRIMARY KEY,
    password varchar(30) NOT NULL,
    firstname varchar(30) NOT NULL,
    surname varchar(30) NOT NULL,
    addressLine1 varchar(50) NOT NULL,
    addressLine2 varchar(50) NOT NULL,
    city varchar(20) NOT NULL,
    mobile varchar(10) NOT NULL
);

CREATE TABLE categories(
    categoryID varchar(10) PRIMARY KEY,
    categoryDescription varchar(30)
);

CREATE TABLE books(
	ISBN varchar(20) PRIMARY KEY,
    title varchar(50) NOT NULL,
    author varchar(30) NOT NULL,
    edition int NOT NULL,
    year YEAR NOT NULL,
    categoryID varchar(10),
    FOREIGN KEY (categoryID) REFERENCES categories(categoryID),
    reserved varchar(1) NOT NULL
);

CREATE TABLE reserved(
    ISBN varchar(20) PRIMARY KEY,
    username varchar(30),
    reservedDate varchar(15)
);

INSERT INTO books VALUES
('093-403992', 'Computers in Business', 'Alicia Oneill', 3, 1997, 3, 'N'),
('23472-8729', 'Exploring Peru', 'Stephanie Birchin', 4, 2005, 5, 'N'),
('237-34823', 'Business Strategy', 'Joe Peppard', 2, 2002, 2, 'N'),
('23u8-923849', 'A guide to nutrition', 'John Thorpe', 2, 1997, 1, 'N'),
('82n8-308', 'computers for idiots', 'Susan O\'Neill', 5, 1998, 4, 'N'),
('2983-3494', 'Cooking for children', 'Anabelle Sharper', 1, 2003, 7, 'N'),
('9823-23984', 'My life in picture', 'Kevin Graham', 8, 2004, 1, 'N'),
('9823-2403-0', 'Davinvi Code', 'Dan Brown', 1, 2003, 8, 'N'),
('98234-029384', 'My rand in Texas', 'George Bush', 1, 2005, 1, 'N'),
('9823-98345', 'How to cook Italian food', 'Jamie Oliver', 2, 2005, 7, 'N'),
('9823-98487', 'Optimising your business', 'Cleo Blair', 1, 2001, 2, 'N'),
('988745-234', 'Tara Toad', 'Maeve Binchy', 4, 2002, 8, 'N'),
('993-004-00', 'My life in bits', 'John Smith', 1, 2001, 1, 'N'),
('9987-0039882', 'Shooting History', 'Jon Snow', 1, 2003, 1, 'N');

INSERT INTO categories VALUES
('001', 'Health'),
('002', 'Business'),
('003', 'Biography'),
('004', 'Technology'),
('005', 'Travel'),
('006', 'Self-Help'),
('007', 'Cookery'),
('008', 'Fiction');
