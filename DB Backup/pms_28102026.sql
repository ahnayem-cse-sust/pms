-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2026 at 10:54 AM
-- Server version: 8.4.11-0ubuntu0.26.04.1
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auditable_id` bigint UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:28:48'),
(2, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:36:42'),
(3, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:37:47'),
(4, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:38:26'),
(5, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:38:47'),
(6, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:39:37'),
(7, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:39:43'),
(8, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:41:00'),
(9, 4, 'user.created', 'User', 8, NULL, '{\"name\": \"MEHEDI RAIHAN\", \"email\": \"raihanmehedi700@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01771713685\", \"employee_id\": \"1\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T06:41:37.728652Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:41:37'),
(10, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:43:07'),
(11, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:47:11'),
(12, 4, 'user.created', 'User', 9, NULL, '{\"name\": \"ISRAT JAHAN\", \"email\": \"israt29190@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01876692194\", \"employee_id\": \"2\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T06:47:15.670929Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:47:15'),
(13, 4, 'user.created', 'User', 10, NULL, '{\"name\": \"TULI NANDY\", \"email\": \"nandytuli9@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01674827361\", \"employee_id\": \"3\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T06:49:51.257412Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:49:51'),
(14, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:50:03'),
(15, 4, 'user.created', 'User', 11, NULL, '{\"name\": \"MD. RAZAUL KARIM\", \"email\": \"md.razaulkarim86@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01819633879\", \"employee_id\": \"4\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T06:54:39.445658Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:54:39'),
(16, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:56:29'),
(17, 4, 'user.created', 'User', 12, NULL, '{\"name\": \"MD. MAHABUB ALAM\", \"email\": \"mahabubjocl@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01613444355\", \"employee_id\": \"5\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T06:56:34.550581Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:56:34'),
(18, 7, 'user.updated', 'User', 5, '{\"name\": \"IT Employee\", \"email\": \"it_emp@joplc.com\", \"role_ids\": [3], \"whatsapp\": null, \"is_active\": true, \"employee_id\": null, \"location_id\": 1, \"department_id\": 1, \"designation_id\": null, \"is_department_head\": false}', '{\"name\": \"IT Employee\", \"email\": \"it_emp@joplc.com\", \"role_ids\": [3], \"whatsapp\": null, \"is_active\": false, \"employee_id\": null, \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": null, \"is_department_head\": false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:56:49'),
(19, 9, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:56:55'),
(20, 12, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:12:07'),
(21, 4, 'lookup.designations.created', 'Designation', 5, NULL, '{\"name\": \"Assistent Cum Computer Oparetor\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:13:57'),
(22, 4, 'user.updated', 'User', 12, '{\"name\": \"MD. MAHABUB ALAM\", \"email\": \"mahabubjocl@gmail.com\", \"role_ids\": [3], \"whatsapp\": \"01613444355\", \"is_active\": true, \"employee_id\": \"5\", \"location_id\": 1, \"department_id\": 1, \"designation_id\": 4, \"is_department_head\": false}', '{\"name\": \"MD. MAHABUB ALAM\", \"email\": \"mahabubjocl@gmail.com\", \"role_ids\": [3], \"whatsapp\": \"01613444355\", \"is_active\": true, \"employee_id\": \"5\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"5\", \"is_department_head\": false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:14:23'),
(23, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:15:52'),
(24, 4, 'user.created', 'User', 13, NULL, '{\"name\": \"RAFAT KHAN\", \"email\": \"rafatkhan1988@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01672011005\", \"employee_id\": \"7\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T08:55:48.117458Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 08:55:48'),
(25, 4, 'user.created', 'User', 14, NULL, '{\"name\": \"KAZI MD AIYUB\", \"email\": \"kaziaiyub@gmail.com\", \"role_ids\": [\"3\"], \"whatsapp\": \"01731964635\", \"employee_id\": \"8\", \"location_id\": \"1\", \"department_id\": \"1\", \"designation_id\": \"4\", \"password_changed_at\": \"2026-10-08T09:01:48.018249Z\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 09:01:48'),
(26, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 09:06:56'),
(27, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-08 09:35:49'),
(28, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 07:04:01'),
(29, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-10 06:20:30'),
(30, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:22:10'),
(31, 11, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:22:52'),
(32, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:23:58'),
(33, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:48:32'),
(34, 9, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 04:54:49'),
(35, 9, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 04:55:24'),
(36, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:11:29'),
(37, 7, 'user.updated', 'User', 5, '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":false,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:12:15'),
(38, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:12:19'),
(39, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:14:00'),
(40, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:14:15'),
(41, 7, 'user.updated', 'User', 5, '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:14:47'),
(42, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:41:41'),
(43, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:42:37'),
(44, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:43:38'),
(45, 4, 'lookup.departments.updated', 'Department', 1, '{\"name\":\"Information Technology\",\"code\":\"IT\",\"is_active\":1}', '{\"name\":\"MIS & IT\",\"code\":\"IT\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:45:13'),
(46, 4, 'lookup.designations.created', 'Designation', 6, NULL, '{\"name\":\"Sr. ASSTT\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:57:23'),
(47, 4, 'user.created', 'User', 15, NULL, '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":\"1\",\"designation_id\":\"6\",\"location_id\":\"1\",\"password_changed_at\":\"2026-10-11T06:00:25.690370Z\",\"role_ids\":[\"2\"]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:00:25'),
(48, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:01:13'),
(49, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:02:03'),
(50, 15, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:02:45'),
(51, 7, 'user.updated', 'User', 15, '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":1,\"designation_id\":6,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2]}', '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":\"1\",\"designation_id\":\"6\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:03:25'),
(52, 7, 'user.updated', 'User', 4, '{\"name\":\"IT Admin\",\"email\":\"it_admin@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2]}', '{\"name\":\"IT Admin\",\"email\":\"it_admin@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:04:03'),
(53, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:04:06'),
(54, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 06:04:06'),
(55, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 07:04:57'),
(56, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 07:10:17'),
(57, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:32:10'),
(58, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:33:30'),
(59, 12, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:55:02'),
(60, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:59:01'),
(61, 7, 'user.updated', 'User', 14, '{\"name\":\"KAZI MD AIYUB\",\"email\":\"kaziaiyub@gmail.com\",\"employee_id\":\"8\",\"whatsapp\":\"01731964635\",\"department_id\":1,\"designation_id\":4,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"KAZI MD AIYUB\",\"email\":\"kaziaiyub6@gmail.com\",\"employee_id\":\"8\",\"whatsapp\":\"01731964635\",\"department_id\":\"1\",\"designation_id\":\"4\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:01:19'),
(62, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:04:06'),
(63, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:04:37'),
(64, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:04:53'),
(65, 10, 'user.password_changed', 'User', 10, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:10:06'),
(66, 10, 'user.password_changed', 'User', 10, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:11:35'),
(67, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:14:13'),
(68, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:14:28'),
(69, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:15:45'),
(70, 7, 'user.updated', 'User', 14, '{\"name\":\"KAZI MD AIYUB\",\"email\":\"kaziaiyub6@gmail.com\",\"employee_id\":\"8\",\"whatsapp\":\"01731964635\",\"department_id\":1,\"designation_id\":4,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"KAZI MD AIYUB\",\"email\":\"kaziaiyub06@gmail.com\",\"employee_id\":\"8\",\"whatsapp\":\"01731964635\",\"department_id\":\"1\",\"designation_id\":\"4\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:05:27'),
(71, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:54:40'),
(72, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:54:50'),
(73, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:25:46'),
(74, 7, 'user.updated', 'User', 10, '{\"name\":\"TULI NANDY\",\"email\":\"nandytuli9@gmail.com\",\"employee_id\":\"3\",\"whatsapp\":\"01674827361\",\"department_id\":1,\"designation_id\":4,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"TULI NANDY\",\"email\":\"nandytuli9@gmail.com\",\"employee_id\":\"3\",\"whatsapp\":\"01674827361\",\"department_id\":\"1\",\"designation_id\":\"4\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:59:05'),
(75, 7, 'user.updated', 'User', 10, '{\"name\":\"TULI NANDY\",\"email\":\"nandytuli9@gmail.com\",\"employee_id\":\"3\",\"whatsapp\":\"01674827361\",\"department_id\":1,\"designation_id\":4,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"TULI NANDY\",\"email\":\"nandytuli9@gmail.com\",\"employee_id\":\"3\",\"whatsapp\":\"01674827361\",\"department_id\":\"1\",\"designation_id\":\"4\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:00:41'),
(76, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:03:25'),
(77, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:15:53'),
(78, 13, 'logout', NULL, NULL, NULL, NULL, '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:48:32'),
(79, 14, 'logout', NULL, NULL, NULL, NULL, '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:49:01'),
(80, 14, 'logout', NULL, NULL, NULL, NULL, '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:49:20'),
(81, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 05:00:34'),
(82, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 05:00:58'),
(83, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:42:13'),
(84, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:47:54'),
(85, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-13 03:07:12'),
(86, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:08:08'),
(87, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:08:39'),
(88, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 02:59:59'),
(89, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:09:55'),
(90, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:10:13'),
(91, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:11:34'),
(92, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:16:36'),
(93, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:52:04'),
(94, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:52:12'),
(95, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 04:22:31'),
(96, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 15:03:10'),
(97, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-16 07:02:37'),
(98, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:57:24'),
(99, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:57:49'),
(100, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:17:55'),
(101, 11, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:20:00'),
(102, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:27:01'),
(103, 4, 'user.updated', 'User', 11, '{\"name\":\"MD. RAZAUL KARIM\",\"email\":\"md.razaulkarim86@gmail.com\",\"employee_id\":\"4\",\"whatsapp\":\"01819633879\",\"department_id\":1,\"designation_id\":4,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"MD. RAZAUL KARIM\",\"email\":\"md.razaulkarim86@gmail.com\",\"employee_id\":\"4\",\"whatsapp\":\"01819633879\",\"department_id\":\"1\",\"designation_id\":\"5\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:30:34'),
(104, 4, 'user.updated', 'User', 12, '{\"name\":\"MD. MAHABUB ALAM\",\"email\":\"mahabubjocl@gmail.com\",\"employee_id\":\"5\",\"whatsapp\":\"01613444355\",\"department_id\":1,\"designation_id\":5,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"MD. MAHABUB ALAM\",\"email\":\"mahabubjocl@gmail.com\",\"employee_id\":\"5\",\"whatsapp\":\"01613444355\",\"department_id\":\"1\",\"designation_id\":\"5\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:42:57'),
(105, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 08:32:01'),
(106, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 02:00:49'),
(107, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:02:06'),
(108, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:02:45'),
(109, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:23:56'),
(110, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:24:49'),
(111, 7, 'user.updated', 'User', 4, '{\"name\":\"IT Admin\",\"email\":\"it_admin@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,6]}', '{\"name\":\"IT Admin\",\"email\":\"it_admin@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:05'),
(112, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:11'),
(113, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:30'),
(114, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:03'),
(115, 7, 'user.updated', 'User', 5, '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":false,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:55'),
(116, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:57'),
(117, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:27:30'),
(118, 7, 'ticket.created_on_behalf', 'Ticket', 1, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:28:31'),
(119, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:29:57'),
(120, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:30:45'),
(121, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:32:16'),
(122, 4, 'ticket.team_added', 'Ticket', 1, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:38:12'),
(123, 4, 'ticket.team_added', 'Ticket', 1, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:38:12'),
(124, 4, 'ticket.status_changed', 'Ticket', 1, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:38:12'),
(125, 4, 'ticket.assigned', 'Ticket', 1, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:38:12'),
(126, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:38:59'),
(127, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:39:15'),
(128, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:40:23'),
(129, 4, 'ticket.team_added', 'Ticket', 1, '{\"team\":null}', '{\"team\":\"IT Employee (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:40:58'),
(130, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:41:11'),
(131, 5, 'ticket.work_update', 'Ticket', 1, '{\"work_status\":\"ASSIGNED\"}', '{\"work_status\":\"IN_PROGRESS\",\"note\":null}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:41:56'),
(132, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:18'),
(133, 4, 'ticket.team_removed', 'Ticket', 1, '{\"team\":\"MD. MAHABUB ALAM\"}', '{\"team\":null}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:44'),
(134, 4, 'ticket.team_role_changed', 'Ticket', 1, '{\"team\":\"IT Employee (Supporting)\"}', '{\"team\":\"IT Employee (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:44'),
(135, 4, 'ticket.reassigned', 'Ticket', 1, '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '{\"assigned_to\":\"IT Employee\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:44'),
(136, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:49'),
(137, 5, 'ticket.status_changed', 'Ticket', 1, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:43:56'),
(138, 5, 'ticket.status_changed', 'Ticket', 1, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:47:40'),
(139, 5, 'ticket.status_changed', 'Ticket', 1, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:47:41'),
(140, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:48:35'),
(141, 4, 'ticket.status_changed', 'Ticket', 1, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:49:13'),
(142, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:49:32'),
(143, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:50:16'),
(144, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:50:01'),
(145, 11, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:50:30'),
(146, 4, 'user.updated', 'User', 11, '{\"name\":\"MD. RAZAUL KARIM\",\"email\":\"md.razaulkarim86@gmail.com\",\"employee_id\":\"4\",\"whatsapp\":\"01819633879\",\"department_id\":1,\"designation_id\":5,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"MD. RAZAUL KARIM\",\"email\":\"md.razaulkarim86@gmail.com\",\"employee_id\":\"4\",\"whatsapp\":\"01819633879\",\"department_id\":\"1\",\"designation_id\":\"5\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:51:43'),
(147, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:53:07'),
(148, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:26:44'),
(149, 7, 'ticket.created', 'Ticket', 2, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:28:57'),
(150, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:29:19'),
(151, 4, 'ticket.team_added', 'Ticket', 2, '{\"team\":null}', '{\"team\":\"IT Employee (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:00'),
(152, 4, 'ticket.team_added', 'Ticket', 2, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:00'),
(153, 4, 'ticket.team_added', 'Ticket', 2, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:00'),
(154, 4, 'ticket.status_changed', 'Ticket', 2, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:00'),
(155, 4, 'ticket.assigned', 'Ticket', 2, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:00'),
(156, 4, 'ticket.team_removed', 'Ticket', 2, '{\"team\":\"MD. MAHABUB ALAM\"}', '{\"team\":null}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:17'),
(157, 4, 'ticket.team_role_changed', 'Ticket', 2, '{\"team\":\"IT Employee (Supporting)\"}', '{\"team\":\"IT Employee (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:17'),
(158, 4, 'ticket.reassigned', 'Ticket', 2, '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '{\"assigned_to\":\"IT Employee\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:17'),
(159, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:48'),
(160, 5, 'ticket.status_changed', 'Ticket', 2, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:32:44'),
(161, 5, 'ticket.status_changed', 'Ticket', 2, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:33:20'),
(162, 5, 'ticket.status_changed', 'Ticket', 2, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:33:20'),
(163, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:33:28'),
(164, 4, 'ticket.comment_added', 'Ticket', 2, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:34:27'),
(165, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:34:36'),
(166, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:36:13'),
(167, 4, 'ticket.status_changed', 'Ticket', 2, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:36:28'),
(168, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:37:57'),
(169, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:41:40'),
(170, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:41:51'),
(171, 6, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:43:32'),
(172, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:22:42'),
(173, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:23:39'),
(174, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:20'),
(175, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:35'),
(176, 9, 'ticket.created', 'Ticket', 3, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:25:26'),
(177, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:25:28'),
(178, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:26:06'),
(179, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:26:58'),
(180, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:27:31'),
(181, 4, 'ticket.team_added', 'Ticket', 3, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:28:04'),
(182, 4, 'ticket.status_changed', 'Ticket', 3, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:28:04'),
(183, 4, 'ticket.assigned', 'Ticket', 3, '{\"assigned_to\":null}', '{\"assigned_to\":\"ISRAT JAHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:28:04'),
(184, 4, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:29:46'),
(185, 5, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:30:16'),
(186, 9, 'ticket.status_changed', 'Ticket', 3, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:31:55'),
(187, 9, 'ticket.status_changed', 'Ticket', 3, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:32:34'),
(188, 9, 'ticket.status_changed', 'Ticket', 3, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:32:34'),
(189, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 09:30:15'),
(190, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 10:01:02'),
(191, 7, 'user.updated', 'User', 7, '{\"name\":\"System Administrator\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[1]}', '{\"name\":\"System Administrator\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,3,6,1]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:24:48');
INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(192, 7, 'ticket.deleted', 'Ticket', 2, '{\"ticket_no\":\"RQ-2\",\"subject\":\"Email Password reset\"}', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:26:05'),
(193, 7, 'ticket.deleted', 'Ticket', 1, '{\"ticket_no\":\"RQ-1\",\"subject\":\"New user need\"}', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:26:18'),
(194, 7, 'ticket.status_changed', 'Ticket', 3, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:27:35'),
(195, 7, 'user.updated', 'User', 3, '{\"name\":\"Accounts Head\",\"email\":\"acct_head@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":2,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":true,\"role_ids\":[5]}', '{\"name\":\"Accounts Head\",\"email\":\"acct_head@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"2\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":true,\"role_ids\":[5]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:28:32'),
(196, 7, 'user.updated', 'User', 1, '{\"name\":\"Accounts User\",\"email\":\"acct_user@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":2,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[4]}', '{\"name\":\"Accounts User\",\"email\":\"acct_user@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"2\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[4]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:28:38'),
(197, 7, 'user.updated', 'User', 4, '{\"name\":\"IT Admin\",\"email\":\"it_admin@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2]}', '{\"name\":\"IT Admin\",\"email\":\"it_admin@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[2]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:28:46'),
(198, 7, 'user.updated', 'User', 5, '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[3]}', '{\"name\":\"IT Employee\",\"email\":\"it_emp@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[3]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:28:55'),
(199, 7, 'user.updated', 'User', 6, '{\"name\":\"Management User\",\"email\":\"sharif99452@gmail.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":null,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[6]}', '{\"name\":\"Management User\",\"email\":\"sharif99452@gmail.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":null,\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:29:12'),
(200, 7, 'user.updated', 'User', 3, '{\"name\":\"Accounts Head\",\"email\":\"acct_head@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":2,\"designation_id\":null,\"location_id\":1,\"is_active\":false,\"is_department_head\":true,\"role_ids\":[5]}', '{\"name\":\"Accounts Head\",\"email\":\"acct_head@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"2\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[5]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:29:26'),
(201, 7, 'user.updated', 'User', 2, '{\"name\":\"Sales User\",\"email\":\"sales_user@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":3,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[4]}', '{\"name\":\"Sales User\",\"email\":\"sales_user@joplc.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":\"3\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":false,\"is_department_head\":false,\"role_ids\":[4]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:29:38'),
(202, 7, 'user.updated', 'User', 7, '{\"name\":\"System Administrator\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[1,2,3,6]}', '{\"name\":\"Md Abu Hanife Nayem\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":\"20251341\",\"whatsapp\":\"01521236214\",\"department_id\":\"1\",\"designation_id\":null,\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,3,6,1]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:30:13'),
(203, 7, 'lookup.categories.updated', 'TicketCategory', 4, '{\"name\":\"User & Access\",\"sort_order\":4,\"is_active\":1}', '{\"name\":\"User & Access\",\"sort_order\":\"4\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:34:28'),
(204, 7, 'lookup.categories.updated', 'TicketCategory', 5, '{\"name\":\"IT Service\",\"sort_order\":5,\"is_active\":1}', '{\"name\":\"IT Service\",\"sort_order\":\"5\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:34:30'),
(205, 7, 'lookup.categories.updated', 'TicketCategory', 6, '{\"name\":\"Security\",\"sort_order\":6,\"is_active\":1}', '{\"name\":\"Security\",\"sort_order\":\"6\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:34:31'),
(206, 7, 'lookup.categories.updated', 'TicketCategory', 3, '{\"name\":\"Network\",\"sort_order\":3,\"is_active\":1}', '{\"name\":\"Network\",\"sort_order\":\"3\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:34:34'),
(207, 7, 'lookup.categories.updated', 'TicketCategory', 6, '{\"name\":\"Security\",\"sort_order\":6,\"is_active\":1}', '{\"name\":\"Others\",\"sort_order\":\"6\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:35:39'),
(208, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 8, '{\"category_id\":1,\"name\":\"Network device\",\"is_active\":1}', '{\"category_id\":\"3\",\"name\":\"Network device (Router, Switch etc.)\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:37:27'),
(209, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 11, '{\"category_id\":2,\"name\":\"ERP\",\"is_active\":1}', '{\"category_id\":\"2\",\"name\":\"OLD ERP (Hawlader)\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:38:19'),
(210, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 16, '{\"category_id\":2,\"name\":\"Windows\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Windows\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:38:36'),
(211, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 17, '{\"category_id\":2,\"name\":\"Office\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Office\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:38:46'),
(212, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 18, '{\"category_id\":2,\"name\":\"Antivirus\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Antivirus\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:38:54'),
(213, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 19, '{\"category_id\":2,\"name\":\"Database\",\"is_active\":1}', '{\"category_id\":\"2\",\"name\":\"Database\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:39:39'),
(214, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 20, '{\"category_id\":2,\"name\":\"Application\",\"is_active\":1}', '{\"category_id\":\"2\",\"name\":\"Application\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:39:45'),
(215, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 21, '{\"category_id\":2,\"name\":\"Other\",\"is_active\":1}', '{\"category_id\":\"2\",\"name\":\"Others\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:39:56'),
(216, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 31, '{\"category_id\":4,\"name\":\"New user\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Email\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:40:51'),
(217, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 32, '{\"category_id\":4,\"name\":\"Password reset\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"D-Nothi\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:41:05'),
(218, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 33, '{\"category_id\":4,\"name\":\"Account locked\",\"is_active\":1}', '{\"category_id\":\"2\",\"name\":\"Correction\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:41:37'),
(219, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 43, '{\"category_id\":5,\"name\":\"Training\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Training\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:42:59'),
(220, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 42, '{\"category_id\":5,\"name\":\"Backup\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Backup\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:43:07'),
(221, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 44, '{\"category_id\":5,\"name\":\"Report request\",\"is_active\":1}', '{\"category_id\":\"5\",\"name\":\"Report request\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:43:23'),
(222, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 47, '{\"category_id\":6,\"name\":\"Malware\",\"is_active\":1}', '{\"category_id\":\"6\",\"name\":\"Malware\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:44:12'),
(223, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 48, '{\"category_id\":6,\"name\":\"Suspicious email\",\"is_active\":1}', '{\"category_id\":\"6\",\"name\":\"Suspicious email\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:44:17'),
(224, 7, 'lookup.subcategories.updated', 'TicketSubcategory', 51, '{\"category_id\":6,\"name\":\"Password\\/security issue\",\"is_active\":1}', '{\"category_id\":\"6\",\"name\":\"Password\\/security issue\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:44:30'),
(225, 7, 'lookup.departments.updated', 'Department', 2, '{\"name\":\"Accounts\",\"code\":\"ACC\",\"is_active\":1}', '{\"name\":\"Accounts & Finance\",\"code\":\"ACC\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:46:50'),
(226, 7, 'lookup.departments.updated', 'Department', 3, '{\"name\":\"Sales\",\"code\":\"SAL\",\"is_active\":1}', '{\"name\":\"Sales & Marketing\",\"code\":\"SAL\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:47:00'),
(227, 7, 'lookup.departments.updated', 'Department', 4, '{\"name\":\"HR\",\"code\":\"HR\",\"is_active\":1}', '{\"name\":\"HR & Admin\",\"code\":\"HR\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:47:11'),
(228, 7, 'lookup.departments.updated', 'Department', 5, '{\"name\":\"Marketing\",\"code\":\"MKT\",\"is_active\":1}', '{\"name\":\"Operations\",\"code\":\"MKT\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:47:22'),
(229, 7, 'lookup.departments.updated', 'Department', 6, '{\"name\":\"Administration\",\"code\":\"ADM\",\"is_active\":1}', '{\"name\":\"E & D\",\"code\":\"ADM\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:47:32'),
(230, 7, 'lookup.departments.created', 'Department', 7, NULL, '{\"name\":\"Audit\",\"code\":\"AUD\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:48:03'),
(231, 7, 'lookup.departments.updated', 'Department', 5, '{\"name\":\"Operations\",\"code\":\"MKT\",\"is_active\":1}', '{\"name\":\"Operations\",\"code\":\"OPS\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:48:33'),
(232, 7, 'lookup.departments.updated', 'Department', 6, '{\"name\":\"E & D\",\"code\":\"ADM\",\"is_active\":1}', '{\"name\":\"E & D\",\"code\":\"E&D\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:48:39'),
(233, 7, 'lookup.designations.updated', 'Designation', 1, '{\"name\":\"Officer\",\"is_active\":1}', '{\"name\":\"Officer(MIS & IT)\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:49:31'),
(234, 7, 'lookup.designations.updated', 'Designation', 2, '{\"name\":\"Executive\",\"is_active\":1}', '{\"name\":\"Senior Officer\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:50:18'),
(235, 7, 'lookup.designations.updated', 'Designation', 1, '{\"name\":\"Officer(MIS & IT)\",\"is_active\":1}', '{\"name\":\"Officer\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:50:24'),
(236, 7, 'lookup.designations.created', 'Designation', 7, NULL, '{\"name\":\"Junior Officer\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:50:57'),
(237, 7, 'lookup.designations.created', 'Designation', 8, NULL, '{\"name\":\"Assistant Manager\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:51:20'),
(238, 7, 'lookup.designations.created', 'Designation', 9, NULL, '{\"name\":\"Deputy Manager\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:51:27'),
(239, 7, 'lookup.designations.created', 'Designation', 10, NULL, '{\"name\":\"AGM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:51:39'),
(240, 7, 'lookup.designations.created', 'Designation', 11, NULL, '{\"name\":\"DGM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:51:43'),
(241, 7, 'lookup.designations.created', 'Designation', 12, NULL, '{\"name\":\"GM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:51:47'),
(242, 7, 'user.updated', 'User', 7, '{\"name\":\"Md Abu Hanife Nayem\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":\"20251341\",\"whatsapp\":\"01521236214\",\"department_id\":1,\"designation_id\":null,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[1,2,3,6]}', '{\"name\":\"Md Abu Hanife Nayem\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":\"20251341\",\"whatsapp\":\"01521236214\",\"department_id\":\"1\",\"designation_id\":\"2\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,3,6,1]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:52:44'),
(243, 7, 'user.created', 'User', 16, NULL, '{\"name\":\"Md Tarek Hossain\",\"email\":\"tarek.jocl@gmail.com\",\"employee_id\":\"1357\",\"whatsapp\":\"01844290967\",\"department_id\":\"1\",\"designation_id\":\"7\",\"location_id\":\"1\",\"password_changed_at\":\"2026-10-18T11:55:54.777361Z\",\"role_ids\":[\"2\",\"3\",\"6\"]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:55:54'),
(244, 7, 'user.updated', 'User', 15, '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":1,\"designation_id\":6,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,6]}', '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":\"1\",\"designation_id\":\"6\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,3,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:56:09'),
(245, 7, 'user.created', 'User', 17, NULL, '{\"name\":\"Md Sajjad Hossain\",\"email\":\"sajjad.jocl2020@gmail.com\",\"employee_id\":\"1308\",\"whatsapp\":\"01830310919\",\"department_id\":\"1\",\"designation_id\":\"1\",\"location_id\":\"1\",\"password_changed_at\":\"2026-10-18T11:58:04.562128Z\",\"role_ids\":[\"2\",\"3\",\"6\"]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:58:04'),
(246, 7, 'user.updated', 'User', 6, '{\"name\":\"Management User\",\"email\":\"sharif99452@gmail.com\",\"employee_id\":null,\"whatsapp\":null,\"department_id\":null,\"designation_id\":null,\"location_id\":1,\"is_active\":false,\"is_department_head\":false,\"role_ids\":[6]}', '{\"name\":\"MOHAMMAD SHARIFUL ISLAM\",\"email\":\"sharif99452@gmail.com\",\"employee_id\":\"20070725\",\"whatsapp\":\"01777797319\",\"department_id\":\"1\",\"designation_id\":\"3\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"role_ids\":[2,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:01:06'),
(247, 16, 'ticket.created_on_behalf', 'Ticket', 4, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:11:44'),
(248, 17, 'ticket.team_added', 'Ticket', 4, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:13:32'),
(249, 17, 'ticket.status_changed', 'Ticket', 4, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:13:32'),
(250, 17, 'ticket.assigned', 'Ticket', 4, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:13:32'),
(251, 16, 'ticket.status_changed', 'Ticket', 4, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:14:19'),
(252, 16, 'ticket.status_changed', 'Ticket', 4, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:15:06'),
(253, 16, 'ticket.status_changed', 'Ticket', 4, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:15:06'),
(254, 17, 'ticket.status_changed', 'Ticket', 4, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:15:31'),
(255, 7, 'ticket.created', 'Ticket', 5, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:29:09'),
(256, 17, 'ticket.created', 'Ticket', 6, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:25:52'),
(257, 17, 'ticket.team_added', 'Ticket', 6, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:11'),
(258, 17, 'ticket.status_changed', 'Ticket', 6, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:11'),
(259, 17, 'ticket.assigned', 'Ticket', 6, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:11'),
(260, 11, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:34'),
(261, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:27:23'),
(262, 7, 'ticket.deleted', 'Ticket', 5, '{\"ticket_no\":\"RQ-5\",\"subject\":\"ht\"}', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:29:23'),
(263, 7, 'ticket.deleted', 'Ticket', 4, '{\"ticket_no\":\"RQ-4\",\"subject\":\"Tax Report\"}', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:29:36'),
(264, 12, 'ticket.status_changed', 'Ticket', 6, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:35:17'),
(265, 7, 'user.updated', 'User', 7, '{\"name\":\"Md Abu Hanife Nayem\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":\"20251341\",\"whatsapp\":\"01521236214\",\"department_id\":1,\"designation_id\":2,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":true,\"role_ids\":[1,2,3,6]}', '{\"name\":\"Md Abu Hanife Nayem\",\"email\":\"nayem.jocl@gmail.com\",\"employee_id\":\"20251341\",\"whatsapp\":\"01521236214\",\"department_id\":\"1\",\"designation_id\":\"2\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":false,\"role_ids\":[2,3,6,1]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:47:33'),
(266, 7, 'user.updated', 'User', 17, '{\"name\":\"Md Sajjad Hossain\",\"email\":\"sajjad.jocl2020@gmail.com\",\"employee_id\":\"1308\",\"whatsapp\":\"01830310919\",\"department_id\":1,\"designation_id\":1,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":true,\"role_ids\":[2,3,6]}', '{\"name\":\"Md Sajjad Hossain\",\"email\":\"sajjad.jocl2020@gmail.com\",\"employee_id\":\"1308\",\"whatsapp\":\"01830310919\",\"department_id\":\"1\",\"designation_id\":\"1\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":false,\"role_ids\":[2,3,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:47:40'),
(267, 7, 'user.updated', 'User', 16, '{\"name\":\"Md Tarek Hossain\",\"email\":\"tarek.jocl@gmail.com\",\"employee_id\":\"1357\",\"whatsapp\":\"01844290967\",\"department_id\":1,\"designation_id\":7,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":true,\"role_ids\":[2,3,6]}', '{\"name\":\"Md Tarek Hossain\",\"email\":\"tarek.jocl@gmail.com\",\"employee_id\":\"1357\",\"whatsapp\":\"01844290967\",\"department_id\":\"1\",\"designation_id\":\"7\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":false,\"role_ids\":[2,3,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:47:46'),
(268, 7, 'user.updated', 'User', 15, '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":1,\"designation_id\":6,\"location_id\":1,\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":true,\"role_ids\":[2,3,6]}', '{\"name\":\"YEASMIN ARA CHOWDHURY\",\"email\":\"yeasminsoma0@gmail.com\",\"employee_id\":\"20051090\",\"whatsapp\":\"01866823255\",\"department_id\":\"1\",\"designation_id\":\"6\",\"location_id\":\"1\",\"is_active\":true,\"is_department_head\":false,\"show_in_attendance\":false,\"role_ids\":[2,3,6]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:47:53'),
(269, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:12:50'),
(270, 7, 'user.avatar_changed', 'User', 7, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:15:35'),
(271, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:15:47'),
(272, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:16:04'),
(273, 7, 'lookup.service_types.created', 'TicketType', 6, NULL, '{\"name\":\"Development Request\",\"code\":\"DEV\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:42:40'),
(274, 7, 'lookup.service_types.created', 'TicketType', 7, NULL, '{\"name\":\"Maintenance\",\"code\":\"MAIN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:42:52'),
(275, 7, 'lookup.service_types.created', 'TicketType', 8, NULL, '{\"name\":\"Procurement Request\",\"code\":\"ITP\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:43:31'),
(276, 7, 'lookup.service_types.created', 'TicketType', 9, NULL, '{\"name\":\"Consultancy\",\"code\":\"CON\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:43:52'),
(277, 7, 'lookup.service_types.created', 'TicketType', 10, NULL, '{\"name\":\"IT Training\",\"code\":\"ITT\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:44:03'),
(278, 12, 'ticket.status_changed', 'Ticket', 6, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:06:20'),
(279, 12, 'ticket.status_changed', 'Ticket', 6, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:06:20'),
(280, 17, 'ticket.status_changed', 'Ticket', 6, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:07:01'),
(281, 17, 'ticket.created', 'Ticket', 7, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:08:26'),
(282, 17, 'ticket.team_added', 'Ticket', 7, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:09:17'),
(283, 17, 'ticket.status_changed', 'Ticket', 7, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:09:17'),
(284, 17, 'ticket.assigned', 'Ticket', 7, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:09:17'),
(285, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:13:25'),
(286, 7, 'lookup.service_types.created', 'TicketType', 11, NULL, '{\"name\":\"Data Entry\",\"code\":\"DAT\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:14:29'),
(287, 7, 'lookup.service_types.updated', 'TicketType', 5, '{\"name\":\"IT Asset Request\",\"code\":\"AST\",\"is_active\":1}', '{\"name\":\"IT Device Request\",\"code\":\"AST\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:14:41'),
(288, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-19 05:15:28'),
(289, 7, 'lookup.subcategories.created', 'TicketSubcategory', 52, NULL, '{\"category_id\":\"2\",\"name\":\"PMS(IT Service Desk)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:15:56'),
(290, 7, 'ticket.created', 'Ticket', 8, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:20:46'),
(291, 7, 'ticket.team_added', 'Ticket', 8, '{\"team\":null}', '{\"team\":\"YEASMIN ARA CHOWDHURY (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:21:00'),
(292, 7, 'ticket.status_changed', 'Ticket', 8, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:21:00'),
(293, 7, 'ticket.assigned', 'Ticket', 8, '{\"assigned_to\":null}', '{\"assigned_to\":\"YEASMIN ARA CHOWDHURY\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:21:00'),
(294, 7, 'lookup.service_types.created', 'TicketType', 12, NULL, '{\"name\":\"Departmental Services\",\"code\":\"DPS\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:23:04'),
(295, 7, 'ticket.created', 'Ticket', 9, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:25:41'),
(296, 7, 'ticket.team_added', 'Ticket', 9, '{\"team\":null}', '{\"team\":\"YEASMIN ARA CHOWDHURY (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:26:51'),
(297, 7, 'ticket.status_changed', 'Ticket', 9, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:26:51'),
(298, 7, 'ticket.assigned', 'Ticket', 9, '{\"assigned_to\":null}', '{\"assigned_to\":\"YEASMIN ARA CHOWDHURY\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:26:51'),
(299, 12, 'ticket.status_changed', 'Ticket', 7, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:31:44'),
(300, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:12:45'),
(301, 12, 'ticket.status_changed', 'Ticket', 7, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:35:18'),
(302, 12, 'ticket.status_changed', 'Ticket', 7, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:35:18'),
(303, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:36:50'),
(304, 17, 'ticket.status_changed', 'Ticket', 7, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:43:55'),
(305, 17, 'lookup.subcategories.created', 'TicketSubcategory', 53, NULL, '{\"category_id\":\"6\",\"name\":\"Note Draft\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:59:41'),
(306, 17, 'ticket.created', 'Ticket', 10, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:00:24'),
(307, 17, 'ticket.team_added', 'Ticket', 10, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:01:00'),
(308, 17, 'ticket.status_changed', 'Ticket', 10, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:01:00'),
(309, 17, 'ticket.assigned', 'Ticket', 10, '{\"assigned_to\":null}', '{\"assigned_to\":\"ISRAT JAHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:01:00'),
(310, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:03:17'),
(311, 17, 'ticket.created', 'Ticket', 11, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:25:32'),
(312, 17, 'ticket.team_added', 'Ticket', 11, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:25:41'),
(313, 17, 'ticket.status_changed', 'Ticket', 11, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:25:41'),
(314, 17, 'ticket.assigned', 'Ticket', 11, '{\"assigned_to\":null}', '{\"assigned_to\":\"ISRAT JAHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:25:41'),
(315, 7, 'ticket.created', 'Ticket', 12, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:26:50'),
(316, 7, 'ticket.team_added', 'Ticket', 12, '{\"team\":null}', '{\"team\":\"MEHEDI RAIHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:29:29'),
(317, 7, 'ticket.team_added', 'Ticket', 12, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:29:29'),
(318, 7, 'ticket.team_added', 'Ticket', 12, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:29:29'),
(319, 7, 'ticket.team_added', 'Ticket', 12, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:29:29'),
(320, 7, 'ticket.status_changed', 'Ticket', 12, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:29:29'),
(321, 7, 'ticket.assigned', 'Ticket', 12, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:29:29'),
(322, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:30:48'),
(323, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 08:51:58'),
(324, 9, 'ticket.status_changed', 'Ticket', 10, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:08:23'),
(325, 9, 'ticket.status_changed', 'Ticket', 10, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:09:15'),
(326, 9, 'ticket.status_changed', 'Ticket', 10, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:09:15'),
(327, 9, 'ticket.status_changed', 'Ticket', 11, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:09:36'),
(328, 17, 'ticket.status_changed', 'Ticket', 10, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:09:46'),
(329, 9, 'ticket.status_changed', 'Ticket', 11, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:09:46'),
(330, 9, 'ticket.status_changed', 'Ticket', 11, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:09:46'),
(331, 17, 'ticket.status_changed', 'Ticket', 11, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:10:03'),
(332, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:37:21'),
(333, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 11:49:24'),
(334, 12, 'ticket.status_changed', 'Ticket', 12, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 11:51:45'),
(335, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 02:48:54'),
(336, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:15:53'),
(337, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:16:10'),
(338, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:16:25'),
(339, 7, 'ticket.created', 'Ticket', 13, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 04:17:56'),
(340, 7, 'ticket.team_added', 'Ticket', 13, '{\"team\":null}', '{\"team\":\"RAFAT KHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 04:26:38'),
(341, 7, 'ticket.status_changed', 'Ticket', 13, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 04:26:38'),
(342, 7, 'ticket.assigned', 'Ticket', 13, '{\"assigned_to\":null}', '{\"assigned_to\":\"RAFAT KHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 04:26:38'),
(343, 13, 'ticket.status_changed', 'Ticket', 13, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 04:36:48'),
(344, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 04:37:27'),
(345, 7, 'ticket.created', 'Ticket', 14, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:25:59'),
(346, 7, 'ticket.team_added', 'Ticket', 14, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:26:30'),
(347, 7, 'ticket.status_changed', 'Ticket', 14, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:26:30'),
(348, 7, 'ticket.assigned', 'Ticket', 14, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:26:30'),
(349, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 06:24:37'),
(350, 12, 'ticket.status_changed', 'Ticket', 12, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:29:56'),
(351, 12, 'ticket.status_changed', 'Ticket', 12, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:29:56');
INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(352, 12, 'ticket.created', 'Ticket', 15, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:47:58'),
(353, 7, 'ticket.service type_changed', 'Ticket', 15, '{\"service type\":\"Development Request\"}', '{\"service type\":\"Change Request\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:50:07'),
(354, 7, 'ticket.sub-category_changed', 'Ticket', 15, '{\"sub-category\":\"Office\"}', '{\"sub-category\":null}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:50:07'),
(355, 7, 'ticket.team_added', 'Ticket', 15, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:50:39'),
(356, 7, 'ticket.status_changed', 'Ticket', 15, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:50:39'),
(357, 7, 'ticket.assigned', 'Ticket', 15, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:50:39'),
(358, 7, 'ticket.status_changed', 'Ticket', 12, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:51:38'),
(359, 12, 'ticket.status_changed', 'Ticket', 15, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 10:03:24'),
(360, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 10:28:10'),
(361, 7, 'lookup.service_types.updated', 'TicketType', 1, '{\"name\":\"Incident\",\"code\":\"INC\",\"is_active\":1}', '{\"name\":\"IT Service\",\"code\":\"INC\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:25:58'),
(362, 7, 'lookup.service_types.updated', 'TicketType', 2, '{\"name\":\"Service Request\",\"code\":\"SR\",\"is_active\":1}', '{\"name\":\"Incident Report\",\"code\":\"SR\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:26:21'),
(363, 7, 'lookup.service_types.updated', 'TicketType', 12, '{\"name\":\"Departmental Services\",\"code\":\"DPS\",\"is_active\":1}', '{\"name\":\"D\",\"code\":\"DPS\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:27:23'),
(364, 7, 'lookup.service_types.updated', 'TicketType', 6, '{\"name\":\"Development Request\",\"code\":\"DEV\",\"is_active\":1}', '{\"name\":\"Departmental Services\",\"code\":\"DEV\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:27:51'),
(365, 7, 'lookup.service_types.updated', 'TicketType', 7, '{\"name\":\"Maintenance\",\"code\":\"MAIN\",\"is_active\":1}', '{\"name\":\"Development Request\",\"code\":\"MAIN\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:28:22'),
(366, 7, 'lookup.service_types.updated', 'TicketType', 2, '{\"name\":\"Incident Report\",\"code\":\"SR\",\"is_active\":1}', '{\"name\":\"Maintenance\",\"code\":\"SR\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:28:29'),
(367, 7, 'lookup.service_types.updated', 'TicketType', 9, '{\"name\":\"Consultancy\",\"code\":\"CON\",\"is_active\":1}', '{\"name\":\"Incident Report\",\"code\":\"CON\",\"is_active\":true}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:29:02'),
(368, 7, 'ticket.created', 'Ticket', 16, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:32:10'),
(369, 7, 'ticket.team_added', 'Ticket', 16, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:32:21'),
(370, 7, 'ticket.status_changed', 'Ticket', 16, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:32:21'),
(371, 7, 'ticket.assigned', 'Ticket', 16, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:32:21'),
(372, 7, 'ticket.created', 'Ticket', 17, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:35:46'),
(373, 7, 'ticket.team_added', 'Ticket', 17, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:35:59'),
(374, 7, 'ticket.status_changed', 'Ticket', 17, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:35:59'),
(375, 7, 'ticket.assigned', 'Ticket', 17, '{\"assigned_to\":null}', '{\"assigned_to\":\"ISRAT JAHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:35:59'),
(376, 16, 'ticket.created_on_behalf', 'Ticket', 18, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:43:21'),
(377, 16, 'ticket.team_added', 'Ticket', 18, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:44:06'),
(378, 16, 'ticket.team_added', 'Ticket', 18, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:44:06'),
(379, 16, 'ticket.status_changed', 'Ticket', 18, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:44:06'),
(380, 16, 'ticket.assigned', 'Ticket', 18, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:44:06'),
(381, 16, 'ticket.status_changed', 'Ticket', 18, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:44:26'),
(382, 16, 'ticket.status_changed', 'Ticket', 18, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:45:33'),
(383, 16, 'ticket.status_changed', 'Ticket', 18, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:45:33'),
(384, 16, 'ticket.status_changed', 'Ticket', 18, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:46:09'),
(385, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 02:44:41'),
(386, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:04:23'),
(387, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:04:35'),
(388, 16, 'ticket.status_changed', 'Ticket', 14, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:17:19'),
(389, 12, 'ticket.status_changed', 'Ticket', 16, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:44:08'),
(390, 9, 'ticket.status_changed', 'Ticket', 17, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 04:03:14'),
(391, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:23:29'),
(392, 7, 'ticket.created', 'Ticket', 19, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:36:33'),
(393, 7, 'ticket.team_added', 'Ticket', 19, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:36:47'),
(394, 7, 'ticket.team_added', 'Ticket', 19, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:36:47'),
(395, 7, 'ticket.status_changed', 'Ticket', 19, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:36:47'),
(396, 7, 'ticket.assigned', 'Ticket', 19, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:36:47'),
(397, 7, 'ticket.created', 'Ticket', 20, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:41:51'),
(398, 7, 'ticket.team_added', 'Ticket', 20, '{\"team\":null}', '{\"team\":\"TULI NANDY (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:42:13'),
(399, 7, 'ticket.status_changed', 'Ticket', 20, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:42:13'),
(400, 7, 'ticket.assigned', 'Ticket', 20, '{\"assigned_to\":null}', '{\"assigned_to\":\"TULI NANDY\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:42:13'),
(401, 7, 'ticket.created', 'Ticket', 21, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:06:40'),
(402, 7, 'ticket.team_added', 'Ticket', 21, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:06:51'),
(403, 7, 'ticket.status_changed', 'Ticket', 21, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:06:51'),
(404, 7, 'ticket.assigned', 'Ticket', 21, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. RAZAUL KARIM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:06:51'),
(405, 16, 'ticket.status_changed', 'Ticket', 19, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:35:16'),
(406, 13, 'ticket.comment_added', 'Ticket', 13, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 06:32:15'),
(407, 7, 'attachment.download', 'TicketAttachment', 1, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:40:57'),
(408, 11, 'ticket.status_changed', 'Ticket', 21, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:58:15'),
(409, 11, 'ticket.status_changed', 'Ticket', 21, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:58:41'),
(410, 11, 'ticket.status_changed', 'Ticket', 21, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:58:41'),
(411, 16, 'ticket.status_changed', 'Ticket', 19, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:01:37'),
(412, 16, 'ticket.status_changed', 'Ticket', 19, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:01:37'),
(413, 16, 'ticket.status_changed', 'Ticket', 19, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:02:36'),
(414, 12, 'ticket.status_changed', 'Ticket', 15, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:09:15'),
(415, 12, 'ticket.status_changed', 'Ticket', 15, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:09:15'),
(416, 12, 'ticket.status_changed', 'Ticket', 16, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:10:13'),
(417, 12, 'ticket.status_changed', 'Ticket', 16, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:10:13'),
(418, 12, 'ticket.created', 'Ticket', 22, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:15:50'),
(419, 7, 'ticket.team_added', 'Ticket', 22, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:19:40'),
(420, 7, 'ticket.status_changed', 'Ticket', 22, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:19:40'),
(421, 7, 'ticket.assigned', 'Ticket', 22, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:19:40'),
(422, 7, 'ticket.comment_added', 'Ticket', 22, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:21:43'),
(423, 12, 'ticket.created', 'Ticket', 23, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:21:46'),
(424, 12, 'ticket.status_changed', 'Ticket', 22, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:22:18'),
(425, 7, 'ticket.team_added', 'Ticket', 23, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:24:15'),
(426, 7, 'ticket.status_changed', 'Ticket', 23, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:24:15'),
(427, 7, 'ticket.assigned', 'Ticket', 23, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:24:15'),
(428, 12, 'ticket.created', 'Ticket', 24, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:24:49'),
(429, 12, 'ticket.status_changed', 'Ticket', 23, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:25:01'),
(430, 7, 'ticket.comment_added', 'Ticket', 23, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:25:37'),
(431, 7, 'ticket.team_added', 'Ticket', 24, '{\"team\":null}', '{\"team\":\"MEHEDI RAIHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:26:35'),
(432, 7, 'ticket.team_added', 'Ticket', 24, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:26:35'),
(433, 7, 'ticket.status_changed', 'Ticket', 24, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:26:35'),
(434, 7, 'ticket.assigned', 'Ticket', 24, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:26:35'),
(435, 7, 'ticket.comment_added', 'Ticket', 24, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:28:42'),
(436, 7, 'ticket.status_changed', 'Ticket', 21, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:18:04'),
(437, 9, 'ticket.status_changed', 'Ticket', 17, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 08:18:06'),
(438, 9, 'ticket.status_changed', 'Ticket', 17, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 08:18:06'),
(439, 7, 'ticket.status_changed', 'Ticket', 15, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:20:44'),
(440, 7, 'ticket.status_changed', 'Ticket', 16, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:20:52'),
(441, 7, 'ticket.status_changed', 'Ticket', 17, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:21:04'),
(442, 7, 'ticket.created', 'Ticket', 25, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:30:19'),
(443, 7, 'ticket.team_added', 'Ticket', 25, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:30:50'),
(444, 7, 'ticket.team_added', 'Ticket', 25, '{\"team\":null}', '{\"team\":\"TULI NANDY (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:30:50'),
(445, 7, 'ticket.status_changed', 'Ticket', 25, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:30:50'),
(446, 7, 'ticket.assigned', 'Ticket', 25, '{\"assigned_to\":null}', '{\"assigned_to\":\"ISRAT JAHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:30:50'),
(447, 9, 'ticket.status_changed', 'Ticket', 25, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 08:47:04'),
(448, 10, 'ticket.status_changed', 'Ticket', 20, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 09:11:20'),
(449, 13, 'ticket.work_update', 'Ticket', 13, '{\"work_status\":\"IN_PROGRESS\"}', '{\"work_status\":\"DONE\",\"note\":null}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 09:24:00'),
(450, 13, 'ticket.status_changed', 'Ticket', 13, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 09:24:57'),
(451, 13, 'ticket.status_changed', 'Ticket', 13, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 09:24:57'),
(452, 7, 'ticket.status_changed', 'Ticket', 13, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 09:34:34'),
(453, 12, 'ticket.status_changed', 'Ticket', 22, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 10:20:48'),
(454, 12, 'ticket.status_changed', 'Ticket', 22, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 10:20:48'),
(455, 10, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 10:49:00'),
(456, 7, 'ticket.status_changed', 'Ticket', 22, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 11:04:21'),
(457, 7, 'lookup.service_types.updated', 'TicketType', 12, '{\"name\":\"D\",\"code\":\"DPS\",\"is_active\":0}', '{\"name\":\"Document Preparation\",\"code\":\"DPS\",\"is_active\":false}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 11:08:45'),
(458, 7, 'ticket.created', 'Ticket', 26, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:13:46'),
(459, 12, 'ticket.status_changed', 'Ticket', 23, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:14:21'),
(460, 12, 'ticket.status_changed', 'Ticket', 23, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:14:21'),
(461, 7, 'ticket.team_added', 'Ticket', 26, '{\"team\":null}', '{\"team\":\"Md Abu Hanife Nayem (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(462, 7, 'ticket.team_added', 'Ticket', 26, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(463, 7, 'ticket.team_added', 'Ticket', 26, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(464, 7, 'ticket.team_added', 'Ticket', 26, '{\"team\":null}', '{\"team\":\"RAFAT KHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(465, 7, 'ticket.team_added', 'Ticket', 26, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(466, 7, 'ticket.team_added', 'Ticket', 26, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(467, 7, 'ticket.status_changed', 'Ticket', 26, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(468, 7, 'ticket.assigned', 'Ticket', 26, '{\"assigned_to\":null}', '{\"assigned_to\":\"RAFAT KHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:15:56'),
(469, 12, 'ticket.status_changed', 'Ticket', 24, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:16:04'),
(470, 7, 'ticket.status_changed', 'Ticket', 23, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:18:01'),
(471, 12, 'ticket.comment_added', 'Ticket', 24, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:20:16'),
(472, 7, 'user.avatar_removed', 'User', 7, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:50:45'),
(473, 7, 'user.avatar_changed', 'User', 7, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:51:08'),
(474, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:53:54'),
(475, 12, 'user.avatar_changed', 'User', 12, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:54:31'),
(476, 12, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:55:18'),
(477, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 02:48:56'),
(478, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:17:02'),
(479, 13, 'ticket.status_changed', 'Ticket', 26, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:17:45'),
(480, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:17:49'),
(481, 16, 'user.avatar_changed', 'User', 16, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:50:16'),
(482, 16, 'ticket.status_changed', 'Ticket', 14, '{\"status\":\"In Progress\"}', '{\"status\":\"On Hold\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 04:01:09'),
(483, 16, 'ticket.created_on_behalf', 'Ticket', 27, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:03:28'),
(484, 16, 'ticket.team_added', 'Ticket', 27, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:04:14'),
(485, 16, 'ticket.status_changed', 'Ticket', 27, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:04:14'),
(486, 16, 'ticket.assigned', 'Ticket', 27, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:04:14'),
(487, 16, 'ticket.status_changed', 'Ticket', 27, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:04:26'),
(488, 7, 'ticket.comment_added', 'Ticket', 20, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 06:49:12'),
(489, 7, 'user.created', 'User', 18, NULL, '{\"name\":\"MOHAMMAD MAHFUZUR RAHMAN\",\"email\":\"mahfuz.rahman@jamunaoil.gov.bd\",\"employee_id\":\"20251345\",\"whatsapp\":\"01863356933\",\"department_id\":\"2\",\"designation_id\":\"1\",\"location_id\":\"1\",\"password_changed_at\":\"2026-10-27T08:41:13.482875Z\",\"role_ids\":[\"4\"]}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 08:41:13'),
(490, 7, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 08:42:09'),
(491, 17, 'ticket.created', 'Ticket', 28, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:34:44'),
(492, 17, 'ticket.team_added', 'Ticket', 28, '{\"team\":null}', '{\"team\":\"ISRAT JAHAN (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:35:54'),
(493, 17, 'ticket.status_changed', 'Ticket', 28, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:35:54'),
(494, 17, 'ticket.assigned', 'Ticket', 28, '{\"assigned_to\":null}', '{\"assigned_to\":\"ISRAT JAHAN\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:35:54'),
(495, 9, 'ticket.status_changed', 'Ticket', 28, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 09:38:43'),
(496, 10, 'ticket.status_changed', 'Ticket', 20, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:46:42'),
(497, 10, 'ticket.status_changed', 'Ticket', 20, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:46:42'),
(498, 17, 'ticket.created', 'Ticket', 29, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:53:59'),
(499, 17, 'ticket.team_added', 'Ticket', 29, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:54:25'),
(500, 17, 'ticket.status_changed', 'Ticket', 29, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:54:25'),
(501, 17, 'ticket.assigned', 'Ticket', 29, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Sajjad Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:54:25'),
(502, 17, 'ticket.status_changed', 'Ticket', 29, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:54:28'),
(503, 17, 'ticket.created', 'Ticket', 30, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:56:33'),
(504, 17, 'ticket.team_added', 'Ticket', 30, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:56:47'),
(505, 17, 'ticket.status_changed', 'Ticket', 30, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:56:47'),
(506, 17, 'ticket.assigned', 'Ticket', 30, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Sajjad Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:56:47'),
(507, 17, 'ticket.status_changed', 'Ticket', 30, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:56:49'),
(508, 17, 'ticket.created', 'Ticket', 31, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:58:06'),
(509, 17, 'ticket.team_added', 'Ticket', 31, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:58:22'),
(510, 17, 'ticket.status_changed', 'Ticket', 31, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:58:22'),
(511, 17, 'ticket.assigned', 'Ticket', 31, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Sajjad Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:58:22'),
(512, 17, 'ticket.status_changed', 'Ticket', 31, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:58:42'),
(513, 9, 'ticket.status_changed', 'Ticket', 28, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:00:17'),
(514, 9, 'ticket.status_changed', 'Ticket', 28, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:00:17'),
(515, 17, 'ticket.created', 'Ticket', 32, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:00:50'),
(516, 13, 'ticket.comment_added', 'Ticket', 26, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:02:13'),
(517, 13, 'ticket.comment_added', 'Ticket', 26, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:02:13'),
(518, 17, 'ticket.created', 'Ticket', 33, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:02:44'),
(519, 17, 'ticket.team_added', 'Ticket', 33, '{\"team\":null}', '{\"team\":\"Md Abu Hanife Nayem (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:02:53'),
(520, 17, 'ticket.status_changed', 'Ticket', 33, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:02:53'),
(521, 17, 'ticket.assigned', 'Ticket', 33, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Abu Hanife Nayem\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:02:53'),
(522, 13, 'ticket.work_update', 'Ticket', 26, '{\"work_status\":\"IN_PROGRESS\"}', '{\"work_status\":\"IN_PROGRESS\",\"note\":\"I have completed two items on the list today.\\r\\nDesktop ( CPU) & Monitor\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:02:59'),
(523, 17, 'ticket.status_changed', 'Ticket', 28, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:05:16'),
(524, 17, 'ticket.team_added', 'Ticket', 32, '{\"team\":null}', '{\"team\":\"Md Abu Hanife Nayem (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:08:28'),
(525, 17, 'ticket.status_changed', 'Ticket', 32, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:08:28'),
(526, 17, 'ticket.assigned', 'Ticket', 32, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Abu Hanife Nayem\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:08:28'),
(527, 7, 'ticket.status_changed', 'Ticket', 32, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:15:42'),
(528, 7, 'ticket.status_changed', 'Ticket', 33, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:15:49'),
(529, 7, 'ticket.status_changed', 'Ticket', 20, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:16:30'),
(530, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:18:50'),
(531, 10, 'ticket.comment_added', 'Ticket', 20, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:22:20'),
(532, 17, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 12:28:40'),
(533, 18, 'user.password_changed', 'User', 18, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 13:40:17'),
(534, 18, 'ticket.created', 'Ticket', 34, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 13:47:25'),
(535, 18, 'user.avatar_changed', 'User', 18, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 13:48:31'),
(536, 18, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 13:48:43'),
(537, 8, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 02:35:12'),
(538, 14, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:09:52'),
(539, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:10:30'),
(540, 17, 'lookup.service_types.created', 'TicketType', 13, NULL, '{\"name\":\"REPORT GENERATION\",\"code\":\"RG\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:20:14'),
(541, 17, 'ticket.created', 'Ticket', 35, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:22:22'),
(542, 17, 'ticket.team_added', 'Ticket', 35, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:22:34'),
(543, 17, 'ticket.status_changed', 'Ticket', 35, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:22:34'),
(544, 17, 'ticket.assigned', 'Ticket', 35, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Sajjad Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:22:34'),
(545, 17, 'ticket.status_changed', 'Ticket', 35, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:22:40'),
(546, 7, 'ticket.status_changed', 'Ticket', 34, '{\"status\":\"New\"}', '{\"status\":\"Acknowledged\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:39:27'),
(547, 13, 'logout', NULL, NULL, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:55:50'),
(548, 16, 'ticket.created', 'Ticket', 36, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:56:27');
INSERT INTO `audit_logs` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(549, 16, 'ticket.team_added', 'Ticket', 36, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:56:38'),
(550, 16, 'ticket.status_changed', 'Ticket', 36, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:56:38'),
(551, 16, 'ticket.assigned', 'Ticket', 36, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. RAZAUL KARIM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:56:38'),
(552, 17, 'ticket.created', 'Ticket', 37, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:04:40'),
(553, 17, 'ticket.team_added', 'Ticket', 37, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:04:55'),
(554, 17, 'ticket.status_changed', 'Ticket', 37, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:04:55'),
(555, 17, 'ticket.assigned', 'Ticket', 37, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Sajjad Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:04:55'),
(556, 17, 'ticket.status_changed', 'Ticket', 37, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:05:02'),
(557, 17, 'ticket.created', 'Ticket', 38, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:08:18'),
(558, 17, 'ticket.team_added', 'Ticket', 38, '{\"team\":null}', '{\"team\":\"Md Sajjad Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:08:29'),
(559, 17, 'ticket.status_changed', 'Ticket', 38, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:08:29'),
(560, 17, 'ticket.assigned', 'Ticket', 38, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Sajjad Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:08:29'),
(561, 17, 'ticket.status_changed', 'Ticket', 35, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:20:14'),
(562, 17, 'ticket.status_changed', 'Ticket', 35, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:20:14'),
(563, 17, 'ticket.status_changed', 'Ticket', 35, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:20:19'),
(564, 7, 'lookup.subcategories.created', 'TicketSubcategory', 54, NULL, '{\"category_id\":\"5\",\"name\":\"Website Update\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:20:32'),
(565, 12, 'ticket.created', 'Ticket', 39, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:31:07'),
(566, 7, 'ticket.team_added', 'Ticket', 39, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:31:27'),
(567, 7, 'ticket.status_changed', 'Ticket', 39, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:31:27'),
(568, 7, 'ticket.assigned', 'Ticket', 39, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:31:27'),
(569, 12, 'ticket.status_changed', 'Ticket', 39, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:31:44'),
(570, 11, 'ticket.status_changed', 'Ticket', 36, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:20:03'),
(571, 11, 'ticket.status_changed', 'Ticket', 36, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:20:10'),
(572, 11, 'ticket.status_changed', 'Ticket', 36, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:20:10'),
(573, 11, 'ticket.comment_added', 'Ticket', 26, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:20:49'),
(574, 12, 'ticket.status_changed', 'Ticket', 39, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 06:01:00'),
(575, 12, 'ticket.status_changed', 'Ticket', 39, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 06:01:01'),
(576, 7, 'ticket.status_changed', 'Ticket', 39, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 06:44:34'),
(577, 13, 'ticket.comment_added', 'Ticket', 26, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 08:59:02'),
(578, 16, 'ticket.created', 'Ticket', 40, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:02:52'),
(579, 16, 'ticket.team_added', 'Ticket', 40, '{\"team\":null}', '{\"team\":\"Md Tarek Hossain (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:03:02'),
(580, 16, 'ticket.status_changed', 'Ticket', 40, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:03:02'),
(581, 16, 'ticket.assigned', 'Ticket', 40, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:03:02'),
(582, 16, 'ticket.status_changed', 'Ticket', 40, '{\"status\":\"Assigned\"}', '{\"status\":\"In Progress\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:03:08'),
(583, 16, 'ticket.status_changed', 'Ticket', 40, '{\"status\":\"In Progress\"}', '{\"status\":\"Resolved\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:35:50'),
(584, 16, 'ticket.status_changed', 'Ticket', 40, '{\"status\":\"Resolved\"}', '{\"status\":\"User Confirmation\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:35:50'),
(585, 16, 'ticket.status_changed', 'Ticket', 40, '{\"status\":\"User Confirmation\"}', '{\"status\":\"Closed\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:36:01'),
(586, 13, 'ticket.comment_added', 'Ticket', 26, NULL, NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:57:26'),
(587, 13, 'ticket.work_update', 'Ticket', 26, '{\"work_status\":\"IN_PROGRESS\"}', '{\"work_status\":\"IN_PROGRESS\",\"note\":\"PRINTER,SCANER,MOUSE,UPS,APPLICATION SERVER,LAPTOP LIST DONE.\"}', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:58:56'),
(588, 17, 'ticket.created', 'Ticket', 41, NULL, NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:47:29'),
(589, 17, 'ticket.team_added', 'Ticket', 41, '{\"team\":null}', '{\"team\":\"MEHEDI RAIHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:48:26'),
(590, 17, 'ticket.team_added', 'Ticket', 41, '{\"team\":null}', '{\"team\":\"MD. RAZAUL KARIM (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:48:26'),
(591, 17, 'ticket.team_added', 'Ticket', 41, '{\"team\":null}', '{\"team\":\"MD. MAHABUB ALAM (Primary)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:48:26'),
(592, 17, 'ticket.team_added', 'Ticket', 41, '{\"team\":null}', '{\"team\":\"RAFAT KHAN (Supporting)\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:48:26'),
(593, 17, 'ticket.status_changed', 'Ticket', 41, '{\"status\":\"New\"}', '{\"status\":\"Assigned\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:48:26'),
(594, 17, 'ticket.assigned', 'Ticket', 41, '{\"assigned_to\":null}', '{\"assigned_to\":\"MD. MAHABUB ALAM\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('it-service-desk-cache-1574bddb75c78a6fd2251d61e2993b5146201319', 'i:1;', 1793073076),
('it-service-desk-cache-1574bddb75c78a6fd2251d61e2993b5146201319:timer', 'i:1793073076;', 1793073076),
('it-service-desk-cache-7b52009b64fd0a2a49e6d8a939753077792b0554', 'i:1;', 1793019331),
('it-service-desk-cache-7b52009b64fd0a2a49e6d8a939753077792b0554:timer', 'i:1793019331;', 1793019331),
('it-service-desk-cache-902ba3cda1883801594b6e1b452790cc53948fda', 'i:1;', 1793019128),
('it-service-desk-cache-902ba3cda1883801594b6e1b452790cc53948fda:timer', 'i:1793019128;', 1793019128),
('it-service-desk-cache-91c57bdfefea488995d0c3db6bc743964efec7ed', 'i:1;', 1793181479),
('it-service-desk-cache-91c57bdfefea488995d0c3db6bc743964efec7ed:timer', 'i:1793181479;', 1793181479),
('it-service-desk-cache-9b6eb3d0811ff4a59a35f6362b9628ff71202496', 'i:1;', 1793184424),
('it-service-desk-cache-9b6eb3d0811ff4a59a35f6362b9628ff71202496:timer', 'i:1793184424;', 1793184424),
('it-service-desk-cache-9e6a55b6b4563e652a23be9d623ca5055c356940', 'i:1;', 1793108971),
('it-service-desk-cache-9e6a55b6b4563e652a23be9d623ca5055c356940:timer', 'i:1793108971;', 1793108971),
('it-service-desk-cache-b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'i:1;', 1791713554),
('it-service-desk-cache-b1d5781111d84f7b3fe45a0852e59758cd7a87e5:timer', 'i:1791713554;', 1791713554),
('it-service-desk-cache-e58b18b0f5d4402790da4928a63e26d7913760b9', 'i:1;', 1791780616),
('it-service-desk-cache-e58b18b0f5d4402790da4928a63e26d7913760b9:timer', 'i:1791780616;', 1791780616),
('joplc-it-problem-management-system-cache-424f74a6a7ed4d4ed4761507ebcd209a6ef0937b', 'i:1;', 1791695070),
('joplc-it-problem-management-system-cache-424f74a6a7ed4d4ed4761507ebcd209a6ef0937b:timer', 'i:1791695070;', 1791695070);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'MIS & IT', 'IT', 1, '2026-10-08 06:28:08', '2026-10-11 05:45:13'),
(2, 'Accounts & Finance', 'ACC', 1, '2026-10-08 06:28:08', '2026-10-18 11:46:50'),
(3, 'Sales & Marketing', 'SAL', 1, '2026-10-08 06:28:08', '2026-10-18 11:47:00'),
(4, 'HR & Admin', 'HR', 1, '2026-10-08 06:28:08', '2026-10-18 11:47:11'),
(5, 'Operations', 'OPS', 1, '2026-10-08 06:28:08', '2026-10-18 11:48:33'),
(6, 'E & D', 'E&D', 1, '2026-10-08 06:28:08', '2026-10-18 11:48:39'),
(7, 'Audit', 'AUD', 1, '2026-10-18 11:48:03', '2026-10-18 11:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Officer', 1, '2026-10-08 06:28:08', '2026-10-18 11:50:24'),
(2, 'Senior Officer', 1, '2026-10-08 06:28:08', '2026-10-18 11:50:18'),
(3, 'Manager', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 'Assistant', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(5, 'Assistent Cum Computer Oparetor', 1, '2026-10-08 07:13:57', '2026-10-08 07:13:57'),
(6, 'Sr. ASSTT', 1, '2026-10-11 05:57:23', '2026-10-11 05:57:23'),
(7, 'Junior Officer', 1, '2026-10-18 11:50:57', '2026-10-18 11:50:57'),
(8, 'Assistant Manager', 1, '2026-10-18 11:51:20', '2026-10-18 11:51:20'),
(9, 'Deputy Manager', 1, '2026-10-18 11:51:27', '2026-10-18 11:51:27'),
(10, 'AGM', 1, '2026-10-18 11:51:39', '2026-10-18 11:51:39'),
(11, 'DGM', 1, '2026-10-18 11:51:43', '2026-10-18 11:51:43'),
(12, 'GM', 1, '2026-10-18 11:51:47', '2026-10-18 11:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Head Office', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `login_histories`
--

CREATE TABLE `login_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `email_tried` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `successful` tinyint(1) NOT NULL,
  `event` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'login',
  `reason` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_histories`
--

INSERT INTO `login_histories` (`id`, `user_id`, `email_tried`, `successful`, `event`, `reason`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:28:16'),
(2, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:28:52'),
(3, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:33:14'),
(4, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:36:48'),
(5, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:37:57'),
(6, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:38:43'),
(7, NULL, 'mgmt@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:38:59'),
(8, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:39:23'),
(9, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:39:41'),
(10, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:39:57'),
(11, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:41:04'),
(12, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:43:14'),
(13, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:45:50'),
(14, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:49:39'),
(15, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:54:55'),
(16, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 06:56:34'),
(17, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:03:35'),
(18, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:10:07'),
(19, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 07:12:32'),
(20, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 09:01:07'),
(21, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 09:01:19'),
(22, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 09:01:52'),
(23, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-08 09:05:58'),
(24, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-08 09:33:07'),
(25, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 03:54:09'),
(26, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-09 07:03:44'),
(27, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-10 03:24:53'),
(28, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-10 06:20:20'),
(29, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:18:43'),
(30, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:21:27'),
(31, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:21:37'),
(32, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:21:49'),
(33, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:22:01'),
(34, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:22:21'),
(35, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:23:14'),
(36, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:24:00'),
(37, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:48:07'),
(38, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 03:48:32'),
(39, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:48:35'),
(40, NULL, 'kaziaiyub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:49:33'),
(41, NULL, 'kaziaiyub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:49:50'),
(42, NULL, 'kaziaiyub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:50:35'),
(43, NULL, 'kaziaiyub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:50:45'),
(44, NULL, 'kaziaiub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:50:59'),
(45, NULL, 'kaziaiyub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:51:25'),
(46, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:51:49'),
(47, NULL, 'kaziaiyub6@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 03:51:51'),
(48, NULL, 'kaziaiyub06@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 04:04:30'),
(49, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 04:55:04'),
(50, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 04:56:49'),
(51, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:03:31'),
(52, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:11:32'),
(53, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:11:47'),
(54, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:11:56'),
(55, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:12:22'),
(56, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:14:04'),
(57, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:14:21'),
(58, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 05:22:06'),
(59, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:24:28'),
(60, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:41:54'),
(61, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:42:42'),
(62, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:43:43'),
(63, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 05:52:44'),
(64, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 05:53:18'),
(65, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:01:18'),
(66, 15, 'yeasminsoma0@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:02:26'),
(67, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:02:50'),
(68, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:04:09'),
(69, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 06:04:19'),
(70, 4, 'it_admin@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:35:53'),
(71, 4, 'it_admin@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:36:22'),
(72, 15, 'yeasminsoma0@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 06:36:49'),
(73, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 07:04:14'),
(74, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 07:08:51'),
(75, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 07:17:13'),
(76, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:31:20'),
(77, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:32:17'),
(78, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:54:59'),
(79, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 08:55:05'),
(80, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:00:33'),
(81, 14, 'kaziaiyub6@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:03:02'),
(82, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:04:20'),
(83, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 10:04:42'),
(84, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:06:22'),
(85, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:14:25'),
(86, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:14:34'),
(87, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-11 10:14:47'),
(88, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:04:37'),
(89, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:54:39'),
(90, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:54:45'),
(91, NULL, 'admin@nextpower.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:56:04'),
(92, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-11 11:56:10'),
(93, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 06:19:06'),
(94, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:25:39'),
(95, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:25:46'),
(96, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:31:57'),
(97, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:39:41'),
(98, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 21:37:32'),
(99, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:55:07'),
(100, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 21:39:41'),
(101, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:56:30'),
(102, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:56:41'),
(103, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:56:49'),
(104, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:56:54'),
(105, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:57:09'),
(106, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:57:26'),
(107, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:57:36'),
(108, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:57:46'),
(109, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:57:55'),
(110, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:58:08'),
(111, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 03:59:25'),
(112, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 03:59:27'),
(113, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:00:24'),
(114, 10, 'nandytuli9@gmail.com', 0, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:00:37'),
(115, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:00:48'),
(116, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:01:35'),
(117, 6, 'sharif99452@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:03:25'),
(118, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:04:27'),
(119, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:08:53'),
(120, 6, 'sharif99452@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:15:53'),
(121, 4, 'it_admin@joplc.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 22:02:41'),
(122, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 22:06:12'),
(123, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-11 22:08:42'),
(124, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:30:38'),
(125, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 22:05:44'),
(126, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:48:03'),
(127, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:48:32'),
(128, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:48:50'),
(129, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:49:01'),
(130, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:49:16'),
(131, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '58.145.188.245', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 04:49:20'),
(132, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-12 04:53:12'),
(133, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 05:00:29'),
(134, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 05:00:34'),
(135, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 05:00:55'),
(136, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 05:00:58'),
(137, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-11 23:10:09'),
(138, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-11 23:20:24'),
(139, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:39:23'),
(140, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:42:13'),
(141, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:42:22'),
(142, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:47:54'),
(143, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-12 10:48:01'),
(144, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-13 03:07:00'),
(145, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-13 03:07:12'),
(146, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:08:05'),
(147, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:08:08'),
(148, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:08:17'),
(149, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:08:39'),
(150, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-10-13 03:43:30'),
(151, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-13 04:00:50'),
(152, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-13 04:12:35'),
(153, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-12 22:00:53'),
(154, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-12 22:05:21'),
(155, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-13 10:49:46'),
(156, 4, 'it_admin@joplc.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-13 04:52:40'),
(157, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 02:59:42'),
(158, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 02:59:59'),
(159, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:09:47'),
(160, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:09:55'),
(161, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:10:01'),
(162, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:10:13'),
(163, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:11:30'),
(164, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 03:11:34'),
(165, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 04:03:26'),
(166, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-13 22:03:33'),
(167, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 05:45:09'),
(168, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 09:09:53'),
(169, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-14 03:24:50'),
(170, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-14 13:16:58'),
(171, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:15:53'),
(172, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:16:36'),
(173, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:51:59'),
(174, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:52:04'),
(175, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:52:10'),
(176, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 02:52:12'),
(177, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', '2026-10-15 03:22:22'),
(178, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 03:26:28'),
(179, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-14 21:39:08'),
(180, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 04:13:57'),
(181, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 04:15:30'),
(182, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 04:21:57'),
(183, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-14 22:22:31'),
(184, 6, 'sharif99452@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-14 22:26:10'),
(185, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 14:51:41'),
(186, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 15:03:10'),
(187, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-15 15:03:14'),
(188, 4, 'it_admin@joplc.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-15 15:32:49'),
(189, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-16 04:12:21'),
(190, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-16 04:12:21'),
(191, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-16 07:01:13'),
(192, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-16 07:02:37'),
(193, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:56:46'),
(194, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:57:24'),
(195, 13, 'rafatkhan1988@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:57:30'),
(196, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:57:36'),
(197, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 02:57:49'),
(198, 9, 'israt29190@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 03:38:50'),
(199, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 03:38:56'),
(200, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 03:52:01'),
(201, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 03:53:03'),
(202, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-17 03:53:03'),
(203, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:17:48'),
(204, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:17:55'),
(205, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:18:46'),
(206, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:20:00'),
(207, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:20:04'),
(208, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:27:01'),
(209, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 04:27:09'),
(210, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-17 04:30:35'),
(211, 4, 'it_admin@joplc.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-17 04:43:36'),
(212, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 06:13:59'),
(213, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 06:17:55'),
(214, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 06:17:55'),
(215, 4, 'it_admin@joplc.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-17 06:16:37'),
(216, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 08:29:50'),
(217, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 08:32:01'),
(218, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 08:32:23'),
(219, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 08:32:29'),
(220, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-17 08:32:26'),
(221, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-17 13:56:00'),
(222, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 02:00:25'),
(223, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 02:00:49'),
(224, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 02:56:11'),
(225, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:02:06'),
(226, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:02:12'),
(227, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:02:45'),
(228, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:10:22'),
(229, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:13:52'),
(230, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:22:09'),
(231, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:22:36'),
(232, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:23:56'),
(233, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:24:02'),
(234, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:24:49'),
(235, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:24:53'),
(236, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:11'),
(237, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:15'),
(238, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:30'),
(239, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:25:43'),
(240, 6, 'sharif99452@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:03'),
(241, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:08'),
(242, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:16'),
(243, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:45'),
(244, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:26:57'),
(245, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:27:04'),
(246, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:27:30'),
(247, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:27:34'),
(248, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-18 03:13:52'),
(249, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:29:57'),
(250, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:30:01'),
(251, 6, 'sharif99452@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:30:45'),
(252, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:32:01'),
(253, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:32:16'),
(254, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:32:29');
INSERT INTO `login_histories` (`id`, `user_id`, `email_tried`, `successful`, `event`, `reason`, `ip_address`, `user_agent`, `created_at`) VALUES
(255, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:38:59'),
(256, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:39:03'),
(257, 6, 'sharif99452@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:39:15'),
(258, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:40:20'),
(259, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:40:23'),
(260, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:40:27'),
(261, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:41:11'),
(262, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:41:14'),
(263, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:18'),
(264, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:25'),
(265, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:49'),
(266, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:42:52'),
(267, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:48:35'),
(268, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:48:38'),
(269, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:49:32'),
(270, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:49:37'),
(271, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:50:16'),
(272, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 03:50:22'),
(273, 6, 'sharif99452@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 03:50:22'),
(274, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 03:50:34'),
(275, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 04:20:33'),
(276, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 04:20:57'),
(277, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:45:56'),
(278, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:48:16'),
(279, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:50:01'),
(280, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:50:04'),
(281, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:50:30'),
(282, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:50:32'),
(283, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:53:07'),
(284, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 05:54:30'),
(285, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:25:42'),
(286, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:26:44'),
(287, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:26:49'),
(288, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:29:19'),
(289, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:29:23'),
(290, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:31:48'),
(291, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:32:24'),
(292, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:33:28'),
(293, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:33:33'),
(294, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:34:36'),
(295, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:34:40'),
(296, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:36:13'),
(297, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:36:16'),
(298, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:37:57'),
(299, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:38:01'),
(300, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:41:40'),
(301, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:41:43'),
(302, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:41:51'),
(303, 6, 'sharif99452@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:41:55'),
(304, 6, 'sharif99452@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:43:32'),
(305, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-10-18 06:43:38'),
(306, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 07:12:58'),
(307, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 07:19:26'),
(308, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:12:17'),
(309, 4, 'it_admin@joplc.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 05:57:41'),
(310, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:18:40'),
(311, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:20:19'),
(312, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:22:42'),
(313, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:23:01'),
(314, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:23:39'),
(315, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:23:43'),
(316, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:20'),
(317, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:27'),
(318, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:35'),
(319, 15, 'yeasminsoma0@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:45'),
(320, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:24:53'),
(321, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:25:22'),
(322, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:25:28'),
(323, 15, 'yeasminsoma0@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:25:36'),
(324, 15, 'yeasminsoma0@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:25:36'),
(325, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:26:06'),
(326, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:26:10'),
(327, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:26:58'),
(328, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:27:03'),
(329, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:27:31'),
(330, 4, 'it_admin@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:27:37'),
(331, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 08:12:17'),
(332, 4, 'it_admin@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:29:46'),
(333, 5, 'it_emp@joplc.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:29:48'),
(334, 5, 'it_emp@joplc.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 08:30:16'),
(335, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 09:00:45'),
(336, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 08:46:12'),
(337, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 09:00:52'),
(338, NULL, 'rafatkhan1988@gmail.com123456', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 09:20:48'),
(339, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 09:20:57'),
(340, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 09:30:15'),
(341, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 09:58:51'),
(342, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 10:01:02'),
(343, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 11:20:34'),
(344, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:07:17'),
(345, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:09:57'),
(346, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 12:01:10'),
(347, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-18 12:25:01'),
(348, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-18 12:24:34'),
(349, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 02:52:01'),
(350, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:15:32'),
(351, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:23:56'),
(352, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:24:10'),
(353, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:25:46'),
(354, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:34'),
(355, 4, 'it_admin@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:37'),
(356, 4, 'it_admin@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:40'),
(357, 4, 'it_admin@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:26:55'),
(358, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:27:23'),
(359, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:28:39'),
(360, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:33:11'),
(361, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 03:38:31'),
(362, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 03:31:27'),
(363, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:12:32'),
(364, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 03:57:39'),
(365, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:12:50'),
(366, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:15:47'),
(367, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:15:53'),
(368, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:15:55'),
(369, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:16:04'),
(370, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 04:16:50'),
(371, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 02:52:05'),
(372, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 04:25:37'),
(373, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 04:33:55'),
(374, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:04:05'),
(375, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-19 03:35:17'),
(376, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:05:32'),
(377, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 04:55:47'),
(378, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 04:55:47'),
(379, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:12:50'),
(380, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:13:25'),
(381, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-19 05:15:08'),
(382, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:15:21'),
(383, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-19 05:15:28'),
(384, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 05:07:35'),
(385, 15, 'yeasminsoma0@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:29:54'),
(386, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 05:31:06'),
(387, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 05:18:58'),
(388, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 05:31:44'),
(389, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:06:41'),
(390, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:12:45'),
(391, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:31:20'),
(392, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:36:19'),
(393, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:36:50'),
(394, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 06:43:45'),
(395, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 06:35:18'),
(396, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:03:17'),
(397, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:20:40'),
(398, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 05:35:13'),
(399, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:24:23'),
(400, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 07:30:48'),
(401, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 07:29:43'),
(402, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 08:39:36'),
(403, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 08:43:14'),
(404, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 08:51:58'),
(405, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 08:58:43'),
(406, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:08:00'),
(407, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 09:10:13'),
(408, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:37:03'),
(409, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:37:21'),
(410, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 09:41:58'),
(411, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 09:47:05'),
(412, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 11:49:12'),
(413, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 11:49:24'),
(414, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 11:51:30'),
(415, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 08:40:04'),
(416, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 11:58:18'),
(417, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 11:56:04'),
(418, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 11:59:32'),
(419, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 12:45:32'),
(420, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 12:46:34'),
(421, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-19 13:05:17'),
(422, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-19 13:17:52'),
(423, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-20 03:16:15'),
(424, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-20 03:16:22'),
(425, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-20 04:22:26'),
(426, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-20 04:30:30'),
(427, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-20 06:00:29'),
(428, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-20 06:00:33'),
(429, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-21 03:21:46'),
(430, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-21 03:59:57'),
(431, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-21 04:14:29'),
(432, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 03:52:37'),
(433, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 04:14:29'),
(434, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-22 04:14:37'),
(435, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-23 03:41:01'),
(436, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-23 03:41:37'),
(437, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-24 03:39:00'),
(438, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-24 03:52:54'),
(439, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 02:48:03'),
(440, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 02:48:54'),
(441, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 02:56:03'),
(442, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 02:56:13'),
(443, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:15:38'),
(444, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:15:53'),
(445, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:16:00'),
(446, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:16:10'),
(447, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:16:23'),
(448, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 03:16:25'),
(449, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 03:17:05'),
(450, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 03:30:50'),
(451, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 03:42:11'),
(452, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 03:46:33'),
(453, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 03:53:02'),
(454, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 04:05:00'),
(455, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 04:36:26'),
(456, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 04:37:27'),
(457, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 04:26:47'),
(458, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 04:51:22'),
(459, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:01:14'),
(460, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-25 04:51:30'),
(461, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 05:14:00'),
(462, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 05:01:29'),
(463, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:18:56'),
(464, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-25 05:14:06'),
(465, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 05:46:43'),
(466, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 06:14:13'),
(467, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 06:24:28'),
(468, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 06:24:37'),
(469, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 07:03:24'),
(470, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 07:03:24'),
(471, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 06:21:50'),
(472, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 07:22:47'),
(473, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 07:23:31'),
(474, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 08:17:41'),
(475, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 08:33:51'),
(476, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 08:18:11'),
(477, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 08:35:09'),
(478, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-25 08:33:51'),
(479, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 09:02:38'),
(480, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:27:32'),
(481, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 08:42:09'),
(482, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 09:48:11'),
(483, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-25 09:47:56'),
(484, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 10:10:49'),
(485, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 10:24:12'),
(486, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 10:10:49'),
(487, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-25 10:28:10'),
(488, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 09:54:26'),
(489, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 10:28:48'),
(490, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 03:33:43'),
(491, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 10:36:37'),
(492, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:03:58'),
(493, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 10:40:00'),
(494, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:20:42'),
(495, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 11:06:17'),
(496, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 11:39:32'),
(497, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-25 11:48:58'),
(498, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 02:43:26'),
(499, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 02:44:41'),
(500, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:04:13'),
(501, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:04:23'),
(502, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:04:28'),
(503, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:04:35'),
(504, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:14:45'),
(505, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:20:13'),
(506, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 03:24:24'),
(507, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:41:11'),
(508, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:42:52'),
(509, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:45:56'),
(510, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 03:47:37'),
(511, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 03:52:50'),
(512, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 03:45:10'),
(513, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 03:46:11'),
(514, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 04:02:37'),
(515, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 03:48:43'),
(516, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 03:52:50'),
(517, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 04:03:14'),
(518, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:21:30'),
(519, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 04:23:29'),
(520, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 03:33:50'),
(521, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:28:37'),
(522, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:49:02'),
(523, 5, 'it_emp@joplc.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:53:34'),
(524, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 04:54:40'),
(525, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 04:42:18'),
(526, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:00:12'),
(527, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 04:51:58'),
(528, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:22:31'),
(529, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 05:07:04'),
(530, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:28:18');
INSERT INTO `login_histories` (`id`, `user_id`, `email_tried`, `successful`, `event`, `reason`, `ip_address`, `user_agent`, `created_at`) VALUES
(531, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 05:35:07'),
(532, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 05:24:06'),
(533, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 05:35:16'),
(534, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 05:55:39'),
(535, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:10:54'),
(536, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 05:59:03'),
(537, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 06:16:20'),
(538, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 05:41:58'),
(539, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 06:17:31'),
(540, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:40:38'),
(541, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 06:39:49'),
(542, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 06:40:57'),
(543, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:56:28'),
(544, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 03:47:54'),
(545, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 06:57:35'),
(546, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:08:06'),
(547, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 07:16:34'),
(548, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 07:02:40'),
(549, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 07:26:12'),
(550, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 08:16:18'),
(551, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 07:29:45'),
(552, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:17:29'),
(553, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:22:49'),
(554, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 08:18:34'),
(555, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 08:35:27'),
(556, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 08:24:02'),
(557, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 08:43:46'),
(558, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 08:56:57'),
(559, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 08:46:33'),
(560, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 09:10:32'),
(561, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 08:57:22'),
(562, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 09:22:29'),
(563, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-26 09:11:26'),
(564, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 08:49:11'),
(565, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 09:34:02'),
(566, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 09:40:35'),
(567, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 09:45:08'),
(568, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 10:18:02'),
(569, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 08:49:53'),
(570, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-26 10:23:35'),
(571, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 10:48:23'),
(572, 10, 'nandytuli9@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 10:49:00'),
(573, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 10:35:14'),
(574, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 09:45:36'),
(575, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 11:03:59'),
(576, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 11:13:12'),
(577, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 11:49:11'),
(578, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:13:14'),
(579, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 12:24:02'),
(580, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:50:35'),
(581, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:53:54'),
(582, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:54:01'),
(583, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:55:18'),
(584, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-26 12:55:21'),
(585, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-26 12:59:05'),
(586, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 02:48:42'),
(587, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 02:48:56'),
(588, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:10:19'),
(589, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:17:02'),
(590, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:17:12'),
(591, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:17:49'),
(592, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:36:13'),
(593, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:42:53'),
(594, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 03:43:34'),
(595, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 03:47:55'),
(596, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 04:09:07'),
(597, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 03:56:52'),
(598, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 04:13:18'),
(599, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 03:44:01'),
(600, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 04:13:35'),
(601, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 04:02:51'),
(602, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 04:24:34'),
(603, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 04:12:02'),
(604, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-27 04:14:13'),
(605, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:00:29'),
(606, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-27 04:53:48'),
(607, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 04:30:36'),
(608, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 05:12:37'),
(609, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 06:10:53'),
(610, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 05:24:28'),
(611, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 06:47:35'),
(612, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 06:52:09'),
(613, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 08:17:03'),
(614, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 08:42:09'),
(615, 18, 'mahfuz.rahman@jamunaoil.gov.bd', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 08:42:40'),
(616, NULL, 'mahfuz.rahman0908@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 08:58:07'),
(617, NULL, 'mahfuz.rahman0908@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 08:58:17'),
(618, 18, 'mahfuz.rahman@jamunaoil.gov.bd', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 08:58:42'),
(619, 18, 'mahfuz.rahman@jamunaoil.gov.bd', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 08:58:59'),
(620, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 09:25:48'),
(621, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:27:44'),
(622, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 04:03:19'),
(623, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 09:37:59'),
(624, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 09:46:01'),
(625, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 09:38:55'),
(626, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 09:55:52'),
(627, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:00:02'),
(628, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-27 09:49:38'),
(629, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 09:37:42'),
(630, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:13:41'),
(631, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-27 10:18:50'),
(632, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 10:21:33'),
(633, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 10:11:03'),
(634, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 10:11:03'),
(635, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-27 10:18:10'),
(636, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 12:23:22'),
(637, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 12:28:40'),
(638, 18, 'mahfuz.rahman@jamunaoil.gov.bd', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 13:39:50'),
(639, 18, 'mahfuz.rahman@jamunaoil.gov.bd', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-27 13:48:43'),
(640, 8, 'raihanmehedi700@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 02:34:44'),
(641, 8, 'raihanmehedi700@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 02:35:12'),
(642, 14, 'kaziaiyub06@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:04:35'),
(643, 14, 'kaziaiyub06@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:09:52'),
(644, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:09:59'),
(645, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:10:30'),
(646, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:17:22'),
(647, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:26:43'),
(648, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:32:58'),
(649, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:35:48'),
(650, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 03:29:11'),
(651, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:52:54'),
(652, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:53:47'),
(653, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'manual', '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:55:50'),
(654, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:59:23'),
(655, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 03:59:29'),
(656, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-28 04:06:22'),
(657, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 03:57:43'),
(658, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 03:50:19'),
(659, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:17:33'),
(660, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 03:42:09'),
(661, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 04:40:37'),
(662, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 04:31:52'),
(663, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 04:40:46'),
(664, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 04:58:17'),
(665, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:19:34'),
(666, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-28 05:09:52'),
(667, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 04:31:55'),
(668, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:56:39'),
(669, 12, 'mahabubjocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 05:59:35'),
(670, 12, 'mahabubjocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 06:01:18'),
(671, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 03:32:58'),
(672, 9, 'israt29190@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 06:35:21'),
(673, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 05:57:49'),
(674, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 06:42:52'),
(675, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 06:44:42'),
(676, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 07:17:28'),
(677, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 07:18:21'),
(678, 9, 'israt29190@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 06:35:27'),
(679, 10, 'nandytuli9@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-28 08:38:30'),
(680, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 08:57:22'),
(681, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:00:01'),
(682, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:00:12'),
(683, 10, 'nandytuli9@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-28 08:55:03'),
(684, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-28 08:59:02'),
(685, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 09:03:08'),
(686, 16, 'tarek.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:35:13'),
(687, 13, 'rafatkhan1988@gmail.com', 1, 'login', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 09:56:59'),
(688, 16, 'tarek.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 09:47:46'),
(689, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:12:43'),
(690, 17, 'sajjad.jocl2020@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 10:20:48'),
(691, 17, 'sajjad.jocl2020@gmail.com', 0, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:44:53'),
(692, 7, 'nayem.jocl@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 09:20:39'),
(693, 17, 'sajjad.jocl2020@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:45:04'),
(694, 7, 'nayem.jocl@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:45:06'),
(695, 11, 'md.razaulkarim86@gmail.com', 1, 'logout', 'timeout', '103.16.73.139', NULL, '2026-10-28 05:21:19'),
(696, 11, 'md.razaulkarim86@gmail.com', 1, 'login', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', '2026-10-28 10:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_03_000001_create_itsm_phase1_tables', 1),
(5, '2026_10_03_000002_create_roles_and_link_users', 1),
(6, '2026_10_05_000003_users_multiple_roles', 1),
(7, '2026_10_05_000004_whatsapp_and_role_updates', 1),
(8, '2026_10_05_000005_it_admin_can_manage_users', 1),
(9, '2026_10_06_000006_request_on_behalf', 1),
(10, '2026_10_06_000007_attachment_limit_5mb', 1),
(11, '2026_10_08_000008_attendance_permission', 1),
(12, '2026_10_09_000009_attendance_own_and_timeout', 2),
(13, '2026_10_12_000010_logout_tracking', 3),
(14, '2026_10_13_000011_multi_employee_assignment', 4),
(15, '2026_10_16_000012_request_numbers_rq', 5),
(16, '2026_10_17_000013_escalate_from_any_open_status', 5),
(17, '2026_10_18_000014_status_colors_new_closed', 6),
(18, '2026_10_18_000015_status_color_resolved', 6),
(19, '2026_10_18_000016_status_color_closed_darkgreen', 6),
(20, '2026_10_19_000017_users_show_in_attendance', 7),
(21, '2026_10_19_000018_users_avatar_path', 8),
(22, '2026_10_26_000019_roles_and_user_permissions', 9),
(23, '2026_10_27_000020_split_admin_permissions_crud', 9),
(24, '2026_10_27_000021_users_board_position', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('002fe72b-ecdb-47b2-9517-d25f20d647b3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"New request RQ-39: Office Order\"}', NULL, '2026-10-28 04:31:07', '2026-10-28 04:31:07'),
('00313990-18a7-4b88-b3e8-360c3dc329ce', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"Request RQ-1 was submitted for YEASMIN ARA CHOWDHURY.\"}', '2026-10-18 04:20:44', '2026-10-18 03:28:31', '2026-10-18 04:20:44'),
('014eb5f3-b573-4eca-a900-048b3a0a626b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3 has been assigned to ISRAT JAHAN\"}', '2026-10-18 08:31:52', '2026-10-18 08:28:04', '2026-10-18 08:31:52'),
('01b02dd9-f09d-4df5-96db-254d7dc27139', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 12:15:06', '2026-10-18 12:15:06'),
('01bb3185-3b2f-4948-aa8a-0f1033b1919d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 06:01:00', '2026-10-28 06:01:00'),
('027fbbac-7e8a-413d-9aba-95d2bf7b3ecf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"New request RQ-15: Tax certificate Correction\"}', NULL, '2026-10-25 09:47:58', '2026-10-25 09:47:58'),
('02cfab0e-951b-42a7-a150-45e72bd1440a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":37,\"ticket_no\":\"RQ-37\",\"message\":\"New request RQ-37: Draft a note for computer Accesories Inventory\"}', NULL, '2026-10-28 04:04:40', '2026-10-28 04:04:40'),
('02f5d684-081c-4aa9-aba4-43d8f29bb7f3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('041d2579-4168-4f60-bc90-1d5e38b238c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 08:18:06', '2026-10-26 08:18:06'),
('0422f70e-2ac5-4755-90f3-80df32f721a0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"Your request RQ-11 was submitted.\"}', '2026-10-19 07:28:02', '2026-10-19 07:25:32', '2026-10-19 07:28:02'),
('052d43ce-7b6c-47a4-adf5-cd6bc47ceb58', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('0541a53d-1f02-4f2a-873d-bb1820f78d80', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 12:15:06', '2026-10-18 12:15:06'),
('06be1d3b-e207-4fbe-bd57-9c71052a880d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 05:20:10', '2026-10-28 05:20:10'),
('075b67c5-bd8f-40a0-99bb-a8d0d556952b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: In Progress \\u2192 Resolved\"}', '2026-10-28 06:43:00', '2026-10-28 06:01:00', '2026-10-28 06:43:00'),
('09176ef5-148d-4ce8-9931-e93eb5da2704', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-19 05:09:17', '2026-10-26 12:20:47'),
('09236dd6-24af-4e4c-8394-5ed7465a36b9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":38,\"ticket_no\":\"RQ-38\",\"message\":\"New request RQ-38: Draft a note for Awareness regarding Cyber Scurity\"}', '2026-10-28 04:22:38', '2026-10-28 04:08:18', '2026-10-28 04:22:38'),
('09901550-cf15-4d10-9ed5-58bcf64ce4d5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2 has been assigned to IT Employee\"}', '2026-10-18 07:13:06', '2026-10-18 06:31:17', '2026-10-18 07:13:06'),
('0a4ad3f4-478a-4bbd-9c37-eee0f4e52e45', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: Assigned \\u2192 In Progress\"}', NULL, '2026-10-19 09:09:36', '2026-10-19 09:09:36'),
('0ae00bf9-8201-4527-a985-9d5fbc1e9284', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"New request RQ-33: Add Product Serial Number in INVENTORY Menu\"}', NULL, '2026-10-27 10:02:44', '2026-10-27 10:02:44'),
('0af220b4-a592-4c37-9065-a456706527b9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: In Progress \\u2192 Resolved\"}', NULL, '2026-10-25 11:45:33', '2026-10-25 11:45:33'),
('0b975510-4337-4e9d-8d6d-d861ebc7428d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: Assigned \\u2192 In Progress\"}', NULL, '2026-10-27 09:38:43', '2026-10-27 09:38:43'),
('0c833668-67ee-4377-a3b9-4a2ff33e937b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:01:37', '2026-10-26 07:01:37'),
('0d06dd2d-bb38-4cdc-a4fa-e53c5b2de017', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: Assigned \\u2192 In Progress\"}', '2026-10-18 12:17:26', '2026-10-18 12:14:19', '2026-10-18 12:17:26'),
('0d3233ea-3b2d-4799-ac32-9aef21a13be7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 18, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"Your request RQ-34 was submitted.\"}', '2026-10-27 13:47:55', '2026-10-27 13:47:25', '2026-10-27 13:47:55'),
('0e695043-d361-4a93-963e-eb964f2ac4f0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"Md Tarek Hossain submitted request RQ-4 on your behalf.\"}', '2026-10-18 12:17:19', '2026-10-18 12:11:44', '2026-10-18 12:17:19'),
('0eb2d506-61db-4f44-ba24-9920a2e6ab29', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 10:20:48', '2026-10-26 10:20:48'),
('0eced386-053c-4e55-be86-df5c4f5761b3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 10:00:17', '2026-10-27 10:00:17'),
('0f4d020b-3109-43f0-8a4f-35d73b8061ff', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 08:32:34', '2026-10-18 08:32:34'),
('12b92ef0-a82b-4978-9993-99ff70ac95a0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"New request RQ-41: Listing of Damaged Items for sent to HR Department\"}', NULL, '2026-10-28 10:47:29', '2026-10-28 10:47:29'),
('1346a04d-b787-45d3-a08d-30c0c7c6cea2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"New request RQ-35: Bank Asia Employee List\"}', NULL, '2026-10-28 03:22:22', '2026-10-28 03:22:22'),
('13fe189f-462f-4e16-86e1-c8a7adc856d2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', '2026-10-19 11:58:41', '2026-10-19 09:09:46', '2026-10-19 11:58:41'),
('1583bfb6-7c7f-4235-9691-b60f0fa6586b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"RQ-27: Assigned \\u2192 In Progress\"}', NULL, '2026-10-27 05:04:26', '2026-10-27 05:04:26'),
('15d4b9dd-5a98-4e79-a069-e2e10774219b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"Request RQ-27 was submitted for MOHAMMAD SHARIFUL ISLAM.\"}', NULL, '2026-10-27 05:03:28', '2026-10-27 05:03:28'),
('16cf4977-7cb8-4171-98cb-58013b62bae9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: Resolved \\u2192 User Confirmation\"}', '2026-10-26 09:34:43', '2026-10-26 09:24:57', '2026-10-26 09:34:43'),
('173db13c-a7f4-4d49-8d88-8ebed2e19c12', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', NULL, '2026-10-18 12:11:44', '2026-10-18 12:11:44'),
('1749f49a-f88c-4866-8b87-fcc521423ba8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"New request RQ-3: Need to prepare a document\"}', NULL, '2026-10-18 08:25:26', '2026-10-18 08:25:26'),
('1753134e-0fa3-470e-91bb-03330fd77e24', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:01:37', '2026-10-26 07:01:37'),
('177d24b5-00a3-4526-8417-67f1b2a20d6a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-19 03:26:11', '2026-10-26 12:20:47'),
('1795c0c7-d9f1-4380-876d-423542c138aa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"RQ-26: you were added as a supporting employee (RAFAT KHAN is primary)\"}', '2026-10-26 12:20:47', '2026-10-26 12:15:56', '2026-10-26 12:20:47'),
('18a6d24f-2191-4186-8e65-379bbf7072f2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"Your request RQ-14 was submitted.\"}', '2026-10-25 05:26:33', '2026-10-25 05:25:59', '2026-10-25 05:26:33'),
('18d5ca22-c8db-450c-807f-fed249652250', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: Assigned \\u2192 In Progress\"}', '2026-10-26 08:17:35', '2026-10-26 05:35:16', '2026-10-26 08:17:35'),
('19ad6103-40a5-4aaf-9e47-3d0cb887c2c8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:09:15', '2026-10-26 07:09:15'),
('19ce66b7-de6b-4684-aef2-e1ea40ab729f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('19df51c5-ac87-46c1-babf-3014bd0d574a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":29,\"ticket_no\":\"RQ-29\",\"message\":\"New request RQ-29: Make a Note & Detail Description on Newly purchased 51 Desktop\"}', NULL, '2026-10-27 09:53:59', '2026-10-27 09:53:59'),
('1abee692-379a-4786-ba0f-b9f78bec3a22', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', '2026-10-26 03:17:01', '2026-10-19 05:08:26', '2026-10-26 03:17:01'),
('1afc85c1-21a0-498b-91e4-2b8a6da5eae7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:10:13', '2026-10-26 07:10:13'),
('1bb6eade-a72f-4188-9b65-f5ce6c8da083', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you are the primary responsible employee\"}', '2026-10-19 03:15:42', '2026-10-18 06:31:00', '2026-10-19 03:15:42'),
('1be1e7bb-9186-4453-8961-8c0063502e24', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"New request RQ-28: Hardware Stock Update\"}', NULL, '2026-10-27 09:34:44', '2026-10-27 09:34:44'),
('1bfa0929-2c84-49cc-946e-6d3fdbcdd2d6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: In Progress \\u2192 Resolved\"}', '2026-10-26 11:04:08', '2026-10-26 10:20:48', '2026-10-26 11:04:08'),
('1c9470b5-9625-4e92-8fc9-554693c3e05f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"New request RQ-39: Office Order\"}', NULL, '2026-10-28 04:31:07', '2026-10-28 04:31:07'),
('1cdc1260-a06e-4683-ba9c-5c88a64df63a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', '2026-10-19 03:28:52', '2026-10-18 12:11:44', '2026-10-19 03:28:52'),
('1d94707f-b20d-46ed-9fb3-306e7dbf61d9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 06:35:18', '2026-10-19 06:35:18'),
('1da6d702-90d8-43ed-95ec-289077440769', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 09:46:42', '2026-10-27 09:46:42'),
('20c78fd4-2917-4454-88c5-808c30909c4d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"New request RQ-22: Depot Pis Entry\"}', NULL, '2026-10-26 07:15:51', '2026-10-26 07:15:51'),
('2140d574-e4a0-421d-a42d-3d4076d05a01', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":31,\"ticket_no\":\"RQ-31\",\"message\":\"New request RQ-31: Ready & Provide All Salary Report for the Month of October 2026\"}', NULL, '2026-10-27 09:58:06', '2026-10-27 09:58:06'),
('22d6cb45-1131-4a2a-b729-a4be696cf849', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"New request RQ-41: Listing of Damaged Items for sent to HR Department\"}', NULL, '2026-10-28 10:47:29', '2026-10-28 10:47:29'),
('2620f4fd-dd71-49ce-88e7-7649e261bf37', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"New request RQ-24: CHEQUE VOUCHER Entry\"}', '2026-10-26 08:17:35', '2026-10-26 07:24:49', '2026-10-26 08:17:35'),
('26a16779-9910-4b72-af67-23711b31b95c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"New request RQ-15: Tax certificate Correction\"}', '2026-10-25 09:48:18', '2026-10-25 09:47:58', '2026-10-25 09:48:18'),
('26a4b0c4-b8f9-4b9a-a191-dd25793b35bf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":30,\"ticket_no\":\"RQ-30\",\"message\":\"New request RQ-30: Password Reset For Md Iqbal Hossain of National Mail Server\"}', '2026-10-27 10:17:40', '2026-10-27 09:56:33', '2026-10-27 10:17:40'),
('27d37f4e-ae73-4cac-90e0-e740bb3a1aa3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 09:24:57', '2026-10-26 09:24:57'),
('28ab19af-3a1e-4855-b1f9-1757ef0a7617', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"New request RQ-39: Office Order\"}', NULL, '2026-10-28 04:31:07', '2026-10-28 04:31:07'),
('2950a384-e7dd-4fa4-901a-484622da84cf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', '2026-10-26 03:17:01', '2026-10-19 07:25:32', '2026-10-26 03:17:01'),
('2a2c9002-b914-494d-b7ba-6c1d2b5ba1a3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 09:24:57', '2026-10-26 09:24:57'),
('2adba9f1-e007-4e6a-b6a2-4319b9740bd6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 06:58:41', '2026-10-26 06:58:41'),
('2c4be26c-b59e-41db-9dc3-aea397a2189b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"New request RQ-18: Establish an internet connection (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', NULL, '2026-10-25 11:43:21', '2026-10-25 11:43:21'),
('2caa2b1f-236f-4a11-ab02-bcf953725018', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"RQ-40: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 09:35:50', '2026-10-28 09:35:50'),
('2e90aff8-430d-4aac-92ab-f684bb806f43', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"New request RQ-33: Add Product Serial Number in INVENTORY Menu\"}', NULL, '2026-10-27 10:02:44', '2026-10-27 10:02:44'),
('2f131308-7ac8-4a31-86d6-b8d6836f1ff7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1 has been assigned to MD. MAHABUB ALAM\"}', NULL, '2026-10-18 03:38:12', '2026-10-18 03:38:12'),
('2f24c466-b03f-4dee-98eb-fc7579d8ca65', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"Your request RQ-28 was submitted.\"}', NULL, '2026-10-27 09:34:44', '2026-10-27 09:34:44'),
('2fa3f768-6c1a-4bf0-a75b-41cf517ac5cc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"New request RQ-21: Printer setup support\"}', NULL, '2026-10-26 05:06:40', '2026-10-26 05:06:40'),
('31327a54-ddd7-49ad-b2ee-2f6792dc2f88', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"New request RQ-19: Router Configure\"}', NULL, '2026-10-26 04:36:33', '2026-10-26 04:36:33'),
('3154f91d-aded-4a57-aebc-0163f0992d9d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: User Confirmation \\u2192 Closed\"}', NULL, '2026-10-28 06:44:34', '2026-10-28 06:44:34'),
('31f6fef5-9c83-45a8-ba83-58ea735aa4c7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 13, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: User Confirmation \\u2192 Closed\"}', '2026-10-27 04:24:40', '2026-10-26 09:34:35', '2026-10-27 04:24:40'),
('32099c1c-8405-4252-bd9f-15f1da5521ea', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"New request RQ-17: Bank Advice Checking\"}', NULL, '2026-10-25 11:35:46', '2026-10-25 11:35:46'),
('3225a68c-543d-4d94-b382-65dd0d06d118', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 18, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"RQ-34: New \\u2192 Acknowledged\"}', NULL, '2026-10-28 03:39:27', '2026-10-28 03:39:27'),
('335ef73d-9b4e-448d-a7c9-19878b9c69ef', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"RQ-40: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 09:35:50', '2026-10-28 09:35:50'),
('341f8df4-bd1b-4c1b-b545-535ae5b11483', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 08:18:06', '2026-10-26 08:18:06'),
('3494fb5a-e0b4-47cf-a950-7e99ad1a8e2b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: In Progress \\u2192 Resolved\"}', '2026-10-26 08:17:35', '2026-10-26 06:58:41', '2026-10-26 08:17:35'),
('34d40632-379d-4b6e-8a59-f30b07730dc1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":38,\"ticket_no\":\"RQ-38\",\"message\":\"Your request RQ-38 was submitted.\"}', NULL, '2026-10-28 04:08:18', '2026-10-28 04:08:18'),
('353a9c12-a9f6-46a0-b815-ec22ac123ce1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2 has been assigned to MD. MAHABUB ALAM\"}', '2026-10-18 07:13:06', '2026-10-18 06:31:00', '2026-10-18 07:13:06'),
('359eed79-a825-42eb-95ad-38022e45d502', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: you are the primary responsible employee\"}', '2026-10-19 03:31:00', '2026-10-18 08:28:04', '2026-10-19 03:31:00'),
('35a15047-e4c8-4e08-bc44-5e3a05d88a4e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"New request RQ-16: Salary Sheet Print\"}', '2026-10-26 03:17:01', '2026-10-25 11:32:10', '2026-10-26 03:17:01'),
('35e5aa0a-5dbc-42ad-a7dd-7e8b174462f6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"New request RQ-36: No Internet issue\"}', NULL, '2026-10-28 03:56:27', '2026-10-28 03:56:27'),
('3708633a-e8cd-47cb-8c96-af8562c46c1c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"Your request RQ-7 was submitted.\"}', '2026-10-19 05:11:10', '2026-10-19 05:08:26', '2026-10-19 05:11:10'),
('374b9b74-8734-46f7-9825-06a573f0c7b4', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"IT commented on RQ-20\"}', '2026-10-28 03:26:55', '2026-10-27 10:22:20', '2026-10-28 03:26:55'),
('38ab93a4-3e8e-4250-b19d-f01b9a9c7eed', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 12:14:21', '2026-10-26 12:14:21'),
('39933277-d3f7-4cea-9401-9c2a056d001b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"Md Tarek Hossain submitted request RQ-27 on your behalf.\"}', NULL, '2026-10-27 05:03:28', '2026-10-27 05:03:28'),
('39f90ad2-a1a7-4ee1-a5cc-f48d2bd9c6cc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"New request RQ-22: Depot Pis Entry\"}', '2026-10-26 08:17:35', '2026-10-26 07:15:51', '2026-10-26 08:17:35'),
('3ac64760-5c95-42a8-932a-a4e61a75a95f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"New request RQ-1: New user need (for YEASMIN ARA CHOWDHURY, filed by System Administrator)\"}', '2026-10-18 03:33:19', '2026-10-18 03:28:31', '2026-10-18 03:33:19'),
('3b01510e-2600-4c9f-8a33-7fff40ea5b78', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"New request RQ-20: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 04:41:51', '2026-10-26 04:41:51'),
('3b593d44-8253-4437-ae99-66156503f036', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"RQ-24: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-26 07:26:35', '2026-10-26 12:20:47'),
('3b83eddd-f6bf-4ddf-ad57-c454af4b6145', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 05:06:20', '2026-10-19 05:06:20'),
('3ba701c3-cd7f-4358-a009-600eab821d72', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 8, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-26 02:43:35', '2026-10-19 07:29:29', '2026-10-26 02:43:35'),
('3c5de8b2-0d09-488b-9e78-2447431a36b1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 06:01:00', '2026-10-28 06:01:00'),
('3d3c33dd-1fd3-4e1d-99bf-200465b5bd93', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"Your request RQ-6 was submitted.\"}', '2026-10-19 03:33:34', '2026-10-19 03:25:52', '2026-10-19 03:33:34'),
('3e41ac50-b604-4fc9-aeed-25ecb27110f2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"Your request RQ-9 was submitted.\"}', '2026-10-19 05:25:45', '2026-10-19 05:25:41', '2026-10-19 05:25:45'),
('3e4b7ef3-573f-49a5-80e5-aebdda330b37', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"Your request RQ-10 was submitted.\"}', '2026-10-19 07:28:02', '2026-10-19 07:00:24', '2026-10-19 07:28:02'),
('3f49d4ed-43c9-432e-bd2b-a7ed28647226', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', NULL, '2026-10-19 05:08:26', '2026-10-19 05:08:26'),
('3f9e3a53-9faf-4c56-b1e4-800af40eab5b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"New request RQ-22: Depot Pis Entry\"}', NULL, '2026-10-26 07:15:51', '2026-10-26 07:15:51'),
('404fb4cd-1b41-44ae-9d79-9baad868c8d9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: Resolved \\u2192 User Confirmation\"}', '2026-10-19 05:11:02', '2026-10-19 05:06:20', '2026-10-19 05:11:02'),
('42e42419-19cc-494b-bee6-a55545fca0ec', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"New request RQ-34: To arrange the LAN wiring\"}', '2026-10-28 03:45:05', '2026-10-27 13:47:25', '2026-10-28 03:45:05'),
('432b9fc8-fe22-4f65-9473-66b633493a82', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: you are the primary responsible employee\"}', '2026-10-19 09:08:18', '2026-10-19 07:01:00', '2026-10-19 09:08:18'),
('436542f9-577f-4976-99c3-4431e93d9d35', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-18 03:47:41', '2026-10-18 03:47:41'),
('438bc7f0-b143-489f-824e-323c96f56784', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 12:14:21', '2026-10-26 12:14:21'),
('44979b99-968f-4608-a39b-3c946783aab9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":30,\"ticket_no\":\"RQ-30\",\"message\":\"New request RQ-30: Password Reset For Md Iqbal Hossain of National Mail Server\"}', NULL, '2026-10-27 09:56:33', '2026-10-27 09:56:33'),
('453dedcb-72c4-404c-83d2-9b981812282b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('45de6454-f833-4ba9-b242-53b248d082e1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: Resolved \\u2192 User Confirmation\"}', '2026-10-27 10:16:12', '2026-10-27 09:46:42', '2026-10-27 10:16:12'),
('4633e0bf-1b01-4a57-a204-ebafd5dcbb94', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"Your request RQ-20 was submitted.\"}', '2026-10-26 04:42:18', '2026-10-26 04:41:51', '2026-10-26 04:42:18'),
('4649f871-8126-43e5-8ebb-38ba12688114', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 08:18:06', '2026-10-26 08:18:06'),
('47e7850c-5fb4-47d8-932d-de0a302ec213', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"Your request RQ-17 was submitted.\"}', '2026-10-25 11:36:03', '2026-10-25 11:35:46', '2026-10-25 11:36:03'),
('481c70fc-4609-4ab9-9f52-6b5186b013b2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: User Confirmation \\u2192 Closed\"}', '2026-10-19 09:11:01', '2026-10-19 09:09:46', '2026-10-19 09:11:01'),
('48c4af7b-33e9-478b-a7af-a20b8eaa388c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39 has been assigned to MD. MAHABUB ALAM\"}', NULL, '2026-10-28 04:31:27', '2026-10-28 04:31:27'),
('498500b6-470d-4055-a1b8-15a41d0fd1f7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-26 08:20:52', '2026-10-26 12:20:47'),
('49a31b0e-80b5-4696-a291-ac11be797b43', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"RQ-40: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 09:35:50', '2026-10-28 09:35:50'),
('49bd2694-73d3-447c-bfe2-6c0bfc9a193a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"IT commented on RQ-26\"}', '2026-10-28 10:45:25', '2026-10-28 09:57:26', '2026-10-28 10:45:25'),
('49efc7bd-07ad-45fd-9142-4385c01af368', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 12:14:21', '2026-10-26 12:14:21'),
('4b228ee2-452c-45cb-a9f7-bee752587e18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"New request RQ-41: Listing of Damaged Items for sent to HR Department\"}', NULL, '2026-10-28 10:47:29', '2026-10-28 10:47:29'),
('4cbaf0e6-08bf-4c3b-b231-95f4b2972752', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: Resolved \\u2192 User Confirmation\"}', '2026-10-26 08:17:35', '2026-10-26 07:10:13', '2026-10-26 08:17:35'),
('4cdbd492-09a0-4fca-8f3b-a1a5835e8b5d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 13, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: you are the primary responsible employee\"}', '2026-10-25 04:36:36', '2026-10-25 04:26:38', '2026-10-25 04:36:36'),
('4d0db449-7a6f-4571-adbc-7a83efac0873', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"RQ-33: you are the primary responsible employee\"}', '2026-10-27 10:17:40', '2026-10-27 10:02:53', '2026-10-27 10:17:40'),
('4d1ab398-3794-4123-a980-860a96e2245c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', NULL, '2026-10-19 07:26:50', '2026-10-19 07:26:50'),
('4d6f17b0-c1a9-4c93-bf8d-eb93d8c11a8e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 03:47:41', '2026-10-18 03:47:41'),
('4df09f77-72cf-4816-a02e-405aeba7a259', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"Your request RQ-3 was submitted.\"}', '2026-10-18 08:26:00', '2026-10-18 08:25:26', '2026-10-18 08:26:00'),
('4df35432-122e-4c7f-807c-09b38a854dd9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: you are the primary responsible employee\"}', '2026-10-18 12:15:56', '2026-10-18 12:13:32', '2026-10-18 12:15:56'),
('4ef29deb-48d2-4565-893f-3d13a06eb15d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 13, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"RQ-41: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
('50dd19d0-a749-4ba5-ae1a-d61a6e30c8b9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"New request RQ-27: Install Oracle 19c on a laptop (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', '2026-10-27 05:12:45', '2026-10-27 05:03:28', '2026-10-27 05:12:45'),
('51197b77-2a4f-4b8d-9011-209395bf907e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"IT commented on RQ-13\"}', '2026-10-26 07:28:51', '2026-10-26 06:32:15', '2026-10-26 07:28:51'),
('51e40abb-abea-4e86-90b5-02eff2d9c9e1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: In Progress \\u2192 Resolved\"}', '2026-10-27 10:17:40', '2026-10-27 09:46:42', '2026-10-27 10:17:40'),
('526b183f-95ca-4547-88a7-9e0937ff2e4b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', NULL, '2026-10-19 07:00:24', '2026-10-19 07:00:24'),
('527cf6e3-b046-4832-97da-76b1a35c1c52', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', '2026-10-19 03:29:46', '2026-10-19 03:25:52', '2026-10-19 03:29:46'),
('531b528b-85be-43ae-bfd1-6c4d9e0c1836', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: you were added as a supporting employee (Md Tarek Hossain is primary)\"}', '2026-10-26 07:00:25', '2026-10-25 11:44:06', '2026-10-26 07:00:25'),
('535d5583-45ab-4bae-ac32-5533798f3595', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"New request RQ-20: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 04:41:51', '2026-10-26 04:41:51'),
('538819d4-7c34-4253-bec8-925a78ebb7bd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', '2026-10-26 03:17:01', '2026-10-19 09:09:46', '2026-10-26 03:17:01'),
('53e6163f-f291-4b81-963a-08086ca9d643', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: User Confirmation \\u2192 Closed\"}', '2026-10-18 06:36:08', '2026-10-18 03:49:13', '2026-10-18 06:36:08'),
('5482b835-e234-4f94-b49f-5aaa5db1ec3c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: In Progress \\u2192 Resolved\"}', '2026-10-26 12:16:38', '2026-10-26 12:14:21', '2026-10-26 12:16:38'),
('55305b92-5fda-4d46-9558-9ac0571d9a53', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":38,\"ticket_no\":\"RQ-38\",\"message\":\"New request RQ-38: Draft a note for Awareness regarding Cyber Scurity\"}', NULL, '2026-10-28 04:08:18', '2026-10-28 04:08:18'),
('55db3797-6b47-424d-b742-e9134a0472ef', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":29,\"ticket_no\":\"RQ-29\",\"message\":\"New request RQ-29: Make a Note & Detail Description on Newly purchased 51 Desktop\"}', NULL, '2026-10-27 09:53:59', '2026-10-27 09:53:59'),
('5617dfdd-05c1-4d87-a7f6-ea491f2938aa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', '2026-10-19 11:58:29', '2026-10-19 09:09:15', '2026-10-19 11:58:29'),
('562c60e8-1bcb-4a07-ac7e-c19aaf0ccca1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":29,\"ticket_no\":\"RQ-29\",\"message\":\"Your request RQ-29 was submitted.\"}', NULL, '2026-10-27 09:53:59', '2026-10-27 09:53:59'),
('57d30a87-484b-47ba-8537-c7ba254f9c38', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"Your request RQ-41 was submitted.\"}', NULL, '2026-10-28 10:47:29', '2026-10-28 10:47:29'),
('594444b5-fde8-41a9-a559-666727077188', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"New request RQ-17: Bank Advice Checking\"}', NULL, '2026-10-25 11:35:46', '2026-10-25 11:35:46'),
('59b35dff-4bfd-4932-9da3-75420d9ebff2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-19 03:31:10', '2026-10-18 06:31:00', '2026-10-19 03:31:10'),
('5a15b562-87a8-459c-a9a7-e371f18ac39c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: In Progress \\u2192 Resolved\"}', '2026-10-26 08:17:35', '2026-10-26 07:10:13', '2026-10-26 08:17:35'),
('5c2f6df5-72f3-4ebf-956b-9b836eaa4df6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"RQ-26: you were added as a supporting employee (RAFAT KHAN is primary)\"}', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
('5c3f8f0d-1287-419f-83b8-fec21848fb9f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-25 11:32:21', '2026-10-26 12:20:47'),
('5da46a49-1975-4efe-9cb9-fddac2f3c084', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('5dbfab2b-2918-4671-9f65-5982380d3b5a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"New request RQ-22: Depot Pis Entry\"}', NULL, '2026-10-26 07:15:51', '2026-10-26 07:15:51'),
('5e0297a7-1da7-4221-942d-8e999b52734f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', '2026-10-26 03:17:01', '2026-10-25 04:17:56', '2026-10-26 03:17:01'),
('5e590a8a-0f2c-41b5-82fd-e2720e02460f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"New request RQ-23: CASH CREDIT VOUCHER (CCV) Entry\"}', NULL, '2026-10-26 07:21:46', '2026-10-26 07:21:46'),
('5ecd4273-81e2-4ebf-8eea-182a48360e18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', NULL, '2026-10-19 03:25:52', '2026-10-19 03:25:52'),
('5f0bc8e0-172d-44d6-9a13-b2268e135fff', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"Your request RQ-21 was submitted.\"}', '2026-10-26 05:06:56', '2026-10-26 05:06:40', '2026-10-26 05:06:56'),
('5f1627b3-83a6-4abc-a2b9-d32a6a563460', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:01:37', '2026-10-26 07:01:37'),
('5f330a4f-e4c6-4c81-82a8-d2064afe6175', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: Assigned \\u2192 In Progress\"}', NULL, '2026-10-28 05:20:03', '2026-10-28 05:20:03'),
('5f7b7fe7-821a-464f-9bb8-dceb8055f0a3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('5fac1a0a-3bc2-4379-a033-e1041c1c6b27', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: Resolved \\u2192 User Confirmation\"}', '2026-10-18 12:17:31', '2026-10-18 12:15:06', '2026-10-18 12:17:31'),
('5fc8416a-c959-4e43-ac0f-9f5dae372bf3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"IT commented on RQ-22\"}', '2026-10-26 07:22:09', '2026-10-26 07:21:43', '2026-10-26 07:22:09'),
('6072024d-e005-473d-96cd-d3a285d84afd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"Your request RQ-40 was submitted.\"}', NULL, '2026-10-28 09:02:52', '2026-10-28 09:02:52'),
('61593532-25a5-4034-bd80-a7e8fee0ce69', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"New request RQ-24: CHEQUE VOUCHER Entry\"}', NULL, '2026-10-26 07:24:49', '2026-10-26 07:24:49'),
('616ad970-a5b5-4e2f-9166-04a968d1b102', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"IT commented on RQ-24\"}', '2026-10-26 12:20:47', '2026-10-26 07:28:42', '2026-10-26 12:20:47'),
('61a45bf8-65df-4470-98f7-944bdfef9093', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15 has been assigned to MD. MAHABUB ALAM\"}', '2026-10-26 12:20:47', '2026-10-25 09:50:40', '2026-10-26 12:20:47'),
('61c13b70-10ed-40bd-98d0-a85886870009', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"Your request RQ-26 was submitted.\"}', '2026-10-26 12:18:18', '2026-10-26 12:13:46', '2026-10-26 12:18:18'),
('61d6b4a1-5fd9-4b43-88ac-fc7d6bc98e81', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-28 05:20:10', '2026-10-28 05:20:10'),
('61fc32c8-6ea8-40c1-9b59-3eb542634dc9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":29,\"ticket_no\":\"RQ-29\",\"message\":\"New request RQ-29: Make a Note & Detail Description on Newly purchased 51 Desktop\"}', NULL, '2026-10-27 09:53:59', '2026-10-27 09:53:59'),
('62535fd9-5847-4ab6-86a4-3fb9290c4d33', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"New request RQ-19: Router Configure\"}', NULL, '2026-10-26 04:36:33', '2026-10-26 04:36:33'),
('626d5474-629c-40fc-b892-4172d4d273b9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: User Confirmation \\u2192 Closed\"}', '2026-10-26 08:17:35', '2026-10-26 07:02:36', '2026-10-26 08:17:35'),
('62f157f5-22a3-4c12-9b0a-11b7122a8d02', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"New request RQ-16: Salary Sheet Print\"}', NULL, '2026-10-25 11:32:10', '2026-10-25 11:32:10'),
('6372e633-0bc3-4499-973f-eb3e09bc1bd3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', '2026-10-26 03:17:01', '2026-10-19 07:00:24', '2026-10-26 03:17:01'),
('63e4d646-214e-4ad0-87c2-7e645a898226', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 10, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"RQ-25: you were added as a supporting employee (ISRAT JAHAN is primary)\"}', '2026-10-27 04:13:46', '2026-10-26 08:30:50', '2026-10-27 04:13:46'),
('6468928b-6e09-45b8-baf8-976b30a7ec5d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', '2026-10-19 07:28:02', '2026-10-19 05:25:41', '2026-10-19 07:28:02'),
('64d23d00-f5ca-4638-b56f-0e63f85ac7ab', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23 has been assigned to MD. MAHABUB ALAM\"}', '2026-10-26 12:20:47', '2026-10-26 07:24:15', '2026-10-26 12:20:47'),
('65457537-430a-42b6-a906-b38b4f76a181', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', NULL, '2026-10-19 07:26:50', '2026-10-19 07:26:50'),
('65603a4f-f70a-4d76-bac9-20e8c3956b23', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 10:00:17', '2026-10-27 10:00:17'),
('66b30ac5-26e7-468e-aba2-c4b8ab0b19fa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: In Progress \\u2192 Resolved\"}', '2026-10-26 08:17:35', '2026-10-26 07:09:15', '2026-10-26 08:17:35'),
('66b425b2-79a4-4d5f-829b-660a36b89d9c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:10:13', '2026-10-26 07:10:13'),
('67104023-3ebe-4b86-9940-2f4f3254b764', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: Assigned \\u2192 In Progress\"}', NULL, '2026-10-18 03:43:56', '2026-10-18 03:43:56'),
('67b50237-a5ed-4dee-abd3-6c10076cf747', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":31,\"ticket_no\":\"RQ-31\",\"message\":\"New request RQ-31: Ready & Provide All Salary Report for the Month of October 2026\"}', NULL, '2026-10-27 09:58:06', '2026-10-27 09:58:06'),
('67d745a8-a918-470e-aec0-c2eb5255b383', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"Your request RQ-2 was submitted.\"}', '2026-10-18 06:29:02', '2026-10-18 06:28:57', '2026-10-18 06:29:02'),
('688942a6-ef2e-4317-9fd9-5c0f771839f5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 10, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: User Confirmation \\u2192 Closed\"}', '2026-10-27 10:37:17', '2026-10-27 10:16:30', '2026-10-27 10:37:17'),
('694ce642-bff7-4ee0-b059-98f3aaae0049', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', NULL, '2026-10-18 12:11:44', '2026-10-18 12:11:44'),
('6ad4c1b6-a4fc-4863-8142-ab7a2938626c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: User Confirmation \\u2192 Closed\"}', '2026-10-27 10:06:19', '2026-10-27 10:05:16', '2026-10-27 10:06:19'),
('6afa2a32-2aa6-488d-9320-64493f820869', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"New request RQ-41: Listing of Damaged Items for sent to HR Department\"}', NULL, '2026-10-28 10:47:29', '2026-10-28 10:47:29'),
('6b14d6cc-8266-47a4-9ee7-188ec3d59834', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: Resolved \\u2192 User Confirmation\"}', '2026-10-26 08:21:47', '2026-10-26 08:18:06', '2026-10-26 08:21:47');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('6b4a3638-9773-4a25-93e0-614706271338', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"New request RQ-26: Prepare an IT Equipment Stock & Asset Summary\"}', NULL, '2026-10-26 12:13:46', '2026-10-26 12:13:46'),
('6b717abd-56a1-460b-b714-9c27e39d0798', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('6ba2184a-9cfe-412d-9f9e-e42aa2c6a299', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"New request RQ-26: Prepare an IT Equipment Stock & Asset Summary\"}', NULL, '2026-10-26 12:13:46', '2026-10-26 12:13:46'),
('6bc8babe-139a-47b6-a908-88568c3c483e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"New request RQ-21: Printer setup support\"}', NULL, '2026-10-26 05:06:40', '2026-10-26 05:06:40'),
('6bca6434-cfc9-4238-9887-f45c6ae262a0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":31,\"ticket_no\":\"RQ-31\",\"message\":\"New request RQ-31: Ready & Provide All Salary Report for the Month of October 2026\"}', '2026-10-27 10:17:40', '2026-10-27 09:58:06', '2026-10-27 10:17:40'),
('6c03470f-d425-4241-a09e-263b861dbe97', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: you are the primary responsible employee: Let us know the approximate total count of CASH CREDIT VOUCHER (CCV) August-2026 when you complete this task.\"}', '2026-10-26 12:20:47', '2026-10-26 07:24:15', '2026-10-26 12:20:47'),
('6ce2755a-5889-4f76-aa46-4e23500933c4', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 10:20:48', '2026-10-26 10:20:48'),
('6dcfdb76-5ea4-442b-b645-1ab0ac9c1036', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"IT commented on RQ-26\"}', '2026-10-28 05:56:50', '2026-10-28 05:20:49', '2026-10-28 05:56:50'),
('6fa1892a-88f0-43b5-ad99-a81bf8a8a3ca', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you are the primary responsible employee\"}', '2026-10-18 06:32:39', '2026-10-18 06:31:17', '2026-10-18 06:32:39'),
('7112a7aa-f80f-4c4b-bd34-e5ec63ee9479', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: In Progress \\u2192 Resolved\"}', '2026-10-26 04:36:52', '2026-10-25 11:45:33', '2026-10-26 04:36:52'),
('71be6769-310a-41a0-85b4-0866c4f48771', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"New request RQ-25: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 08:30:19', '2026-10-26 08:30:19'),
('7297209a-20f6-40b3-b192-5bdfd9ba1b1f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-25 09:50:40', '2026-10-26 12:20:47'),
('746bbcbc-326b-4bd5-91a3-4330c531d3c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":30,\"ticket_no\":\"RQ-30\",\"message\":\"Your request RQ-30 was submitted.\"}', NULL, '2026-10-27 09:56:33', '2026-10-27 09:56:33'),
('74e27e68-29a8-413e-9db8-7d5f3814de85', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"Your request RQ-36 was submitted.\"}', NULL, '2026-10-28 03:56:27', '2026-10-28 03:56:27'),
('7644df12-d936-49b9-8afd-4510db2d003a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-26 11:04:21', '2026-10-26 12:20:47'),
('76459081-0192-4148-a510-b3fcdaa73332', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"New request RQ-32: Add Status option in My Requests Menu\"}', '2026-10-27 10:17:40', '2026-10-27 10:00:50', '2026-10-27 10:17:40'),
('76736120-2d6d-4790-be30-b533a322ac0f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"IT commented on RQ-23\"}', '2026-10-26 12:20:47', '2026-10-26 07:25:37', '2026-10-26 12:20:47'),
('7782a5d2-55e6-4f95-8bda-37f3b0846b75', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"New request RQ-23: CASH CREDIT VOUCHER (CCV) Entry\"}', '2026-10-26 08:17:35', '2026-10-26 07:21:46', '2026-10-26 08:17:35'),
('7998e456-8cf4-4b65-bba1-d5dd492e8dfa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"New request RQ-39: Office Order\"}', NULL, '2026-10-28 04:31:07', '2026-10-28 04:31:07'),
('7a148424-7bb8-45d5-b810-f6557f20fa0b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"New request RQ-26: Prepare an IT Equipment Stock & Asset Summary\"}', NULL, '2026-10-26 12:13:46', '2026-10-26 12:13:46'),
('7a375898-1553-4505-8d53-ddedfdb49feb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:09:15', '2026-10-26 07:09:15'),
('7ae2d94b-4ee6-49f2-a60b-cc1a1fbeadcc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"New request RQ-21: Printer setup support\"}', NULL, '2026-10-26 05:06:40', '2026-10-26 05:06:40'),
('7b04a0b1-95e1-4dc0-8d9a-1cbfe5a22463', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', '2026-10-26 03:17:01', '2026-10-19 05:06:20', '2026-10-26 03:17:01'),
('7b09eddb-3f36-4ab1-819d-c69b1c69239a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: User Confirmation \\u2192 Closed\"}', NULL, '2026-10-18 03:49:13', '2026-10-18 03:49:13'),
('7b2ca451-14eb-492b-8d41-3ccc9c2461dd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 10:00:17', '2026-10-27 10:00:17'),
('7b38ac52-e846-457a-a627-cc93b1e39efb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"New request RQ-34: To arrange the LAN wiring\"}', NULL, '2026-10-27 13:47:25', '2026-10-27 13:47:25'),
('7b909532-3559-44f1-b66a-b621aafe6d21', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', '2026-10-19 07:28:02', '2026-10-19 05:20:46', '2026-10-19 07:28:02'),
('7c81f0ef-7503-49da-8607-55008f3dcdc0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you were removed from the team\"}', '2026-10-19 03:15:45', '2026-10-18 03:42:44', '2026-10-19 03:15:45'),
('7cbc4367-a01d-4883-81c5-4b280ffbb3f5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"IT Employee updated their work on RQ-1: In progress\"}', '2026-10-19 03:15:48', '2026-10-18 03:41:56', '2026-10-19 03:15:48'),
('7cefdf85-91b2-4f7c-9334-eb1dfc1b6a7b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 05:20:10', '2026-10-28 05:20:10'),
('7d52af85-a3fe-4986-8e49-74df94e5eb0f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"RQ-9: you are the primary responsible employee\"}', NULL, '2026-10-19 05:26:51', '2026-10-19 05:26:51'),
('7d58b6e1-f164-4ddb-b20a-848a00166647', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: Assigned \\u2192 In Progress\"}', '2026-10-19 07:28:02', '2026-10-19 05:31:44', '2026-10-19 07:28:02'),
('7e2489d2-f886-4103-adc3-1ccdad3caac9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 10, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: you are the primary responsible employee\"}', '2026-10-26 06:17:28', '2026-10-26 04:42:13', '2026-10-26 06:17:28'),
('7f43b0fa-377d-44e1-8d72-28d454c561c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 8, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"RQ-41: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
('7f5a40f9-3f80-43fd-bd2a-f7088eed4b18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"IT commented on RQ-26\"}', '2026-10-28 09:00:05', '2026-10-28 08:59:02', '2026-10-28 09:00:05'),
('7f98d71a-7a7a-4c88-85d3-d636023f6eb8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"New request RQ-24: CHEQUE VOUCHER Entry\"}', NULL, '2026-10-26 07:24:49', '2026-10-26 07:24:49'),
('7f9fc766-2b40-4fd5-aa29-b5e5f5480aa1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 09:24:57', '2026-10-26 09:24:57'),
('7ffb2d43-1f84-44ea-a8d4-d483f7b0c0d8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"New request RQ-36: No Internet issue\"}', '2026-10-28 04:22:32', '2026-10-28 03:56:27', '2026-10-28 04:22:32'),
('8190c4b9-1706-4216-baf3-53ef378a739c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-19 06:43:55', '2026-10-26 12:20:47'),
('81a971de-b5d0-4073-86cd-c00f4646d726', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('826999ca-895a-4efb-96eb-9ee5af18e700', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', '2026-10-26 03:17:01', '2026-10-19 07:26:50', '2026-10-26 03:17:01'),
('829ca667-ee03-4c97-bde5-7be7ea0135eb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"New request RQ-40: Loss\\/Gain Posting Mismatch\"}', NULL, '2026-10-28 09:02:52', '2026-10-28 09:02:52'),
('832e8827-0ca1-4065-b9a5-b2d0679df9c5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', '2026-10-19 07:28:02', '2026-10-19 07:26:50', '2026-10-19 07:28:02'),
('83c4a216-b316-46a6-8d6b-76b38dde1ca8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"RQ-14: In Progress \\u2192 On Hold\"}', '2026-10-27 04:13:47', '2026-10-27 04:01:09', '2026-10-27 04:13:47'),
('8455ba03-049b-427f-946f-25f462a28b16', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"New request RQ-25: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 08:30:19', '2026-10-26 08:30:19'),
('858e042b-3adb-490c-83e3-a157488c6665', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: User Confirmation \\u2192 Closed\"}', '2026-10-28 10:46:14', '2026-10-26 08:18:04', '2026-10-28 10:46:14'),
('85b09dc1-fb2a-4257-a6a0-ab136af5107d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('8650007f-5749-477f-8615-0d258b1c642e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: Assigned \\u2192 In Progress\"}', '2026-10-19 03:38:52', '2026-10-19 03:35:17', '2026-10-19 03:38:52'),
('886a76d5-a93d-4687-bdbd-a5885d6b4d9d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 06:58:41', '2026-10-26 06:58:41'),
('89063b74-2f29-49a4-b9fc-985f11d727e7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: User Confirmation \\u2192 Closed\"}', '2026-10-18 12:15:54', '2026-10-18 12:15:31', '2026-10-18 12:15:54'),
('898a44f7-1061-4974-a2d2-ac8a94508b95', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 09:46:42', '2026-10-27 09:46:42'),
('8a3f8ed2-5dce-47b9-bc8b-60e339480209', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1 has been assigned to IT Employee\"}', NULL, '2026-10-18 03:42:44', '2026-10-18 03:42:44'),
('8af83f3b-84d3-4e80-a201-abf2820e93b2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-27 10:00:17', '2026-10-27 10:00:17'),
('8b2743ef-e30c-42f3-a056-01ac8a86ff2c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', '2026-10-18 12:17:29', '2026-10-18 12:15:06', '2026-10-18 12:17:29'),
('8b5c2b23-649b-49d6-9dbf-564ab71dcb7f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-19 09:10:40', '2026-10-19 07:29:29', '2026-10-19 09:10:40'),
('8b8b80df-a354-4309-aa9f-d0c8c3d370f2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 10:20:48', '2026-10-26 10:20:48'),
('8baa18be-6bc2-4fa4-bc4a-4727ade46c6f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"RQ-26: Assigned \\u2192 In Progress\"}', '2026-10-27 03:43:37', '2026-10-27 03:17:45', '2026-10-27 03:43:37'),
('8bca4835-b9cd-4bf7-b953-35aead6f7f25', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: In Progress \\u2192 Resolved\"}', NULL, '2026-10-25 11:45:33', '2026-10-25 11:45:33'),
('8cb3100b-ff3c-4b55-a0ca-d743a467a958', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:10:13', '2026-10-26 07:10:13'),
('8d0e2d19-1be0-47a2-a8b2-ffc11b5fe397', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 06:01:00', '2026-10-28 06:01:00'),
('8daf0e81-a68c-4b19-9ed1-799fa4231a3c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: you are the primary responsible employee\"}', '2026-10-19 09:09:34', '2026-10-19 07:25:41', '2026-10-19 09:09:34'),
('8dd83d4c-bd81-458c-89bb-03f6c9daa677', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', NULL, '2026-10-19 05:20:46', '2026-10-19 05:20:46'),
('8e3ff65f-191d-49d6-a5bb-d865f13105d8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"IT commented on RQ-26\"}', '2026-10-27 10:17:40', '2026-10-27 10:02:13', '2026-10-27 10:17:40'),
('8e8f525b-2764-43fb-a813-e5576ee1bd19', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"RQ-26: you were added as a supporting employee (RAFAT KHAN is primary)\"}', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
('8ea97f54-b745-4a54-8040-71d7eb9f49ee', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-25 03:31:56', '2026-10-19 07:29:29', '2026-10-25 03:31:56'),
('8fdb26e2-6a01-44b1-a874-7ee5737e0bea', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: In Progress \\u2192 Resolved\"}', '2026-10-25 09:50:58', '2026-10-25 09:29:56', '2026-10-25 09:50:58'),
('8ffd839a-b64f-487c-a5b8-96e970bc9571', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', '2026-10-19 05:10:53', '2026-10-19 05:06:20', '2026-10-19 05:10:53'),
('902aec7c-a206-4c52-a128-7cdc6e72cd29', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: Resolved \\u2192 User Confirmation\"}', '2026-10-26 08:17:35', '2026-10-26 07:01:37', '2026-10-26 08:17:35'),
('906c5d80-cab9-4010-a5ed-be1aea3152c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"New request RQ-3: Need to prepare a document\"}', '2026-10-18 08:27:43', '2026-10-18 08:25:26', '2026-10-18 08:27:43'),
('91c7ec24-e38c-4414-b202-4b756f18a622', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: you are the primary responsible employee\"}', '2026-10-27 09:38:55', '2026-10-27 09:35:54', '2026-10-27 09:38:55'),
('9274c154-a8cf-4c2f-b951-579648704d8b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: Assigned \\u2192 In Progress\"}', '2026-10-25 05:01:21', '2026-10-25 04:36:48', '2026-10-25 05:01:21'),
('929bcf4b-7e93-47e1-830f-d257143e1f23', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-19 05:07:01', '2026-10-26 12:20:47'),
('92ebf251-aaa7-44a3-91e4-aafa64bc2e04', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: In Progress \\u2192 Resolved\"}', '2026-10-26 08:17:35', '2026-10-26 07:01:37', '2026-10-26 08:17:35'),
('935d2d2d-5636-4c84-a23c-25bb4c670860', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"New request RQ-15: Tax certificate Correction\"}', NULL, '2026-10-25 09:47:58', '2026-10-25 09:47:58'),
('9435462d-adc5-4bbc-b60b-52846befc6f9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: Resolved \\u2192 User Confirmation\"}', '2026-10-18 07:13:06', '2026-10-18 06:33:20', '2026-10-18 07:13:06'),
('95e24148-3af4-4cc7-a99f-c3ed0e9f420d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"RQ-25: Assigned \\u2192 In Progress\"}', '2026-10-26 11:04:59', '2026-10-26 08:47:04', '2026-10-26 11:04:59'),
('960aac88-b888-4e67-a77b-24ff0dec79e1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"RQ-40: In Progress \\u2192 Resolved\"}', '2026-10-28 10:45:12', '2026-10-28 09:35:50', '2026-10-28 10:45:12'),
('972b4da0-89d2-4b70-8ddb-d083d8657a06', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: User Confirmation \\u2192 Closed\"}', '2026-10-19 03:24:33', '2026-10-18 11:27:35', '2026-10-19 03:24:33'),
('98e90159-350e-45d1-a884-c82245577ee9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"New request RQ-32: Add Status option in My Requests Menu\"}', NULL, '2026-10-27 10:00:50', '2026-10-27 10:00:50'),
('98f47def-c29e-4907-84c7-de80fbef89f6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: In Progress \\u2192 Resolved\"}', NULL, '2026-10-25 11:45:33', '2026-10-25 11:45:33'),
('9910e38e-d380-4d81-a836-79f67f66db3a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"New request RQ-23: CASH CREDIT VOUCHER (CCV) Entry\"}', NULL, '2026-10-26 07:21:46', '2026-10-26 07:21:46'),
('991491dc-cf12-4e0a-9016-12afbfe6c26c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"New request RQ-22: Depot Pis Entry\"}', NULL, '2026-10-26 07:15:51', '2026-10-26 07:15:51'),
('99c073b5-ef06-4ba5-ad42-3f703b65aeec', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: In Progress \\u2192 Resolved\"}', NULL, '2026-10-25 09:29:56', '2026-10-25 09:29:56'),
('9b7e3805-f306-4d95-9103-7e1991360ca0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"New request RQ-26: Prepare an IT Equipment Stock & Asset Summary\"}', NULL, '2026-10-26 12:13:46', '2026-10-26 12:13:46'),
('9bd05ef1-fe7b-4f0e-8762-53ffda840602', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":37,\"ticket_no\":\"RQ-37\",\"message\":\"New request RQ-37: Draft a note for computer Accesories Inventory\"}', '2026-10-28 04:22:30', '2026-10-28 04:04:40', '2026-10-28 04:22:30'),
('9c48b880-2e35-440c-b4b5-47a2072e5f4d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 08:18:06', '2026-10-26 08:18:06'),
('9cff1bef-46aa-4102-8066-36d6decec80a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-26 12:18:01', '2026-10-26 12:20:47'),
('9d335912-3215-4a0d-9902-2c97739771aa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"Your request RQ-33 was submitted.\"}', NULL, '2026-10-27 10:02:44', '2026-10-27 10:02:44'),
('9e95a0b5-5521-436f-9d9e-b99548dc5401', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"New request RQ-40: Loss\\/Gain Posting Mismatch\"}', NULL, '2026-10-28 09:02:52', '2026-10-28 09:02:52'),
('9e9f838c-db10-4f40-b9b8-42391726f392', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 10:00:17', '2026-10-27 10:00:17'),
('9f8a902f-295c-4bf8-a707-33e3c637e1d7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"New request RQ-17: Bank Advice Checking\"}', NULL, '2026-10-25 11:35:46', '2026-10-25 11:35:46'),
('a0329d1a-2f80-4793-bdae-d7a498e961eb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-18 03:41:29', '2026-10-18 03:40:58', '2026-10-18 03:41:29'),
('a0449d23-2234-452e-9b8c-69946cc0719d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"New request RQ-20: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 04:41:51', '2026-10-26 04:41:51'),
('a23378e1-6725-4182-b35d-4a5751c02af6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"Your request RQ-32 was submitted.\"}', NULL, '2026-10-27 10:00:50', '2026-10-27 10:00:50'),
('a334b4fd-df4b-40d0-97c9-b3052bd76a30', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"New request RQ-20: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 04:41:51', '2026-10-26 04:41:51'),
('a3378072-d6a4-4cb7-b749-2f5f667751b5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"New request RQ-28: Hardware Stock Update\"}', NULL, '2026-10-27 09:34:44', '2026-10-27 09:34:44'),
('a394725b-5ec5-4cb9-b73a-a4d1f21c8ed5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"Your request RQ-22 was submitted.\"}', '2026-10-26 12:20:47', '2026-10-26 07:15:51', '2026-10-26 12:20:47'),
('a40a0d7d-e6b8-41d9-a61b-96f0d7b8336a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: Assigned \\u2192 In Progress\"}', NULL, '2026-10-25 11:44:26', '2026-10-25 11:44:26'),
('a4290c0c-fe88-4592-9c15-83162ee2b505', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"RQ-26: you were added as a supporting employee (RAFAT KHAN is primary)\"}', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
('a44e7518-ffd9-4587-ad7a-98dd5d453628', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"New request RQ-18: Establish an internet connection (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', NULL, '2026-10-25 11:43:21', '2026-10-25 11:43:21'),
('a4a6439c-309d-4cde-87e3-df7ecf86a9f5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"RQ-41: you are the primary responsible employee\"}', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
('a52edec1-8783-44c1-8c14-62037dcd79a8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 06:58:41', '2026-10-26 06:58:41'),
('a7f88111-80b6-4a9a-94b4-5757a25394de', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 05:20:10', '2026-10-28 05:20:10'),
('a816d0f2-1094-4daf-89a0-bb3cb13eb484', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: In Progress \\u2192 Resolved\"}', '2026-10-18 07:13:06', '2026-10-18 06:33:20', '2026-10-18 07:13:06'),
('a82fcd53-c695-4880-862f-d9d4690113fa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', '2026-10-19 03:29:46', '2026-10-18 12:15:06', '2026-10-19 03:29:46'),
('a8a84e95-0dc3-4571-84a4-7b62c931524b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('a8b47474-bf0f-48e7-8c86-859e2b6858e0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"New request RQ-2: Email Password reset\"}', NULL, '2026-10-18 06:28:57', '2026-10-18 06:28:57'),
('a916aeb6-5e1b-4b8a-ac76-98c8d362555d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: User Confirmation \\u2192 Closed\"}', '2026-10-26 10:24:54', '2026-10-26 08:21:04', '2026-10-26 10:24:54'),
('aa3f15ac-0bc5-4f3d-9e77-49f7ef20c612', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":38,\"ticket_no\":\"RQ-38\",\"message\":\"New request RQ-38: Draft a note for Awareness regarding Cyber Scurity\"}', NULL, '2026-10-28 04:08:18', '2026-10-28 04:08:18'),
('aa41651a-760d-40ff-8d59-e0fafd116e7e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: Assigned \\u2192 In Progress\"}', '2026-10-19 11:58:46', '2026-10-19 11:51:45', '2026-10-19 11:58:46'),
('aa954f7d-a6d1-4b30-a74f-072c407b0bae', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('aab057ca-7ff7-41d9-a361-16d4fd0a5bbf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":37,\"ticket_no\":\"RQ-37\",\"message\":\"Your request RQ-37 was submitted.\"}', NULL, '2026-10-28 04:04:40', '2026-10-28 04:04:40'),
('ab670fcb-d6c8-437a-9a94-a6524804e223', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"Your request RQ-5 was submitted.\"}', '2026-10-19 03:29:46', '2026-10-18 12:29:09', '2026-10-19 03:29:46'),
('abf64a17-8602-469c-971e-3f0e19ff6a3d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"Your request RQ-16 was submitted.\"}', '2026-10-25 11:32:24', '2026-10-25 11:32:10', '2026-10-25 11:32:24'),
('ac231c8b-3411-44ad-a739-b137ac474d18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"RQ-32: Assigned \\u2192 In Progress\"}', NULL, '2026-10-27 10:15:42', '2026-10-27 10:15:42'),
('ac26d2c0-49d8-4bf5-ab85-8b2ec8fa5533', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 06:01:00', '2026-10-28 06:01:00'),
('ac424e08-a525-4ed8-a3c2-2918458124f6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":37,\"ticket_no\":\"RQ-37\",\"message\":\"New request RQ-37: Draft a note for computer Accesories Inventory\"}', NULL, '2026-10-28 04:04:40', '2026-10-28 04:04:40'),
('aca2471a-a69d-4555-a95e-deb5b9f41a02', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"RQ-32: you are the primary responsible employee\"}', '2026-10-27 10:17:40', '2026-10-27 10:08:28', '2026-10-27 10:17:40'),
('adde27ad-9d18-47ec-b7b6-e44d255b0f7c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: you were added as a supporting employee (Md Tarek Hossain is primary)\"}', NULL, '2026-10-26 04:36:47', '2026-10-26 04:36:47'),
('ade1521a-8382-412c-8ae7-2448953c1940', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('adff8c3f-5294-4e25-8e46-773f8bb71cab', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"IT commented on RQ-26\"}', '2026-10-27 10:17:40', '2026-10-27 10:02:13', '2026-10-27 10:17:40'),
('ae3485b5-b8e7-48de-a260-466b741443ca', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:09:15', '2026-10-26 07:09:15'),
('ae6609d6-5446-451c-9639-d46dd40fbbce', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18 has been assigned to Md Tarek Hossain\"}', NULL, '2026-10-25 11:44:06', '2026-10-25 11:44:06'),
('aee8d897-9791-464e-8dc9-313bbfd030f0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"Your request RQ-35 was submitted.\"}', NULL, '2026-10-28 03:22:22', '2026-10-28 03:22:22'),
('af77dd42-863b-49a3-b11c-82bba88fe725', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"RQ-35: In Progress \\u2192 Resolved\"}', '2026-10-28 04:22:40', '2026-10-28 04:20:14', '2026-10-28 04:22:40'),
('af90c242-2749-4bb1-8231-012165933096', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:10:13', '2026-10-26 07:10:13'),
('afcc9095-6afb-4bbc-bc5d-88ec2fa25128', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"New request RQ-27: Install Oracle 19c on a laptop (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', NULL, '2026-10-27 05:03:28', '2026-10-27 05:03:28'),
('affef5ce-4bb3-4ec5-9bee-b6b17d55cda3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"RQ-16: Assigned \\u2192 In Progress\"}', '2026-10-26 04:36:52', '2026-10-26 03:44:08', '2026-10-26 04:36:52'),
('b0ebbebb-150e-409d-8110-b4e5110d5704', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 08:32:34', '2026-10-18 08:32:34'),
('b2947590-ca87-4a5b-8a30-7b96929ffacb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"New request RQ-39: Office Order\"}', '2026-10-28 04:31:38', '2026-10-28 04:31:07', '2026-10-28 04:31:38'),
('b2a8a782-bbc1-4f37-bc98-f4b77af133b1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: In Progress \\u2192 Resolved\"}', NULL, '2026-10-25 09:29:56', '2026-10-25 09:29:56'),
('b2e7cdd7-f368-4cb7-8b60-df82edd17156', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"New request RQ-23: CASH CREDIT VOUCHER (CCV) Entry\"}', NULL, '2026-10-26 07:21:46', '2026-10-26 07:21:46'),
('b2f1445e-e6af-4dcd-8878-551c5bb358ed', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"RQ-35: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 04:20:14', '2026-10-28 04:20:14'),
('b3238995-055c-48be-89d7-a890cc73e34a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":38,\"ticket_no\":\"RQ-38\",\"message\":\"New request RQ-38: Draft a note for Awareness regarding Cyber Scurity\"}', NULL, '2026-10-28 04:08:18', '2026-10-28 04:08:18'),
('b36138e4-2d1a-482d-805e-670272aa26b1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', '2026-10-19 07:24:31', '2026-10-19 07:00:24', '2026-10-19 07:24:31'),
('b38dc5a4-e892-4f73-841c-c49be6eb5575', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 10, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"New reply from requester on RQ-20\"}', '2026-10-27 09:47:01', '2026-10-27 06:49:12', '2026-10-27 09:47:01'),
('b41cbb5b-7176-492d-b877-68b2f7011f3f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"RQ-23: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 12:14:21', '2026-10-26 12:14:21'),
('b42d71a9-9ff3-48a7-91f3-823786c01bd7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 07:09:15', '2026-10-26 07:09:15'),
('b519143c-fdde-47b5-8dfd-d6552030dedf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: you are the primary responsible employee\"}', '2026-10-26 06:59:32', '2026-10-26 05:06:51', '2026-10-26 06:59:32'),
('b5710edd-f72d-4353-bb90-3f8e52a50b30', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"RQ-33: Assigned \\u2192 In Progress\"}', NULL, '2026-10-27 10:15:49', '2026-10-27 10:15:49'),
('b5891d4a-cada-4207-ab18-5dcb49695846', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"New request RQ-32: Add Status option in My Requests Menu\"}', NULL, '2026-10-27 10:00:50', '2026-10-27 10:00:50'),
('b6908c3e-7244-4c8a-85d4-e8dc8dff18a6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', '2026-10-19 03:41:38', '2026-10-18 12:29:09', '2026-10-19 03:41:38'),
('b6fe05d9-9dfe-41a2-b932-18580972c577', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"New request RQ-36: No Internet issue\"}', NULL, '2026-10-28 03:56:27', '2026-10-28 03:56:27'),
('b7182bb4-5476-42eb-b63b-6129c5b6f200', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: Assigned \\u2192 In Progress\"}', '2026-10-26 11:04:49', '2026-10-26 09:11:20', '2026-10-26 11:04:49'),
('b8016e91-b451-424d-81d1-4d7dea8c26e3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"New request RQ-28: Hardware Stock Update\"}', '2026-10-27 09:37:23', '2026-10-27 09:34:44', '2026-10-27 09:37:23'),
('b8d2e867-019c-42a3-b463-9371574481bd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', NULL, '2026-10-19 05:08:26', '2026-10-19 05:08:26'),
('b9dad125-3588-4a56-84c5-0ed7abce2402', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 09:24:57', '2026-10-26 09:24:57'),
('b9fc1895-4d78-4cbc-bbb1-66d769adfa3c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"New request RQ-21: Printer setup support\"}', NULL, '2026-10-26 05:06:40', '2026-10-26 05:06:40'),
('ba790c45-6476-469a-9c39-da139ea17476', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 06:58:41', '2026-10-26 06:58:41'),
('bad80991-bfa2-4231-aaa2-93b652ca532c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"New request RQ-34: To arrange the LAN wiring\"}', NULL, '2026-10-27 13:47:25', '2026-10-27 13:47:25'),
('bba9b865-0fe5-4433-b684-ee3e8de4be8e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"New request RQ-36: No Internet issue\"}', NULL, '2026-10-28 03:56:27', '2026-10-28 03:56:27'),
('bbb7b97a-03a3-426b-b38f-8962a9f585d7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"RQ-28: In Progress \\u2192 Resolved\"}', '2026-10-27 10:17:40', '2026-10-27 10:00:17', '2026-10-27 10:17:40'),
('bbe56e08-112b-4d4b-a7c1-2ba6912a3b6d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: you are the primary responsible employee\"}', NULL, '2026-10-28 03:56:38', '2026-10-28 03:56:38'),
('bd1fdd9e-6104-4b97-b7b2-1eaefc3b926b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"New request RQ-2: Email Password reset\"}', '2026-10-18 06:29:28', '2026-10-18 06:28:57', '2026-10-18 06:29:28'),
('bd46c0ac-f404-4f4a-b37d-d9b5026b1c44', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":29,\"ticket_no\":\"RQ-29\",\"message\":\"New request RQ-29: Make a Note & Detail Description on Newly purchased 51 Desktop\"}', '2026-10-27 10:17:40', '2026-10-27 09:53:59', '2026-10-27 10:17:40'),
('bd7ba89e-0277-4da8-9772-03d058379c7e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', NULL, '2026-10-19 07:25:32', '2026-10-19 07:25:32'),
('beace635-91d0-444f-a698-9e2f063cdcc5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: In Progress \\u2192 Resolved\"}', '2026-10-28 05:56:42', '2026-10-28 05:20:10', '2026-10-28 05:56:42'),
('bf2c7c54-c578-46e8-995f-405f9e11107e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"RQ-19: you are the primary responsible employee\"}', NULL, '2026-10-26 04:36:47', '2026-10-26 04:36:47'),
('bfb70e1e-eedc-4475-b83a-7c1589735dae', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('c009bb90-1766-4a17-877c-7ec3b25363ed', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"RQ-14: Assigned \\u2192 In Progress\"}', '2026-10-26 04:36:52', '2026-10-26 03:17:19', '2026-10-26 04:36:52'),
('c07f51e8-24d7-44f6-b496-ef9f2a8edc2e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":30,\"ticket_no\":\"RQ-30\",\"message\":\"New request RQ-30: Password Reset For Md Iqbal Hossain of National Mail Server\"}', NULL, '2026-10-27 09:56:33', '2026-10-27 09:56:33'),
('c11f7828-f126-4483-904c-c748e842bb4b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 06:35:18', '2026-10-19 06:35:18'),
('c1f09c3d-81d2-481e-aafd-6df94c28e6e6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"New request RQ-34: To arrange the LAN wiring\"}', NULL, '2026-10-27 13:47:25', '2026-10-27 13:47:25'),
('c1f56157-bf00-4545-8768-2fa6f2dd4690', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', NULL, '2026-10-19 05:25:41', '2026-10-19 05:25:41'),
('c2705280-b48d-4e6b-ade3-63cc47e0c846', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', '2026-10-19 05:13:11', '2026-10-19 05:06:20', '2026-10-19 05:13:11'),
('c2a35601-b2e4-4e97-94a7-f04747b826f5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-18 03:40:26', '2026-10-18 03:38:12', '2026-10-18 03:40:26'),
('c32f88fc-cb1f-4197-b33c-f7500e112dfc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: you are the primary responsible employee\"}', '2026-10-26 03:41:23', '2026-10-25 11:35:59', '2026-10-26 03:41:23'),
('c49e2261-216f-4aa4-8fa1-1804049c5b5d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', '2026-10-19 03:33:30', '2026-10-18 12:29:09', '2026-10-19 03:33:30'),
('c828ba5a-dc0f-4600-a893-788d8e3486c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: Resolved \\u2192 User Confirmation\"}', '2026-10-25 09:51:12', '2026-10-25 09:29:56', '2026-10-25 09:51:12'),
('c866b32f-5856-478e-8119-3f8f28274e29', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', '2026-10-26 03:17:01', '2026-10-19 06:35:18', '2026-10-26 03:17:01'),
('c8a2bdcf-b0d4-4559-9578-d4fe5aad8b61', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":37,\"ticket_no\":\"RQ-37\",\"message\":\"New request RQ-37: Draft a note for computer Accesories Inventory\"}', NULL, '2026-10-28 04:04:40', '2026-10-28 04:04:40'),
('c8b750a4-9bdc-459e-8408-fffe93371c24', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"RQ-35: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 04:20:14', '2026-10-28 04:20:14'),
('c8caf841-0083-4367-871d-b7c4b8fe16c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"Your request RQ-24 was submitted.\"}', '2026-10-26 12:20:47', '2026-10-26 07:24:49', '2026-10-26 12:20:47'),
('c8ceb44d-6dd5-4e5c-b53f-bd4550068267', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":31,\"ticket_no\":\"RQ-31\",\"message\":\"Your request RQ-31 was submitted.\"}', NULL, '2026-10-27 09:58:06', '2026-10-27 09:58:06'),
('c90d9331-6963-4991-a601-46bba0490775', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"Your request RQ-13 was submitted.\"}', '2026-10-25 04:18:02', '2026-10-25 04:17:56', '2026-10-25 04:18:02'),
('c97993c8-4e7e-4686-82b2-10893ccee560', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you were removed from the team\"}', '2026-10-19 03:15:38', '2026-10-18 06:31:17', '2026-10-19 03:15:38'),
('c9884d3c-23ce-41ee-a27a-a18fe52afc59', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"New request RQ-24: CHEQUE VOUCHER Entry\"}', NULL, '2026-10-26 07:24:49', '2026-10-26 07:24:49'),
('ca4ff585-431a-44cc-a672-6b5aacfab208', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you are the primary responsible employee\"}', '2026-10-18 03:43:10', '2026-10-18 03:42:44', '2026-10-18 03:43:10'),
('cb92626c-2ffd-4267-8498-6e14e7349746', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"New request RQ-19: Router Configure\"}', NULL, '2026-10-26 04:36:33', '2026-10-26 04:36:33'),
('cbcace59-1ae3-4095-a044-332ccdb5f04d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: In Progress \\u2192 Resolved\"}', NULL, '2026-10-26 10:20:48', '2026-10-26 10:20:48'),
('ccfe4d8a-5c39-4d24-bf04-c12e920f2b08', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: In Progress \\u2192 Resolved\"}', '2026-10-26 03:17:01', '2026-10-25 09:29:56', '2026-10-26 03:17:01'),
('cd5431ce-17a8-4155-ac38-1721f864e00e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":34,\"ticket_no\":\"RQ-34\",\"message\":\"New request RQ-34: To arrange the LAN wiring\"}', NULL, '2026-10-27 13:47:25', '2026-10-27 13:47:25'),
('cf000a62-01be-498c-831d-716afbed37cc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"New request RQ-33: Add Product Serial Number in INVENTORY Menu\"}', '2026-10-27 10:17:40', '2026-10-27 10:02:44', '2026-10-27 10:17:40');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('cf5ef9c6-3b8b-47a0-8484-68f62ae4f0e3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"RQ-8: you are the primary responsible employee\"}', NULL, '2026-10-19 05:21:00', '2026-10-19 05:21:00'),
('cfb97edf-017e-4f4b-949c-ec263492cbbc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 05:06:20', '2026-10-19 05:06:20'),
('d0118631-1b19-4040-9724-28264bcd3074', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', '2026-10-26 03:17:01', '2026-10-19 05:25:41', '2026-10-26 03:17:01'),
('d06af4dc-cc62-46f9-a144-2f34bd3835fd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: In Progress \\u2192 Resolved\"}', '2026-10-26 09:34:28', '2026-10-26 09:24:57', '2026-10-26 09:34:28'),
('d099f1cf-3b39-4648-846d-15906a07b5bf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', NULL, '2026-10-19 07:25:32', '2026-10-19 07:25:32'),
('d202b015-8117-46e1-a472-7c86d04f6b28', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-19 07:29:29', '2026-10-26 12:20:47'),
('d2aa757c-5fa7-46c9-a07b-40ffe264d413', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"New request RQ-40: Loss\\/Gain Posting Mismatch\"}', NULL, '2026-10-28 09:02:52', '2026-10-28 09:02:52'),
('d32ac9d1-74d0-4109-bfe7-88651b7b3711', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: In Progress \\u2192 Resolved\"}', '2026-10-26 08:21:47', '2026-10-26 08:18:06', '2026-10-26 08:21:47'),
('d37e6758-a980-49e7-99e6-997fa84c4731', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', '2026-10-19 08:40:04', '2026-10-19 07:25:32', '2026-10-19 08:40:04'),
('d3ea6a68-f6af-480a-a398-0d56cd5093b4', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you are the primary responsible employee\"}', '2026-10-19 03:15:51', '2026-10-18 03:38:12', '2026-10-19 03:15:51'),
('d439e6a8-dc61-4f1d-becb-c308ccf0292a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"New request RQ-23: CASH CREDIT VOUCHER (CCV) Entry\"}', NULL, '2026-10-26 07:21:46', '2026-10-26 07:21:46'),
('d54e1a22-69c9-41e4-8bfb-7b77e817260f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"Your request RQ-25 was submitted.\"}', '2026-10-26 09:34:50', '2026-10-26 08:30:19', '2026-10-26 09:34:50'),
('d57cdbbe-948f-4594-8a34-3920c2da653a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: User Confirmation \\u2192 Closed\"}', '2026-10-18 07:13:06', '2026-10-18 06:36:28', '2026-10-18 07:13:06'),
('d5ad38af-4fb7-4710-b650-4d2e66cf958e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-25 11:45:33', '2026-10-25 11:45:33'),
('d64c6419-e10d-4a0d-a4d2-0f7882912d9d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"Your request RQ-12 was submitted.\"}', '2026-10-19 08:40:04', '2026-10-19 07:26:50', '2026-10-19 08:40:04'),
('d68f0346-7362-4459-9cff-040b571d9130', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 13, '{\"ticket_id\":26,\"ticket_no\":\"RQ-26\",\"message\":\"RQ-26: you are the primary responsible employee\"}', '2026-10-27 04:25:04', '2026-10-26 12:15:56', '2026-10-27 04:25:04'),
('d770a8c1-ddf7-420c-ba90-2e3e51b51b5a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"New request RQ-27: Install Oracle 19c on a laptop (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', NULL, '2026-10-27 05:03:28', '2026-10-27 05:03:28'),
('d7803fcc-f87a-4501-901c-6d4c00294810', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 09:46:42', '2026-10-27 09:46:42'),
('d797ba82-1a66-4fff-871e-eb532b74c669', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"New request RQ-19: Router Configure\"}', NULL, '2026-10-26 04:36:33', '2026-10-26 04:36:33'),
('d7a8b9c3-2493-46ab-be5a-81102762302b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', NULL, '2026-10-19 07:00:24', '2026-10-19 07:00:24'),
('d7e283ca-6dec-4081-8587-69ea70211278', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: Resolved \\u2192 User Confirmation\"}', '2026-10-19 07:28:02', '2026-10-19 06:35:18', '2026-10-19 07:28:02'),
('d80ba34f-3ea8-4ca7-929d-9547339d5878', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"New request RQ-35: Bank Asia Employee List\"}', NULL, '2026-10-28 03:22:22', '2026-10-28 03:22:22'),
('d832797a-c86b-4a08-a51e-1a2a1c29377b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"Request RQ-4 was submitted for Md Sajjad Hossain.\"}', '2026-10-18 12:11:55', '2026-10-18 12:11:44', '2026-10-18 12:11:55'),
('d8cf28f0-a98a-40eb-b211-d743fd288104', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":23,\"ticket_no\":\"RQ-23\",\"message\":\"Your request RQ-23 was submitted.\"}', '2026-10-26 07:22:05', '2026-10-26 07:21:46', '2026-10-26 07:22:05'),
('d9e79d24-7f44-411a-8d0e-c24cc206ebcd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":20,\"ticket_no\":\"RQ-20\",\"message\":\"RQ-20: In Progress \\u2192 Resolved\"}', NULL, '2026-10-27 09:46:42', '2026-10-27 09:46:42'),
('da699709-4583-4897-8a83-1869f2289202', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 06:33:20', '2026-10-18 06:33:20'),
('dafefacf-e7ee-4726-810f-1c04295a0790', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', '2026-10-19 08:40:04', '2026-10-19 06:35:18', '2026-10-19 08:40:04'),
('db8a71f4-e675-4cd5-8ac4-21fba503c3ca', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: In Progress \\u2192 Resolved\"}', '2026-10-18 06:33:43', '2026-10-18 06:33:20', '2026-10-18 06:33:43'),
('dba1138a-4330-4cc5-bac8-90f65116d60f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"New request RQ-17: Bank Advice Checking\"}', '2026-10-26 03:17:01', '2026-10-25 11:35:46', '2026-10-26 03:17:01'),
('dc33d602-7e66-4ec6-9422-7f5b0da0369a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":41,\"ticket_no\":\"RQ-41\",\"message\":\"RQ-41: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
('dc3a3153-cb5b-469c-af45-eb841645c279', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: Resolved \\u2192 User Confirmation\"}', '2026-10-26 08:17:35', '2026-10-26 06:58:41', '2026-10-26 08:17:35'),
('dcdef4e7-9035-4572-bee5-8569cbe282ba', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":32,\"ticket_no\":\"RQ-32\",\"message\":\"New request RQ-32: Add Status option in My Requests Menu\"}', NULL, '2026-10-27 10:00:50', '2026-10-27 10:00:50'),
('dd4ac0f5-ae3a-4c85-b1d5-b640c7c24e58', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"Your request RQ-39 was submitted.\"}', NULL, '2026-10-28 04:31:07', '2026-10-28 04:31:07'),
('de1e6bf5-e3a8-4d97-85e9-7aca13df332c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 8, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"RQ-24: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', NULL, '2026-10-26 07:26:35', '2026-10-26 07:26:35'),
('de9caecd-1820-4662-9d25-b9260d22e68e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"RQ-27 has been assigned to Md Tarek Hossain\"}', NULL, '2026-10-27 05:04:14', '2026-10-27 05:04:14'),
('deb34550-f664-4ad2-a732-e47e85a01ea5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"Your request RQ-15 was submitted.\"}', '2026-10-26 12:20:47', '2026-10-25 09:47:58', '2026-10-26 12:20:47'),
('dfbf4470-28a7-42b0-8360-044489c3daa8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":21,\"ticket_no\":\"RQ-21\",\"message\":\"RQ-21: Assigned \\u2192 In Progress\"}', '2026-10-26 08:17:35', '2026-10-26 06:58:15', '2026-10-26 08:17:35'),
('e00738e3-31c5-49d1-9b1c-897687220cb8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-18 06:36:08', '2026-10-18 06:31:00', '2026-10-18 06:36:08'),
('e11000fb-4c50-49cb-8195-1906ce7fe896', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', NULL, '2026-10-18 12:29:09', '2026-10-18 12:29:09'),
('e3ed92b4-e0af-49b3-bd34-138b755ec2c1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: Assigned \\u2192 In Progress\"}', '2026-10-18 07:13:06', '2026-10-18 06:32:44', '2026-10-18 07:13:06'),
('e41f6006-e625-476b-85cf-82d7b5c5a28b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"Request RQ-18 was submitted for MOHAMMAD SHARIFUL ISLAM.\"}', '2026-10-26 03:17:01', '2026-10-25 11:43:21', '2026-10-26 03:17:01'),
('e43d9de6-4221-4a07-8b56-9676b2995cc3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', NULL, '2026-10-19 05:20:46', '2026-10-19 05:20:46'),
('e799b3b0-df19-458d-977a-0ff5fe12b5d7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"New request RQ-25: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 08:30:19', '2026-10-26 08:30:19'),
('e7d9e620-3096-425e-badf-e60b9c35ad7a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":27,\"ticket_no\":\"RQ-27\",\"message\":\"New request RQ-27: Install Oracle 19c on a laptop (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', NULL, '2026-10-27 05:03:28', '2026-10-27 05:03:28'),
('e818a599-1a25-4f2d-9dd8-8ed44dc16c1b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"RQ-25: you are the primary responsible employee\"}', '2026-10-26 08:35:40', '2026-10-26 08:30:50', '2026-10-26 08:35:40'),
('e832e88f-c67d-4dc2-a294-4e3110563822', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"Md Tarek Hossain submitted request RQ-18 on your behalf.\"}', NULL, '2026-10-25 11:43:21', '2026-10-25 11:43:21'),
('e8594c0b-72f0-4f2c-a13a-62dc6cd1e7b7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"RQ-35: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 04:20:14', '2026-10-28 04:20:14'),
('e85abd7f-ef61-4872-b278-7631965edb18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"IT commented on RQ-2\"}', '2026-10-18 07:13:06', '2026-10-18 06:34:27', '2026-10-18 07:13:06'),
('e8ad709b-13de-4a97-bea6-3f43570cdda2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', '2026-10-19 07:28:02', '2026-10-19 06:35:18', '2026-10-19 07:28:02'),
('e8faf1a6-c93e-406e-b698-a07d05e3b9b6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"New request RQ-1: New user need (for YEASMIN ARA CHOWDHURY, filed by System Administrator)\"}', NULL, '2026-10-18 03:28:31', '2026-10-18 03:28:31'),
('e9b6f8b7-4b6b-41dd-8390-97e9a6e559c9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":19,\"ticket_no\":\"RQ-19\",\"message\":\"Your request RQ-19 was submitted.\"}', '2026-10-26 04:36:52', '2026-10-26 04:36:33', '2026-10-26 04:36:52'),
('ea7f4503-5c21-4c74-b5d0-9fb0ea9ba210', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: In Progress \\u2192 Resolved\"}', NULL, '2026-10-25 09:29:56', '2026-10-25 09:29:56'),
('ebd80a0a-e800-4451-84b8-275d07d0ce3b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: User Confirmation \\u2192 Closed\"}', '2026-10-18 08:30:11', '2026-10-18 06:36:28', '2026-10-18 08:30:11'),
('ec89d04f-b976-4967-807e-062ac0076d4f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"System Administrator submitted request RQ-1 on your behalf.\"}', NULL, '2026-10-18 03:28:31', '2026-10-18 03:28:31'),
('ec8b2b7d-96bc-4bfe-94b3-7eb494cc9113', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":33,\"ticket_no\":\"RQ-33\",\"message\":\"New request RQ-33: Add Product Serial Number in INVENTORY Menu\"}', NULL, '2026-10-27 10:02:44', '2026-10-27 10:02:44'),
('ed23f291-1070-4794-8c68-a9d5be0163c9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', '2026-10-19 03:41:35', '2026-10-19 03:25:52', '2026-10-19 03:41:35'),
('edfb9c09-d278-484a-861c-41c2fe200d69', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"New request RQ-15: Tax certificate Correction\"}', NULL, '2026-10-25 09:47:58', '2026-10-25 09:47:58'),
('ef0056f7-c9f5-4d9e-b3f4-f96bd8f70f61', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-25 09:51:38', '2026-10-26 12:20:47'),
('ef2c4fd1-008c-42ec-ae15-5b6d0877a9bd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: Assigned \\u2192 In Progress\"}', NULL, '2026-10-19 09:08:23', '2026-10-19 09:08:23'),
('f13bcc8b-8d97-4f9b-af24-55a2e713ebf6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', '2026-10-26 03:17:01', '2026-10-19 09:09:15', '2026-10-26 03:17:01'),
('f215cc27-290e-44de-a02b-e92d77732eef', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"RQ-14: you are the primary responsible employee\"}', '2026-10-26 03:17:01', '2026-10-25 05:26:30', '2026-10-26 03:17:01'),
('f2218799-549f-413a-bce9-6624c9d99e80', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":31,\"ticket_no\":\"RQ-31\",\"message\":\"New request RQ-31: Ready & Provide All Salary Report for the Month of October 2026\"}', NULL, '2026-10-27 09:58:06', '2026-10-27 09:58:06'),
('f262aae4-cf5e-4a90-80ef-75fa3a798416', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"New request RQ-16: Salary Sheet Print\"}', NULL, '2026-10-25 11:32:10', '2026-10-25 11:32:10'),
('f2b87e5f-5c61-47aa-a12c-701129773c85', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":16,\"ticket_no\":\"RQ-16\",\"message\":\"New request RQ-16: Salary Sheet Print\"}', NULL, '2026-10-25 11:32:10', '2026-10-25 11:32:10'),
('f3446a05-8e42-499f-999e-a1eb2130a9a5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":36,\"ticket_no\":\"RQ-36\",\"message\":\"RQ-36: In Progress \\u2192 Resolved\"}', NULL, '2026-10-28 05:20:10', '2026-10-28 05:20:10'),
('f37fcbb4-aaf5-4a37-a097-c4160d1025c8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":40,\"ticket_no\":\"RQ-40\",\"message\":\"New request RQ-40: Loss\\/Gain Posting Mismatch\"}', '2026-10-28 09:20:39', '2026-10-28 09:02:52', '2026-10-28 09:20:39'),
('f3bc984a-3bc4-4f5a-be24-87ed89aa13fb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', '2026-10-18 12:16:59', '2026-10-18 12:11:44', '2026-10-18 12:16:59'),
('f462ba38-3fef-499f-9185-68f37626e4be', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: In Progress \\u2192 Resolved\"}', '2026-10-18 03:48:46', '2026-10-18 03:47:41', '2026-10-18 03:48:46'),
('f604ac19-87fa-460c-a7f8-9f7c4fb50d9c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', '2026-10-26 03:17:01', '2026-10-25 05:25:59', '2026-10-26 03:17:01'),
('f730d01e-353b-49a9-8fdf-f9f0a6c8596e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', NULL, '2026-10-19 05:25:41', '2026-10-19 05:25:41'),
('f7ff1278-c0c7-4d9b-b39b-2e0713532379', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":25,\"ticket_no\":\"RQ-25\",\"message\":\"New request RQ-25: Salary Sheet Cross Checking\"}', NULL, '2026-10-26 08:30:19', '2026-10-26 08:30:19'),
('f8632498-41a8-4473-b987-40164dc2ff97', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', '2026-10-26 03:17:01', '2026-10-19 05:20:46', '2026-10-26 03:17:01'),
('f8690fd4-e32a-42bb-a187-a337eff3fac7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"New request RQ-18: Establish an internet connection (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', '2026-10-26 04:36:52', '2026-10-25 11:43:21', '2026-10-26 04:36:52'),
('f86caec5-7077-4b7c-a9c9-266a44df4a1e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"RQ-15: User Confirmation \\u2192 Closed\"}', '2026-10-26 12:20:47', '2026-10-26 08:20:44', '2026-10-26 12:20:47'),
('f88f635d-4ef8-4088-8ec6-5820670ce983', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22: you are the primary responsible employee\"}', '2026-10-26 12:20:47', '2026-10-26 07:19:40', '2026-10-26 12:20:47'),
('f90fb4fe-fb6d-4dcd-984c-62d9a61ed4d7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', '2026-10-19 05:13:01', '2026-10-19 05:08:26', '2026-10-19 05:13:01'),
('f92c43bd-b1ae-47cc-b591-beb91f323af9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"RQ-24 has been assigned to MD. MAHABUB ALAM\"}', '2026-10-26 12:20:47', '2026-10-26 07:26:35', '2026-10-26 12:20:47'),
('f94936b9-791a-4522-97b6-f90187fe4542', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":17,\"ticket_no\":\"RQ-17\",\"message\":\"RQ-17: Assigned \\u2192 In Progress\"}', '2026-10-26 04:36:52', '2026-10-26 04:03:14', '2026-10-26 04:36:52'),
('f973eab0-0548-4a2e-ae3d-af38084db354', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":24,\"ticket_no\":\"RQ-24\",\"message\":\"New request RQ-24: CHEQUE VOUCHER Entry\"}', NULL, '2026-10-26 07:24:49', '2026-10-26 07:24:49'),
('f9babdfa-1e36-4f97-ba0c-ca090ba13064', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"Your request RQ-8 was submitted.\"}', '2026-10-19 05:21:05', '2026-10-19 05:20:46', '2026-10-19 05:21:05'),
('fa379a03-cee3-4bed-94f5-2aad235b7730', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: User Confirmation \\u2192 Closed\"}', '2026-10-19 09:11:05', '2026-10-19 09:10:03', '2026-10-19 09:11:05'),
('fa6a1f3e-115f-45e1-b382-3d01ae2a4fb2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":15,\"ticket_no\":\"RQ-15\",\"message\":\"New request RQ-15: Tax certificate Correction\"}', '2026-10-25 11:04:40', '2026-10-25 09:47:58', '2026-10-25 11:04:40'),
('fb8982c5-0b0d-4332-bda8-1675a2865e5c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"New request RQ-18: Establish an internet connection (for MOHAMMAD SHARIFUL ISLAM, filed by Md Tarek Hossain)\"}', NULL, '2026-10-25 11:43:21', '2026-10-25 11:43:21'),
('fc6387dc-c7b3-4652-969e-f72ba0cd9c17', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":39,\"ticket_no\":\"RQ-39\",\"message\":\"RQ-39: you are the primary responsible employee\"}', NULL, '2026-10-28 04:31:27', '2026-10-28 04:31:27'),
('fd1cc50c-aa11-4a14-9d51-a774b1c29d71', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('fd3aadb9-8a79-492c-b790-167b03c34c1c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', NULL, '2026-10-18 12:29:09', '2026-10-18 12:29:09'),
('fd460a86-4315-4e4c-8732-683c39a85794', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":18,\"ticket_no\":\"RQ-18\",\"message\":\"RQ-18: User Confirmation \\u2192 Closed\"}', NULL, '2026-10-25 11:46:09', '2026-10-25 11:46:09'),
('fd6bd65a-246f-49c4-82d9-b0a3e19316f9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', NULL, '2026-10-19 03:25:52', '2026-10-19 03:25:52'),
('fd715b1c-c86b-4c2c-9cde-74380b7d850a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"New request RQ-35: Bank Asia Employee List\"}', '2026-10-28 03:45:05', '2026-10-28 03:22:22', '2026-10-28 03:45:05'),
('fe8779b4-46e1-4cff-8e17-e1ed644f21f9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":28,\"ticket_no\":\"RQ-28\",\"message\":\"New request RQ-28: Hardware Stock Update\"}', NULL, '2026-10-27 09:34:44', '2026-10-27 09:34:44'),
('ff387025-ec13-482e-ba5c-c0a2e7ebe343', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":35,\"ticket_no\":\"RQ-35\",\"message\":\"New request RQ-35: Bank Asia Employee List\"}', NULL, '2026-10-28 03:22:22', '2026-10-28 03:22:22'),
('ff7d6d4a-d7fb-4187-b715-a91eac34246b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":22,\"ticket_no\":\"RQ-22\",\"message\":\"RQ-22 has been assigned to MD. MAHABUB ALAM\"}', '2026-10-26 12:20:47', '2026-10-26 07:19:40', '2026-10-26 12:20:47'),
('fffa9584-7036-4d0c-b709-08f20fdb5ed2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":30,\"ticket_no\":\"RQ-30\",\"message\":\"New request RQ-30: Password Reset For Md Iqbal Hossain of National Mail Server\"}', NULL, '2026-10-27 09:56:33', '2026-10-27 09:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'System Administrator', '[\"ticket.create\",\"ticket.create.behalf\",\"ticket.view.own\",\"ticket.view.all\",\"ticket.comment.public\",\"ticket.note.internal\",\"attachment.upload\",\"attachment.download.internal\",\"dashboard.officer\",\"report.view\",\"attendance.view\",\"user.view\",\"user.create\",\"user.update\",\"lookup.view\",\"lookup.create\",\"lookup.update\",\"settings.view\",\"settings.update\",\"audit.view\",\"role.view\",\"role.create\",\"role.update\",\"role.delete\"]', '2026-10-08 06:28:08', '2026-10-25 10:29:55'),
(2, 'it_officer', 'IT Admin', '[\"ticket.create\",\"ticket.create.behalf\",\"ticket.view.own\",\"ticket.view.all\",\"ticket.acknowledge\",\"ticket.assign\",\"ticket.edit\",\"ticket.work\",\"ticket.comment.public\",\"ticket.note.internal\",\"ticket.close\",\"ticket.reopen\",\"ticket.escalate\",\"ticket.cancel\",\"attachment.upload\",\"attachment.download.internal\",\"dashboard.officer\",\"report.view\",\"lookup.view\",\"lookup.create\",\"lookup.update\",\"user.view\",\"user.create\",\"user.update\"]', '2026-10-08 06:28:08', '2026-10-25 10:29:55'),
(3, 'it_member', 'IT Team Member', '[\"ticket.create\",\"ticket.create.behalf\",\"ticket.view.own\",\"ticket.view.assigned\",\"ticket.work\",\"ticket.comment.public\",\"ticket.note.internal\",\"ticket.escalate\",\"attachment.upload\",\"attachment.download.internal\",\"dashboard.member\",\"attendance.own\"]', '2026-10-08 06:28:08', '2026-10-25 10:29:55'),
(4, 'dept_user', 'Department User', '[\"ticket.create\",\"ticket.view.own\",\"ticket.comment.public\",\"ticket.confirm\",\"ticket.reopen\",\"ticket.cancel\",\"attachment.upload\",\"dashboard.department\"]', '2026-10-08 06:28:08', '2026-10-25 10:29:55'),
(5, 'dept_head', 'Department Head', '[\"ticket.create\",\"ticket.create.behalf.dept\",\"ticket.view.own\",\"ticket.view.department\",\"ticket.comment.public\",\"ticket.confirm\",\"ticket.reopen\",\"ticket.cancel\",\"attachment.upload\",\"dashboard.department\",\"report.view\"]', '2026-10-08 06:28:08', '2026-10-25 10:29:55'),
(6, 'management', 'Management', '[\"ticket.view.all\",\"dashboard.officer\",\"report.view\",\"attendance.view\"]', '2026-10-08 06:28:08', '2026-10-25 10:29:55');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(7, 1),
(4, 2),
(6, 2),
(7, 2),
(15, 2),
(16, 2),
(17, 2),
(5, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(1, 4),
(2, 4),
(18, 4),
(3, 5),
(6, 6),
(7, 6),
(15, 6),
(16, 6),
(17, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dBAJP1SHirV5wEvN3Tr4o8mMXnVjp5mVd45D695m', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGpoeGRzR2ZSOEdKTUQzQkVTU3phTExmYWxsRUt3VXd2SFloOWxscyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1793178621),
('EE8hcHT5XnRbfmKyJj0q548F4JTI32HbbbSmDJGj', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTBqY1hRY3dKQW1MR3pQUTYybVZHOEJtMElUc1FQM3owN1FPblhtaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1793179072),
('f9X8rmYQnPHd45mCpG4Tc3AsvLlVqQUYMhOv1uoR', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkpmZXluU1BMZkQ0TGpKVmVLQklhR3FSdHRjQmtvTzJROGJqakVhWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1793177800),
('jnMQ3JQApZAWYIv21xluZDdhShaKG0MuIMgIIh2l', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGpEVm51eUFtTVNjOGt4TUtTWDhFNFpnNlFSUnhFbW02ZWdBeEd2biI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1793180050),
('mCRQX2aSgzf5tZO2lvhmY7OawcVmbFyE19uHbFbM', 17, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiYW1obVFRZHZ1aDNIWXREVUVFQ1FabElwTldtNmxqbjhkTnUyNWEwRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3BtcyI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNztzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMTk0NmE1OWI0NTg2ZGRhZDA1ZDM4MjllNGQxYjU0ODA4YWEwMGVlZGEwMGY5NWUzZmNmOTMzYWQ5Mzk5MTEwNCI7czoxNjoibGFzdF9hY3Rpdml0eV9hdCI7aToxNzkzMTg0NTQ5O3M6MTY6Imxhc3RfYWN0aXZpdHlfaXAiO3M6MTM6IjEwMy4xNi43My4xMzkiO30=', 1793184549),
('PDMBEqwt18Udg4KC4JxUaf0aYsKVhGjFynq6lycW', 11, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiU1pNblcwSGlCcmdsWFdXcE5jR1FyZkxOS2tCSEdZZXFFWXFLZjV6TiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9teS10YXNrcz8lMkZteS10YXNrcz0iO3M6NToicm91dGUiO3M6MTE6InRhc2tzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImYyN2EyYmY1NDhiMzBmZTUyODM4MDNhNGJhMGU4NjY1NWIxNWRmNmNmMWY5YzhhNWZjNGRiYWUwYThhOTExZjQiO3M6MTY6Imxhc3RfYWN0aXZpdHlfYXQiO2k6MTc5MzE4NDM5NztzOjE2OiJsYXN0X2FjdGl2aXR5X2lwIjtzOjEzOiIxMDMuMTYuNzMuMTM5Ijt9', 1793184397),
('PKRkHg9UY6FzLAbCYWL3ysG6kYfvLmqhaqZRYWwp', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVRBVGJVdVgyVlc3TEJ2RDVjaXJsVHVET1QwVndBVzFOSWZ2TWNmTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1793181771),
('Ry2aYYGcOcqnOaPX0W38LouSpGiWlcjQWuLL4EfM', 13, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZ05xbjZoSUZ1cXRaWllaN1NDTDIwYnF4ZllEVmEwOElXVExRY2J4TyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy90aWNrZXRzLzI2PyUyRnRpY2tldHMlMkYyNj0iO3M6NToicm91dGUiO3M6MTI6InRpY2tldHMuc2hvdyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIwMDE0Mjc5MzQ0NDM5NzRkZjc5MDJlYzRkOWM2NzFiNzQ3YTNhMmNkYTEzOTE5ODEzNmI1ZjczNmIxOWY3ZDMzIjtzOjE2OiJsYXN0X2FjdGl2aXR5X2F0IjtpOjE3OTMxODE1MzY7czoxNjoibGFzdF9hY3Rpdml0eV9pcCI7czoxMzoiMTAzLjE2LjczLjEzNyI7fQ==', 1793181536),
('TuJJlxw2BcGSBxGVVfuhWBkt3fxYd48QRVLDIWmB', 7, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiNG1UWlRySHVGQTBOWDZiVmRQalJuSjBlOTBiQnJJaVhhMWhtUVdCdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy90aWNrZXRzLzI2PyUyRnRpY2tldHMlMkYyNj0iO3M6NToicm91dGUiO3M6MTI6InRpY2tldHMuc2hvdyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImU0N2FlY2QyZGZkZWU2ZjA1MmYzNGU5MTU5OTY1NTMwYzY0NWU4NDViNzg3MWJjMGUyZTQ5NWNlMTU0YmJmNzkiO3M6MTY6Imxhc3RfYWN0aXZpdHlfYXQiO2k6MTc5MzE4NDUwNDtzOjE2OiJsYXN0X2FjdGl2aXR5X2lwIjtzOjEzOiIxMDMuMTYuNzMuMTM5Ijt9', 1793184504),
('uMHllYDoHh433Eivkc6FcLGG9dVeHf1Rs3SPffmd', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkJYMDd1emNpM0dUdTRMSEdjYU43bWpiSldUalBsYnBOam9PVGlwMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1793168231);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'upload.max_kb', '5120', 'upload', '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(2, 'upload.allowed_ext', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,log,zip', 'upload', '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(3, 'ticket.auto_close_days', '3', 'workflow', '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 'ticket.reopen_window_days', '7', 'workflow', '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(6, 'security.max_failed_logins', '5', 'security', '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(7, 'security.lockout_minutes', '15', 'security', '2026-10-08 06:28:08', '2026-10-08 06:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_type_id` bigint UNSIGNED NOT NULL,
  `requester_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `requester_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requester_employee_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requester_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requester_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requester_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `priority_id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferred_completion_date` date DEFAULT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `asset_id` bigint UNSIGNED DEFAULT NULL,
  `approval_required` tinyint(1) NOT NULL DEFAULT '0',
  `sla_response_due_at` timestamp NULL DEFAULT NULL,
  `sla_resolution_due_at` timestamp NULL DEFAULT NULL,
  `sla_status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acknowledged_at` timestamp NULL DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `reopened_at` timestamp NULL DEFAULT NULL,
  `reopen_count` smallint UNSIGNED NOT NULL DEFAULT '0',
  `resolution` text COLLATE utf8mb4_unicode_ci,
  `closed_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_no`, `ticket_type_id`, `requester_id`, `department_id`, `requester_name`, `requester_employee_id`, `requester_designation`, `requester_phone`, `requester_email`, `location_id`, `category_id`, `subcategory_id`, `priority_id`, `status_id`, `subject`, `description`, `preferred_completion_date`, `assigned_to`, `due_date`, `asset_id`, `approval_required`, `sla_response_due_at`, `sla_resolution_due_at`, `sla_status`, `acknowledged_at`, `assigned_at`, `started_at`, `resolved_at`, `closed_at`, `reopened_at`, `reopen_count`, `resolution`, `closed_by`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RQ-1', 2, 15, 1, 'YEASMIN ARA CHOWDHURY', '20051090', 'Sr. ASSTT', '01866823255', 'yeasminsoma0@gmail.com', 1, 2, 14, 3, 11, 'New user need', 'Emp ID: 20251123', NULL, 5, NULL, NULL, 0, '2026-10-18 05:28:31', '2026-10-18 19:28:31', 'on_track', '2026-10-18 03:38:12', '2026-10-18 03:42:44', '2026-10-18 03:43:56', '2026-10-18 03:47:40', '2026-10-18 03:49:13', NULL, 0, 'Resolved', 4, 7, 4, '2026-10-18 03:28:31', '2026-10-18 11:26:18', '2026-10-18 11:26:18'),
(2, 'RQ-2', 2, 7, 1, 'System Administrator', NULL, NULL, NULL, 'nayem.jocl@gmail.com', 1, 5, 46, 3, 11, 'Email Password reset', 'Need to reset pasword for myself', NULL, 5, NULL, NULL, 0, '2026-10-18 08:28:57', '2026-10-18 22:28:57', 'on_track', '2026-10-18 06:31:00', '2026-10-18 06:31:17', '2026-10-18 06:32:44', '2026-10-18 06:33:20', '2026-10-18 06:36:28', NULL, 0, 'Resolved', 4, 7, 4, '2026-10-18 06:28:57', '2026-10-18 11:26:05', '2026-10-18 11:26:05'),
(3, 'RQ-3', 2, 9, 1, 'ISRAT JAHAN', '2', 'Assistant', '01876692194', 'israt29190@gmail.com', 1, 5, 44, 3, 11, 'Need to prepare a document', 'Need to prepare a document with required employee information', NULL, 9, NULL, NULL, 0, '2026-10-18 10:25:26', '2026-10-19 00:25:26', 'on_track', '2026-10-18 08:28:04', '2026-10-18 08:28:04', '2026-10-18 08:31:55', '2026-10-18 08:32:34', '2026-10-18 11:27:35', NULL, 0, 'Resolved', 7, 9, 7, '2026-10-18 08:25:26', '2026-10-18 11:27:35', NULL),
(4, 'RQ-4', 2, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 2, 14, 3, 11, 'Tax Report', 'tax report for 25-26', NULL, 16, NULL, NULL, 0, '2026-10-18 14:11:44', '2026-10-19 04:11:44', 'on_track', '2026-10-18 12:13:32', '2026-10-18 12:13:32', '2026-10-18 12:14:19', '2026-10-18 12:15:06', '2026-10-18 12:15:31', NULL, 0, 'done', 17, 16, 17, '2026-10-18 12:11:44', '2026-10-19 03:29:36', '2026-10-19 03:29:36'),
(5, 'RQ-5', 1, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 11, 3, 1, 'ht', 'htw', NULL, NULL, NULL, NULL, 0, '2026-10-18 14:29:09', '2026-10-19 04:29:09', 'on_track', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 7, NULL, '2026-10-18 12:29:09', '2026-10-19 03:29:23', '2026-10-19 03:29:23'),
(6, 'RQ-6', 2, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 5, NULL, 3, 11, 'Pay Slip Ready For Salary October 2026 (Staff)', 'Please Ready Pay Slip For Salary October 2026 (Staff)', NULL, 12, NULL, NULL, 0, '2026-10-19 05:25:52', '2026-10-19 19:25:52', 'on_track', '2026-10-19 03:26:11', '2026-10-19 03:26:11', '2026-10-19 03:35:17', '2026-10-19 05:06:20', '2026-10-19 05:07:01', NULL, 0, 'work is done', 17, 17, 17, '2026-10-19 03:25:52', '2026-10-19 05:07:01', NULL),
(7, 'RQ-7', 2, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 2, 14, 3, 11, 'Overtime for October 2026 (Other Depot)', 'Ready bank Advice for Overtime October 2026 (Other Depot)', NULL, 12, NULL, NULL, 0, '2026-10-19 07:08:26', '2026-10-19 21:08:26', 'on_track', '2026-10-19 05:09:17', '2026-10-19 05:09:17', '2026-10-19 05:31:44', '2026-10-19 06:35:18', '2026-10-19 06:43:55', NULL, 0, 'Overtime October 2026 (Other Depot) bank Advice has been created and sent to the payroll section.', 17, 17, 17, '2026-10-19 05:08:26', '2026-10-19 06:43:55', NULL),
(8, 'RQ-8', 11, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 52, 3, 3, 'Add depot name', 'Add depot name as location on PMS', NULL, 15, NULL, NULL, 0, '2026-10-19 07:20:46', '2026-10-19 21:20:46', 'on_track', '2026-10-19 05:21:00', '2026-10-19 05:21:00', NULL, NULL, NULL, NULL, 0, NULL, NULL, 7, 7, '2026-10-19 05:20:46', '2026-10-19 05:21:00', NULL),
(9, 'RQ-9', 12, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 6, NULL, 3, 3, 'Mater File Update', 'Update the master file with printed copy of file name.', NULL, 15, '2026-10-19', NULL, 0, '2026-10-19 07:25:41', '2026-10-19 21:25:41', 'on_track', '2026-10-19 05:26:51', '2026-10-19 05:26:51', NULL, NULL, NULL, NULL, 0, NULL, NULL, 7, 7, '2026-10-19 05:25:41', '2026-10-19 05:27:53', NULL),
(10, 'RQ-10', 12, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 6, 53, 3, 11, 'Please write a note on provided documents', 'Please write a note on provided documents', NULL, 9, NULL, NULL, 0, '2026-10-19 09:00:24', '2026-10-19 23:00:24', 'on_track', '2026-10-19 07:01:00', '2026-10-19 07:01:00', '2026-10-19 09:08:23', '2026-10-19 09:09:15', '2026-10-19 09:09:46', NULL, 0, 'Resolved', 17, 17, 17, '2026-10-19 07:00:24', '2026-10-19 09:09:46', NULL),
(11, 'RQ-11', 12, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 6, NULL, 3, 11, 'Update Computer Transfer File', 'Update Computer Transfer File , One Dot printer sent to cumilla Depot', NULL, 9, NULL, NULL, 0, '2026-10-19 09:25:32', '2026-10-19 23:25:32', 'on_track', '2026-10-19 07:25:41', '2026-10-19 07:25:41', '2026-10-19 09:09:36', '2026-10-19 09:09:46', '2026-10-19 09:10:03', NULL, 0, 'Resolved', 17, 17, 17, '2026-10-19 07:25:32', '2026-10-19 09:10:03', NULL),
(12, 'RQ-12', 11, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 14, 3, 11, 'Group 1 & 2 Data input.', 'Input Group 1 & 2 old software September salary data to the new software.', NULL, 12, NULL, NULL, 0, '2026-10-19 09:26:50', '2026-10-19 23:26:50', 'on_track', '2026-10-19 07:29:29', '2026-10-19 07:29:29', '2026-10-19 11:51:45', '2026-10-25 09:29:56', '2026-10-25 09:51:38', NULL, 0, 'Completed the data entry', 7, 7, 7, '2026-10-19 07:26:50', '2026-10-25 09:51:38', NULL),
(13, 'RQ-13', 12, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 6, NULL, 3, 11, 'Preparing Stationary Items List', 'Prepare a list of all stationary and other items of MIS & IT Department', NULL, 13, NULL, NULL, 0, '2026-10-25 06:17:56', '2026-10-25 20:17:56', 'on_track', '2026-10-25 04:26:38', '2026-10-25 04:26:38', '2026-10-25 04:36:48', '2026-10-26 09:24:57', '2026-10-26 09:34:34', NULL, 0, 'Resolved', 7, 7, 7, '2026-10-25 04:17:56', '2026-10-26 09:34:34', NULL),
(14, 'RQ-14', 7, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 12, 3, 6, 'Domain Purchase', 'Proceed to Purchase 2 subdomain from BTCL\r\n1.erp.jamunaoil.gov.bd\r\n2.hrm.jamunaoil.gov.bd', NULL, 16, NULL, NULL, 0, '2026-10-25 07:25:59', '2026-10-25 21:25:59', 'on_track', '2026-10-25 05:26:30', '2026-10-25 05:26:30', '2026-10-26 03:17:19', NULL, NULL, NULL, 0, NULL, NULL, 7, 16, '2026-10-25 05:25:59', '2026-10-27 04:01:09', NULL),
(15, 'RQ-15', 3, 12, 1, 'MD. MAHABUB ALAM', '5', 'Assistent Cum Computer Oparetor', '01613444355', 'mahabubjocl@gmail.com', 1, 5, NULL, 3, 11, 'Tax certificate Correction', 'Tax certificate Correction for retired employees', NULL, 12, NULL, NULL, 0, '2026-10-25 11:47:58', '2026-10-26 01:47:58', 'on_track', '2026-10-25 09:50:39', '2026-10-25 09:50:39', '2026-10-25 10:03:24', '2026-10-26 07:09:15', '2026-10-26 08:20:44', NULL, 0, 'completed the work', 7, 12, 7, '2026-10-25 09:47:58', '2026-10-26 08:20:44', NULL),
(16, 'RQ-16', 1, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 14, 3, 11, 'Salary Sheet Print', 'Print management salary sheet of September 2026 from new software and send this to the salary section.', NULL, 12, NULL, NULL, 0, '2026-10-25 13:32:10', '2026-10-26 03:32:10', 'on_track', '2026-10-25 11:32:21', '2026-10-25 11:32:21', '2026-10-26 03:44:08', '2026-10-26 07:10:13', '2026-10-26 08:20:52', NULL, 0, 'Work is done', 7, 7, 7, '2026-10-25 11:32:10', '2026-10-26 08:20:52', NULL),
(17, 'RQ-17', 1, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 14, 3, 11, 'Bank Advice Checking', 'Check the bank advice of new software and previous software. Correct all those mismatches on new software.', NULL, 9, NULL, NULL, 0, '2026-10-25 13:35:46', '2026-10-26 03:35:46', 'on_track', '2026-10-25 11:35:59', '2026-10-25 11:35:59', '2026-10-26 04:03:14', '2026-10-26 08:18:06', '2026-10-26 08:21:04', NULL, 0, 'Resolved', 7, 7, 7, '2026-10-25 11:35:46', '2026-10-26 08:21:04', NULL),
(18, 'RQ-18', 1, 6, 1, 'MOHAMMAD SHARIFUL ISLAM', '20070725', 'Manager', '01777797319', 'sharif99452@gmail.com', 1, 3, 24, 3, 11, 'Establish an internet connection', 'Establish an internet connection in the DGM (P&E) Room, currently occupied by S. M. OLIUZZAMAN, AGM (E&D) In-Charge & Project Director.', NULL, 16, NULL, NULL, 0, '2026-10-25 13:43:21', '2026-10-26 03:43:21', 'on_track', '2026-10-25 11:44:06', '2026-10-25 11:44:06', '2026-10-25 11:44:26', '2026-10-25 11:45:33', '2026-10-25 11:46:09', NULL, 0, 'internet connection established.', 16, 16, 16, '2026-10-25 11:43:21', '2026-10-25 11:46:09', NULL),
(19, 'RQ-19', 1, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 3, 29, 3, 11, 'Router Configure', 'Need to configure a router and make a wifi network for MIS and IT department.\r\nThis wifi will connect a device with the local network(172 series) not internet.', NULL, 16, NULL, NULL, 0, '2026-10-26 06:36:33', '2026-10-26 20:36:33', 'on_track', '2026-10-26 04:36:47', '2026-10-26 04:36:47', '2026-10-26 05:35:16', '2026-10-26 07:01:37', '2026-10-26 07:02:36', NULL, 0, 'Router configured, and working fine.', 16, 7, 16, '2026-10-26 04:36:33', '2026-10-26 07:02:36', NULL),
(20, 'RQ-20', 11, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 14, 3, 11, 'Salary Sheet Cross Checking', 'Identify the employee ids of group 2 where employees net payable not matched with previous software September 2026 pay slip.', NULL, 10, NULL, NULL, 0, '2026-10-26 06:41:51', '2026-10-26 20:41:51', 'on_track', '2026-10-26 04:42:13', '2026-10-26 04:42:13', '2026-10-26 09:11:20', '2026-10-27 09:46:42', '2026-10-27 10:16:30', NULL, 0, 'Done.', 7, 7, 7, '2026-10-26 04:41:51', '2026-10-27 10:16:30', NULL),
(21, 'RQ-21', 1, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 12, 3, 11, 'Printer setup support', 'Contact with Officer(Depot) of cumilla depot and take necessary step to guide them to print chalan from vat software. \r\nContact person:\r\n1. Md Yeasin, Officer(Depot) \r\n    Whatsapp: 01344544418\r\n2. Atiqur Rahman, Officer(Depot) \r\n    Whatsapp: 01798542502', NULL, 11, NULL, NULL, 0, '2026-10-26 07:06:40', '2026-10-26 21:06:40', 'on_track', '2026-10-26 05:06:51', '2026-10-26 05:06:51', '2026-10-26 06:58:15', '2026-10-26 06:58:41', '2026-10-26 08:18:04', NULL, 0, 'Setup Done.', 7, 7, 7, '2026-10-26 05:06:40', '2026-10-26 08:18:04', NULL),
(22, 'RQ-22', 11, 12, 1, 'MD. MAHABUB ALAM', '5', 'Assistent Cum Computer Oparetor', '01613444355', 'mahabubjocl@gmail.com', 1, 2, 11, 3, 11, 'Depot Pis Entry', 'Depot Pis (August-2026) Need to Data Entry.', NULL, 12, NULL, NULL, 0, '2026-10-26 09:15:50', '2026-10-26 23:15:50', 'on_track', '2026-10-26 07:19:40', '2026-10-26 07:19:40', '2026-10-26 07:22:18', '2026-10-26 10:20:48', '2026-10-26 11:04:21', NULL, 0, 'Depot Pis (August-2026) Data Entry Done and Checklist Send to Cash Section', 7, 12, 7, '2026-10-26 07:15:50', '2026-10-26 11:04:21', NULL),
(23, 'RQ-23', 11, 12, 1, 'MD. MAHABUB ALAM', '5', 'Assistent Cum Computer Oparetor', '01613444355', 'mahabubjocl@gmail.com', 1, 2, 11, 3, 11, 'CASH CREDIT VOUCHER (CCV) Entry', 'CASH CREDIT VOUCHER (CCV) August-2026 Need to Data Entry', NULL, 12, NULL, NULL, 0, '2026-10-26 09:21:45', '2026-10-26 23:21:45', 'on_track', '2026-10-26 07:24:15', '2026-10-26 07:24:15', '2026-10-26 07:25:01', '2026-10-26 12:14:21', '2026-10-26 12:18:01', NULL, 0, 'CASH CREDIT VOUCHER (CCV) August-2026 Data Entry Completed', 7, 12, 7, '2026-10-26 07:21:46', '2026-10-26 12:18:01', NULL),
(24, 'RQ-24', 11, 12, 1, 'MD. MAHABUB ALAM', '5', 'Assistent Cum Computer Oparetor', '01613444355', 'mahabubjocl@gmail.com', 1, 2, 11, 3, 4, 'CHEQUE VOUCHER Entry', 'CHEQUE VOUCHER August-2026 Need to Data Entry', NULL, 12, NULL, NULL, 0, '2026-10-26 09:24:49', '2026-10-26 23:24:49', 'on_track', '2026-10-26 07:26:35', '2026-10-26 07:26:35', '2026-10-26 12:16:04', NULL, NULL, NULL, 0, NULL, NULL, 12, 12, '2026-10-26 07:24:49', '2026-10-26 12:16:04', NULL),
(25, 'RQ-25', 11, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 14, 3, 4, 'Salary Sheet Cross Checking', 'Identify the employee ids of group 1 of new software salary sheet where employees net payable not matched with previous software September 2026 pay slip.', NULL, 9, NULL, NULL, 0, '2026-10-26 10:30:19', '2026-10-27 00:30:19', 'on_track', '2026-10-26 08:30:50', '2026-10-26 08:30:50', '2026-10-26 08:47:04', NULL, NULL, NULL, 0, NULL, NULL, 7, 9, '2026-10-26 08:30:19', '2026-10-26 08:47:04', NULL),
(26, 'RQ-26', 6, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 1, NULL, 3, 4, 'Prepare an IT Equipment Stock & Asset Summary', 'Prepare a list of IT equipment\'s of MIS & IT department with following information:\r\n1. All equipment list covering equipment category, equipment name, Brand & Model.\r\n2. In stock quantity\r\n3. In use quantity', NULL, 13, NULL, NULL, 0, '2026-10-26 14:13:46', '2026-10-27 04:13:46', 'on_track', '2026-10-26 12:15:56', '2026-10-26 12:15:56', '2026-10-27 03:17:45', NULL, NULL, NULL, 0, NULL, NULL, 7, 13, '2026-10-26 12:13:46', '2026-10-27 03:17:45', NULL),
(27, 'RQ-27', 1, 6, 1, 'MOHAMMAD SHARIFUL ISLAM', '20070725', 'Manager', '01777797319', 'sharif99452@gmail.com', 1, 2, NULL, 3, 4, 'Install Oracle 19c on a laptop', 'install oracle 19c in a laptop for database testing and configure new report, etc.', NULL, 16, NULL, NULL, 0, '2026-10-27 07:03:28', '2026-10-27 21:03:28', 'on_track', '2026-10-27 05:04:14', '2026-10-27 05:04:14', '2026-10-27 05:04:26', NULL, NULL, NULL, 0, NULL, NULL, 16, 16, '2026-10-27 05:03:28', '2026-10-27 05:04:26', NULL),
(28, 'RQ-28', 11, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 1, 1, 3, 11, 'Hardware Stock Update', 'Please update Hardware Stock date column', NULL, 9, NULL, NULL, 0, '2026-10-27 11:34:44', '2026-10-28 01:34:44', 'on_track', '2026-10-27 09:35:54', '2026-10-27 09:35:54', '2026-10-27 09:38:43', '2026-10-27 10:00:17', '2026-10-27 10:05:16', NULL, 0, 'Updated', 17, 17, 17, '2026-10-27 09:34:44', '2026-10-27 10:05:16', NULL),
(29, 'RQ-29', 6, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 1, 10, 3, 4, 'Make a Note & Detail Description on Newly purchased 51 Desktop', 'Make a Note Attached with Details of  Allowcation & Description on Newly purchased 51 Desktop', NULL, 17, NULL, NULL, 0, '2026-10-27 11:53:59', '2026-10-28 01:53:59', 'on_track', '2026-10-27 09:54:25', '2026-10-27 09:54:25', '2026-10-27 09:54:28', NULL, NULL, NULL, 0, NULL, NULL, 17, 17, '2026-10-27 09:53:59', '2026-10-27 09:54:28', NULL),
(30, 'RQ-30', 1, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 5, 31, 3, 4, 'Password Reset For Md Iqbal Hossain of National Mail Server', 'Password Reset For Md Iqbal Hossain of National Mail Server', NULL, 17, NULL, NULL, 0, '2026-10-27 11:56:33', '2026-10-28 01:56:33', 'on_track', '2026-10-27 09:56:47', '2026-10-27 09:56:47', '2026-10-27 09:56:49', NULL, NULL, NULL, 0, NULL, NULL, 17, 17, '2026-10-27 09:56:33', '2026-10-27 09:56:49', NULL),
(31, 'RQ-31', 6, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 2, 14, 3, 4, 'Ready & Provide All Salary Report for the Month of October 2026', 'Ready & Provide All Salary Report for the Month of October 2026', NULL, 17, '2026-10-27', NULL, 0, '2026-10-27 11:58:06', '2026-10-28 01:58:06', 'on_track', '2026-10-27 09:58:22', '2026-10-27 09:58:22', '2026-10-27 09:58:42', NULL, NULL, NULL, 0, NULL, NULL, 17, 17, '2026-10-27 09:58:06', '2026-10-27 09:58:42', NULL),
(32, 'RQ-32', 1, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 2, 52, 3, 4, 'Add Status option in My Requests Menu', 'Please Add Status option in My Requests Menu', NULL, 7, '2026-10-27', NULL, 0, '2026-10-27 12:00:50', '2026-10-28 02:00:50', 'on_track', '2026-10-27 10:08:28', '2026-10-27 10:08:28', '2026-10-27 10:15:42', NULL, NULL, NULL, 0, NULL, NULL, 17, 7, '2026-10-27 10:00:50', '2026-10-27 10:15:42', NULL),
(33, 'RQ-33', 1, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 2, 52, 3, 4, 'Add Product Serial Number in INVENTORY Menu', 'Please Add Product Serial Number in INVENTORY Menu', NULL, 7, '2026-10-27', NULL, 0, '2026-10-27 12:02:44', '2026-10-28 02:02:44', 'on_track', '2026-10-27 10:02:53', '2026-10-27 10:02:53', '2026-10-27 10:15:49', NULL, NULL, NULL, 0, NULL, NULL, 17, 7, '2026-10-27 10:02:44', '2026-10-27 10:15:49', NULL),
(34, 'RQ-34', 1, 18, 2, 'MOHAMMAD MAHFUZUR RAHMAN', '20251345', 'Officer', '01863356933', 'mahfuz.rahman@jamunaoil.gov.bd', 1, 3, 22, 3, 2, 'To arrange the LAN wiring', 'My PC has a dedicated server connection for the company\'s ERP software that was developed by Howlader. The server line/wiring cable has been connected haphazardly that looks absurd. I am requesting to rearranging the wiring cable.', NULL, NULL, NULL, NULL, 0, '2026-10-27 15:47:25', '2026-10-28 05:47:25', 'on_track', '2026-10-28 03:39:27', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 18, 7, '2026-10-27 13:47:25', '2026-10-28 03:39:27', NULL),
(35, 'RQ-35', 13, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 2, 14, 3, 11, 'Bank Asia Employee List', 'Please Provide employee list having acount in Bank Asia', NULL, 17, '2026-10-28', NULL, 0, '2026-10-28 05:22:21', '2026-10-28 19:22:21', 'on_track', '2026-10-28 03:22:34', '2026-10-28 03:22:34', '2026-10-28 03:22:40', '2026-10-28 04:20:14', '2026-10-28 04:20:19', NULL, 0, 'Bank Asia employee list has been sent', 17, 17, 17, '2026-10-28 03:22:21', '2026-10-28 04:20:19', NULL),
(36, 'RQ-36', 1, 16, 1, 'Md Tarek Hossain', '1357', 'Junior Officer', '01844290967', 'tarek.jocl@gmail.com', 1, 3, NULL, 3, 9, 'No Internet issue', 'Faysal Mahmud, Officer (E&D)\r\nLocation: DGM (P&E), Ground Floor', NULL, 11, NULL, NULL, 0, '2026-10-28 05:56:27', '2026-10-28 19:56:27', 'on_track', '2026-10-28 03:56:38', '2026-10-28 03:56:38', '2026-10-28 05:20:03', '2026-10-28 05:20:10', NULL, NULL, 0, 'DONE', NULL, 16, 11, '2026-10-28 03:56:27', '2026-10-28 05:20:10', NULL),
(37, 'RQ-37', 1, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 6, 53, 3, 4, 'Draft a note for computer Accesories Inventory', 'Draft a note for computer Accesories Inventory', NULL, 17, '2026-10-28', NULL, 0, '2026-10-28 06:04:40', '2026-10-28 20:04:40', 'on_track', '2026-10-28 04:04:55', '2026-10-28 04:04:55', '2026-10-28 04:05:02', NULL, NULL, NULL, 0, NULL, NULL, 17, 17, '2026-10-28 04:04:40', '2026-10-28 04:05:02', NULL),
(38, 'RQ-38', 6, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 6, 53, 3, 3, 'Draft a note for Awareness regarding Cyber Scurity', 'Draft a note for Awareness regarding Cyber Scurity', NULL, 17, '2026-10-28', NULL, 0, '2026-10-28 06:08:18', '2026-10-28 20:08:18', 'on_track', '2026-10-28 04:08:29', '2026-10-28 04:08:29', NULL, NULL, NULL, NULL, 0, NULL, NULL, 17, 17, '2026-10-28 04:08:18', '2026-10-28 04:08:29', NULL),
(39, 'RQ-39', 1, 12, 1, 'MD. MAHABUB ALAM', '5', 'Assistent Cum Computer Oparetor', '01613444355', 'mahabubjocl@gmail.com', 1, 5, 54, 3, 11, 'Office Order', 'Publication of office orders_ Date-27-10-2026\r\nMemorial No. 28.24.0000.005.19.001.26-664', NULL, 12, NULL, NULL, 0, '2026-10-28 06:31:07', '2026-10-28 20:31:07', 'on_track', '2026-10-28 04:31:27', '2026-10-28 04:31:27', '2026-10-28 04:31:44', '2026-10-28 06:01:00', '2026-10-28 06:44:34', NULL, 0, 'Office Order Update done', 7, 12, 7, '2026-10-28 04:31:07', '2026-10-28 06:44:34', NULL),
(40, 'RQ-40', 1, 16, 1, 'Md Tarek Hossain', '1357', 'Junior Officer', '01844290967', 'tarek.jocl@gmail.com', 1, 2, NULL, 3, 11, 'Loss/Gain Posting Mismatch', 'Find-out mismatch posting in Rangpur Railhead Depot', NULL, 16, NULL, NULL, 0, '2026-10-28 11:02:52', '2026-10-29 01:02:52', 'on_track', '2026-10-28 09:03:02', '2026-10-28 09:03:02', '2026-10-28 09:03:08', '2026-10-28 09:35:50', '2026-10-28 09:36:01', NULL, 0, 'solution provided.', 16, 16, 16, '2026-10-28 09:02:52', '2026-10-28 09:36:01', NULL),
(41, 'RQ-41', 6, 17, 1, 'Md Sajjad Hossain', '1308', 'Officer', '01830310919', 'sajjad.jocl2020@gmail.com', 1, 1, 10, 3, 3, 'Listing of Damaged Items for sent to HR Department', 'Listing of Damaged Items for sent to HR Department', NULL, 12, '2026-10-28', NULL, 0, '2026-10-28 12:47:29', '2026-10-29 02:47:29', 'on_track', '2026-10-28 10:48:26', '2026-10-28 10:48:26', NULL, NULL, NULL, NULL, 0, NULL, NULL, 17, 17, '2026-10-28 10:47:29', '2026-10-28 10:48:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_assignments`
--

CREATE TABLE `ticket_assignments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `assigned_by` bigint UNSIGNED NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SUPPORT',
  `primary_marker` tinyint UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `work_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ASSIGNED',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_assignments`
--

INSERT INTO `ticket_assignments` (`id`, `ticket_id`, `employee_id`, `assigned_by`, `role`, `primary_marker`, `assigned_at`, `work_status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 4, 'SUPPORT', NULL, '2026-10-18 03:38:12', 'DONE', NULL, '2026-10-18 03:38:12', '2026-10-18 03:47:40'),
(3, 1, 5, 4, 'PRIMARY', 1, '2026-10-18 03:40:58', 'DONE', NULL, '2026-10-18 03:40:58', '2026-10-18 03:47:40'),
(4, 2, 5, 4, 'PRIMARY', 1, '2026-10-18 06:30:59', 'DONE', NULL, '2026-10-18 06:30:59', '2026-10-18 06:33:20'),
(5, 2, 9, 4, 'SUPPORT', NULL, '2026-10-18 06:31:00', 'DONE', NULL, '2026-10-18 06:31:00', '2026-10-18 06:33:20'),
(7, 3, 9, 4, 'PRIMARY', 1, '2026-10-18 08:28:04', 'DONE', NULL, '2026-10-18 08:28:04', '2026-10-18 08:32:34'),
(8, 4, 16, 17, 'PRIMARY', 1, '2026-10-18 12:13:32', 'DONE', NULL, '2026-10-18 12:13:32', '2026-10-18 12:15:06'),
(9, 6, 12, 17, 'PRIMARY', 1, '2026-10-19 03:26:11', 'DONE', NULL, '2026-10-19 03:26:11', '2026-10-19 05:06:20'),
(10, 7, 12, 17, 'PRIMARY', 1, '2026-10-19 05:09:17', 'DONE', NULL, '2026-10-19 05:09:17', '2026-10-19 06:35:18'),
(11, 8, 15, 7, 'PRIMARY', 1, '2026-10-19 05:21:00', 'ASSIGNED', NULL, '2026-10-19 05:21:00', '2026-10-19 05:21:00'),
(12, 9, 15, 7, 'PRIMARY', 1, '2026-10-19 05:26:51', 'ASSIGNED', NULL, '2026-10-19 05:26:51', '2026-10-19 05:26:51'),
(13, 10, 9, 17, 'PRIMARY', 1, '2026-10-19 07:01:00', 'DONE', NULL, '2026-10-19 07:01:00', '2026-10-19 09:09:15'),
(14, 11, 9, 17, 'PRIMARY', 1, '2026-10-19 07:25:41', 'DONE', NULL, '2026-10-19 07:25:41', '2026-10-19 09:09:46'),
(15, 12, 8, 7, 'SUPPORT', NULL, '2026-10-19 07:29:29', 'DONE', NULL, '2026-10-19 07:29:29', '2026-10-25 09:29:56'),
(16, 12, 9, 7, 'SUPPORT', NULL, '2026-10-19 07:29:29', 'DONE', NULL, '2026-10-19 07:29:29', '2026-10-25 09:29:56'),
(17, 12, 11, 7, 'SUPPORT', NULL, '2026-10-19 07:29:29', 'DONE', NULL, '2026-10-19 07:29:29', '2026-10-25 09:29:56'),
(18, 12, 12, 7, 'PRIMARY', 1, '2026-10-19 07:29:29', 'DONE', NULL, '2026-10-19 07:29:29', '2026-10-25 09:29:56'),
(19, 13, 13, 7, 'PRIMARY', 1, '2026-10-25 04:26:38', 'DONE', NULL, '2026-10-25 04:26:38', '2026-10-26 09:24:57'),
(20, 14, 16, 7, 'PRIMARY', 1, '2026-10-25 05:26:30', 'WAITING', NULL, '2026-10-25 05:26:30', '2026-10-27 04:01:09'),
(21, 15, 12, 7, 'PRIMARY', 1, '2026-10-25 09:50:39', 'DONE', NULL, '2026-10-25 09:50:39', '2026-10-26 07:09:15'),
(22, 16, 12, 7, 'PRIMARY', 1, '2026-10-25 11:32:21', 'DONE', NULL, '2026-10-25 11:32:21', '2026-10-26 07:10:13'),
(23, 17, 9, 7, 'PRIMARY', 1, '2026-10-25 11:35:59', 'DONE', NULL, '2026-10-25 11:35:59', '2026-10-26 08:18:06'),
(24, 18, 11, 16, 'SUPPORT', NULL, '2026-10-25 11:44:06', 'DONE', NULL, '2026-10-25 11:44:06', '2026-10-25 11:45:33'),
(25, 18, 16, 16, 'PRIMARY', 1, '2026-10-25 11:44:06', 'DONE', NULL, '2026-10-25 11:44:06', '2026-10-25 11:45:33'),
(26, 19, 11, 7, 'SUPPORT', NULL, '2026-10-26 04:36:47', 'DONE', NULL, '2026-10-26 04:36:47', '2026-10-26 07:01:37'),
(27, 19, 16, 7, 'PRIMARY', 1, '2026-10-26 04:36:47', 'DONE', NULL, '2026-10-26 04:36:47', '2026-10-26 07:01:37'),
(28, 20, 10, 7, 'PRIMARY', 1, '2026-10-26 04:42:13', 'DONE', NULL, '2026-10-26 04:42:13', '2026-10-27 09:46:42'),
(29, 21, 11, 7, 'PRIMARY', 1, '2026-10-26 05:06:51', 'DONE', NULL, '2026-10-26 05:06:51', '2026-10-26 06:58:41'),
(30, 22, 12, 7, 'PRIMARY', 1, '2026-10-26 07:19:40', 'DONE', NULL, '2026-10-26 07:19:40', '2026-10-26 10:20:48'),
(31, 23, 12, 7, 'PRIMARY', 1, '2026-10-26 07:24:15', 'DONE', NULL, '2026-10-26 07:24:15', '2026-10-26 12:14:21'),
(32, 24, 8, 7, 'SUPPORT', NULL, '2026-10-26 07:26:35', 'ASSIGNED', NULL, '2026-10-26 07:26:35', '2026-10-26 07:26:35'),
(33, 24, 12, 7, 'PRIMARY', 1, '2026-10-26 07:26:35', 'IN_PROGRESS', NULL, '2026-10-26 07:26:35', '2026-10-26 12:16:04'),
(34, 25, 9, 7, 'PRIMARY', 1, '2026-10-26 08:30:50', 'IN_PROGRESS', NULL, '2026-10-26 08:30:50', '2026-10-26 08:47:04'),
(35, 25, 10, 7, 'SUPPORT', NULL, '2026-10-26 08:30:50', 'ASSIGNED', NULL, '2026-10-26 08:30:50', '2026-10-26 08:30:50'),
(36, 26, 7, 7, 'SUPPORT', NULL, '2026-10-26 12:15:56', 'ASSIGNED', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
(37, 26, 11, 7, 'SUPPORT', NULL, '2026-10-26 12:15:56', 'ASSIGNED', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
(38, 26, 12, 7, 'SUPPORT', NULL, '2026-10-26 12:15:56', 'ASSIGNED', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
(39, 26, 13, 7, 'PRIMARY', 1, '2026-10-26 12:15:56', 'IN_PROGRESS', 'PRINTER,SCANER,MOUSE,UPS,APPLICATION SERVER,LAPTOP LIST DONE.', '2026-10-26 12:15:56', '2026-10-28 09:58:56'),
(40, 26, 16, 7, 'SUPPORT', NULL, '2026-10-26 12:15:56', 'ASSIGNED', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
(41, 26, 17, 7, 'SUPPORT', NULL, '2026-10-26 12:15:56', 'ASSIGNED', NULL, '2026-10-26 12:15:56', '2026-10-26 12:15:56'),
(42, 27, 16, 16, 'PRIMARY', 1, '2026-10-27 05:04:14', 'IN_PROGRESS', NULL, '2026-10-27 05:04:14', '2026-10-27 05:04:26'),
(43, 28, 9, 17, 'PRIMARY', 1, '2026-10-27 09:35:54', 'DONE', NULL, '2026-10-27 09:35:54', '2026-10-27 10:00:17'),
(44, 29, 17, 17, 'PRIMARY', 1, '2026-10-27 09:54:25', 'IN_PROGRESS', NULL, '2026-10-27 09:54:25', '2026-10-27 09:54:28'),
(45, 30, 17, 17, 'PRIMARY', 1, '2026-10-27 09:56:47', 'IN_PROGRESS', NULL, '2026-10-27 09:56:47', '2026-10-27 09:56:49'),
(46, 31, 17, 17, 'PRIMARY', 1, '2026-10-27 09:58:22', 'IN_PROGRESS', NULL, '2026-10-27 09:58:22', '2026-10-27 09:58:42'),
(47, 33, 7, 17, 'PRIMARY', 1, '2026-10-27 10:02:53', 'IN_PROGRESS', NULL, '2026-10-27 10:02:53', '2026-10-27 10:15:49'),
(48, 32, 7, 17, 'PRIMARY', 1, '2026-10-27 10:08:28', 'IN_PROGRESS', NULL, '2026-10-27 10:08:28', '2026-10-27 10:15:42'),
(49, 35, 17, 17, 'PRIMARY', 1, '2026-10-28 03:22:34', 'DONE', NULL, '2026-10-28 03:22:34', '2026-10-28 04:20:14'),
(50, 36, 11, 16, 'PRIMARY', 1, '2026-10-28 03:56:38', 'DONE', NULL, '2026-10-28 03:56:38', '2026-10-28 05:20:10'),
(51, 37, 17, 17, 'PRIMARY', 1, '2026-10-28 04:04:55', 'IN_PROGRESS', NULL, '2026-10-28 04:04:55', '2026-10-28 04:05:02'),
(52, 38, 17, 17, 'PRIMARY', 1, '2026-10-28 04:08:29', 'ASSIGNED', NULL, '2026-10-28 04:08:29', '2026-10-28 04:08:29'),
(53, 39, 12, 7, 'PRIMARY', 1, '2026-10-28 04:31:27', 'DONE', NULL, '2026-10-28 04:31:27', '2026-10-28 06:01:00'),
(54, 40, 16, 16, 'PRIMARY', 1, '2026-10-28 09:03:02', 'DONE', NULL, '2026-10-28 09:03:02', '2026-10-28 09:35:50'),
(55, 41, 8, 17, 'SUPPORT', NULL, '2026-10-28 10:48:26', 'ASSIGNED', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
(56, 41, 11, 17, 'SUPPORT', NULL, '2026-10-28 10:48:26', 'ASSIGNED', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
(57, 41, 12, 17, 'PRIMARY', 1, '2026-10-28 10:48:26', 'ASSIGNED', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26'),
(58, 41, 13, 17, 'SUPPORT', NULL, '2026-10-28 10:48:26', 'ASSIGNED', NULL, '2026-10-28 10:48:26', '2026-10-28 10:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_assignment_log`
--

CREATE TABLE `ticket_assignment_log` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `assigned_to` bigint UNSIGNED NOT NULL,
  `assigned_from` bigint UNSIGNED DEFAULT NULL,
  `assigned_by` bigint UNSIGNED NOT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stored_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_bytes` bigint UNSIGNED NOT NULL,
  `sha256` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_internal` tinyint(1) NOT NULL DEFAULT '0',
  `scan_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_attachments`
--

INSERT INTO `ticket_attachments` (`id`, `ticket_id`, `comment_id`, `uploaded_by`, `original_name`, `stored_path`, `mime_type`, `extension`, `size_bytes`, `sha256`, `is_internal`, `scan_status`, `created_at`, `updated_at`) VALUES
(1, 13, 19, 13, 'এমআইএস আইটি মালামাল লিস্ট.docx', 'ticket-attachments/13/lVpDeP0K3pNEW2s52imT0s362HCJH7jyvKwyxZUh.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'docx', 17652, '119ea82854e4bf57a60adefe4a8558f303a1bea933920f444506cce7c002faad', 0, 'skipped', '2026-10-26 06:32:15', '2026-10-26 06:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_categories`
--

INSERT INTO `ticket_categories` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hardware', 1, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(2, 'Software', 2, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(3, 'Network', 3, 1, '2026-10-08 06:28:08', '2026-10-18 11:34:34'),
(4, 'User & Access', 4, 0, '2026-10-08 06:28:08', '2026-10-18 11:34:28'),
(5, 'IT Service', 5, 1, '2026-10-08 06:28:08', '2026-10-18 11:34:30'),
(6, 'Others', 6, 1, '2026-10-08 06:28:08', '2026-10-18 11:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_comments`
--

INSERT INTO `ticket_comments` (`id`, `ticket_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'I have started the task', '2026-10-18 03:43:56', '2026-10-18 03:43:56'),
(2, 1, 5, 'Resolved', '2026-10-18 03:47:40', '2026-10-18 03:47:40'),
(3, 1, 4, 'Checked and found ok', '2026-10-18 03:49:13', '2026-10-18 03:49:13'),
(4, 2, 5, 'Resolved', '2026-10-18 06:33:20', '2026-10-18 06:33:20'),
(5, 2, 4, 'It not resolved', '2026-10-18 06:34:27', '2026-10-18 06:34:27'),
(6, 2, 4, 'gserg', '2026-10-18 06:36:28', '2026-10-18 06:36:28'),
(7, 3, 9, 'Resolved', '2026-10-18 08:32:34', '2026-10-18 08:32:34'),
(8, 3, 7, 'Solved', '2026-10-18 11:27:35', '2026-10-18 11:27:35'),
(9, 4, 16, 'done', '2026-10-18 12:15:06', '2026-10-18 12:15:06'),
(10, 4, 17, 'Work is done', '2026-10-18 12:15:31', '2026-10-18 12:15:31'),
(11, 6, 12, 'work is done', '2026-10-19 05:06:20', '2026-10-19 05:06:20'),
(12, 7, 12, 'Overtime October 2026 (Other Depot) bank Advice has been created and sent to the payroll section.', '2026-10-19 06:35:18', '2026-10-19 06:35:18'),
(13, 10, 9, 'Resolved', '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
(14, 11, 9, 'Resolved', '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
(15, 12, 12, 'Completed the data entry', '2026-10-25 09:29:56', '2026-10-25 09:29:56'),
(16, 12, 7, 'Entry completed.', '2026-10-25 09:51:38', '2026-10-25 09:51:38'),
(17, 18, 16, 'internet connection established.', '2026-10-25 11:45:33', '2026-10-25 11:45:33'),
(18, 18, 16, 'checked and found working fine.', '2026-10-25 11:46:09', '2026-10-25 11:46:09'),
(19, 13, 13, 'স্যার ঠিক আসে কিনা একটু দেখেন।', '2026-10-26 06:32:15', '2026-10-26 06:32:15'),
(20, 21, 11, 'Setup Done.', '2026-10-26 06:58:41', '2026-10-26 06:58:41'),
(21, 19, 16, 'Router configured, and working fine.', '2026-10-26 07:01:37', '2026-10-26 07:01:37'),
(22, 19, 16, 'Confirmed.', '2026-10-26 07:02:36', '2026-10-26 07:02:36'),
(23, 15, 12, 'completed the work', '2026-10-26 07:09:15', '2026-10-26 07:09:15'),
(24, 16, 12, 'Work is done', '2026-10-26 07:10:13', '2026-10-26 07:10:13'),
(25, 22, 7, 'Let us know the approximate total count of PIS(August-2026) when you complete this task.', '2026-10-26 07:21:43', '2026-10-26 07:21:43'),
(26, 23, 7, 'Let us know the approximate total count of CASH CREDIT VOUCHER (CCV) August-2026 when you complete this task.', '2026-10-26 07:25:37', '2026-10-26 07:25:37'),
(27, 24, 7, 'Let us know how many CHEQUE VOUCHER of August-2026 entry completed by you and your team members separately.', '2026-10-26 07:28:42', '2026-10-26 07:28:42'),
(28, 17, 9, 'Resolved', '2026-10-26 08:18:06', '2026-10-26 08:18:06'),
(29, 13, 13, 'Resolved', '2026-10-26 09:24:57', '2026-10-26 09:24:57'),
(30, 22, 12, 'Depot Pis (August-2026) Data Entry Done and Checklist Send to Cash Section', '2026-10-26 10:20:48', '2026-10-26 10:20:48'),
(31, 23, 12, 'CASH CREDIT VOUCHER (CCV) August-2026 Data Entry Completed', '2026-10-26 12:14:21', '2026-10-26 12:14:21'),
(32, 24, 12, 'Currently, the check voucher has been entry completed up to 10th of August 2026', '2026-10-26 12:20:16', '2026-10-26 12:20:16'),
(33, 14, 16, 'btcl website is not accessible right now', '2026-10-27 04:01:09', '2026-10-27 04:01:09'),
(34, 20, 7, 'How many employees checking completed yet.', '2026-10-27 06:49:12', '2026-10-27 06:49:12'),
(35, 20, 10, 'Done.', '2026-10-27 09:46:42', '2026-10-27 09:46:42'),
(36, 28, 9, 'Updated', '2026-10-27 10:00:17', '2026-10-27 10:00:17'),
(37, 26, 13, 'Hello sir,\r\nI have completed two items on the list today.\r\nDesktop ( CPU) & Monitor', '2026-10-27 10:02:13', '2026-10-27 10:02:13'),
(38, 26, 13, 'Hello sir,\r\nI have completed two items on the list today.\r\nDesktop ( CPU) & Monitor', '2026-10-27 10:02:13', '2026-10-27 10:02:13'),
(39, 20, 10, '73', '2026-10-27 10:22:20', '2026-10-27 10:22:20'),
(40, 35, 17, 'Bank Asia employee list has been sent', '2026-10-28 04:20:14', '2026-10-28 04:20:14'),
(41, 36, 11, 'DONE', '2026-10-28 05:20:03', '2026-10-28 05:20:03'),
(42, 36, 11, 'DONE', '2026-10-28 05:20:10', '2026-10-28 05:20:10'),
(43, 26, 11, 'GOOD JOB.', '2026-10-28 05:20:49', '2026-10-28 05:20:49'),
(44, 39, 12, 'Office Order Update done', '2026-10-28 06:01:00', '2026-10-28 06:01:00'),
(45, 26, 13, 'PRINTER,SCANER,MOUSE,UPS,APPLICATION SERVER LIST DONE.', '2026-10-28 08:59:02', '2026-10-28 08:59:02'),
(46, 40, 16, 'solution provided.', '2026-10-28 09:35:50', '2026-10-28 09:35:50'),
(47, 40, 16, 'confirmed', '2026-10-28 09:36:01', '2026-10-28 09:36:01'),
(48, 26, 13, 'LAPTOP LIST DONE', '2026-10-28 09:57:26', '2026-10-28 09:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_history`
--

CREATE TABLE `ticket_history` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_history`
--

INSERT INTO `ticket_history` (`id`, `ticket_id`, `user_id`, `action`, `field`, `old_value`, `new_value`, `remark`, `created_at`) VALUES
(1, 1, 7, 'created_on_behalf', NULL, NULL, 'YEASMIN ARA CHOWDHURY', 'New user need', '2026-10-18 03:28:31'),
(2, 1, 4, 'team_added', 'team', NULL, 'ISRAT JAHAN (Supporting)', NULL, '2026-10-18 03:38:12'),
(3, 1, 4, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-18 03:38:12'),
(4, 1, 4, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-18 03:38:12'),
(5, 1, 4, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-18 03:38:12'),
(6, 1, 4, 'team_added', 'team', NULL, 'IT Employee (Supporting)', NULL, '2026-10-18 03:40:58'),
(7, 1, 4, 'team_removed', 'team', 'MD. MAHABUB ALAM', NULL, NULL, '2026-10-18 03:42:44'),
(8, 1, 4, 'team_role_changed', 'team', 'IT Employee (Supporting)', 'IT Employee (Primary)', NULL, '2026-10-18 03:42:44'),
(9, 1, 4, 'reassigned', 'assigned_to', 'MD. MAHABUB ALAM', 'IT Employee', NULL, '2026-10-18 03:42:44'),
(10, 1, 5, 'status_changed', 'status', 'Assigned', 'In Progress', 'I have started the task', '2026-10-18 03:43:56'),
(11, 1, 5, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-18 03:47:40'),
(12, 1, 5, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-18 03:47:41'),
(13, 1, 4, 'status_changed', 'status', 'User Confirmation', 'Closed', 'Checked and found ok', '2026-10-18 03:49:13'),
(14, 2, 7, 'created', NULL, NULL, 'RQ-2', 'Email Password reset', '2026-10-18 06:28:57'),
(15, 2, 4, 'team_added', 'team', NULL, 'IT Employee (Supporting)', NULL, '2026-10-18 06:31:00'),
(16, 2, 4, 'team_added', 'team', NULL, 'ISRAT JAHAN (Supporting)', NULL, '2026-10-18 06:31:00'),
(17, 2, 4, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-18 06:31:00'),
(18, 2, 4, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-18 06:31:00'),
(19, 2, 4, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-18 06:31:00'),
(20, 2, 4, 'team_removed', 'team', 'MD. MAHABUB ALAM', NULL, NULL, '2026-10-18 06:31:17'),
(21, 2, 4, 'team_role_changed', 'team', 'IT Employee (Supporting)', 'IT Employee (Primary)', NULL, '2026-10-18 06:31:17'),
(22, 2, 4, 'reassigned', 'assigned_to', 'MD. MAHABUB ALAM', 'IT Employee', NULL, '2026-10-18 06:31:17'),
(23, 2, 5, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-18 06:32:44'),
(24, 2, 5, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-18 06:33:20'),
(25, 2, 5, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-18 06:33:20'),
(26, 2, 4, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-18 06:34:27'),
(27, 2, 4, 'status_changed', 'status', 'User Confirmation', 'Closed', 'gserg', '2026-10-18 06:36:28'),
(28, 3, 9, 'created', NULL, NULL, 'RQ-3', 'Need to prepare a document', '2026-10-18 08:25:26'),
(29, 3, 4, 'team_added', 'team', NULL, 'ISRAT JAHAN (Primary)', NULL, '2026-10-18 08:28:04'),
(30, 3, 4, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-18 08:28:04'),
(31, 3, 4, 'assigned', 'assigned_to', NULL, 'ISRAT JAHAN', NULL, '2026-10-18 08:28:04'),
(32, 3, 9, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-18 08:31:55'),
(33, 3, 9, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-18 08:32:34'),
(34, 3, 9, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-18 08:32:34'),
(35, 3, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', 'Solved', '2026-10-18 11:27:35'),
(36, 4, 16, 'created_on_behalf', NULL, NULL, 'Md Sajjad Hossain', 'Tax Report', '2026-10-18 12:11:44'),
(37, 4, 17, 'team_added', 'team', NULL, 'Md Tarek Hossain (Primary)', NULL, '2026-10-18 12:13:32'),
(38, 4, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-18 12:13:32'),
(39, 4, 17, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-18 12:13:32'),
(40, 4, 16, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-18 12:14:19'),
(41, 4, 16, 'status_changed', 'status', 'In Progress', 'Resolved', 'done', '2026-10-18 12:15:06'),
(42, 4, 16, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-18 12:15:06'),
(43, 4, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', 'Work is done', '2026-10-18 12:15:31'),
(44, 5, 7, 'created', NULL, NULL, 'RQ-5', 'ht', '2026-10-18 12:29:09'),
(45, 6, 17, 'created', NULL, NULL, 'RQ-6', 'Pay Slip Ready For Salary October 2026 (Staff)', '2026-10-19 03:25:52'),
(46, 6, 17, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-19 03:26:11'),
(47, 6, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 03:26:11'),
(48, 6, 17, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-19 03:26:11'),
(49, 6, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-19 03:35:17'),
(50, 6, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'work is done', '2026-10-19 05:06:20'),
(51, 6, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-19 05:06:20'),
(52, 6, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-19 05:07:01'),
(53, 7, 17, 'created', NULL, NULL, 'RQ-7', 'Overtime for October 2026 (Other Depot)', '2026-10-19 05:08:26'),
(54, 7, 17, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-19 05:09:17'),
(55, 7, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 05:09:17'),
(56, 7, 17, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-19 05:09:17'),
(57, 8, 7, 'created', NULL, NULL, 'RQ-8', 'Add depot name', '2026-10-19 05:20:46'),
(58, 8, 7, 'team_added', 'team', NULL, 'YEASMIN ARA CHOWDHURY (Primary)', NULL, '2026-10-19 05:21:00'),
(59, 8, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 05:21:00'),
(60, 8, 7, 'assigned', 'assigned_to', NULL, 'YEASMIN ARA CHOWDHURY', NULL, '2026-10-19 05:21:00'),
(61, 9, 7, 'created', NULL, NULL, 'RQ-9', 'Mater File Update', '2026-10-19 05:25:41'),
(62, 9, 7, 'team_added', 'team', NULL, 'YEASMIN ARA CHOWDHURY (Primary)', NULL, '2026-10-19 05:26:51'),
(63, 9, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 05:26:51'),
(64, 9, 7, 'assigned', 'assigned_to', NULL, 'YEASMIN ARA CHOWDHURY', NULL, '2026-10-19 05:26:51'),
(65, 7, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-19 05:31:44'),
(66, 7, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'Overtime October 2026 (Other Depot) bank Advice has been created and sent to the payroll section.', '2026-10-19 06:35:18'),
(67, 7, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-19 06:35:18'),
(68, 7, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-19 06:43:55'),
(69, 10, 17, 'created', NULL, NULL, 'RQ-10', 'Please write a note on provided documents', '2026-10-19 07:00:24'),
(70, 10, 17, 'team_added', 'team', NULL, 'ISRAT JAHAN (Primary)', NULL, '2026-10-19 07:01:00'),
(71, 10, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 07:01:00'),
(72, 10, 17, 'assigned', 'assigned_to', NULL, 'ISRAT JAHAN', NULL, '2026-10-19 07:01:00'),
(73, 11, 17, 'created', NULL, NULL, 'RQ-11', 'Update Computer Transfer File', '2026-10-19 07:25:32'),
(74, 11, 17, 'team_added', 'team', NULL, 'ISRAT JAHAN (Primary)', NULL, '2026-10-19 07:25:41'),
(75, 11, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 07:25:41'),
(76, 11, 17, 'assigned', 'assigned_to', NULL, 'ISRAT JAHAN', NULL, '2026-10-19 07:25:41'),
(77, 12, 7, 'created', NULL, NULL, 'RQ-12', 'Group 1 & 2 Data input.', '2026-10-19 07:26:50'),
(78, 12, 7, 'team_added', 'team', NULL, 'MEHEDI RAIHAN (Supporting)', NULL, '2026-10-19 07:29:29'),
(79, 12, 7, 'team_added', 'team', NULL, 'ISRAT JAHAN (Supporting)', NULL, '2026-10-19 07:29:29'),
(80, 12, 7, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Supporting)', NULL, '2026-10-19 07:29:29'),
(81, 12, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-19 07:29:29'),
(82, 12, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-19 07:29:29'),
(83, 12, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-19 07:29:29'),
(84, 10, 9, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-19 09:08:23'),
(85, 10, 9, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-19 09:09:15'),
(86, 10, 9, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-19 09:09:15'),
(87, 11, 9, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-19 09:09:36'),
(88, 10, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-19 09:09:46'),
(89, 11, 9, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-19 09:09:46'),
(90, 11, 9, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-19 09:09:46'),
(91, 11, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-19 09:10:03'),
(92, 12, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-19 11:51:45'),
(93, 13, 7, 'created', NULL, NULL, 'RQ-13', 'Preparing Stationary Items List', '2026-10-25 04:17:56'),
(94, 13, 7, 'team_added', 'team', NULL, 'RAFAT KHAN (Primary)', NULL, '2026-10-25 04:26:38'),
(95, 13, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-25 04:26:38'),
(96, 13, 7, 'assigned', 'assigned_to', NULL, 'RAFAT KHAN', NULL, '2026-10-25 04:26:38'),
(97, 13, 13, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-25 04:36:48'),
(98, 14, 7, 'created', NULL, NULL, 'RQ-14', 'Domain Purchase', '2026-10-25 05:25:59'),
(99, 14, 7, 'team_added', 'team', NULL, 'Md Tarek Hossain (Primary)', NULL, '2026-10-25 05:26:30'),
(100, 14, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-25 05:26:30'),
(101, 14, 7, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-25 05:26:30'),
(102, 12, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'Completed the data entry', '2026-10-25 09:29:56'),
(103, 12, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-25 09:29:56'),
(104, 15, 12, 'created', NULL, NULL, 'RQ-15', 'Tax certificate Correction', '2026-10-25 09:47:58'),
(105, 15, 7, 'service type_changed', 'service type', 'Development Request', 'Change Request', NULL, '2026-10-25 09:50:07'),
(106, 15, 7, 'sub-category_changed', 'sub-category', 'Office', NULL, NULL, '2026-10-25 09:50:07'),
(107, 15, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-25 09:50:39'),
(108, 15, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-25 09:50:39'),
(109, 15, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-25 09:50:39'),
(110, 12, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', 'Entry completed.', '2026-10-25 09:51:38'),
(111, 15, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-25 10:03:24'),
(112, 16, 7, 'created', NULL, NULL, 'RQ-16', 'Salary Sheet Print', '2026-10-25 11:32:10'),
(113, 16, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-25 11:32:21'),
(114, 16, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-25 11:32:21'),
(115, 16, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-25 11:32:21'),
(116, 17, 7, 'created', NULL, NULL, 'RQ-17', 'Bank Advice Checking', '2026-10-25 11:35:46'),
(117, 17, 7, 'team_added', 'team', NULL, 'ISRAT JAHAN (Primary)', NULL, '2026-10-25 11:35:59'),
(118, 17, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-25 11:35:59'),
(119, 17, 7, 'assigned', 'assigned_to', NULL, 'ISRAT JAHAN', NULL, '2026-10-25 11:35:59'),
(120, 18, 16, 'created_on_behalf', NULL, NULL, 'MOHAMMAD SHARIFUL ISLAM', 'Establish an internet connection', '2026-10-25 11:43:21'),
(121, 18, 16, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Supporting)', NULL, '2026-10-25 11:44:06'),
(122, 18, 16, 'team_added', 'team', NULL, 'Md Tarek Hossain (Primary)', NULL, '2026-10-25 11:44:06'),
(123, 18, 16, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-25 11:44:06'),
(124, 18, 16, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-25 11:44:06'),
(125, 18, 16, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-25 11:44:26'),
(126, 18, 16, 'status_changed', 'status', 'In Progress', 'Resolved', 'internet connection established.', '2026-10-25 11:45:33'),
(127, 18, 16, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-25 11:45:33'),
(128, 18, 16, 'status_changed', 'status', 'User Confirmation', 'Closed', 'checked and found working fine.', '2026-10-25 11:46:09'),
(129, 14, 16, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 03:17:19'),
(130, 16, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 03:44:08'),
(131, 17, 9, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 04:03:14'),
(132, 19, 7, 'created', NULL, NULL, 'RQ-19', 'Router Configure', '2026-10-26 04:36:33'),
(133, 19, 7, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Supporting)', NULL, '2026-10-26 04:36:47'),
(134, 19, 7, 'team_added', 'team', NULL, 'Md Tarek Hossain (Primary)', NULL, '2026-10-26 04:36:47'),
(135, 19, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 04:36:47'),
(136, 19, 7, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-26 04:36:47'),
(137, 20, 7, 'created', NULL, NULL, 'RQ-20', 'Salary Sheet Cross Checking', '2026-10-26 04:41:51'),
(138, 20, 7, 'team_added', 'team', NULL, 'TULI NANDY (Primary)', NULL, '2026-10-26 04:42:13'),
(139, 20, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 04:42:13'),
(140, 20, 7, 'assigned', 'assigned_to', NULL, 'TULI NANDY', NULL, '2026-10-26 04:42:13'),
(141, 21, 7, 'created', NULL, NULL, 'RQ-21', 'Printer setup support', '2026-10-26 05:06:40'),
(142, 21, 7, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Primary)', NULL, '2026-10-26 05:06:51'),
(143, 21, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 05:06:51'),
(144, 21, 7, 'assigned', 'assigned_to', NULL, 'MD. RAZAUL KARIM', NULL, '2026-10-26 05:06:51'),
(145, 19, 16, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 05:35:16'),
(146, 13, 13, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-26 06:32:15'),
(147, 21, 11, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 06:58:15'),
(148, 21, 11, 'status_changed', 'status', 'In Progress', 'Resolved', 'Setup Done.', '2026-10-26 06:58:41'),
(149, 21, 11, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 06:58:41'),
(150, 19, 16, 'status_changed', 'status', 'In Progress', 'Resolved', 'Router configured, and working fine.', '2026-10-26 07:01:37'),
(151, 19, 16, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 07:01:37'),
(152, 19, 16, 'status_changed', 'status', 'User Confirmation', 'Closed', 'Confirmed.', '2026-10-26 07:02:36'),
(153, 15, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'completed the work', '2026-10-26 07:09:15'),
(154, 15, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 07:09:15'),
(155, 16, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'Work is done', '2026-10-26 07:10:13'),
(156, 16, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 07:10:13'),
(157, 22, 12, 'created', NULL, NULL, 'RQ-22', 'Depot Pis Entry', '2026-10-26 07:15:50'),
(158, 22, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-26 07:19:40'),
(159, 22, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 07:19:40'),
(160, 22, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-26 07:19:40'),
(161, 22, 7, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-26 07:21:43'),
(162, 23, 12, 'created', NULL, NULL, 'RQ-23', 'CASH CREDIT VOUCHER (CCV) Entry', '2026-10-26 07:21:46'),
(163, 22, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 07:22:18'),
(164, 23, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-26 07:24:15'),
(165, 23, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 07:24:15'),
(166, 23, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', 'Let us know the approximate total count of CASH CREDIT VOUCHER (CCV) August-2026 when you complete this task.', '2026-10-26 07:24:15'),
(167, 24, 12, 'created', NULL, NULL, 'RQ-24', 'CHEQUE VOUCHER Entry', '2026-10-26 07:24:49'),
(168, 23, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 07:25:01'),
(169, 23, 7, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-26 07:25:37'),
(170, 24, 7, 'team_added', 'team', NULL, 'MEHEDI RAIHAN (Supporting)', NULL, '2026-10-26 07:26:35'),
(171, 24, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-26 07:26:35'),
(172, 24, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 07:26:35'),
(173, 24, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-26 07:26:35'),
(174, 24, 7, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-26 07:28:42'),
(175, 21, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 08:18:04'),
(176, 17, 9, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-26 08:18:06'),
(177, 17, 9, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 08:18:06'),
(178, 15, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 08:20:44'),
(179, 16, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 08:20:52'),
(180, 17, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 08:21:04'),
(181, 25, 7, 'created', NULL, NULL, 'RQ-25', 'Salary Sheet Cross Checking', '2026-10-26 08:30:19'),
(182, 25, 7, 'team_added', 'team', NULL, 'ISRAT JAHAN (Primary)', NULL, '2026-10-26 08:30:50'),
(183, 25, 7, 'team_added', 'team', NULL, 'TULI NANDY (Supporting)', NULL, '2026-10-26 08:30:50'),
(184, 25, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 08:30:50'),
(185, 25, 7, 'assigned', 'assigned_to', NULL, 'ISRAT JAHAN', NULL, '2026-10-26 08:30:50'),
(186, 25, 9, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 08:47:04'),
(187, 20, 10, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 09:11:20'),
(188, 13, 13, 'status_changed', 'status', 'In Progress', 'Resolved', 'Resolved', '2026-10-26 09:24:57'),
(189, 13, 13, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 09:24:57'),
(190, 13, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 09:34:34'),
(191, 22, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'Depot Pis (August-2026) Data Entry Done and Checklist Send to Cash Section', '2026-10-26 10:20:48'),
(192, 22, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 10:20:48'),
(193, 22, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 11:04:21'),
(194, 26, 7, 'created', NULL, NULL, 'RQ-26', 'Prepare an IT Equipment Stock & Asset Summary', '2026-10-26 12:13:46'),
(195, 23, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'CASH CREDIT VOUCHER (CCV) August-2026 Data Entry Completed', '2026-10-26 12:14:21'),
(196, 23, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-26 12:14:21'),
(197, 26, 7, 'team_added', 'team', NULL, 'Md Abu Hanife Nayem (Supporting)', NULL, '2026-10-26 12:15:56'),
(198, 26, 7, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Supporting)', NULL, '2026-10-26 12:15:56'),
(199, 26, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Supporting)', NULL, '2026-10-26 12:15:56'),
(200, 26, 7, 'team_added', 'team', NULL, 'RAFAT KHAN (Primary)', NULL, '2026-10-26 12:15:56'),
(201, 26, 7, 'team_added', 'team', NULL, 'Md Tarek Hossain (Supporting)', NULL, '2026-10-26 12:15:56'),
(202, 26, 7, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Supporting)', NULL, '2026-10-26 12:15:56'),
(203, 26, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-26 12:15:56'),
(204, 26, 7, 'assigned', 'assigned_to', NULL, 'RAFAT KHAN', NULL, '2026-10-26 12:15:56'),
(205, 24, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-26 12:16:04'),
(206, 23, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-26 12:18:01'),
(207, 24, 12, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-26 12:20:16'),
(208, 26, 13, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 03:17:45'),
(209, 14, 16, 'status_changed', 'status', 'In Progress', 'On Hold', 'btcl website is not accessible right now', '2026-10-27 04:01:09'),
(210, 27, 16, 'created_on_behalf', NULL, NULL, 'MOHAMMAD SHARIFUL ISLAM', 'Install Oracle 19c on a laptop', '2026-10-27 05:03:28'),
(211, 27, 16, 'team_added', 'team', NULL, 'Md Tarek Hossain (Primary)', NULL, '2026-10-27 05:04:14'),
(212, 27, 16, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 05:04:14'),
(213, 27, 16, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-27 05:04:14'),
(214, 27, 16, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 05:04:26'),
(215, 20, 7, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-27 06:49:12'),
(216, 28, 17, 'created', NULL, NULL, 'RQ-28', 'Hardware Stock Update', '2026-10-27 09:34:44'),
(217, 28, 17, 'team_added', 'team', NULL, 'ISRAT JAHAN (Primary)', NULL, '2026-10-27 09:35:54'),
(218, 28, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 09:35:54'),
(219, 28, 17, 'assigned', 'assigned_to', NULL, 'ISRAT JAHAN', NULL, '2026-10-27 09:35:54'),
(220, 28, 9, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 09:38:43'),
(221, 20, 10, 'status_changed', 'status', 'In Progress', 'Resolved', 'Done.', '2026-10-27 09:46:42'),
(222, 20, 10, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-27 09:46:42'),
(223, 29, 17, 'created', NULL, NULL, 'RQ-29', 'Make a Note & Detail Description on Newly purchased 51 Desktop', '2026-10-27 09:53:59'),
(224, 29, 17, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Primary)', NULL, '2026-10-27 09:54:25'),
(225, 29, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 09:54:25'),
(226, 29, 17, 'assigned', 'assigned_to', NULL, 'Md Sajjad Hossain', NULL, '2026-10-27 09:54:25'),
(227, 29, 17, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 09:54:28'),
(228, 30, 17, 'created', NULL, NULL, 'RQ-30', 'Password Reset For Md Iqbal Hossain of National Mail Server', '2026-10-27 09:56:33'),
(229, 30, 17, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Primary)', NULL, '2026-10-27 09:56:47'),
(230, 30, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 09:56:47'),
(231, 30, 17, 'assigned', 'assigned_to', NULL, 'Md Sajjad Hossain', NULL, '2026-10-27 09:56:47'),
(232, 30, 17, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 09:56:49'),
(233, 31, 17, 'created', NULL, NULL, 'RQ-31', 'Ready & Provide All Salary Report for the Month of October 2026', '2026-10-27 09:58:06'),
(234, 31, 17, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Primary)', NULL, '2026-10-27 09:58:22'),
(235, 31, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 09:58:22'),
(236, 31, 17, 'assigned', 'assigned_to', NULL, 'Md Sajjad Hossain', NULL, '2026-10-27 09:58:22'),
(237, 31, 17, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 09:58:42'),
(238, 28, 9, 'status_changed', 'status', 'In Progress', 'Resolved', 'Updated', '2026-10-27 10:00:17'),
(239, 28, 9, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-27 10:00:17'),
(240, 32, 17, 'created', NULL, NULL, 'RQ-32', 'Add Status option in My Requests Menu', '2026-10-27 10:00:50'),
(241, 26, 13, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-27 10:02:13'),
(242, 26, 13, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-27 10:02:13'),
(243, 33, 17, 'created', NULL, NULL, 'RQ-33', 'Add Product Serial Number in INVENTORY Menu', '2026-10-27 10:02:44'),
(244, 33, 17, 'team_added', 'team', NULL, 'Md Abu Hanife Nayem (Primary)', NULL, '2026-10-27 10:02:53'),
(245, 33, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 10:02:53'),
(246, 33, 17, 'assigned', 'assigned_to', NULL, 'Md Abu Hanife Nayem', NULL, '2026-10-27 10:02:53'),
(247, 28, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-27 10:05:16'),
(248, 32, 17, 'team_added', 'team', NULL, 'Md Abu Hanife Nayem (Primary)', NULL, '2026-10-27 10:08:28'),
(249, 32, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-27 10:08:28'),
(250, 32, 17, 'assigned', 'assigned_to', NULL, 'Md Abu Hanife Nayem', NULL, '2026-10-27 10:08:28'),
(251, 32, 7, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 10:15:42'),
(252, 33, 7, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-27 10:15:49'),
(253, 20, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-27 10:16:30'),
(254, 20, 10, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-27 10:22:20'),
(255, 34, 18, 'created', NULL, NULL, 'RQ-34', 'To arrange the LAN wiring', '2026-10-27 13:47:25'),
(256, 35, 17, 'created', NULL, NULL, 'RQ-35', 'Bank Asia Employee List', '2026-10-28 03:22:22'),
(257, 35, 17, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Primary)', NULL, '2026-10-28 03:22:34'),
(258, 35, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 03:22:34'),
(259, 35, 17, 'assigned', 'assigned_to', NULL, 'Md Sajjad Hossain', NULL, '2026-10-28 03:22:34'),
(260, 35, 17, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-28 03:22:40'),
(261, 34, 7, 'status_changed', 'status', 'New', 'Acknowledged', NULL, '2026-10-28 03:39:27'),
(262, 36, 16, 'created', NULL, NULL, 'RQ-36', 'No Internet issue', '2026-10-28 03:56:27'),
(263, 36, 16, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Primary)', NULL, '2026-10-28 03:56:38'),
(264, 36, 16, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 03:56:38'),
(265, 36, 16, 'assigned', 'assigned_to', NULL, 'MD. RAZAUL KARIM', NULL, '2026-10-28 03:56:38'),
(266, 37, 17, 'created', NULL, NULL, 'RQ-37', 'Draft a note for computer Accesories Inventory', '2026-10-28 04:04:40'),
(267, 37, 17, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Primary)', NULL, '2026-10-28 04:04:55'),
(268, 37, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 04:04:55'),
(269, 37, 17, 'assigned', 'assigned_to', NULL, 'Md Sajjad Hossain', NULL, '2026-10-28 04:04:55'),
(270, 37, 17, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-28 04:05:02'),
(271, 38, 17, 'created', NULL, NULL, 'RQ-38', 'Draft a note for Awareness regarding Cyber Scurity', '2026-10-28 04:08:18'),
(272, 38, 17, 'team_added', 'team', NULL, 'Md Sajjad Hossain (Primary)', NULL, '2026-10-28 04:08:29'),
(273, 38, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 04:08:29'),
(274, 38, 17, 'assigned', 'assigned_to', NULL, 'Md Sajjad Hossain', NULL, '2026-10-28 04:08:29'),
(275, 35, 17, 'status_changed', 'status', 'In Progress', 'Resolved', 'Bank Asia employee list has been sent', '2026-10-28 04:20:14'),
(276, 35, 17, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-28 04:20:14'),
(277, 35, 17, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-28 04:20:19'),
(278, 39, 12, 'created', NULL, NULL, 'RQ-39', 'Office Order', '2026-10-28 04:31:07'),
(279, 39, 7, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-28 04:31:27'),
(280, 39, 7, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 04:31:27'),
(281, 39, 7, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-28 04:31:27'),
(282, 39, 12, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-28 04:31:44'),
(283, 36, 11, 'status_changed', 'status', 'Assigned', 'In Progress', 'DONE', '2026-10-28 05:20:03'),
(284, 36, 11, 'status_changed', 'status', 'In Progress', 'Resolved', 'DONE', '2026-10-28 05:20:10'),
(285, 36, 11, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-28 05:20:10'),
(286, 26, 11, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-28 05:20:49'),
(287, 39, 12, 'status_changed', 'status', 'In Progress', 'Resolved', 'Office Order Update done', '2026-10-28 06:01:00'),
(288, 39, 12, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-28 06:01:01'),
(289, 39, 7, 'status_changed', 'status', 'User Confirmation', 'Closed', NULL, '2026-10-28 06:44:34'),
(290, 26, 13, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-28 08:59:02'),
(291, 40, 16, 'created', NULL, NULL, 'RQ-40', 'Loss/Gain Posting Mismatch', '2026-10-28 09:02:52'),
(292, 40, 16, 'team_added', 'team', NULL, 'Md Tarek Hossain (Primary)', NULL, '2026-10-28 09:03:02'),
(293, 40, 16, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 09:03:02'),
(294, 40, 16, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-28 09:03:02'),
(295, 40, 16, 'status_changed', 'status', 'Assigned', 'In Progress', NULL, '2026-10-28 09:03:08'),
(296, 40, 16, 'status_changed', 'status', 'In Progress', 'Resolved', 'solution provided.', '2026-10-28 09:35:50'),
(297, 40, 16, 'status_changed', 'status', 'Resolved', 'User Confirmation', NULL, '2026-10-28 09:35:50'),
(298, 40, 16, 'status_changed', 'status', 'User Confirmation', 'Closed', 'confirmed', '2026-10-28 09:36:01'),
(299, 26, 13, 'comment_added', NULL, NULL, NULL, NULL, '2026-10-28 09:57:26'),
(300, 41, 17, 'created', NULL, NULL, 'RQ-41', 'Listing of Damaged Items for sent to HR Department', '2026-10-28 10:47:29'),
(301, 41, 17, 'team_added', 'team', NULL, 'MEHEDI RAIHAN (Supporting)', NULL, '2026-10-28 10:48:26'),
(302, 41, 17, 'team_added', 'team', NULL, 'MD. RAZAUL KARIM (Supporting)', NULL, '2026-10-28 10:48:26'),
(303, 41, 17, 'team_added', 'team', NULL, 'MD. MAHABUB ALAM (Primary)', NULL, '2026-10-28 10:48:26'),
(304, 41, 17, 'team_added', 'team', NULL, 'RAFAT KHAN (Supporting)', NULL, '2026-10-28 10:48:26'),
(305, 41, 17, 'status_changed', 'status', 'New', 'Assigned', NULL, '2026-10-28 10:48:26'),
(306, 41, 17, 'assigned', 'assigned_to', NULL, 'MD. MAHABUB ALAM', NULL, '2026-10-28 10:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_internal_notes`
--

CREATE TABLE `ticket_internal_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_priorities`
--

CREATE TABLE `ticket_priorities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint UNSIGNED NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_minutes` int UNSIGNED DEFAULT NULL,
  `resolution_minutes` int UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_priorities`
--

INSERT INTO `ticket_priorities` (`id`, `name`, `level`, `color`, `response_minutes`, `resolution_minutes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Critical', 1, 'danger', 15, 240, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(2, 'High', 2, 'warning', 30, 480, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(3, 'Medium', 3, 'primary', 120, 960, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 'Low', 4, 'secondary', 240, 2400, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_sequences`
--

CREATE TABLE `ticket_sequences` (
  `year` smallint UNSIGNED NOT NULL,
  `last_number` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_sequences`
--

INSERT INTO `ticket_sequences` (`year`, `last_number`) VALUES
(0, 41);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_statuses`
--

CREATE TABLE `ticket_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `is_final` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_statuses`
--

INSERT INTO `ticket_statuses` (`id`, `name`, `code`, `is_open`, `is_final`, `color`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'New', 'NEW', 1, 0, 'danger', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(2, 'Acknowledged', 'ACKNOWLEDGED', 1, 0, 'info', 2, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(3, 'Assigned', 'ASSIGNED', 1, 0, 'info', 3, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 'In Progress', 'IN_PROGRESS', 1, 0, 'warning', 4, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(5, 'Waiting for User', 'WAITING_USER', 1, 0, 'secondary', 5, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(6, 'On Hold', 'ON_HOLD', 1, 0, 'secondary', 6, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(7, 'Escalated', 'ESCALATED', 1, 0, 'danger', 7, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(8, 'Resolved', 'RESOLVED', 1, 0, 'primary', 8, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(9, 'User Confirmation', 'USER_CONFIRMATION', 1, 0, 'success', 9, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(10, 'Reopened', 'REOPENED', 1, 0, 'danger', 10, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(11, 'Closed', 'CLOSED', 0, 1, 'darkgreen', 11, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(12, 'Cancelled', 'CANCELLED', 0, 1, 'dark', 12, '2026-10-08 06:28:08', '2026-10-08 06:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status_transitions`
--

CREATE TABLE `ticket_status_transitions` (
  `id` bigint UNSIGNED NOT NULL,
  `from_status_id` bigint UNSIGNED NOT NULL,
  `to_status_id` bigint UNSIGNED NOT NULL,
  `permission` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requires_comment` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_status_transitions`
--

INSERT INTO `ticket_status_transitions` (`id`, `from_status_id`, `to_status_id`, `permission`, `requires_comment`) VALUES
(1, 1, 2, 'ticket.acknowledge', 0),
(2, 1, 3, 'ticket.assign', 0),
(3, 2, 3, 'ticket.assign', 0),
(4, 3, 4, 'ticket.work', 0),
(5, 4, 5, 'ticket.work', 1),
(6, 5, 4, 'ticket.work', 0),
(7, 4, 6, 'ticket.work', 1),
(8, 6, 4, 'ticket.work', 0),
(9, 4, 8, 'ticket.work', 1),
(10, 8, 9, 'system', 0),
(11, 9, 11, 'ticket.confirm', 0),
(12, 9, 11, 'ticket.close', 0),
(13, 9, 10, 'ticket.confirm', 1),
(14, 11, 10, 'ticket.reopen', 1),
(15, 10, 3, 'ticket.assign', 0),
(16, 10, 4, 'ticket.work', 0),
(17, 7, 3, 'ticket.assign', 0),
(18, 7, 4, 'ticket.work', 0),
(19, 1, 12, 'ticket.cancel', 1),
(20, 2, 12, 'ticket.cancel', 1),
(21, 3, 12, 'ticket.cancel', 1),
(22, 3, 7, 'ticket.escalate', 1),
(23, 4, 7, 'ticket.escalate', 1),
(24, 5, 7, 'ticket.escalate', 1),
(25, 6, 7, 'ticket.escalate', 1),
(26, 10, 7, 'ticket.escalate', 1),
(27, 1, 7, 'ticket.escalate', 1),
(28, 2, 7, 'ticket.escalate', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_subcategories`
--

CREATE TABLE `ticket_subcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_subcategories`
--

INSERT INTO `ticket_subcategories` (`id`, `category_id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Desktop', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(2, 1, 'Laptop', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(3, 1, 'Monitor', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 1, 'Printer', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(5, 1, 'Scanner', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(6, 1, 'UPS', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(7, 1, 'Keyboard/Mouse', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(8, 3, 'Network device (Router, Switch etc.)', 1, '2026-10-08 06:28:08', '2026-10-18 11:37:27'),
(9, 1, 'Server', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(10, 1, 'Other', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(11, 2, 'OLD ERP (Hawlader)', 1, '2026-10-08 06:28:08', '2026-10-18 11:38:19'),
(12, 2, 'VAT Software', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(13, 2, 'HRM', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(14, 2, 'Payroll', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(15, 2, 'Accounts', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(16, 5, 'Windows', 1, '2026-10-08 06:28:08', '2026-10-18 11:38:36'),
(17, 5, 'Office', 1, '2026-10-08 06:28:08', '2026-10-18 11:38:46'),
(18, 5, 'Antivirus', 1, '2026-10-08 06:28:08', '2026-10-18 11:38:54'),
(19, 2, 'Database', 0, '2026-10-08 06:28:08', '2026-10-18 11:39:39'),
(20, 2, 'Application', 0, '2026-10-08 06:28:08', '2026-10-18 11:39:45'),
(21, 2, 'Others', 1, '2026-10-08 06:28:08', '2026-10-18 11:39:56'),
(22, 3, 'LAN', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(23, 3, 'Wi-Fi', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(24, 3, 'Internet', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(25, 3, 'VPN', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(26, 3, 'IP address', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(27, 3, 'Network printer', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(28, 3, 'Switch', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(29, 3, 'Router', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(30, 3, 'Firewall', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(31, 5, 'Email', 1, '2026-10-08 06:28:08', '2026-10-18 11:40:51'),
(32, 5, 'D-Nothi', 1, '2026-10-08 06:28:08', '2026-10-18 11:41:05'),
(33, 2, 'Correction', 1, '2026-10-08 06:28:08', '2026-10-18 11:41:37'),
(34, 4, 'Application access', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(35, 4, 'Folder access', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(36, 4, 'Email access', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(37, 4, 'ERP permission', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(38, 4, 'Internet permission', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(39, 5, 'Installation', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(40, 5, 'Configuration', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(41, 5, 'Data recovery', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(42, 5, 'Backup', 0, '2026-10-08 06:28:08', '2026-10-18 11:43:07'),
(43, 5, 'Training', 0, '2026-10-08 06:28:08', '2026-10-18 11:42:59'),
(44, 5, 'Report request', 0, '2026-10-08 06:28:08', '2026-10-18 11:43:23'),
(45, 5, 'New equipment', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(46, 5, 'Maintenance', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(47, 6, 'Malware', 0, '2026-10-08 06:28:08', '2026-10-18 11:44:12'),
(48, 6, 'Suspicious email', 0, '2026-10-08 06:28:08', '2026-10-18 11:44:17'),
(49, 6, 'Unauthorized access', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(50, 6, 'Security incident', 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(51, 6, 'Password/security issue', 0, '2026-10-08 06:28:08', '2026-10-18 11:44:30'),
(52, 2, 'PMS(IT Service Desk)', 1, '2026-10-19 05:15:56', '2026-10-19 05:15:56'),
(53, 6, 'Note Draft', 1, '2026-10-19 06:59:41', '2026-10-19 06:59:41'),
(54, 5, 'Website Update', 1, '2026-10-28 04:20:32', '2026-10-28 04:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requires_approval` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_types`
--

INSERT INTO `ticket_types` (`id`, `name`, `code`, `requires_approval`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'IT Service', 'INC', 0, 1, '2026-10-08 06:28:08', '2026-10-25 11:25:58'),
(2, 'Maintenance', 'SR', 0, 1, '2026-10-08 06:28:08', '2026-10-25 11:28:29'),
(3, 'Change Request', 'CHG', 1, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 'Access Request', 'ACC', 1, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(5, 'IT Device Request', 'AST', 1, 1, '2026-10-08 06:28:08', '2026-10-19 05:14:41'),
(6, 'Departmental Services', 'DEV', 0, 1, '2026-10-19 04:42:40', '2026-10-25 11:27:51'),
(7, 'Development Request', 'MAIN', 0, 1, '2026-10-19 04:42:52', '2026-10-25 11:28:22'),
(8, 'Procurement Request', 'ITP', 0, 1, '2026-10-19 04:43:31', '2026-10-19 04:43:31'),
(9, 'Incident Report', 'CON', 0, 1, '2026-10-19 04:43:52', '2026-10-25 11:29:02'),
(10, 'IT Training', 'ITT', 0, 1, '2026-10-19 04:44:03', '2026-10-19 04:44:03'),
(11, 'Data Entry', 'DAT', 0, 1, '2026-10-19 05:14:29', '2026-10-19 05:14:29'),
(12, 'Document Preparation', 'DPS', 0, 0, '2026-10-19 05:23:04', '2026-10-26 11:08:45'),
(13, 'REPORT GENERATION', 'RG', 0, 1, '2026-10-28 03:20:14', '2026-10-28 03:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_work_updates`
--

CREATE TABLE `ticket_work_updates` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `work_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_work_updates`
--

INSERT INTO `ticket_work_updates` (`id`, `ticket_id`, `user_id`, `work_status`, `note`, `created_at`) VALUES
(1, 1, 5, 'IN_PROGRESS', NULL, '2026-10-18 03:41:56'),
(2, 13, 13, 'DONE', NULL, '2026-10-26 09:24:00'),
(3, 26, 13, 'IN_PROGRESS', 'I have completed two items on the list today.\r\nDesktop ( CPU) & Monitor', '2026-10-27 10:02:59'),
(4, 26, 13, 'IN_PROGRESS', 'PRINTER,SCANER,MOUSE,UPS,APPLICATION SERVER,LAPTOP LIST DONE.', '2026-10-28 09:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `designation_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `whatsapp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_department_head` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_attendance` tinyint(1) NOT NULL DEFAULT '0',
  `failed_logins` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `last_activity_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_open` tinyint(1) NOT NULL DEFAULT '0',
  `extra_permissions` json DEFAULT NULL,
  `denied_permissions` json DEFAULT NULL,
  `board_position` smallint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `department_id`, `designation_id`, `location_id`, `whatsapp`, `avatar_path`, `is_active`, `is_department_head`, `show_in_attendance`, `failed_logins`, `locked_until`, `last_login_at`, `last_login_ip`, `password_changed_at`, `last_activity_at`, `last_activity_ip`, `session_open`, `extra_permissions`, `denied_permissions`, `board_position`) VALUES
(1, NULL, 'Accounts User', 'acct_user@joplc.com', NULL, '$2y$12$kzJZFOciig/E/9USmMDtwuvzgvHW5XwDhs1VT7eH0ZL5OaNnHPPmC', NULL, '2026-10-08 06:28:08', '2026-10-18 11:28:38', 2, NULL, 1, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(2, NULL, 'Sales User', 'sales_user@joplc.com', NULL, '$2y$12$u8p6kRp7k6wWsrqif6Ffe.vULZ5QxyXY/r77xtBoM13cMIdpxBT8.', NULL, '2026-10-08 06:28:08', '2026-10-18 11:29:38', 3, NULL, 1, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(3, NULL, 'Accounts Head', 'acct_head@joplc.com', NULL, '$2y$12$c40PoxyUKsnY3vC7KdF1Te4tFVmt4cNDu8knjpEdTxNhFtbRCkZQm', NULL, '2026-10-08 06:28:09', '2026-10-18 11:29:25', 2, NULL, 1, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(4, NULL, 'IT Admin', 'it_admin@joplc.com', NULL, '$2y$12$BmUzAwzlNZveAPEj/yZPQuo/eAOwa3JSruaj/PeiCOugzi3eCtXpy', NULL, '2026-10-08 06:28:09', '2026-10-19 03:26:55', 1, NULL, 1, NULL, NULL, 0, 0, 0, 3, NULL, '2026-10-18 08:27:37', '103.16.73.139', NULL, '2026-10-18 08:29:07', '103.16.73.139', 0, NULL, NULL, NULL),
(5, NULL, 'IT Employee', 'it_emp@joplc.com', NULL, '$2y$12$/TiX7SibnvHwy8wqpxqYueW0pXrSBvWRXV64HXNVE3S.jHBOJwn3O', NULL, '2026-10-08 06:28:09', '2026-10-26 04:53:34', 1, NULL, 1, NULL, NULL, 0, 0, 1, 1, NULL, '2026-10-18 08:29:48', '103.16.73.139', NULL, '2026-10-18 08:29:48', '103.16.73.139', 0, NULL, NULL, NULL),
(6, '20070725', 'MOHAMMAD SHARIFUL ISLAM', 'sharif99452@gmail.com', NULL, '$2y$12$ExIMWuhPT16xdKg37RBJdeaFlUObwxzcYdtXZIl9Dv0PqYDTll8ya', NULL, '2026-10-08 06:28:09', '2026-10-27 04:30:36', 1, 3, 1, '01777797319', NULL, 1, 0, 0, 0, NULL, '2026-10-18 06:41:55', '103.16.73.139', NULL, '2026-10-18 06:43:29', '103.16.73.139', 0, NULL, NULL, 11),
(7, '20251341', 'Md Abu Hanife Nayem', 'nayem.jocl@gmail.com', NULL, '$2y$12$6updb3ilShVS8YPCZiscsudIHepxdohvhz7r/v5wSamlJ.0bhDcmK', NULL, '2026-10-08 06:28:09', '2026-10-28 10:47:36', 1, 2, 1, '01521236214', 'avatars/7-0748d77fa3d47dca.jpg', 1, 0, 0, 0, NULL, '2026-10-28 10:45:06', '103.16.73.139', NULL, '2026-10-28 10:47:36', '103.16.73.139', 1, NULL, NULL, 10),
(8, '1', 'MEHEDI RAIHAN', 'raihanmehedi700@gmail.com', NULL, '$2y$12$ox73ogjyuV/8fANP/cHDrewpCM6C4wjfh2nVqXOZPAYRvEKilND1q', NULL, '2026-10-08 06:41:37', '2026-10-28 02:35:12', 1, 4, 1, '01771713685', NULL, 1, 0, 1, 0, NULL, '2026-10-28 02:34:44', '103.16.73.137', '2026-10-08 06:41:37', '2026-10-28 02:34:44', '103.16.73.137', 0, NULL, NULL, 6),
(9, '2', 'ISRAT JAHAN', 'israt29190@gmail.com', NULL, '$2y$12$yAqpFn67wjkHPrNj5UcyleiuwWo5oOoVh9P4sgoGFvryNER1TMCHC', NULL, '2026-10-08 06:47:15', '2026-10-28 07:59:50', 1, 4, 1, '01876692194', NULL, 1, 0, 1, 0, NULL, '2026-10-28 06:35:21', '103.16.73.139', '2026-10-08 06:47:15', '2026-10-28 06:35:21', '103.16.73.139', 0, NULL, NULL, 1),
(10, '3', 'TULI NANDY', 'nandytuli9@gmail.com', NULL, '$2y$12$BKK0QAbIHW8KowytaZm7vedyDXMQL1EiGg5UWRcQ0U0xlvRhBjhD2', NULL, '2026-10-08 06:49:51', '2026-10-28 09:10:21', 1, 4, 1, '01674827361', NULL, 1, 0, 1, 0, NULL, '2026-10-28 08:38:30', '103.16.73.137', '2026-10-12 04:00:41', '2026-10-28 08:55:03', '103.16.73.137', 0, NULL, NULL, 3),
(11, '4', 'MD. RAZAUL KARIM', 'md.razaulkarim86@gmail.com', NULL, '$2y$12$s37ul/dzt8SaibETNHJ3LuEC81LYAvWv9lu2U893WBAbrm5U0HBH2', NULL, '2026-10-08 06:54:39', '2026-10-28 10:46:05', 1, 5, 1, '01819633879', NULL, 1, 0, 1, 0, NULL, '2026-10-28 10:46:05', '103.16.73.139', '2026-10-08 06:54:39', '2026-10-28 10:46:05', '103.16.73.139', 1, NULL, NULL, 4),
(12, '5', 'MD. MAHABUB ALAM', 'mahabubjocl@gmail.com', NULL, '$2y$12$efDTtG6QVBNZLX93UU6eceX1oTtb8g6Kf0/ZIen0TcV1.lMH3iJqm', NULL, '2026-10-08 06:56:34', '2026-10-28 06:17:10', 1, 5, 1, '01613444355', 'avatars/12-db3f2a844344eda8.jpg', 1, 0, 1, 0, NULL, '2026-10-28 05:59:35', '103.16.73.139', '2026-10-08 06:56:34', '2026-10-28 06:00:47', '103.16.73.139', 0, NULL, NULL, 2),
(13, '7', 'RAFAT KHAN', 'rafatkhan1988@gmail.com', NULL, '$2y$12$wlSZu0r612jg6HcVV/xcrulXFnOHm/kxl6oTLPJmcrYb.fl4Xk32i', NULL, '2026-10-08 08:55:48', '2026-10-28 09:58:29', 1, 4, 1, '01672011005', NULL, 1, 0, 1, 0, NULL, '2026-10-28 09:56:59', '103.16.73.137', '2026-10-08 08:55:48', '2026-10-28 09:58:29', '103.16.73.137', 1, NULL, NULL, 5),
(14, '8', 'KAZI MD AIYUB', 'kaziaiyub06@gmail.com', NULL, '$2y$12$rC6s4wAI9kPOYTlpjwJ4DOeuGnZGVHH5IAk2BvlsLBR4QQ/e0Wugu', NULL, '2026-10-08 09:01:48', '2026-10-28 03:09:52', 1, 4, 1, '01731964635', NULL, 1, 0, 1, 0, NULL, '2026-10-28 03:04:35', '103.16.73.139', '2026-10-08 09:01:48', '2026-10-28 03:09:49', '103.16.73.139', 0, NULL, NULL, 12),
(15, '20051090', 'YEASMIN ARA CHOWDHURY', 'yeasminsoma0@gmail.com', NULL, '$2y$12$eDpPQzvk/4Q6twaULtSo.OdeiJGvgJ/PkYyN4u7YaQdVoHmGNmYNq', NULL, '2026-10-11 06:00:25', '2026-10-27 04:30:36', 1, 6, 1, '01866823255', NULL, 1, 0, 0, 0, NULL, '2026-10-19 05:29:54', '103.16.73.139', '2026-10-11 06:00:25', '2026-10-19 05:32:50', '103.16.73.139', 1, NULL, NULL, 7),
(16, '1357', 'Md Tarek Hossain', 'tarek.jocl@gmail.com', NULL, '$2y$12$4Ug8R6mDSIBjPdgcJZBPweMmtxmFbzTke2eqdw1n2SFfIcwIiTyeS', NULL, '2026-10-18 11:55:54', '2026-10-28 10:02:51', 1, 7, 1, '01844290967', 'avatars/16-aed3f4084ce8a7ac.jpg', 1, 0, 0, 0, NULL, '2026-10-28 09:35:13', '103.16.73.139', '2026-10-18 11:55:54', '2026-10-28 09:47:46', '103.16.73.139', 0, NULL, NULL, 8),
(17, '1308', 'Md Sajjad Hossain', 'sajjad.jocl2020@gmail.com', NULL, '$2y$12$YZoku/88vb9OlhPBgdiCWup2gde3eHfdz03iogcAwsF1tmwRNjHRK', NULL, '2026-10-18 11:58:04', '2026-10-28 10:48:41', 1, 1, 1, '01830310919', NULL, 1, 0, 0, 0, NULL, '2026-10-28 10:45:04', '103.16.73.139', '2026-10-18 11:58:04', '2026-10-28 10:48:41', '103.16.73.139', 1, NULL, NULL, 9),
(18, '20251345', 'MOHAMMAD MAHFUZUR RAHMAN', 'mahfuz.rahman@jamunaoil.gov.bd', NULL, '$2y$12$qX4OsZ8ldXEZ4j30BwMa0uIxUadPLTIB.X4ROWwyUSsjqXX7iSW4y', NULL, '2026-10-27 08:41:13', '2026-10-27 13:48:43', 2, 1, 1, '01863356933', 'avatars/18-417c79897871268d.jpg', 1, 0, 0, 0, NULL, '2026-10-27 13:39:50', '103.16.73.139', '2026-10-27 13:40:16', '2026-10-27 13:47:54', '103.16.73.139', 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audit_logs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designations_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_name_unique` (`name`);

--
-- Indexes for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_histories_user_id_foreign` (`user_id`),
  ADD KEY `login_histories_event_created_at_index` (`event`,`created_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_settings_key_unique` (`key`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_no_unique` (`ticket_no`),
  ADD KEY `tickets_ticket_type_id_foreign` (`ticket_type_id`),
  ADD KEY `tickets_requester_id_foreign` (`requester_id`),
  ADD KEY `tickets_location_id_foreign` (`location_id`),
  ADD KEY `tickets_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tickets_closed_by_foreign` (`closed_by`),
  ADD KEY `tickets_created_by_foreign` (`created_by`),
  ADD KEY `tickets_updated_by_foreign` (`updated_by`),
  ADD KEY `tickets_status_id_assigned_to_index` (`status_id`,`assigned_to`),
  ADD KEY `tickets_department_id_status_id_index` (`department_id`,`status_id`),
  ADD KEY `tickets_category_id_created_at_index` (`category_id`,`created_at`),
  ADD KEY `tickets_priority_id_index` (`priority_id`),
  ADD KEY `tickets_asset_id_index` (`asset_id`);
ALTER TABLE `tickets` ADD FULLTEXT KEY `tickets_subject_description_fulltext` (`subject`,`description`);

--
-- Indexes for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tasg_ticket_employee` (`ticket_id`,`employee_id`),
  ADD UNIQUE KEY `uq_tasg_one_primary` (`ticket_id`,`primary_marker`),
  ADD KEY `fk_tasg_by` (`assigned_by`),
  ADD KEY `ix_tasg_employee` (`employee_id`);

--
-- Indexes for table `ticket_assignment_log`
--
ALTER TABLE `ticket_assignment_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_assignments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_assignments_assigned_to_foreign` (`assigned_to`),
  ADD KEY `ticket_assignments_assigned_from_foreign` (`assigned_from`),
  ADD KEY `ticket_assignments_assigned_by_foreign` (`assigned_by`);

--
-- Indexes for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_attachments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_attachments_comment_id_foreign` (`comment_id`),
  ADD KEY `ticket_attachments_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_categories_name_unique` (`name`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_comments_user_id_foreign` (`user_id`),
  ADD KEY `ticket_comments_ticket_id_created_at_index` (`ticket_id`,`created_at`);

--
-- Indexes for table `ticket_history`
--
ALTER TABLE `ticket_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_history_user_id_foreign` (`user_id`),
  ADD KEY `ticket_history_ticket_id_created_at_index` (`ticket_id`,`created_at`);

--
-- Indexes for table `ticket_internal_notes`
--
ALTER TABLE `ticket_internal_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_internal_notes_user_id_foreign` (`user_id`),
  ADD KEY `ticket_internal_notes_ticket_id_created_at_index` (`ticket_id`,`created_at`);

--
-- Indexes for table `ticket_priorities`
--
ALTER TABLE `ticket_priorities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_priorities_name_unique` (`name`),
  ADD UNIQUE KEY `ticket_priorities_level_unique` (`level`);

--
-- Indexes for table `ticket_sequences`
--
ALTER TABLE `ticket_sequences`
  ADD PRIMARY KEY (`year`);

--
-- Indexes for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_statuses_name_unique` (`name`),
  ADD UNIQUE KEY `ticket_statuses_code_unique` (`code`);

--
-- Indexes for table `ticket_status_transitions`
--
ALTER TABLE `ticket_status_transitions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_status_transition` (`from_status_id`,`to_status_id`,`permission`),
  ADD KEY `ticket_status_transitions_to_status_id_foreign` (`to_status_id`);

--
-- Indexes for table `ticket_subcategories`
--
ALTER TABLE `ticket_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_subcategories_category_id_name_unique` (`category_id`,`name`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_types_name_unique` (`name`),
  ADD UNIQUE KEY `ticket_types_code_unique` (`code`);

--
-- Indexes for table `ticket_work_updates`
--
ALTER TABLE `ticket_work_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_twu_user` (`user_id`),
  ADD KEY `ix_twu_ticket_time` (`ticket_id`,`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_employee_id_unique` (`employee_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_designation_id_foreign` (`designation_id`),
  ADD KEY `users_location_id_foreign` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_histories`
--
ALTER TABLE `login_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=697;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `ticket_assignment_log`
--
ALTER TABLE `ticket_assignment_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `ticket_history`
--
ALTER TABLE `ticket_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT for table `ticket_internal_notes`
--
ALTER TABLE `ticket_internal_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_priorities`
--
ALTER TABLE `ticket_priorities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ticket_status_transitions`
--
ALTER TABLE `ticket_status_transitions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ticket_subcategories`
--
ALTER TABLE `ticket_subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ticket_work_updates`
--
ALTER TABLE `ticket_work_updates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD CONSTRAINT `login_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ticket_categories` (`id`),
  ADD CONSTRAINT `tickets_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `tickets_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `ticket_priorities` (`id`),
  ADD CONSTRAINT `tickets_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `ticket_statuses` (`id`),
  ADD CONSTRAINT `tickets_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `ticket_subcategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_ticket_type_id_foreign` FOREIGN KEY (`ticket_type_id`) REFERENCES `ticket_types` (`id`),
  ADD CONSTRAINT `tickets_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  ADD CONSTRAINT `fk_tasg_by` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_tasg_employee` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_tasg_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_assignment_log`
--
ALTER TABLE `ticket_assignment_log`
  ADD CONSTRAINT `ticket_assignments_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ticket_assignments_assigned_from_foreign` FOREIGN KEY (`assigned_from`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_assignments_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ticket_assignments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `ticket_comments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_attachments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_attachments_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_history`
--
ALTER TABLE `ticket_history`
  ADD CONSTRAINT `ticket_history_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_internal_notes`
--
ALTER TABLE `ticket_internal_notes`
  ADD CONSTRAINT `ticket_internal_notes_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_internal_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_status_transitions`
--
ALTER TABLE `ticket_status_transitions`
  ADD CONSTRAINT `ticket_status_transitions_from_status_id_foreign` FOREIGN KEY (`from_status_id`) REFERENCES `ticket_statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_status_transitions_to_status_id_foreign` FOREIGN KEY (`to_status_id`) REFERENCES `ticket_statuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_subcategories`
--
ALTER TABLE `ticket_subcategories`
  ADD CONSTRAINT `ticket_subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_work_updates`
--
ALTER TABLE `ticket_work_updates`
  ADD CONSTRAINT `fk_twu_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_twu_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
