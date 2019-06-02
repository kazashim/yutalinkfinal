-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 22 Ağu 2018, 10:45:43
-- Sunucu sürümü: 5.7.17-log
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `craigs`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adsense`
--

CREATE TABLE `adsense` (
  `id` int(11) NOT NULL,
  `item_ads` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `item_ads_statu` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `blog_ads` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `blog_ads_statu` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `adsense`
--

INSERT INTO `adsense` (`id`, `item_ads`, `item_ads_statu`, `blog_ads`, `blog_ads_statu`) VALUES
(1, '<a target=\"_blank\" href=\"https://themerig.com\"><img style=\"width:100%;height:100%;\" src=\"//lh6.ggpht.com/Ab63gyKVnGwbQaj0guyJ0caGj-VugefmMd3SyzpPOX2RgCDA1tzQTY36sGI65Guw5OXdas4f5w=w303\" height=\"auto\" alt=\"\"></a>', '1', '<a target=\"_blank\" href=\"https://themerig.com\"><img style=\"width:100%;height:100%;\" src=\"//lh6.ggpht.com/Ab63gyKVnGwbQaj0guyJ0caGj-VugefmMd3SyzpPOX2RgCDA1tzQTY36sGI65Guw5OXdas4f5w=w303\" height=\"auto\" alt=\"\"></a>', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `author_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cover_image` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `blog_permit` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `views` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `update_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `update_author_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `remove` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_category`
--

CREATE TABLE `blog_category` (
  `id` int(11) NOT NULL,
  `blog_ctg_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_comment`
--

CREATE TABLE `blog_comment` (
  `id` int(11) NOT NULL,
  `blog_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `b_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `b_permit` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `item_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `ctg_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ctg_icon_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category_box`
--

CREATE TABLE `category_box` (
  `id` int(11) NOT NULL,
  `category_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `ctg_bx_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `text_val` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category_box_1`
--

CREATE TABLE `category_box_1` (
  `id` int(11) NOT NULL,
  `category_box_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `c_fullname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `c_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `c_subject` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `c_message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `c_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `statu` varchar(21) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `remove` varchar(21) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ip_users`
--

CREATE TABLE `ip_users` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `up_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `grid_list_my_ads` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `grid_list_bookmark` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `grid_list_sold_items` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `grid_list_index` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `grid_list_profile` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `ip_users`
--

INSERT INTO `ip_users` (`id`, `ip`, `date`, `up_date`, `user_id`, `lang`, `grid_list_my_ads`, `grid_list_bookmark`, `grid_list_sold_items`, `grid_list_index`, `grid_list_profile`) VALUES
(1, '::1', '1534934666', NULL, '', '', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `items`
--

CREATE TABLE `items` (
  `id` int(32) NOT NULL,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `price_appendix` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `address` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `permit` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `user_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sale_status` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `views` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `sale_hidden_status_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remove` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sale_hidden_reply_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cx` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_category_box_1`
--

CREATE TABLE `i_category_box_1` (
  `id` int(11) NOT NULL,
  `ctg_bx_1_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_category_box_2`
--

CREATE TABLE `i_category_box_2` (
  `id` int(11) NOT NULL,
  `ctg_bx_2_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `ctg_bx_2_subj` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_category_box_3`
--

CREATE TABLE `i_category_box_3` (
  `id` int(11) NOT NULL,
  `ctg_bx_3_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `ctg_bx_3_subj` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_category_box_4`
--

CREATE TABLE `i_category_box_4` (
  `id` int(11) NOT NULL,
  `ctg_bx_4_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `ctg_bx_4_subj` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_category_box_5`
--

CREATE TABLE `i_category_box_5` (
  `id` int(11) NOT NULL,
  `ctg_bx_5_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lang_` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `language`
--

INSERT INTO `language` (`id`, `name`, `lang_`) VALUES
(1, 'TR', 'tr'),
(2, 'EN', 'en');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `g_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `a_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `st` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `page_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `page_permit` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `permit` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `item_per_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `logo_two` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `general_about` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(2500) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `con_lat` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `con_lon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `home_per_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `home_pag_view` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_per_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `profile_pag_view` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `sold_per_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `sold_pag_view` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `profile_detail_per_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `profile_detail_pag_view` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `blog_per_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `blog_pag_view` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `book_per_page` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `book_pag_view` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `blog_permit` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `blog_per_page_count` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `admin_message_per_page` varchar(21) COLLATE utf8_unicode_ci NOT NULL,
  `admin_message_pag_view` varchar(21) COLLATE utf8_unicode_ci NOT NULL,
  `google_api_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cover_img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `footer_img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `update_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_blog_per_page` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_blog_pag_view` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_page_per_page` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_page_pag_view` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_users_per_page` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_users_pag_view` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_item_per_page` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_item_pag_view` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `statu_language` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `h_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `mail_header_img` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `home_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `url_ay` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `home_subj` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `favicon_ico` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `home_meta_desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `home_meta_keywords` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_code` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_site_url` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `envato_username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `google_analytics_code` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `permit`, `currency`, `lang`, `phone`, `logo`, `item_per_page`, `logo_two`, `general_about`, `address`, `email`, `facebook`, `con_lat`, `con_lon`, `home_per_page`, `home_pag_view`, `profile_per_page`, `profile_pag_view`, `sold_per_page`, `sold_pag_view`, `profile_detail_per_page`, `profile_detail_pag_view`, `blog_per_page`, `blog_pag_view`, `book_per_page`, `book_pag_view`, `blog_permit`, `blog_per_page_count`, `admin_message_per_page`, `admin_message_pag_view`, `google_api_key`, `cover_img`, `footer_img`, `user_id`, `update_date`, `admin_blog_per_page`, `admin_blog_pag_view`, `admin_page_per_page`, `admin_page_pag_view`, `admin_users_per_page`, `admin_users_pag_view`, `admin_item_per_page`, `admin_item_pag_view`, `statu_language`, `h_url`, `twitter`, `mail_header_img`, `home_title`, `url_ay`, `home_subj`, `favicon_ico`, `home_meta_desc`, `home_meta_keywords`, `purchase_code`, `purchase_site_url`, `envato_username`, `google_analytics_code`) VALUES
(1, '1', '$', 'en', '0532 123 45 67', 'assets/img/logo/43193.png', '5', 'assets/img/logo/55103.png', 'Themerig.com All rights reserved.', 'Almanya', 'noreply@themerig.com', 'themerig', '51.165691', '10.451526000000058', '16', '3', '6', '2', '6', '2', '6', '2', '6', '2', '6', '2', '1', '5', '6', '2', 'AIzaSyBatZ85-H1smYjp9wIy3CF_zA2PPHIqtm0', 'assets/img/general/447521.jpg', 'assets/img/general/892755.jpg', '1', '1534922546', '6', '2', '6', '2', '6', '2', '6', '2', '1', 'off', 'twitter', 'assets/img/general/header-bg.png', 'Craigs Cms', '-', 'Directory Listing Theme', 'assets/img/logo/691603.png', 'Themerig company', 'Items, Ad, Featured item, ', '62cb619a-2991-4677-8ad7-23cbc5e335d1', 'localhost', 'fra_beautifulloc1K', '<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-124234129-1\"></script>\r\n<script>\r\n	 window.dataLayer = window.dataLayer || [];\r\n	 function gtag(){dataLayer.push(arguments);}\r\n	 gtag(\"js\", new Date());\r\n	gtag(\"config\", \"UA-124234129-1\");\r\n</script>');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `smtp`
--

CREATE TABLE `smtp` (
  `id` int(11) NOT NULL,
  `host` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_secure` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `site_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `site_title` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `smtp`
--

INSERT INTO `smtp` (`id`, `host`, `port`, `smtp_secure`, `username`, `password`, `site_name`, `site_title`) VALUES
(1, 'mail.themerig.com', '465', 'ssl', 'noreply@themerig.com', '', 'https://example.com', 'Craigs Directory');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `register_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `st` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `newsletter` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `hide_phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `get_message` int(11) DEFAULT '0',
  `admin_slide_menu` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `remove` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `hide_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_chats`
--

CREATE TABLE `users_chats` (
  `id` int(11) NOT NULL,
  `user_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `target_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `read_type` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `product_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sound_type` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_comment`
--

CREATE TABLE `users_comment` (
  `id` int(11) NOT NULL,
  `your_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `i_rate` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `i_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `i_desc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `adsense`
--
ALTER TABLE `adsense`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blog_category`
--
ALTER TABLE `blog_category`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `category_box`
--
ALTER TABLE `category_box`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `category_box_1`
--
ALTER TABLE `category_box_1`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ip_users`
--
ALTER TABLE `ip_users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `i_category_box_1`
--
ALTER TABLE `i_category_box_1`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_category_box_2`
--
ALTER TABLE `i_category_box_2`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_category_box_3`
--
ALTER TABLE `i_category_box_3`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_category_box_4`
--
ALTER TABLE `i_category_box_4`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_category_box_5`
--
ALTER TABLE `i_category_box_5`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `smtp`
--
ALTER TABLE `smtp`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_chats`
--
ALTER TABLE `users_chats`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_comment`
--
ALTER TABLE `users_comment`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `adsense`
--
ALTER TABLE `adsense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `blog_category`
--
ALTER TABLE `blog_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `blog_comment`
--
ALTER TABLE `blog_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `category_box`
--
ALTER TABLE `category_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `category_box_1`
--
ALTER TABLE `category_box_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `ip_users`
--
ALTER TABLE `ip_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `items`
--
ALTER TABLE `items`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `i_category_box_1`
--
ALTER TABLE `i_category_box_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `i_category_box_2`
--
ALTER TABLE `i_category_box_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `i_category_box_3`
--
ALTER TABLE `i_category_box_3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `i_category_box_4`
--
ALTER TABLE `i_category_box_4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `i_category_box_5`
--
ALTER TABLE `i_category_box_5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `smtp`
--
ALTER TABLE `smtp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `users_chats`
--
ALTER TABLE `users_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `users_comment`
--
ALTER TABLE `users_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
