-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 17, 2024 lúc 01:47 AM
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
-- Cơ sở dữ liệu: `website_bando`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin_data`
--

CREATE TABLE `tbl_admin_data` (
  `admin_id` int(11) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin_data`
--

INSERT INTO `tbl_admin_data` (`admin_id`, `email_admin`, `password_admin`) VALUES
(5, 'admin2@gmail.com', '$2y$10$XprlvuoU171mEeUoqprHaeLbCUyQsH2FxJZobgZkO1hPj5HFo07bq'),
(7, 'admin1@gmail.com', '$2y$10$rnrTQk39EuYCQM5HB9eJ3ut72k1fgImZcMSQ1yjjFRaNi1h2ocQYi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `category_id`, `brand_name`) VALUES
(13, 1, 'Men\'s shirt'),
(14, 1, 'Men\'s pants'),
(15, 2, 'Women\'s shirt'),
(17, 1, 'Men\'s jacket'),
(18, 2, 'Women\'s skirt'),
(19, 2, 'Women\'s pants'),
(21, 2, 'Women\'s set'),
(26, 9, 'Quần áo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Sale'),
(4, 'Collection'),
(5, 'Contact'),
(6, 'News'),
(7, 'Recruitment'),
(9, 'Trẻ em');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_news`
--

CREATE TABLE `tbl_news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_content` text NOT NULL,
  `news_image` varchar(255) DEFAULT NULL,
  `news_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_news`
--

INSERT INTO `tbl_news` (`news_id`, `news_title`, `news_content`, `news_image`, `news_date`) VALUES
(8, 'Thời Trang Thế Giới', 'Trang tạp chí thời trang của chúng tôi, đem lại cho các tín đồ thời trang những thông tin mới, xu hướng thời trang thế giới từ cổ điển đến hiện đại.', 'news3.webp', '2024-12-13 10:05:43'),
(16, 'CHUYỂN ĐỘNG TRAO YÊU THƯƠNG', 'Tháng 12 này, triển khai chuỗi hoạt động \"Chuyển động trao yêu thương\" với mong muốn sẻ chia, lan tỏa hơi ấm và mang đến nhiều hơn các giá trị cả về vật chất và tinh thần cho cộng đồng, đặc biệt là những hoàn cảnh khó khăn.', 'news1.webp', '2024-12-13 10:12:02'),
(17, 'Khuyến Mãi', 'Cùng săn sale các Deal giá hời nhất, tham khảo và cập nhật các tin tức khuyến mãi tại YODY để không bỏ lỡ một deal giá tốt!', 'news2.webp', '2024-12-13 10:12:23'),
(23, 'Bảo vệ khách hàng', 'Chúng tôi ra mắt chuyên mục \"Bảo vệ khách hàng\" giúp tránh gặp các trường hợp mạo danh YODY lừa đảo, gây thiệt hại về tài sản và thông tin cá nhân.', 'new3.jpg', '2024-12-13 14:30:17'),
(24, 'Khuyến Mãi 1', 'Áđxdg', 'aothundesc.webp', '2024-12-17 00:33:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_price_new` varchar(255) NOT NULL,
  `product_desc` varchar(5000) NOT NULL,
  `product_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `category_id`, `brand_id`, `product_price`, `product_price_new`, `product_desc`, `product_img`) VALUES
(1, 'Polo Regular', 1, 13, '450000', '300000', 'HƯỚNG DẪN BẢO QUẢN\r\n\r\n- Khi giặt không ngâm quá lâu\r\n- Giặt máy với chu kỳ trung bình, vòng quay ngắn (nếu kỹ hơn có thể giặt tay để giữ độ bền)\r\n- Nên kết hợp nước xả vải để sản phẩm mềm mại và phẳng hơn\r\n- Không sử dụng hóa chất tẩy để giặt\r\n- Phơi trong bóng mát. Sấy khô ở nhiệt độ thấp\r\n- Lộn ngược mặt trái để giặt và tránh giặt với sản phẩm khác màu\r\n\r\nLƯU Ý\r\n\r\n- Giao hàng tận nơi\r\n- Kiểm tra hàng trước khi thanh toán\r\n____', 'polo_regular.avif'),
(3, 'Cargo nhiều túi', 1, 14, '400000', '370000', 'Quần Cargo nhiều túi ZARA', 'cargo.jpg'),
(4, 'Áo khoác dạ nam dáng ngắn', 1, 17, '899000', '800000', 'Áo khoác dạ nam dáng ngắn LIZARD chất liệu cao cấp', 'aokhoacdanam.jpg'),
(5, 'Áo nữ 22SF6818170', 2, 15, '697000', '299000', 'Áo nữ 22SF6818170/SP2210\r\n', 'ao_nu.jpg'),
(6, 'Váy nữ đẹp cao cấp', 2, 18, '710000', '700000', 'Đầm, Váy nữ đẹp cao cấp - Váy đầm sang trọng', 'vaynu.webp'),
(7, 'Quần dài nữ Intage Pants', 2, 19, '400000', '250000', 'Chất liệu: Caro Lăng cao cấp, chất dày dặn, đứng form ít nhăn., Form dáng: Quần lưng cao, dáng Baggy. Chi tiết xếp ly sắc xảo tạo điểm nhấn ở phần lai ...', 'quannu.webp'),
(9, 'Bộ Đông Nữ Hoodie In Hình', 2, 21, '899000', '809100', 'Siêu giữ ấm cho mùa lạnh với bộ đồ hoodie dành cho các chị em. Thiết kế áo hoodie cùng quần nỉ dày dặn, giữ ấm tốt. Kết cấu sợi tạo nên mặt vải đanh chắc, không bị bai dão, ít xù. Khả năng co giãn nhẹ giúp thoải mái trong mọi hoạt động di chuyển. Thiết kế basic nhưng có hình in tạo điểm nhấn riêng biệt, ấn tượng.', 'dobonu.webp'),
(10, ' Áo Ba Lỗ Nam Cơ Bản Gấu Thêu Slogan', 1, 13, '129000', '116000', 'Áo ba lỗ làm từ sợi cotton mềm mại, thoáng mát, thấm hút mồ hôi tốt thích hợp cho mọi hoạt động. Độ dày dặn vừa phải giúp áo giữ form tốt, không bai dão. Thiết kế basic đơn giản, điểm nhấn thêu slogan cá tính, phù hợp cho nhiều phong cách và hoàn cảnh.', 'aobalonam.webp'),
(11, ' Quần Sooc Nam Túi Cạnh Sườn', 1, 14, '379000', '341000', 'Thoải mái hoạt động với vải mềm mại, thấm hút nhanh. Túi cạnh sườn tiện lợi đừng đồ dùng cá nhân nhỏ gọn. Thích hợp mặc ở nhà, đi làm hay đi chơi. Thiếu kế ngang đầu gối, dáng cơ bản', 'quansoocnam.webp'),
(12, ' Áo Polo Nam Pique Mắt Chim Basic Co Giãn Thoáng Khí', 1, 13, '400000', '345000', 'Vải dệt 2 màu tạo nên hiệu ứng mắt chim độc đáo. Độ bền cao, thám hút tốt, thoáng khí giúp bạn luôn cảm thấy mát mẻ, dễ chịu. Phần cổ và bo tay áo được thiết kế tỉ mỉ, tinh tế giúp tôn dáng.', 'aopolonam.webp'),
(13, ' Áo Len Nam Thu Đông Cổ 3 Cm', 1, 17, '399000', '279300', 'Áo len dáng suông vừa phải, ôm gọn gàng khi mặc. Thoải mái cử động cho người mặc, giữ ấm tốt nhờ chất liệu viscose cùng kiểu dệt giữ nhiệt hiệu quả. Thiết kế cổ 3cm trẻ trung giữ ấm.', 'aolennam.webp'),
(14, 'Áo Len Nam Regular Cổ Tròn Thấp Bện Thừng', 1, 13, '499000', '450000', 'Giữ ấm hiệu quả với chất liệu len vặn thừng cao cấp. Vải mềm mịn, co giãn tốt, không xù, không bai màu mang đến cảm giác thoải mái, tự tin. Thiết kế đơn giản, dễ phối đồ phù hợp với nhiều phong cách.', 'aolennam1.webp'),
(15, 'Váy Nữ Maxi 2 Dây Bèo Ngực', 2, 18, '850000', '700000', 'Chiếc váy lấy cảm hứng từ những gam màu, cam, vàng, xanh tươi mát của mùa hè, một chút gió nhẹ, một vài tia nắng ấm là những gì mà tạo hóa ban tặng cho thiên nhiên. Thiết kế maxi dịu dàng mềm mại thích hợp cho những chuyến đi biển mùa hè.', 'vaynumaxi.webp'),
(16, 'Quần Âu Nữ Suông Kèm Đai Lệch Cá Tính', 2, 19, '450000', '', 'Quần âu nữ chất liệu tuýt-si nano cao cấp, co giãn 4 chiều thoải mái. Vải mềm mịn, thoáng mát, không nhăn. Công nghệ nano giúp quần bền màu, dễ chăm sóc. Thiết kế đai lệch độc đáo ạo điểm nhấn thời trang tôn lên vẻ đẹp hiện đại của phái nữ.', 'quanaunu.webp'),
(17, 'Quần Âu Nam Cạp Di Động', 1, 14, '500000', '450000', 'Quần âu nam với cấu trúc từ sợi Nano là các sợi polyester siêu mảnh, nhỏ hơn đường kính sợi tóc nhiều lần, mặt cắt ngang hình đa giác xoắn giúp hạn chế nhăn nhàu, form quần đứng nhưng mặc vẫn cảm thấy rất nhẹ và mềm mại. Đặc biệt, chiếc quần được trang bị cạp di động - là 1 trong những cải tiến giúp chiếc quần âu linh hoạt co giãn, phù hợp với nhiều vòng eo trong quá trình sử dụng.', 'quanaunam.webp'),
(18, ' Áo Polo Nam Pique Mắt Chim Basic Co Giãn Thoáng Khí', 1, 13, '100000', '60000', 'Vải dệt 2 màu tạo nên hiệu ứng mắt chim độc đáo. Độ bền cao, thám hút tốt, thoáng khí giúp bạn luôn cảm thấy mát mẻ, dễ chịu. Phần cổ và bo tay áo được thiết kế tỉ mỉ, tinh tế giúp tôn dáng.\r\n', 'aonam.webp'),
(19, 'Sơ Mi Dài Tay Nam Cafe', 1, 13, '300000', '100000', 'Áo sơ mi nam vải cafe không chỉ là lựa chọn hoàn hảo cho ngày làm việc mà còn là điểm nhấn thời trang đầy phong cách. Chất liệu vải cafe mềm mại với màu sắc trang nhã. Thiết kế dài tay có thể mặc mọi mùa và tạo điểm nhấn trong bất kỳ sự kiện nào.', 'aosomi.webp'),
(20, 'Áo Thun Nam Cổ Tròn Cotton Phiên Bản Premium', 1, 13, '200000', '100000', 'Áo thun nam basic với chất vải cotton thoáng mát - item không thể thiếu trong tủ đồ hàng ngày\r\nChất liệu: 100% Cotton\r\nÁo co giãn đàn hồi tốt\r\nKhả năng thấm hút mồ hôi hiệu quả mang đến sự thông thoáng cho người mặc\r\nForm dáng suông cơ bản, dễ mặc, dễ phối đồ\r\nThiết kế thun trơn đơn giản, tinh tế\r\n', 'aothun.webp'),
(21, 'Sơ Mi Tay Dài Nam Nano Kẻ', 1, 13, '400000', '300000', 'Những chiếc áo sơ mi luôn đề cao sự chỉn chu, lịch sự mà vẫn cần thoải mái. Thấu hiểu điều này, chúng tôi đã nghiên cứu và cho ra đời những chiếc áo sơ mi nana tối ưu từ sợi. Sợi nano là các sợi polyester siêu mảnh, nhỏ hơn đường kinh sợi tóc nhiều lần, có cấu trúc riêng biệt. Nhờ vậy, sơ mi Nano hạn chế nhăn nhàu tốt, giữ form tốt nhưng khi mặc vẫn cho cảm giác nhẹ nhàng.\r\n', 'aosomi2.webp'),
(22, ' Quần Thể Thao Nam Chun Gấu Transcend Limit', 1, 14, '500000', '450000', 'Chất liệu gió co giãn 360 độ kết hợp công nghệ dệt kim đan dọc giúp quần có độ bền cao, định hình phom dáng tốt, đồng thời vẫn đảm bảo sự thoải mái tối đa. Với quần Transcend Limit bạn có thể tự tin vận động mà không lo bị gò bó.', 'quanthethao.webp'),
(23, 'Áo Măng Tô Nữ Dáng Ngắn Chun Lưng Cạp', 2, 15, '1000000', '900000', 'Cá tính - phong cách cùng áo măng tô dáng ngắn YODY. Chiếc áo này vừa mang nét đẹp cổ điển của những chiếc măng tô lại vừa hiện đại với dáng ngắn, tôn chân, dễ mặc với nhiều vóc dáng khác nhau. Áo có độ bóng nhẹ, mềm, bền form và phù hợp với siêu nhiều cách phối đồ. ', 'aomangto.webp'),
(24, 'áo trẻ em', 9, 26, '320000', '100000', 'abc', 'aomangto.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product_img_desc`
--

CREATE TABLE `tbl_product_img_desc` (
  `product_id` int(11) NOT NULL,
  `product_img_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product_img_desc`
--

INSERT INTO `tbl_product_img_desc` (`product_id`, `product_img_desc`) VALUES
(1, 'polo_regular_desc.jpg'),
(3, 'cargo_desc.jpg'),
(4, 'aokhoacdanam_desc.jpg'),
(5, 'ao_nu_desc.jpg'),
(6, 'vaynu_desc.webp'),
(7, 'quannu_desc.webp'),
(8, 'tatnam_desc.webp'),
(9, 'dobonu_desc.webp'),
(10, 'aobalonam_desc.webp'),
(11, 'quansoocnam_desc.webp'),
(12, 'aopolonam_desc.webp'),
(13, 'aolennam_desc.webp'),
(14, 'aolennam1_desc.webp'),
(15, 'vaynumaxi_desc.webp'),
(16, 'quanaunu_desc.webp'),
(17, 'quanaunamdesc.webp'),
(18, 'aonamdesc.webp'),
(19, 'aosomidesc.webp'),
(20, 'aothundesc.webp'),
(21, 'aosomi2desc.webp'),
(22, 'quanthethaodesc.webp'),
(23, 'aomangtodesc.webp'),
(24, 'aomangtodesc.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product_sizes`
--

CREATE TABLE `tbl_product_sizes` (
  `size_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product_sizes`
--

INSERT INTO `tbl_product_sizes` (`size_id`, `product_id`, `size`, `quantity`) VALUES
(1, 1, 'M', 26),
(3, 1, 'L', 26),
(4, 1, 'XL', 30),
(5, 3, 'M', 20),
(6, 3, 'L', 10),
(7, 4, 'M', 10),
(8, 4, 'L', 8),
(9, 5, 'S', 10),
(10, 5, 'M', 10),
(11, 5, 'L', 10),
(12, 24, 'M', 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_recruitment`
--

CREATE TABLE `tbl_recruitment` (
  `recruitment_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `cccd` varchar(20) NOT NULL,
  `position` varchar(255) NOT NULL,
  `work_experience` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_recruitment`
--

INSERT INTO `tbl_recruitment` (`recruitment_id`, `full_name`, `birth_date`, `address`, `cccd`, `position`, `work_experience`, `submission_date`) VALUES
(1, 'Trần Minh Hoàng', '2003-06-17', '382 Núi Thành, Đà Nẵng', '123456', 'manage', '2 years', '2024-12-12 17:38:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user_data`
--

CREATE TABLE `tbl_user_data` (
  `user_id` int(11) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `password_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user_data`
--

INSERT INTO `tbl_user_data` (`user_id`, `email_user`, `password_user`) VALUES
(21, 'user2@gmail.com', '$2y$10$drQj7z/AVeP7pzHLW7OmBu2mz9vG8Fv0SKbIVj/tFgPfg0bOYLwWW'),
(22, 'user1@gmail.com', '$2y$10$ZLpISVNZf3FymQMQKjfkCeEcITLrfzaXXY8C5RoMGM9Hds.bHQgfm'),
(23, 'admin@gmail.com', '$2y$10$fFUm.C84dX7wnJOF1bsd2OY6dXxtGvtmos6fE0Iltdi2LcuXbKf12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`info_id`, `user_id`, `full_name`, `phone_number`, `address`, `date_of_birth`) VALUES
(4, 21, 'ABCDEF', '1237655555', '1233333', '2009-02-02'),
(5, 22, 'Trần Minh Hoàng', '0905530635', '1 Núi Thành', '2000-01-01'),
(6, 23, 'admin1', '012345', '01234 Đà Nẵng', '1999-01-01');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin_data`
--
ALTER TABLE `tbl_admin_data`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`),
  ADD KEY `fk_category_brand` (`category_id`);

--
-- Chỉ mục cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category_product` (`category_id`),
  ADD KEY `fk_brand_product` (`brand_id`);

--
-- Chỉ mục cho bảng `tbl_product_sizes`
--
ALTER TABLE `tbl_product_sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `tbl_recruitment`
--
ALTER TABLE `tbl_recruitment`
  ADD PRIMARY KEY (`recruitment_id`);

--
-- Chỉ mục cho bảng `tbl_user_data`
--
ALTER TABLE `tbl_user_data`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin_data`
--
ALTER TABLE `tbl_admin_data`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `tbl_product_sizes`
--
ALTER TABLE `tbl_product_sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tbl_recruitment`
--
ALTER TABLE `tbl_recruitment`
  MODIFY `recruitment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_user_data`
--
ALTER TABLE `tbl_user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD CONSTRAINT `fk_category_brand` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`);

--
-- Các ràng buộc cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user_data` (`user_id`),
  ADD CONSTRAINT `tbl_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`);

--
-- Các ràng buộc cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `fk_brand_product` FOREIGN KEY (`brand_id`) REFERENCES `tbl_brand` (`brand_id`),
  ADD CONSTRAINT `fk_category_product` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`);

--
-- Các ràng buộc cho bảng `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD CONSTRAINT `tbl_user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user_data` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
