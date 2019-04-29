CREATE DATABASE IF NOT EXISTS ContactsDb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ContactsDb;

CREATE TABLE Contacts(
	ContactID INT NOT NULL AUTO_INCREMENT,
	FirstName varchar(255) NOT NULL,
	LastName varchar(255) NOT NULL,
	Title varchar(255),
	Gender int NOT NULL DEFAULT 0,
	Phone varchar(20),
	MobilePhone varchar(20),
	Email varchar(255),
	Address varchar(255),
	PostalCode varchar(20),
	Dob varchar(50),
	Comments varchar(2000),
	PRIMARY KEY(ContactID)
);

CREATE TABLE Users(
	UserID INT NOT NULL AUTO_INCREMENT,
	UserName varchar(50) NOT NULL,
	Password varchar(255) NOT NULL,
	UserRole varchar(255),
	SessionID varchar(255),
	PRIMARY KEY(UserID)
);