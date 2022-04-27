SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `world_of_mirrors`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'Wall mirrors'),
(3, 'Make-up mirrors'),
(5, 'Mirrors with lights'),
(41, 'Standing mirrors');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_user_name` varchar(50) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_user_name`, `comment`, `comment_created_date`, `product_id`) VALUES
(7, 'Alex', 'Wonderful, some periodic cleaning on dust that collects on bottom mirror ledge. Looks good, strong value!', '2022-03-27 21:26:06', 9),
(8, 'Ron', 'It’s a mirror plain and simple.', '2022-03-28 21:26:06', 5),
(9, 'Amora', 'The frame is nice but the mirror is not very flat.', '2022-03-29 21:26:06', 12),
(10, 'Erica', 'Good size for my entrance door.', '2022-03-30 21:25:06', 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_width` int(5) DEFAULT NULL,
  `product_hight` int(5) DEFAULT NULL,
  `product_shape` varchar(50) NOT NULL,
  `product_frame` varchar(50) NOT NULL,
  `product_description` varchar(1024) NOT NULL,
  `product_image` varchar(50) DEFAULT NULL,
  `product_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_width`, `product_hight`, `product_shape`, `product_frame`, `product_description`, `product_image`, `product_created_date`, `product_updated_date`, `category_id`) VALUES
(5, 'Mirror #1', 600, 1200, 'Oval', 'Aluminum', '<p>By decorating with mirrors, you add depth to a room and give it more life.</p>', NULL, '2022-03-24 22:27:57', '2022-04-12 19:14:15', 1),
(9, 'Mirror #2', 543, 345, 'Rectangular', 'Stainless steel', '<p>Your reflection deserves to be framed in a nice way.</p>', NULL, '2022-03-25 21:37:49', '2022-04-11 23:08:53', 1),
(12, 'Mirror #3', 800, 600, 'Rectangular', 'Stainless steel', '<p>This mirror comes equipped with integrated LED lighting that spreads a soft, diffused light in the bathroom that is easy to wake up to, giving you a pleasant start in the morning.</p>', 'images/Mirror-3.JPG', '2022-03-27 16:59:56', '2022-04-12 06:30:45', 5),
(29, 'Mirror #4', 400, 1670, 'Rectangular', 'Stainless steel', '<p>You decide the style of this mirror by adding or removing the crown up top.</p>', 'images/Mirror-4.JPG', '2022-03-29 18:06:09', '2022-04-12 21:14:48', 41),
(30, 'Mirror #5', 650, 650, 'Square', 'Stainless steel', '<p>The timeless design works just as well in the living room as in the bathroom.</p>', NULL, '2022-03-29 18:11:07', '2022-04-11 23:09:58', 1),
(31, 'Mirror #6', 270, 400, 'Rectangular', 'Wood', '<p>This mirror works just as well on a chest of drawers as on a wall. When it&rsquo;s on the wall you can use the stand to hang your scarves or ties.</p>', NULL, '2022-03-29 18:13:24', '2022-04-11 23:10:07', 3),
(32, 'Mirror #7', 170, 330, 'Round', 'Stainless steel', '<p>This 2-sided mirror can be placed wherever you need it. It has a regular mirror on one side and a magnifying mirror on the other - ideal for shaving, plucking eyebrows or putting on makeup.</p>', NULL, '2022-03-29 18:13:26', '2022-04-11 23:10:15', 3),
(33, 'Mirror #8', 170, 170, 'Round', 'Stainless steel', '<p>Check out your hair from all angles and get a close-up view when shaving or putting on make-up. An indispensable tool, with magnifying mirror on one side, to help you prepare for the day ahead.</p>', NULL, '2022-03-29 18:13:28', '2022-04-11 23:10:26', 3),
(34, 'Mirror #9', 1000, 960, 'Rectangular', 'Stainless steel, High-pressure melamine laminate', '<p>A mirror cabinet that makes clever use of wall space, combined with integrated LED lighting that spreads a soft light in the bathroom &ndash; so you get off to a good start in the morning.</p>', NULL, '2022-03-29 18:22:56', '2022-04-11 23:10:34', 5),
(35, 'Mirror #10', 520, 1400, 'Rectangular', 'High-pressure melamine laminate', '<p>A classical look with molded edges. You can hang it vertically or horizontally depending on your preference and what best fits your space.</p>', NULL, '2022-03-29 18:28:41', '2022-04-12 18:24:32', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `categories_products` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
