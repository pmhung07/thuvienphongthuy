-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 11, 2017 at 09:39 AM
-- Server version: 10.0.27-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thuvienphongthuy_vn`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu_order`
--

CREATE TABLE IF NOT EXISTS `admin_menu_order` (
  `amo_admin` int(11) NOT NULL DEFAULT '0',
  `amo_module` int(11) NOT NULL DEFAULT '0',
  `amo_order` int(11) DEFAULT '0',
  PRIMARY KEY (`amo_admin`,`amo_module`),
  KEY `amo_order` (`amo_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_menu_order`
--

INSERT INTO `admin_menu_order` (`amo_admin`, `amo_module`, `amo_order`) VALUES
(1, 25, 2),
(1, 24, 27),
(1, 23, 21),
(1, 22, 5),
(1, 21, 2),
(5, 12, 1),
(5, 19, 2),
(5, 17, 0),
(5, 14, 3),
(1, 12, 24),
(1, 2, 0),
(1, 9, 28),
(1, 7, 10),
(1, 11, 25),
(1, 5, 15),
(1, 19, 14),
(1, 10, 22),
(1, 17, 15),
(1, 16, 18),
(1, 8, 0),
(1, 14, 1),
(1, 13, 19),
(1, 6, 0),
(1, 18, 8),
(1, 15, 0),
(1, 4, 4),
(1, 20, 23),
(1, 3, 3),
(1, 1, 2),
(1, 26, 20),
(1, 27, 17),
(6, 17, 3),
(6, 18, 4),
(6, 19, 2),
(6, 25, 1),
(7, 17, 7),
(7, 18, 8),
(7, 19, 9),
(7, 20, 4),
(7, 25, 5),
(1, 28, 21),
(6, 22, 9),
(6, 28, 10),
(1, 29, 0),
(1, 30, 0),
(1, 31, 0),
(1, 32, 0),
(1, 33, 0),
(7, 22, 6),
(7, 28, 4),
(7, 15, 2),
(7, 16, 3),
(6, 15, 7),
(6, 16, 8),
(7, 10, 0),
(7, 13, 1),
(6, 10, 5),
(6, 13, 6),
(8, 25, 0),
(8, 19, 0),
(1, 34, 0),
(0, 34, 0),
(0, 22, 1),
(0, 27, 3),
(0, 13, 4),
(0, 26, 5),
(0, 28, 2),
(0, 23, 6),
(0, 10, 7),
(0, 25, 8),
(0, 15, 9),
(0, 16, 10),
(0, 17, 11),
(0, 18, 12),
(0, 19, 13),
(0, 20, 14),
(0, 12, 15),
(0, 11, 16),
(0, 14, 17),
(0, 24, 18),
(0, 9, 19),
(1, 35, 13),
(6, 12, 0),
(11, 19, 0),
(11, 24, 0),
(11, 25, 0),
(9, 17, 0),
(9, 19, 0),
(9, 24, 0),
(9, 25, 0),
(9, 35, 0),
(10, 19, 0),
(10, 22, 0),
(10, 24, 0),
(10, 25, 0),
(13, 19, 1),
(13, 24, 0),
(13, 25, 0),
(14, 19, 0),
(14, 24, 0),
(14, 25, 0),
(6, 14, 11),
(7, 14, 0),
(7, 24, 0),
(7, 35, 0),
(15, 25, 0),
(15, 19, 0),
(15, 24, 0),
(7, 12, 0),
(7, 26, 0),
(19, 25, 0),
(17, 25, 0),
(21, 25, 0),
(18, 25, 0),
(16, 25, 0),
(22, 17, 0),
(22, 18, 0),
(22, 19, 0),
(22, 20, 0),
(22, 22, 0),
(22, 24, 0),
(22, 25, 0),
(22, 35, 0),
(20, 25, 0),
(7, 9, 0),
(7, 11, 0),
(7, 23, 0),
(7, 27, 0),
(23, 24, 0),
(24, 24, 0),
(24, 25, 0),
(27, 17, 0),
(27, 18, 0),
(27, 19, 0),
(27, 20, 0),
(27, 22, 0),
(27, 24, 0),
(27, 35, 0),
(29, 10, 15),
(29, 11, 23),
(29, 12, 14),
(29, 13, 13),
(29, 15, 12),
(29, 16, 11),
(29, 17, 9),
(29, 18, 10),
(29, 19, 1),
(29, 20, 18),
(29, 23, 8),
(29, 25, 4),
(29, 24, 0),
(29, 26, 7),
(29, 27, 6),
(29, 22, 10),
(29, 28, 4),
(29, 35, 5),
(28, 18, 0),
(28, 19, 0),
(28, 20, 0),
(28, 22, 0),
(28, 24, 0),
(27, 25, 0),
(29, 9, 11),
(30, 18, 0),
(30, 19, 0),
(30, 24, 0),
(30, 25, 0),
(31, 10, 0),
(31, 13, 0),
(31, 15, 0),
(31, 16, 0),
(31, 17, 0),
(31, 18, 0),
(31, 19, 0),
(31, 20, 0),
(31, 22, 0),
(31, 23, 0),
(31, 24, 0),
(31, 25, 0),
(31, 26, 0),
(31, 35, 0),
(28, 11, 0),
(28, 12, 0),
(28, 13, 0),
(28, 15, 0),
(28, 17, 0),
(28, 23, 0),
(28, 26, 0),
(28, 35, 0),
(32, 15, 0),
(32, 16, 0),
(32, 17, 0),
(32, 18, 0),
(32, 19, 0),
(32, 20, 0),
(32, 22, 0),
(32, 24, 0),
(32, 25, 0),
(32, 35, 0),
(1, 36, 11),
(1, 37, 12),
(29, 36, 8),
(29, 37, 9),
(33, 25, 0),
(34, 17, 0),
(34, 19, 0),
(34, 25, 0),
(1, 38, 10),
(35, 17, 0),
(35, 18, 0),
(35, 19, 0),
(35, 20, 0),
(35, 25, 0),
(35, 24, 0),
(36, 25, 0),
(37, 9, 0),
(37, 10, 0),
(37, 11, 0),
(37, 12, 0),
(37, 13, 0),
(37, 14, 0),
(37, 15, 0),
(37, 16, 0),
(37, 17, 0),
(37, 18, 0),
(37, 19, 0),
(37, 20, 0),
(37, 23, 0),
(37, 25, 0),
(37, 24, 0),
(37, 26, 0),
(37, 27, 0),
(37, 35, 0),
(37, 36, 0),
(37, 37, 0),
(37, 38, 0),
(38, 19, 0),
(38, 24, 0),
(38, 25, 0),
(39, 17, 0),
(39, 18, 0),
(39, 19, 0),
(39, 24, 0),
(39, 25, 0),
(40, 17, 0),
(40, 18, 0),
(40, 19, 0),
(40, 20, 0),
(40, 24, 0),
(40, 25, 0),
(41, 17, 0),
(41, 19, 0),
(1, 39, 7),
(1, 40, 0),
(42, 17, 0),
(42, 18, 0),
(42, 19, 0),
(42, 20, 0),
(42, 24, 0),
(42, 25, 0),
(1, 41, 0),
(29, 39, 7),
(13, 39, 2),
(43, 25, 0),
(41, 39, 0),
(44, 25, 0),
(47, 24, 0),
(47, 25, 0),
(46, 9, 0),
(46, 10, 0),
(46, 11, 0),
(46, 12, 0),
(46, 13, 0),
(46, 15, 0),
(46, 16, 0),
(46, 17, 0),
(46, 18, 0),
(46, 19, 0),
(46, 20, 0),
(46, 23, 0),
(46, 25, 0),
(46, 24, 0),
(46, 26, 0),
(46, 27, 0),
(46, 35, 0),
(46, 37, 0),
(46, 39, 0),
(45, 17, 0),
(45, 18, 0),
(45, 19, 0),
(45, 20, 0),
(45, 24, 0),
(45, 25, 0),
(48, 17, 0),
(48, 18, 0),
(48, 19, 0),
(48, 20, 0),
(48, 24, 0),
(48, 25, 0),
(1, 42, 9),
(29, 42, 6),
(44, 42, 0),
(49, 25, 0),
(29, 14, 0),
(29, 38, 5),
(50, 19, 0),
(50, 24, 0),
(50, 25, 0),
(51, 25, 0),
(7, 36, 0),
(7, 37, 0),
(7, 38, 0),
(7, 39, 0),
(7, 42, 0),
(1, 43, 1),
(29, 43, 2),
(43, 43, 0),
(27, 43, 0),
(10, 43, 0),
(24, 43, 0),
(31, 43, 0),
(32, 43, 0),
(52, 25, 0),
(52, 43, 0),
(53, 17, 0),
(53, 18, 0),
(53, 19, 0),
(53, 20, 0),
(53, 24, 0),
(53, 25, 0),
(37, 39, 0),
(37, 42, 0),
(37, 43, 0),
(13, 15, 3),
(13, 16, 4),
(13, 17, 5),
(13, 18, 6),
(13, 35, 7),
(13, 36, 8),
(13, 37, 9),
(13, 42, 10),
(13, 43, 11),
(7, 43, 0),
(1, 45, 5),
(1, 46, 6),
(1, 47, 4),
(1, 49, 3),
(31, 39, 0),
(27, 45, 0),
(54, 19, 0),
(51, 19, 0),
(38, 45, 0),
(38, 47, 0),
(38, 49, 0),
(55, 25, 0),
(51, 43, 0),
(56, 25, 0),
(44, 45, 0),
(57, 25, 0),
(58, 25, 0),
(59, 17, 0),
(59, 18, 0),
(59, 19, 0),
(59, 43, 0),
(51, 18, 0),
(31, 27, 0),
(60, 18, 0),
(60, 19, 0),
(60, 17, 0),
(61, 19, 0),
(61, 25, 0),
(62, 25, 0),
(13, 14, 0),
(60, 25, 0),
(63, 19, 0),
(64, 19, 0),
(50, 17, 0),
(50, 18, 0),
(50, 43, 0),
(58, 24, 0),
(65, 24, 0),
(65, 25, 0),
(33, 24, 0),
(49, 24, 0),
(55, 24, 0),
(57, 24, 0),
(62, 43, 0),
(68, 25, 0),
(68, 42, 0),
(68, 43, 0),
(69, 25, 0),
(69, 43, 0),
(67, 17, 0),
(67, 24, 0),
(67, 25, 0),
(70, 14, 0),
(70, 17, 0),
(70, 18, 0),
(70, 19, 0),
(70, 24, 0),
(70, 25, 0),
(70, 35, 0),
(70, 36, 0),
(70, 37, 0),
(70, 39, 0),
(70, 42, 0),
(70, 43, 0),
(66, 14, 0),
(66, 17, 0),
(66, 18, 0),
(66, 19, 0),
(66, 24, 0),
(66, 25, 0),
(66, 35, 0),
(66, 36, 0),
(66, 37, 0),
(66, 39, 0),
(66, 42, 0),
(66, 43, 0),
(72, 25, 0),
(73, 25, 0),
(74, 25, 0),
(74, 43, 0),
(75, 25, 0),
(76, 25, 0),
(77, 17, 0),
(77, 25, 0),
(78, 25, 0),
(78, 43, 0),
(79, 17, 0),
(79, 18, 0),
(79, 19, 0),
(80, 17, 0),
(80, 19, 0),
(80, 25, 0),
(81, 17, 0),
(81, 19, 0),
(81, 25, 0),
(82, 17, 0),
(82, 24, 0),
(82, 25, 0),
(83, 17, 0),
(83, 24, 0),
(83, 25, 0),
(84, 19, 0),
(84, 25, 0),
(84, 42, 0),
(84, 43, 0),
(85, 17, 0),
(85, 18, 0),
(85, 19, 0),
(85, 20, 0),
(85, 25, 0),
(86, 17, 0),
(86, 18, 0),
(86, 25, 0),
(1, 50, 0),
(87, 19, 0),
(87, 25, 0),
(87, 43, 0),
(88, 17, 0),
(88, 18, 0),
(88, 19, 0),
(89, 25, 0),
(89, 43, 0),
(90, 19, 0),
(90, 25, 0),
(90, 39, 0),
(29, 50, 3),
(91, 17, 0),
(91, 19, 0),
(91, 25, 0),
(92, 17, 0),
(92, 19, 0),
(92, 25, 0),
(93, 17, 0),
(93, 19, 0),
(93, 27, 0),
(93, 25, 0),
(94, 19, 0),
(94, 25, 0),
(94, 43, 0),
(96, 17, 0),
(96, 25, 0),
(96, 43, 0),
(97, 10, 0),
(97, 12, 0),
(97, 13, 0),
(97, 14, 0),
(97, 15, 0),
(97, 16, 0),
(97, 17, 0),
(97, 18, 0),
(97, 19, 0),
(97, 23, 0),
(97, 24, 0),
(97, 25, 0),
(97, 26, 0),
(97, 27, 0),
(97, 35, 0),
(97, 43, 0),
(97, 50, 0),
(43, 23, 0),
(98, 19, 0),
(98, 25, 0),
(98, 27, 0),
(97, 46, 0),
(70, 10, 0),
(70, 12, 0),
(70, 16, 0),
(70, 23, 0),
(70, 26, 0),
(70, 27, 0),
(70, 46, 0),
(70, 50, 0),
(99, 10, 0),
(99, 12, 0),
(99, 16, 0),
(99, 17, 0),
(99, 18, 0),
(99, 19, 0),
(99, 23, 0),
(99, 24, 0),
(99, 25, 0),
(99, 26, 0),
(99, 27, 0),
(99, 35, 0),
(99, 43, 0),
(99, 46, 0),
(99, 50, 0),
(37, 46, 0),
(37, 50, 0),
(61, 27, 0),
(1, 51, 0),
(1, 52, 0),
(29, 51, 16),
(29, 52, 17),
(61, 51, 0),
(61, 52, 0),
(97, 51, 0),
(97, 52, 0),
(79, 25, 0),
(79, 43, 0),
(1, 53, 0),
(90, 43, 0),
(100, 25, 0),
(100, 43, 0),
(1, 63, 0),
(1, 64, 0),
(1, 44, 0),
(1, 48, 0),
(1, 66, 0),
(1, 67, 0),
(1, 68, 0),
(1, 61, 0),
(1, 62, 0),
(1, 69, 0),
(1, 70, 0),
(1, 73, 0),
(1, 71, 0),
(1, 72, 0),
(1, 60, 0),
(1, 59, 0),
(1, 58, 0),
(1, 57, 0),
(1, 65, 0),
(1, 74, 0),
(1, 75, 0),
(1, 76, 0),
(62, 1, 0),
(62, 3, 0),
(62, 14, 0),
(62, 15, 0),
(62, 22, 0),
(62, 76, 0),
(1, 77, 0),
(1, 78, 0),
(1, 79, 0),
(1, 80, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_translate`
--

CREATE TABLE IF NOT EXISTS `admin_translate` (
  `tra_keyword` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tra_text` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `tra_source` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`tra_keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_translate`
--

INSERT INTO `admin_translate` (`tra_keyword`, `tra_text`, `lang_id`, `tra_source`) VALUES
('7b7bc2512ee1fedcd76bdc68926d4f7b', 'Administrator', NULL, 'Administrator'),
('92a0c34d248a92158439d9fe8cd8f3d7', 'My Account Settings', NULL, 'My Account Settings'),
('bb963991d090ccbda164125fae51d302', 'Add new member management', NULL, 'Add new member management'),
('970fbf35df228ca68fc54cdd1286539a', 'Member management listing', NULL, 'Member management listing'),
('214da1f24a3f988f8152522853ab3958', 'Website Settings', NULL, 'Website Settings'),
('0323de4f66a1700e2173e9bcdce02715', 'Logout', NULL, 'Logout'),
('b61541208db7fa7dba42c85224405911', 'Menu', NULL, 'Menu'),
('e050b402c1f5326f8d350c61694e0513', 'Show list menu', NULL, 'Show list menu'),
('6bc362dbf494c61ea117fe3c71ca48a5', 'Move', NULL, 'Move'),
('8b14cccf460524cc522b671cb73c4a60', 'Username is not empty and> 3 characters', NULL, 'Username is not empty and> 3 characters'),
('4a2625fe1771a1890227ec50ee1f86ea', 'Administrator account already exists', NULL, 'Administrator account already exists'),
('df10cc9b682c4dbf276339eb45b2a65b', 'Password must be greater than 4 characters', NULL, 'Password must be greater than 4 characters'),
('16648260e58b4cf9d458e1a197ef43f1', 'Email is invalid', NULL, 'Email is invalid'),
('224e2acc248325e112a1d8631b8aa2d3', 'Add new member', NULL, 'Add new member'),
('7ccf75fa7498152efe4e152833455c67', 'Login name', NULL, 'Login name'),
('f11b368cddfe37c47af9b9d91c6ba4f0', 'Full name', NULL, 'Full name'),
('bcc254b55c4a1babdf1dcb82c207506b', 'Phone', NULL, 'Phone'),
('dc647eb65e6711e155375218212b3964', 'Password', NULL, 'Password'),
('4c231e0da3eaaa6a9752174f7f9cfb31', 'Confirm password', NULL, 'Confirm password'),
('ce8ae9da5b7cd6c3df2929543a9af92d', 'Email', NULL, 'Email'),
('fc8c9c23f2469829de2243f7f8d72444', 'Right module', NULL, 'Right module'),
('99938282f04071859941e18f16efcf42', 'select', NULL, 'select'),
('22884db148f0ffb0d830ba431102b0b5', 'module', NULL, 'module'),
('34ec78fcc91ffb1e54cd85e4a0924332', 'add', NULL, 'add'),
('de95b43bceeb4b998aed4aed5cef1ae7', 'edit', NULL, 'edit'),
('099af53f601532dbd31e0ea99ffdeb64', 'delete', NULL, 'delete'),
('be82fbf6d7c55af87ba69b9dff2dc7ff', 'Ngôn ngữ', NULL, 'Ngôn ngữ'),
('df8191c2beda9c6aca13fa77f5e540d2', 'Cấu hinh', NULL, 'Cấu hinh'),
('4994a8ffeba4ac3140beb89e8d41f174', 'Language', NULL, 'Language'),
('c9cb3dbd637672e65c8138311808f73b', 'all_category', NULL, 'all_category'),
('03368e3c1eb4d2a9048775874301b19f', 'Select category', NULL, 'Select category'),
('97efa0b62a66b41fd988ec7fc2e694bb', 'save_change', NULL, 'save_change'),
('4594b97fc007a53b3e727dff76015a92', 'Please_enter_Old_password', NULL, 'Please_enter_Old_password'),
('a7c31c1d5e83cb69a35bb36a907abb44', 'Please_enter_New_password', NULL, 'Please_enter_New_password'),
('5fad91acf14ca6920bb84cb7bd72c9c0', 'New_password_must_be_at_least_6_characters', NULL, 'New_password_must_be_at_least_6_characters'),
('ff3806e80cd949908764c0b76cf0af83', 'Please_enter_confirm_password', NULL, 'Please_enter_confirm_password'),
('afb12635ac15e867c3968bc1459532c1', 'New_password_and_confirm_password_is_not_correct', NULL, 'New_password_and_confirm_password_is_not_correct'),
('01c643fcdc6979fe16e0aa1a492192e8', 'edit_the_information_management', NULL, 'edit_the_information_management'),
('3bd27d5b87038caa242f4f4020245af6', 'Change_your_Email', NULL, 'Change_your_Email'),
('3359f0cd1bbefac69fac3f4a2e7edd42', 'Change_your_password', NULL, 'Change_your_password'),
('e1f42c3f43ff8b2826b3162969b9f459', 'User login', NULL, 'User login'),
('01557660faa28f8ec65992d1ddbb7b79', 'Your Email', NULL, 'Your Email'),
('c93ce0c5bad27f3f26a54a17d9e42657', 'Change email', NULL, 'Change email'),
('09a5a307de671894b4276b0ea8577671', 'Reset all', NULL, 'Reset all'),
('062d2b8bc2cfac7772c75ae8090fb9d1', 'Old password', NULL, 'Old password'),
('3544848f820b9d94a3f3871a382cf138', 'New password', NULL, 'New password'),
('6ab96a5df54aa6aae2bab9ea75ab76c9', 'Confirm new password', NULL, 'Confirm new password'),
('0b39c5aca15b84b1ad53a94d6b3feb78', 'Change password', NULL, 'Change password'),
('48ac7023f5336e87b09d17a76bb02821', 'Thông tin tài khoản của bạn', NULL, 'Thông tin tài khoản của bạn'),
('3896fae1e0badb956dc9af2b15766b28', 'Cấu hình module', NULL, 'Cấu hình module'),
('8df314f50401b0b9738864d326d03cd3', 'Thoát', NULL, 'Thoát'),
('27163bae262de21ce154cfbdfd477c2b', 'Management website version 1.0', NULL, 'Management website version 1.0'),
('09f0c5159c5e34504e453eff3fc70324', 'Account Management', NULL, 'Account Management'),
('08bd40c7543007ad06e4fce31618f6ec', 'Account', NULL, 'Account'),
('99dea78007133396a7b8ed70578ac6ae', 'Login', NULL, 'Login'),
('56ee3495a32081ccb6d2376eab391bfa', 'Listing', NULL, 'Listing'),
('b78a3223503896721cca1303f776159b', 'Title', NULL, 'Title'),
('bb2562bfee18c26343fc91d08e28a625', 'No selected', NULL, 'No selected'),
('c9cc8cce247e49bae79f15173ce97354', 'Save', NULL, 'Save'),
('5fb63579fc981698f97d55bfecb213ea', 'Copy', NULL, 'Copy'),
('7dce122004969d56ae2e0245cb754d35', 'Edit', NULL, 'Edit'),
('f2a6c498fb90ee345d997f888fce3b18', 'Delete', NULL, 'Delete'),
('dfaa01f3617bd390d1cb2bab9cf0520f', 'Click to edit...', NULL, 'Click to edit...'),
('48abd7fae8de549e4271afaf506bb800', 'Enter keyword', NULL, 'Enter keyword'),
('961f2247a2070bedff9f9cd8d64e2650', 'Choose', NULL, 'Choose'),
('8929ef313c0fd6e43446cc0aa86b70cd', 'Tìm kiếm', NULL, 'Tìm kiếm'),
('f1851d5600eae616ee802a31ac74701b', 'Enter', NULL, 'Enter'),
('063c5bad4cb4e38270a8064282d8cf26', 'Sort A->Z or Z->A', NULL, 'Sort A->Z or Z->A'),
('7230432287324d1e98e7f2b77affe81c', 'Do you want quick edit basic', NULL, 'Do you want quick edit basic'),
('8833c8e8224a14b07aa3e6e75adff5c8', 'Click vào để sửa đổi sau đó enter để lưu lại', NULL, 'Click vào để sửa đổi sau đó enter để lưu lại'),
('40782f943cb26695685719d494a86558', 'Click sửa đổi sau đó chọn save', NULL, 'Click sửa đổi sau đó chọn save'),
('e74687ce22a0dd5b084b221e0245d9c1', 'Nhân bản thêm một bản ghi mới', NULL, 'Nhân bản thêm một bản ghi mới'),
('103e26ede1d9a1ef79d9a695ad38f076', 'Bạn muốn sửa đổi bản ghi', NULL, 'Bạn muốn sửa đổi bản ghi'),
('a5915972963fbe301b98cba71fec357b', 'Bạn muốn xóa bản ghi?', NULL, 'Bạn muốn xóa bản ghi?'),
('d879cb7ec352716ee940adac5c505340', 'Do you want to delete the product you''ve selected ?', NULL, 'Do you want to delete the product you''ve selected ?'),
('24c0b84c19d8cdde90951ac6762f0706', 'Delete all selected', NULL, 'Delete all selected'),
('17ae5cc83fa7a949d2008d5d2a556fe2', 'Total record', NULL, 'Total record'),
('f7d5343e33c330dcecd1d398d20c8e92', 'Bạn đã nhân bản bản ghi thành công', NULL, 'Bạn đã nhân bản bản ghi thành công'),
('8d6e39135454a7027fc058ab43383aa8', 'Trang tĩnh', NULL, 'Trang tĩnh'),
('d7a00df7478eb7c92d3fc2671f3566b3', 'Quản trị admin', NULL, 'Quản trị admin'),
('4d3d769b812b6faa6b76e1a8abaece2d', 'Active', NULL, 'Active'),
('9d5b888617863d159ab820e180d623ef', 'Are you sure to delete', NULL, 'Are you sure to delete'),
('b987786c142dd32f3accf9f4149a0872', 'Edit member', NULL, 'Edit member'),
('6bcecfe8349eb783b735d815c8e08c28', 'Edit member profile', NULL, 'Edit member profile'),
('b36aa562ba43e1963c42cdec3c8b5b77', 'Change password member', NULL, 'Change password member'),
('8547034108ba0285d5339f5e149d9b32', 'Please enter new password', NULL, 'Please enter new password'),
('2516af6cb654137bb71e9d2fd6c577d2', 'New password and confirm password is not correct', NULL, 'New password and confirm password is not correct'),
('2ac2ab1411f17fb8cba5b55dabe6b1e4', 'Lệnh xóa đã được thực thi', NULL, 'Lệnh xóa đã được thực thi'),
('c5fdc1445fe5c0dcaa39c1d115855bf7', 'Thông tin tài khoản', NULL, 'Thông tin tài khoản'),
('d28be3f99afba35abdbbfe4c99b6e1e3', 'Please_enter_your_email', NULL, 'Please_enter_your_email'),
('78d20478f2f45aa8b7145bd54d06402a', 'information_was_updated_successfully', NULL, 'information_was_updated_successfully'),
('353dabf6d46427c82546b9a493614ad0', 'Please_enter_new_password', NULL, 'Please_enter_new_password'),
('57fbf1acc87fb60f9ea8ebdbbb873302', 'Your_new_password_has_been_updated', NULL, 'Your_new_password_has_been_updated'),
('a81259cef8e959c624df1d456e5d3297', 'static', NULL, 'static'),
('068f80c7519d0528fb08e82137a72131', 'Products', NULL, 'Products'),
('3c0a7d001a21130f5db7d07b9a439fe1', 'Non Product', NULL, 'Non Product'),
('dd1ba1872df91985ed1ca4cde2dfe669', 'News', NULL, 'News'),
('95dcedf40fa126126059d385a5b99ff0', 'Please choose category type', NULL, 'Please choose category type'),
('573d643cf1e507e3939566ee8cb85bfe', 'Please enter category name', NULL, 'Please enter category name'),
('fda58db98b52e8d92a3f1cd51c9a450f', 'Add_new_category', NULL, 'Add_new_category'),
('d655b63849eeb44fad5798c66e116998', 'type_category', NULL, 'type_category'),
('fd690b6d380ba7eb2a9e5cec25da61a6', 'Choose type category', NULL, 'Choose type category'),
('b068931cc450442b63f5b3d276ea4297', 'name', NULL, 'name'),
('70a17ffa722a3985b86d30b034ad06d7', 'order', NULL, 'order'),
('0122b4c2c01ee1c698ecc309d2b8eb5a', 'upper', NULL, 'upper'),
('01d3dfc57f26088606d3e9f6bf7a1048', 'upper_category', NULL, 'upper_category'),
('060fb83015cb941e21d082671d52885d', 'Continue add new', NULL, 'Continue add new'),
('1d613209ca4410c69b31bafb38de7cb2', 'clear_all', NULL, 'clear_all'),
('f1cea98356796a054e3a2db2f0fe32f9', 'Category_listing', NULL, 'Category_listing'),
('c6e7280140fd46628ba9ba7ec51a0f91', 'select_type_category', NULL, 'select_type_category'),
('c4ef352f74e502ef5e7bc98e6f4e493d', 'category', NULL, 'category'),
('498f79c4c5bbde77f1bceb6c86fd0f6d', 'Show', NULL, 'Show'),
('a28c6d1503fde7e355cda9ce2b7ba5d0', 'Are you want duplicate record', NULL, 'Are you want duplicate record'),
('af1b98adf7f686b84cd0b443e022b7a0', 'Categories', NULL, 'Categories'),
('cd48206067ac5f62cc664794150bd319', 'Category listing', NULL, 'Category listing'),
('88cca1554d60a722c9329867fe6726de', 'Tên danh mục', NULL, 'Tên danh mục'),
('6925a750d9e84cdbab22e95eadc99906', 'Loại danh mục', NULL, 'Loại danh mục'),
('6cd9e20b34570fd85452d6841057d2c2', 'Chọn loại danh mục', NULL, 'Chọn loại danh mục'),
('29deb7955c1d18575d56aaae47bf1a5e', 'Sắp xếp', NULL, 'Sắp xếp'),
('780716c458f796ddf5f10f52f441fe56', 'Danh mục cấp trên', NULL, 'Danh mục cấp trên'),
('cf90b11dd7bbcf5cd45da5040bedd867', 'Chọn danh mục cấp trên', NULL, 'Chọn danh mục cấp trên'),
('6274b84f1f676f85714b028f6f55c57b', 'Driver PC', NULL, 'Driver PC'),
('d9cf894a32729d157f1d0bfdbfaf936c', 'Driver may quet', NULL, 'Driver may quet'),
('771458219e59453787d2146aca9fcf1e', 'Tài liệu', NULL, 'Tài liệu'),
('1cd2c2f7a203be1d0a7cc942037d51ad', 'Tin tức', NULL, 'Tin tức'),
('fe1083c0fc101c774c5499e66233d374', 'Tiếp tục thêm?', NULL, 'Tiếp tục thêm?'),
('3b7db4b6d510cc3156e3acf4365e7a74', 'Cập nhật', NULL, 'Cập nhật'),
('b82c0104ef1adec1b5e53aea1c4f8c0c', 'Nhập lại', NULL, 'Nhập lại'),
('bc214b2709bc9d5700f8e0b32cbc4d79', 'Tiếp tục thêm', NULL, 'Tiếp tục thêm'),
('c6da2bda24551c87773c3bba6b749b76', 'Vui lòng chọn loại danh mục!', NULL, 'Vui lòng chọn loại danh mục!'),
('85fec4de116c4045b390de2d02168786', 'Vui lòng nhập tên danh mục', NULL, 'Vui lòng nhập tên danh mục'),
('33d1d25eb9e66e6489b7d8f7ec654555', 'You must delete all the levels of this category', NULL, 'You must delete all the levels of this category'),
('327431af0359c7ac54080e8671c1fc80', 'You have successfully duplicated', NULL, 'You have successfully duplicated'),
('c019d25bd2df5a54287341f7481259eb', 'edit_category', NULL, 'edit_category'),
('56903119996f1373899114696160973c', 'Chia sẻ', NULL, 'Chia sẻ'),
('884db94d85bdedd34a5a58ad2e1a18d0', 'Bạn chưa nhập tên tài liệu', NULL, 'Bạn chưa nhập tên tài liệu'),
('d0cb7ccdfe5d6f0ae6aaeb9e676f414f', 'Add_new_datas', NULL, 'Add_new_datas'),
('cf210dbf1670fa82368c0a1e7f4e56c4', 'Chọn danh mục con', NULL, 'Chọn danh mục con'),
('2dd69561641113e64c0bcf4605cbd942', 'Chọn danh mục chi tiết', NULL, 'Chọn danh mục chi tiết'),
('21353a2850a5eab64aef2032ebef5816', 'ABC!', NULL, 'ABC!'),
('043da5402eca0c9215717f3cd4f3eade', 'Danh sách dữ liệu', NULL, 'Danh sách dữ liệu'),
('004e6d6e45f708cf000e0fd87bf1b65e', 'Add merchant', NULL, 'Add merchant'),
('4d6c058532a674578fe9f32efdcf6573', 'Tên tài liệu', NULL, 'Tên tài liệu'),
('53d8de583ea7608b24d2aaf0edd90f0b', 'Danh mục', NULL, 'Danh mục'),
('04c16e8f2d4a683bc3cd83c5cafa4856', 'Giới thiệu về tài liệu', NULL, 'Giới thiệu về tài liệu'),
('fc5984a3ae35bab46b4ff272d737d120', 'Trích dẫn tài liệu', NULL, 'Trích dẫn tài liệu'),
('16dbc5908e012d1940b1c55071571570', 'Giá cho mỗi lần sử dụng', NULL, 'Giá cho mỗi lần sử dụng'),
('af39d4cfecd73b52ae3ac2fdebda4561', 'Bản quyền', NULL, 'Bản quyền'),
('e90db9294ce68c5dd5d7c87d0f207980', 'Vui lòng nhập tên tài liệu', NULL, 'Vui lòng nhập tên tài liệu'),
('f01435acd94ced9d198b163136a6ceb1', 'Chọn danh mục', NULL, 'Chọn danh mục'),
('78805a221a988e79ef3f42d7c5bfd418', 'image', NULL, 'image'),
('d7df5b64df1181ef1d62d646a13aa860', 'keyword', NULL, 'keyword'),
('be53a0541a6d36f6ecb879fa2c584b08', 'Image', NULL, 'Image'),
('4631c1fd35806f277b34ba3c70069489', 'You have successfully deleted', NULL, 'You have successfully deleted'),
('f75524d2aa1e6a75e13d5e2fb7c7a676', 'Vui lòng nh?p tên danh m?c', NULL, 'Vui lòng nh?p tên danh m?c'),
('74421f0917e81d2dad20f8e4d737d37f', 'Edit_category', NULL, 'Edit_category'),
('a1cfe29a9846edb6ae913d1e1e05888c', 'Nhập từ khóa', NULL, 'Nhập từ khóa'),
('ceaf8f023f0c4b3cf66e9c5511fcff22', 'Chọn kiểu banner', NULL, 'Chọn kiểu banner'),
('54fda48d5a50ec4ce706f65c761a3dff', 'Chọn vị trí', NULL, 'Chọn vị trí'),
('03f0c66427dc00033958e15dff032dbb', 'Trang chủ', NULL, 'Trang chủ'),
('8f0e5317f1fa00221cc547c5c3cdec34', 'Edit advertising', NULL, 'Edit advertising'),
('5dae250cff71e901a306c717ab58b3b3', 'Bạn muốn sửa bản ghi', NULL, 'Bạn muốn sửa bản ghi'),
('2157fca76b95fd50a372126699d8c3ec', 'Copy thêm một bản ghi mới', NULL, 'Copy thêm một bản ghi mới'),
('142e6a934ae3c2fc01a2d3e2523cb589', 'Nhân b?n thêm m?t b?n ghi m?i', NULL, 'Nhân b?n thêm m?t b?n ghi m?i'),
('e3ba49e33c232c5ea969c87a9ee2050a', 'Quảng cáo', NULL, 'Quảng cáo'),
('1d1aa192b5f3b65f18a833224b52a22d', 'Sản phẩm', NULL, 'Sản phẩm'),
('a9636fce0da937ba4fed9958e9462cda', 'Phân quyền quản trị', NULL, 'Phân quyền quản trị'),
('ac31d041d3e67dcf260bbcd2f82469c9', 'Bạn không có quyền thực thi!', NULL, 'Bạn không có quyền thực thi!'),
('8ee82083742c1b615430a93460616a46', 'MUA BÁN NHÀ ĐẤT', NULL, 'MUA BÁN NHÀ ĐẤT'),
('094ce90bfbba4de9c0fd03f5056b77d9', 'THUÊ VÀ CHO THUÊ NHÀ', NULL, 'THUÊ VÀ CHO THUÊ NHÀ'),
('58dc583399f5d68ea9f71c42d2e79103', 'SÀN BẤT ĐỘNG SẢN', NULL, 'SÀN BẤT ĐỘNG SẢN'),
('6bf3915e608a7526412c35a16aae2b05', 'ĐIỆN THOẠI', NULL, 'ĐIỆN THOẠI'),
('0d798e4ecb3e0577de1b3c1444bcae6a', 'CHỢ SIM', NULL, 'CHỢ SIM'),
('24b1b1abff309e2a0ec134b386f8214c', 'Ô TÔ', NULL, 'Ô TÔ'),
('a68208b9b6c75d05ccac7d5839a96a4e', 'DỊCH VỤ TẬN NHÀ', NULL, 'DỊCH VỤ TẬN NHÀ'),
('b112cba49893aa090dc6091806fc37df', 'LAO ĐỘNG PHỔ THÔNG', NULL, 'LAO ĐỘNG PHỔ THÔNG'),
('c52d8d23e763c989a33058f025d93bf8', 'LAO ĐỘNG TRÍ ÓC', NULL, 'LAO ĐỘNG TRÍ ÓC'),
('efb8dfbb1cba4c8da41b67de7c08864b', 'ĐIỆN TỬ, KÝ THUẬT SỐ', NULL, 'ĐIỆN TỬ, KÝ THUẬT SỐ'),
('40e624d84556d9edf3802fdb987c8ca1', 'MUA SẮM', NULL, 'MUA SẮM'),
('b577acf82b3b3188191d3528059a3b79', 'XE MÁY, XE ĐẠP', NULL, 'XE MÁY, XE ĐẠP'),
('6ac54d2c62a894c643f30d0bb814694f', 'ĐIỆN LẠNH, ĐIỆN MÁY', NULL, 'ĐIỆN LẠNH, ĐIỆN MÁY'),
('d8b0cdf9466a76a57360064b60a9227d', 'THỜI TRANG, MỸ PHẨM', NULL, 'THỜI TRANG, MỸ PHẨM'),
('2c7a5c356c8d877cd0361bcd2c0af8af', 'MÁY TÍNH, LAPTOP', NULL, 'MÁY TÍNH, LAPTOP'),
('50d3a25ef7d8c330fb57c77e50cb48cc', 'DỊCH VỤ', NULL, 'DỊCH VỤ'),
('346a58018ae5e354e9510e25cd01c81e', 'DỊCH VỤ DOANH NGHIỆP', NULL, 'DỊCH VỤ DOANH NGHIỆP'),
('ab41a8eb003ff7fd9e67dba1627fc5a9', 'CƠ HỘI GIAO THƯƠNG', NULL, 'CƠ HỘI GIAO THƯƠNG'),
('0fb464d0dbee4648e90fd18dc8972dc6', 'DỊCH VỤ CÁ NHÂN', NULL, 'DỊCH VỤ CÁ NHÂN'),
('10a651fd5f014d666a6b95a4932857fa', 'NỘI THẤT', NULL, 'NỘI THẤT'),
('9453442b3063c7a43a629f8733f18bd4', 'TỔNG HỢP', NULL, 'TỔNG HỢP'),
('6c31fc599d184dd7a9d3a301d3de75e8', 'Phim', NULL, 'Phim'),
('97e7c9a7d06eac006a28bf05467fcc8b', 'Link', NULL, 'Link'),
('801ab24683a4a8c433c6eb40c48bcd9d', 'Download', NULL, 'Download'),
('5cc98746db0fcf058c95d4856aa46842', 'Mua bán nhà đất', NULL, 'Mua bán nhà đất'),
('fcee708258a773e87b37e65f1279e34f', 'Thuê và cho thuê', NULL, 'Thuê và cho thuê'),
('f1501d247a790dc9ff5ac31ae525de22', 'Điện thoại', NULL, 'Điện thoại'),
('bcf1ccafe96e5f7d6fcb208df045bed1', 'Chợ sim', NULL, 'Chợ sim'),
('b925cdeb1edc0985a17eea8012d9d8dd', 'Ô tô', NULL, 'Ô tô'),
('30a1d3c3aca3f918fdcc9cb589986128', 'Lao động phổ thông', NULL, 'Lao động phổ thông'),
('bae1f75899eac5a2dc9eb81f784b26a2', 'Lao động trí óc', NULL, 'Lao động trí óc'),
('ac421f45f5bd1ba2801d3130de78384d', 'Điện tử, Kỹ thuật số', NULL, 'Điện tử, Kỹ thuật số'),
('5176f4a3b49d7515441f74d305a1fee4', 'Mua sắm', NULL, 'Mua sắm'),
('06c74a7e9dcc8e66e27474e56169f44e', 'Xe máy, Xe đạp', NULL, 'Xe máy, Xe đạp'),
('5dbead756ab4eee9dd7983ab369c3295', 'Điện lạnh, Điện máy', NULL, 'Điện lạnh, Điện máy'),
('03be79eefa1432bfa4008adfd18e7836', 'Thời trang mỹ phẩm', NULL, 'Thời trang mỹ phẩm'),
('94f21c225bbfcf9f3654eaf396730085', 'Máy tính, Laptop', NULL, 'Máy tính, Laptop'),
('03dc535fc66c57188eaffca903283992', 'Du lịch', NULL, 'Du lịch'),
('d0ff935d67be1326c5c0856e725eed4d', 'Dịch vụ doanh nghiệp', NULL, 'Dịch vụ doanh nghiệp'),
('b98b3f15bb1f34359e5acf8687a78e84', 'Cơ hội giao thương', NULL, 'Cơ hội giao thương'),
('d31aef91375327cf3bd7a3fefc004d75', 'Dịch vụ cá nhân', NULL, 'Dịch vụ cá nhân'),
('d6913913945117feac3c844c6b4ebd2e', 'Nội thất', NULL, 'Nội thất'),
('8e4e27377bd0366469e7dc69b5b32275', 'Tổng hợp', NULL, 'Tổng hợp'),
('a8a2e224048f51664241961bc23f8676', 'Dịch vụ tận nhà', NULL, 'Dịch vụ tận nhà'),
('8d9d823b800103205454de85f8735c46', 'Sàn bất động sản', NULL, 'Sàn bất động sản'),
('afe41e484cf5d42d74d1efce223871c2', 'You_have_successfully_deleted', NULL, 'You_have_successfully_deleted'),
('2075c3be17b85fb44f6a45c28a9f05fc', 'Countries Listing', NULL, 'Countries Listing'),
('98f9052ad81233bca8722ba651544f6c', 'Nhu cầu', NULL, 'Nhu cầu'),
('053987a37b7f36a2760628f31120b14e', 'Toàn quốc', NULL, 'Toàn quốc'),
('4e57f728ae3215e7310bf4985c838a89', 'Hà nội', NULL, 'Hà nội'),
('f681bd651a6652cf9294c60f411f0215', 'Bắc Giang', NULL, 'Bắc Giang'),
('de7e5d9b248361f4b560802c71afc2f9', 'Bắc Kạn', NULL, 'Bắc Kạn'),
('c4d85b1be115ded42d69a6ff88b0bd47', 'Bắc Ninh', NULL, 'Bắc Ninh'),
('8bc6a5effae254a09d40a10b4516bb73', 'Cao Bằng', NULL, 'Cao Bằng'),
('e9445c96139efadcdfdc0e416858d95e', 'Điện Biên', NULL, 'Điện Biên'),
('aa910bef944a56330336f94eb757c3ed', 'Hà Giang', NULL, 'Hà Giang'),
('f0b68cacc2184c83d9dc7cb23d892663', 'Hà Nam', NULL, 'Hà Nam'),
('287393887e3fd5d3e3305a08be04083b', 'Hà Tây', NULL, 'Hà Tây'),
('651f953eb2315f6f7e35fa992ab98cd9', 'Hải Dương', NULL, 'Hải Dương'),
('6f8c60a9bdb11817373666b6a5fbd292', 'Hải Phòng', NULL, 'Hải Phòng'),
('2da3e1f27435347121f2e552eaaf93f7', 'Hòa Bình', NULL, 'Hòa Bình'),
('75b131cea90d5f490e5c4c284c4255d2', 'Hưng Yên', NULL, 'Hưng Yên'),
('5579f27dcfb93ec6cd9417d65dc125af', 'Lai Châu', NULL, 'Lai Châu'),
('c3b061272fd0d1c7e361a5345874dcd4', 'Lào Cai', NULL, 'Lào Cai'),
('602e95042b228877db1ff563b7fea774', 'Lạng Sơn', NULL, 'Lạng Sơn'),
('255743afd7d38f74bf6a90de466feb18', 'Nam Định', NULL, 'Nam Định'),
('227d280f63386c6b9bfb18b284862681', 'Ninh Bình', NULL, 'Ninh Bình'),
('7f978ef3fb24898727ae59c672858105', 'Phú Thọ', NULL, 'Phú Thọ'),
('7824812baaf94c18edb249d9d5f6f2a7', 'Quảng Ninh', NULL, 'Quảng Ninh'),
('961bc0e1955e1d3c25591c71829179dd', 'Sơn La', NULL, 'Sơn La'),
('0112b771328465cad12755f107de23ba', 'Thái Bình', NULL, 'Thái Bình'),
('11049d538b9a6a80d1760afbc1030ae1', 'Thái Nguyên', NULL, 'Thái Nguyên'),
('fca197a93a3919b2b9d30445943eb48a', 'Tuyên Quang', NULL, 'Tuyên Quang'),
('09211743135215b34c282bf417d884fa', 'Vĩnh Phúc', NULL, 'Vĩnh Phúc'),
('1bd89ebfba9e7a14512dcb29256ad806', 'Yên Bái', NULL, 'Yên Bái'),
('5804ee92a68dc628fdb455d767ac10e3', 'TP Đà Nẵng', NULL, 'TP Đà Nẵng'),
('5c8bf197cde53266268b9b62fbb396ad', 'Bình Định', NULL, 'Bình Định'),
('d32c641d1c42b6e5fd924e4570d69f6c', 'Đắk Lắk', NULL, 'Đắk Lắk'),
('31d298f206c9c839a13862282a191a76', 'Đắk Nông', NULL, 'Đắk Nông'),
('a1d27d5dbcd690d1845de3cfb765eec6', 'Gia Lai', NULL, 'Gia Lai'),
('abd12e32a9db010a4027489e7ecb5ca8', 'Hà Tĩnh', NULL, 'Hà Tĩnh'),
('35cec2b5d231397efc16d03bca948a66', 'Khánh Hòa', NULL, 'Khánh Hòa'),
('7ef23579f23bf29124128df25dc0f267', 'Kon Tum', NULL, 'Kon Tum'),
('e8bafdfea8046710577b9968f86a5562', 'Nghệ An', NULL, 'Nghệ An'),
('bd8075557de62d9a37ab8d98a10d20b0', 'Phú Yên', NULL, 'Phú Yên'),
('f7b4446a5c9ce4d381c4f9478a13ad34', 'Quảng Bình', NULL, 'Quảng Bình'),
('d063795383e2a20dcc721c14659ed812', 'Quảng Nam', NULL, 'Quảng Nam'),
('2288e6cea334ff2598e8c2065a57861e', 'Quảng Ngãi', NULL, 'Quảng Ngãi'),
('16f1b646c5a19da94a7415a300669823', 'Quảng Trị', NULL, 'Quảng Trị'),
('52d874de001c74c2cd5444fc92448216', 'Thanh Hóa', NULL, 'Thanh Hóa'),
('867f6eeb8dccda44b16fcfb8ea5d3f7d', 'Thừa Thiên Huế', NULL, 'Thừa Thiên Huế'),
('10a68cf74932e37c134b80eb07e44c3b', 'TP. Hồ Chí Minh', NULL, 'TP. Hồ Chí Minh'),
('e95140c4b0bf785a4b5f7be40fda3d65', 'An Giang', NULL, 'An Giang'),
('b2d9afe167c3a60b258ca6d0cb525129', 'Bà Rịa Vũng Tàu', NULL, 'Bà Rịa Vũng Tàu'),
('cb18cc248272f2762e4c6764712d91cc', 'Bạc Liêu', NULL, 'Bạc Liêu'),
('abf0d36fe9739173b8330685067f40d9', 'Bến Tre', NULL, 'Bến Tre'),
('d5464a7bd8514ddd69d71c976ba607bb', 'Bình Dương', NULL, 'Bình Dương'),
('c8d30e5b963a7cdd502cbe2748fa4eb6', 'Bình Phước', NULL, 'Bình Phước'),
('c4686496695da46babaee9840c354e6a', 'Bình Thuận', NULL, 'Bình Thuận'),
('e6fe3672e56730080289b7e1bc3d5712', 'Cà Mau', NULL, 'Cà Mau'),
('fcc82c7712086464966d177b39d326fa', 'Cần Thơ', NULL, 'Cần Thơ'),
('35f097891ba0021867928062c0c02699', 'Đồng Nai', NULL, 'Đồng Nai'),
('d5bd7d7c5576380c1232e7524c2d4bb2', 'Đồng Tháp', NULL, 'Đồng Tháp'),
('75a62b709dc74af6389a48a589cf1124', 'Hậu Giang', NULL, 'Hậu Giang'),
('db1100d9070e4f5f48a586a9655db48d', 'Kiên Giang', NULL, 'Kiên Giang'),
('6a30a804c6a91553f5e14b6a5b1ed49d', 'Lâm Đồng', NULL, 'Lâm Đồng'),
('5435822dcb8dcbd2cd16552ffa5e2d2c', 'Long An', NULL, 'Long An'),
('ab3af5ee6087060bf78f2bf3d0d4c88d', 'Ninh Thuận', NULL, 'Ninh Thuận'),
('f9585be0ca79ccc1fb7e219201376a57', 'Sóc Trăng', NULL, 'Sóc Trăng'),
('1b4daae1254bda0154188cb5f7d2e9e1', 'Tây Ninh', NULL, 'Tây Ninh'),
('9bba92aae60e37fe5aac43a07877a25f', 'Tiền Giang', NULL, 'Tiền Giang'),
('ba4078feda618f304a674a6a0d01bb68', 'Trà Vinh', NULL, 'Trà Vinh'),
('06de503ffc7ca3bdff2beb4b4fe901e8', 'Vĩnh Long', NULL, 'Vĩnh Long'),
('885b3ee0b741e60b926eb8c0a683c35f', 'Vui lòng chọn tỉnh!', NULL, 'Vui lòng chọn tỉnh!'),
('6f35e1f030754cc4469022127e341ccb', 'Vui lòng nhập tên tỉnh thành', NULL, 'Vui lòng nhập tên tỉnh thành'),
('eb721a72b7d386acb4e168b56fb95df1', 'Add_new_city', NULL, 'Add_new_city'),
('42ebdc9f1af092f9b974d7b51e474419', 'Chọn loại tỉnh thành', NULL, 'Chọn loại tỉnh thành'),
('4ed5d2eaed1a1fadcc41ad1d58ed603e', 'city', NULL, 'city'),
('328748b55afde20b5a956609b32b513e', 'city listing', NULL, 'city listing'),
('d42f46b914a21ee45241ac4333e5ab8a', 'Vui lòng nhập vào tên tỉnh thành!', NULL, 'Vui lòng nhập vào tên tỉnh thành!'),
('c7fa20c6a355ea7dbbab3ce6c65156ef', 'Bạn phải xóa cấp con trước khi xóa cấp cha', NULL, 'Bạn phải xóa cấp con trước khi xóa cấp cha'),
('aad8128c642bb59add89fae434ec0dc3', 'Edit_ity', NULL, 'Edit_ity'),
('805c94cc130ae10eb045385c8f54cfc5', 'Chọn cấp cha', NULL, 'Chọn cấp cha'),
('bddc6e92b622d6500bdb2048f5c3dce2', 'Edit_city', NULL, 'Edit_city'),
('b11985c961634dd69ca8539f59797db3', 'Tỉnh/Thành phố', NULL, 'Tỉnh/Thành phố'),
('7082cbdf7c0b2bc8b0659274e7de982f', 'Tin đăng', NULL, 'Tin đăng'),
('f15f0b14795cd3689aeab772f8149dcb', 'Hàng sách tay', NULL, 'Hàng sách tay'),
('038a228d40865ae897c58d41bb9bdaf1', 'Hàng khuyến mại', NULL, 'Hàng khuyến mại'),
('6c629d607cbaf6fd80d70931f863b802', 'tin quan trọng', NULL, 'tin quan trọng'),
('d0faf7214e01dce7713e184743665e6f', 'Hàng độc', NULL, 'Hàng độc'),
('c0a50ba1b00d76f93f80de5f902f89dd', 'Hàng giá rẻ', NULL, 'Hàng giá rẻ'),
('dfa85ac3ac4f828265e0753958a88c3d', ' Ngày sửa ', NULL, ' Ngày sửa '),
('52ff6349a8a65e052c361354f78a6d74', 'Loại tin đăng', NULL, 'Loại tin đăng'),
('7773a4f59a9ee8a671347584cd8bcf89', 'loại tin đăng', NULL, 'loại tin đăng'),
('eadd8eafc98af58c6c7a6f032fe1a8a3', 'Please_select_modules!', NULL, 'Please_select_modules!'),
('4673be2c5ba93eea6072cc4553945801', 'Tin rao vặt', NULL, 'Tin rao vặt'),
('68afa9268ee0f565f1cdd9b8b1f5b5a6', 'Ngày tạo', NULL, 'Ngày tạo'),
('a584d37807281b7255f091a4065fc451', 'Ngày hết hạn', NULL, 'Ngày hết hạn'),
('5b5c80e938ea3c40223e29f23b7a74da', 'Quận huyện', NULL, 'Quận huyện'),
('2c62fe4689fffcc9fd45eb5686bc123d', 'Classifields listing', NULL, 'Classifields listing'),
('86ae2259a5375a1cec8e0a79f1559658', 'Thêm mới luật', NULL, 'Thêm mới luật'),
('b1656e5ba0197c559a8db5fa3adb0654', 'Nhà tuyển dụng', NULL, 'Nhà tuyển dụng'),
('f9150744e80fefac3df99989fac36235', 'Ứng viên', NULL, 'Ứng viên'),
('43c80153329dcfde25e9e78d6449bf8f', 'Forum Listing', NULL, 'Forum Listing'),
('e6b391a8d2c4d45902a23a8b6585703d', 'URL', NULL, 'URL'),
('15bbb9d0bbf25e8d2978de1168c749dc', 'Website', NULL, 'Website');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE IF NOT EXISTS `admin_user` (
  `adm_id` int(11) NOT NULL AUTO_INCREMENT,
  `adm_loginname` varchar(100) DEFAULT NULL,
  `adm_password` varchar(100) DEFAULT NULL,
  `adm_name` varchar(255) DEFAULT NULL,
  `adm_email` varchar(255) DEFAULT NULL,
  `adm_address` varchar(255) DEFAULT NULL,
  `adm_phone` varchar(255) DEFAULT NULL,
  `adm_mobile` varchar(255) DEFAULT NULL,
  `adm_access_module` varchar(255) DEFAULT NULL,
  `adm_access_category` text,
  `adm_date` int(11) DEFAULT '0',
  `adm_isadmin` tinyint(1) DEFAULT '0',
  `adm_active` tinyint(1) DEFAULT '1',
  `lang_id` tinyint(1) DEFAULT '1',
  `adm_delete` int(11) DEFAULT '0',
  `adm_all_category` int(1) DEFAULT NULL,
  `adm_edit_all` int(1) DEFAULT '0',
  `admin_id` int(1) DEFAULT '0',
  PRIMARY KEY (`adm_id`),
  KEY `adm_date` (`adm_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=63 ;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`adm_id`, `adm_loginname`, `adm_password`, `adm_name`, `adm_email`, `adm_address`, `adm_phone`, `adm_mobile`, `adm_access_module`, `adm_access_category`, `adm_date`, `adm_isadmin`, `adm_active`, `lang_id`, `adm_delete`, `adm_all_category`, `adm_edit_all`, `admin_id`) VALUES
(1, 'admin', 'c93ccd78b2076528346216b3b2f701e6', 'Phạm Mạnh Hùng', 'tiendungftu91@gmail.com', '35A - Nguyễn Tuân - Thanh Xuân Trung - Thanh Xuân - Hà Nội', '01678481197', '01678481197', NULL, NULL, 0, 1, 1, 1, 0, NULL, 0, 0),
(62, 'dunglm', 'e10adc3949ba59abbe56e057f20f883e', 'Le Minh Dzung', 'dunglm@gmail.com', NULL, '000000000', NULL, NULL, '', 0, 0, 1, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_category`
--

CREATE TABLE IF NOT EXISTS `admin_user_category` (
  `auc_admin_id` int(11) NOT NULL DEFAULT '0',
  `auc_category_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_language`
--

CREATE TABLE IF NOT EXISTS `admin_user_language` (
  `aul_admin_id` int(11) NOT NULL DEFAULT '0',
  `aul_lang_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aul_admin_id`,`aul_lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user_language`
--

INSERT INTO `admin_user_language` (`aul_admin_id`, `aul_lang_id`) VALUES
(62, 1),
(62, 2);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_right`
--

CREATE TABLE IF NOT EXISTS `admin_user_right` (
  `adu_admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `adu_admin_module_id` int(11) NOT NULL DEFAULT '0',
  `adu_add` int(1) DEFAULT '0',
  `adu_edit` int(1) DEFAULT '0',
  `adu_delete` int(1) DEFAULT '0',
  PRIMARY KEY (`adu_admin_id`,`adu_admin_module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `admin_user_right`
--

INSERT INTO `admin_user_right` (`adu_admin_id`, `adu_admin_module_id`, `adu_add`, `adu_edit`, `adu_delete`) VALUES
(62, 3, 1, 1, 1),
(62, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories_multi`
--

CREATE TABLE IF NOT EXISTS `categories_multi` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_order` int(5) DEFAULT NULL,
  `cat_picture` varchar(255) DEFAULT NULL,
  `cat_description` text,
  `cat_active` int(1) DEFAULT '1',
  `lang_id` int(1) DEFAULT '1',
  `cat_group_id` int(11) NOT NULL COMMENT '1- Khóa học tiếng anh ; 2 - Khóa học luyện thi',
  `cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `cat_has_child` int(11) NOT NULL DEFAULT '1',
  `cat_type` varchar(100) DEFAULT NULL,
  `admin_id` int(11) DEFAULT '1',
  `cat_channel` tinyint(4) DEFAULT '1',
  `cat_share_link` tinyint(1) DEFAULT '0',
  `cat_download_link` tinyint(1) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_channel` (`cat_channel`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `categories_multi`
--

INSERT INTO `categories_multi` (`cat_id`, `cat_name`, `cat_order`, `cat_picture`, `cat_description`, `cat_active`, `lang_id`, `cat_group_id`, `cat_parent_id`, `cat_has_child`, `cat_type`, `admin_id`, `cat_channel`, `cat_share_link`, `cat_download_link`, `title`, `keywords`, `description`) VALUES
(1, 'KHOÁ HỌC PHONG THUỶ', 1, NULL, '<p>Hầu hết mọi người sinh ra đều muốn c&oacute; một cuộc sống sung sướng, an b&igrave;nh v&agrave; hạnh Ph&uacute;c. Một số người lu&ocirc;n gặp thuận lợi tr&ecirc;n bước đường c&ocirc;ng danh v&agrave; thụ hưởng một cuộc sống v&ocirc; c&ugrave;ng sung Sướng. Một số kh&aacute;c tuy kết quả học tập rất kh&aacute;, l&agrave;m việc miệt m&agrave;i nhưng cũng dừng ở mức trung lưu. Lại c&oacute; nhiều người quanh năm vất vả xoay chuyển đủ nghề m&agrave; ngh&egrave;o vẫn ho&agrave;n ngh&egrave;o. Thời đại ng&agrave;y nay nhịp sống v&ocirc; c&ugrave;ng s&ocirc;i động, sự ph&acirc;n cấp gi&agrave;u ngh&egrave;o ng&agrave;y c&agrave;ng nhanh v&agrave; r&otilde; rệt &ldquo;Kẻ ăn chăng, hết người lần kh&ocirc;ng ra" người ta tư hỏi kh&ocirc;ng hiểu v&igrave; sao c&oacute; những kh&aacute;c biệt như vậy. Phải chăng l&agrave; do s&ocirc; phận ? C&oacute; &yacute; kiến cho rằng t&iacute;nh c&aacute;ch tạo n&ecirc;n số phận. Người xưa đ&atilde; n&oacute;i "Cha mẹ sinh con trời sinh t&iacute;nh &rdquo;Vậy n&ecirc;n ngo&agrave;i việc học tập c&ocirc;ng t&aacute;c v&agrave; ứng xử ta c&ograve;n cần r&egrave;n luyện t&iacute;nh c&aacute;ch.</p>\r\n<p>Người ngh&egrave;o lu&ocirc;n lu&ocirc;n t&igrave;m c&aacute;ch cải thiện cuộc sống của m&igrave;nh. c&ograve;n kẻ gi&agrave;u lại muốn gi&agrave;u th&ecirc;m. Trong bước đường sự nghiệp thường gặp kh&ocirc;ng &iacute;t những trắc trở kh&oacute; lường nhiều khi kh&oacute; hiểu. Người ta đi t&igrave;m hiểu v&agrave; &aacute;p dụng những kinh nghiệm trong phong tục d&acirc;n gian nhằm l&agrave;m cho c&ocirc;ng việc su&ocirc;n sẻ hơn. C&oacute; nhiều người sau khi chuyển sang một c&ocirc;ng việc kh&aacute;c th&igrave; gặt h&aacute;i được nhiều th&agrave;nh c&ocirc;ng; C&oacute; những gia đ&igrave;nh sau khi chuyển đến ng&ocirc;i nh&agrave; mới th&igrave; việc l&agrave;m ăn gặp nhiều thuận lợi, cuộc s&ocirc;ng chẳng mấy chốc khấm kh&aacute; hẳn l&ecirc;n. Mặc d&ugrave; chủ nh&agrave; trước đ&oacute; rất ngh&egrave;o. kh&oacute;; C&oacute; những gia đ&igrave;nh nhiều năm kh&aacute; giả nhưng đến đời con ch&aacute;u lại kh&ocirc;n kh&oacute; v&ocirc; c&ugrave;ng. Nhiều &yacute; kiến cho rằng người ở tr&ecirc;n đất c&oacute; hợp hay kh&ocirc;ng. Trong sử s&aacute;ch viết rằng c&oacute; những v&ugrave;ng đất m&agrave; ở đ&oacute; sản sinh ra nhiều danh nh&acirc;n kiệt xuất, lại c&oacute; nhiều v&ugrave;ng tuy l&agrave;m lụng vất vả nhưng cuộc s&ocirc;ng vẫn kh&oacute; khăn.</p>\r\n<p>C&oacute; một c&acirc;u chuyện sau đ&acirc;y: L&agrave;ng H&agrave; Ph&uacute; - Thuỷ Nguy&ecirc;n - Hải Ph&ograve;ng theo thần phả l&agrave; một v&ugrave;ng đất tr&ugrave; ph&uacute;, sơn thuỷ hữu t&igrave;nh, tr&ecirc;n bến dưới thuyền tấp nập; Cuộc sống của cư d&acirc;n sung t&uacute;c, hội h&egrave; đ&igrave;nh đ&aacute;m nhộn nhịp. V&agrave;o cuối thập kỷ 60 thế kỷ trước. D&ograve;ng s&ocirc;ng Gi&aacute; được ngăn lại (ngăn mặn) đ&ecirc; lấy nước ngọt tưới ti&ecirc;u cho v&ugrave;ng đồng ruộng rộng lớn. Việc l&agrave;m n&agrave;y đ&atilde; mang lại lợi &iacute;ch kh&ocirc;ng nhỏ cho c&aacute;c l&agrave;ng x&atilde; hai b&ecirc;n bờ s&ocirc;ng trong việc ph&aacute;t triển n&ocirc;ng nghiệp v&agrave; nu&ocirc;i trồng thuỷ sản. Nhưng l&agrave;ng H&agrave; Ph&uacute; do mất ưu thế về giao th&ocirc;ng thuỷ n&ecirc;n đời sống của cư d&acirc;n trở n&ecirc;n kh&oacute; khăn, t&uacute;ng thiếu. C&oacute; một điều lạ l&agrave; một số người l&agrave;m ăn ph&aacute;t đạt th&igrave; lại bị c&aacute;c bệnh nan y m&agrave; chết.</p>\r\n<p>Mọi việc d&ugrave; kh&oacute; khăn đến mấy con người đều c&oacute; thể phấn đấu vượt qua. C&ograve;n những điều b&iacute; ẩn cần phải nghi&ecirc;n cứu t&igrave;m lời giải đ&aacute;p để cho cuộc sống ng&agrave;y một tốt đẹp hơn.</p>\r\n<p>Tam Nguy&ecirc;n&nbsp;<em>st</em></p>', 1, 1, 0, 0, 1, '1', 1, 1, 0, 0, '', '', ''),
(2, 'KHOÁ HỌC TỬ VI', 2, NULL, '<p>Tử Vi L&yacute; Số l&agrave; một trong c&aacute;c m&ocirc;n giải đo&aacute;n về vận mệnh của con người, như: B&aacute;t Tự H&agrave; Lạc, Tử Vi L&yacute; Số, Tứ Trụ Tử B&igrave;nh, Kỳ M&ocirc;n Độn Gi&aacute;p, Th&aacute;i Ất, Lục Nh&acirc;m Đại Độn...<br />Mỗi trường ph&aacute;i c&oacute; cơ sở l&yacute; luận ri&ecirc;ng, dựa v&agrave;o c&aacute;c l&yacute; thuyết ri&ecirc;ng của m&igrave;nh, nhưng c&oacute; đặc điểm chung l&agrave; đều được t&iacute;ch lũy v&agrave; ph&aacute;t triển theo thời gian, c&aacute;c cơ sở của n&oacute; được chi&ecirc;m nghiệm v&agrave; đ&aacute;nh gi&aacute; c&oacute; t&iacute;nh thực tế, n&ecirc;n đ&atilde; ph&aacute;t triển v&agrave; được y&ecirc;u th&iacute;ch kh&ocirc;ng chỉ ở c&aacute;c nước &Aacute; Đ&ocirc;ng m&agrave; c&ograve;n tr&ecirc;n to&agrave;n thế giới.</p>', 1, 1, 0, 0, 1, '1', 1, 1, 0, 0, '', '', ''),
(5, 'KHOÁ HỌC KINH DỊCH', 4, NULL, '', 1, 1, 0, 0, 1, '1', 1, 1, 0, 0, '', '', ''),
(6, 'KHOÁ HỌC KỲ MÔN ĐỘN GIÁP', 5, NULL, '', 1, 1, 0, 0, 1, '1', 1, 1, 0, 0, '', '', ''),
(7, 'KHOÁ HỌC TƯỚNG SỐ', 6, NULL, '', 1, 1, 0, 0, 1, '1', 1, 1, 0, 0, '', '', ''),
(8, 'TÀI LIỆU PHONG THUỶ', 1, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(9, 'TÀI LIỆU TỬ VI', 2, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(10, 'TÀI LIỆU TỨ TRỤ', 3, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(11, 'TÀI LIỆU KỲ MÔN ĐỘN GIÁP', 4, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(12, 'TÀI LIỆU LỤC NHÂM', 5, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(13, 'TÀI LIỆU KINH DỊCH', 6, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(14, 'TÀI LIỆU TƯỚNG SỐ', 7, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(15, 'TÀI LIỆU CHỈ TAY', 8, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(16, 'TÀI LIỆU CÚNG BÁI', 9, NULL, '', 1, 1, 0, 0, 1, '2', 1, 1, 0, 0, NULL, NULL, NULL),
(4, 'KHOÁ HỌC TỨ TRỤ', 3, NULL, '<p>Tứ Trụ Tử B&igrave;nh l&agrave; một trong c&aacute;c m&ocirc;n giải đo&aacute;n về vận mệnh của con người, như: B&aacute;t Tự H&agrave; Lạc, Tử Vi L&yacute; Số, Tứ Trụ Tử B&igrave;nh, Kỳ M&ocirc;n Độn Gi&aacute;p, Th&aacute;i Ất, Lục Nh&acirc;m Đại Độn...<br />Mỗi trường ph&aacute;i c&oacute; cơ sở l&yacute; luận ri&ecirc;ng, dựa v&agrave;o c&aacute;c l&yacute; thuyết ri&ecirc;ng của m&igrave;nh, nhưng c&oacute; đặc điểm chung l&agrave; đều được t&iacute;ch lũy v&agrave; ph&aacute;t triển theo thời gian, c&aacute;c cơ sở của n&oacute; được chi&ecirc;m nghiệm v&agrave; đ&aacute;nh gi&aacute; c&oacute; t&iacute;nh thực tế, n&ecirc;n đ&atilde; ph&aacute;t triển v&agrave; được y&ecirc;u th&iacute;ch kh&ocirc;ng chỉ ở c&aacute;c nước &Aacute; Đ&ocirc;ng m&agrave; c&ograve;n tr&ecirc;n to&agrave;n thế giới.</p>', 1, 1, 0, 0, 1, '1', 1, 1, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `class_university_code` varchar(255) DEFAULT NULL,
  `class_user_created` int(11) DEFAULT '0',
  `class_time_created` int(11) DEFAULT '0',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_user`
--

CREATE TABLE IF NOT EXISTS `class_user` (
  `class_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_user_class_id` int(11) DEFAULT '0',
  `class_user_uid` int(11) DEFAULT '0',
  `class_user_created` int(11) DEFAULT '0',
  PRIMARY KEY (`class_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_user_id` int(11) DEFAULT NULL,
  `com_post_id` int(11) DEFAULT NULL,
  `com_content` text COLLATE utf8_unicode_ci,
  `com_date` int(11) DEFAULT NULL,
  `com_type` int(11) DEFAULT NULL COMMENT '1: cm dien dan,2: cm bai hoc,3: cm ki nang, 4: cm listing',
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments_reply`
--

CREATE TABLE IF NOT EXISTS `comments_reply` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_user_id` int(11) DEFAULT NULL,
  `rep_comment_id` int(11) DEFAULT NULL,
  `rep_content` text COLLATE utf8_unicode_ci,
  `rep_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments_reply_support`
--

CREATE TABLE IF NOT EXISTS `comments_reply_support` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_user_id` int(11) DEFAULT NULL,
  `rep_comment_id` int(11) DEFAULT NULL,
  `rep_content` text COLLATE utf8_unicode_ci,
  `rep_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments_support`
--

CREATE TABLE IF NOT EXISTS `comments_support` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_user_id` int(11) DEFAULT NULL,
  `com_post_id` int(11) DEFAULT NULL,
  `com_content` text COLLATE utf8_unicode_ci,
  `com_date` int(11) DEFAULT NULL,
  `com_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'dasdsadsa',
  `con_page_size` varchar(10) DEFAULT NULL,
  `con_left_size` varchar(10) DEFAULT NULL,
  `con_right_size` varchar(10) DEFAULT NULL,
  `con_admin_email` varchar(255) DEFAULT NULL,
  `con_site_title` varchar(255) DEFAULT NULL,
  `con_meta_description` text,
  `con_meta_keywords` text,
  `con_currency` varchar(20) DEFAULT NULL,
  `con_exchange` double DEFAULT '0',
  `con_mod_rewrite` tinyint(1) DEFAULT '0',
  `con_lang_id` int(11) DEFAULT '1',
  `con_extenstion` varchar(20) DEFAULT 'html',
  `con_support_online` text,
  `lang_id` int(11) DEFAULT '1',
  `con_list_currency` varchar(255) DEFAULT 'USD',
  `con_product_page` int(11) DEFAULT '10',
  `con_gmail_name` varchar(255) DEFAULT NULL,
  `con_gmail_pass` varchar(255) DEFAULT NULL,
  `con_gmail_subject` varchar(255) DEFAULT NULL,
  `con_filename` varchar(255) DEFAULT NULL,
  `con_news_page` int(11) DEFAULT '0',
  PRIMARY KEY (`con_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=3 ;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`con_id`, `con_page_size`, `con_left_size`, `con_right_size`, `con_admin_email`, `con_site_title`, `con_meta_description`, `con_meta_keywords`, `con_currency`, `con_exchange`, `con_mod_rewrite`, `con_lang_id`, `con_extenstion`, `con_support_online`, `lang_id`, `con_list_currency`, `con_product_page`, `con_gmail_name`, `con_gmail_pass`, `con_gmail_subject`, `con_filename`, `con_news_page`) VALUES
(1, '1133', '215', '230', 'dinhtoan1905@gmail.com', 'Học tiếng Anh Online, tiếng Anh giao tiếp, thi TOEIC, IELTS, TOEFL', 'Học tiếng Anh Online, Tiếng Anh giao tiếp, luyện thi TOEFL, IELTS, TOEIC, kỹ năng Tiếng Anh, Tiếng Anh phổ thông, tiếng anh văn phòng, tiếng Anh trẻ em', 'Học tiếng Anh online, khóa học tiếng Anh, luyện thi TOEIC, IELTS, TOEFL, Ngữ pháp tiếng Anh, Từ vựng tiếng Anh, CLB tiếng Anh', 'VND', 1, 1, 1, 'html', 'Kinh doanh online,dinhtoan1905,dinhtoan1905, 0936 863 638,dinhtoan1905@gmail.com;Kinh doanh online,dinhtoan1905,dinhtoan1905, 0936 863 638,dinhtoan1905@gmail.com;Kinh doanh online,dinhtoan1905,dinhtoan1905, 0936 863 638,dinhtoan1905@gmail.com', 1, 'USD,EUR,GBP', 40, '', '', '', '', 20);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `cou_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_cat_id` int(11) NOT NULL,
  `cou_cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `cou_name` varchar(255) NOT NULL,
  `cou_info` text,
  `cou_time` varchar(255) DEFAULT NULL,
  `cou_avatar` varchar(255) DEFAULT NULL,
  `cou_active` tinyint(4) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cou_order` int(11) NOT NULL DEFAULT '0',
  `cou_condition` text NOT NULL,
  `cou_goal` text NOT NULL,
  `cou_object` text NOT NULL,
  `cou_intro` text NOT NULL,
  `cou_tags` varchar(255) DEFAULT NULL,
  `cou_price` int(11) NOT NULL DEFAULT '0',
  `cou_day` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cou_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`cou_id`, `cou_cat_id`, `cou_cat_parent_id`, `cou_name`, `cou_info`, `cou_time`, `cou_avatar`, `cou_active`, `title`, `keywords`, `description`, `cou_order`, `cou_condition`, `cou_goal`, `cou_object`, `cou_intro`, `cou_tags`, `cou_price`, `cou_day`) VALUES
(2, 1, 1, 'PHONG THUỶ ỨNG DỤNG TRONG ĐỜI SỐNG VÀ KINH DOANH', 'Bạn gặp vấn đề  về việc chọn người để hợp tác, hùn hạp làm ăn? Bạn cảm thấy lúng túng khi chọn người phù hợp để làm việc cho mình? Bạn cảm thấy bối rối không biết người ấy có thích hợp để cùng nhau chung sống trọn đời?  Vậy thì đây chính là khóa học dành cho bạn!\r\n\r\n\r\nKhóa học phong thủy ứng dụng trước hết sẽ cung cấp cho bạn những kiến thức cơ bản nhất về âm dương, ngũ hành và cách áp dụng những kiến thức quý giá này vào cuộc sống. Bạn cũng sẽ nhận ra phong thủy không hề mê tín mà có căn cứ khoa học đàng hoàng, âm dương chính là tiền đề của bộ môn Văn hóa phương Đông - một bộ môn khoa học lâu đời và có tính ứng dụng trên rất nhiều lĩnh vực khác nhau. Chính vì thế, vận dụng những hiểu biết về âm dương, ngũ hành vào cuộc sống sẽ giúp các bạn đoán biết tính cách người khác, biết cách tính tuổi để chọn người phù hợp với mình và tránh người tuổi xung, phân bổ nhân viên vào vị trí phù hợp, thậm chí là có thể tự tìm cách hóa giải xung khắc. Không chỉ vậy, học viên còn biết cách tối ưu hóa việc tính tuổi để tự tạo cho mình một đội nhóm vô địch, bằng cách tính tuổi quý nhân, tuổi thần tài, tuổi trạch mã, để làm tăng may mắn, tài lộc cho bàn thân và doanh nghiệp.\r\n\r\n\r\nĐồng hành cùng các bạn trong khóa học này là thầy Tam Nguyên, chuyên gia tư vấn phong thủy cao cấp, tổng thư ký hiệp hội phong thủy dịch học thế giới - Phân hội Việt Nam. Với hơn 15 năm nghiên cứu các bộ môn Văn hóa Phương Đông và tư vấn Phong Thủy, Thầy đã trực tiếp và gián tiếp tham gia tư vấn phong thủy các dự án trong và ngoài nước như: Tập đoàn Nam Cường, Tòa nhà Parkson, Dự án Mirax của Nga, Khu đô thị An Hưng, Công ty Luật Gia Phạm, Tập đoàn của Nhật, Tập Đoàn Bắc Phương, Seven.Am … cùng các Đình Chùa cổ lớn ở Miền bắc như Chùa Trăm Gian, Tổ Chùa Bổ Đà … Bằng bề dày kinh nghiệm và những kiến thức uyên thâm, thầy sẽ trực tiếp hướng dẫn cũng như có những chia sẻ quý báu với các bạn học viên trong khóa học này.\r\n\r\n\r\nCòn chần chừ gì nữa mà không đăng ký khóa học này ngay đi thôi.', '1488187103', 'zvp1488187103.png', 0, '', '', '', 0, 'Không gian yên tĩnh\r\n\r\nCó mạng internet\r\n\r\nCó laptop', 'Tự tìm các tuổi theo lộc mã quý nhân, tam hợp\r\n\r\nTự tìm được bạn đời hợp tuổi, hợp mệnh để phát vượng\r\n\r\nTự tìm kiếm lựa chọn được năm sinh con', 'Lãnh đạo doanh nghiệp xây dựng ekip cho mình\r\n\r\nTrưởng phó phòng xây dựng đội nhóm\r\n\r\nNhà đầu tư muốn tim người hợp tác\r\n\r\nCác bạn trẻ muốn tìm bạn đời', '', '', 299000, 0),
(3, 1, 1, 'XÂY DỰNG EKIP VÀ HOÁ GIẢI XUNG SÁT', 'Phong thuỷ là một triết lý, một nghệ thuật sắp đặt của người Trung Hoa cổ chuyên nghiên cứu sự ảnh hưởng của hướng gió, hướng khí, mạch nước đến đời sống, hoạ phúc của con người..Nhiều công ty đã áp dụng thuật phong thuỷ vào hoạt động kinh doanh và nhận thấy những tác dụng tích cực, rõ ràng nhất đó là tạo ra được một môi trường làm việc yên bình, thành công và sinh lời. Nếu bạn cũng muốn công việc kinh doanh của mình ngày một phát triển thì bạn nên quan tâm tới việc sử dụng Thuật phong thuỷ. Thật tuyệt vời khi bước vào cuộc hành trình tới thế giới diệu kỳ của “gió và nước”, biết cách sử dụng dòng chảy năng lượng để cải thiện bản thân và hoạt động kinh doanh.\r\n\r\nVới nhà lãnh đạo, có được kiến thức phong thuỷ sẽ giúp họ lựa chọn, bố trí, sắp xếp không gian làm việc của mình sao cho hợp lý nhất và nâng hiệu quả làm việc lên mức cao nhất. Khoá học “Bí quyết xây dựng ê kíp & sử dụng kiến thức phong thuỷ trong điều hành Doanh nghiệp” do PTI tổ chức sẽ giúp các nhà lãnh đạo có được điều này.', '1488187742', 'anv1488187742.jpg', 0, '', '', '', 0, 'Đã học khoá Phong thuỷ ứng dụng trong đời sống và kinh doanh\r\n\r\nKhông gian yên tĩnh\r\n\r\nCó mạng internet\r\n\r\nCó laptop\r\n', '– Khoá học sẽ trang bị cho bạn những bí quyết và kỹ năng cần có để có thể tìm kiếm và lựa chọn ê kíp trong ban điều hành;\r\n\r\n– Biết cách vận dụng các kiến thức phong thuỷ trong điều hành Doanh nghiệp.', '– Cấp lãnh đạo doanh nghiệp (HĐQT, HĐTV, Ban Tổng Giám đốc, Ban Giám đốc);\r\n\r\n– Đội ngũ quản lý của các Doanh nghiệp (Các Giám đốc chức năng, các Trưởng/Phó các Phòng/Ban/Bộ phận trong Doanh nghiệp).', '', '', 599000, 0),
(4, 1, 1, 'KHOÁ HỌC PHONG THUỶ KÍCH TÀI LỘC 2017', 'Phong Thuỷ trở nên nổi tiếng và được ứng dụng rộng rãi qua hàng nghìn năm nay, do khả năng hoá giải vận hạn, và đặc biệt là kích hoạt tài lộc cho con người và căn nhà.\r\n\r\nBỞI VÌ:\r\nĐất có vận đất, người có vận người, khí có vận khí.\r\nĐón được thiên khí mỗi năm tức là tận dụng được vận khí của đất trời để gia tăng tài lộc, sức khỏe, hạnh phúc thúc đẩy thành công trong cuộc sống, cũng như trên đường kinh doanh.\r\nVũ trụ luôn ban cho chúng ta những điều tốt lành và cả những điều xấu, nếu chúng ta biết tận dụng, kích hoạt đúng chỗ, đúng cách những điều tốt lành thì sẽ tăng cường tài lộc và chế hóa những điều xấu, xung sát kém may mắn.\r\n\r\nNăm 2017 - Đinh Dậu - Sự vận hành của VŨ TRỤ và các THIÊN TINH ảnh sẽ hưởng đến NHÀ CỬA và VẬN MỆNH của mỗi người: Có những vị trí thật tốt và có những vị trí thật xấu, có những vị trí đem lại tài lộc, công danh và cả những vị trí đem đến bệnh tật, thị phi, hao tài tốn của, nhân duyên kém may mắn ….\r\n\r\nChương trình này là CƠ HỘI để bất cứ ai – dù chưa có kiến thức về Phong Thuỷ – có thể nắm được những điều căn bản và vận dụng được Phong Thuỷ cho bản thân đơn giản nhất', '1488187869', 'qig1488187869.jpg', 0, '', '', '', 0, '- Không gian yên tĩnh\r\n\r\n- Thiết bị kết nối internet', '- Tự mình kích hoạt được tài lộc cho nhà cửa, văn phòng công ty, cửa hàng, nhà máy... để chiêu tài lộc, chế sát.\r\n\r\n- Nắm được vận hạn của bản thân mình trong năm Đinh Dậu 2017 để có kế hoạch phù hợp cho công việc và sự nghiệp.\r\n\r\n- Nắm được thủ tục chính xác cách thực hiện 12 kỳ tết lễ (lễ tạ Thần, lễ giao thừa, tết nguyên tiêu...) của năm Đinh Dậu.\r\n\r\n- Nắm được năm nay hướng nhà nào vượng, hướng nhà nào có thể xây dựng mới, khu vực nào trong nhà có thể sửa chữa.', '- Dành cho mọi lứa tuổi, những người yêu và thích tìm hiểu về phong thủy\r\n\r\nĐặc biệt dành cho những người lãnh đạo doanh nghiệp, làm ăn, kinh doanh muốn nắm bắt được vận hạn và kích hoạt tài lộc trong năm Đinh Dậu.', '', '', 699000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi`
--

CREATE TABLE IF NOT EXISTS `courses_multi` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_cou_id` int(11) NOT NULL,
  `com_name` varchar(255) NOT NULL,
  `com_num_unit` int(11) NOT NULL,
  `com_image` varchar(255) DEFAULT NULL,
  `com_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `courses_multi`
--

INSERT INTO `courses_multi` (`com_id`, `com_cou_id`, `com_name`, `com_num_unit`, `com_image`, `com_active`) VALUES
(1, 2, 'Bài số 1 Giới thiệu khóa học', 1, 'vli1488189832.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tabs`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tabs` (
  `cou_tab_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_tab_com_id` int(11) DEFAULT NULL,
  `cou_tab_name` varchar(255) DEFAULT NULL,
  `cou_tab_order` int(11) DEFAULT '0',
  PRIMARY KEY (`cou_tab_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `courses_multi_tabs`
--

INSERT INTO `courses_multi_tabs` (`cou_tab_id`, `cou_tab_com_id`, `cou_tab_name`, `cou_tab_order`) VALUES
(1, 1, 'Video', 0),
(2, 1, 'Tài liệu', 0),
(4, 2, 'Bài số 4 Tính tương đối của Âm Dương', 0),
(5, 2, 'Bài số 5 Tính phổ biến của Âm Dương', 0),
(21, 4, 'Bài số 14 Ngũ hành Kim', 0),
(20, 4, 'Bài số 13 Khái niệm ngũ hành', 0),
(19, 3, 'Bài số 12 Tính chuyển hóa của Âm Dương', 0),
(16, 3, 'Bài số 9 Tính đối lập của Âm Dương', 0),
(17, 3, 'Bài số 10 Tính hỗ căn của Âm Dương', 0),
(18, 3, 'Bài số 11 Tính tiêu trưởng của Âm Dương', 0),
(13, 2, 'Bài số 7 Tính khả phân của Âm Dương', 0),
(14, 2, 'Bài số 8 Tính tương quan của Âm Dương', 0),
(22, 4, 'Bài số 15 Ngũ hành Mộc', 0),
(23, 4, 'Bài số 16 Ngũ hành Thủy', 0),
(24, 4, 'Bài số 17 Ngũ hành Hỏa', 0),
(25, 4, 'Bài số 18 Ngũ hành Thổ', 0),
(26, 5, 'Bài số 19 Ngũ hành tương sinh - tương khắc', 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tabs_block`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tabs_block` (
  `com_block_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_block_tab_id` int(11) DEFAULT NULL,
  `com_block_data_type` varchar(255) DEFAULT NULL COMMENT 'content_data ----- question_multiplechoice ----- question_matching ----- question_writing ----- question_recording ',
  `com_block_data_name` varchar(255) DEFAULT NULL,
  `com_block_data_order` int(11) DEFAULT '0',
  PRIMARY KEY (`com_block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tabs_content`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tabs_content` (
  `cou_tab_cont_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_tab_cont_tabs_id` int(11) NOT NULL,
  `cou_tab_cont_block_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 là mặc định chung ,parent',
  `cou_tab_cont_title` varchar(255) DEFAULT NULL,
  `cou_tab_cont_text` text,
  `cou_tab_cont_text_type` int(11) NOT NULL DEFAULT '1' COMMENT '1 - text ; 2- vocabulary',
  `cou_tab_cont_media` varchar(255) DEFAULT NULL COMMENT '1 - video 2 - audio; 3 - image',
  `cou_tab_cont_media_type` int(11) NOT NULL DEFAULT '0' COMMENT '1 - video 2 - audio; 3 - image',
  `cou_tab_cont_order` int(11) NOT NULL DEFAULT '1',
  `cou_tab_cont_active` tinyint(11) NOT NULL DEFAULT '1',
  `cou_tab_cont_for_question` int(11) NOT NULL DEFAULT '0',
  `cou_tab_cont_img_voca` varchar(255) DEFAULT NULL COMMENT 'Anh neu la tu vung',
  `cou_tab_cont_audio_voca` varchar(255) DEFAULT NULL,
  `cou_tab_cont_main_voca` varchar(255) DEFAULT NULL,
  `cou_tab_cont_phonetic_voca` varchar(255) DEFAULT NULL,
  `cou_tab_cont_exam_voca` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cou_tab_cont_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tab_answers`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tab_answers` (
  `cou_tab_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_tab_answer_question_id` int(11) NOT NULL DEFAULT '0',
  `cou_tab_answer_content` varchar(255) DEFAULT NULL,
  `cou_tab_answer_true` int(11) DEFAULT '0',
  PRIMARY KEY (`cou_tab_answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tab_media`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tab_media` (
  `cou_tab_media_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_tab_media_name` varchar(255) DEFAULT NULL,
  `cou_tab_media_url` varchar(255) DEFAULT NULL,
  `cou_tab_media_order` int(11) DEFAULT NULL,
  `cou_tab_media_unit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cou_tab_media_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `courses_multi_tab_media`
--

INSERT INTO `courses_multi_tab_media` (`cou_tab_media_id`, `cou_tab_media_name`, `cou_tab_media_url`, `cou_tab_media_order`, `cou_tab_media_unit_id`) VALUES
(4, 'Intro', 'eiz1488190821.flv', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tab_modules`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tab_modules` (
  `cou_tab_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_tab_module_tabs_id` int(11) DEFAULT NULL,
  `cou_tab_module_content_id` int(11) DEFAULT NULL,
  `cou_tab_module_content_type` int(11) DEFAULT '0' COMMENT '1 - content ; 2 - question',
  `cou_tab_module_content_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cou_tab_module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses_multi_tab_questions`
--

CREATE TABLE IF NOT EXISTS `courses_multi_tab_questions` (
  `cou_tab_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_tab_question_tabs_id` int(11) DEFAULT NULL,
  `cou_tab_question_block_id` int(11) DEFAULT NULL,
  `cou_tab_cont_content_id` int(11) DEFAULT '0',
  `cou_tab_question_title` varchar(255) DEFAULT NULL,
  `cou_tab_question_media` varchar(255) DEFAULT NULL,
  `cou_tab_question_media_type` int(11) DEFAULT '0',
  `cou_tab_question_paragraph` text,
  `cou_tab_question_content` text,
  `cou_tab_question_order` int(11) DEFAULT '0',
  `cou_tab_question_status` tinyint(4) DEFAULT '1',
  `cou_tab_question_type` varchar(255) DEFAULT '0' COMMENT '1 - multiplechoice ; 2 - matching ; 3 -draganddrop  ;4 - writing; 5 - recording ; ',
  PRIMARY KEY (`cou_tab_question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cover_letters`
--

CREATE TABLE IF NOT EXISTS `cover_letters` (
  `cv_id` int(11) NOT NULL AUTO_INCREMENT,
  `cv_cat_id` int(11) NOT NULL,
  `cv_cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `cv_name` varchar(255) NOT NULL,
  `cv_price` int(11) NOT NULL DEFAULT '5000',
  `cv_info` text,
  `cv_time` varchar(255) DEFAULT NULL,
  `cv_avatar` varchar(255) DEFAULT NULL,
  `cv_imgcontent` varchar(255) DEFAULT NULL,
  `cv_data` varchar(255) DEFAULT NULL,
  `cv_active` tinyint(4) NOT NULL,
  `cv_meta_title` varchar(255) NOT NULL,
  `cv_meta_keywords` varchar(255) NOT NULL,
  `cv_meta_description` varchar(255) NOT NULL,
  `cv_order` int(11) NOT NULL DEFAULT '0',
  `cv_language` int(11) DEFAULT '1' COMMENT '1 - vn ; 2 - en',
  `cv_downloads` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `cover_letters`
--

INSERT INTO `cover_letters` (`cv_id`, `cv_cat_id`, `cv_cat_parent_id`, `cv_name`, `cv_price`, `cv_info`, `cv_time`, `cv_avatar`, `cv_imgcontent`, `cv_data`, `cv_active`, `cv_meta_title`, `cv_meta_keywords`, `cv_meta_description`, `cv_order`, `cv_language`, `cv_downloads`) VALUES
(1, 8, 8, '500 Điều Kiêng Kỵ Trong Phong Thủy Trang Trí - Đàm Liên & Kim Phong', 10000, '', '1488365002', 'nyv1488282676.jpg', 'wxu1488282678.jpg', 'tum1488282678.pdf', 1, '500 Điều Kiêng Kỵ Trong Phong Thủy Trang Trí - Đàm Liên & Kim Phong', 'phong thuỷ, cấm kỵ', '500 Điều Kiêng Kỵ Trong Phong Thủy Trang Trí - Đàm Liên & Kim Phong', 0, 1, 0),
(2, 8, 8, 'Chọn Hướng Nhà Hướng Đất Theo Quan Niệm Cổ - Tôn Nhan', 10000, '', '1488283027', 'hrm1488283027.gif', 'nfo1488283027.gif', 'nty1488283027.pdf', 1, 'Chọn Hướng Nhà Hướng Đất Theo Quan Niệm Cổ - Tôn Nhan', 'Chọn Hướng Nhà Hướng Đất Theo Quan Niệm Cổ', 'Chọn Hướng Nhà Hướng Đất Theo Quan Niệm Cổ - Tôn Nhan', 0, 1, 0),
(3, 8, 8, 'Dã Đàm Tả Ao (Sài Gòn 1974) - Cao Trung', 10000, '', '1488284432', 'mgh1488284432.jpg', 'qkf1488284432.jpg', 'wpe1488284432.pdf', 1, 'Dã Đàm Tả Ao (Sài Gòn 1974) - Cao Trung', 'Dã Đàm Tả Ao (Sài Gòn 1974) - Cao Trung', 'Dã Đàm Tả Ao (Sài Gòn 1974) - Cao Trung', 0, 1, 0),
(4, 8, 8, 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Của Chiêm Mộng & Vu Thuật - Diêu Vĩnh Quân', 10000, '', '1488362282', 'drh1488362282.jpg', 'jph1488362282.jpg', 'ewa1488362282.pdf', 1, 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Của Chiêm Mộng & Vu Thuật - Diêu Vĩnh Quân', 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Của Chiêm Mộng & Vu Thuật - Diêu Vĩnh Quân, 633 Trang', 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Của Chiêm Mộng & Vu Thuật - Diêu Vĩnh Quân, 633 Trang', 0, 1, 0),
(5, 8, 8, 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Phong Thủy - Vương Ngọc Đức', 10000, '', '1488362501', 'dck1488362501.png', 'rby1488362501.png', 'feg1488362502.pdf', 1, 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Phong Thủy - Vương Ngọc Đức', 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Phong Thủy - Vương Ngọc Đức, 594 Trang', 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Phong Thủy - Vương Ngọc Đức, 594 Trang', 0, 1, 0),
(6, 8, 8, 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Tướng Thuật - Diêu Vĩ Quân', 10000, '', '1488362625', 'xyr1488362625.jpg', 'zul1488362625.jpg', 'kse1488362626.pdf', 1, 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Tướng Thuật - Diêu Vĩ Quân', 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Tướng Thuật - Diêu Vĩ Quân, 401 Trang', 'Đại Điển Tích Văn Hóa Trung Hoa-Bí Ẩn Tướng Thuật - Diêu Vĩ Quân, 401 Trang', 0, 1, 0),
(7, 8, 8, 'Đại Điển Tích Văn Hóa Trung Hoa-Quyền Mưu Thần Bí - Triệu Quốc Hoa, 428 Trang', 10000, '', '1488363759', 'gzn1488363759.png', 'vod1488363759.png', 'uwi1488363760.pdf', 1, 'Đại Điển Tích Văn Hóa Trung Hoa-Quyền Mưu Thần Bí - Triệu Quốc Hoa', 'Đại Điển Tích Văn Hóa Trung Hoa-Quyền Mưu Thần Bí - Triệu Quốc Hoa, 428 Trang', 'Đại Điển Tích Văn Hóa Trung Hoa-Quyền Mưu Thần Bí - Triệu Quốc Hoa, 428 Trang', 0, 1, 0),
(8, 8, 8, 'Đại Điển Tích Văn Hóa Trung Hoa-Trạch Cát Thần Bí (NXB Văn Hóa Thông Tin 2004) - Lưu Đạo Siêu & Chu Vĩnh Ích', 10000, '', '1488363893', 'nsz1488363893.jpg', 'byu1488363893.jpg', 'pnw1488363893.pdf', 1, 'Đại Điển Tích Văn Hóa Trung Hoa-Trạch Cát Thần Bí (NXB Văn Hóa Thông Tin 2004) - Lưu Đạo Siêu & Chu Vĩnh Ích', 'Đại Điển Tích Văn Hóa Trung Hoa-Trạch Cát Thần Bí (NXB Văn Hóa Thông Tin 2004) - Lưu Đạo Siêu & Chu Vĩnh Ích, 467 Trang', 'Đại Điển Tích Văn Hóa Trung Hoa-Trạch Cát Thần Bí (NXB Văn Hóa Thông Tin 2004) - Lưu Đạo Siêu & Chu Vĩnh Ích, 467 Trang', 0, 1, 0),
(9, 8, 8, 'Địa Lý Tả Ao Đại Đạo Diễn Ca - Cao Trung', 10000, '', '1488442718', 'upx1488442718.jpg', 'mqy1488442718.jpg', 'zef1488442718.pdf', 1, 'Địa Lý Toàn Thư Tập 1 (NXB Văn Hóa Thông Tin 1996) - Lưu Bá Ôn', 'Địa Lý Toàn Thư Tập 1 (NXB Văn Hóa Thông Tin 1996) - Lưu Bá Ôn, 386 Trang', 'Địa Lý Toàn Thư Tập 1 (NXB Văn Hóa Thông Tin 1996) - Lưu Bá Ôn, 386 Trang', 0, 1, 0),
(10, 8, 8, 'Địa Lý Toàn Thư Tập 2 - Lưu Bá Ôn', 10000, '', '1488443170', 'cfx1488443170.jpg', 'fnw1488443170.jpg', 'akr1488443170.pdf', 1, 'Địa Lý Toàn Thư Tập 2 (NXB Văn Hóa Thông Tin 1996) - Lưu Bá Ôn, 376 Trang', 'Địa Lý Toàn Thư Tập 2 (NXB Văn Hóa Thông Tin 1996) - Lưu Bá Ôn, 376 Trang', 'Địa Lý Toàn Thư Tập 2 (NXB Văn Hóa Thông Tin 1996) - Lưu Bá Ôn, 376 Trang', 0, 1, 0),
(11, 8, 8, 'Địa Lý Trị Soạn Phú - Cao Trung, 174 Trang', 10000, '', '1488443914', 'env1488443914.jpg', 'tna1488443914.jpg', 'tps1488443915.pdf', 1, 'Địa Lý Trị Soạn Phú - Cao Trung', 'Địa Lý Trị Soạn Phú - Cao Trung, 174 Trang', 'Địa Lý Trị Soạn Phú - Cao Trung, 174 Trang', 0, 1, 0),
(12, 8, 8, 'Hướng Gió, Mạch Nước, Thế Đất Trong Nghệ Thuật Kiến Trúc Xây Dựng Nhà Ở - Vương Ngọc Đức', 10000, '', '1488444204', 'vja1488444204.jpg', 'bee1488444205.jpg', 'zoy1488444205.pdf', 1, 'Hướng Gió, Mạch Nước, Thế Đất Trong Nghệ Thuật Kiến Trúc Xây Dựng Nhà Ở (NXB Văn Hóa Thông Tin 1996) - Vương Ngọc Đức, 576tr', 'Hướng Gió, Mạch Nước, Thế Đất Trong Nghệ Thuật Kiến Trúc Xây Dựng Nhà Ở (NXB Văn Hóa Thông Tin 1996) - Vương Ngọc Đức, 576tr', 'Hướng Gió, Mạch Nước, Thế Đất Trong Nghệ Thuật Kiến Trúc Xây Dựng Nhà Ở (NXB Văn Hóa Thông Tin 1996) - Vương Ngọc Đức, 576tr', 0, 1, 0),
(13, 8, 8, 'Kiến Trúc Phong Thủy Với Hoàng Đế Trạch Kinh - Hoàng Đế', 10000, '', '1488445149', 'nzd1488445149.gif', 'ioe1488445149.gif', NULL, 1, 'Kiến Trúc Phong Thủy Với Hoàng Đế Trạch Kinh (NXB Hà Nội) - Hoàng Đế', 'Kiến Trúc Phong Thủy Với Hoàng Đế Trạch Kinh (NXB Hà Nội) - Hoàng Đế, 351 Trang', 'Kiến Trúc Phong Thủy Với Hoàng Đế Trạch Kinh (NXB Hà Nội) - Hoàng Đế, 351 Trang', 0, 1, 0),
(14, 8, 8, 'La Bàn Phong Thủy - Trình Kiến Ngân', 10000, '', '1488619070', 'pgu1488619070.gif', 'ggk1488619070.gif', 'tal1488619070.pdf', 1, 'La Bàn Phong Thủy - Trình Kiến Ngân', 'La Bàn Phong Thủy - Trình Kiến Ngân, 200 Trang', 'La Bàn Phong Thủy - Trình Kiến Ngân, 200 Trang', 0, 1, 0),
(15, 8, 8, 'Nghệ Thuật Sử Dụng Màu Sắc Trong Cuộc Sống (NXB Văn Hóa Thông Tin 1999) - Đào Đăng Trạch Thiên', 10000, '', '1488619568', 'iur1488619568.png', 'eof1488619569.png', 'rdc1488619569.pdf', 1, 'Nghệ Thuật Sử Dụng Màu Sắc Trong Cuộc Sống (NXB Văn Hóa Thông Tin 1999) - Đào Đăng Trạch Thiên', 'Nghệ Thuật Sử Dụng Màu Sắc Trong Cuộc Sống (NXB Văn Hóa Thông Tin 1999) - Đào Đăng Trạch Thiên, 254 Trang', 'Nghệ Thuật Sử Dụng Màu Sắc Trong Cuộc Sống (NXB Văn Hóa Thông Tin 1999) - Đào Đăng Trạch Thiên, 254 Trang', 0, 1, 0),
(16, 8, 8, 'Nghi Lễ Dân Gian, Nghi Lễ Động Thổ - Minh Đường', 10000, '', '1488619697', 'oxe1488619697.png', 'fcg1488619698.png', 'gfj1488619700.pdf', 1, 'Nghi Lễ Dân Gian, Nghi Lễ Động Thổ (NXB Thời Đại 2010) - Minh Đường', 'Nghi Lễ Dân Gian, Nghi Lễ Động Thổ (NXB Thời Đại 2010) - Minh Đường, 176 Trang ', 'Nghi Lễ Dân Gian, Nghi Lễ Động Thổ (NXB Thời Đại 2010) - Minh Đường, 176 Trang ', 0, 1, 0),
(17, 8, 8, 'Nghi Lễ Dân Gian, Nhập Trạch Khai Trương (NXB Thời Đại 2010) - Minh Đường', 10000, '', '1488619807', 'feo1488619807.png', 'qpi1488619807.png', 'tbr1488619808.pdf', 1, 'Nghi Lễ Dân Gian, Nhập Trạch Khai Trương (NXB Thời Đại 2010) - Minh Đường', 'Nghi Lễ Dân Gian, Nhập Trạch Khai Trương (NXB Thời Đại 2010) - Minh Đường, 168 Trang', 'Nghi Lễ Dân Gian, Nhập Trạch Khai Trương (NXB Thời Đại 2010) - Minh Đường, 168 Trang', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `faq_answers`
--

CREATE TABLE IF NOT EXISTS `faq_answers` (
  `ans_id` int(11) NOT NULL AUTO_INCREMENT,
  `ans_user_id` int(11) DEFAULT NULL,
  `ans_question_id` int(11) DEFAULT NULL,
  `ans_content` text COLLATE utf8_unicode_ci,
  `ans_date` int(11) DEFAULT NULL,
  `ans_active` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`ans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faq_questions`
--

CREATE TABLE IF NOT EXISTS `faq_questions` (
  `que_id` int(11) NOT NULL AUTO_INCREMENT,
  `que_user_id` int(11) DEFAULT NULL,
  `que_tab_id` int(11) NOT NULL DEFAULT '0',
  `que_content` text COLLATE utf8_unicode_ci,
  `que_date` int(11) DEFAULT NULL,
  `que_active` tinyint(4) DEFAULT '0',
  `que_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'questions - thanks',
  PRIMARY KEY (`que_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `lang_id` int(11) NOT NULL DEFAULT '0',
  `lang_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_path` varchar(15) COLLATE utf8_unicode_ci DEFAULT 'home',
  `lang_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`lang_id`, `lang_name`, `lang_path`, `lang_image`, `lang_domain`) VALUES
(1, 'Tiếng việt', 'vn', NULL, NULL),
(2, 'English', 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `learn_speak_result`
--

CREATE TABLE IF NOT EXISTS `learn_speak_result` (
  `lsr_id` int(11) NOT NULL AUTO_INCREMENT,
  `lsr_use_id` int(11) NOT NULL,
  `lsr_spe_id` int(11) NOT NULL,
  `lsr_comment` text NOT NULL,
  `lsr_point` tinyint(2) NOT NULL,
  `lsr_audio` tinytext NOT NULL,
  `lsr_status` tinyint(1) NOT NULL,
  `lsr_date` varchar(255) NOT NULL,
  PRIMARY KEY (`lsr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `learn_writing_result`
--

CREATE TABLE IF NOT EXISTS `learn_writing_result` (
  `lwr_id` int(11) NOT NULL AUTO_INCREMENT,
  `lwr_use_id` int(11) NOT NULL,
  `lwr_wri_id` int(11) NOT NULL,
  `lwr_content` text NOT NULL,
  `lwr_point` tinyint(4) DEFAULT NULL,
  `lwr_comment` text,
  `lwr_status` int(11) NOT NULL DEFAULT '0',
  `lwr_date` int(11) NOT NULL,
  `lwr_smail` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`lwr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `listarm`
--

CREATE TABLE IF NOT EXISTS `listarm` (
  `listarm_id` int(11) NOT NULL AUTO_INCREMENT,
  `listarm_name` varchar(255) NOT NULL,
  `listarm_exp` int(11) NOT NULL,
  `listarm_img` varchar(255) NOT NULL,
  PRIMARY KEY (`listarm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `listexp`
--

CREATE TABLE IF NOT EXISTS `listexp` (
  `listexp_id` int(11) NOT NULL AUTO_INCREMENT,
  `listexp_des` varchar(255) NOT NULL,
  `listexp_code` varchar(255) NOT NULL,
  `listexp_exp` int(11) NOT NULL,
  `listexp_type` varchar(255) NOT NULL DEFAULT 'exp',
  PRIMARY KEY (`listexp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mesclass`
--

CREATE TABLE IF NOT EXISTS `mesclass` (
  `mesclass_id` int(11) NOT NULL AUTO_INCREMENT,
  `mesclass_class` int(11) NOT NULL DEFAULT '0',
  `mesclass_teacher` int(11) NOT NULL DEFAULT '0',
  `mesclass_content` text NOT NULL,
  `mesclass_date` int(11) NOT NULL,
  `mesclass_type` int(11) NOT NULL DEFAULT '0' COMMENT '0 - teacher ; 1 - admin ; 3-rieng',
  `mes_uid` int(11) NOT NULL,
  `mesclass_read` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mesclass_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(100) DEFAULT NULL,
  `mod_path` varchar(255) DEFAULT NULL,
  `mod_listname` varchar(100) DEFAULT NULL,
  `mod_listfile` varchar(100) DEFAULT NULL,
  `mod_order` int(11) DEFAULT '0',
  `mod_help` mediumtext,
  `lang_id` int(11) DEFAULT '1',
  `mod_checkloca` int(11) DEFAULT '0',
  PRIMARY KEY (`mod_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`mod_id`, `mod_name`, `mod_path`, `mod_listname`, `mod_listfile`, `mod_order`, `mod_help`, `lang_id`, `mod_checkloca`) VALUES
(1, 'Q.Lý Categories', 'categories_multi', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(3, 'Q.Lý Courses', 'courses', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(14, 'Q.Lý Members', 'members', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(15, 'Q.Lý Admin', 'admin_user', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(22, 'Q.Lý News Posts', 'posts', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(76, 'Q.Lý Cover Letters', 'cover_letters', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(77, 'Q.Lý Exp', 'exp', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(78, 'Q.Lý Huy Hiệu', 'arm', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(79, 'Gửi thông báo cho User', 'sendmes', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0),
(80, 'Q.Lý Slider & Ad', 'slides', 'Thêm mới|Danh sách', 'add.php|listing.php', 0, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_cat_id` int(11) NOT NULL,
  `post_cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `post_cat_related_id` int(11) NOT NULL DEFAULT '0',
  `post_title` varchar(255) NOT NULL,
  `post_description` varchar(255) DEFAULT NULL,
  `post_content` text NOT NULL,
  `post_picture` varchar(255) NOT NULL,
  `post_time` int(11) NOT NULL,
  `post_active` tinyint(4) NOT NULL,
  `post_meta_title` varchar(255) NOT NULL,
  `post_meta_description` varchar(255) NOT NULL,
  `post_meta_keywords` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scratch_cards`
--

CREATE TABLE IF NOT EXISTS `scratch_cards` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_code` varchar(255) DEFAULT NULL,
  `sc_seri` varchar(255) DEFAULT NULL,
  `sc_value` int(11) NOT NULL DEFAULT '0' COMMENT '30000 - 50000 - 100000',
  `sc_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE IF NOT EXISTS `slides` (
  `slide_id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_name` varchar(255) NOT NULL,
  `slide_content` text,
  `slide_content_invi` int(11) NOT NULL,
  `slide_url` varchar(255) DEFAULT NULL,
  `slide_img` varchar(255) DEFAULT NULL,
  `slide_button` varchar(255) DEFAULT NULL,
  `slide_link` varchar(255) DEFAULT NULL,
  `slide_order` int(11) NOT NULL DEFAULT '0',
  `slide_active` int(11) NOT NULL,
  `slide_type` int(11) NOT NULL DEFAULT '0',
  `slide_position` int(11) DEFAULT '0',
  PRIMARY KEY (`slide_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`slide_id`, `slide_name`, `slide_content`, `slide_content_invi`, `slide_url`, `slide_img`, `slide_button`, `slide_link`, `slide_order`, `slide_active`, `slide_type`, `slide_position`) VALUES
(1, 'Banner Slider 1', 'Nếu các bạn sinh viên lựa chọn giáo dục quốc tế để thực hiện mục tiêu học tập, công việc và cuộc sống của mình thì chúng tôi cam kết sẽ cùng bạn tìm thấy sự lựa chọn đúng đắn để đạt được những mục tiêu đó', 0, 'http://thuvienphongthuy.vn/', 'shw1487904387.jpg', '', NULL, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `use_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_active` int(11) DEFAULT '0',
  `use_login` varchar(100) DEFAULT NULL,
  `use_password` varchar(50) DEFAULT NULL,
  `use_birthdays` int(11) DEFAULT NULL,
  `use_gender` int(11) DEFAULT '0',
  `use_phone` varchar(20) DEFAULT NULL,
  `use_email` varchar(100) DEFAULT NULL,
  `use_address` varchar(255) DEFAULT NULL,
  `use_date` int(11) DEFAULT '0',
  `use_security` varchar(255) DEFAULT NULL,
  `use_name` varchar(255) DEFAULT NULL,
  `use_avatar` varchar(100) DEFAULT NULL,
  `use_openid` tinyint(4) NOT NULL DEFAULT '0',
  `use_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Status',
  `use_teacher` int(11) NOT NULL DEFAULT '0',
  `use_ex` int(11) NOT NULL DEFAULT '0',
  `user_wallet` int(11) NOT NULL DEFAULT '0',
  `user_admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`use_id`),
  UNIQUE KEY `use_email` (`use_email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_active`
--

CREATE TABLE IF NOT EXISTS `user_active` (
  `uactive_id` int(11) NOT NULL AUTO_INCREMENT,
  `uactive_user_id` int(11) DEFAULT '0',
  `uactive_start_date` int(11) DEFAULT '0',
  `uactive_end_date` int(11) DEFAULT '0',
  `uactive_active` int(11) DEFAULT '0',
  PRIMARY KEY (`uactive_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_log`
--

CREATE TABLE IF NOT EXISTS `user_activity_log` (
  `user_act_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_act_uid` int(11) NOT NULL,
  `user_act_des` text NOT NULL,
  `user_act_time` int(11) NOT NULL,
  `user_act_time_date` int(11) DEFAULT '0',
  PRIMARY KEY (`user_act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE IF NOT EXISTS `user_courses` (
  `uc_id` int(11) NOT NULL AUTO_INCREMENT,
  `uc_uid` int(11) NOT NULL,
  `uc_couid` int(11) NOT NULL DEFAULT '0',
  `uc_startdate` int(11) NOT NULL DEFAULT '0',
  `uc_enddate` int(11) NOT NULL DEFAULT '0',
  `uc_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE IF NOT EXISTS `user_logs` (
  `ulog_id` int(255) NOT NULL AUTO_INCREMENT,
  `ulog_user_id` int(255) NOT NULL,
  `ulog_course` int(255) NOT NULL,
  `ulog_date` int(255) NOT NULL,
  `ulog_comment` text NOT NULL,
  PRIMARY KEY (`ulog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_log`
--

CREATE TABLE IF NOT EXISTS `user_payment_log` (
  `upaylog_ui` int(11) NOT NULL AUTO_INCREMENT,
  `upaylog_user_id` int(11) DEFAULT '0',
  `upaylog_date` int(11) DEFAULT '0',
  `upaylog_money` int(11) DEFAULT '0',
  `upaylog_method` varchar(255) DEFAULT NULL,
  `upaylog_pin` int(11) DEFAULT '0',
  `upaylog_seri` int(11) DEFAULT '0',
  `upaylog_transaction_id` int(11) DEFAULT '0',
  `upaylog_bank` int(11) DEFAULT '0',
  `upaylog_info` text,
  `upaylog_info_description` text,
  PRIMARY KEY (`upaylog_ui`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_wallet`
--

CREATE TABLE IF NOT EXISTS `user_wallet` (
  `uw_id` int(11) NOT NULL AUTO_INCREMENT,
  `uw_user_id` int(11) NOT NULL,
  `uw_money` int(11) NOT NULL,
  PRIMARY KEY (`uw_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
