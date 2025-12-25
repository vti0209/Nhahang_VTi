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
-- DANH MỤC 1: dacsan_Viet (Chỉ chứa ảnh trong thư mục dacsan_Viet)
(1, 'Bún bò Huế', 1, 'images/dacsan_Viet/bunbo-hue.jpg', 'Hương vị đậm đà đặc trưng của mắm ruốc và sợi bún to chuẩn vị cố đô.', 180000, 5, '2017-12-18', 5, '', 0),
(2, 'Cơm Cháy', 1, 'images/dacsan_Viet/com-chay.jpg', 'Cơm cháy giòn tan kết hợp cùng chà bông và mỡ hành thơm ngậy.', 290000, 0, '2017-12-18', 8, '', 0),
(3, 'Cao Lầu Hội An', 1, 'images/dacsan_Viet/caolau-hoian.jpg', 'Sợi mì vàng óng ăn kèm thịt xá xíu và rau sống Trà Quế tươi ngon.', 210000, 10, '2017-12-18', 10, '', 0),
(4, 'Lẩu Mắm Miền Tây', 1, 'images/dacsan_Viet/laumam-mientay.jpg', 'Món lẩu trứ danh miền sông nước với hương vị mắm cá linh, cá sặc nồng nàn.', 180000, 0, '2017-12-18', 7, '', 0),
(5, 'Bánh tráng cuốn thịt', 1, 'images/dacsan_Viet/banhtrangcuon.jpg', 'Thịt heo luộc thái mỏng cuốn cùng rau sống và mắm nêm đậm đà.', 250000, 15, '2017-12-18', 12, '', 0),
(30, 'Bánh mỳ thịt nướng', 1, 'images/dacsan_Viet/banh-mythit-nuong.png', 'Bánh mì giòn rụm kẹp thịt nướng thơm lừng và đồ chua tươi mát.', 89000, 0, '2017-12-18', 15, '', 0),
(31, 'Bún bò Huế', 1, 'images/dacsan_Viet/bun-bo.jpg', 'Hương vị bún bò chuẩn gốc Huế, cay nồng và đậm đà khó quên.', 229000, 0, '2017-12-18', 15, '', 0),
(32, 'Xôi ngũ vị', 1, 'images/dacsan_Viet/xoi-nguvi.jpg', 'Xôi nếp dẻo thơm với 5 màu sắc tự nhiên và topping đa dạng.', 299000, 0, '2017-12-18', 12, '', 0),
(37, 'Mỳ Tôm Thượng hạng', 1, 'images/dacsan_Viet/mytom-dacbiet.jpg', 'Nâng tầm món mỳ tôm quen thuộc với hải sản tươi và nước dùng đặc biệt.', 189000, 0, '2017-12-18', 15, '', 0),
(38, 'Bún thịt nướng', 1, 'images/dacsan_Viet/bunthit-nuong.jpg', 'Thịt nướng thơm mùi sả, ăn kèm bún tươi và nước mắm chua ngọt.', 99000, 0, '2017-12-18', 15, '', 0),
(39, 'Thắng cố heo', 1, 'images/dacsan_Viet/thang-co.jpg', 'Đặc sản vùng cao với hương vị độc bản từ các loại gia vị núi rừng.', 82000, 0, '2017-12-18', 15, '', 0),
(40, 'Lòng chiên chẩm chéo', 1, 'images/dacsan_Viet/long-chien.png', 'Lòng heo chiên vàng giòn, chấm cùng chẩm chéo cay tê đặc trưng.', 189000, 0, '2017-12-18', 15, '', 0),
(41, 'Phồng tôm', 1, 'images/dacsan_Viet/phong-tom.jpg', 'Bánh phồng tôm giòn tan, món khai vị không thể thiếu trong mỗi bữa tiệc.', 30000, 0, '2017-12-18', 15, '', 0),

-- DANH MỤC 2: dacsan_nuocNgoai (Chỉ chứa ảnh trong thư mục dacsan_nuocNgoai)
(6, 'Trứng Ngâm tương', 2, 'images/dacsan_nuocNgoai/trungngam.jpg', 'Trứng lòng đào béo ngậy thấm đẫm sốt tương Hàn Quốc ngọt thanh.', 165000, 5, '2017-12-18', 15, '', 0),
(7, 'Toboki Hàn', 2, 'images/dacsan_nuocNgoai/tokboki.jpg', 'Bánh gạo dẻo dai hòa quyện cùng sốt cay nồng chuẩn vị Seoul.', 155000, 10, '2017-12-18', 9, '', 0),
(8, 'Heo kho Tộ', 2, 'images/dacsan_nuocNgoai/heokho-tau.jpg', 'Thịt heo kho mềm rục, màu cánh gián đẹp mắt và hương vị đưa cơm.', 195000, 15, '2017-12-18', 19, '', 0),
(9, 'Pizza Italya', 2, 'images/dacsan_nuocNgoai/pizza.jpg', 'Đế bánh giòn tan phủ đầy phô mai tan chảy và nhân topping phong phú.', 265000, 0, '2017-12-18', 15, '', 0),
(10, 'Mỳ ý sốt cà', 2, 'images/dacsan_nuocNgoai/my-y.jpg', 'Sợi mỳ dai mềm hòa quyện cùng sốt cà chua tươi và thịt bằm thơm ngon.', 315000, 0, '2017-12-18', 10, '', 0),
(27, 'Sườn Nướng vị tê Cay', 2, 'images/dacsan_nuocNgoai/suon-nuong.jpg', 'Sườn heo nướng xèo xèo với sốt tê cay chuẩn vị Tứ Xuyên.', 219000, 0, '2017-12-18', 20, '', 0),
(28, 'Trung Thu trướng muối', 2, 'images/dacsan_nuocNgoai/trung-thu.jpg', 'Bánh trung thu nhân trứng muối tan chảy, ngọt thanh không ngán.', 209000, 0, '2017-12-18', 30, '', 0),
(33, 'Hamberger Bò Mỹ', 2, 'images/dacsan_nuocNgoai/hamber.jpg', 'Nhân bò Mỹ nướng mọng nước kết hợp cùng phô mai và rau tươi.', 239000, 0, '2017-12-22', 20, '', 0),
(42, 'Bánh kem Plan', 2, 'images/dacsan_nuocNgoai/banh-plan.jpg', 'Lớp kem mịn màng hòa quyện cùng caramel ngọt đắng tinh tế.', 235000, 0, '2017-12-22', 20, '', 0),
(43, 'Bánh dâu Tây', 2, 'images/dacsan_nuocNgoai/banh-cuon-dau.jpg', 'Vị chua thanh của dâu tây kết hợp lớp vỏ bánh mềm mại, ngọt ngào.', 279000, 0, '2017-12-22', 20, '', 0),
(44, 'Hả Cảo', 2, 'images/dacsan_nuocNgoai/ha-cao.jpg', 'Lớp vỏ trong suốt bao bọc nhân tôm thịt đậm đà chuẩn vị Dimsum.', 230000, 0, '2017-12-22', 20, '', 0),
(45, 'Cơm cuộn Hàn', 2, 'images/dacsan_nuocNgoai/com-cuon.jpg', 'Kimbap truyền thống với đầy đủ rau củ, trứng và xúc xích.', 139000, 0, '2017-12-22', 20, '', 0),
(46, 'Tua mực sốt cà', 2, 'images/dacsan_nuocNgoai/tua-muc.jpg', 'Tua mực giòn sần sật thấm đẫm sốt cà chua đậm đà, hấp dẫn.', 439000, 0, '2017-12-22', 20, '', 0),
(47, 'Hotdog Phô Mai', 2, 'images/dacsan_nuocNgoai/hotdog.jpg', 'Lớp vỏ chiên xù giòn rụm bao quanh nhân phô mai kéo sợi cực đã.', 299000, 0, '2017-12-22', 20, '', 0),

-- DANH MỤC 3: amThucHot (Chỉ chứa ảnh trong thư mục amThucHot)
(11, 'Mì thịt chấm', 3, 'images/amThucHot/01.jpg', 'Sự kết hợp độc đáo giữa mì sợi và nước sốt thịt chấm đậm đà.', 225000, 5, '2017-12-18', 10, '', 0),
(12, 'Gà luộc chẩm chéo', 3, 'images/amThucHot/02.jpg', 'Thịt gà ta thả vườn dai ngọt chấm cùng gia vị chẩm chéo Tây Bắc.', 245000, 10, '2017-12-18', 20, '', 0),
(13, 'Gỏi tai mui', 3, 'images/amThucHot/03.jpg', 'Vị giòn sần sật của tai heo trộn cùng mắm chua ngọt và rau thơm.', 275000, 15, '2017-12-18', 21, '', 0),
(14, 'Trứng sốt mắm', 3, 'images/amThucHot/04.jpg', 'Món ăn giản dị nhưng cực kỳ bắt cơm với sốt mắm tỏi ớt cay nhẹ.', 225000, 0, '2017-12-18', 17, '', 0),
(15, 'Tôm cuộn xả', 3, 'images/amThucHot/05.jpg', 'Tôm tươi ngọt thịt được cuộn sả nướng thơm lừng đầy kích thích.', 225000, 0, '2017-12-18', 6, '', 0),
(16, 'Bún bò đặc biệt', 3, 'images/amThucHot/06.jpg', 'Phiên bản nâng cấp với đầy đủ topping bò tái, nạm, gầu và chả cua.', 235000, 0, '2017-12-18', 11, '', 0),
(17, 'Mâm ngũ vị', 3, 'images/amThucHot/07.jpg', 'Tổng hòa 5 món ngon đặc sắc mang lại trải nghiệm ẩm thực đa dạng.', 245000, 0, '2017-12-18', 13, '', 0),
(22, 'Chân gà xả tắc', 3, 'images/amThucHot/08.jpg', 'Món ăn vặt "quốc dân" với vị chua, cay, mặn, ngọt cực kỳ hấp dẫn.', 259000, 0, '2017-12-18', 10, '', 0),

-- DANH MỤC 4: monKhachChon (Tách riêng danh mục số 4 cho dễ quản lý)
(18, 'Tôm Hùm nướng', 4, 'images/MonKhachChon/tom.jpg', 'Tôm hùm nướng bơ tỏi thơm nức mũi.', 195000, 0, '2017-12-18', 15, '', 0),
(19, 'Bò sốt Hàn Quốc', 4, 'images/MonKhachChon/bo-sot.jpg', 'Thịt bò mềm mại được tẩm ướp sốt Bulgogi đặc trưng.', 115000, 0, '2017-12-18', 13, '', 0),
(20, 'Vịt nguyên tiêu Trung', 4, 'images/MonKhachChon/vit.jpg', 'Vịt quay thơm mùi tiêu đen theo phong cách Trung Hoa.', 199000, 0, '2017-12-18', 20, '', 0),
(21, 'Củ sen tương', 4, 'images/MonKhachChon/cu-sen.jpg', 'Món chay thanh đạm với củ sen giòn ngọt kho tương.', 299000, 0, '2017-12-18', 10, '', 0),
(23, 'Cơm nhà trọn vị', 4, 'images/MonKhachChon/comtron-vi.jpg', 'Mâm cơm ấm cúng với những món ăn thân quen như mẹ nấu.', 169000, 0, '2017-12-18', 25, '', 0),
(24, 'Vịt nguyên tiêu Trung', 4, 'images/MonKhachChon/vitnguyen-tieu.jpg', 'Vịt quay thảo mộc thơm nồng hạt tiêu, thịt ngọt lịm.', 269000, 0, '2017-12-18', 0, '', 0),
(25, 'Bò tái TOMOTO', 4, 'images/MonKhachChon/bo-tai.jpg', 'Thịt bò tươi ngon thái mỏng, giữ trọn vị ngọt tự nhiên.', 199000, 0, '2017-12-18', 13, '', 0),
(26, 'Gỏi Tôm', 4, 'images/MonKhachChon/goi-tom.jpg', 'Tôm tươi kết hợp cùng ngó sen tạo nên vị chua ngọt hài hòa.', 189000, 0, '2017-12-18', 13, '', 0),
(34, 'Ghẹ chiên', 4, 'images/MonKhachChon/ghe-chien.jpg', 'Ghẹ tươi chiên giòn, thơm nồng vị biển.', 299000, 0, '2017-12-18', 13, '', 0),
(35, 'Combo-nem, trứng,...', 4, 'images/MonKhachChon/combo-nuong.jpg', 'Mẹt đồ nướng tổng hợp đa dạng cho buổi tụ tập.', 399000, 0, '2017-12-18', 13, '', 0),
(36, 'Bò thượng hạng', 4, 'images/MonKhachChon/bo-sodiep.jpg', 'Phần bò thượng hạng mềm tan ngay đầu lưỡi.', 599000, 0, '2017-12-18', 13, '', 0);

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
(29, 'Van Tiet', 'van.tit', '49CDB4C2B576011E554669632DFBD7CC', 'tiet.ho27@student.passerellesnumeriques.org', 'Đà Nẵng', '0373532152', NULL, 1),
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

