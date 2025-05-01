-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 02:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_feeding`
--

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `parent_name` varchar(100) DEFAULT NULL,
  `parent_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `registration_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beneficiaries`
--

INSERT INTO `beneficiaries` (`id`, `full_name`, `gender`, `date_of_birth`, `parent_name`, `parent_number`, `address`, `created_by`, `registration_date`) VALUES
(1, 'hodan yusuf', 'Female', '2025-04-01', 'xaliimo', '618565555', 'ankara', NULL, '2025-04-29'),
(2, 'Ahmed Ali', 'Male', '2019-06-21', 'caasho xasan', '615555722', 'USA', NULL, '2025-04-29'),
(4, 'XAllimo Ali', 'Female', '2025-04-04', 'caasho xasan', '1545525452', 'karan', NULL, '2025-04-30'),
(5, 'XAllimo Ali', 'Female', '2025-04-29', 'caasho xasan', '33332333', 'suuqaoolaha', 4, '2025-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `feeding_programs`
--

CREATE TABLE `feeding_programs` (
  `id` int(11) NOT NULL,
  `program_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeding_programs`
--

INSERT INTO `feeding_programs` (`id`, `program_name`, `description`, `start_date`, `end_date`) VALUES
(1, 'Outpatient Therapeutic Pogram (OTP)', 'program to treat severe acute malnutrition', '2025-04-30', '2025-05-02'),
(2, 'OTP', 'program treat childrens', '2025-04-02', '2025-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `feeding_records`
--

CREATE TABLE `feeding_records` (
  `id` int(11) NOT NULL,
  `beneficiary_id` int(11) NOT NULL,
  `feeding_program_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `feeding_date` date DEFAULT curdate(),
  `quantity` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `recorded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeding_records`
--

INSERT INTO `feeding_records` (`id`, `beneficiary_id`, `feeding_program_id`, `meal_id`, `feeding_date`, `quantity`, `remarks`, `recorded_by`, `created_at`) VALUES
(1, 5, 1, 1, '2025-04-25', '2 sachets', 'Beneficiary accepted meal well', 4, '2025-04-30 09:46:48'),
(4, 1, 2, 1, '2025-04-30', '3sachets', 'Beneficiary accepted meal well', 1, '2025-04-30 12:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `meal_name` varchar(100) NOT NULL,
  `meal_description` text DEFAULT NULL,
  `calories` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `meal_name`, `meal_description`, `calories`) VALUES
(1, 'plumpy Nut', 'Hight-calories peanut-based paste for malnutrition', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_assessments`
--

CREATE TABLE `nutrition_assessments` (
  `id` int(11) NOT NULL,
  `beneficiary_id` int(11) NOT NULL,
  `assessment_date` date DEFAULT curdate(),
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `muac` decimal(5,2) DEFAULT NULL,
  `health_notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition_assessments`
--

INSERT INTO `nutrition_assessments` (`id`, `beneficiary_id`, `assessment_date`, `weight`, `height`, `muac`, `health_notes`, `created_by`, `created_at`) VALUES
(1, 2, '2025-04-30', 12.50, 85.00, 12.00, 'slight improvement observed ', NULL, '2025-04-30 12:08:40'),
(3, 5, '2025-05-01', 12.50, 84.00, 12.00, 'slight improvement observed ', 4, '2025-05-01 12:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `position` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `hire_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `full_name`, `gender`, `position`, `phone_number`, `address`, `email`, `hire_date`) VALUES
(1, 'Amina Mohamed', 'Female', 'Nutrition Officer', '017526252', 'ankara', 'amina@gmail.com', '2025-04-29'),
(2, 'casho Mohamed', 'Female', 'malnutrition Officer', '766221545532', 'ankara', 'casho@gmail.com', '2025-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Staff') DEFAULT 'Staff',
  `staff_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `staff_id`, `created_at`) VALUES
(1, 'Admin', '1234', 'Admin', 1, '2025-04-29 14:49:58'),
(4, 'Staff', '1212', 'Staff', 2, '2025-04-30 14:16:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_beneficiaries_user` (`created_by`);

--
-- Indexes for table `feeding_programs`
--
ALTER TABLE `feeding_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeding_records`
--
ALTER TABLE `feeding_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_id` (`beneficiary_id`),
  ADD KEY `feeding_program_id` (`feeding_program_id`),
  ADD KEY `meal_id` (`meal_id`),
  ADD KEY `fk_feeding_user` (`recorded_by`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nutrition_assessments`
--
ALTER TABLE `nutrition_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_id` (`beneficiary_id`),
  ADD KEY `fk_assessments_user` (`created_by`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feeding_programs`
--
ALTER TABLE `feeding_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feeding_records`
--
ALTER TABLE `feeding_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nutrition_assessments`
--
ALTER TABLE `nutrition_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD CONSTRAINT `fk_beneficiaries_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `feeding_records`
--
ALTER TABLE `feeding_records`
  ADD CONSTRAINT `feeding_records_ibfk_1` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeding_records_ibfk_2` FOREIGN KEY (`feeding_program_id`) REFERENCES `feeding_programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeding_records_ibfk_3` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeding_records_ibfk_4` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_feeding_user` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `nutrition_assessments`
--
ALTER TABLE `nutrition_assessments`
  ADD CONSTRAINT `fk_assessments_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `nutrition_assessments_ibfk_1` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
