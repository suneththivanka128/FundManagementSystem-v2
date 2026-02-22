-- 1. Create and Select Database
CREATE DATABASE IF NOT EXISTS `Fund Management System` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Fund Management System`;

-- 2. Temporarily disable Foreign Key Checks
SET FOREIGN_KEY_CHECKS = 0;

-- 3. Roles Table
CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`RoleName`, `Description`) VALUES
('Admin', 'System administrator with full access'),
('User', 'Regular member with limited access');

-- 4. Member Registration Table
CREATE TABLE `memberregistration` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `RegNo` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `NICNumber` varchar(255) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `WhatsAppNo` varchar(20) DEFAULT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `ProfilePhoto` varchar(255) DEFAULT NULL,
  `RoleID` int(11) DEFAULT 2,
  `status` enum('pending','Approve','Reject') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `RegNo` (`RegNo`),
  CONSTRAINT `fk_role` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `memberregistration` (`FirstName`, `LastName`, `RegNo`, `Email`, `RoleID`, `status`) VALUES
('System', 'Admin', 'ADMIN-001', 'admin@example.com', 1, 'Approve'),
('John', 'Doe', 'REG-0001', 'johndoe@example.com', 2, 'Approve');

-- 5. Add Payment Table
CREATE TABLE `add_payment` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `RegistrationNo` varchar(255) DEFAULT NULL,
  `PaymentDate` date NOT NULL,
  `ForYear` year(4) NOT NULL,
  `ForMonth` varchar(15) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Status` varchar(50) DEFAULT 'active',
  PRIMARY KEY (`PaymentID`),
  CONSTRAINT `fk_member_pay` FOREIGN KEY (`RegistrationNo`) REFERENCES `memberregistration` (`RegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Expenses Table
CREATE TABLE `expenses` (
  `Payment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `DataAdder` varchar(50) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `Responser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Payment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Announcement Table
CREATE TABLE `announcement` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date DEFAULT NULL,
  `Message` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `announcement` (`Date`, `Message`) VALUES
('2024-01-01', 'Welcome to the Fund Management System!'),
('2025-01-01', 'Happy New Year to all members!');

-- 8. Contact Us Table
CREATE TABLE `contactus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RegNo` varchar(255) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `WhatsAppNo` varchar(15) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Message` varchar(1000) DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`ID`),
  CONSTRAINT `fk_member_contact` FOREIGN KEY (`RegNo`) REFERENCES `memberregistration` (`RegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Re-enable Foreign Key Checks
SET FOREIGN_KEY_CHECKS = 1;