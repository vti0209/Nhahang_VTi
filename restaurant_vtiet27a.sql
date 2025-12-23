create database restaurant_vtiet27a;
use restaurant_vtiet27a;
-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2018 at 12:29 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_vtiet27a`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', MD5('1234@'));
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--
TRUNCATE TABLE `categories`;
INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Đặc Sản Việt'),
(2, 'Ẩm Thực nước Bạn'),
(3, 'Sản phẩm Hot');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contents` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `contents` text,
  `created` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--
TRUNCATE TABLE `contacts`;
INSERT INTO `contacts` (`id`, `name`, `email`, `title`, `contents`, `created`, `status`) VALUES
(1, 'Ho Van Tiet', 'hotiet74@gmail.com', 'Demo web', 'Test thôi nhá', '2018-02-02 08:32:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total` float NOT NULL,
  `date_order` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `orders` ADD `order_code` VARCHAR(20) AFTER `id`;
--
-- Dumping data for table `orders`
--
TRUNCATE TABLE `orders`;
INSERT INTO `orders` (`id`, `total`, `date_order`, `status`, `user_id`) VALUES
(1, 245000, '2018-01-25 18:30:30', 1, 12),
(7, 245000, '2018-11-06 18:23:37', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `saleprice` float NOT NULL,
  `created` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `keyword` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--
TRUNCATE TABLE `products`;
INSERT INTO `products` (`id`, `name`, `category_id`, `image`, `description`, `price`, `saleprice`, `created`, `quantity`, `keyword`, `status`) VALUES
(1, 'Bún bò Huế', 1, 'images/fashion_boy/ao dep - xanh duong.jpg', '', 180000, 0, '2017-12-18', 5, '', 0),
(2, 'Cơm Cháy', 1, 'images/fashion_boy/men-cloth.jpg', '', 290000, 0, '2017-12-18', 8, '', 0),
(3, 'Cao Lầu Hội An', 1, 'images/fashion_boy/men-wear.jpg', '', 210000, 0, '2017-12-18', 10, '', 0),
(4, 'Lẩu Mắm Miền Tây', 1, 'images/fashion_boy/vest-xam-ke-soc-an-tuong.jpg', '', 180000, 0, '2017-12-18', 7, '', 0),
(5, 'Bánh tráng cuốn thịt', 1, 'images/fashion_boy/so-mi-xanh-tim-hoa-tiet-tron.jpg', '', 250000, 0, '2017-12-18', 12, '', 0),
(6, 'Trứng Ngâm tương', 2, 'images/fashion_girl/Green-Viscose-Dresses.jpg', '', 165000, 0, '2017-12-18', 15, '', 0),
(7, 'Toboki Hàn', 2, 'images/fashion_girl/Set_ao_croptop_co_sen_chan_vay_mau_xanh.jpg', '', 155000, 0, '2017-12-18', 9, '', 0),
(8, 'Heo kho Tộ', 2, 'images/fashion_girl/Dress-Materials.jpg', '', 195000, 0, '2017-12-18', 19, '', 0),
(9, 'Pizza Italya', 2, 'images/fashion_girl/Ao_khoac_kaki_hai_lop_mau_ke.jpg', '', 265000, 0, '2017-12-18', 15, '', 0),
(10, 'Mỳ ý sốt cà', 2, 'images/fashion_girl/Dam_maxi_hai_day_kem_nit.jpg', '', 315000, 0, '2017-12-18', 10, '', 0),
(11, 'Mì thịt chấm', 3, 'images/hangmoive/ao so mi.jpg', '', 225000, 0, '2017-12-18', 10, '', 0),
(12, 'Gà luộc chẩm chéo', 3, 'images/hangmoive/Dam_xoe_phoi_ren_xinh_xan_mau_trang.jpg', '', 245000, 0, '2017-12-18', 20, '', 0),
(13, 'Gỏi tai mui', 3, 'images/hangmoive/womens-georgette.jpg', '', 275000, 0, '2017-12-18', 21, '', 0),
(14, 'Trứng sốt mắm', 3, 'images/hangmoive/vest-den-cham-nho.jpg', '', 225000, 0, '2017-12-18', 17, '', 0),
(15, 'Tôm cuộn xả', 3, 'images/hangmoive/so-mi-xanh-tim-hoa-tiet-tron.jpg', '', 225000, 0, '2017-12-18', 6, '', 0),
(16, 'Bún bò đặc biệt', 3, 'images/hangmoive/Brown-Casual-Shoes.jpg', '', 235000, 0, '2017-12-18', 11, '', 0),
(17, 'Mâm ngũ vị', 3, 'images/hangmoive/Roadster-Casual-Shoes.jpg', '', 245000, 0, '2017-12-18', 13, '', 0),
(18, 'Tôm Hùm nướng', 1, 'images/shoes/adidas-alphabounce-reflective-pack-2.jpg', '', 195000, 0, '2017-12-18', 15, '', 0),
(19, 'Bò sốt Hàn Quốc', 1, 'images/shoes/dep quay hau.jpg', '', 115000, 0, '2017-12-18', 13, '', 0),
(20, 'Vịt nguyên tiêu Trung', 2, 'images/shoes/giay-cao-co-mau-nau-bong-tron.png', '', 199000, 0, '2017-12-18', 20, '', 0),
(21, 'Củ sen tương', 2, 'images/shoes/Silver-Heeled-Sandals.jpg', '', 299000, 0, '2017-12-18', 10, '', 0),
(22, 'Chân gà xả tắc', 3, 'images/hangmoive/Tan-Boots-425x498.jpg', '', 259000, 0, '2017-12-18', 10, '', 0),
(23, 'Cơm nhà trọn vị', 2, 'images/shoes/Giay the thao nu xanh.jpg', '', 169000, 0, '2017-12-18', 25, '', 0),
(24, 'Vịt nguyên tiêu Trung', 2, 'images/shoes/giay-cao-co-mau-nau-bong-tron.png', '', 269000, 0, '2017-12-18', 0, '', 0),
(25, 'Bò tái TOMOTO', 1, 'images/shoes/xanhduongfreetr5printtrainings-.jpg', '', 199000, 0, '2017-12-18', 13, '', 0),
(26, 'Gỏi Tôm', 1, 'images/shoes/xanhairzoompegasus33runningsho.jpg', '', 189000, 0, '2017-12-18', 13, '', 0),
(27, 'Sườn Nướng vị tê Cay', 2, 'images/fashion_girl/Dam_du_tiec_dun_eo_ta_xeo_mau_hong_cam.jpg', '', 219000, 0, '2017-12-18', 20, '', 0),
(28, 'Trung Thu trướng muối', 2, 'images/fashion_girl/Maternity-Store-300x351.jpg', '', 209000, 0, '2017-12-18', 30, '', 0),
(30, 'Bánh mỳ thịt nướng', 1, 'images/fashion_boy/that-lung-da-khoa-tron-cham-khac-noi.png', '', 89000, 0, '2017-12-18', 15, '', 0),
(31, 'Bún bò Huế', 1, 'images/fashion_boy/quan-au-mau-bordeaux.jpg', '', 229000, 0, '2017-12-18', 15, '', 0),
(32, 'Xôi ngũ vị', 1, 'images/fashion_boy/Cotton-Henley-T-shirt.jpg', '', 299000, 0, '2017-12-18', 12, '', 0),
(33, 'Hamberger Bò Mỹ', 2, 'images/fashion_girl/dress-f-blue.jpg', '', 239000, 0, '2017-12-22', 20, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--




-- 2. Tạo lại bảng với cấu trúc chuẩn InnoDB
CREATE TABLE `product_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Cập nhật dữ liệu mẫu khớp với bảng orders của bạn
INSERT INTO `product_order` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 12, 1, 245000),
(7, 17, 1, 245000);

-- 4. Cập nhật lại VIEW để đảm bảo lệnh SELECT trong PHP không bị lỗi
DROP VIEW IF EXISTS `view_order_list`;
CREATE VIEW `view_order_list` AS 
SELECT 
    o.id AS idOrder,
    u.fullname, u.phone, u.email,
    p.name AS nameProduct,
    po.quantity,
    o.status,
    o.date_order AS dateOrder
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN product_order po ON o.id = po.order_id
JOIN products p ON po.product_id = p.id;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `contents` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `image`, `status`) VALUES
(1, 'images/background.jpg', 0),
(2, 'images/slide/slide-3.jpg', 1),
(3, 'images/slide/slide-4.jpg', 1),
(4, 'images/slide/slide-5.jpg', 1),
(5, 'images/slide/slide-2.jpg', 1),
(6, 'images/banner/2.jpg', 2),
(7, 'images/banner/3.jpg', 2),
(8, 'images/banner/banner.jpg', 2),
(9, 'images/banner/khuyenmaithang12.png', 2),
(10, 'images/partner/partner1.png', 3),
(11, 'images/partner/partner2.png', 3),
(12, 'images/partner/partner3.png', 3),
(13, 'images/partner/partner4.png', 3),
(14, 'images/partner/partner5.png', 3),
(15, 'images/partner/partner6.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE reset_tokens (
    -- Khóa chính của bảng token
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    
    -- Cột này lưu trữ ID người dùng (từ users.id)
    user_id INT(11) NOT NULL, 
    
    -- Mã token duy nhất để đặt lại mật khẩu
    token VARCHAR(64) NOT NULL UNIQUE,
    
    -- Thời gian hết hạn của token
    expiry_time DATETIME NOT NULL,
    
    -- Thời gian tạo
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
--
-- Dumping data for table `users`
--
TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `address`, `phone`, `created`, `role`) VALUES
(29, 'Van Tiet', 'van.tit', '49CDB4C2B576011E554669632DFBD7CC', 'tiet.ho@gmail.com', 'Đà Nẵng', '0373532152', NULL, 1),
(26, 'LanNguyen', 'hilan', '5d41402abc4b2a76b9719d911017c592', 'Lannguyen10@gmail.com', 'Đà Nẵng', '123456789', NULL, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_groupby_idorder`
-- (See below for the actual view)
--
CREATE TABLE `view_groupby_idorder` (
`idOrder` int(11)
,`status` tinyint(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_order_list`
-- (See below for the actual view)
--
CREATE TABLE `view_order_list` (
`idOrder` int(11)
,`fullname` varchar(50)
,`phone` varchar(20)
,`email` varchar(100)
,`idUser` int(11)
,`address` varchar(50)
,`idProduct` int(11)
,`nameProduct` varchar(255)
,`price` float
,`saleprice` float
,`quantity` int(11)
,`status` tinyint(2)
,`dateOrder` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `view_groupby_idorder`
--
DROP TABLE IF EXISTS `view_groupby_idorder`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_groupby_idorder`  AS  select `orders`.`id` AS `idOrder`,`orders`.`status` AS `status` from (((`orders` join `users` on((`orders`.`user_id` = `users`.`id`))) join `product_order` on((`product_order`.`order_id` = `orders`.`id`))) join `products` on((`product_order`.`product_id` = `products`.`id`))) group by `orders`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_order_list`
--
DROP TABLE IF EXISTS `view_order_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_order_list`  AS  select `orders`.`id` AS `idOrder`,`users`.`fullname` AS `fullname`,`users`.`phone` AS `phone`,`users`.`email` AS `email`,`users`.`id` AS `idUser`,`users`.`address` AS `address`,`products`.`id` AS `idProduct`,`products`.`name` AS `nameProduct`,`products`.`price` AS `price`,`products`.`saleprice` AS `saleprice`,`product_order`.`quantity` AS `quantity`,`orders`.`status` AS `status`,`orders`.`date_order` AS `dateOrder` from (((`orders` join `users` on((`orders`.`user_id` = `users`.`id`))) join `product_order` on((`product_order`.`order_id` = `orders`.`id`))) join `products` on((`product_order`.`product_id` = `products`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

