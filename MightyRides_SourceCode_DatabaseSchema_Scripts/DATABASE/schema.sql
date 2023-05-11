-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- Create DATABASE CARS

CREATE TABLE `customer` 
(
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `PhoneNo` varchar(255) NOT NULL UNIQUE,
  `Address` varchar(255) DEFAULT NULL,
  `DrivingLicense` varchar(255) DEFAULT NULL UNIQUE,
  `c_email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (customerID) 
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `customer_login`
(
  `c_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastloggedintime` timestamp NOT NULL DEFAULT current_timestamp(),
  `vkey` varchar(255) DEFAULT NULL
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `dealer` 
(
  `dealerid` int(11) NOT NULL AUTO_INCREMENT,
  `DName` varchar(255) NOT NULL,
  `PhoneNo` varchar(255) NOT NULL,
  `Website` varchar(255) DEFAULT NULL,
  `D_Email` varchar(255) NOT NULL,
  `D_Password` varchar(255) NOT NULL,
  PRIMARY KEY(dealerid)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `dealer_login` 
(
  `d_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastloggedintime` timestamp NOT NULL DEFAULT current_timestamp(),
  `vkey` varchar(255) DEFAULT NULL
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `manufacturer`
(
  `manufacturerid` int(11) AUTO_INCREMENT,
  `Mname` varchar(255) NOT NULL UNIQUE,
  `PhoneNo` varchar(255) NOT NULL UNIQUE,
  `Location` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL UNIQUE,
  `Website` varchar(255) NOT NULL UNIQUE,
  Primary KEY (manufacturerid) 
); 
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `car` 
(
  `carid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `carType` varchar(255) NOT NULL,
  `Mileage` varchar(255) NOT NULL,
  `Color` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `fuelType` varchar(255) NOT NULL,
  `LicensePlateNo` varchar(255) DEFAULT NULL UNIQUE,
  `ManufactureDate` date NOT NULL,
  `ManufacturerID` int(11) DEFAULT NULL,
  `dealerid` int(11) DEFAULT NULL,
  `uploadedtime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(carid),
  FOREIGN KEY (manufacturerid) References manufacturer(manufacturerid) ON DELETE CASCADE
);

-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `features`
(
  `carid` int(11) NOT NULL,
  `features` varchar(255) NOT NULL,
  Primary Key (carid, features)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `images`
(
  `carid` int(11) DEFAULT NULL,
  `images` varchar(255) NOT NULL,
  `uploadedtime` datetime NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (carid) References car(carid) ON DELETE CASCADE
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `branch`
(
  `dealerid` int(11) NOT NULL,
  `BranchName` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  FOREIGN KEY (dealerid) References dealer(dealerid) ON DELETE CASCADE
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `newcar`
(
  `NewCarid` int(11) NOT NULL,
  `Price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `customerID` int(11) DEFAULT NULL,
  `paymentdate` date DEFAULT NULL,
  `paymentstatus` varchar(255) DEFAULT NULL,
  `paymentstatuschangetime` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (NewCarid) References car(carid) ON DELETE CASCADE,
  FOREIGN KEY (customerID) References customer(customerID) ON DELETE CASCADE
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `owns` (
  `carid` int(11) NOT NULL,
  `dealerid` int(11) NOT NULL,
  -- `cartype` varchar(255) DEFAULT NULL,
  FOREIGN KEY (carid) References car(carid) ON DELETE CASCADE,
  FOREIGN KEY (dealerid) References dealer(dealerid) ON DELETE CASCADE,
  PRIMARY KEY(carid, dealerid)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `preownedcar` 
(
  `PreOwnedCarid` int(11) NOT NULL,
  `ResalePrice` double NOT NULL,
  `KMdriven` varchar(20) NOT NULL,
  `discount` double DEFAULT NULL,
  `paymentdate` date DEFAULT NULL,
  `paymentstatus` varchar(255) DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL,
  `paymentstatuschangetime` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (customerID) References customer(customerID) ON DELETE CASCADE,
  FOREIGN KEY (PreOwnedCarid) References car(carid) ON DELETE CASCADE
);
--  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `rent` 
(
  `rentalcarid` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `rentdate` date DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
    FOREIGN KEY (rentalcarid) References car(carid) ON DELETE CASCADE,
    FOREIGN KEY (customerID) References customer(customerID) ON DELETE CASCADE

);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `rentalcar`
(
    `rentalcarid` int(11) NOT NULL,
    `rentamount` double NOT NULL,
    FOREIGN KEY (rentalcarid) References car(carid) ON DELETE CASCADE
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;