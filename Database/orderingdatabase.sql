-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2019 at 01:16 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orderingdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `cakecustomizedinfo`
--

DROP TABLE IF EXISTS `cakecustomizedinfo`;
CREATE TABLE IF NOT EXISTS `cakecustomizedinfo` (
  `customId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(100) NOT NULL,
  `productId` int(11) NOT NULL,
  `decorationId` int(11) NOT NULL,
  `layerNumber` int(11) NOT NULL COMMENT 'if decoration id is equal to 16 only',
  `flavorId` int(11) NOT NULL,
  `price` double(11,2) NOT NULL,
  `batchNumber` varchar(1000) NOT NULL,
  `dateCreated` date NOT NULL,
  `customStatus` int(11) NOT NULL COMMENT '0 - Not Finished; 1 - Finished;',
  PRIMARY KEY (`customId`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cakedecorationdetails`
--

DROP TABLE IF EXISTS `cakedecorationdetails`;
CREATE TABLE IF NOT EXISTS `cakedecorationdetails` (
  `decorationId` int(11) NOT NULL AUTO_INCREMENT,
  `decorationCode` varchar(1000) NOT NULL,
  `decorationPrice` double(11,2) NOT NULL,
  `decorationImage` varchar(100) NOT NULL,
  `decorationType` varchar(100) NOT NULL,
  `availability` int(11) NOT NULL COMMENT '0 - Available; 1 - Not Available;',
  PRIMARY KEY (`decorationId`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cakedecorationdetails`
--

INSERT INTO `cakedecorationdetails` (`decorationId`, `decorationCode`, `decorationPrice`, `decorationImage`, `decorationType`, `availability`) VALUES
(1, 'candle1', 20.00, 'candle1.png', 'Candles', 0),
(2, 'candle2', 20.00, 'candle2.png', 'Candles', 0),
(3, 'candle3', 20.00, 'candle3.png', 'Candles', 0),
(4, 'cherry', 40.00, 'cherry.png', 'Fruits', 0),
(5, 'cream1', 40.00, 'cream1.png', 'Creams', 0),
(6, 'eight', 30.00, 'eight.png', 'Numbers', 0),
(7, 'five', 30.00, 'five.png', 'Numbers', 0),
(8, 'flower1', 25.00, 'flower1.png', 'Flowers', 0),
(9, 'flower2', 25.00, 'flower2.png', 'Flowers', 0),
(10, 'flower3', 25.00, 'flower3.png', 'Flowers', 0),
(11, 'flower4', 25.00, 'flower4.png', 'Flowers', 0),
(12, 'flower5', 25.00, 'flower5.png', 'Flowers', 0),
(13, 'flower6', 25.00, 'flower6.png', 'Flowers', 0),
(14, 'flower7', 25.00, 'flower7.png', 'Flowers', 0),
(15, 'four', 30.00, 'four.png', 'Numbers', 0),
(16, 'layer', 1500.00, 'layer.png', 'Layers', 0),
(17, 'nine', 30.00, 'nine.png', 'Numbers', 0),
(18, 'one', 30.00, 'one.png', 'Numbers', 0),
(19, 'ribbon', 15.00, 'ribbon.png', 'Ribbons', 0),
(20, 'ribbon2', 15.00, 'ribbon2.png', 'Ribbons', 0),
(21, 'ribbon3', 15.00, 'ribbon3.png', 'Ribbons', 0),
(22, 'ribbon4', 15.00, 'ribbon4.png', 'Ribbons', 0),
(23, 'ribbon5', 15.00, 'ribbon5.png', 'Ribbons', 0),
(24, 'ribbon6', 15.00, 'ribbon6.png', 'Ribbons', 0),
(25, 'seven', 30.00, 'seven.png', 'Numbers', 0),
(26, 'six', 30.00, 'six.png', 'Numbers', 0),
(27, 'strawberry', 40.00, 'strawberry.png', 'Fruits', 0),
(28, 'three', 30.00, 'three.png', 'Numbers', 0),
(29, 'two', 30.00, 'two.png', 'Numbers', 0),
(30, 'zero', 30.00, 'zero.png', 'Numbers', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cakeflavors`
--

DROP TABLE IF EXISTS `cakeflavors`;
CREATE TABLE IF NOT EXISTS `cakeflavors` (
  `flavorId` int(11) NOT NULL AUTO_INCREMENT,
  `flavorName` varchar(1000) NOT NULL,
  `flavorPrice` double(11,2) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`flavorId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cakeflavors`
--

INSERT INTO `cakeflavors` (`flavorId`, `flavorName`, `flavorPrice`, `image`, `status`) VALUES
(1, 'Vanilla Cake', 100.00, 'vanilla.png', 0),
(2, 'Chocolate Cake', 150.00, 'chocolate.png', 0),
(5, 'Triple Chocolate Cake', 220.00, 'marblechocolatevanilla.png', 0),
(7, 'Red-Velvet Cake', 210.00, 'redvelvet.png', 0),
(8, 'Strawberry Cake', 120.00, 'strawberry.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productcategories`
--

DROP TABLE IF EXISTS `productcategories`;
CREATE TABLE IF NOT EXISTS `productcategories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  `categoryImage` varchar(1000) NOT NULL,
  `categoryStatus` int(11) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productcategories`
--

INSERT INTO `productcategories` (`categoryId`, `categoryName`, `categoryImage`, `categoryStatus`) VALUES
(1, 'Birthday Cakes', '1.jpg', 1),
(2, 'Wedding Cakes', '', 2),
(3, 'Cup Cakes', '3.jpg', 1),
(6, 'Christening Cakes', '', 2),
(5, 'Design Your Own', '5.jpg', 1),
(7, 'Graduation Cakes', '', 2),
(9, 'BEST SELLER CAKES', '9.JPG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productinformation`
--

DROP TABLE IF EXISTS `productinformation`;
CREATE TABLE IF NOT EXISTS `productinformation` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(100) NOT NULL,
  `productDetails` varchar(1500) NOT NULL,
  `productPrice` double(12,2) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `productImage` varchar(500) NOT NULL,
  `productStatus` int(11) NOT NULL,
  `designedBy` int(11) NOT NULL COMMENT 'For categoryId = 5 Only; FK - userId',
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`productId`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productinformation`
--

INSERT INTO `productinformation` (`productId`, `productName`, `productDetails`, `productPrice`, `categoryId`, `productImage`, `productStatus`, `designedBy`, `stock`) VALUES
(42, 'Milk Chocolate Buttercream', '1 Layer 8\" x 4\"', 2250.00, 1, '1_42.jpg', 1, 0, 13),
(43, 'Bi-RIte Creamery Classic Chocolate', '1 Layer 8\" x 4\"', 2500.00, 1, '1_43.jpg', 1, 0, 14),
(44, 'Vanilla Cake with Pastry Cream', '1 Layer 6\" x 4\"', 1500.00, 1, '1_44.jpg', 1, 0, 13),
(45, 'Chocolate Mousse Cake', '1 Layer 6\" x 4\"', 1500.00, 1, '1_45.jpg', 1, 0, 12),
(46, 'Strawberry Cake', '1 Layer 8\" x 4\"', 2500.00, 1, '1_46.jpg', 1, 0, 15),
(48, 'Chocolate Strawberry Cake', '1 Layer 8\" x 4\"', 1500.00, 2, '2_48.jpg', 1, 0, 12),
(49, 'Supreme Vanilla Cake', '1 Layer 8\" x 4\"', 2500.00, 2, '2_49.jpeg', 1, 0, 11),
(50, 'Triple Chocolate Cake', '1 Layer 8\" x 4\"', 2500.00, 2, '2_50.jpg', 1, 0, 21),
(51, 'White Roses Cake', '1 Layer 6\" x 4\"', 1500.00, 2, '2_51.jpg', 1, 0, 1500),
(52, 'Carrot Cake', 'Minimum of 30 pieces', 40.00, 3, '3_52.jpg', 1, 0, 190),
(53, 'Red Velvet', 'Minimum of 30 pieces', 40.00, 2, '2_53.jpg', 1, 0, 190),
(54, 'Red Velvet', 'Minimum of 30 pieces', 40.00, 3, '3_54.jpg', 1, 0, 190),
(55, 'Vanilla Cup Cake with Vanilla Frosting', 'Minimum of 30 pieces', 40.00, 3, '3_55.jpg', 1, 0, 190),
(56, 'Oreo Cream Cake', 'Minimum of 30 pieces', 40.00, 3, '3_56.jpg', 1, 0, 190),
(57, 'Triple Chocolate Cup Cake', 'Minimum of 30 pieces', 40.00, 3, '3_57.jpg', 1, 0, 190),
(47, 'Honey Cake', '1 Layer 8\" x 4\"', 1500.00, 2, '2_47.jpg', 1, 0, 12),
(20, 'Christening Cakes', 'Christening Cakes', 590.00, 6, '6_20.JPG', 1, 0, 0),
(21, 'TEST', 'TEST', 660.00, 7, '7_21.JPG', 1, 0, 0),
(33, 'test', 'Customized Cake', 600.00, 5, '201908110347013.jpg', 1, 3, 0),
(34, 'TEST 123123', '1 Layer 6\" x 4\"', 1500.00, 6, '6_34.JPG', 1, 0, 3),
(36, 'mmmmm', '1 Layer 6\" x 4\"', 3333.00, 6, '', 1, 0, 2),
(37, 'Red Velvet', '1 Layer 6\" x 4\"', 1000.00, 9, '9_37.JPG', 1, 0, 1),
(38, 'Carrot Cake', '1 Layer 8\" x 4\"', 1800.00, 9, '9_38.JPG', 1, 0, 1),
(39, 'Smores', '1 Layer 6\" x 4\"', 1000.00, 9, '9_39.JPG', 1, 0, 4),
(40, 'Oreo Cake', '1 Layer 8\" x 4\"', 1500.00, 9, '9_40.JPG', 1, 0, 18),
(41, 'Chocolate Ganache', '1 Layer 6\" x 4\"', 1000.00, 9, '9_41.JPG', 1, 0, 13);

-- --------------------------------------------------------

--
-- Table structure for table `productorders`
--

DROP TABLE IF EXISTS `productorders`;
CREATE TABLE IF NOT EXISTS `productorders` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `userId` varchar(100) NOT NULL,
  `orderDate` date NOT NULL,
  `deliveryDate` date NOT NULL COMMENT 'Delivery or Pick Up Date',
  `deliveryType` int(11) NOT NULL COMMENT '0 - Pick Up; 1 - Deliver;',
  `batchNumber` varchar(1000) NOT NULL,
  `orderStatus` int(11) NOT NULL COMMENT '0 - On Cart; 1 - Reserved; 2 - Pending; 3 - Approved; 4 - Denied; 5 - Delivered;',
  PRIMARY KEY (`orderId`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productorders`
--

INSERT INTO `productorders` (`orderId`, `productId`, `quantity`, `userId`, `orderDate`, `deliveryDate`, `deliveryType`, `batchNumber`, `orderStatus`) VALUES
(8, 38, 1, '11', '2019-10-13', '2019-10-25', 0, '2019101309010811', 3),
(3, 42, 1, '12', '2019-10-13', '2019-10-09', 0, '2019101308501912', 4),
(4, 37, 1, '12', '2019-10-13', '2019-10-17', 0, '2019101308514712', 3),
(5, 38, 1, '12', '2019-10-13', '2019-10-17', 0, '2019101308514712', 3),
(6, 39, 1, '12', '2019-10-13', '2019-10-17', 0, '2019101308514712', 3),
(7, 40, 1, '12', '2019-10-13', '2019-10-17', 0, '2019101308514712', 3),
(9, 39, 1, '11', '2019-10-13', '2019-10-25', 0, '2019101309010811', 3),
(10, 40, 1, '11', '2019-10-13', '2019-10-25', 0, '2019101309010811', 3),
(11, 39, 1, '11', '2019-10-13', '0000-00-00', 0, '2019101309185711', 4);

-- --------------------------------------------------------

--
-- Table structure for table `productverification`
--

DROP TABLE IF EXISTS `productverification`;
CREATE TABLE IF NOT EXISTS `productverification` (
  `verificationId` int(11) NOT NULL AUTO_INCREMENT,
  `paymentImage` varchar(1000) NOT NULL,
  `verificationStatus` int(11) NOT NULL COMMENT '0 - Pending; 1 - Approved; 2 - Denied;',
  `batchNumber` varchar(1000) NOT NULL,
  `readStatus` int(11) NOT NULL COMMENT '0 - Unread; 1 - Read;',
  PRIMARY KEY (`verificationId`),
  UNIQUE KEY `batchNumber` (`batchNumber`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productverification`
--

INSERT INTO `productverification` (`verificationId`, `paymentImage`, `verificationStatus`, `batchNumber`, `readStatus`) VALUES
(1, '201910130433219_9.png', 0, '201910130433219', 1),
(2, '2019101308501912_12.jpg', 2, '2019101308501912', 0),
(3, '2019101308514712_12.jpg', 1, '2019101308514712', 1),
(4, '2019101309010811_11.png', 1, '2019101309010811', 1),
(5, '', 0, '2019101309185711', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tempaccount`
--

DROP TABLE IF EXISTS `tempaccount`;
CREATE TABLE IF NOT EXISTS `tempaccount` (
  `listId` int(11) NOT NULL AUTO_INCREMENT,
  `tempUserId` varchar(100) NOT NULL,
  `dateLog` datetime NOT NULL,
  PRIMARY KEY (`listId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

DROP TABLE IF EXISTS `useraccounts`;
CREATE TABLE IF NOT EXISTS `useraccounts` (
  `listId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userPassword` varchar(5000) NOT NULL,
  `userType` int(11) NOT NULL COMMENT '0 - Admin; 1 - Users',
  `tempUserId` varchar(100) NOT NULL,
  PRIMARY KEY (`listId`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`listId`, `userId`, `userName`, `userPassword`, `userType`, `tempUserId`) VALUES
(11, 11, 'jhiebaba', 'b936e7d4952efb0f5480a8304acaaeed', 1, ''),
(4, 4, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, ''),
(9, 9, 'user1', 'd8578edf8458ce06fbc5bb76a58c5ca4', 1, ''),
(10, 10, 'jhiebaba', 'b936e7d4952efb0f5480a8304acaaeed', 1, ''),
(12, 12, 'shm', '1cd7bd0fd8518ab1ac80560a36fd9d7d', 1, ''),
(13, 13, 'user21', '25d55ad283aa400af464c76d713c07ad', 1, ''),
(14, 14, 'ralph', 'e2282829f546bbcb216693e2a5659a79', 1, ''),
(17, 17, 'raymondgeee', '32366c5cc71d45733c74e832c8797dfc', 1, '1910191156521'),
(18, 18, 'user50', '6eea9b7ef19179a06954edd0f6c05ceb', 1, '1910190124291');

-- --------------------------------------------------------

--
-- Table structure for table `userinformation`
--

DROP TABLE IF EXISTS `userinformation`;
CREATE TABLE IF NOT EXISTS `userinformation` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `surName` varchar(100) NOT NULL,
  `gender` int(11) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `contactNumber` varchar(25) NOT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `profilePicture` varchar(1000) DEFAULT NULL,
  `registeredDate` date NOT NULL,
  `userStatus` int(11) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userinformation`
--

INSERT INTO `userinformation` (`userId`, `firstName`, `surName`, `gender`, `address`, `contactNumber`, `email`, `profilePicture`, `registeredDate`, `userStatus`) VALUES
(4, 'Admin', 'Test', 1, 'Dyan Lang', '12344', 'admin.test@gmail.com', '4.PNG', '0000-00-00', 0),
(10, 'jhiewel', 'lanting', 2, 'sta.anastacia sto.tomas batangas', '09157023072', NULL, NULL, '2019-10-13', 0),
(9, 'user1', 'Test', 1, 'Tiaong, Quezon', '09122719384', NULL, NULL, '2019-10-12', 0),
(11, 'jhiewel', 'lanting', 2, 'sta.anastacia sto.tomas batangas', '09157023072', NULL, '11.png', '2019-10-13', 0),
(12, 'shem', 'mon', 1, 'santiago', '09215046542', NULL, NULL, '2019-10-13', 0),
(13, 'user3', 'Test', 1, 'qweqwe1', '11', NULL, NULL, '2019-10-13', 0),
(14, 'ralph', 'cosme', 1, 'sampaloc', '09123123123', NULL, NULL, '2019-10-13', 0),
(17, 'Raymond', 'Gelera', 1, 'Tiaong, Quezon', '09122719384', NULL, NULL, '2019-10-19', 0),
(18, 'qwerty', 'qwerty', 2, 'qwer', '12312312312', NULL, NULL, '2019-10-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usernotification`
--

DROP TABLE IF EXISTS `usernotification`;
CREATE TABLE IF NOT EXISTS `usernotification` (
  `notificationId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `notificationDetails` varchar(2000) NOT NULL,
  `notificationKey` varchar(1000) NOT NULL,
  `notificationRemarks` varchar(1000) NOT NULL,
  `notificationStatus` int(11) NOT NULL,
  `notificationType` int(11) NOT NULL COMMENT '0 - Default; 1 - Did not pick up;',
  `notificationDate` date NOT NULL,
  PRIMARY KEY (`notificationId`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usernotification`
--

INSERT INTO `usernotification` (`notificationId`, `userId`, `notificationDetails`, `notificationKey`, `notificationRemarks`, `notificationStatus`, `notificationType`, `notificationDate`) VALUES
(1, 12, 'Order/s has been approved', '2019101308514712', '', 1, 0, '0000-00-00'),
(2, 11, 'Order/s has been approved', '2019101309010811', '', 1, 0, '0000-00-00'),
(4, 12, 'You did not pick-up your order.', '2019101308514712', 'Please pick up your order within 1-2 days or else order will be cancelled and down payment is not refundable.', 1, 1, '2019-10-23'),
(5, 12, 'Order/s has been denied', '2019101308501912', 'asdasdasdasd test', 1, 0, '2019-10-23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
