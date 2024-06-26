-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2024 at 07:17 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `post_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`) VALUES
(1, 2, 1, 'hi\n', '2024-06-24 17:37:33'),
(2, 2, 1, 'hi\n', '2024-06-24 17:37:34'),
(3, 2, 1, 'hi\n', '2024-06-24 17:37:34'),
(4, 2, 1, 'hi\n', '2024-06-24 17:37:35'),
(5, 2, 1, 'hi\n', '2024-06-24 17:37:35'),
(6, 2, 1, 'hi\n', '2024-06-24 17:37:35'),
(7, 2, 1, 'hi\n', '2024-06-24 17:37:35'),
(8, 2, 1, 'hi\n', '2024-06-24 17:37:35'),
(9, 3, 1, 'dfdgf', '2024-06-24 17:38:21'),
(10, 3, 1, 'dfdgf', '2024-06-24 17:38:21'),
(11, 3, 1, 'sdas', '2024-06-24 17:40:03'),
(12, 3, 1, 'dfsf', '2024-06-24 17:54:47'),
(13, 2, 3, 'oh, Hi Hammad Welcome', '2024-06-24 17:58:56'),
(14, 2, 2, 'this is comment\n', '2024-06-24 23:05:26'),
(15, 5, 4, 'ok', '2024-06-26 00:47:05'),
(16, 5, 12, 'ok', '2024-06-26 00:47:12'),
(17, 5, 14, 'coment working\r\n', '2024-06-26 00:50:43'),
(18, 8, 14, 'HI Driver...', '2024-06-26 01:41:06'),
(19, 5, 19, 'over the lazy dog', '2024-06-26 07:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(22, 4, 3),
(28, 5, 12),
(36, 5, 3),
(35, 8, 14),
(34, 5, 14),
(33, 5, 13),
(32, 6, 13),
(31, 5, 10),
(27, 5, 11),
(25, 2, 2),
(24, 4, 2),
(23, 2, 3),
(18, 3, 1),
(37, 5, 19),
(38, 2, 19);

-- --------------------------------------------------------

--
-- Table structure for table `narrative_contributions`
--

DROP TABLE IF EXISTS `narrative_contributions`;
CREATE TABLE IF NOT EXISTS `narrative_contributions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `narrative_contributions`
--

INSERT INTO `narrative_contributions` (`id`, `user_id`, `post_id`, `content`, `created_at`) VALUES
(1, 4, 3, 'this is narrative', '2024-06-24 19:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `shared_post_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created_at`, `shared_post_id`) VALUES
(1, 2, 'hello\r\n', '2024-06-24 17:37:18', NULL),
(2, 2, 'this is my new post\r\n', '2024-06-24 17:57:01', NULL),
(3, 4, 'This is Hammad\'s first post\r\n', '2024-06-24 17:58:18', NULL),
(4, 2, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus natus at architecto sed dolores, repellat ratione ad tenetur, nulla itaque, voluptatem officiis. Corrupti dolor optio natus voluptatum laborum repudiandae. Modi?\r\nSequi, at! Libero omnis corporis error tempore temporibus tempora amet exercitationem repellendus, mollitia, laudantium aliquam odit, non eligendi cupiditate expedita soluta ad neque? Mollitia exercitationem iste eos rem. Porro, maiores!\r\nCulpa alias corporis doloremque vel quis error temporibus nobis modi maxime iusto quaerat quo ex ad reiciendis, cumque consequuntur enim molestiae nesciunt sit eum maiores aperiam voluptatum laudantium delectus. Blanditiis!\r\nDicta sed cumque deserunt repellat, perspiciatis veritatis suscipit excepturi blanditiis ex, officia accusantium asperiores. Vel facere nesciunt exercitationem modi cum amet ducimus magnam aspernatur, asperiores quae iure voluptate voluptas enim!', '2024-06-25 16:13:22', NULL),
(5, 4, 'Agree with him', '2024-06-25 16:14:14', 4),
(6, 4, 'Yes I do...', '2024-06-25 16:14:41', 5),
(7, 4, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus natus at architecto sed dolores, repellat ratione ad tenetur, nulla itaque, voluptatem officiis. Corrupti dolor optio natus voluptatum laborum repudiandae. Modi?\r\n            ', '2024-06-25 16:15:49', NULL),
(8, 4, 'zdfsfd', '2024-06-25 16:15:53', 7),
(9, 2, 'this is Lorem text\n', '2024-06-25 16:22:45', 8),
(10, 2, 'Just Lorem text', '2024-06-25 16:23:05', 4),
(11, 5, 'Hello Sami,\r\nhow are you?', '2024-06-25 19:07:06', NULL),
(12, 6, 'Hi I am Driver, this is my first post here.', '2024-06-25 19:25:32', NULL),
(13, 5, 'Helloooooo!', '2024-06-26 00:24:14', NULL),
(14, 5, 'hl0', '2024-06-26 00:50:20', 12),
(15, 8, 'Hi, I am SAlman \r\nposting this story', '2024-06-26 01:40:45', NULL),
(16, 8, 'reposting my own story', '2024-06-26 01:44:41', 15),
(17, 9, 'A quick Briwb fix hymos iver tge kazt dif', '2024-06-26 04:33:24', NULL),
(18, 9, 'it is good but it has many mistakes\r\n', '2024-06-26 04:34:09', 17),
(19, 5, 'A quick brown fox jumps', '2024-06-26 07:09:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
CREATE TABLE IF NOT EXISTS `replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `user_id`, `comment_id`, `content`, `created_at`) VALUES
(1, 2, 13, 'sdadsd', '2024-06-24 18:50:49'),
(2, 4, 13, 'haha\n', '2024-06-24 18:51:42'),
(3, 4, 14, 'oh really????', '2024-06-24 23:05:51'),
(4, 2, 13, 'sadasd\n', '2024-06-25 05:48:07'),
(5, 2, 13, 'sad', '2024-06-25 15:59:33'),
(6, 2, 12, 'ok\n', '2024-06-25 16:09:09'),
(7, 5, 17, 'k.o', '2024-06-26 01:16:56'),
(8, 5, 12, 'hehe', '2024-06-26 06:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`) VALUES
(1, 'sami', '', 'sami', NULL),
(2, 'msami', '', '$2y$10$oRy53EBb/USU10fIbS6fUu/bjhouOa14Bgn.YAZdSxD4DjaWy/nua', NULL),
(3, 'sam', '', '$2y$10$LqjeeByGRpe9.qHiZOnPzuLeFSg4Y5HYnOcW7xOUeTN4WPkOxe7Sa', NULL),
(4, 'hammad', '', '$2y$10$Jkdps5m8WcFXCUfTj7cKq.JWszO2ji0f96fnUr4lwjsDcOdov1hY6', NULL),
(5, 'kamran', 'kamran@gmail.com', '$2y$10$xHD0IRvUYOHA1qc5xL2JReYrEKVzwX.8vP2Y3IcZTScdqyZHBoSqu', NULL),
(6, 'driver', 'driver@driver.com', '$2y$10$4HHIUio7wspzb0O7mHz.Mu5DW4ZCahFgrJwc9ZFZPEnvS5Gt2/w.C', 'uploads/elie-khoury-GidYc-pS9sM-unsplash.jpg'),
(8, 'salman', 'salman@gmail.com', '$2y$10$05Wg9jYqqTuuJCGUWxJOx.TzS1G3u2UQh1VOzkFTH0X4EUduDyuSG', 'uploads/lionill.png'),
(9, 'hammad_291', 'hm746765@gmail.com', '$2y$10$CovfIVNL7bSHH2xiehor6eWmNT5hTI5C.wwt4LWkjUaRofxaDgLl6', 'uploads/African-Wanderlust-Adventure-Logo-2.png'),
(10, 'Admin', 'admin@gmail.com', '$2y$10$HOQzPsCJ/Dsz40HGnH/fT.d7ASGeNQcQY5CvH9wCsxy9auP0Gtk/.', 'uploads/2024_05_26_17_05_IMG_4451.JPG'),
(11, 'aimen', 'amw@gmail.com', '$2y$10$1Jm/s3RywqZNmqnUafwfK.bG0vamJfrex1nJvzwz0TrUzle/XUpH2', 'uploads/2024_05_23_16_09_IMG_4075.JPG');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
