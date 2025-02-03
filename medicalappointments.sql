-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 01:06 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicalappointments`
--
CREATE DATABASE IF NOT EXISTS `medicalappointments` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `medicalappointments`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `AppointmentID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `AppointmentDate` datetime NOT NULL,
  `Status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `Mode` enum('InPerson','Online') NOT NULL,
  `Report` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`AppointmentID`),
  KEY `UserID` (`UserID`),
  KEY `DoctorID` (`DoctorID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`UserID`, `DoctorID`, `AppointmentDate`, `Status`, `Mode`, `Report`, `CreatedAt`)
SELECT 
    FLOOR(RAND() * 50) + 1,
    FLOOR(RAND() * 10) + 1,
    DATE_ADD('2025-01-01', INTERVAL FLOOR(RAND() * 90) DAY),
    CASE FLOOR(RAND() * 3) WHEN 0 THEN 'Completed' WHEN 1 THEN 'Scheduled' ELSE 'Cancelled' END,
    CASE FLOOR(RAND() * 2) WHEN 0 THEN 'InPerson' ELSE 'Online' END,
    CASE WHEN RAND() > 0.5 THEN 'Zalecono badania' ELSE NULL END,
    NOW()
FROM (SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL 
      SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) a,
     (SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL 
      SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) b;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctoravailability`
--

CREATE TABLE IF NOT EXISTS `doctoravailability` (
  `AvailabilityID` int(11) NOT NULL AUTO_INCREMENT,
  `DoctorID` int(11) NOT NULL,
  `AvailableDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  PRIMARY KEY (`AvailabilityID`),
  KEY `DoctorID` (`DoctorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dodawanie dostępności lekarzy
--

INSERT INTO doctoravailability (DoctorID, AvailableDate, StartTime, EndTime)
SELECT 
    d.DoctorID, 
    DATE_ADD(CURDATE(), INTERVAL FLOOR(RAND() * 30) DAY),  -- Losowa data w ciągu następnych 30 dni
    SEC_TO_TIME(FLOOR(RAND() * 4 + 8) * 3600),  -- Start między 8:00 a 12:00
    SEC_TO_TIME(FLOOR(RAND() * 5 + 13) * 3600) -- Koniec między 13:00 a 18:00
FROM doctors d, (SELECT 1 UNION SELECT 2 UNION SELECT 3) x;  -- Po 3 wpisy na lekarza

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctors`
--

CREATE TABLE IF NOT EXISTS `doctors` (
  `DoctorID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `SpecializationID` int(11) NOT NULL,
  `Bio` text DEFAULT NULL,
  `AvailabilityStatus` enum('Available','OnLeave','Unavailable') DEFAULT 'Available',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`DoctorID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `SpecializationID` (`SpecializationID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`FirstName`, `LastName`, `Email`, `PhoneNumber`, `SpecializationID`, `Bio`, `AvailabilityStatus`, `CreatedAt`) VALUES
('Jan', 'Kowalski', 'jan.kowalski@clinic.com', '123456789', 1, 'Doświadczony kardiolog', 'Available', NOW()),
('Anna', 'Nowak', 'anna.nowak@clinic.com', '987654321', 2, 'Dermatolog z wieloletnim stażem', 'Available', NOW()),
('Piotr', 'Wiśniewski', 'piotr.wisniewski@clinic.com', '456123789', 3, 'Ekspert w neurologii', 'Available', NOW()),
('Marta', 'Lis', 'marta.lis@clinic.com', '741852963', 4, 'Specjalista ortopedii', 'Available', NOW());

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `healthpackages`
--

CREATE TABLE IF NOT EXISTS `healthpackages` (
  `PackageID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `DurationMonths` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`PackageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dodawanie pakietów zdrowotnych
--

INSERT INTO healthpackages (Name, Description, Price, DurationMonths)
VALUES 
('Podstawowy', 'Podstawowy pakiet zdrowotny', 199.99, 3),
('Rozszerzony', 'Więcej konsultacji i badań', 399.99, 6),
('Premium', 'Najszerszy zakres usług', 799.99, 12);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `AppointmentID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PaymentMethod` enum('CreditCard','DebitCard','PayPal','Cash') NOT NULL,
  `Status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
  PRIMARY KEY (`PaymentID`),
  KEY `UserID` (`UserID`),
  KEY `AppointmentID` (`AppointmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dodawanie płatności
--

INSERT INTO `payments` (`UserID`, `AppointmentID`, `Amount`, `PaymentMethod`, `Status`, `PaymentDate`)
SELECT 
    FLOOR(RAND() * 50) + 1,
    FLOOR(RAND() * 100) + 1,
    ROUND(RAND() * 300 + 100, 2),
    CASE FLOOR(RAND() * 3) WHEN 0 THEN 'CreditCard' WHEN 1 THEN 'PayPal' ELSE 'DebitCard' END,
    CASE FLOOR(RAND() * 2) WHEN 0 THEN 'Completed' ELSE 'Pending' END,
    NOW()
FROM (SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL 
      SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) a;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prescriptions`
--

CREATE TABLE IF NOT EXISTS `prescriptions` (
  `PrescriptionID` int(11) NOT NULL AUTO_INCREMENT,
  `AppointmentID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Details` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`PrescriptionID`),
  KEY `AppointmentID` (`AppointmentID`),
  KEY `DoctorID` (`DoctorID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dodawanie recept dla zakończonych wizyt
--

INSERT INTO prescriptions (AppointmentID, DoctorID, UserID, Details, CreatedAt)
SELECT 
    a.AppointmentID, 
    a.DoctorID,
    a.UserID,
    CONCAT('Lek ', FLOOR(RAND() * 50) + 1, ' - 2x dziennie przez 7 dni'), 
    NOW()
FROM appointments a
WHERE a.Status = 'Completed'
LIMIT 70;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `ReviewID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `Comment` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ReviewID`),
  KEY `UserID` (`UserID`),
  KEY `DoctorID` (`DoctorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dodawanie opinii dla zakończonych wizyt
--

INSERT INTO reviews (UserID, DoctorID, Rating, Comment, CreatedAt)
SELECT 
    a.UserID, 
    a.DoctorID, 
    FLOOR(RAND() * 3 + 3),  -- Oceny 3-5
    CASE FLOOR(RAND() * 3) 
        WHEN 0 THEN 'Bardzo dobry lekarz!' 
        WHEN 1 THEN 'Wizyta przebiegła sprawnie' 
        ELSE 'Mogło być lepiej, ale ok' 
    END,
    NOW()
FROM appointments a
WHERE a.Status = 'Completed'
LIMIT 50;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `specializations`
--

CREATE TABLE IF NOT EXISTS `specializations` (
  `SpecializationID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`SpecializationID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`Name`, `Description`) VALUES
('Kardiolog', 'Specjalista od chorób serca'),
('Dermatolog', 'Specjalista od chorób skóry'),
('Neurolog', 'Specjalista od układu nerwowego'),
('Ortopeda', 'Specjalista od układu kostnego'),
('Pediatra', 'Lekarz dziecięcy'),
('Okulista', 'Specjalista od chorób oczu'),
('Laryngolog', 'Specjalista od chorób uszu, nosa i gardła'),
('Psychiatra', 'Specjalista od zdrowia psychicznego'),
('Urolog', 'Specjalista od układu moczowego'),
('Endokrynolog', 'Specjalista od hormonów');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `userhealthpackages`
--

CREATE TABLE IF NOT EXISTS `userhealthpackages` (
  `SubscriptionID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `PackageID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  PRIMARY KEY (`SubscriptionID`),
  KEY `UserID` (`UserID`),
  KEY `PackageID` (`PackageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dodawanie pakietów użytkowników
--

INSERT INTO userhealthpackages (UserID, PackageID, StartDate, EndDate)
SELECT 
    u.UserID,
    FLOOR(RAND() * 3) + 1,  -- losowy pakiet
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 6) MONTH), -- Aktywne od 0-6 miesięcy temu
    DATE_ADD(NOW(), INTERVAL FLOOR(RAND() * 6 + 6) MONTH) -- Ważne przez 6-12 miesięcy
FROM users u
LIMIT 30;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`FirstName`, `LastName`, `Email`, `PhoneNumber`, `DateOfBirth`, `Address`, `CreatedAt`)
SELECT 
    CONCAT('User', id),
    CONCAT('Surname', id),
    CONCAT('user', id, '@example.com'),
    LPAD(id, 9, '0'),
    DATE_ADD('1970-01-01', INTERVAL FLOOR(RAND() * 18000) DAY),
    CONCAT('Miasto ', id, ', ul. Przykładowa ', id),
    NOW()
FROM (SELECT (a.a + (10 * b.a)) AS id FROM 
      (SELECT 1 a UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
       UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) a,
      (SELECT 0 a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) b) numbers
WHERE id <= 50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `doctors` (`DoctorID`);

--
-- Constraints for table `doctoravailability`
--
ALTER TABLE `doctoravailability`
  ADD CONSTRAINT `doctoravailability_ibfk_1` FOREIGN KEY (`DoctorID`) REFERENCES `doctors` (`DoctorID`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`SpecializationID`) REFERENCES `specializations` (`SpecializationID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`AppointmentID`) REFERENCES `appointments` (`AppointmentID`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`AppointmentID`) REFERENCES `appointments` (`AppointmentID`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `doctors` (`DoctorID`),
  ADD CONSTRAINT `prescriptions_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `doctors` (`DoctorID`);

--
-- Constraints for table `userhealthpackages`
--
ALTER TABLE `userhealthpackages`
  ADD CONSTRAINT `userhealthpackages_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `userhealthpackages_ibfk_2` FOREIGN KEY (`PackageID`) REFERENCES `healthpackages` (`PackageID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
