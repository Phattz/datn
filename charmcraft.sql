-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 03, 2025 lúc 04:51 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `datn`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banner`
--

INSERT INTO `banner` (`id`, `image`) VALUES
(1, 'bannerPhu.jpg'),
(2, 'bannerSlide1.jpg'),
(3, 'bannerSlide2.jpg'),
(4, 'bannerSlide3.jpg'),
(5, 'bannerSlide4.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`) VALUES
(1, 'Gương', 1),
(2, 'Trang sức', 1),
(3, 'Mũ', 1),
(4, 'Túi', 1),
(5, 'Phụ kiện', 1),
(6, 'Khăn', 1),
(7, 'ví', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `nameColor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`id`, `nameColor`) VALUES
(1, 'Xanh lá'),
(2, 'Trắng'),
(3, 'Đen'),
(4, 'Đỏ'),
(5, 'Xanh dương'),
(6, 'Đen tím'),
(7, 'Hồng'),
(8, 'Xanh biển'),
(9, 'Nâu'),
(10, 'Trắng xanh'),
(11, 'Trắng đỏ'),
(12, 'Nâu hồng'),
(13, 'Trắng xanh lá mạ'),
(14, 'Vàng'),
(15, 'Bạc'),
(16, 'Tím'),
(17, 'Hồng đào'),
(18, 'xanh lá'),
(19, 'Vàng, xanh dương'),
(20, 'Cam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `idProductDetail` int(11) DEFAULT NULL,
  `idOrder` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `salePrice` int(11) DEFAULT NULL,
  `reviewContent` text DEFAULT NULL,
  `ratingStar` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `shippingAddress` varchar(255) DEFAULT NULL,
  `idVoucher` int(11) DEFAULT NULL,
  `receiverPhone` varchar(20) DEFAULT NULL,
  `receiverName` varchar(100) DEFAULT NULL,
  `idPayment` int(11) DEFAULT NULL,
  `totalPrice` int(11) DEFAULT NULL,
  `orderStatus` varchar(50) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productcomment`
--

CREATE TABLE `productcomment` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `dateComment` datetime DEFAULT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productdetail`
--

CREATE TABLE `productdetail` (
  `id` int(11) NOT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `stockQuantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `idColor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productdetail`
--

INSERT INTO `productdetail` (`id`, `idProduct`, `stockQuantity`, `price`, `idColor`) VALUES
(45, 1, 30, 50000, 15),
(46, 1, 30, 50000, 14),
(51, 2, 30, 120000, 3),
(52, 2, 30, 120000, 2),
(57, 3, 30, 40000, 9),
(58, 3, 30, 40000, 2),
(81, 7, 30, 265000, 14),
(82, 7, 30, 265000, 5),
(87, 8, 30, 60000, 14),
(88, 8, 30, 60000, 5),
(93, 9, 30, 60000, 14),
(94, 9, 30, 60000, 5),
(99, 10, 30, 40000, 14),
(100, 10, 30, 40000, 5),
(105, 11, 30, 60000, 14),
(106, 11, 30, 60000, 5),
(111, 12, 30, 200000, 14),
(112, 12, 30, 200000, 5),
(113, 12, 30, 205000, 14),
(114, 12, 30, 205000, 5),
(115, 12, 30, 210000, 14),
(116, 12, 30, 210000, 5),
(117, 13, 30, 250000, 14),
(118, 13, 30, 250000, 5),
(119, 13, 30, 255000, 14),
(120, 13, 30, 255000, 5),
(121, 13, 30, 260000, 14),
(122, 13, 30, 260000, 5),
(123, 14, 30, 250000, 14),
(124, 14, 30, 250000, 5),
(125, 14, 30, 255000, 14),
(126, 14, 30, 255000, 5),
(127, 14, 30, 260000, 14),
(128, 14, 30, 260000, 5),
(129, 15, 30, 250000, 14),
(130, 15, 30, 250000, 5),
(131, 15, 30, 255000, 14),
(132, 15, 30, 255000, 5),
(133, 15, 30, 260000, 14),
(134, 15, 30, 260000, 5),
(135, 16, 30, 250000, 14),
(136, 16, 30, 250000, 5),
(137, 16, 30, 255000, 14),
(138, 16, 30, 255000, 5),
(139, 16, 30, 260000, 14),
(140, 16, 30, 260000, 5),
(141, 17, 30, 250000, 14),
(142, 17, 30, 250000, 5),
(143, 17, 30, 255000, 14),
(144, 17, 30, 255000, 5),
(145, 17, 30, 260000, 14),
(146, 17, 30, 260000, 5),
(147, 18, 30, 270000, 14),
(148, 18, 30, 270000, 5),
(149, 18, 30, 275000, 14),
(150, 18, 30, 275000, 5),
(151, 18, 30, 280000, 14),
(152, 18, 30, 280000, 5),
(153, 19, 30, 250000, 14),
(154, 19, 30, 250000, 5),
(155, 19, 30, 255000, 14),
(156, 19, 30, 255000, 5),
(157, 19, 30, 260000, 14),
(158, 19, 30, 260000, 5),
(159, 20, 30, 200000, 14),
(160, 20, 30, 200000, 5),
(161, 20, 30, 205000, 14),
(162, 20, 30, 205000, 5),
(163, 20, 30, 210000, 14),
(164, 20, 30, 210000, 5),
(165, 21, 30, 180000, 14),
(166, 21, 30, 180000, 5),
(167, 21, 30, 185000, 14),
(168, 21, 30, 185000, 5),
(169, 21, 30, 190000, 14),
(170, 21, 30, 190000, 5),
(171, 22, 30, 180000, 14),
(172, 22, 30, 180000, 5),
(173, 22, 30, 185000, 14),
(174, 22, 30, 185000, 5),
(175, 22, 30, 190000, 14),
(176, 22, 30, 190000, 5),
(177, 23, 30, 100000, 14),
(178, 23, 30, 100000, 5),
(179, 23, 30, 105000, 14),
(180, 23, 30, 105000, 5),
(181, 23, 30, 110000, 14),
(182, 23, 30, 110000, 5),
(183, 24, 30, 150000, 14),
(184, 24, 30, 150000, 5),
(185, 24, 30, 155000, 14),
(186, 24, 30, 155000, 5),
(187, 24, 30, 160000, 14),
(188, 24, 30, 160000, 5),
(189, 25, 30, 200000, 14),
(190, 25, 30, 200000, 5),
(191, 25, 30, 205000, 14),
(192, 25, 30, 205000, 5),
(193, 25, 30, 210000, 14),
(194, 25, 30, 210000, 5),
(195, 26, 30, 220000, 14),
(196, 26, 30, 220000, 5),
(197, 26, 30, 225000, 14),
(198, 26, 30, 225000, 5),
(199, 26, 30, 230000, 14),
(200, 26, 30, 230000, 5),
(201, 4, 30, 40000, 2),
(202, 4, 30, 40000, 11),
(203, 4, 30, 45000, 2),
(204, 4, 30, 45000, 11),
(205, 4, 30, 50000, 2),
(206, 4, 30, 50000, 11),
(207, 5, 30, 60000, 17),
(208, 5, 30, 60000, 13),
(209, 5, 30, 65000, 17),
(210, 5, 30, 65000, 13),
(211, 5, 30, 70000, 17),
(212, 5, 30, 70000, 13),
(213, 6, 30, 65000, 13),
(214, 6, 30, 65000, 14),
(215, 6, 30, 70000, 13),
(216, 6, 30, 70000, 14),
(217, 6, 30, 75000, 13),
(218, 6, 30, 75000, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hot` tinyint(4) DEFAULT NULL,
  `status` int(4) NOT NULL,
  `view` int(11) NOT NULL,
  `idCategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `description`, `hot`, `status`, `view`, `idCategory`) VALUES
(1, 'guong-mori.jpg', 'Gương mori', NULL, NULL, 1, 53, 1),
(2, 'guong-theu-hoa.jpg', 'Gương thêu hoa', NULL, NULL, 1, 3, 1),
(3, 'cot-toc-theu.jpg', 'Cột tóc thêu', NULL, NULL, 1, 0, 5),
(4, 'moc-khoa-go-vai.jpg', 'Móc khóa gỗ vải', NULL, NULL, 1, 0, 5),
(5, 'moc-khoa-len.jpg', 'Móc khóa len', NULL, NULL, 1, 0, 5),
(6, 'khan-bandana.jpg', 'Khăn bandana', NULL, NULL, 1, 0, 6),
(7, 'cot-srunchies.jpg', 'Cột Srunchies', NULL, NULL, 1, 0, 5),
(8, 'hong-ngoc-lua.jpg', 'Hồng Ngọc Lửa', NULL, NULL, 1, 0, 2),
(9, 'ngoc-xanh-dai-duong.jpg', 'Ngọc xanh đại dương', NULL, NULL, 1, 0, 2),
(10, 'vong-day-basic.jpg', 'Vòng dây basic', NULL, NULL, 1, 0, 2),
(11, 'luc-lac-huyen-bi.jpg', 'Lục lạc huyền bí', NULL, NULL, 1, 0, 2),
(12, 'combo-basic.jpg', 'Combo basic', NULL, NULL, 1, 0, 2),
(13, 'combo-da-hong.jpg', 'Combo đá hồng', NULL, NULL, 1, 0, 2),
(14, 'combo-da-day-trang.jpg', 'Combo đá, dây trắng', NULL, NULL, 1, 0, 2),
(15, 'combo-da-day-den.jpg', 'Combo đá dây đen', NULL, NULL, 1, 0, 2),
(16, 'combo-da-xanh.jpg', 'Combo đá xanh', NULL, NULL, 1, 0, 2),
(17, 'combo-da-day-nau1.jpg', 'Combo đá dây nâu', NULL, NULL, 1, 2, 2),
(18, 'tui-hoa-len.jpg', 'Túi hoa len', NULL, NULL, 1, 0, 4),
(19, 'tui-popcorn-len.jpg', 'Túi popcorn len', NULL, NULL, 1, 0, 4),
(20, 'tui-cinta-len.jpg', 'Túi Cinta len', NULL, NULL, 1, 0, 4),
(21, 'tui-vuong-len.jpg', 'Túi vuông len', NULL, NULL, 1, 1, 4),
(22, 'tui-tote-len.jpg', 'Túi tote len', NULL, NULL, 1, 0, 4),
(23, 'tui-2-day-nho-len.jpg', 'Túi 2 dây nhỏ len', NULL, NULL, 1, 0, 4),
(24, 'tui-xach-tay-nho-len.jpg', 'Túi xách tay nhỏ len', NULL, NULL, 1, 3, 4),
(25, 'tui-shouder-len.jpg', 'Túi shouder len', NULL, NULL, 1, 24, 4),
(26, 'non-len.jpg', 'Nón len', NULL, NULL, 1, 12, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT 0,
  `active` int(1) NOT NULL DEFAULT 0,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `address`, `email`, `password`, `role`, `active`, `dateCreate`, `code`) VALUES
(12, 'Quang Huy', '0969894160', NULL, 'qhuy112002@gmail.com', '873a6c53cff341c414378de81f75c45a', 0, 1, '2025-11-27 00:29:01', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discountType` varchar(50) DEFAULT NULL,
  `applyType` varchar(50) DEFAULT NULL,
  `dateStart` date DEFAULT NULL,
  `dateEnd` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher`
--

INSERT INTO `voucher` (`id`, `name`, `description`, `discountType`, `applyType`, `dateStart`, `dateEnd`, `status`) VALUES
(1, 'GIAM10', 'Giảm 10% cho toàn bộ đơn hàng', 'percent', 'order', '2025-01-01', '2025-12-31', 1),
(2, 'FREESHIP20', 'Giảm 20% phí vận chuyển', 'percent', 'shipping', '2025-01-01', '2025-12-31', 1),
(3, 'SALE50K', 'Giảm 50.000đ cho đơn hàng từ 300k', 'fixed', 'order', '2025-01-01', '2025-12-31', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProductDetail` (`idProductDetail`),
  ADD KEY `idOrder` (`idOrder`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idVoucher` (`idVoucher`),
  ADD KEY `idPayment` (`idPayment`),
  ADD KEY `idUser` (`idUser`);

--
-- Chỉ mục cho bảng `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `productcomment`
--
ALTER TABLE `productcomment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProduct` (`idProduct`),
  ADD KEY `idUser` (`idUser`);

--
-- Chỉ mục cho bảng `productdetail`
--
ALTER TABLE `productdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProduct` (`idProduct`),
  ADD KEY `idMaterial` (`idColor`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategory` (`idCategory`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `productcomment`
--
ALTER TABLE `productcomment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `productdetail`
--
ALTER TABLE `productdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`idProductDetail`) REFERENCES `productdetail` (`id`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idVoucher`) REFERENCES `voucher` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`idPayment`) REFERENCES `paymentmethod` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `productcomment`
--
ALTER TABLE `productcomment`
  ADD CONSTRAINT `productcomment_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `productcomment_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `productdetail`
--
ALTER TABLE `productdetail`
  ADD CONSTRAINT `productdetail_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `productdetail_ibfk_3` FOREIGN KEY (`idColor`) REFERENCES `colors` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
