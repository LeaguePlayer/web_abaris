-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 12 2013 г., 12:14
-- Версия сервера: 5.5.32-0ubuntu0.13.04.1
-- Версия PHP: 5.4.9-4ubuntu2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `abaris`
--

-- --------------------------------------------------------

--
-- Структура таблицы `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `versions_data` text NOT NULL,
  `name` tinyint(1) NOT NULL DEFAULT '1',
  `description` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_photo`
--

CREATE TABLE IF NOT EXISTS `gallery_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text,
  `file_name` varchar(255) NOT NULL,
  `ext` varchar(10) NOT NULL,
  `main` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_gallery_photo_gallery1` (`gallery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_adaptabillity`
--

CREATE TABLE IF NOT EXISTS `tbl_adaptabillity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_id` int(11) NOT NULL COMMENT 'Ссылка на деталь',
  `auto_model_id` int(11) DEFAULT NULL COMMENT 'Модель автомобиля',
  `engine_model_id` int(11) DEFAULT NULL COMMENT 'Модель двигателя',
  `description` text COMMENT 'Описание',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `tbl_adaptabillity`
--

INSERT INTO `tbl_adaptabillity` (`id`, `detail_id`, `auto_model_id`, `engine_model_id`, `description`) VALUES
(1, 1, NULL, 1, NULL),
(2, 1, 2, 1, NULL),
(3, 2, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_analog_details`
--

CREATE TABLE IF NOT EXISTS `tbl_analog_details` (
  `original_id` int(11) NOT NULL COMMENT 'Оригинал',
  `analog_id` int(11) NOT NULL COMMENT 'Аналог',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  PRIMARY KEY (`original_id`,`analog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_analog_details`
--

INSERT INTO `tbl_analog_details` (`original_id`, `analog_id`, `sort`) VALUES
(1, 2, NULL),
(2, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_authassignment`
--

CREATE TABLE IF NOT EXISTS `tbl_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_authitem`
--

CREATE TABLE IF NOT EXISTS `tbl_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_authitemchild`
--

CREATE TABLE IF NOT EXISTS `tbl_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_auto_engines`
--

CREATE TABLE IF NOT EXISTS `tbl_auto_engines` (
  `auto_model_id` int(11) NOT NULL COMMENT 'Модель авто',
  `engine_id` int(11) NOT NULL COMMENT 'Модель двигателя',
  `VIN` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`auto_model_id`,`engine_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_auto_engines`
--

INSERT INTO `tbl_auto_engines` (`auto_model_id`, `engine_id`, `VIN`) VALUES
(2, 1, 'QWERT1234');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_auto_models`
--

CREATE TABLE IF NOT EXISTS `tbl_auto_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Модель',
  `brand_id` int(11) DEFAULT NULL COMMENT 'Марка',
  `img_photo` varchar(256) DEFAULT NULL COMMENT 'Фото',
  `description` text COMMENT 'Описание',
  `dt_release_date` date DEFAULT NULL COMMENT 'Дата выпуска',
  `dt_end_release_date` date DEFAULT NULL COMMENT 'Дата окончания выпуска',
  `number_doors` tinyint(2) DEFAULT NULL COMMENT 'Количество дверей',
  `engine_model_id` int(11) DEFAULT NULL COMMENT 'Модель двигателя',
  `bodytype_id` int(11) DEFAULT NULL COMMENT 'Тип кузова',
  `VIN` varchar(20) DEFAULT NULL COMMENT 'VIN',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_auto_models`
--

INSERT INTO `tbl_auto_models` (`id`, `name`, `brand_id`, `img_photo`, `description`, `dt_release_date`, `dt_end_release_date`, `number_doors`, `engine_model_id`, `bodytype_id`, `VIN`, `status`, `sort`, `create_time`, `update_time`) VALUES
(1, 'Hyundai V', 1, '9eed73880.png', '', '1969-12-31', '1969-12-31', 4, 1, 1, '', 1, 1, 1378805013, 1378805249),
(2, 'Hyundai Avanta', 1, '569a56e6a.png', '', '2013-09-03', '0000-00-00', NULL, 1, 1, '', 1, 2, 1378890423, 1379401466);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_bodytypes`
--

CREATE TABLE IF NOT EXISTS `tbl_bodytypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT 'Тип кузова',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_bodytypes`
--

INSERT INTO `tbl_bodytypes` (`id`, `name`) VALUES
(1, 'Седан'),
(2, 'Хэтчбек');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_brands`
--

CREATE TABLE IF NOT EXISTS `tbl_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(45) DEFAULT NULL COMMENT 'Идентификатор',
  `name` varchar(45) NOT NULL COMMENT 'Название',
  `img_logo` varchar(256) DEFAULT NULL COMMENT 'Логотип',
  `wswg_description` text COMMENT 'Описание',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_brands`
--

INSERT INTO `tbl_brands` (`id`, `alias`, `name`, `img_logo`, `wswg_description`, `status`, `sort`, `create_time`, `update_time`) VALUES
(1, 'Hyundai', 'Hyundai', '683ea23e5.jpg', '', 1, 1, 1378801577, NULL),
(2, 'Chevrolet', 'Chevrolet', '45b5de3d1.png', '', 1, 2, 1378801607, NULL),
(3, 'Daewoo', 'Daewoo', '8cc1c6b8f.png', '', 1, 3, 1378801622, NULL),
(4, 'Kia_Motors', 'Kia Motors', '71697328b.png', '', 1, 4, 1378801636, NULL),
(5, 'Ssang_Yong', 'Ssang Yong', '23ef86890.png', '', 1, 5, 1378801648, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_cart`
--

CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SID` varchar(20) NOT NULL COMMENT '№ карты',
  `user_id` int(11) DEFAULT NULL COMMENT 'Ссылка на пользователя',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=127 ;

--
-- Дамп данных таблицы `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `SID`, `user_id`) VALUES
(120, '5254e4487ec79', 0),
(121, '525529cc8972e', 30),
(111, '524d4d48eddf1', 1),
(119, '5253f28aa0a1e', 0),
(123, '525545ae60bc3', 0),
(124, '525631632a9c4', 0),
(126, '5257c59687929', 33);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_cart_details`
--

CREATE TABLE IF NOT EXISTS `tbl_cart_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL COMMENT 'Корзина',
  `detail_id` int(11) NOT NULL COMMENT 'Товар',
  `count` int(11) DEFAULT '0' COMMENT 'Количество',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Дамп данных таблицы `tbl_cart_details`
--

INSERT INTO `tbl_cart_details` (`id`, `cart_id`, `detail_id`, `count`, `status`, `create_time`, `update_time`) VALUES
(92, 111, 1, 7, 1, 1381392115, 1381401459),
(95, 111, 5, 4, 1, 1381393727, 1381393759),
(93, 111, 3, 1, 1, 1381393702, 1381393838),
(83, 121, 1, 5, 1, 1381313311, 1381313527),
(84, 123, 1, 1, 1, 1381377619, NULL),
(85, 123, 2, 1, 1, 1381377655, NULL),
(89, 124, 2, 1, 1, 1381381943, NULL),
(88, 124, 1, 3, 1, 1381381940, 1381382549);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_details`
--

CREATE TABLE IF NOT EXISTS `tbl_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article` varchar(45) NOT NULL COMMENT 'Артикул',
  `name` varchar(256) NOT NULL COMMENT 'Наименование детали',
  `price` decimal(10,2) NOT NULL COMMENT 'Стоимтость',
  `in_stock` int(11) DEFAULT '0' COMMENT 'В наличии',
  `dt_delivery_date` date DEFAULT NULL COMMENT 'Примерная дата доставки',
  `img_photo` varchar(256) DEFAULT NULL COMMENT 'Фото',
  `wswg_description` text COMMENT 'Описание',
  `brand_id` int(11) NOT NULL COMMENT 'Бренд',
  `category_id` int(11) NOT NULL COMMENT 'Категория',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  `discount` float NOT NULL DEFAULT '0' COMMENT 'Скидка',
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_details`
--

INSERT INTO `tbl_details` (`id`, `article`, `name`, `price`, `in_stock`, `dt_delivery_date`, `img_photo`, `wswg_description`, `brand_id`, `category_id`, `status`, `sort`, `create_time`, `update_time`, `discount`, `type`) VALUES
(1, '545151515', 'механизм натяжения ', 450.00, 1, '1969-12-31', '43524cedf.jpg', '<p>Описание</p>\r\n', 3, 3, 1, 2, 1378964026, 1379070546, 10, 0),
(2, '89898565', 'Рычаг', 965.00, 0, '1969-12-29', '40d645136.jpg', '', 1, 5, 1, 1, 1378980263, 1380867655, 0, 0),
(3, '787878', 'Краска', 500.00, 0, '1969-12-31', '593d5e7ce.jpg', NULL, 0, 0, 1, 3, 1380872047, 1380872310, 0, 2),
(4, 'AS45', 'Держатель', 500.00, 0, NULL, 'bf706e048.jpg', NULL, 0, 0, 1, 4, 1380872483, NULL, 0, 1),
(5, 'R970AC300K', 'Набор автомобилиста. Огнетушитель, трос, аптечка, знак, жилет, перчатки.', 3500.00, 0, '1969-12-31', '0c57de2e7.jpg', NULL, 4, 0, 1, 5, 1380875114, 1380875132, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_detail_category`
--

CREATE TABLE IF NOT EXISTS `tbl_detail_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Наименование детали',
  `parent_id` int(11) DEFAULT NULL COMMENT 'Родительская категория',
  `level` tinyint(4) DEFAULT NULL COMMENT 'Вложенность',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `tbl_detail_category`
--

INSERT INTO `tbl_detail_category` (`id`, `name`, `parent_id`, `level`) VALUES
(1, 'Двигатель', NULL, 0),
(2, 'Генератор', 1, 1),
(3, 'Воздушный фильтр', 1, 1),
(4, 'Трансмиссия', NULL, 0),
(5, 'Карданный вал', 4, 1),
(6, 'Коленвал', 1, 1),
(7, 'Аксессуары', NULL, 0),
(8, 'Расходные материалы', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_email_recipients`
--

CREATE TABLE IF NOT EXISTS `tbl_email_recipients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL COMMENT 'email получателя',
  `template_id` int(11) DEFAULT '0' COMMENT 'Ссылка на шаблон',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_email_templates`
--

CREATE TABLE IF NOT EXISTS `tbl_email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название шаблона',
  `alias` varchar(255) DEFAULT NULL COMMENT 'Идентификатор шаблона',
  `subject` varchar(255) NOT NULL COMMENT 'Тема письма',
  `from` varchar(255) NOT NULL COMMENT 'От кого',
  `send_interval` int(11) DEFAULT NULL COMMENT 'Периодичность рассылки',
  `last_send_date` datetime DEFAULT NULL COMMENT 'Дата последней рассылки',
  `send_status` tinyint(4) DEFAULT NULL COMMENT 'Статус рассылки',
  `content` text NOT NULL COMMENT 'Шаблон письма',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_email_vars`
--

CREATE TABLE IF NOT EXISTS `tbl_email_vars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Имя переменной',
  `value` text COMMENT 'Значение переменной',
  `template_id` int(11) DEFAULT '0' COMMENT 'Ссылка на шаблон',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_engines`
--

CREATE TABLE IF NOT EXISTS `tbl_engines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT 'Название',
  `volume` float DEFAULT NULL COMMENT 'Объем двигателя',
  `fuel` tinyint(4) DEFAULT NULL COMMENT 'Тип топлива',
  `power` float DEFAULT NULL COMMENT 'Мощность',
  `description` text COMMENT 'Описание',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tbl_engines`
--

INSERT INTO `tbl_engines` (`id`, `name`, `volume`, `fuel`, `power`, `description`, `status`, `sort`, `create_time`, `update_time`) VALUES
(1, 'V', 45, 1, 45, '', NULL, 1, 1378801812, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  `module` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`, `module`) VALUES
('m000000_000000_base_auth', 1378801432, 'auth'),
('m000000_000000_base_core', 1378801431, 'core'),
('m000000_000000_base_email', 1378801432, 'email'),
('m000000_000000_base_user', 1378801425, 'user'),
('m110805_153437_installYiiUser', 1378801430, 'user'),
('m110810_162301_userTimestampFix', 1378801431, 'user'),
('m130711_095829_create_gallery_tables', 1378801432, 'core'),
('m130811_142229_settings', 1378801432, 'core'),
('m130830_115831_email_initial', 1378801432, 'email'),
('m130903_080921_auth_init', 1378801435, 'auth'),
('m130909_075303_brands', 1378801435, 'core'),
('m130910_053607_auto_models', 1378801435, 'core'),
('m130910_054201_bodytypes', 1378801435, 'core'),
('m130910_054417_engines', 1378801435, 'core'),
('m130911_040005_user_cars', 1379590607, 'core'),
('m130911_092413_detail_category', 1378891617, 'core'),
('m130912_050318_details', 1378963347, 'core'),
('m130912_054509_adaptabillity', 1378964897, 'core'),
('m130912_104629_user_cars_STO', 1379590607, 'core'),
('m130913_103701_analog_details', 1379068929, 'core'),
('m130916_072538_auto_engines', 1379316655, 'core'),
('m130916_111614_orders', 1379590607, 'core'),
('m130916_114341_user_involces', 1379590607, 'core'),
('m130920_061851_cart', 1379658170, 'core'),
('m130920_062824_cart_details', 1379658794, 'core'),
('m130927_114602_pages', 1380283114, 'core'),
('m131002_044417_orders', 1380710222, 'core');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_orders`
--

CREATE TABLE IF NOT EXISTS `tbl_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SID` varchar(20) DEFAULT NULL COMMENT 'Номер заказа',
  `paytype` varchar(20) NOT NULL COMMENT 'Способ оплаты',
  `order_status` int(2) DEFAULT NULL COMMENT 'Текщий статус заказа',
  `cart_id` int(11) DEFAULT NULL COMMENT 'Номер корзины',
  `recipient_firstname` varchar(45) NOT NULL COMMENT 'Имя получателя',
  `recipient_family` varchar(45) NOT NULL COMMENT 'Фамилия получателя',
  `recipient_lastname` varchar(45) NOT NULL COMMENT 'Отчество получателя',
  `client_comment` text COMMENT 'Комментарий заказчика',
  `client_email` varchar(100) NOT NULL COMMENT 'Email заказчика',
  `client_phone` varchar(20) NOT NULL COMMENT 'Телефон заказчика',
  `order_date` datetime DEFAULT NULL COMMENT 'Дата заказа',
  `delivery_date` date DEFAULT NULL COMMENT 'Примерная дата доставки',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `SID`, `paytype`, `order_status`, `cart_id`, `recipient_firstname`, `recipient_family`, `recipient_lastname`, `client_comment`, `client_email`, `client_phone`, `order_date`, `delivery_date`, `status`, `sort`, `create_time`, `update_time`) VALUES
(1, NULL, 'sberbank', NULL, 111, 'Максим', 'Рочев', 'Кузьмич', '', 'support@amobile-studio.ru', '89129541116', NULL, NULL, NULL, 1, 1380803693, NULL),
(2, NULL, 'mastercard', NULL, 121, 'Максим', 'Рочев', 'Кузьмич', NULL, 'support@amobile-studio.ru', '89129541116', NULL, NULL, NULL, 2, 1381313999, NULL),
(3, NULL, 'visa', NULL, 111, 'Максим', 'Рочев', 'Кузьмич', NULL, 'support@amobile-studio.ru', '89224795149', NULL, NULL, NULL, 3, 1381393899, NULL),
(4, NULL, 'visa', NULL, 111, 'Максим', 'Рочев', 'Кузьмич', NULL, 'support@amobile-studio.ru', '89224795149', NULL, NULL, NULL, 4, 1381395690, NULL),
(5, NULL, 'visa', NULL, 111, 'Максим', 'Рочев', 'Кузьмич', NULL, 'support@amobile-studio.ru', '89224795149', NULL, NULL, NULL, 5, 1381395973, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_pages`
--

CREATE TABLE IF NOT EXISTS `tbl_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'Название',
  `alias` varchar(255) DEFAULT NULL COMMENT 'Идентификатор',
  `menu_title` varchar(255) DEFAULT NULL COMMENT 'Название в меню',
  `wswg_content` text COMMENT 'Контент',
  `section` int(11) NOT NULL DEFAULT '0' COMMENT 'Раздел',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_key` text,
  `meta_description` text,
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `title`, `alias`, `menu_title`, `wswg_content`, `section`, `meta_title`, `meta_key`, `meta_description`, `status`, `sort`, `create_time`, `update_time`) VALUES
(1, 'Как добраться', 'kak_dobratsya', 'Как добраться', '<p>Пустая страница</p>\r\n', 0, 'Как добраться', '', '', 1, 1, 1380284128, 1380285508),
(2, 'Подобрать запчасть', 'podobrat_zapchast', 'Подобрать запчасть', '<p>Пустая страница</p>', 1, 'Подобрать запчасть', '', '', 1, 2, 1380353208, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(100) NOT NULL DEFAULT '',
  `jur_name` varchar(255) NOT NULL DEFAULT '',
  `INN` varchar(40) NOT NULL DEFAULT '',
  `KPP` varchar(40) NOT NULL DEFAULT '',
  `account_number` varchar(40) NOT NULL DEFAULT '',
  `director_fio` varchar(100) NOT NULL DEFAULT '',
  `taxation_system` int(2) NOT NULL DEFAULT '0',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `BIC` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `first_name`, `last_name`, `company_name`, `jur_name`, `INN`, `KPP`, `account_number`, `director_fio`, `taxation_system`, `phone`, `BIC`) VALUES
(1, 'Administrator', 'Admin', '', '', '', '', '', '', 0, '', ''),
(30, 'Максим', 'Рочев', '', '', '', '', '', '', 2, '9224795149', ''),
(32, 'Максим', 'Рочев', '', '', '', '', '', '', 0, '9224795149', ''),
(33, 'Максим', 'Рочев', '', '', '', '', '', '', 0, '9224795149', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` text,
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` text,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'first_name', 'First Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(2, 'last_name', 'Last Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'company_name', 'Наименовании организации', 'VARCHAR', 100, 0, 2, '', '', '', '', '', '', '', 1, 3),
(4, 'jur_name', 'Наименование юр. лица', 'VARCHAR', 255, 0, 2, '', '', '', '', '', '', '', 2, 3),
(5, 'INN', 'ИНН', 'VARCHAR', 40, 0, 2, '', '', '', '', '', '', '', 4, 3),
(6, 'KPP', 'КПП', 'VARCHAR', 40, 0, 2, '', '', '', '', '', '', '', 4, 3),
(7, 'account_number', 'Номер рачсетного счета', 'VARCHAR', 40, 0, 2, '', '', '', '', '', '', '', 5, 3),
(8, 'director_fio', 'ФИО руководителя', 'VARCHAR', 100, 0, 2, '', '', '', '', '', '', '', 3, 3),
(9, 'taxation_system', 'Система налогообложения', 'INTEGER', 2, 0, 2, '', '0==Общая;1==УСН;2==ЕНВД;3==ЕСХН', '', '', '0', '', '', 7, 3),
(10, 'phone', 'Телефон (10 цифр)', 'VARCHAR', 20, 0, 1, '', '', 'Неправильно введен номер телефона', '{"match":{"pattern":"/^[0-9]{10,10}+$/"}}', '', '', '', 0, 3),
(11, 'BIC', 'БИК банка', 'VARCHAR', 100, 0, 2, '', '', '', '', '', '', '', 6, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_settings`
--

CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `option` varchar(255) NOT NULL COMMENT 'Параметр',
  `value` varchar(256) DEFAULT NULL COMMENT 'Значение',
  `label` varchar(255) DEFAULT NULL COMMENT 'Название',
  `type` varchar(20) DEFAULT NULL COMMENT 'Тип поля для ввода',
  `ranges` text COMMENT 'Возможные значения',
  PRIMARY KEY (`option`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_settings`
--

INSERT INTO `tbl_settings` (`option`, `value`, `label`, `type`, `ranges`) VALUES
('address', 'г Тюмень, ул. Ордженекидзе, 112', 'Адрес магазина', NULL, NULL),
('order_phone', '8 (999) 464- 456- 998', 'Стол заказов', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `discount` float NOT NULL DEFAULT '0',
  `user_type` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `superuser`, `status`, `create_at`, `lastvisit_at`, `discount`, `user_type`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '7be4f0736cb97869458a20fc34a663b0', 1, 1, '2013-09-10 08:23:50', '2013-10-12 06:07:41', 0, 0),
(30, '', '200820e3227815ed1756a6b531e7e0d2', 'support@amobile-studio.ru', 'ec2485ab44b939d7f660b0f944eef7fb', 0, 1, '2013-10-09 09:59:12', '0000-00-00 00:00:00', 0, 1),
(32, '', '200820e3227815ed1756a6b531e7e0d2', 'support2@amobile-studio.ru', '108fe1532b9f87ba0011dc4acd41ae69', 0, 1, '2013-10-10 06:42:35', '0000-00-00 00:00:00', 0, 0),
(33, '', '200820e3227815ed1756a6b531e7e0d2', 'support3@amobile-studio.ru', '081c962965ede0d3f1ca62186815b18f', 0, 1, '2013-10-11 09:31:36', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user_cars`
--

CREATE TABLE IF NOT EXISTS `tbl_user_cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(45) NOT NULL COMMENT 'Марка авто',
  `model` varchar(45) DEFAULT NULL COMMENT 'Модель авто',
  `year` tinyint(4) DEFAULT NULL COMMENT 'Год выпуска',
  `VIN` varchar(20) DEFAULT NULL COMMENT 'ВИН',
  `mileage` float DEFAULT NULL COMMENT 'Пробег',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `tbl_user_cars`
--

INSERT INTO `tbl_user_cars` (`id`, `brand`, `model`, `year`, `VIN`, `mileage`, `status`, `sort`, `create_time`, `update_time`, `user_id`) VALUES
(11, 'asdfsfds', 'sdfdsf', NULL, '', NULL, NULL, 5, 1381476305, 1381486156, 1),
(3, 'werdfsd', 'dfdf', NULL, '', NULL, NULL, 3, 1381311929, NULL, 28);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user_cars_STO`
--

CREATE TABLE IF NOT EXISTS `tbl_user_cars_STO` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_car_id` int(11) NOT NULL COMMENT 'ID автомобиля пользователя',
  `maintenance_date` datetime DEFAULT NULL COMMENT 'Дата прохождения ТО',
  `maintenance_name` varchar(45) DEFAULT NULL COMMENT 'Название ТО',
  `maintenance_type` text COMMENT 'Вид работ',
  `maintenance_cost` float DEFAULT NULL COMMENT 'Сумма затрат',
  `azs_cost` float DEFAULT NULL COMMENT 'Затраты на АЗС',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `tbl_user_cars_STO`
--

INSERT INTO `tbl_user_cars_STO` (`id`, `user_car_id`, `maintenance_date`, `maintenance_name`, `maintenance_type`, `maintenance_cost`, `azs_cost`, `status`, `sort`, `create_time`, `update_time`) VALUES
(8, 13, '0000-00-00 00:00:00', '', '9', NULL, NULL, NULL, 2, 1381482230, 1381483753),
(7, 13, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1381481994, 1381482221),
(9, 11, '0000-00-00 00:00:00', 'Наименование работ', '3', 500, 300, NULL, 3, 1381486537, 1381490476);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user_involces`
--

CREATE TABLE IF NOT EXISTS `tbl_user_involces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(45) DEFAULT NULL COMMENT 'Номер счета',
  `date` datetime DEFAULT NULL COMMENT 'Дама',
  `cost` varchar(45) DEFAULT NULL COMMENT 'Стоимость',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Статус',
  `attache_file` varchar(256) DEFAULT NULL COMMENT 'Файл',
  `user_id` int(11) DEFAULT NULL COMMENT 'ID пользователя',
  `sort` int(11) DEFAULT NULL COMMENT 'Вес для сортировки',
  `create_time` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `update_time` int(11) DEFAULT NULL COMMENT 'Дата последнего редактирования',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_authassignment`
--
ALTER TABLE `tbl_authassignment`
  ADD CONSTRAINT `tbl_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_authitemchild`
--
ALTER TABLE `tbl_authitemchild`
  ADD CONSTRAINT `tbl_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
