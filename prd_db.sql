-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 02:42 PM
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
-- Database: `prd_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_content`
--

CREATE TABLE `about_content` (
  `section_key` varchar(50) NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_content`
--

INSERT INTO `about_content` (`section_key`, `section_title`, `section_text`) VALUES
('intro', 'හැදින්වීම', 'වයඹ පළාත් සභාව යටතේ ක්‍රියාත්මක වන ප්‍රධානතම තාක්ෂණික ආයතනයක් වන්නේ පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුවයි. කුරුණෑගල සහ පුත්තලම යන දිස්ත්‍රික්ක දෙකම ආවරණය වන පරිදි පළාතේ පොදු ප්‍රවාහන ජාලය ශක්තිමත් කිරීම සහ ග්‍රාමීය මෙන්ම නාගරික මාර්ග පද්ධතිය නඩත්තු කිරීම මෙහි ප්‍රධාන වගකීම වේ.'),
('offices', 'විධායක ඉංජිනේරු කාර්යාල', 'වයඹ පළාත පුරා විසිරී ඇති මාර්ග ජාලය කාර්යක්ෂමව පාලනය කිරීම සහ අධීක්ෂණය කිරීම සදහා විධායක ඉංජිනේරු කාර්යාල 6ක් ස්ථාපිත කර ඇත. මෙම සෑම කාර්යාලයක්ම අදාල ප්‍රදේශයට අයත් මාර්ගවල ප්‍රමිතිය සහ ඉදිකිරීම් කටයුතු පිළිබඳ සෘජු වගකීම දරනු ලබයි. වයඹ පළාතේ ආර්ථික සංවර්ධනයට සෘජුවම දායක වන මෙම දෙපාර්තමේන්තුව කෘෂිකාර්මික නිපැයුම් වෙළඳපොළ කරා ප්‍රවාහනය කිරීමට අවශ්‍ය මංමාවත් සකසා දීම මගින් ප්‍රදේශයේ ජන ජීවිතය ඉහළ නැංවීමට විශාල මෙහෙවරක් ඉටු කරයි.'),
('org_chart', 'සංවිධාන සැලැස්ම අන්තර්ගතය', '...... (සංවිධාන සැලැස්ම ඉදිරියේදී යාවත්කාලීන වේ)'),
('task_01', '01. පළාත් මාර්ග ඉදිකිරීම සහ සංවර්ධනය', 'නව මාර්ග පද්ධති සැලසුම් කිරීම සහ පවතින මාර්ග කාපට් (Asphalt) යොදා නවීකරණය කිරීම.'),
('task_02', '02. නඩත්තු කටයුතු', 'මාර්ග දෙපස කාණු පද්ධති, පාලම් සහ බෝක්කු නිසි ලෙස නඩත්තු කිරීම.'),
('task_03', '03. ගමනාගමන පහසුකම් සැලසීම', 'ජනතාවට බාධාවකින් තොරව ගමනා ගමන කටයුතු සිදුකිරීම සදහා අවශ්‍ය යටිතල පහසුකම් සැලසීම.');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(10) DEFAULT NULL,
  `tasks` text DEFAULT NULL,
  `head_name` varchar(255) DEFAULT NULL,
  `head_title` varchar(255) DEFAULT NULL,
  `head_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `slug`, `title`, `icon`, `tasks`, `head_name`, `head_title`, `head_photo`, `created_at`) VALUES
(1, 'div-1', 'ආයතන අංශය', '🏛️', '1. කාර්යාල කළමනාකරණය - දෛනිකව කාර්යාලයේ වැඩකටයුතු සැලසුම් කිරීම සහ ඒවා නිසි පරිදි සිදු වනවාදැයි සොයා බැලීම.\r\n2. ලේඛන නඩත්තුව - ආයතනයට ලැබෙන සහ ආයතනයෙන් පිටතට යවන ලිපි ලේඛන, ලිපි ගොනු සහ වාර්තා ක්‍රමවත්ව ගොනු කර තැබීම.\r\n3. සන්නිවේදනය - දුරකථන ඇමතුම් , ඊමේල් සහ අනෙකුත් පණිවිඩ අදාළ අංශ වෙත යොමු කිරීම සහ සම්බන්ධීකරණය.\r\n4. මානව සම්පත් සහාය - සේවකයින්ගේ පැමිණීම සටහන් කිරීම , නිවාඩු අනුමත කිරීම සහ සේවක සුබසාධන කටයුතු සම්බන්ධීකරණය.\r\n5. නඩත්තු කටයුතු - කාර්යාල ගොඩනැගිල්ල, ගෘහ භාණ්ඩ සහ විදුලි උපකරණවල අලුත් වැඩියා කටයුතු සහ පිරිසිදු කිරීම් අධීක්ෂණය කිරීම.\r\n6. අමුත්තන් පිළිගැනීම - කාර්යාලයට පැමිණෙන බාහිර පුද්ගලයින්ට සහ සේවාදායකයින්ට අවශ්‍ය මගපෙන්වීම් ලබා දීම.\r\n7. උත්සව සහ රැස්වීම් සංවිධානය - ආයතනික රැස්වීම්, සම්මුඛ පරීක්ෂණ සහ විවිධ උත්සව සදහා අවශ්‍ය පහසුකම් සලසා දීම.', 'A.L.D.S. ප්‍රියදර්ශනී', 'පරිපාලන නිළධාරී', 'img/Division/1775397963_A.L.D.S.Priyadarshani (Administrative Officer) (1).png', '2026-04-05 14:05:16'),
(2, 'div-2', 'වැඩ අංශය', '🏗️', '1. ඇස්තමේන්තු සකස් කිරීම - අලුත් වැඩියාවක් හෝ අලුත් වැඩක් සදහා වැය වන පිරිවැය ගණනයකර වාර්තා පිළියෙළ කිරීම.\n2. ටෙන්ඩර් කටයුතු - අදාල වැඩ කටයුතු සදහා කොන්ත්‍රාත්කරුවන් තෝරා ගැනීමට අවශ්‍ය ලියකියවිලි සකස් කිරීම සහ ටෙන්ඩර් දැන්වීම් සදහා සහාය වීම.\n3. කොන්ත්‍රාත්කරුවන් අධීක්ෂණය - බාහිර පාර්ශවයන් මගින් සිදු කරන වැඩ නිසි ප්‍රමිතියට සහ නියමිත කාලයට අවසන් කරන්නේදැයි සොයා බැලීම.\n4. දේපළ ආරක්ෂාව - ආයතනයේ භෞතික දේපළවලට හානි සිදු නොවීමට වගබලා ගැනීම සහ ඒවායේ ආරක්ෂාව තහවුරු කිරීම.', 'අංශ ප්‍රධානීන්', 'වැඩ අංශය', '', '2026-04-05 14:05:16'),
(3, 'div-3', 'ගිණුම් අංශය', '💹', '1.ගෙවීම් සිදු කිරීම - සේවක වැටුප් , අතිකාල දීමනා, සැපයුම් කරුවන්ට ගෙවිය යුතු මුදල් හා උපයෝගිතා ගාස්තු\r\n2.ආදායම් වාර්තා කිරීම -  ආයතනයට ලැබෙන සියළුම මුදල් , චෙක්පත් හෝ බැංකු තැන්පතු නිසි පරිදි සටහන්කිරීම සහ රිසිට් පත් නිකුත් කිරීම.\r\n3.පොත් තැබීම - දෛනිකව සිදුවන සියළුම වියදම් සහ ආදායම් ලෙජර් පොත්වල හෝ පරිගණක මෘදුකාංගවල නිවැරදිව සටහන් කිරීම\r\n4.බැංකු කටයුතු', 'අංශ ප්‍රධානීන්', 'ගිණුම් අංශය', '', '2026-04-05 14:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_content`
--

CREATE TABLE `home_content` (
  `id` int(11) NOT NULL,
  `section_key` varchar(50) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_content`
--

INSERT INTO `home_content` (`id`, `section_key`, `section_title`, `section_text`) VALUES
(1, 'vision', 'දැක්ම', 'කාර්යක්ෂම හා ඵලදායි පළාත් මාර්ග පද්ධතියක්'),
(2, 'mission', 'මෙහෙවර', 'සීමිත සම්පත් දියුණු තාක්ෂණය හා ශිල්පීය නිපුනතාවය ඵලදායි ලෙස කළමනාකරණය කර ගනිමින් වයඹ පළාත් මාර්ග පද්ධතිය කාර්යක්ෂම ප්‍රවාහන මෙහෙයුම් සදහා නිර්මාණය කිරීම හා යථාවත් කාලීනව පවත්වා ගෙන යාම.'),
(3, 'director_name', 'මාණ්ඩලික නිලධාරී නම', 'N.P. කුමාරසිංහ'),
(4, 'director_title', 'තනතුර', 'පළාත් අධ්‍යක්ෂක'),
(5, 'director_quote', 'ප්‍රකාශය', 'වයඹ පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව, ගුණාත්මක හා කාර්යක්ෂම මාර්ග පද්ධතියක් තුළින් පළාතේ අනාගත සංවර්ධනය වේගවත් කිරීම සඳහා නිරන්තරයෙන්ම කැපවී සිටී.');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'namal bandara', 'namal.itunit.coop@gmail.com', '්්්්්්', '2026-04-05 14:21:04'),
(2, 'namal bandara', 'namal.itunit.coop@gmail.com', '්්්්්්', '2026-04-05 14:24:05');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `date`, `created_at`) VALUES
(1, 'මාර්ග නඩත්තු ව්‍යාපෘතිය', 'කුරුණෑගල දිස්ත්‍රික්කයේ ග්‍රාමීය මාර්ග රැසක් කාපට් කිරීමේ වැඩසටහන ආරම්භ වේ.', '2024-03-20', '2026-03-28 15:38:21'),
(2, 'නව පාලමක් ඉදිකිරීම', 'පුත්තලම ප්‍රදේශයේ නව පාලමක් සඳහා මුල්ගල් තැබීම අද දින සිදුවිය.', '2024-03-15', '2026-03-28 15:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `procurements`
--

CREATE TABLE `procurements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_officers`
--

CREATE TABLE `staff_officers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_officers`
--

INSERT INTO `staff_officers` (`id`, `name`, `designation`, `image_path`, `display_order`) VALUES
(2, 'J.M.S.I. බණ්ඩාර', 'සහකාර අධ්‍යක්ෂ', 'img/staff/1775198983_WhatsApp Image 2026-04-02 at 12.31.12.jpeg', 0),
(3, 'J.M.T.B. ජයවර්ධන', 'සහකාර අධ්‍යක්ෂ', 'img/staff/1775199100_WhatsApp Image 2026-04-02 at 12.31.32.jpeg', 0),
(5, 'A.L.D.S. ප්‍රියදර්ශනී', 'පරිපාලන නිළධාරී', 'img/staff/1775199381_A.L.D.S.Priyadarshani (Administrative Officer).png', 0),
(6, 'R.D.G.S. සුරංජිමාලි', 'ගණකාධිකාරී', 'img/staff/1775202176_WhatsApp Image 2026-04-02 at 12.36.24.jpeg', 0),
(7, 'aaa', 'aaaa', 'img/staff/1775202684_WhatsApp Image 2026-04-02 at 12.23.27.jpeg', 0),
(9, 'aaa', 'aaa', 'img/staff/1775202823_WhatsApp Image 2026-04-02 at 12.23.14.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_offices_content`
--

CREATE TABLE `sub_offices_content` (
  `section_key` varchar(50) NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_offices_content`
--

INSERT INTO `sub_offices_content` (`section_key`, `section_title`, `section_text`) VALUES
('page_desc', 'පිටු විස්තරය', 'පළාතේ මාර්ග සංවර්ධනය වඩාත් කාර්යක්ෂමව සහ කඩිනමින් සිදුකිරීම උදෙසා අපගේ දෙපාර්තමේන්තුව යටතේ විධායක ඉංජිනේරු කාර්යාල 6ක් ප්‍රධාන දිස්ත්‍රික්ක දෙක ආවරණය වන පරිදි ස්ථාපිත කර ඇත.'),
('page_subtitle', 'පිටු උප මාතෘකාව', 'වයඹ පළාත පුරා විසිරී ඇති අපගේ උපකාර්යාල ජාලය'),
('page_title', 'පිටු මාතෘකාව', 'උපකාර්යාල (විධායක ඉංජිනේරු කාර්යාල)');

-- --------------------------------------------------------

--
-- Table structure for table `sub_offices_list`
--

CREATE TABLE `sub_offices_list` (
  `id` int(11) NOT NULL,
  `office_name` varchar(255) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_offices_list`
--

INSERT INTO `sub_offices_list` (`id`, `office_name`, `district`, `address`, `display_order`) VALUES
(1, 'කුරුණෑගල කාර්යාලය', 'කුරුණෑගල', 'විධායක ඉංජිනේරු කාර්යාලය, කුරුණෑගල.', 1),
(2, 'කුලියාපිටිය කාර්යාලය', 'කුරුණෑගල', 'විධායක ඉංජිනේරු කාර්යාලය, කුලියාපිටිය.', 2),
(3, 'මහව කාර්යාලය', 'කුරුණෑගල', 'විධායක ඉංජිනේරු කාර්යාලය, මහව.', 3),
(4, 'ආණමඩුව කාර්යාලය', 'පුත්තලම', 'විධායක ඉංජිනේරු කාර්යාලය, ආණමඩුව.', 4),
(5, 'වාරියපොළ කාර්යාලය', 'කුරුණෑගල', 'විධායක ඉංජිනේරු කාර්යාලය, වාරියපොළ.', 5),
(6, 'හලාවත කාර්යාලය', 'පුත්තලම', 'විධායක ඉංජිනේරු කාර්යාලය, හලාවත.', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`section_key`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_content`
--
ALTER TABLE `home_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procurements`
--
ALTER TABLE `procurements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_officers`
--
ALTER TABLE `staff_officers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_offices_content`
--
ALTER TABLE `sub_offices_content`
  ADD PRIMARY KEY (`section_key`);

--
-- Indexes for table `sub_offices_list`
--
ALTER TABLE `sub_offices_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_content`
--
ALTER TABLE `home_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `procurements`
--
ALTER TABLE `procurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_officers`
--
ALTER TABLE `staff_officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_offices_list`
--
ALTER TABLE `sub_offices_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
