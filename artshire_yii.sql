-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2014 at 01:42 AM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `artshire_yii`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `value` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE IF NOT EXISTS `tbl_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) CHARACTER SET latin1 NOT NULL COMMENT 'ISO 3166-1 alpha-2',
  `name` varchar(64) CHARACTER SET latin1 NOT NULL COMMENT 'ISO 3166-1 official English short name (Gazetteer order, w/o diacritics)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=250 ;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` (`id`, `code`, `name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AX', 'Aland Islands'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AO', 'Angola'),
(8, 'AI', 'Anguilla'),
(9, 'AQ', 'Antarctica'),
(10, 'AG', 'Antigua and Barbuda'),
(11, 'AR', 'Argentina'),
(12, 'AM', 'Armenia'),
(13, 'AW', 'Aruba'),
(14, 'AU', 'Australia'),
(15, 'AT', 'Austria'),
(16, 'AZ', 'Azerbaijan'),
(17, 'BS', 'Bahamas'),
(18, 'BH', 'Bahrain'),
(19, 'BD', 'Bangladesh'),
(20, 'BB', 'Barbados'),
(21, 'BY', 'Belarus'),
(22, 'BE', 'Belgium'),
(23, 'BZ', 'Belize'),
(24, 'BJ', 'Benin'),
(25, 'BM', 'Bermuda'),
(26, 'BT', 'Bhutan'),
(27, 'BO', 'Bolivia, Plurinational State of'),
(28, 'BQ', 'Bonaire, Sint Eustatius and Saba'),
(29, 'BA', 'Bosnia and Herzegovina'),
(30, 'BW', 'Botswana'),
(31, 'BV', 'Bouvet Island'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'British Indian Ocean Territory'),
(34, 'BN', 'Brunei Darussalam'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Cambodia'),
(39, 'CM', 'Cameroon'),
(40, 'CA', 'Canada'),
(41, 'CV', 'Cape Verde'),
(42, 'KY', 'Cayman Islands'),
(43, 'CF', 'Central African Republic'),
(44, 'TD', 'Chad'),
(45, 'CL', 'Chile'),
(46, 'CN', 'China'),
(47, 'CX', 'Christmas Island'),
(48, 'CC', 'Cocos (Keeling) Islands'),
(49, 'CO', 'Colombia'),
(50, 'KM', 'Comoros'),
(51, 'CG', 'Congo'),
(52, 'CD', 'Congo, The Democratic Republic of the'),
(53, 'CK', 'Cook Islands'),
(54, 'CR', 'Costa Rica'),
(55, 'CI', 'Cote d''Ivoire'),
(56, 'HR', 'Croatia'),
(57, 'CU', 'Cuba'),
(58, 'CW', 'Curacao'),
(59, 'CY', 'Cyprus'),
(60, 'CZ', 'Czech Republic'),
(61, 'DK', 'Denmark'),
(62, 'DJ', 'Djibouti'),
(63, 'DM', 'Dominica'),
(64, 'DO', 'Dominican Republic'),
(65, 'EC', 'Ecuador'),
(66, 'EG', 'Egypt'),
(67, 'SV', 'El Salvador'),
(68, 'GQ', 'Equatorial Guinea'),
(69, 'ER', 'Eritrea'),
(70, 'EE', 'Estonia'),
(71, 'ET', 'Ethiopia'),
(72, 'FK', 'Falkland Islands (Malvinas)'),
(73, 'FO', 'Faroe Islands'),
(74, 'FJ', 'Fiji'),
(75, 'FI', 'Finland'),
(76, 'FR', 'France'),
(77, 'GF', 'French Guiana'),
(78, 'PF', 'French Polynesia'),
(79, 'TF', 'French Southern Territories'),
(80, 'GA', 'Gabon'),
(81, 'GM', 'Gambia'),
(82, 'GE', 'Georgia'),
(83, 'DE', 'Germany'),
(84, 'GH', 'Ghana'),
(85, 'GI', 'Gibraltar'),
(86, 'GR', 'Greece'),
(87, 'GL', 'Greenland'),
(88, 'GD', 'Grenada'),
(89, 'GP', 'Guadeloupe'),
(90, 'GU', 'Guam'),
(91, 'GT', 'Guatemala'),
(92, 'GG', 'Guernsey'),
(93, 'GN', 'Guinea'),
(94, 'GW', 'Guinea-Bissau'),
(95, 'GY', 'Guyana'),
(96, 'HT', 'Haiti'),
(97, 'HM', 'Heard Island and McDonald Islands'),
(98, 'VA', 'Holy See (Vatican City State)'),
(99, 'HN', 'Honduras'),
(100, 'HK', 'Hong Kong'),
(101, 'HU', 'Hungary'),
(102, 'IS', 'Iceland'),
(103, 'IN', 'India'),
(104, 'ID', 'Indonesia'),
(105, 'IR', 'Iran, Islamic Republic of'),
(106, 'IQ', 'Iraq'),
(107, 'IE', 'Ireland'),
(108, 'IM', 'Isle of Man'),
(109, 'IL', 'Israel'),
(110, 'IT', 'Italy'),
(111, 'JM', 'Jamaica'),
(112, 'JP', 'Japan'),
(113, 'JE', 'Jersey'),
(114, 'JO', 'Jordan'),
(115, 'KZ', 'Kazakhstan'),
(116, 'KE', 'Kenya'),
(117, 'KI', 'Kiribati'),
(118, 'KP', 'Korea, Democratic People''s Republic of'),
(119, 'KR', 'Korea, Republic of'),
(120, 'KW', 'Kuwait'),
(121, 'KG', 'Kyrgyzstan'),
(122, 'LA', 'Lao People''s Democratic Republic'),
(123, 'LV', 'Latvia'),
(124, 'LB', 'Lebanon'),
(125, 'LS', 'Lesotho'),
(126, 'LR', 'Liberia'),
(127, 'LY', 'Libyan Arab Jamahiriya'),
(128, 'LI', 'Liechtenstein'),
(129, 'LT', 'Lithuania'),
(130, 'LU', 'Luxembourg'),
(131, 'MO', 'Macao'),
(132, 'MK', 'Macedonia, The Former Yugoslav Republic of'),
(133, 'MG', 'Madagascar'),
(134, 'MW', 'Malawi'),
(135, 'MY', 'Malaysia'),
(136, 'MV', 'Maldives'),
(137, 'ML', 'Mali'),
(138, 'MT', 'Malta'),
(139, 'MH', 'Marshall Islands'),
(140, 'MQ', 'Martinique'),
(141, 'MR', 'Mauritania'),
(142, 'MU', 'Mauritius'),
(143, 'YT', 'Mayotte'),
(144, 'MX', 'Mexico'),
(145, 'FM', 'Micronesia, Federated States of'),
(146, 'MD', 'Moldova, Republic of'),
(147, 'MC', 'Monaco'),
(148, 'MN', 'Mongolia'),
(149, 'ME', 'Montenegro'),
(150, 'MS', 'Montserrat'),
(151, 'MA', 'Morocco'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NL', 'Netherlands'),
(158, 'NC', 'New Caledonia'),
(159, 'NZ', 'New Zealand'),
(160, 'NI', 'Nicaragua'),
(161, 'NE', 'Niger'),
(162, 'NG', 'Nigeria'),
(163, 'NU', 'Niue'),
(164, 'NF', 'Norfolk Island'),
(165, 'MP', 'Northern Mariana Islands'),
(166, 'NO', 'Norway'),
(167, 'PS', 'Occupied Palestinian Territory'),
(168, 'OM', 'Oman'),
(169, 'PK', 'Pakistan'),
(170, 'PW', 'Palau'),
(171, 'PA', 'Panama'),
(172, 'PG', 'Papua New Guinea'),
(173, 'PY', 'Paraguay'),
(174, 'PE', 'Peru'),
(175, 'PH', 'Philippines'),
(176, 'PN', 'Pitcairn'),
(177, 'PL', 'Poland'),
(178, 'PT', 'Portugal'),
(179, 'PR', 'Puerto Rico'),
(180, 'QA', 'Qatar'),
(181, 'RE', 'Reunion'),
(182, 'RO', 'Romania'),
(183, 'RU', 'Russian Federation'),
(184, 'RW', 'Rwanda'),
(185, 'BL', 'Saint Barthelemy'),
(186, 'SH', 'Saint Helena, Ascension and Tristan da Cunha'),
(187, 'KN', 'Saint Kitts and Nevis'),
(188, 'LC', 'Saint Lucia'),
(189, 'MF', 'Saint Martin (French part)'),
(190, 'PM', 'Saint Pierre and Miquelon'),
(191, 'VC', 'Saint Vincent and The Grenadines'),
(192, 'WS', 'Samoa'),
(193, 'SM', 'San Marino'),
(194, 'ST', 'Sao Tome and Principe'),
(195, 'SA', 'Saudi Arabia'),
(196, 'SN', 'Senegal'),
(197, 'RS', 'Serbia'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leone'),
(200, 'SG', 'Singapore'),
(201, 'SX', 'Sint Maarten (Dutch part)'),
(202, 'SK', 'Slovakia'),
(203, 'SI', 'Slovenia'),
(204, 'SB', 'Solomon Islands'),
(205, 'SO', 'Somalia'),
(206, 'ZA', 'South Africa'),
(207, 'GS', 'South Georgia and the South Sandwich Islands'),
(208, 'SS', 'South Sudan'),
(209, 'ES', 'Spain'),
(210, 'LK', 'Sri Lanka'),
(211, 'SD', 'Sudan'),
(212, 'SR', 'Suriname'),
(213, 'SJ', 'Svalbard and Jan Mayen'),
(214, 'SZ', 'Swaziland'),
(215, 'SE', 'Sweden'),
(216, 'CH', 'Switzerland'),
(217, 'SY', 'Syrian Arab Republic'),
(218, 'TW', 'Taiwan, Province of China'),
(219, 'TJ', 'Tajikistan'),
(220, 'TZ', 'Tanzania, United Republic of'),
(221, 'TH', 'Thailand'),
(222, 'TL', 'Timor-Leste'),
(223, 'TG', 'Togo'),
(224, 'TK', 'Tokelau'),
(225, 'TO', 'Tonga'),
(226, 'TT', 'Trinidad and Tobago'),
(227, 'TN', 'Tunisia'),
(228, 'TR', 'Turkey'),
(229, 'TM', 'Turkmenistan'),
(230, 'TC', 'Turks and Caicos Islands'),
(231, 'TV', 'Tuvalu'),
(232, 'UG', 'Uganda'),
(233, 'UA', 'Ukraine'),
(234, 'AE', 'United Arab Emirates'),
(235, 'GB', 'United Kingdom'),
(236, 'US', 'United States'),
(237, 'UM', 'United States Minor Outlying Islands'),
(238, 'UY', 'Uruguay'),
(239, 'UZ', 'Uzbekistan'),
(240, 'VU', 'Vanuatu'),
(241, 'VE', 'Venezuela, Bolivarian Republic of'),
(242, 'VN', 'Viet Nam'),
(243, 'VG', 'Virgin Islands, British'),
(244, 'VI', 'Virgin Islands, U.S.'),
(245, 'WF', 'Wallis and Futuna'),
(246, 'EH', 'Western Sahara'),
(247, 'YE', 'Yemen'),
(248, 'ZM', 'Zambia'),
(249, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE IF NOT EXISTS `tbl_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_key` varchar(30) NOT NULL,
  `img_serial` int(11) NOT NULL,
  `project_key` varchar(30) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `main_img` text NOT NULL,
  `cropped_img` varchar(40) NOT NULL,
  `thumb_image` varchar(100) DEFAULT NULL,
  `bg_img` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`id`, `img_key`, `img_serial`, `project_key`, `project_id`, `main_img`, `cropped_img`, `thumb_image`, `bg_img`, `created_at`, `updated_at`) VALUES
(1, '53AD672B14BEE27', 0, '53AB27EA9909102', 4, '1660513_706668229379029_5355503694442434837_n.jpg', '53AD672B1192327.jpg', NULL, 0, '2014-06-27 12:44:27', '2014-06-27 12:44:27'),
(2, '53AD67425BC9650', 0, '53AB27EA9909102', 4, '10449929_749009668499465_3837974750954709521_n.jpg', '53AD674259D6650.jpg', NULL, 0, '2014-06-27 12:44:50', '2014-06-27 12:44:50'),
(3, '53AD6747B527355', 0, '53AB27EA9909102', 4, '1012251_10202661555280577_1848055974_n.jpg', '53B710B60AAD714_309.3333333333333_174.jp', NULL, 0, '2014-06-27 12:44:55', '2014-07-04 20:38:14'),
(5, '53AD6CA93C12953', 0, '53AD6C810523113', 5, 'Desert.jpg', '53AD6CA92D6D053.jpg', NULL, 0, '2014-06-27 13:07:53', '2014-06-27 13:07:53'),
(6, '53AD6CB92E29C09', 0, '53AD6C810523113', 5, 'Chrysanthemum.jpg', '53AD6CB92BB8209.jpg', NULL, 0, '2014-06-27 13:08:09', '2014-06-27 13:08:09'),
(7, '53AD6CD5C588A37', 0, '53AD6C810523113', 5, 'Penguins.jpg', '53AD6CD5C21D837.jpg', NULL, 0, '2014-06-27 13:08:37', '2014-06-27 13:08:37'),
(8, '53AD6CFE382F018', 0, '53AD6C810523113', 5, 'Jellyfish.jpg', '53AD6CFE357E018.jpg', NULL, 0, '2014-06-27 13:09:18', '2014-06-27 13:09:18'),
(9, '53B2E9C7B5C4603', 0, '53B2E9B69CDCB46', 6, 'Special needs5.jpg', '53B2E9C7B3D0503.jpg', NULL, 0, '2014-07-01 17:03:03', '2014-07-01 17:03:03'),
(10, '53B2EA239129635', 0, '53B2E9B69CDCB46', 6, 'Scott Signature.png', '53B2EA238EF6535.png', NULL, 0, '2014-07-01 17:04:35', '2014-07-01 17:04:35'),
(11, '53B2EAB0219E656', 0, '53B2EA756116457', 7, 'Koala.jpg', '53B2EAB01F2BD56.jpg', NULL, 0, '2014-07-01 17:06:56', '2014-07-01 17:06:56'),
(12, '53B4249C9E0CE20', 0, '53B4248DE9BBA05', 8, 'medessist.jpg', '53B4249C9BDA720.jpg', NULL, 0, '2014-07-02 15:26:20', '2014-07-02 15:26:20'),
(13, '53B424A4A948228', 0, '53B4248DE9BBA05', 8, 'Special needs5.jpg', '53B424A4A3AAB28.jpg', NULL, 0, '2014-07-02 15:26:28', '2014-07-02 15:26:28'),
(14, '53B424AA3A5BE34', 0, '53B4248DE9BBA05', 8, 'Scott Signature.png', '53B424AA32DFD34.png', NULL, 1, '2014-07-02 15:26:34', '2014-07-02 15:31:20'),
(15, '53B4256641DEC42', 0, '53B425580B1D828', 9, 'Desert.jpg', '53B425663423142.jpg', NULL, 1, '2014-07-02 15:29:42', '2014-07-02 15:30:45'),
(16, '53B425B6A8D8202', 0, '53B425580B1D828', 9, 'Penguins.jpg', '53B425C36C10015_880_495.jpg', NULL, 0, '2014-07-02 15:31:02', '2014-07-02 15:31:15'),
(17, '53B425FCD25BE12', 0, '53B425580B1D828', 9, 'Jellyfish.jpg', '53B425FCA2C0F12.jpg', NULL, 0, '2014-07-02 15:32:12', '2014-07-02 15:32:12'),
(18, '53B44101E2D8529', 0, '53B43FA5727A541', 10, 'nic.jpg', '53B44101E0A5C29.jpg', NULL, 0, '2014-07-02 17:27:29', '2014-07-02 17:27:29'),
(19, '53B4412D217F213', 0, '53B43FA5727A541', 10, 'nic.jpg', '53B4412D1F0E113.jpg', NULL, 0, '2014-07-02 17:28:13', '2014-07-02 17:28:13'),
(20, '53B710A0D54F952', 0, '53AB27EA9909102', 4, '10259040_706667582712427_1724159170841413476_o.jpg', '53B710A0D2A0152.jpg', NULL, 1, '2014-07-04 20:37:52', '2014-07-04 20:37:52'),
(21, '53BC71B3D472723', 0, '53BC7178EBDFE24', 11, 'medessist.jpg', '53BC71B3C745423.jpg', NULL, 0, '2014-07-08 22:33:23', '2014-07-08 22:33:23'),
(22, '53BC71C195F2237', 0, '53BC7178EBDFE24', 11, 'Scott Signature.png', '53BC71C18F1B337.png', NULL, 0, '2014-07-08 22:33:37', '2014-07-08 22:33:37'),
(24, '53BC71D1D5AA653', 0, '53BC7178EBDFE24', 11, 'CrowdDeclare_Declare_001.png', '53BC71D1D2FAB53.png', NULL, 1, '2014-07-08 22:33:53', '2014-07-08 22:33:53'),
(25, '53BC727D9B1C245', 0, '53BC723790D7D35', 12, 'Penguins.jpg', '53BC727D859F745.jpg', NULL, 1, '2014-07-08 22:36:45', '2014-07-08 22:36:45'),
(26, '53BC7309587A505', 0, '53BC723790D7D35', 12, 'Desert.jpg', '53BC76D6305B218_379_213.1875.jpg', NULL, 0, '2014-07-08 22:39:05', '2014-07-08 22:55:18'),
(27, '53BC731D0E43925', 0, '53BC723790D7D35', 12, 'Jellyfish.jpg', '53BC76FE8FD2B58_699_393.1875.jpg', NULL, 0, '2014-07-08 22:39:25', '2014-07-08 22:55:58'),
(28, '53C0278A8C36B02', 0, 'XXX', 0, 'Desert.jpg', '53C0278A7D54902.jpg', NULL, 1, '2014-07-11 18:06:02', '2014-07-11 18:06:02'),
(29, '53C027CDCB7A309', 0, 'XXX', 0, 'Koala.jpg', '53C027CDBE89909.jpg', NULL, 1, '2014-07-11 18:07:09', '2014-07-11 18:07:09'),
(30, '53C02C3D1EAF605', 3, '53C02C27C107443', 13, 'modal_lightbox.png', '53C02CB3959D703.png', NULL, 0, '2014-07-11 18:26:05', '2014-07-11 18:26:05'),
(31, '53C02C89AE82721', 2, '53C02C27C107443', 13, 'images.jpg', '53C02C89AB93521.jpg', NULL, 0, '2014-07-11 18:27:21', '2014-07-11 18:27:21'),
(32, '53C02C935B05631', 4, '53C02C27C107443', 13, '53B1ABC85C37E16_82_46.jpeg', '53C02C9357D9131.jpeg', NULL, 0, '2014-07-11 18:27:31', '2014-07-11 18:27:31'),
(33, '53C02CA247BA946', 1, '53C02C27C107443', 13, '53B1ABC85C37E16_82_46.jpeg', '53C02CA24588346.jpeg', NULL, 0, '2014-07-11 18:27:46', '2014-07-11 18:27:46'),
(34, '53C02CDA6603242', 1, '53C02CC7B26DA23', 14, '2-125x125.jpg', '53C02CDA63D1742.jpg', NULL, 0, '2014-07-11 18:28:42', '2014-07-11 18:28:42'),
(35, '53C02CE2DAB7750', 2, '53C02CC7B26DA23', 14, 'images.jpg', '53C02CE2D884B50.jpg', NULL, 0, '2014-07-11 18:28:50', '2014-07-11 18:28:50'),
(36, '53C3F8F587E3021', 1, '53C3F8E11BFAA01', 15, 'Scott Signature.png', '53C3F8F580D0C21.png', NULL, 0, '2014-07-14 15:36:21', '2014-07-14 15:36:21'),
(37, '53C3F9178631F55', 2, '53C3F8E11BFAA01', 15, 'medessist.jpg', '53C3F9177DE5555.jpg', NULL, 0, '2014-07-14 15:36:55', '2014-07-14 15:36:55'),
(38, '53C3F92A64FF914', 3, '53C3F8E11BFAA01', 15, 'Special needs5.jpg', '53C3F94567B0441_274_149.jpg', NULL, 0, '2014-07-14 15:37:14', '2014-07-14 15:37:41'),
(40, '53E50E52E9F0518', 1, '53E50DA833C1328', 17, 'nicccc.jpg', '53E50E52E415118.jpg', NULL, 0, '2014-08-08 17:52:18', '2014-08-08 17:52:18'),
(41, '53E50E6EB573A46', 2, '53E50DA833C1328', 17, 'nikki manga.jpg', '53E50F6C1DE8800_180_180.jpg', NULL, 0, '2014-08-08 17:52:46', '2014-08-08 17:57:00'),
(42, '53E50EBFA03B607', 3, '53E50DA833C1328', 17, 'swing.jpg', '53E50EBF8C9A407.jpg', NULL, 0, '2014-08-08 17:54:07', '2014-08-08 17:54:07'),
(43, '53F4F644D507C56', 5, '53F4F62B7515131', 18, 'nic.jpg', '53F4F6A90A6AC37.jpg', NULL, 1, '2014-08-20 19:25:56', '2014-08-20 19:25:56'),
(44, '53F4F65595CBA13', 1, '53F4F62B7515131', 18, 'bengals.jpg', '53F4F6559399713.jpg', NULL, 0, '2014-08-20 19:26:13', '2014-08-20 19:26:13'),
(45, '53F4F659F022117', 2, '53F4F62B7515131', 18, 'steelers.jpg', '53F4F659EDB1417.jpg', NULL, 0, '2014-08-20 19:26:17', '2014-08-20 19:26:17'),
(46, '53F4F672DC9BC42', 3, '53F4F62B7515131', 18, 'art logo 2.jpg', '53F4F672DA68342.jpg', NULL, 0, '2014-08-20 19:26:42', '2014-08-20 19:26:42'),
(47, '53F59D4D19B9537', 1, '53F598313EC0449', 19, 'nic.jpg', '53F59D4D0FB7337.jpg', NULL, 0, '2014-08-21 07:18:37', '2014-08-21 07:18:37'),
(48, '53F5A23A7B76E38', 2, '53F598313EC0449', 19, 'nic.jpg', '53F5A23A72EAE38.jpg', NULL, 0, '2014-08-21 07:39:38', '2014-08-21 07:39:38'),
(53, '540360CFE714415', 5, '540360954189D17', 21, 'Screen Shot 2014-06-12 at 2.48.14 PM.png', '54036160D8F6D40_1872_1145.png', NULL, 1, '2014-08-31 17:52:15', '2014-08-31 17:54:41'),
(55, '540361D2980DA34', 1, '540360954189D17', 21, 'DSC08769.JPG', '540361D29619B34.JPG', NULL, 0, '2014-08-31 17:56:34', '2014-08-31 17:56:34'),
(56, '540362645766400', 5, '540362441960328', 22, 'DSC06758.JPG', '540362645532E00.JPG', NULL, 1, '2014-08-31 17:59:00', '2014-08-31 17:59:00'),
(57, '5403627F1116A27', 3, '540362441960328', 22, 'DSC05022.JPG', '540362884130536.JPG', NULL, 0, '2014-08-31 17:59:27', '2014-08-31 17:59:27'),
(58, '5404779B13B1C47', 1, '5404775ECF94446', 23, '53B1ABC85C37E16_82_46.jpeg', '5404779B0F4CD47.jpeg', NULL, 0, '2014-09-01 13:41:47', '2014-09-01 13:41:47'),
(59, '540477FF5865127', 2, '5404775ECF94446', 23, 'collageMaker_frontend21.jpeg', '540477FF55B6D27.jpeg', NULL, 0, '2014-09-01 13:43:27', '2014-09-01 13:43:27'),
(60, '5404780BCDA5E39', 3, '5404775ECF94446', 23, 'collageMaker_random_gallery1.jpeg', '5404780BCB34B39.jpeg', NULL, 0, '2014-09-01 13:43:39', '2014-09-01 13:43:39'),
(61, '5404781B2E4C155', 4, '5404775ECF94446', 23, '2014-08-10_0907.png', '5404781B2C1A755.png', NULL, 0, '2014-09-01 13:43:55', '2014-09-01 13:43:55'),
(62, '54047AB02F53D56', 5, '54047A91A3DBB25', 24, 'IMG_20140316_142948.jpg', '54047AB028FB356.jpg', NULL, 1, '2014-09-01 13:54:56', '2014-09-01 13:54:56'),
(63, '54047AD1D136A29', 1, '54047A91A3DBB25', 24, 'IMG_20140316_143002.jpg', '54047AD1CDCB729.jpg', NULL, 0, '2014-09-01 13:55:29', '2014-09-01 13:55:29'),
(64, '54047AE90369553', 2, '54047A91A3DBB25', 24, 'IMG_20140316_143333.jpg', '54047AE8F3E4652.jpg', NULL, 0, '2014-09-01 13:55:53', '2014-09-01 13:55:53'),
(65, '54047AF7157BB07', 3, '54047A91A3DBB25', 24, 'IMG_20140316_143135.jpg', '54047AF7128CE07.jpg', NULL, 0, '2014-09-01 13:56:07', '2014-09-01 13:56:07'),
(68, '540DA86B98B0227', 1, '540DA570BEE6D44', 25, 'index.jpg', '540DA8696EEEF25.jpg', NULL, 0, '2014-09-08 13:00:27', '2014-09-08 13:00:27'),
(69, '540DA8767F13B38', 2, '540DA570BEE6D44', 25, 'index.jpg', '540DA87679F2738.jpg', NULL, 0, '2014-09-08 13:00:38', '2014-09-08 13:00:38'),
(70, '540DA87F6BCFE47', 3, '540DA570BEE6D44', 25, 'index.jpg', '540DA87F453D347.jpg', NULL, 0, '2014-09-08 13:00:47', '2014-09-08 13:00:47'),
(71, '540DA887A091255', 4, '540DA570BEE6D44', 25, 'index.jpg', '540DA8879E20B55.jpg', NULL, 0, '2014-09-08 13:00:55', '2014-09-08 13:00:55'),
(72, '540DDBF99204D25', 2, '540DDBBC150DE24', 26, '1.png', '540DDBF97862325.png', NULL, 0, '2014-09-08 16:40:25', '2014-09-08 16:40:25'),
(73, '540DDC04D4F0336', 4, '540DDBBC150DE24', 26, 'beaglepub.jpg', '540DDC0B7482543.jpg', NULL, 0, '2014-09-08 16:40:36', '2014-09-08 16:40:36'),
(74, '540DDDAA874FC38', 1, '540DDCCCC0E5B56', 27, 'index.jpg', '540DDDAA7B97338.jpg', NULL, 0, '2014-09-08 16:47:38', '2014-09-08 16:47:38'),
(75, '540DDFD17034449', 1, '540DDF71C955F13', 28, 'Chrysanthemum.jpg', '540DDFD14B95949.jpg', NULL, 0, '2014-09-08 16:56:49', '2014-09-08 16:56:49'),
(76, '540DDFEC0DA0F16', 2, '540DDF71C955F13', 28, 'Penguins.jpg', '540DDFEBEAD3A15.jpg', NULL, 0, '2014-09-08 16:57:16', '2014-09-08 16:57:16'),
(77, '540DE0121606E54', 3, '540DDF71C955F13', 28, 'Hydrangeas.jpg', '540DE0120C03C54.jpg', NULL, 0, '2014-09-08 16:57:54', '2014-09-08 16:57:54'),
(78, '540DE04205C7142', 4, '540DDF71C955F13', 28, 'EFL.jpg', '540DE041EFAB441.jpg', NULL, 0, '2014-09-08 16:58:42', '2014-09-08 16:58:42'),
(79, '540DE42F6EF1E27', 1, '540DE3259E2BD01', 29, 'Desert.jpg', '540DE42F4D42327.jpg', NULL, 0, '2014-09-08 17:15:27', '2014-09-08 17:15:27'),
(80, '540DE48B33D7459', 2, '540DE3259E2BD01', 29, 'Hydrangeas.jpg', '540DE48B30E9F59.jpg', NULL, 0, '2014-09-08 17:16:59', '2014-09-08 17:16:59'),
(81, '540DE4BD6ECC549', 3, '540DE3259E2BD01', 29, 'Jellyfish.jpg', '540DE4BD3D3CC49.jpg', NULL, 0, '2014-09-08 17:17:49', '2014-09-08 17:17:49'),
(82, '540DE4E31317627', 4, '540DE3259E2BD01', 29, 'Penguins.jpg', '540DE4E30FAD227.jpg', NULL, 0, '2014-09-08 17:18:27', '2014-09-08 17:18:27'),
(83, '540F5F7A2A0FE46', 1, '540F5F5D6CCF717', 30, 'browns.jpg', '540F5F7A279F346.jpg', NULL, 0, '2014-09-09 20:13:46', '2014-09-09 20:13:46'),
(84, '540F5F7DD768749', 3, '540F5F5D6CCF717', 30, 'bengals.jpg', '540F5F7DD18D249.jpg', NULL, 0, '2014-09-09 20:13:49', '2014-09-09 20:13:49'),
(85, '54105C52A4C6034', 1, '54105C008BB3412', 31, 'index.jpg', '54105C52950F234.jpg', NULL, 0, '2014-09-10 14:12:34', '2014-09-10 14:12:34'),
(86, '54105C5ECFED146', 2, '54105C008BB3412', 31, 'index.jpg', '54105C5ECDBA846.jpg', NULL, 0, '2014-09-10 14:12:46', '2014-09-10 14:12:46'),
(87, '54105C67DC66955', 3, '54105C008BB3412', 31, 'index.jpg', '54105C67D1A8C55.jpg', NULL, 0, '2014-09-10 14:12:55', '2014-09-10 14:12:55'),
(88, '54105C6F71F8903', 4, '54105C008BB3412', 31, 'index.jpg', '54105C6F6FC7103.jpg', NULL, 0, '2014-09-10 14:13:03', '2014-09-10 14:13:03'),
(89, '5410A1B09343932', 2, '5410A16EEB7C726', 32, 'discovery.jpg', '5410A1DFAFB2719.jpg', NULL, 0, '2014-09-10 19:08:32', '2014-09-10 19:08:32'),
(90, '5410A1B464A5036', 3, '5410A16EEB7C726', 32, 'badge.png', '5410A2E46F60C40.png', NULL, 0, '2014-09-10 19:08:36', '2014-09-10 19:08:36'),
(92, '5410A2013E3F353', 1, '5410A1F3B22F139', 34, 'discovery.jpg', '5410A2013C4BA53.jpg', NULL, 0, '2014-09-10 19:09:53', '2014-09-10 19:09:53'),
(93, '5410A20468FAB56', 2, '5410A1F3B22F139', 34, 'badge.png', '5410A2046706456.png', NULL, 0, '2014-09-10 19:09:56', '2014-09-10 19:09:56'),
(94, '5410A209328D901', 3, '5410A1F3B22F139', 34, 'captchaCode.png', '5410A2093098F01.png', NULL, 0, '2014-09-10 19:10:01', '2014-09-10 19:10:01'),
(95, '5410A20D3A21E05', 4, '5410A1F3B22F139', 34, 'childrenhospital.jpg', '5410A20D37EEC05.jpg', NULL, 0, '2014-09-10 19:10:05', '2014-09-10 19:10:05'),
(96, '5410A276A224150', 1, '5410A1B67678638', 33, 'index.jpg', '5410A276991B650.jpg', NULL, 0, '2014-09-10 19:11:50', '2014-09-10 19:11:50'),
(97, '5410A295E597E21', 2, '5410A1B67678638', 33, 'index.jpg', '5410A295E327521.jpg', NULL, 0, '2014-09-10 19:12:21', '2014-09-10 19:12:21'),
(98, '5410A2A8AE38C40', 3, '5410A1B67678638', 33, 'index.jpg', '5410A2A8A955E40.jpg', NULL, 0, '2014-09-10 19:12:40', '2014-09-10 19:12:40'),
(99, '5410A2B1CFEFD49', 4, '5410A1B67678638', 33, 'index.jpg', '5410A2B1CDBCF49.jpg', NULL, 0, '2014-09-10 19:12:49', '2014-09-10 19:12:49'),
(100, '5410A31A2681D34', 1, '5410A2F84368400', 35, 'badge.png', '5410A6744E63152_50_50.png', NULL, 0, '2014-09-10 19:14:34', '2014-09-10 19:28:52'),
(101, '5410A31B0127635', 2, '5410A2F84368400', 35, 'captchaCode.png', '5410A31AF29BB34.png', NULL, 0, '2014-09-10 19:14:35', '2014-09-10 19:14:35'),
(102, '5410A31CC245A36', 3, '5410A2F84368400', 35, 'childrenhospital.jpg', '5410B29E93CE946_50_50.jpg', NULL, 0, '2014-09-10 19:14:36', '2014-09-10 20:20:46'),
(103, '5410A31EBAF4D38', 4, '5410A2F84368400', 35, 'discovery.jpg', '5410A6B35271F55_50_50.jpg', NULL, 0, '2014-09-10 19:14:38', '2014-09-10 19:29:55'),
(107, '5410B05F3D3BD11', 4, '5410B02E27BD122', 36, 'badge.png', '5411D3751A24809_123_114.png', NULL, 0, '2014-09-10 20:11:11', '2014-09-11 16:53:09'),
(108, '5410B13E3EFD954', 2, '5410B02E27BD122', 36, 'Humpback Whale.jpg', '5411DFAEF02B418_1021_418.jpg', NULL, 0, '2014-09-10 20:14:54', '2014-09-11 17:45:19'),
(109, '5410B146AAEA202', 3, '5410B02E27BD122', 36, 'Waterfall.jpg', '5411DEB8957E212_944_538.jpg', NULL, 0, '2014-09-10 20:15:02', '2014-09-11 17:41:12'),
(110, '5411E8CEF355214', 5, '5411E8C515A0005', 37, 'Ravens.jpg', '5411E8CEEFE9E14.jpg', NULL, 1, '2014-09-11 18:24:14', '2014-09-11 18:24:14'),
(111, '5411E8E06124132', 1, '5411E8C515A0005', 37, 'bengals.jpg', '5411E8E0556B032.jpg', NULL, 0, '2014-09-11 18:24:32', '2014-09-11 18:24:32'),
(112, '541336E007F7E36', 1, '541335D3E502207', 38, 'brochure1.jpg', '5416D54778C8C15_198_355.jpg', NULL, 0, '2014-09-12 18:09:36', '2014-09-15 12:02:15'),
(113, '5413370A2520418', 2, '541335D3E502207', 38, 'brochure9.jpg', '5416D4BB04F7555_461_481.jpg', NULL, 0, '2014-09-12 18:10:18', '2014-09-15 11:59:55'),
(114, '54133722982B842', 4, '541335D3E502207', 38, 'brochure10.jpg', '54133730D57BA56.jpg', NULL, 0, '2014-09-12 18:10:42', '2014-09-12 18:10:42'),
(115, '54133B22C4DA946', 2, '54133AFBEB92407', 39, 'brochure21.jpg', '54133B2CB638656.jpg', NULL, 0, '2014-09-12 18:27:46', '2014-09-12 18:27:46'),
(116, '54133D886A80900', 3, '54133D1B294C911', 40, 'brochure8.jpg', '54133D8F859F407.jpg', NULL, 0, '2014-09-12 18:38:00', '2014-09-12 18:38:00'),
(117, '54133EEA021EB54', 3, '54133E51681FA21', 41, 'brochure10.jpg', '54133F273D98455.jpg', NULL, 0, '2014-09-12 18:43:54', '2014-09-12 18:43:54'),
(118, '54133F060174922', 2, '54133E51681FA21', 41, 'brochure7.jpg', '54133F05EE46321.jpg', NULL, 0, '2014-09-12 18:44:22', '2014-09-12 18:44:22'),
(119, '541346EF8285F07', 1, '5413467F6233C15', 42, 'Blue hills.jpg', '541346EF7CA9C07.jpg', NULL, 0, '2014-09-12 19:18:07', '2014-09-12 19:18:07'),
(120, '54134700A8A6924', 2, '5413467F6233C15', 42, 'Winter.jpg', '541347009DE8B24.jpg', NULL, 0, '2014-09-12 19:18:24', '2014-09-12 19:18:24'),
(121, '5413470690BC130', 3, '5413467F6233C15', 42, 'Water lilies.jpg', '541348A9BF62B29_303_339.jpg', NULL, 0, '2014-09-12 19:18:30', '2014-09-12 19:25:29'),
(123, '54134728EC9DB04', 4, '5413467F6233C15', 42, 'Sunset.jpg', '54134728E54A904.jpg', NULL, 0, '2014-09-12 19:19:04', '2014-09-12 19:19:04'),
(125, '541431B3A88DF47', 1, '541431750AEEB45', 43, 'Chrysanthemum.jpg', '541431B36C7F847.jpg', NULL, 0, '2014-09-13 11:59:47', '2014-09-13 11:59:47'),
(126, '541431C85903708', 3, '541431750AEEB45', 43, 'Penguins.jpg', '541431D68A1DF22.jpg', NULL, 0, '2014-09-13 12:00:08', '2014-09-13 12:00:08'),
(127, '541431F0850E148', 2, '541431750AEEB45', 43, 'Lighthouse.jpg', '541432C1EF06417_855_271.jpg', NULL, 0, '2014-09-13 12:00:48', '2014-09-13 12:04:18'),
(128, '5414320C8D2FA16', 4, '541431750AEEB45', 43, 'Tulips.jpg', '5414320C8A7E716.jpg', NULL, 0, '2014-09-13 12:01:16', '2014-09-13 12:01:16'),
(130, '541890992B2C645', 2, '54170BCC7405552', 45, 'Oryx Antelope.jpg', '5424F46E0AB8B54_955_689.jpg', NULL, 0, '2014-09-16 19:33:45', '2014-09-26 05:06:54'),
(131, '541890A0771DD52', 1, '54170BCC7405552', 45, 'Tree.jpg', '541890D4EAB6F44_715_564.jpg', NULL, 0, '2014-09-16 19:33:52', '2014-09-16 19:34:45'),
(132, '5419C7C8560F228', 5, '5419C7B31A39707', 46, 'bengals.jpg', '5419C7C80B97928.jpg', NULL, 1, '2014-09-17 17:41:28', '2014-09-17 17:41:28'),
(133, '5419C7FCCAA5D20', 1, '5419C7B31A39707', 46, 'Manga Randy.jpg', '541C34CC827C608_316_261.jpg', NULL, 0, '2014-09-17 17:42:20', '2014-09-19 13:51:08'),
(134, '5419C80721F8831', 2, '5419C7B31A39707', 46, 'nicccc.jpg', '5419C9FF9156155_450_762.jpg', NULL, 0, '2014-09-17 17:42:31', '2014-09-17 17:50:55'),
(135, '541C2BB67CCAF22', 5, '541C2BA1A6FF101', 47, 'photo 4.JPG', '542466EE4527A10.JPG', NULL, 1, '2014-09-19 13:12:22', '2014-09-19 13:12:22'),
(136, '541C2E8AA0EDF26', 3, '5419C7B31A39707', 46, 'Penguins.jpg', '541C316FD3BB147_223_455.jpg', NULL, 0, '2014-09-19 13:24:26', '2014-09-19 13:36:47'),
(137, '541C2E9E7257246', 4, '5419C7B31A39707', 46, 'Tulips.jpg', '541C31378EC2B51_805_626.jpg', NULL, 0, '2014-09-19 13:24:46', '2014-09-19 13:35:51'),
(138, '54216D91ABAB141', 2, '54216D64E692556', 48, 'bag.jpg', '54217031997AA53_312_286.jpg', NULL, 0, '2014-09-23 12:54:41', '2014-09-23 13:05:53'),
(139, '542182364D38546', 1, '541C2BA1A6FF101', 47, 'acgedu.png', '542431C094A1416.png', NULL, 0, '2014-09-23 14:22:46', '2014-09-23 14:22:46'),
(140, '5421823D623C453', 2, '541C2BA1A6FF101', 47, 'christchurcheducated.co.nz.png', '542431E196AB649.png', NULL, 0, '2014-09-23 14:22:53', '2014-09-23 14:22:53'),
(141, '542182468C02A02', 3, '541C2BA1A6FF101', 47, 'askchched.png', '542431D010D4E32.png', NULL, 0, '2014-09-23 14:23:02', '2014-09-23 14:23:02'),
(142, '542592D3929FF43', 5, '5425914C169CB12', 50, 'dp.jpg', '542592D38BCA343.jpg', NULL, 1, '2014-09-26 16:22:43', '2014-09-26 16:22:43'),
(143, '54267D31BB34441', 1, '5425914C169CB12', 50, '5966657-business-customer-support-team-in-an-office-with-headsets.jpg', '54267D31B7C8E41.jpg', NULL, 0, '2014-09-27 09:02:41', '2014-09-27 09:02:41'),
(144, '54267D397008F49', 2, '5425914C169CB12', 50, '5966657-business-customer-support-team-in-an-office-with-headsets.jpg', '54267D396CDC749.jpg', NULL, 0, '2014-09-27 09:02:49', '2014-09-27 09:02:49'),
(145, '54267D4295A8558', 3, '5425914C169CB12', 50, '5966657-business-customer-support-team-in-an-office-with-headsets.jpg', '54267D9C819AA28_1109_679.jpg', NULL, 0, '2014-09-27 09:02:58', '2014-09-27 09:04:28'),
(146, '54267D54A264816', 4, '5425914C169CB12', 50, 'Penguins.jpg', '54267D547E42916.jpg', NULL, 0, '2014-09-27 09:03:16', '2014-09-27 09:03:16'),
(148, '542C494F2BC1F55', 5, '542C47757186101', 54, 'change-domain-name.png', '542C494F1A47755.png', NULL, 1, '2014-10-01 23:34:55', '2014-10-01 18:34:55'),
(150, '542C5C3B3F28739', 1, '542C47757186101', 54, 'change-domain-name.png', '542C5DB12363F53_230_227.png', NULL, 0, '2014-10-02 00:55:39', '2014-10-01 20:01:53'),
(151, '542C5C3E7D34242', 2, '542C47757186101', 54, 'change-domain-name.png', '542C5C54451AC04_319_40.png', NULL, 0, '2014-10-02 00:55:42', '2014-10-01 19:56:04'),
(163, '542DB2A184EA133', 1, '542C5FF32FD1531', 55, 'change-domain-name.png', '542DB2A18438133.png', '542DB2A1843E833_thumb.png', 0, '2014-10-03 01:16:33', '2014-10-02 20:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_portal_settings`
--

CREATE TABLE IF NOT EXISTS `tbl_portal_settings` (
  `tps_id` int(11) NOT NULL AUTO_INCREMENT,
  `tps_animation` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tps_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_portal_settings`
--

INSERT INTO `tbl_portal_settings` (`tps_id`, `tps_animation`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projects`
--

CREATE TABLE IF NOT EXISTS `tbl_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ukey` varchar(30) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `final_image_name` varchar(255) NOT NULL,
  `bg_id` int(11) NOT NULL DEFAULT '0',
  `mode` tinyint(2) NOT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `tbl_projects`
--

INSERT INTO `tbl_projects` (`id`, `name`, `ukey`, `owner_id`, `created_at`, `updated_at`, `final_image_name`, `bg_id`, `mode`, `notes`) VALUES
(1, 'xxxx', '53A89F00A85D220', 1, '2014-06-23 21:41:20', '2014-06-23 21:41:20', '', 0, 0, NULL),
(2, 'prueba', '53A8A0825669246', 1, '2014-06-23 21:47:46', '2014-06-23 21:47:46', '195ee6e0caa21b0eb3fb99b14491be57.png', 0, 1, NULL),
(3, 'Scotts project', '53A8A39A044CA58', 1, '2014-06-23 22:00:58', '2014-06-23 22:00:58', '6058817db8d87cba0ee046fca516e17c.png', 0, 1, NULL),
(9, 'test333', '53B425580B1D828', 1, '2014-07-02 15:29:28', '2014-07-02 15:29:28', '6d86539d86d063364c5e0acca02d1118.png', 0, 1, NULL),
(17, 'Nikki is Awesome', '53E50DA833C1328', 1, '2014-08-08 17:49:28', '2014-08-08 17:49:28', 'f0c66acf9471ed0ef6c0460d916ea6d7.png', 28, 1, NULL),
(18, 'nikki', '53F4F62B7515131', 30, '2014-08-20 19:25:31', '2014-08-20 19:25:31', '', 0, 0, NULL),
(19, 'Scotts New', '53F598313EC0449', 1, '2014-08-21 06:56:49', '2014-08-21 06:56:49', '', 29, 0, NULL),
(20, 'nics collage', '540359059C08F01', 30, '2014-08-31 17:19:01', '2014-08-31 17:19:01', '', 28, 0, NULL),
(21, 'Nikki is definitely Awesome', '540360954189D17', 1, '2014-08-31 17:51:17', '2014-08-31 17:51:17', '', 53, 0, NULL),
(22, 'I Say, Nikki the Great', '540362441960328', 30, '2014-08-31 17:58:28', '2014-08-31 17:58:28', '', 0, 0, NULL),
(23, 'Kallol Test Project', '5404775ECF94446', 1, '2014-09-01 13:40:46', '2014-09-01 13:40:46', '', 28, 0, NULL),
(24, 'test365', '54047A91A3DBB25', 31, '2014-09-01 13:54:25', '2014-09-01 13:54:25', '', 62, 0, NULL),
(25, 'test', '540DA570BEE6D44', 32, '2014-09-08 12:47:44', '2014-09-08 12:47:44', '044993021323db4e225dbcc25bf06ac4.png', 29, 1, NULL),
(26, 'testP', '540DDBBC150DE24', 32, '2014-09-08 16:39:24', '2014-09-08 16:39:24', '', 28, 0, NULL),
(27, 'test', '540DDCCCC0E5B56', 32, '2014-09-08 16:43:56', '2014-09-08 16:43:56', '', 28, 0, NULL),
(28, 'test10', '540DDF71C955F13', 32, '2014-09-08 16:55:13', '2014-09-08 16:55:13', 'c58a9c5f4b2c0f9ed667b04626c5a018.png', 28, 1, NULL),
(29, 'test21', '540DE3259E2BD01', 32, '2014-09-08 17:11:01', '2014-09-08 17:11:01', '', 28, 0, NULL),
(30, 'Nicoleeee', '540F5F5D6CCF717', 32, '2014-09-09 20:13:17', '2014-09-09 20:13:17', '', 29, 0, NULL),
(31, 'test567', '54105C008BB3412', 32, '2014-09-10 14:11:12', '2014-09-10 14:11:12', '', 28, 0, NULL),
(32, 'testcollage', '5410A16EEB7C726', 32, '2014-09-10 19:07:26', '2014-09-10 19:07:26', '', 28, 0, NULL),
(33, 'final12', '5410A1B67678638', 32, '2014-09-10 19:08:38', '2014-09-10 19:08:38', '', 28, 0, NULL),
(34, 'test56', '5410A1F3B22F139', 32, '2014-09-10 19:09:39', '2014-09-10 19:09:39', '', 28, 0, NULL),
(35, 'test44', '5410A2F84368400', 32, '2014-09-10 19:14:00', '2014-09-10 19:14:00', '', 28, 0, NULL),
(36, 'testtest', '5410B02E27BD122', 32, '2014-09-10 20:10:22', '2014-09-10 20:10:22', '', 28, 0, NULL),
(37, 'thursday', '5411E8C515A0005', 32, '2014-09-11 18:24:05', '2014-09-11 18:24:05', '', 110, 0, NULL),
(38, 'testt', '541335D3E502207', 32, '2014-09-12 18:05:07', '2014-09-12 18:05:07', '', 0, 0, NULL),
(39, 'last test', '54133AFBEB92407', 32, '2014-09-12 18:27:07', '2014-09-12 18:27:07', '26805418ea09c8206c711c82c6809c61.png', 0, 1, NULL),
(40, 'my test 101', '54133D1B294C911', 32, '2014-09-12 18:36:11', '2014-09-12 18:36:11', '', 28, 0, NULL),
(41, 'without background', '54133E51681FA21', 32, '2014-09-12 18:41:21', '2014-09-12 18:41:21', '', 0, 0, NULL),
(42, 'test345', '5413467F6233C15', 32, '2014-09-12 19:16:15', '2014-09-12 19:16:15', '', 28, 0, NULL),
(43, 'mtest', '541431750AEEB45', 32, '2014-09-13 11:58:45', '2014-09-13 11:58:45', '', 29, 0, NULL),
(44, 'aaa', '54158DA24EE8B18', 32, '2014-09-14 12:44:18', '2014-09-14 12:44:18', '', 0, 0, NULL),
(45, 'test', '54170BCC7405552', 32, '2014-09-15 15:54:52', '2014-09-15 15:54:52', '', 28, 0, NULL),
(46, 'WEDNESDAY', '5419C7B31A39707', 32, '2014-09-17 17:41:07', '2014-09-17 17:41:07', '', 132, 0, NULL),
(47, 'Asif', '541C2BA1A6FF101', 32, '2014-09-19 13:12:01', '2014-09-19 13:12:01', '', 28, 0, NULL),
(49, 'test', '54258C58CCF5B04', 32, '2014-09-26 15:55:04', '2014-09-26 15:55:04', '', 0, 0, NULL),
(50, 'test', '5425914C169CB12', 32, '2014-09-26 16:16:12', '2014-09-26 16:16:12', '', 29, 0, NULL),
(54, 'testa 1', '542C47757186101', 34, '2014-10-01 23:27:01', '2014-10-01 18:27:01', '', 148, 0, NULL),
(55, 'bvbnv', '542C5FF32FD1531', 34, '2014-10-02 01:11:31', '2014-10-01 20:11:31', '', 153, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seo`
--

CREATE TABLE IF NOT EXISTS `tbl_seo` (
  `ts_id` int(11) NOT NULL AUTO_INCREMENT,
  `ts_meta_key` text NOT NULL,
  `ts_site_title` text NOT NULL,
  `ts_meta_description` text NOT NULL,
  `ts_mail_address` varchar(255) NOT NULL,
  `ts_web_address` varchar(400) NOT NULL,
  `ts_address` text NOT NULL,
  `ts_phone` varchar(20) NOT NULL,
  `ts_currency` varchar(29) NOT NULL,
  `ts_favicon` varchar(60) NOT NULL,
  `ts_logo` varchar(60) NOT NULL,
  `ts_mode` tinyint(2) NOT NULL DEFAULT '1',
  `ts_recommended_seller` int(11) NOT NULL DEFAULT '0',
  `ts_author` varchar(255) NOT NULL,
  `ts_hw_meta_key` text NOT NULL,
  `ts_hw_meta_des` text NOT NULL,
  `ts_wu_meta_key` text NOT NULL,
  `ts_wu_meta_des` text NOT NULL,
  `ts_sellmo_meta_key` text NOT NULL,
  `ts_sellmo_meta_des` text NOT NULL,
  `ts_sellpo_meta_key` text NOT NULL,
  `ts_sellpo_meta_des` text NOT NULL,
  `ts_sellmv_meta_key` text NOT NULL,
  `ts_sellmv_meta_des` text NOT NULL,
  `ts_sellrs_meta_key` text NOT NULL,
  `ts_sellrs_meta_des` text NOT NULL,
  `ts_faq_meta_key` text NOT NULL,
  `ts_faq_meta_des` text NOT NULL,
  `ts_search_meta_key` text NOT NULL,
  `ts_search_meta_des` text NOT NULL,
  `ts_partner_meta_key` text NOT NULL,
  `ts_partner_meta_des` text NOT NULL,
  `ts_product_meta_key` text NOT NULL,
  `ts_product_meta_des` text NOT NULL,
  `ts_brand_meta_key` text NOT NULL,
  `ts_brand_meta_des` text NOT NULL,
  `ts_contact_meta_key` text NOT NULL,
  `ts_contact_meta_des` text NOT NULL,
  PRIMARY KEY (`ts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `tu_id` int(11) NOT NULL AUTO_INCREMENT,
  `tu_user_key` varchar(64) NOT NULL,
  `tu_email` varchar(255) NOT NULL,
  `tu_username` varchar(255) NOT NULL,
  `tu_fname` varchar(255) NOT NULL,
  `tu_lname` varchar(255) NOT NULL,
  `tu_sex` varchar(10) NOT NULL DEFAULT 'male',
  `tu_dob` datetime NOT NULL,
  `tu_cur` varchar(20) NOT NULL DEFAULT 'euro',
  `tu_street` varchar(255) NOT NULL,
  `tu_zip` varchar(255) NOT NULL,
  `tu_city` varchar(255) NOT NULL,
  `tu_mobile` varchar(255) NOT NULL,
  `tu_shot_country` varchar(50) NOT NULL,
  `tu_long_country` varchar(255) NOT NULL,
  `tu_password` varchar(64) NOT NULL,
  `tu_role` tinyint(2) NOT NULL,
  `tu_ackey` varchar(50) NOT NULL,
  `tu_fokey` varchar(50) NOT NULL,
  `tu_ip` varchar(50) NOT NULL,
  `tu_created_at` datetime NOT NULL,
  `tu_status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`tu_id`, `tu_user_key`, `tu_email`, `tu_username`, `tu_fname`, `tu_lname`, `tu_sex`, `tu_dob`, `tu_cur`, `tu_street`, `tu_zip`, `tu_city`, `tu_mobile`, `tu_shot_country`, `tu_long_country`, `tu_password`, `tu_role`, `tu_ackey`, `tu_fokey`, `tu_ip`, `tu_created_at`, `tu_status`) VALUES
(32, '540DA545F0D9C01', 'info@hiretechguys.com', 'techold', 'tech', 'expert', 'male', '1988-04-19 00:00:00', '', '', '', '', '', '', 'Afghanistan', '21232f297a57a5a743894a0e4a801fc3', 1, '540da545f0c585.58084658', '', '122.173.1.30', '2014-09-08 12:47:01', 1),
(34, '54188F5722E1723', 'itsgeniusstar@gmail.com', 'scott', '', '', 'male', '1998-08-15 00:00:00', '', '', '', '', '', '', 'Afghanistan', 'admin1', 1, '54188f5722a731.07421643', '', '71.21.206.177', '2014-09-16 19:28:23', 1),
(35, '5420F4E42A12B48', 'taglenet1@outlook.com', 'taglenet1', 'taglenet1', 'taglenet1', 'male', '1999-04-16 00:00:00', '', '', '', '', '', '', 'Afghanistan', 'c3f0e87365436ab47494679ff1db4e26', 1, '5420f4e429b4e6.47495783', '', '190.181.224.35', '2014-09-23 04:19:48', 1),
(36, '5421708D74D4A25', 'thewebsitedesignexchange@gmail.com', 'scottpjr', '', '', 'male', '2012-03-03 00:00:00', '', '', '', '', '', '', 'Afghanistan', '06613cb6e2730e9684061527f9cbe634', 1, '5421708d745d66.40279516', '', '71.21.206.177', '2014-09-23 13:07:25', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
