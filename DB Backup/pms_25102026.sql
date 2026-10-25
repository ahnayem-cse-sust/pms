-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2026 at 05:48 AM
-- Server version: 8.4.11-0ubuntu0.26.04.1
-- PHP Version: 8.5.4

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
(348, 7, 'ticket.assigned', 'Ticket', 14, '{\"assigned_to\":null}', '{\"assigned_to\":\"Md Tarek Hossain\"}', '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-25 05:26:30');

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
('it-service-desk-cache-902ba3cda1883801594b6e1b452790cc53948fda', 'i:1;', 1792383395),
('it-service-desk-cache-902ba3cda1883801594b6e1b452790cc53948fda:timer', 'i:1792383395;', 1792383395),
('it-service-desk-cache-91c57bdfefea488995d0c3db6bc743964efec7ed', 'i:1;', 1792905300),
('it-service-desk-cache-91c57bdfefea488995d0c3db6bc743964efec7ed:timer', 'i:1792905300;', 1792905300),
('it-service-desk-cache-9b6eb3d0811ff4a59a35f6362b9628ff71202496', 'i:1;', 1792905596),
('it-service-desk-cache-9b6eb3d0811ff4a59a35f6362b9628ff71202496:timer', 'i:1792905596;', 1792905596),
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
(464, 13, 'rafatkhan1988@gmail.com', 1, 'logout', 'timeout', '103.16.73.137', NULL, '2026-10-25 05:14:06');

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
(21, '2026_10_19_000018_users_avatar_path', 8);

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
('00313990-18a7-4b88-b3e8-360c3dc329ce', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"Request RQ-1 was submitted for YEASMIN ARA CHOWDHURY.\"}', '2026-10-18 04:20:44', '2026-10-18 03:28:31', '2026-10-18 04:20:44'),
('014eb5f3-b573-4eca-a900-048b3a0a626b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3 has been assigned to ISRAT JAHAN\"}', '2026-10-18 08:31:52', '2026-10-18 08:28:04', '2026-10-18 08:31:52'),
('01b02dd9-f09d-4df5-96db-254d7dc27139', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 12:15:06', '2026-10-18 12:15:06'),
('02f5d684-081c-4aa9-aba4-43d8f29bb7f3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('0422f70e-2ac5-4755-90f3-80df32f721a0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"Your request RQ-11 was submitted.\"}', '2026-10-19 07:28:02', '2026-10-19 07:25:32', '2026-10-19 07:28:02'),
('052d43ce-7b6c-47a4-adf5-cd6bc47ceb58', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('0541a53d-1f02-4f2a-873d-bb1820f78d80', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 12:15:06', '2026-10-18 12:15:06'),
('09176ef5-148d-4ce8-9931-e93eb5da2704', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: you are the primary responsible employee\"}', NULL, '2026-10-19 05:09:17', '2026-10-19 05:09:17'),
('09901550-cf15-4d10-9ed5-58bcf64ce4d5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2 has been assigned to IT Employee\"}', '2026-10-18 07:13:06', '2026-10-18 06:31:17', '2026-10-18 07:13:06'),
('0a4ad3f4-478a-4bbd-9c37-eee0f4e52e45', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: Assigned \\u2192 In Progress\"}', NULL, '2026-10-19 09:09:36', '2026-10-19 09:09:36'),
('0d06dd2d-bb38-4cdc-a4fa-e53c5b2de017', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: Assigned \\u2192 In Progress\"}', '2026-10-18 12:17:26', '2026-10-18 12:14:19', '2026-10-18 12:17:26'),
('0e695043-d361-4a93-963e-eb964f2ac4f0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"Md Tarek Hossain submitted request RQ-4 on your behalf.\"}', '2026-10-18 12:17:19', '2026-10-18 12:11:44', '2026-10-18 12:17:19'),
('0f4d020b-3109-43f0-8a4f-35d73b8061ff', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 08:32:34', '2026-10-18 08:32:34'),
('13fe189f-462f-4e16-86e1-c8a7adc856d2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', '2026-10-19 11:58:41', '2026-10-19 09:09:46', '2026-10-19 11:58:41'),
('173db13c-a7f4-4d49-8d88-8ebed2e19c12', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', NULL, '2026-10-18 12:11:44', '2026-10-18 12:11:44'),
('1749f49a-f88c-4866-8b87-fcc521423ba8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"New request RQ-3: Need to prepare a document\"}', NULL, '2026-10-18 08:25:26', '2026-10-18 08:25:26'),
('177d24b5-00a3-4526-8417-67f1b2a20d6a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: you are the primary responsible employee\"}', NULL, '2026-10-19 03:26:11', '2026-10-19 03:26:11'),
('18a6d24f-2191-4186-8e65-379bbf7072f2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"Your request RQ-14 was submitted.\"}', '2026-10-25 05:26:33', '2026-10-25 05:25:59', '2026-10-25 05:26:33'),
('19ce66b7-de6b-4684-aef2-e1ea40ab729f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('1abee692-379a-4786-ba0f-b9f78bec3a22', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', NULL, '2026-10-19 05:08:26', '2026-10-19 05:08:26'),
('1bb6eade-a72f-4188-9b65-f5ce6c8da083', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you are the primary responsible employee\"}', '2026-10-19 03:15:42', '2026-10-18 06:31:00', '2026-10-19 03:15:42'),
('1cdc1260-a06e-4683-ba9c-5c88a64df63a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', '2026-10-19 03:28:52', '2026-10-18 12:11:44', '2026-10-19 03:28:52'),
('1d94707f-b20d-46ed-9fb3-306e7dbf61d9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 06:35:18', '2026-10-19 06:35:18'),
('2950a384-e7dd-4fa4-901a-484622da84cf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', NULL, '2026-10-19 07:25:32', '2026-10-19 07:25:32'),
('2f131308-7ac8-4a31-86d6-b8d6836f1ff7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1 has been assigned to MD. MAHABUB ALAM\"}', NULL, '2026-10-18 03:38:12', '2026-10-18 03:38:12'),
('353a9c12-a9f6-46a0-b815-ec22ac123ce1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2 has been assigned to MD. MAHABUB ALAM\"}', '2026-10-18 07:13:06', '2026-10-18 06:31:00', '2026-10-18 07:13:06'),
('359eed79-a825-42eb-95ad-38022e45d502', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: you are the primary responsible employee\"}', '2026-10-19 03:31:00', '2026-10-18 08:28:04', '2026-10-19 03:31:00'),
('3708633a-e8cd-47cb-8c96-af8562c46c1c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"Your request RQ-7 was submitted.\"}', '2026-10-19 05:11:10', '2026-10-19 05:08:26', '2026-10-19 05:11:10'),
('3ac64760-5c95-42a8-932a-a4e61a75a95f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"New request RQ-1: New user need (for YEASMIN ARA CHOWDHURY, filed by System Administrator)\"}', '2026-10-18 03:33:19', '2026-10-18 03:28:31', '2026-10-18 03:33:19'),
('3b83eddd-f6bf-4ddf-ad57-c454af4b6145', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 05:06:20', '2026-10-19 05:06:20'),
('3ba701c3-cd7f-4358-a009-600eab821d72', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 8, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', NULL, '2026-10-19 07:29:29', '2026-10-19 07:29:29'),
('3d3c33dd-1fd3-4e1d-99bf-200465b5bd93', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"Your request RQ-6 was submitted.\"}', '2026-10-19 03:33:34', '2026-10-19 03:25:52', '2026-10-19 03:33:34'),
('3e41ac50-b604-4fc9-aeed-25ecb27110f2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"Your request RQ-9 was submitted.\"}', '2026-10-19 05:25:45', '2026-10-19 05:25:41', '2026-10-19 05:25:45'),
('3e4b7ef3-573f-49a5-80e5-aebdda330b37', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"Your request RQ-10 was submitted.\"}', '2026-10-19 07:28:02', '2026-10-19 07:00:24', '2026-10-19 07:28:02'),
('3f49d4ed-43c9-432e-bd2b-a7ed28647226', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', NULL, '2026-10-19 05:08:26', '2026-10-19 05:08:26'),
('404fb4cd-1b41-44ae-9d79-9baad868c8d9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: Resolved \\u2192 User Confirmation\"}', '2026-10-19 05:11:02', '2026-10-19 05:06:20', '2026-10-19 05:11:02'),
('432b9fc8-fe22-4f65-9473-66b633493a82', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: you are the primary responsible employee\"}', '2026-10-19 09:08:18', '2026-10-19 07:01:00', '2026-10-19 09:08:18'),
('436542f9-577f-4976-99c3-4431e93d9d35', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-18 03:47:41', '2026-10-18 03:47:41'),
('453dedcb-72c4-404c-83d2-9b981812282b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('481c70fc-4609-4ab9-9f52-6b5186b013b2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: User Confirmation \\u2192 Closed\"}', '2026-10-19 09:11:01', '2026-10-19 09:09:46', '2026-10-19 09:11:01'),
('4cdbd492-09a0-4fca-8f3b-a1a5835e8b5d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 13, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: you are the primary responsible employee\"}', '2026-10-25 04:36:36', '2026-10-25 04:26:38', '2026-10-25 04:36:36'),
('4d1ab398-3794-4123-a980-860a96e2245c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', NULL, '2026-10-19 07:26:50', '2026-10-19 07:26:50'),
('4d6f17b0-c1a9-4c93-bf8d-eb93d8c11a8e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 03:47:41', '2026-10-18 03:47:41'),
('4df09f77-72cf-4816-a02e-405aeba7a259', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"Your request RQ-3 was submitted.\"}', '2026-10-18 08:26:00', '2026-10-18 08:25:26', '2026-10-18 08:26:00'),
('4df35432-122e-4c7f-807c-09b38a854dd9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: you are the primary responsible employee\"}', '2026-10-18 12:15:56', '2026-10-18 12:13:32', '2026-10-18 12:15:56'),
('526b183f-95ca-4547-88a7-9e0937ff2e4b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', NULL, '2026-10-19 07:00:24', '2026-10-19 07:00:24'),
('527cf6e3-b046-4832-97da-76b1a35c1c52', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', '2026-10-19 03:29:46', '2026-10-19 03:25:52', '2026-10-19 03:29:46'),
('538819d4-7c34-4253-bec8-925a78ebb7bd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('53e6163f-f291-4b81-963a-08086ca9d643', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: User Confirmation \\u2192 Closed\"}', '2026-10-18 06:36:08', '2026-10-18 03:49:13', '2026-10-18 06:36:08'),
('5617dfdd-05c1-4d87-a7f6-ea491f2938aa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', '2026-10-19 11:58:29', '2026-10-19 09:09:15', '2026-10-19 11:58:29'),
('59b35dff-4bfd-4932-9da3-75420d9ebff2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-19 03:31:10', '2026-10-18 06:31:00', '2026-10-19 03:31:10'),
('5da46a49-1975-4efe-9cb9-fddac2f3c084', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('5e0297a7-1da7-4221-942d-8e999b52734f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('5ecd4273-81e2-4ebf-8eea-182a48360e18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', NULL, '2026-10-19 03:25:52', '2026-10-19 03:25:52'),
('5f7b7fe7-821a-464f-9bb8-dceb8055f0a3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('5fac1a0a-3bc2-4379-a033-e1041c1c6b27', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: Resolved \\u2192 User Confirmation\"}', '2026-10-18 12:17:31', '2026-10-18 12:15:06', '2026-10-18 12:17:31'),
('6372e633-0bc3-4499-973f-eb3e09bc1bd3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', NULL, '2026-10-19 07:00:24', '2026-10-19 07:00:24'),
('6468928b-6e09-45b8-baf8-976b30a7ec5d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', '2026-10-19 07:28:02', '2026-10-19 05:25:41', '2026-10-19 07:28:02'),
('65457537-430a-42b6-a906-b38b4f76a181', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', NULL, '2026-10-19 07:26:50', '2026-10-19 07:26:50'),
('67104023-3ebe-4b86-9940-2f4f3254b764', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: Assigned \\u2192 In Progress\"}', NULL, '2026-10-18 03:43:56', '2026-10-18 03:43:56'),
('67d745a8-a918-470e-aec0-c2eb5255b383', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"Your request RQ-2 was submitted.\"}', '2026-10-18 06:29:02', '2026-10-18 06:28:57', '2026-10-18 06:29:02'),
('694ce642-bff7-4ee0-b059-98f3aaae0049', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', NULL, '2026-10-18 12:11:44', '2026-10-18 12:11:44'),
('6b717abd-56a1-460b-b714-9c27e39d0798', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:46', '2026-10-19 09:09:46'),
('6fa1892a-88f0-43b5-ad99-a81bf8a8a3ca', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you are the primary responsible employee\"}', '2026-10-18 06:32:39', '2026-10-18 06:31:17', '2026-10-18 06:32:39'),
('7b04a0b1-95e1-4dc0-8d9a-1cbfe5a22463', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 05:06:20', '2026-10-19 05:06:20'),
('7b09eddb-3f36-4ab1-819d-c69b1c69239a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: User Confirmation \\u2192 Closed\"}', NULL, '2026-10-18 03:49:13', '2026-10-18 03:49:13'),
('7b909532-3559-44f1-b66a-b621aafe6d21', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', '2026-10-19 07:28:02', '2026-10-19 05:20:46', '2026-10-19 07:28:02'),
('7c81f0ef-7503-49da-8607-55008f3dcdc0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you were removed from the team\"}', '2026-10-19 03:15:45', '2026-10-18 03:42:44', '2026-10-19 03:15:45'),
('7cbc4367-a01d-4883-81c5-4b280ffbb3f5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"IT Employee updated their work on RQ-1: In progress\"}', '2026-10-19 03:15:48', '2026-10-18 03:41:56', '2026-10-19 03:15:48'),
('7d52af85-a3fe-4986-8e49-74df94e5eb0f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"RQ-9: you are the primary responsible employee\"}', NULL, '2026-10-19 05:26:51', '2026-10-19 05:26:51'),
('7d58b6e1-f164-4ddb-b20a-848a00166647', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: Assigned \\u2192 In Progress\"}', '2026-10-19 07:28:02', '2026-10-19 05:31:44', '2026-10-19 07:28:02'),
('8190c4b9-1706-4216-baf3-53ef378a739c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: User Confirmation \\u2192 Closed\"}', NULL, '2026-10-19 06:43:55', '2026-10-19 06:43:55'),
('81a971de-b5d0-4073-86cd-c00f4646d726', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('826999ca-895a-4efb-96eb-9ee5af18e700', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', NULL, '2026-10-19 07:26:50', '2026-10-19 07:26:50'),
('832e8827-0ca1-4065-b9a5-b2d0679df9c5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"New request RQ-12: Group 1 & 2 Data input.\"}', '2026-10-19 07:28:02', '2026-10-19 07:26:50', '2026-10-19 07:28:02'),
('85b09dc1-fb2a-4257-a6a0-ab136af5107d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('8650007f-5749-477f-8615-0d258b1c642e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: Assigned \\u2192 In Progress\"}', '2026-10-19 03:38:52', '2026-10-19 03:35:17', '2026-10-19 03:38:52'),
('89063b74-2f29-49a4-b9fc-985f11d727e7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: User Confirmation \\u2192 Closed\"}', '2026-10-18 12:15:54', '2026-10-18 12:15:31', '2026-10-18 12:15:54'),
('8a3f8ed2-5dce-47b9-bc8b-60e339480209', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1 has been assigned to IT Employee\"}', NULL, '2026-10-18 03:42:44', '2026-10-18 03:42:44'),
('8b2743ef-e30c-42f3-a056-01ac8a86ff2c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', '2026-10-18 12:17:29', '2026-10-18 12:15:06', '2026-10-18 12:17:29'),
('8b5c2b23-649b-49d6-9dbf-564ab71dcb7f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-19 09:10:40', '2026-10-19 07:29:29', '2026-10-19 09:10:40'),
('8daf0e81-a68c-4b19-9ed1-799fa4231a3c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: you are the primary responsible employee\"}', '2026-10-19 09:09:34', '2026-10-19 07:25:41', '2026-10-19 09:09:34'),
('8dd83d4c-bd81-458c-89bb-03f6c9daa677', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', NULL, '2026-10-19 05:20:46', '2026-10-19 05:20:46'),
('8ea97f54-b745-4a54-8040-71d7eb9f49ee', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 11, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-25 03:31:56', '2026-10-19 07:29:29', '2026-10-25 03:31:56'),
('8ffd839a-b64f-487c-a5b8-96e970bc9571', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', '2026-10-19 05:10:53', '2026-10-19 05:06:20', '2026-10-19 05:10:53'),
('906c5d80-cab9-4010-a5ed-be1aea3152c2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"New request RQ-3: Need to prepare a document\"}', '2026-10-18 08:27:43', '2026-10-18 08:25:26', '2026-10-18 08:27:43'),
('9274c154-a8cf-4c2f-b951-579648704d8b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"RQ-13: Assigned \\u2192 In Progress\"}', '2026-10-25 05:01:21', '2026-10-25 04:36:48', '2026-10-25 05:01:21'),
('929bcf4b-7e93-47e1-830f-d257143e1f23', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: User Confirmation \\u2192 Closed\"}', NULL, '2026-10-19 05:07:01', '2026-10-19 05:07:01'),
('9435462d-adc5-4bbc-b60b-52846befc6f9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: Resolved \\u2192 User Confirmation\"}', '2026-10-18 07:13:06', '2026-10-18 06:33:20', '2026-10-18 07:13:06'),
('972b4da0-89d2-4b70-8ddb-d083d8657a06', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: User Confirmation \\u2192 Closed\"}', '2026-10-19 03:24:33', '2026-10-18 11:27:35', '2026-10-19 03:24:33'),
('a0329d1a-2f80-4793-bdae-d7a498e961eb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-18 03:41:29', '2026-10-18 03:40:58', '2026-10-18 03:41:29'),
('a816d0f2-1094-4daf-89a0-bb3cb13eb484', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: In Progress \\u2192 Resolved\"}', '2026-10-18 07:13:06', '2026-10-18 06:33:20', '2026-10-18 07:13:06'),
('a82fcd53-c695-4880-862f-d9d4690113fa', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"RQ-4: In Progress \\u2192 Resolved\"}', '2026-10-19 03:29:46', '2026-10-18 12:15:06', '2026-10-19 03:29:46'),
('a8a84e95-0dc3-4571-84a4-7b62c931524b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: Resolved \\u2192 User Confirmation\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('a8b47474-bf0f-48e7-8c86-859e2b6858e0', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"New request RQ-2: Email Password reset\"}', NULL, '2026-10-18 06:28:57', '2026-10-18 06:28:57'),
('aa41651a-760d-40ff-8d59-e0fafd116e7e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: Assigned \\u2192 In Progress\"}', '2026-10-19 11:58:46', '2026-10-19 11:51:45', '2026-10-19 11:58:46'),
('aa954f7d-a6d1-4b30-a74f-072c407b0bae', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('ab670fcb-d6c8-437a-9a94-a6524804e223', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"Your request RQ-5 was submitted.\"}', '2026-10-19 03:29:46', '2026-10-18 12:29:09', '2026-10-19 03:29:46'),
('ade1521a-8382-412c-8ae7-2448953c1940', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('b0ebbebb-150e-409d-8110-b4e5110d5704', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":3,\"ticket_no\":\"RQ-3\",\"message\":\"RQ-3: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 08:32:34', '2026-10-18 08:32:34'),
('b36138e4-2d1a-482d-805e-670272aa26b1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', '2026-10-19 07:24:31', '2026-10-19 07:00:24', '2026-10-19 07:24:31'),
('b6908c3e-7244-4c8a-85d4-e8dc8dff18a6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', '2026-10-19 03:41:38', '2026-10-18 12:29:09', '2026-10-19 03:41:38'),
('b8d2e867-019c-42a3-b463-9371574481bd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', NULL, '2026-10-19 05:08:26', '2026-10-19 05:08:26'),
('bd1fdd9e-6104-4b97-b7b2-1eaefc3b926b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"New request RQ-2: Email Password reset\"}', '2026-10-18 06:29:28', '2026-10-18 06:28:57', '2026-10-18 06:29:28'),
('bd7ba89e-0277-4da8-9772-03d058379c7e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', NULL, '2026-10-19 07:25:32', '2026-10-19 07:25:32'),
('bfb70e1e-eedc-4475-b83a-7c1589735dae', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('c11f7828-f126-4483-904c-c748e842bb4b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 06:35:18', '2026-10-19 06:35:18'),
('c1f56157-bf00-4545-8768-2fa6f2dd4690', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', NULL, '2026-10-19 05:25:41', '2026-10-19 05:25:41'),
('c2705280-b48d-4e6b-ade3-63cc47e0c846', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', '2026-10-19 05:13:11', '2026-10-19 05:06:20', '2026-10-19 05:13:11'),
('c2a35601-b2e4-4e97-94a7-f04747b826f5', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-18 03:40:26', '2026-10-18 03:38:12', '2026-10-18 03:40:26'),
('c49e2261-216f-4aa4-8fa1-1804049c5b5d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', '2026-10-19 03:33:30', '2026-10-18 12:29:09', '2026-10-19 03:33:30'),
('c866b32f-5856-478e-8119-3f8f28274e29', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 06:35:18', '2026-10-19 06:35:18'),
('c90d9331-6963-4991-a601-46bba0490775', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"Your request RQ-13 was submitted.\"}', '2026-10-25 04:18:02', '2026-10-25 04:17:56', '2026-10-25 04:18:02'),
('c97993c8-4e7e-4686-82b2-10893ccee560', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you were removed from the team\"}', '2026-10-19 03:15:38', '2026-10-18 06:31:17', '2026-10-19 03:15:38'),
('ca4ff585-431a-44cc-a672-6b5aacfab208', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you are the primary responsible employee\"}', '2026-10-18 03:43:10', '2026-10-18 03:42:44', '2026-10-18 03:43:10'),
('cf5ef9c6-3b8b-47a0-8484-68f62ae4f0e3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"RQ-8: you are the primary responsible employee\"}', NULL, '2026-10-19 05:21:00', '2026-10-19 05:21:00'),
('cfb97edf-017e-4f4b-949c-ec263492cbbc', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"RQ-6: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 05:06:20', '2026-10-19 05:06:20'),
('d0118631-1b19-4040-9724-28264bcd3074', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', NULL, '2026-10-19 05:25:41', '2026-10-19 05:25:41'),
('d099f1cf-3b39-4648-846d-15906a07b5bf', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', NULL, '2026-10-19 07:25:32', '2026-10-19 07:25:32'),
('d202b015-8117-46e1-a472-7c86d04f6b28', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"RQ-12: you are the primary responsible employee\"}', NULL, '2026-10-19 07:29:29', '2026-10-19 07:29:29'),
('d37e6758-a980-49e7-99e6-997fa84c4731', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"New request RQ-11: Update Computer Transfer File\"}', '2026-10-19 08:40:04', '2026-10-19 07:25:32', '2026-10-19 08:40:04'),
('d3ea6a68-f6af-480a-a398-0d56cd5093b4', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 12, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: you are the primary responsible employee\"}', '2026-10-19 03:15:51', '2026-10-18 03:38:12', '2026-10-19 03:15:51'),
('d57cdbbe-948f-4594-8a34-3920c2da653a', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: User Confirmation \\u2192 Closed\"}', '2026-10-18 07:13:06', '2026-10-18 06:36:28', '2026-10-18 07:13:06'),
('d64c6419-e10d-4a0d-a4d2-0f7882912d9d', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":12,\"ticket_no\":\"RQ-12\",\"message\":\"Your request RQ-12 was submitted.\"}', '2026-10-19 08:40:04', '2026-10-19 07:26:50', '2026-10-19 08:40:04'),
('d7a8b9c3-2493-46ab-be5a-81102762302b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"New request RQ-10: Please write a note on provided documents\"}', NULL, '2026-10-19 07:00:24', '2026-10-19 07:00:24'),
('d7e283ca-6dec-4081-8587-69ea70211278', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: Resolved \\u2192 User Confirmation\"}', '2026-10-19 07:28:02', '2026-10-19 06:35:18', '2026-10-19 07:28:02'),
('d832797a-c86b-4a08-a51e-1a2a1c29377b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"Request RQ-4 was submitted for Md Sajjad Hossain.\"}', '2026-10-18 12:11:55', '2026-10-18 12:11:44', '2026-10-18 12:11:55'),
('da699709-4583-4897-8a83-1869f2289202', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: In Progress \\u2192 Resolved\"}', NULL, '2026-10-18 06:33:20', '2026-10-18 06:33:20'),
('dafefacf-e7ee-4726-810f-1c04295a0790', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', '2026-10-19 08:40:04', '2026-10-19 06:35:18', '2026-10-19 08:40:04'),
('db8a71f4-e675-4cd5-8ac4-21fba503c3ca', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: In Progress \\u2192 Resolved\"}', '2026-10-18 06:33:43', '2026-10-18 06:33:20', '2026-10-18 06:33:43'),
('e00738e3-31c5-49d1-9b1c-897687220cb8', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: you were added as a supporting employee (MD. MAHABUB ALAM is primary)\"}', '2026-10-18 06:36:08', '2026-10-18 06:31:00', '2026-10-18 06:36:08'),
('e11000fb-4c50-49cb-8195-1906ce7fe896', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', NULL, '2026-10-18 12:29:09', '2026-10-18 12:29:09'),
('e3ed92b4-e0af-49b3-bd34-138b755ec2c1', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: Assigned \\u2192 In Progress\"}', '2026-10-18 07:13:06', '2026-10-18 06:32:44', '2026-10-18 07:13:06'),
('e43d9de6-4221-4a07-8b56-9676b2995cc3', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', NULL, '2026-10-19 05:20:46', '2026-10-19 05:20:46'),
('e85abd7f-ef61-4872-b278-7631965edb18', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"IT commented on RQ-2\"}', '2026-10-18 07:13:06', '2026-10-18 06:34:27', '2026-10-18 07:13:06'),
('e8ad709b-13de-4a97-bea6-3f43570cdda2', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"RQ-7: In Progress \\u2192 Resolved\"}', '2026-10-19 07:28:02', '2026-10-19 06:35:18', '2026-10-19 07:28:02'),
('e8faf1a6-c93e-406e-b698-a07d05e3b9b6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"New request RQ-1: New user need (for YEASMIN ARA CHOWDHURY, filed by System Administrator)\"}', NULL, '2026-10-18 03:28:31', '2026-10-18 03:28:31'),
('ebd80a0a-e800-4451-84b8-275d07d0ce3b', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 5, '{\"ticket_id\":2,\"ticket_no\":\"RQ-2\",\"message\":\"RQ-2: User Confirmation \\u2192 Closed\"}', '2026-10-18 08:30:11', '2026-10-18 06:36:28', '2026-10-18 08:30:11'),
('ec89d04f-b976-4967-807e-062ac0076d4f', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"System Administrator submitted request RQ-1 on your behalf.\"}', NULL, '2026-10-18 03:28:31', '2026-10-18 03:28:31'),
('ed23f291-1070-4794-8c68-a9d5be0163c9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', '2026-10-19 03:41:35', '2026-10-19 03:25:52', '2026-10-19 03:41:35'),
('ef2c4fd1-008c-42ec-ae15-5b6d0877a9bd', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: Assigned \\u2192 In Progress\"}', NULL, '2026-10-19 09:08:23', '2026-10-19 09:08:23'),
('f13bcc8b-8d97-4f9b-af24-55a2e713ebf6', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":10,\"ticket_no\":\"RQ-10\",\"message\":\"RQ-10: In Progress \\u2192 Resolved\"}', NULL, '2026-10-19 09:09:15', '2026-10-19 09:09:15'),
('f215cc27-290e-44de-a02b-e92d77732eef', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"RQ-14: you are the primary responsible employee\"}', NULL, '2026-10-25 05:26:30', '2026-10-25 05:26:30'),
('f3bc984a-3bc4-4f5a-be24-87ed89aa13fb', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 17, '{\"ticket_id\":4,\"ticket_no\":\"RQ-4\",\"message\":\"New request RQ-4: Tax Report (for Md Sajjad Hossain, filed by Md Tarek Hossain)\"}', '2026-10-18 12:16:59', '2026-10-18 12:11:44', '2026-10-18 12:16:59'),
('f462ba38-3fef-499f-9185-68f37626e4be', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 4, '{\"ticket_id\":1,\"ticket_no\":\"RQ-1\",\"message\":\"RQ-1: In Progress \\u2192 Resolved\"}', '2026-10-18 03:48:46', '2026-10-18 03:47:41', '2026-10-18 03:48:46'),
('f604ac19-87fa-460c-a7f8-9f7c4fb50d9c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":14,\"ticket_no\":\"RQ-14\",\"message\":\"New request RQ-14: Domain Purchase\"}', NULL, '2026-10-25 05:25:59', '2026-10-25 05:25:59'),
('f730d01e-353b-49a9-8fdf-f9f0a6c8596e', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":9,\"ticket_no\":\"RQ-9\",\"message\":\"New request RQ-9: Mater File Update\"}', NULL, '2026-10-19 05:25:41', '2026-10-19 05:25:41'),
('f8632498-41a8-4473-b987-40164dc2ff97', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 16, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"New request RQ-8: Add depot name\"}', NULL, '2026-10-19 05:20:46', '2026-10-19 05:20:46'),
('f90fb4fe-fb6d-4dcd-984c-62d9a61ed4d7', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":7,\"ticket_no\":\"RQ-7\",\"message\":\"New request RQ-7: Overtime for October 2026 (Other Depot)\"}', '2026-10-19 05:13:01', '2026-10-19 05:08:26', '2026-10-19 05:13:01'),
('f9babdfa-1e36-4f97-ba0c-ca090ba13064', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 7, '{\"ticket_id\":8,\"ticket_no\":\"RQ-8\",\"message\":\"Your request RQ-8 was submitted.\"}', '2026-10-19 05:21:05', '2026-10-19 05:20:46', '2026-10-19 05:21:05'),
('fa379a03-cee3-4bed-94f5-2aad235b7730', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 9, '{\"ticket_id\":11,\"ticket_no\":\"RQ-11\",\"message\":\"RQ-11: User Confirmation \\u2192 Closed\"}', '2026-10-19 09:11:05', '2026-10-19 09:10:03', '2026-10-19 09:11:05'),
('fd1cc50c-aa11-4a14-9d51-a774b1c29d71', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":13,\"ticket_no\":\"RQ-13\",\"message\":\"New request RQ-13: Preparing Stationary Items List\"}', NULL, '2026-10-25 04:17:56', '2026-10-25 04:17:56'),
('fd3aadb9-8a79-492c-b790-167b03c34c1c', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 15, '{\"ticket_id\":5,\"ticket_no\":\"RQ-5\",\"message\":\"New request RQ-5: ht\"}', NULL, '2026-10-18 12:29:09', '2026-10-18 12:29:09'),
('fd6bd65a-246f-49c4-82d9-b0a3e19316f9', 'App\\Notifications\\TicketNotification', 'App\\Models\\User', 6, '{\"ticket_id\":6,\"ticket_no\":\"RQ-6\",\"message\":\"New request RQ-6: Pay Slip Ready For Salary October 2026 (Staff)\"}', NULL, '2026-10-19 03:25:52', '2026-10-19 03:25:52');

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
(1, 'admin', 'System Administrator', '[\"ticket.create\",\"ticket.create.behalf\",\"ticket.view.own\",\"ticket.view.all\",\"ticket.comment.public\",\"ticket.note.internal\",\"attachment.upload\",\"attachment.download.internal\",\"dashboard.officer\",\"report.view\",\"attendance.view\",\"user.manage\",\"lookup.manage\",\"settings.manage\",\"audit.view\"]', '2026-10-08 06:28:08', '2026-10-17 13:55:36'),
(2, 'it_officer', 'IT Admin', '[\"ticket.create\",\"ticket.create.behalf\",\"ticket.view.own\",\"ticket.view.all\",\"ticket.acknowledge\",\"ticket.assign\",\"ticket.edit\",\"ticket.work\",\"ticket.comment.public\",\"ticket.note.internal\",\"ticket.close\",\"ticket.reopen\",\"ticket.escalate\",\"ticket.cancel\",\"attachment.upload\",\"attachment.download.internal\",\"dashboard.officer\",\"report.view\",\"lookup.manage\",\"user.manage\"]', '2026-10-08 06:28:08', '2026-10-17 13:55:36'),
(3, 'it_member', 'IT Team Member', '[\"ticket.create\",\"ticket.create.behalf\",\"ticket.view.own\",\"ticket.view.assigned\",\"ticket.work\",\"ticket.comment.public\",\"ticket.note.internal\",\"ticket.escalate\",\"attachment.upload\",\"attachment.download.internal\",\"dashboard.member\",\"attendance.own\"]', '2026-10-08 06:28:08', '2026-10-17 13:55:36'),
(4, 'dept_user', 'Department User', '[\"ticket.create\",\"ticket.view.own\",\"ticket.comment.public\",\"ticket.confirm\",\"ticket.reopen\",\"ticket.cancel\",\"attachment.upload\",\"dashboard.department\"]', '2026-10-08 06:28:08', '2026-10-17 13:55:36'),
(5, 'dept_head', 'Department Head', '[\"ticket.create\",\"ticket.create.behalf.dept\",\"ticket.view.own\",\"ticket.view.department\",\"ticket.comment.public\",\"ticket.confirm\",\"ticket.reopen\",\"ticket.cancel\",\"attachment.upload\",\"dashboard.department\",\"report.view\"]', '2026-10-08 06:28:08', '2026-10-17 13:55:36'),
(6, 'management', 'Management', '[\"ticket.view.all\",\"dashboard.officer\",\"report.view\",\"attendance.view\"]', '2026-10-08 06:28:08', '2026-10-17 13:55:36');

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
('13VnzEtSeN4FZl6UbeT7QvXQWk35WZZKswVAy9iz', NULL, '103.16.73.137', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidE9mTFpDSm1EbThoN0Z5TndDMTJ1eWlBc0h2OUQ2SmNNOFRHMW1kNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1792906243),
('29U0hEnFlSAl1IGL9RMhFmplrS0bl7LZPM9g4VOd', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTm5CVFU2ZGFsR1B6S0NjcUdRSFdUd25MbkwySUh5a0xCYlJKQlVRcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1792898185),
('2IjdRAzYE9ZNj58cPfRXgtUHr46El8ECp8SluDm5', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXh2Y3l5QWxJTEVHb2ZnRVJUR1dIVTMwaXV0TGF4NlpGcGdFMTlEMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1792902040),
('8BzKKgUsvMzeOnYCeQSY7T28R0P6UKB5ldP4aTb1', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUZHaDNSZG12WlR3eFhNWWNHeVFCemUwb2p6SGNiRmZEUnQ2Rm5oZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792899682),
('cl9TYGRgjlrPIPR5pY2LM0kmOp2SDfDBRsOpV2x0', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzVNMkEzM0tlUFNvOG9pdGZXejR6bEtmNnpRbHZmRkJGRGxKMW92UCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1792903357),
('iO2tleLTy4QFvfdCGM5H7oj875qwsw7TQ5pcCf4u', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3V4dlhhMHhWSjVVa0pJT3dONno5aTVmaEU1RDdDUGpCa2V1NXlQaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0mdGltZW91dD0xIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1792901291),
('iRXr8qwV8878oWmc82MMRdPnglhYaYBGFlXceLqx', 7, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiOWtPWjFHR3FTU0ZPWHB3M1hDRmdSNUhRdkpWMWtoRmRYaEcyTnhLMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9ub3RpZmljYXRpb25zPyUyRm5vdGlmaWNhdGlvbnM9IjtzOjU6InJvdXRlIjtzOjE5OiJub3RpZmljYXRpb25zLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NztzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiZTQ3YWVjZDJkZmRlZTZmMDUyZjM0ZTkxNTk5NjU1MzBjNjQ1ZTg0NWI3ODcxYmMwZTJlNDk1Y2UxNTRiYmY3OSI7czoxNjoibGFzdF9hY3Rpdml0eV9hdCI7aToxNzkyOTA3MjAzO3M6MTY6Imxhc3RfYWN0aXZpdHlfaXAiO3M6MTM6IjEwMy4xNi43My4xMzkiO30=', 1792907203),
('wDHucyggNszt9JLLWLFCvtr5YbIhISWDvQAkjGtV', 11, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoielJyVm5qYms4ZmdyNWpYd2hudk9ZRGhLY2c0ZDZrYnAzbk9mZXFORSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9teS1hdHRlbmRhbmNlPyUyRm15LWF0dGVuZGFuY2U9IjtzOjU6InJvdXRlIjtzOjE1OiJhdHRlbmRhbmNlLm1pbmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiZjI3YTJiZjU0OGIzMGZlNTI4MzgwM2E0YmEwZTg2NjU1YjE1ZGY2Y2YxZjljOGE1ZmM0ZGJhZTBhOGE5MTFmNCI7czoxNjoibGFzdF9hY3Rpdml0eV9hdCI7aToxNzkyODk5MjIzO3M6MTY6Imxhc3RfYWN0aXZpdHlfaXAiO3M6MTM6IjEwMy4xNi43My4xMzkiO30=', 1792899223),
('YNMbQPP5130RORcFZ0XP9eBHweenkZBiT7RzyJaw', NULL, '103.16.73.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlluSjd1R1o1azlSWFQ1TXJtc24xYVhVREZqMVVqa2s2MnFiOU9lZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMDMuMTYuNzMuMTQxL3Btcy9sb2dpbj8lMkZsb2dpbj0iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1792896534);

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
(12, 'RQ-12', 11, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 14, 3, 4, 'Group 1 & 2 Data input.', 'Input Group 1 & 2 old software September salary data to the new software.', NULL, 12, NULL, NULL, 0, '2026-10-19 09:26:50', '2026-10-19 23:26:50', 'on_track', '2026-10-19 07:29:29', '2026-10-19 07:29:29', '2026-10-19 11:51:45', NULL, NULL, NULL, 0, NULL, NULL, 7, 12, '2026-10-19 07:26:50', '2026-10-19 11:51:45', NULL),
(13, 'RQ-13', 12, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 6, NULL, 3, 4, 'Preparing Stationary Items List', 'Prepare a list of all stationary and other items of MIS & IT Department', NULL, 13, NULL, NULL, 0, '2026-10-25 06:17:56', '2026-10-25 20:17:56', 'on_track', '2026-10-25 04:26:38', '2026-10-25 04:26:38', '2026-10-25 04:36:48', NULL, NULL, NULL, 0, NULL, NULL, 7, 13, '2026-10-25 04:17:56', '2026-10-25 04:36:48', NULL),
(14, 'RQ-14', 7, 7, 1, 'Md Abu Hanife Nayem', '20251341', 'Senior Officer', '01521236214', 'nayem.jocl@gmail.com', 1, 2, 12, 3, 3, 'Domain Purchase', 'Proceed to Purchase 2 subdomain from BTCL\r\n1.erp.jamunaoil.gov.bd\r\n2.hrm.jamunaoil.gov.bd', NULL, 16, NULL, NULL, 0, '2026-10-25 07:25:59', '2026-10-25 21:25:59', 'on_track', '2026-10-25 05:26:30', '2026-10-25 05:26:30', NULL, NULL, NULL, NULL, 0, NULL, NULL, 7, 7, '2026-10-25 05:25:59', '2026-10-25 05:26:30', NULL);

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
(15, 12, 8, 7, 'SUPPORT', NULL, '2026-10-19 07:29:29', 'ASSIGNED', NULL, '2026-10-19 07:29:29', '2026-10-19 07:29:29'),
(16, 12, 9, 7, 'SUPPORT', NULL, '2026-10-19 07:29:29', 'ASSIGNED', NULL, '2026-10-19 07:29:29', '2026-10-19 07:29:29'),
(17, 12, 11, 7, 'SUPPORT', NULL, '2026-10-19 07:29:29', 'ASSIGNED', NULL, '2026-10-19 07:29:29', '2026-10-19 07:29:29'),
(18, 12, 12, 7, 'PRIMARY', 1, '2026-10-19 07:29:29', 'IN_PROGRESS', NULL, '2026-10-19 07:29:29', '2026-10-19 11:51:45'),
(19, 13, 13, 7, 'PRIMARY', 1, '2026-10-25 04:26:38', 'IN_PROGRESS', NULL, '2026-10-25 04:26:38', '2026-10-25 04:36:48'),
(20, 14, 16, 7, 'PRIMARY', 1, '2026-10-25 05:26:30', 'ASSIGNED', NULL, '2026-10-25 05:26:30', '2026-10-25 05:26:30');

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
(14, 11, 9, 'Resolved', '2026-10-19 09:09:46', '2026-10-19 09:09:46');

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
(101, 14, 7, 'assigned', 'assigned_to', NULL, 'Md Tarek Hossain', NULL, '2026-10-25 05:26:30');

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
(0, 14);

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
(53, 6, 'Note Draft', 1, '2026-10-19 06:59:41', '2026-10-19 06:59:41');

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
(1, 'Incident', 'INC', 0, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(2, 'Service Request', 'SR', 0, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(3, 'Change Request', 'CHG', 1, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(4, 'Access Request', 'ACC', 1, 1, '2026-10-08 06:28:08', '2026-10-08 06:28:08'),
(5, 'IT Device Request', 'AST', 1, 1, '2026-10-08 06:28:08', '2026-10-19 05:14:41'),
(6, 'Development Request', 'DEV', 0, 1, '2026-10-19 04:42:40', '2026-10-19 04:42:40'),
(7, 'Maintenance', 'MAIN', 0, 1, '2026-10-19 04:42:52', '2026-10-19 04:42:52'),
(8, 'Procurement Request', 'ITP', 0, 1, '2026-10-19 04:43:31', '2026-10-19 04:43:31'),
(9, 'Consultancy', 'CON', 0, 1, '2026-10-19 04:43:52', '2026-10-19 04:43:52'),
(10, 'IT Training', 'ITT', 0, 1, '2026-10-19 04:44:03', '2026-10-19 04:44:03'),
(11, 'Data Entry', 'DAT', 0, 1, '2026-10-19 05:14:29', '2026-10-19 05:14:29'),
(12, 'Departmental Services', 'DPS', 0, 1, '2026-10-19 05:23:04', '2026-10-19 05:23:04');

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
(1, 1, 5, 'IN_PROGRESS', NULL, '2026-10-18 03:41:56');

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
  `session_open` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `department_id`, `designation_id`, `location_id`, `whatsapp`, `avatar_path`, `is_active`, `is_department_head`, `show_in_attendance`, `failed_logins`, `locked_until`, `last_login_at`, `last_login_ip`, `password_changed_at`, `last_activity_at`, `last_activity_ip`, `session_open`) VALUES
(1, NULL, 'Accounts User', 'acct_user@joplc.com', NULL, '$2y$12$kzJZFOciig/E/9USmMDtwuvzgvHW5XwDhs1VT7eH0ZL5OaNnHPPmC', NULL, '2026-10-08 06:28:08', '2026-10-18 11:28:38', 2, NULL, 1, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, NULL, 'Sales User', 'sales_user@joplc.com', NULL, '$2y$12$u8p6kRp7k6wWsrqif6Ffe.vULZ5QxyXY/r77xtBoM13cMIdpxBT8.', NULL, '2026-10-08 06:28:08', '2026-10-18 11:29:38', 3, NULL, 1, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, NULL, 'Accounts Head', 'acct_head@joplc.com', NULL, '$2y$12$c40PoxyUKsnY3vC7KdF1Te4tFVmt4cNDu8knjpEdTxNhFtbRCkZQm', NULL, '2026-10-08 06:28:09', '2026-10-18 11:29:25', 2, NULL, 1, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, NULL, 'IT Admin', 'it_admin@joplc.com', NULL, '$2y$12$BmUzAwzlNZveAPEj/yZPQuo/eAOwa3JSruaj/PeiCOugzi3eCtXpy', NULL, '2026-10-08 06:28:09', '2026-10-19 03:26:55', 1, NULL, 1, NULL, NULL, 0, 0, 0, 3, NULL, '2026-10-18 08:27:37', '103.16.73.139', NULL, '2026-10-18 08:29:07', '103.16.73.139', 0),
(5, NULL, 'IT Employee', 'it_emp@joplc.com', NULL, '$2y$12$/TiX7SibnvHwy8wqpxqYueW0pXrSBvWRXV64HXNVE3S.jHBOJwn3O', NULL, '2026-10-08 06:28:09', '2026-10-18 11:28:55', 1, NULL, 1, NULL, NULL, 0, 0, 1, 0, NULL, '2026-10-18 08:29:48', '103.16.73.139', NULL, '2026-10-18 08:29:48', '103.16.73.139', 0),
(6, '20070725', 'MOHAMMAD SHARIFUL ISLAM', 'sharif99452@gmail.com', NULL, '$2y$12$ExIMWuhPT16xdKg37RBJdeaFlUObwxzcYdtXZIl9Dv0PqYDTll8ya', NULL, '2026-10-08 06:28:09', '2026-10-18 12:01:06', 1, 3, 1, '01777797319', NULL, 1, 0, 0, 0, NULL, '2026-10-18 06:41:55', '103.16.73.139', NULL, '2026-10-18 06:43:29', '103.16.73.139', 0),
(7, '20251341', 'Md Abu Hanife Nayem', 'nayem.jocl@gmail.com', NULL, '$2y$12$6updb3ilShVS8YPCZiscsudIHepxdohvhz7r/v5wSamlJ.0bhDcmK', NULL, '2026-10-08 06:28:09', '2026-10-25 05:46:43', 1, 2, 1, '01521236214', 'avatars/7-3668f8bb83929295.jpg', 1, 0, 0, 0, NULL, '2026-10-25 05:18:56', '103.16.73.139', NULL, '2026-10-25 05:46:43', '103.16.73.139', 1),
(8, '1', 'MEHEDI RAIHAN', 'raihanmehedi700@gmail.com', NULL, '$2y$12$ox73ogjyuV/8fANP/cHDrewpCM6C4wjfh2nVqXOZPAYRvEKilND1q', NULL, '2026-10-08 06:41:37', '2026-10-25 02:48:54', 1, 4, 1, '01771713685', NULL, 1, 0, 1, 0, NULL, '2026-10-25 02:48:03', '103.16.73.139', '2026-10-08 06:41:37', '2026-10-25 02:48:03', '103.16.73.139', 0),
(9, '2', 'ISRAT JAHAN', 'israt29190@gmail.com', NULL, '$2y$12$yAqpFn67wjkHPrNj5UcyleiuwWo5oOoVh9P4sgoGFvryNER1TMCHC', NULL, '2026-10-08 06:47:15', '2026-10-25 04:20:40', 1, 4, 1, '01876692194', NULL, 1, 0, 1, 0, NULL, '2026-10-25 03:46:33', '103.16.73.139', '2026-10-08 06:47:15', '2026-10-25 04:05:00', '103.16.73.139', 0),
(10, '3', 'TULI NANDY', 'nandytuli9@gmail.com', NULL, '$2y$12$BKK0QAbIHW8KowytaZm7vedyDXMQL1EiGg5UWRcQ0U0xlvRhBjhD2', NULL, '2026-10-08 06:49:51', '2026-10-15 04:22:31', 1, 4, 1, '01674827361', NULL, 1, 0, 1, 0, NULL, '2026-10-15 04:13:57', '103.16.73.137', '2026-10-12 04:00:41', '2026-10-15 04:21:45', '103.16.73.137', 0),
(11, '4', 'MD. RAZAUL KARIM', 'md.razaulkarim86@gmail.com', NULL, '$2y$12$s37ul/dzt8SaibETNHJ3LuEC81LYAvWv9lu2U893WBAbrm5U0HBH2', NULL, '2026-10-08 06:54:39', '2026-10-25 03:33:38', 1, 5, 1, '01819633879', NULL, 1, 0, 1, 0, NULL, '2026-10-25 03:30:50', '103.16.73.139', '2026-10-08 06:54:39', '2026-10-25 03:33:38', '103.16.73.139', 1),
(12, '5', 'MD. MAHABUB ALAM', 'mahabubjocl@gmail.com', NULL, '$2y$12$efDTtG6QVBNZLX93UU6eceX1oTtb8g6Kf0/ZIen0TcV1.lMH3iJqm', NULL, '2026-10-08 06:56:34', '2026-10-25 04:08:11', 1, 5, 1, '01613444355', NULL, 1, 0, 1, 0, NULL, '2026-10-25 03:42:11', '103.16.73.139', '2026-10-08 06:56:34', '2026-10-25 03:53:02', '103.16.73.139', 0),
(13, '7', 'RAFAT KHAN', 'rafatkhan1988@gmail.com', NULL, '$2y$12$wlSZu0r612jg6HcVV/xcrulXFnOHm/kxl6oTLPJmcrYb.fl4Xk32i', NULL, '2026-10-08 08:55:48', '2026-10-25 05:30:43', 1, 4, 1, '01672011005', NULL, 1, 0, 1, 0, NULL, '2026-10-25 05:14:00', '103.16.73.137', '2026-10-08 08:55:48', '2026-10-25 05:14:00', '103.16.73.137', 0),
(14, '8', 'KAZI MD AIYUB', 'kaziaiyub06@gmail.com', NULL, '$2y$12$rC6s4wAI9kPOYTlpjwJ4DOeuGnZGVHH5IAk2BvlsLBR4QQ/e0Wugu', NULL, '2026-10-08 09:01:48', '2026-10-25 03:16:10', 1, 4, 1, '01731964635', NULL, 1, 0, 1, 0, NULL, '2026-10-25 03:16:00', '103.16.73.139', '2026-10-08 09:01:48', '2026-10-25 03:16:00', '103.16.73.139', 0),
(15, '20051090', 'YEASMIN ARA CHOWDHURY', 'yeasminsoma0@gmail.com', NULL, '$2y$12$eDpPQzvk/4Q6twaULtSo.OdeiJGvgJ/PkYyN4u7YaQdVoHmGNmYNq', NULL, '2026-10-11 06:00:25', '2026-10-19 05:32:50', 1, 6, 1, '01866823255', NULL, 1, 0, 0, 0, NULL, '2026-10-19 05:29:54', '103.16.73.139', '2026-10-11 06:00:25', '2026-10-19 05:32:50', '103.16.73.139', 1),
(16, '1357', 'Md Tarek Hossain', 'tarek.jocl@gmail.com', NULL, '$2y$12$4Ug8R6mDSIBjPdgcJZBPweMmtxmFbzTke2eqdw1n2SFfIcwIiTyeS', NULL, '2026-10-18 11:55:54', '2026-10-19 04:41:52', 1, 7, 1, '01844290967', NULL, 1, 0, 0, 0, NULL, '2026-10-19 03:38:31', '103.16.73.139', '2026-10-18 11:55:54', '2026-10-19 04:25:37', '103.16.73.139', 0),
(17, '1308', 'Md Sajjad Hossain', 'sajjad.jocl2020@gmail.com', NULL, '$2y$12$YZoku/88vb9OlhPBgdiCWup2gde3eHfdz03iogcAwsF1tmwRNjHRK', NULL, '2026-10-18 11:58:04', '2026-10-19 11:49:24', 1, 1, 1, '01830310919', NULL, 1, 0, 0, 0, NULL, '2026-10-19 11:49:12', '103.16.73.139', '2026-10-18 11:58:04', '2026-10-19 11:49:12', '103.16.73.139', 0);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ticket_assignment_log`
--
ALTER TABLE `ticket_assignment_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ticket_history`
--
ALTER TABLE `ticket_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ticket_work_updates`
--
ALTER TABLE `ticket_work_updates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
