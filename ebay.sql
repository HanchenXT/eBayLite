-- CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS hanchenxt@localhost IDENTIFIED BY '1988114Ha';

DROP DATABASE IF EXISTS `eBayLite`; 
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS eBayLite 
    DEFAULT CHARACTER SET utf8mb4 
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE eBayLite;

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'hanchenxt'@'localhost';
GRANT ALL PRIVILEGES ON `hanchenxt`.* TO 'hanchenxt'@'localhost';
GRANT ALL PRIVILEGES ON `eBayLite`.* TO 'hanchenxt'@'localhost';
FLUSH PRIVILEGES;

-- Tables 

CREATE TABLE `User` (
  userID int(32) unsigned NOT NULL AUTO_INCREMENT,
  user_name varchar(100) NOT NULL,
  password varchar(60) NOT NULL,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  PRIMARY KEY (userID), 
  UNIQUE KEY (user_name)
);

CREATE TABLE AdminUser (
  userID int(32) unsigned NOT NULL AUTO_INCREMENT,
  position varchar(100) NOT NULL,
  PRIMARY KEY (userID)  
);

CREATE TABLE Comments (
  commentID int(32) unsigned NOT NULL AUTO_INCREMENT,
  userID int(32) unsigned NOT NULL,
  itemID int(32) unsigned NOT NULL,
  comment_date datetime NOT NULL,
  content varchar(1000) NULL,
  rate decimal(2, 1) ,
  PRIMARY KEY (commentID)
);

CREATE TABLE Bid (
  bidID int(32) unsigned NOT NULL AUTO_INCREMENT,
  userID int(32) unsigned NOT NULL,
  itemID int(32) unsigned NOT NULL,
  bid_date datetime NOT NULL,
  bid_amount decimal(10, 2) NOT NULL,
  PRIMARY KEY (bidID)
);
-- I changed Category to be flexible -- Zongran Luo
CREATE TABLE Category (
  categoryID int(32) unsigned NOT NULL AUTO_INCREMENT,
  category_name varchar(100) NOT NULL,
  PRIMARY KEY (categoryID),
  UNIQUE KEY category_name (category_name)
);
INSERT INTO Category (category_name) VALUES('Art');
INSERT INTO Category (category_name) VALUES('Books');
INSERT INTO Category (category_name) VALUES('Electronics');
INSERT INTO Category (category_name) VALUES('Home & Garden');
INSERT INTO Category (category_name) VALUES('Sporting Goods');
INSERT INTO Category (category_name) VALUES('Toys');
INSERT INTO Category (category_name) VALUES('Other');


CREATE TABLE Items (
  itemID int(32) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  description varchar(1000) NOT NULL,
  min_sale_price decimal(10, 2) NOT NULL,
  get_it_now_price decimal(10, 2) NOT NULL,
  buy_availability ENUM('0', '1') NOT NULL,
  categoryID int(32) unsigned NOT NULL,
  `condition` ENUM('New', 'Very Good', 'Good', 'Fair', 'Poor') NULL,
  start_bidding decimal(10, 2) NOT NULL,
  return_accepted bit NOT NULL DEFAULT 0,
  end_time datetime NOT NULL,
  PRIMARY KEY (itemID)
);

CREATE TABLE SoldBy (
  itemID int(32) unsigned NOT NULL AUTO_INCREMENT,
  userID int(16) unsigned NOT NULL,
  PRIMARY KEY (itemID)
);

CREATE TABLE Transaction(
  itemID int(32) unsigned NOT NULL AUTO_INCREMENT,	
  userID int(16) unsigned NOT NULL,
  type ENUM('Bid', 'Get It Now') NOT NULL,
  price decimal(10, 2) NOT NULL,
  PRIMARY KEY (itemID)
);

-- Constraints   Foreign Keys: FK_ChildTable_childColumn_ParentTable_parentColumn

ALTER TABLE AdminUser
  ADD CONSTRAINT fk_AdminUser_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID);
  
ALTER TABLE Comments
  ADD CONSTRAINT fk_Comments_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID),
  ADD CONSTRAINT chk_Ratings CHECK (rate >= 0 AND rate <= 5),
  ADD CONSTRAINT fk_Comments_itemID_Items_itemID FOREIGN KEY (itemID) REFERENCES Items (itemID);

ALTER TABLE Bid
  ADD CONSTRAINT fk_Bid_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID),
  ADD CONSTRAINT fk_Bid_itemID_Items_itemID FOREIGN KEY (itemID) REFERENCES Items (itemID);

ALTER TABLE Items
  ADD CONSTRAINT fk_Items_categoryID_Category_categoryID FOREIGN KEY (categoryID) REFERENCES Category (categoryID);

ALTER TABLE SoldBy
  ADD CONSTRAINT fk_SoldBy_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID),
  ADD CONSTRAINT fk_SoldBy_itemID_Items_itemID FOREIGN KEY (itemID) REFERENCES Items (itemID);

ALTER TABLE Transaction
  ADD CONSTRAINT fk_Transaction_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID),
  ADD CONSTRAINT fk_Transaction_itemID_Items_itemID FOREIGN KEY (itemID) REFERENCES Items (itemID);
  
  
  -- Demo Data
  
  -- Item
  INSERT INTO `items` (`itemID`, `name`, `description`, `min_sale_price`, `get_it_now_price`, `buy_availability`, `categoryID`, `condition`, `start_bidding`, `return_accepted`, `end_time`) VALUES (NULL, 'Garmin GPS', 'A Device takes you anywhere you can go', '50', '75', '1', '3', 'Fair', '25', b'0', '2018-04-23 03:15:00'), (NULL, 'Macbook Pro', 'A nice laptop', '1500', NULL, '1', '3', 'Very Good', '1000', b'0', '2018-04-23 01:01:00'), (NULL, 'Microsoft Surface', 'A powerful combination of laptop and tablet', '750', '899', '1', '3', 'Good', '750', b'0', '2018-04-23 06:00:00');
  
  -- Users
  INSERT INTO `user` (`userID`, `user_name`, `password`, `first_name`, `last_name`) VALUES (NULL, 'User1', '123', 'Jack', 'Lee'), (NULL, 'User2', '123', 'Jason', 'chen'), (NULL, 'User3', '123', 'Andy', 'Orr'), (NULL, 'User4', '123', 'Ellie', 'Angell'), (NULL, 'User5', '123', 'Tony', 'Stark'), (NULL, 'User6', '123', 'John', 'Rolf'), (NULL, 'Admin1', '123', 'Tracy', 'Jane'), (NULL, 'Admin2', '123', 'Kevin', 'Smith');
  
  -- Admin User
  INSERT INTO `AdminUser` (`userID`, position) VALUES ('7', 'admin'), ('8', 'admin');
  
  -- Sold by
  INSERT INTO `SoldBy` (`itemID`, userID) VALUES (1, 8), (2, 4), (3, 5);
  
  -- Comments
  INSERT INTO `comments` (`commentID`, `userID`, `itemID`, `comment_date`, `content`, `rate`) VALUES (NULL, '5', '2', '2018-04-18 06:00:00', 'Great for getting OMSCS coursework done', '5'), (NULL, '4', '3', '2018-04-19 19:45:30', 'Looks nice but underpowered', '2'), (NULL, '3', '3', '2018-04-20 10:07:05', NULL, '2');
  
  -- Bids
  INSERT INTO `bid` (`bidID`, `userID`, `itemID`, `bid_date`, `bid_amount`) VALUES (NULL, '4', '1', '2018-04-16 04:01:05', '30'), (NULL, '5', '1', '2018-04-16 08:27:25', '31'), (NULL, '3', '1', '2018-04-17 10:50:00', '33'), (NULL, '4', '1', '2018-04-18 18:17:48', '40'), (NULL, '6', '1', '2018-04-20 15:33:56', '45');