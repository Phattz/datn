-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 03, 2025 lúc 11:21 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `charmcraft`
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
(1, 'CHARMCRAFT.png'),
(2, 'CHARM CRAFT.png'),
(3, 'CHARMCRAFT1.png'),
(4, 'CHARMCRAFT2.png'),
(5, 'bannerSlide4.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `dateFavorite` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `favorite`
--

INSERT INTO `favorite` (`id`, `dateFavorite`, `idUser`, `idProduct`) VALUES
(33, '2024-12-04 00:55:02', 25, 68);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceItem` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orderitems`
--

INSERT INTO `orderitems` (`id`, `quantity`, `priceItem`, `idProduct`, `idOrder`) VALUES
(11, 1, 180000, 70, 1),
(12, 1, 60000, 47, 1),
(13, 1, 50000, 39, 1),
(14, 5, 120000, 40, 2),
(15, 4, 40000, 41, 2),
(16, 1, 50000, 39, 3),
(17, 5, 50000, 39, 4),
(18, 2, 40000, 41, 4),
(19, 2, 60000, 47, 4),
(20, 1, 50000, 39, 5),
(21, 2, 40000, 49, 5),
(22, 2, 30000, 42, 5),
(23, 1, 260000, 75, 6),
(24, 1, 260000, 75, 7),
(25, 1, 260000, 75, 8),
(26, 1, 100000, 72, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `dateOrder` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalPrice` int(11) NOT NULL,
  `noteUser` text NOT NULL,
  `noteAdmin` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `payment` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `dateOrder`, `totalPrice`, `noteUser`, `noteAdmin`, `name`, `address`, `phone`, `payment`, `status`, `idUser`) VALUES
(1, '2024-11-30 04:40:27', 290000, '', NULL, 'Trần Mai Tiến Phát', 'Ấp Phước Thạnh', '0775804665', 1, 1, 25),
(2, '2024-12-02 16:04:55', 760000, '', NULL, 'Trần Mai Tiến Phát', 'Gò Vấp', '0933333333', 1, 1, 25),
(3, '2024-12-03 12:01:21', 50000, '', NULL, 'Trần Mai Tiến Phát', 'Vũng Tàu', '0907828399', 1, 1, 25),
(4, '2024-12-03 13:37:23', 450000, '', NULL, 'Trần Mai Tiến Phát', 'Ấp Tư Bản', '0935839435', 1, 1, 25),
(5, '2024-12-04 01:54:50', 190000, '', NULL, 'Trần Mai Tiến Phát', 'Cà Mau', '0933661897', 1, 1, 25),
(6, '2025-08-09 10:31:58', 260000, 'asdasd', NULL, 'Trần Mai Tiến Phát', 'Bình Tân', '0775804665', 1, 1, 25),
(7, '2025-08-09 10:50:00', 260000, 'hi', NULL, 'Trần phat', 'quận 12,hồ chí minh', '0775804665', 1, 1, 25),
(8, '2025-11-15 09:35:15', 260000, '1', NULL, 'Trần phat', 'quận 12,hồ chí minh', '0775804665', 1, 1, 25),
(9, '2025-12-03 10:07:56', 100000, '', NULL, 'a', 'quận 12,hồ chí minh', '0775804665', 1, 1, 28);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `datePost` date NOT NULL,
  `view` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `idCatePost` int(11) NOT NULL,
  `idUserPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`id`, `title`, `text`, `image`, `datePost`, `view`, `description`, `status`, `idCatePost`, `idUserPost`) VALUES
(1, 'Khăn Bandana Handmade Sunflower', '<ul class=\"productPost-details\">\r\n                                <li><strong>Chất liệu:</strong> Sợi len cotton tự nhiên mềm mại, thoáng khí, và cực kỳ dễ chịu khi tiếp xúc với da, mang đến cảm giác thư giãn tuyệt đối.</li>\r\n                                <li><strong>Màu sắc:</strong> Nền trắng kem tinh tế kết hợp với họa tiết hoa hướng dương vàng rực rỡ, tạo nên một sự kết hợp hoàn hảo giữa sự nhẹ nhàng và nổi bật.</li>\r\n                                <li><strong>Kích thước:</strong> 55 x 55 cm (có thể điều chỉnh theo yêu cầu, rất linh hoạt để phù hợp với phong cách và nhu cầu sử dụng của bạn).</li>\r\n                                <li><strong>Khối lượng:</strong> 200g (vừa phải, không quá nặng nhưng đủ để bạn cảm nhận sự mềm mại và chất lượng của sản phẩm).</li>\r\n                            </ul>\r\n                    \r\n                            <!-- Công dụng -->\r\n                            <div class=\"productPost-usage\">\r\n                                <h2>Công dụng tuyệt vời của khăn Bandana</h2>\r\n                                <p class=\"check-item\"><strong>Phụ kiện thời trang đa năng:</strong> Không chỉ là một món đồ phụ kiện đơn giản, khăn Bandana Handmade Sunflower chính là điểm nhấn giúp bạn tạo dựng phong cách riêng biệt. Bạn có thể quàng nó quanh cổ để giữ ấm trong những buổi chiều thu mát mẻ, hoặc dùng làm băng đô cài tóc để tôn lên vẻ dịu dàng và thanh thoát. Chưa hết, khăn còn có thể được dùng để buộc túi xách hoặc thắt lưng, tạo nên sự cá tính và khác biệt, giúp bạn tỏa sáng trong mọi hoàn cảnh.</p>\r\n                                <!-- Thêm các công dụng khác ở đây -->\r\n                            </div>\r\n                    \r\n                            <!-- Ý nghĩa sản phẩm -->\r\n                            <div class=\"productPost-meaning\">\r\n                                <h2>Ý nghĩa sâu sắc của khăn Bandana Handmade Sunflower</h2>\r\n                                <p class=\"check-item\"><strong>Tôn vinh sự sáng tạo và thủ công tinh xảo:</strong> Mỗi chiếc khăn Bandana không chỉ là một món đồ thời trang mà còn là một tác phẩm nghệ thuật, được tạo ra từ đôi bàn tay khéo léo của những nghệ nhân thủ công. Họa tiết hoa hướng dương, được thêu tay cẩn thận, không chỉ mang đến vẻ đẹp thanh thoát mà còn chứa đựng những giá trị tinh thần. Hoa hướng dương là biểu tượng của sự lạc quan, sức sống và hy vọng, khiến chiếc khăn trở thành một món đồ không thể thiếu trong bộ sưu tập của những người yêu thích sự tinh tế và ý nghĩa sâu sắc.</p>\r\n                                <p class=\"check-item\"><strong>Gắn kết con người với thiên nhiên:</strong> Được làm từ sợi len tự nhiên, chiếc khăn mang lại cảm giác mềm mại, thoải mái và thân thiện với làn da. Không chỉ vậy, sự hiện diện của hoa hướng dương trên chiếc khăn khiến bạn cảm nhận được sự gần gũi với thiên nhiên, như một lời nhắc nhở về vẻ đẹp thuần khiết của thế giới xung quanh. Chiếc khăn không chỉ đẹp về hình thức mà còn mang trong mình một thông điệp về sự hòa hợp giữa con người và thiên nhiên.</p>\r\n                                <p class=\"check-item\"><strong>Hướng tới phong cách sống bền vững:</strong> Trong một thế giới đang ngày càng chú trọng đến việc bảo vệ môi trường, khăn Bandana Handmade Sunflower là sản phẩm lý tưởng cho những ai đang tìm kiếm những món đồ vừa đẹp mắt vừa thân thiện với hành tinh. Chất liệu len cotton tự nhiên, an toàn và tái chế, giúp giảm thiểu tác động tiêu cực đến môi trường. Đây là một món đồ không chỉ có giá trị về mặt thời trang mà còn thể hiện cam kết sống bền vững của bạn.</p>\r\n                                <p class=\"check-item\"><strong>Vẻ đẹp tinh tế nhưng gần gũi:</strong> Khăn Bandana Handmade Sunflower không cần phải quá cầu kỳ để thể hiện sự sang trọng. Với thiết kế đơn giản nhưng đầy cảm hứng, khăn mang đến vẻ đẹp tinh tế và gần gũi, phù hợp với nhiều đối tượng người dùng. Đây là sự kết hợp hoàn hảo giữa giá trị thủ công truyền thống và xu hướng thời trang hiện đại, mang lại một sản phẩm vừa đẹp vừa có ý nghĩa.</p>\r\n                            </div>\r\n\r\n                            <div class=\"productPost-additional\">\r\n                                <h2>Tại sao bạn nên sở hữu khăn Bandana Handmade này?</h2>\r\n                                <p class=\"check-item\"><strong>Thiết kế độc đáo:</strong> Mỗi chiếc khăn Bandana Handmade Sunflower là một tác phẩm nghệ thuật đặc biệt, với từng họa tiết hoa hướng dương được thêu tay tỉ mỉ. Chính vì vậy, mỗi chiếc khăn đều mang một phong cách riêng biệt, không giống bất kỳ sản phẩm nào khác. Đây chính là điểm nhấn giúp bạn thể hiện cá tính và phong cách riêng biệt của mình.</p>\r\n                                <p class=\"check-item\"><strong>Độ bền vượt trội:</strong> Với chất liệu sợi len cotton tự nhiên, chiếc khăn không chỉ mềm mại mà còn rất bền, không dễ bị hư hỏng hay phai màu theo thời gian. Bạn có thể sử dụng chiếc khăn này hàng ngày mà không phải lo lắng về độ bền của nó.</p>\r\n                                <p class=\"check-item\"><strong>Dễ dàng bảo quản:</strong> Một trong những ưu điểm lớn của khăn Bandana là sự dễ dàng trong việc bảo quản. Bạn có thể giặt tay hoặc giặt máy ở chế độ nhẹ mà không lo sợi vải bị xơ hay mất màu. Khăn vẫn giữ được hình dáng và vẻ đẹp nguyên vẹn sau nhiều lần giặt.</p>\r\n                                <p class=\"check-item\"><strong>Phong cách thời thượng:</strong> Khăn Bandana Handmade Sunflower là món đồ không thể thiếu trong tủ đồ của những người yêu thích thời trang. Nó không chỉ làm nổi bật phong cách của bạn mà còn giúp bạn luôn tự tin và thu hút ánh nhìn trong mọi dịp.</p>\r\n                                <p class=\"check-item\"><strong>Phụ kiện không lỗi mốt:</strong> Đây là sản phẩm lý tưởng cho mọi mùa trong năm. Với thiết kế vượt thời gian và dễ dàng kết hợp với mọi trang phục, khăn Bandana Handmade Sunflower sẽ luôn là món đồ yêu thích và không bao giờ lỗi mốt.</p>\r\n                            </div>', 'khan-bandana.jpg', '2024-11-25', 10, 'Khăn bandana len tại CHARM CARFT kết hợp ấm áp và thời trang. Chất liệu len mềm mịn giúp bạn giữ ấm và tạo điểm nhấn cho trang phục. Phù hợp với nhiều phong cách, khăn bandana là phụ kiện không thể thiếu cho vẻ ngoài năng động và sành điệu.', 1, 2, 25),
(2, 'Túi Handmade Shoulder Len', '<ul class=\"productPost-details\">\r\n                    <li><strong>Chất liệu:</strong> Sợi len cotton tự nhiên, mềm mại và bền bỉ, mang đến cảm giác thoải mái khi sử dụng.</li>\r\n                    <li><strong>Màu sắc:</strong> Trắng tinh khiết, dễ dàng phối hợp với nhiều trang phục khác nhau, mang đến vẻ đẹp trang nhã và tinh tế.</li>\r\n                    <li><strong>Kích thước:</strong> 25 x 20 x 10 cm, phù hợp với nhu cầu sử dụng hàng ngày, dễ dàng mang theo mọi lúc mọi nơi.</li>\r\n                    <li><strong>Khối lượng:</strong> 400g, tạo cảm giác vững chắc và chắc chắn khi sử dụng mà không quá nặng nề.</li>\r\n                </ul>\r\n                \r\n    \r\n                <!-- Công dụng -->\r\n                <div class=\"productPost-usage\">\r\n                    <h2>Công dụng</h2>\r\n                    <p class=\"check-item\"><strong>Phù hợp cho mọi dịp:</strong> Chiếc túi này không chỉ là món phụ kiện thời trang mà còn là người bạn đồng hành lý tưởng trong mọi hoạt động hàng ngày. Bạn có thể dễ dàng mang theo túi khi đi làm, đi chơi, đi học hay đi dạo phố mà không lo thiếu sự tiện dụng.</p>\r\n                    <p class=\"check-item\"><strong>Phong cách thời trang đa dạng:</strong> Với thiết kế tối giản, chiếc túi dễ dàng kết hợp với nhiều trang phục khác nhau. Dù bạn theo đuổi phong cách vintage, tối giản hay hiện đại, chiếc túi này đều có thể làm nổi bật phong cách cá nhân của bạn.</p>\r\n                    <p class=\"check-item\"><strong>Độ bền vượt trội:</strong> Túi được làm từ sợi len tự nhiên bền đẹp, chịu được tác động mạnh mẽ từ môi trường bên ngoài. Khả năng chịu lực và độ bền của túi đảm bảo rằng bạn có thể sử dụng túi hàng ngày mà không lo bị hư hỏng.</p>\r\n                    <p class=\"check-item\"><strong>Dễ dàng bảo quản và vệ sinh:</strong> Túi len mềm mại, dễ dàng giặt tay và bảo quản. Bạn không cần phải lo lắng về việc túi bị bẩn, vì chất liệu len giúp túi giữ được độ mới mẻ qua thời gian sử dụng.</p>\r\n                    <p class=\"check-item\"><strong>Đặc biệt trong những ngày mưa:</strong> Nhờ khả năng chống thấm nhẹ, túi có thể chịu được những cơn mưa nhẹ mà không làm ảnh hưởng đến chất lượng của sản phẩm. Đây là một ưu điểm lớn cho những ai thường xuyên di chuyển ngoài trời.</p>\r\n                </div>\r\n    \r\n                <!-- Ý nghĩa sản phẩm -->\r\n                <div class=\"productPost-meaning\">\r\n                    <h2>Ý nghĩa sản phẩm</h2>\r\n                    <p class=\"check-item\"><strong>Biểu tượng của sự sáng tạo và thủ công tinh tế:</strong> Mỗi chiếc túi không chỉ là một món đồ thời trang mà còn là một tác phẩm nghệ thuật, thể hiện sự khéo léo và tỉ mỉ của các nghệ nhân thủ công. Sự kết hợp giữa chất liệu tự nhiên và bàn tay tài hoa của người thợ tạo nên một sản phẩm độc đáo, mang đậm dấu ấn cá nhân.</p>\r\n                    <p class=\"check-item\"><strong>Một lời cam kết với môi trường:</strong> Sản phẩm này không chỉ đơn thuần là một chiếc túi đẹp mà còn là một hành động thiết thực trong việc bảo vệ hành tinh. Việc sử dụng các chất liệu tái chế không chỉ giảm thiểu tác động tiêu cực đến môi trường mà còn thể hiện trách nhiệm của chúng ta trong việc bảo vệ thiên nhiên cho thế hệ tương lai.</p>\r\n                    <p class=\"check-item\"><strong>Tôn vinh phong cách sống đơn giản:</strong> Sự đơn giản trong thiết kế nhưng lại vô cùng tinh tế chính là minh chứng cho một phong cách sống tối giản nhưng đầy ý nghĩa. Túi Handmade Shoulder Len là món đồ lý tưởng cho những ai yêu thích phong cách sống đơn giản.</p>\r\n                    <p class=\"check-item\"><strong>Kết nối con người với thiên nhiên:</strong> Được làm từ sợi len tự nhiên, chiếc túi này không chỉ mang đến cảm giác dễ chịu, thoải mái khi sử dụng mà còn là sự kết nối gần gũi với thiên nhiên. Mỗi lần sử dụng chiếc túi này, bạn không chỉ cảm nhận được vẻ đẹp của sự tinh tế mà còn cảm nhận được sự tươi mới, gần gũi mà thiên nhiên mang lại.</p>\r\n                </div>\r\n    \r\n                <!-- Nội dung bổ sung -->\r\n                <div class=\"productPost-additional\">\r\n                    <h2>Lý do bạn không thể bỏ qua chiếc túi Handmade này</h2>\r\n                    <p class=\"check-item\"><strong>Sự tinh xảo trong từng đường kim mũi chỉ:</strong> Mỗi chiếc túi đều được làm thủ công tỉ mỉ bởi những người thợ lành nghề, đảm bảo sự độc đáo và chất lượng cao nhất. Không có chiếc túi nào giống nhau, và chính điều đó tạo nên giá trị riêng biệt cho từng sản phẩm.</p>\r\n                    <p class=\"check-item\"><strong>Độ bền vượt thời gian:</strong> Túi được làm từ chất liệu sợi len tự nhiên, mang lại độ bền cao và khả năng chịu lực ấn tượng. Dù bạn mang theo sách vở đi học hay đồ dùng cá nhân, chiếc túi này vẫn luôn đồng hành cùng bạn.</p>\r\n                    <p class=\"check-item\"><strong>Chống thấm nhẹ, sẵn sàng cho mọi thời tiết:</strong> Với khả năng chống thấm nhẹ, chiếc túi vẫn giữ được vẻ đẹp nguyên vẹn trong những ngày mưa nhẹ, giúp bạn an tâm sử dụng mọi lúc, mọi nơi.</p>\r\n                    <p class=\"check-item\"><strong>Phong cách sống bền vững:</strong> Bằng việc lựa chọn sản phẩm này, bạn không chỉ sở hữu một món đồ đẹp mà còn góp phần bảo vệ môi trường. Sản phẩm được làm từ sợi len tái chế, giúp giảm thiểu rác thải và bảo vệ hành tinh.</p>\r\n                    <p class=\"check-item\"><strong>Món quà đầy ý nghĩa:</strong> Đây là món quà tuyệt vời cho những người thân yêu, hoặc cho chính bản thân bạn, để thể hiện sự yêu thích đối với sự tinh tế và phong cách sống tối giản. Một món quà không chỉ đẹp về hình thức mà còn mang giá trị tinh thần sâu sắc.</p>\r\n                </div>', 'tui-shouder-len.jpg', '2024-11-25', 10, 'Túi Handmade Shoulder Len tại CHARM CARFT kết hợp nét đẹp thủ công và phong cách hiện đại. Làm từ len chất lượng cao, túi mềm mại, chắc chắn với dây đeo vai thoải mái và màu sắc tinh tế, mang đến vẻ ngoài thời trang cho những ai yêu thích sự độc đáo và cá tính.', 1, 6, 25),
(6, 'Móc Khóa Gỗ Vải Handmade', '<ul class=\"productPost-details\">\r\n                                <li><strong>Chất liệu:</strong> Gỗ tự nhiên được gia công tỉ mỉ, kết hợp với vải cotton mềm mại, họa tiết tinh tế và khóa kim loại chắc chắn.</li>\r\n                                <li><strong>Kích thước:</strong> Tổng chiều dài 12cm, vòng gỗ 3cm. Thiết kế nhỏ gọn, tiện lợi, dễ dàng mang theo mọi lúc mọi nơi.</li>\r\n                                <li><strong>Trọng lượng:</strong> 40g - nhẹ nhàng, không gây bất tiện khi sử dụng nhưng vẫn đảm bảo độ bền chắc.</li>\r\n                                <li><strong>Họa tiết:</strong> Hoa lá vintage trên nền vải pastel nhẹ nhàng, phù hợp với nhiều phong cách thời trang.</li>\r\n                            </ul>\r\n                    \r\n                            <!-- Công dụng -->\r\n                            <div class=\"productPost-usage\">\r\n                                <h2>Công dụng và giá trị sử dụng</h2>\r\n                                <p class=\"check-item\"><strong>Phụ kiện thời trang:</strong> Là món đồ trang trí hoàn hảo cho chìa khóa, balo, hoặc túi xách. Thiết kế sang trọng nhưng không kém phần tinh tế giúp bạn nổi bật trong mọi tình huống.</p>\r\n                                <p class=\"check-item\"><strong>Quà tặng ý nghĩa:</strong> Đây là món quà lý tưởng dành cho bạn bè, người thân trong các dịp đặc biệt như sinh nhật, kỷ niệm, hoặc lễ hội. Sự kết hợp giữa chất liệu tự nhiên và thiết kế độc đáo tạo nên giá trị vượt thời gian.</p>\r\n                                <p class=\"check-item\"><strong>Điểm nhấn cá tính:</strong> Phù hợp với những ai yêu thích sự độc đáo, muốn thể hiện phong cách riêng qua từng chi tiết nhỏ trong cuộc sống.</p>\r\n                            </div>\r\n                    \r\n                            <!-- Ý nghĩa sản phẩm -->\r\n                            <div class=\"productPost-meaning\">\r\n                                <h2>Ý nghĩa của Móc Khóa Gỗ Vải Handmade</h2>\r\n                                <p class=\"check-item\"><strong>Kết nối với thiên nhiên:</strong> Sử dụng gỗ tự nhiên và vải cotton không chỉ mang lại cảm giác thân thiện với môi trường mà còn tạo sự gần gũi với thiên nhiên. Sản phẩm là lời nhắc nhở về vẻ đẹp đơn giản, mộc mạc mà vẫn tinh tế.</p>\r\n                                <p class=\"check-item\"><strong>Vẻ đẹp thủ công:</strong> Từng chiếc móc khóa được tạo ra từ bàn tay khéo léo của người thợ thủ công, mỗi sản phẩm là một tác phẩm nghệ thuật độc nhất, mang dấu ấn riêng.</p>\r\n                                <p class=\"check-item\"><strong>Phong cách sống bền vững:</strong> Hướng tới xu hướng tiêu dùng bền vững, sản phẩm sử dụng chất liệu thân thiện với môi trường, giúp bạn góp phần bảo vệ hành tinh.</p>\r\n                            </div>\r\n\r\n                            <!-- Lý do nên sở hữu -->\r\n                            <div class=\"productPost-additional\">\r\n                                <h2>Lý do bạn nên sở hữu Móc Khóa Gỗ Vải Handmade</h2>\r\n                                <p class=\"check-item\"><strong>Thiết kế độc đáo:</strong> Mỗi chiếc móc khóa là một sự kết hợp hài hòa giữa chất liệu tự nhiên và phong cách hiện đại, tạo nên sự khác biệt không lẫn vào đâu.</p>\r\n                                <p class=\"check-item\"><strong>Độ bền vượt trội:</strong> Với chất liệu gỗ cao cấp và vải cotton chất lượng, sản phẩm bền đẹp theo thời gian, không bị xuống cấp dù sử dụng thường xuyên.</p>\r\n                                <p class=\"check-item\"><strong>Dễ dàng bảo quản:</strong> Sản phẩm dễ dàng làm sạch bằng khăn mềm hoặc nước ấm, giúp duy trì độ sáng bóng và sạch sẽ trong thời gian dài.</p>\r\n                                <p class=\"check-item\"><strong>Phụ kiện không lỗi mốt:</strong> Móc khóa gỗ vải là món đồ thủ công vượt thời gian, phù hợp với mọi lứa tuổi và phong cách.</p>\r\n                            </div>', 'moc-khoa-go-vai.jpg', '2024-11-26', 10, 'Móc Khóa Gỗ Vải Handmade tại shop CHARM CARFT là sản phẩm độc đáo, được làm thủ công từ gỗ tự nhiên và vải cao cấp. Với thiết kế dễ thương và màu sắc tươi sáng, mỗi chiếc móc khóa không chỉ tiện lợi mà còn là món quà ý nghĩa dành cho bạn bè và người thân. Ghé thăm Trạm Nhỏ Xinh để tìm cho mình một chiếc móc khóa đặc biệt nhé!', 1, 2, 25);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `postcate`
--

CREATE TABLE `postcate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `postcate`
--

INSERT INTO `postcate` (`id`, `name`, `status`) VALUES
(1, 'Tô màu', 0),
(2, 'Phụ kiện', 1),
(3, 'Trang trí', 0),
(4, 'Vòng tay', 1),
(5, 'Nón len', 0),
(6, 'Túi len', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productcate`
--

CREATE TABLE `productcate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `productcate`
--

INSERT INTO `productcate` (`id`, `name`, `status`) VALUES
(1, 'Tô màu', 2),
(2, 'Phụ kiện', 1),
(3, 'Trang trí', 2),
(4, 'Vòng tay', 1),
(5, 'Nón len', 1),
(6, 'Túi len', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productcomment`
--

CREATE TABLE `productcomment` (
  `id` int(11) NOT NULL,
  `dateProComment` date NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `productcomment`
--

INSERT INTO `productcomment` (`id`, `dateProComment`, `text`, `status`, `idProduct`, `idUser`) VALUES
(1, '2024-11-24', 'Sản phẩm đẹp', 1, 39, 25),
(2, '2024-11-24', 'Sản phẩm đẹp', 1, 40, 25),
(3, '2024-11-24', 'Sản phẩm đẹp', 1, 41, 25),
(4, '2024-11-24', 'Sản phẩm đẹp', 1, 42, 25),
(5, '2024-11-24', 'Sản phẩm đẹp', 1, 43, 25),
(6, '2024-11-24', 'Sản phẩm đẹp', 1, 44, 25),
(7, '2024-11-24', 'Sản phẩm đẹp', 1, 45, 25),
(9, '2024-11-24', 'Sản phẩm đẹp', 1, 47, 25),
(10, '2024-11-24', 'Sản phẩm đẹp', 1, 48, 25),
(11, '2024-11-24', 'Sản phẩm đẹp', 1, 49, 25),
(13, '2024-11-24', 'Sản phẩm đẹp', 1, 51, 25),
(14, '2024-11-24', 'Sản phẩm đẹp', 1, 52, 25),
(15, '2024-11-24', 'Sản phẩm đẹp', 1, 53, 25),
(16, '2024-11-24', 'Sản phẩm đẹp', 1, 54, 25),
(17, '2024-11-24', 'Sản phẩm đẹp', 1, 55, 25),
(18, '2024-11-24', 'Sản phẩm đẹp', 1, 56, 25),
(20, '2024-11-24', 'Sản phẩm đẹp', 1, 58, 25),
(21, '2024-11-24', 'Sản phẩm đẹp', 1, 67, 25),
(22, '2024-11-24', 'Sản phẩm đẹp', 1, 68, 25),
(23, '2024-11-24', 'Sản phẩm đẹp', 1, 69, 25),
(24, '2024-11-24', 'Sản phẩm đẹp', 1, 70, 25),
(25, '2024-11-24', 'Sản phẩm đẹp', 1, 71, 25),
(26, '2024-11-24', 'Tịt dời', 1, 39, 25);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `salePrice` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `listImages` text DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `size` varchar(255) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `view` int(11) DEFAULT NULL,
  `idCate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `salePrice`, `description`, `detail`, `image`, `listImages`, `color`, `material`, `size`, `quantity`, `status`, `view`, `idCate`) VALUES
(39, 'Gương mori', 50000, 45000, NULL, NULL, 'guong-mori.jpg', '', 'Vải bạc', 'Kim loại', '0', 1, 1, NULL, 2),
(40, 'Gương thêu hoa', 120000, 110000, NULL, NULL, 'guong-theu-hoa.jpg', 'guong-theu-hoa1.jpg,\r\nguong-theu-hoa2.jpg,\r\nguong-theu-hoa3.jpg', 'Vải thêu', 'Kim loại', '0', 1, 1, NULL, 2),
(41, 'Cột tóc thêu', 40000, NULL, NULL, NULL, 'cot-toc-theu.jpg', 'cot-toc-theu1.jpg,\r\ncot-toc-theu2.jpg,\r\ncot-toc-theu3.jpg', 'Không', 'Vải thun', '0', 1, 1, NULL, 2),
(42, 'Móc khóa gỗ vải 1', 300000, NULL, NULL, NULL, 'moc-khoa-go-vai.jpg', 'moc-khoa-go-vai1.jpg,\r\nmoc-khoa-go-vai2.jpg,\r\nmoc-khoa-go-vai3.jpg,\r\nmoc-khoa-go-vai4.jpg', 'Không', 'Gỗ', '0', 2, 1, NULL, 2),
(43, 'Móc khóa len', 60000, NULL, NULL, NULL, 'moc-khoa-len.jpg', 'moc-khoa-len1.jpg,\r\nmoc-khoa-len2.jpg', 'Không', 'Len', '0', 1, 1, NULL, 2),
(44, 'Khăn bandana', 165000, NULL, NULL, NULL, 'khan-bandana.jpg', '\r\nkhan-bandana2.jpg,khan-bandana1.jpg', 'Xanh lá, Trắng', 'Len', '0', 1, 1, NULL, 2),
(45, 'Cột Srunchies', 265000, NULL, NULL, NULL, 'cot-srunchies.jpg', 'cot-srunchies1.jpg', 'Trắng, Đen', 'Vải', '0', 1, 1, NULL, 2),
(47, 'Hồng Ngọc Lửa', 60000, NULL, NULL, NULL, 'hong-ngoc-lua.jpg', 'hong-ngoc-lua1.jpg', 'Đỏ', 'Dây đá', '0', 1, 1, NULL, 4),
(48, 'Ngọc xanh đại dương', 60000, NULL, NULL, NULL, 'ngoc-xanh-dai-duong.jpg', 'ngoc-xanh-dai-duong1.jpg', 'Xanh dương', 'Dây đá', '0', 1, 1, NULL, 4),
(49, 'Vòng dây basic', 40000, NULL, NULL, NULL, 'vong-day-basic.jpg', 'vong-day-basic1.jpg,\r\nvong-day-basic2.jpg', 'Trắng', 'Dây đá', '0', 1, 1, NULL, 4),
(51, 'Lục lạc huyền bí', 60000, NULL, NULL, NULL, 'luc-lac-huyen-bi.jpg', NULL, 'Đen tím', 'Dây đá', '0', 1, 1, NULL, 4),
(52, 'Combo basic', 200000, NULL, NULL, NULL, 'combo-basic.jpg', NULL, 'Đen', 'Dây đá', '0', 1, 1, NULL, 4),
(53, 'Combo đá hồng', 250000, NULL, NULL, NULL, 'combo-da-hong.jpg', 'combo-da-hong1.jpg', 'Hồng', 'Dây đá', '0', 1, 1, NULL, 4),
(54, 'Combo đá, dây trắng', 250000, NULL, NULL, NULL, 'combo-da-day-trang.jpg', 'combo-da-day-trang1.jpg', 'Trắng', 'Dây đá', '0', 1, 1, NULL, 4),
(55, 'Combo đá dây đen', 250000, NULL, NULL, NULL, 'combo-da-day-den.jpg', 'combo-da-day-den1.jpg,\r\ncombo-da-day-den2.jpg,\r\ncombo-da-day-den3.jpg', 'Đen', 'Dây đá', '0', 1, 1, NULL, 4),
(56, 'Combo đá xanh', 250000, NULL, NULL, NULL, 'combo-da-xanh.jpg', 'combo-da-xanh1.jpg,\r\ncombo-da-xanh2.jpg', 'Xanh biển', 'Dây đá', '0', 1, 1, NULL, 4),
(58, 'Combo đá dây nâu', 250000, NULL, NULL, NULL, 'combo-da-day-nau1.jpg', 'combo-da-day-nau2.jpg,\ncombo-da-day-nau3.jpg', 'Nâu', 'Dây đá', '0', 1, 1, NULL, 4),
(67, 'Túi hoa len', 270000, NULL, NULL, NULL, 'tui-hoa-len.jpg', NULL, 'Trắng xanh', 'Len', '0', 1, 1, NULL, 6),
(68, 'Túi popcorn len', 250000, NULL, NULL, NULL, 'tui-popcorn-len.jpg', 'tui-popcorn-len1.jpg', 'Trắng, đỏ', 'Len', '0', 1, 1, NULL, 6),
(69, 'Túi Cinta len', 200000, NULL, NULL, NULL, 'tui-cinta-len.jpg', NULL, 'Trắng', 'Len', '0', 1, 1, NULL, 6),
(70, 'Túi vuông len', 180000, NULL, NULL, NULL, 'tui-vuong-len.jpg', 'tui-vuong-len1.jpg,\r\ntui-vuong-len2.jpg', 'Nâu, Hồng', 'Len', '0', 1, 1, NULL, 6),
(71, 'Túi tote len', 180000, NULL, NULL, NULL, 'tui-tote-len.jpg', NULL, 'Nâu', 'Len', '0', 1, 1, NULL, 6),
(72, 'Túi 2 dây nhỏ len', 100000, NULL, NULL, NULL, 'tui-2-day-nho-len.jpg', 'tui-2-day-nho-len1.jpg', 'Trắng, xanh lá mạ', 'Len', '0', 1, 1, NULL, 6),
(73, 'Túi xách tay nhỏ len', 150000, NULL, NULL, NULL, 'tui-xach-tay-nho-len.jpg', 'tui-xach-tay-nho-len1.jpg,\ntui-xach-tay-nho-len2.jpg', 'Xanh dương, Vàng', 'Len', '0', 1, 1, NULL, 6),
(74, 'Túi shouder len', 200000, NULL, NULL, NULL, 'tui-shouder-len.jpg', NULL, 'Trắng', 'Len', '0', 1, 1, NULL, 6),
(75, 'Nón len', 260000, NULL, NULL, NULL, 'non-len.jpg', 'non-len1.jpg,\nnon-len2.jpg,\nnon-len3.jpg,\nnon-len4.jpg', 'Xanh da trời, Nâu, Trắng', 'Len', '0', 1, 1, NULL, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `star` tinyint(1) NOT NULL,
  `dateRating` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rating`
--

INSERT INTO `rating` (`id`, `text`, `image`, `star`, `dateRating`, `idUser`, `idProduct`) VALUES
(1, 'Quá xứng đáng', NULL, 5, '2024-11-25 09:35:16', 25, 39),
(2, 'Tốt', NULL, 4, '2024-11-25 10:43:40', 25, 39);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `address`, `phone`, `name`, `role`, `active`, `dateCreate`, `code`) VALUES
(25, 'Phattmtps40087@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', NULL, '0775804665', 'Phat', 1, 1, '2025-08-09 10:21:46', 'dd320904bf58ebd4e9828b28e6b8594c22169b08dde188c634de4d14e3f640bb'),
(26, 'tranphat02052005@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', NULL, '0775804665', 'Tran Phat', 0, 0, '2025-11-15 09:33:45', 'ffa030f4d551ca7bd2315aff9b8f3e627d597620089814cc6b6ac423b65780bd'),
(28, 'nastumijaki198@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, '1', 'a', 0, 1, '2025-11-26 19:09:11', '53806f96f77d50d994b4340f1c861bbaf9edc3499fcd0b930e35127985b0d10b');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idProducts` (`idProduct`);

--
-- Chỉ mục cho bảng `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProducts` (`idProduct`),
  ADD KEY `idOrders` (`idOrder`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_catePost` (`idCatePost`),
  ADD KEY `idUserPost` (`idUserPost`);

--
-- Chỉ mục cho bảng `postcate`
--
ALTER TABLE `postcate`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `productcate`
--
ALTER TABLE `productcate`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `productcomment`
--
ALTER TABLE `productcomment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProducts` (`idProduct`),
  ADD KEY `idUser` (`idUser`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCate` (`idCate`);

--
-- Chỉ mục cho bảng `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idProducts` (`idProduct`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
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
-- AUTO_INCREMENT cho bảng `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `postcate`
--
ALTER TABLE `postcate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `productcate`
--
ALTER TABLE `productcate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `productcomment`
--
ALTER TABLE `productcomment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`idCatePost`) REFERENCES `postcate` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`idUserPost`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `productcomment`
--
ALTER TABLE `productcomment`
  ADD CONSTRAINT `productcomment_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `productcomment_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idCate`) REFERENCES `productcate` (`id`);

--
-- Các ràng buộc cho bảng `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
