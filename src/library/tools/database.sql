-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-11-2011 a las 00:25:48
-- Versión del servidor: 5.1.50
-- Versión de PHP: 5.3.8-ZS5.5.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `vassilymas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`name`),
  UNIQUE KEY `order` (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcar la base de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`, `order`) VALUES
(1, 'living', 1),
(2, 'comedor', 2),
(3, 'cocina', 3),
(4, 'baño', 4),
(5, 'escritorio', 5),
(6, 'dormitorio', 6),
(7, 'niños', 7),
(8, 'jardin', 8),
(9, 'accesorios', 9),
(10, 'outlet', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(45) NOT NULL,
  `key` varchar(45) NOT NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY (`id`,`key`,`value`,`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `configuration`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Contact_User1` (`User_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `contact`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactdata`
--

CREATE TABLE IF NOT EXISTS `contactdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Contact_id` int(10) unsigned NOT NULL,
  `field` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`,`Contact_id`,`field`),
  KEY `fk_ContactData_Contact1` (`Contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `contactdata`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`products_id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_images_products1` (`products_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Volcar la base de datos para la tabla `images`
--

INSERT INTO `images` (`id`, `products_id`, `name`) VALUES
(1, 1, 'img_4e87955716e43p16b0pugkj1mjhu5irob1ic2ta6.jpg'),
(2, 1, 'img_4e87955728bd4p16b0pugkj1q941uqk1kvj114j1t4c8.jpg'),
(3, 1, 'img_4e87955737038p16b0pugkj1t9f8ldkgh176810rl7.jpg'),
(4, 1, 'img_4e8795574b953p16b0pugkjicfk7s1jni1ide1vi55.jpg'),
(5, 2, 'img_4e882e7b8d8acp16b1v9rorifj15q718110p51fei5.jpg'),
(6, 3, 'img_4e88d6948fc4cp16b38c8o37rbl9589514n5mn95.jpg'),
(7, 4, 'img_4e88d725509f3p16b38gnkn8g86u6m1r8c1k3m5.jpg'),
(8, 5, 'img_4e88d83dbb36fp16b38p61e149q1r3nhs1pf31svq5.jpg'),
(9, 6, 'img_4e88d90d3fd06p16b38vg411ub1em3jto1lejlm45.jpg'),
(12, 8, 'img_4e88d9fa80fa3p16b396o3s1pj9ef81c781gkde7h5.jpg'),
(13, 11, 'img_4e88daff515b9p16b39e68m1f3uqqqqes16dn12sg5.jpg'),
(14, 12, 'img_4e88dc5480969p16b39p4d51c7qcjv1dnd1src1ov05.jpg'),
(15, 12, 'img_4e88dc548fa11p16b39p4d51k8l7fb1vg01li51dkt6.jpg'),
(16, 12, 'img_4e88dc549ea88p16b39p4d53ep8pj6cs1q7s1ul67.jpg'),
(17, 12, 'img_4e88dc54aeedcp16b39p4d5miet23l5u27oap8.jpg'),
(18, 13, 'img_4e88dc8162894p16b39qgfs133v97i1k5n1obq1ih85.jpg'),
(19, 13, 'img_4e88dc81711d7p16b39qgft1jvvmecb2f1ll3jb36.jpg'),
(20, 13, 'img_4e88dc817f59dp16b39qgft3ph705e0vpt14su8.jpg'),
(21, 13, 'img_4e88dc818d92dp16b39qgft43hl4t18r21nch15vo7.jpg'),
(22, 14, 'img_4e88dcc3ef080p16b39sh7u14egdvdm4o1rag4rf6.jpg'),
(23, 14, 'img_4e88dcc409b3ep16b39sh7ub7e1faj9hs3p15a88.jpg'),
(24, 14, 'img_4e88dcc418812p16b39sh7ugou9e66qi17kir1o5.jpg'),
(25, 14, 'img_4e88dcc425f3bp16b39sh7uj1a1bs0ts41qik1ss77.jpg'),
(29, 16, 'img_4e88e37ea92a1p16b3bh3bk1oal8on1dhp1nio1get6.jpg'),
(30, 16, 'img_4e88e37eb83b4p16b3bh3bk21i1u5h1j921uod1voo5.jpg'),
(38, 9, 'img_4e8905a378b32p16b3jrqumn2ocso7o5jdvpqd5.jpg'),
(39, 9, 'img_4e8905e4eccccp16b3jtrc3ph6p6k1klrt161hvp5.jpg'),
(40, 9, 'img_4e8905fc73138p16b3juf2kvto1rt41v7q1ue91ma45.jpg'),
(41, 9, 'img_4e8905fc82a06p16b3juivkk7j13em1l1jftpmqu6.jpg'),
(42, 18, 'img_4e8d23c747121p16bbl7cmrmai1ohauq812d91ph05.jpg'),
(43, 19, 'img_4e8d240fd0f56p16bbl9ll8n331kqa10tra4b1qlk5.jpg'),
(44, 20, 'img_4e8d2f892d984p16bbo3a211kvifkh1sc0knkhta5.jpg'),
(45, 21, 'img_4e8d318e277a3p16bboj2eo2slpvh1kei1p4p95l5.jpg'),
(48, 35, 'img_4eac735520a77p16d8q4op8171g12u2enebr818c74.jpg'),
(49, 36, 'img_4eac7374f3cfcp16d8q5t3ak016vqhgehq9155n4.jpg'),
(51, 38, 'img_4eac74048c9c3p16d8qab6u1km11l7t130eqm11r4a4.jpg'),
(52, 39, 'img_4eac7429c1925p16d8qbe9esov1jpm2didg12204.jpg'),
(57, 41, 'img_4ebb01ee5f03fp16e57v1sg1feg3ko12qeain13k54.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Product` int(11) DEFAULT NULL,
  `Order` int(10) unsigned NOT NULL,
  `price` float(15,2) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `sku` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`,`Order`),
  KEY `fk_OrderDetail_Orders1` (`Order`),
  KEY `fk_OrderDetail_products1` (`Product`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Volcar la base de datos para la tabla `orderdetail`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ordernumber` varchar(45) NOT NULL,
  `User` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orderNumber_UNIQUE` (`ordernumber`),
  KEY `fk_Order_User1` (`User`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `ordernumber`, `User`, `created_at`) VALUES
(2, '4ecc4c7ea5eb3', 2, '2011-11-22 22:11:34'),
(3, '4ecc4c8a451ef', 2, '2011-11-22 22:11:46'),
(6, '4eb202479fb64', 36, '2011-11-02 23:11:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Rol` int(10) unsigned NOT NULL,
  `Resource` int(11) NOT NULL,
  PRIMARY KEY (`id`,`Rol`,`Resource`),
  KEY `fk_Privilege_Rol1` (`Rol`),
  KEY `fk_Privilege_Resource1` (`Resource`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `privilege`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(100) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `price` float(15,2) NOT NULL,
  `width` float(15,2) DEFAULT '0.00',
  `height` float(15,2) DEFAULT '0.00',
  `depth` float(15,2) DEFAULT '0.00',
  `materials` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Volcar la base de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `description`, `price`, `width`, `height`, `depth`, `materials`) VALUES
(1, NULL, 'Sofa Lindo', '<p>la descripcion de mi sofa</p>', 99.00, 33.00, 33.00, 33.00, '<p>los materiales!</p>'),
(2, NULL, 'banquito', '', 89.00, 55.00, 44.00, 77.00, ''),
(3, NULL, 'una silla que no se desforma', '<p>asdas</p>', 33.00, 343.00, 34.00, 343.00, '<p>asdasd</p>'),
(4, NULL, 'silla 2 & silla', '<p>sadas</p>', 34.00, 34.00, 34.00, 34.00, '<p>sdasd</p>'),
(5, NULL, 'lalala', '<p>asdsad</p>', 445.00, 455.00, 45.00, 45.00, '<p>sdfsdf</p>'),
(6, NULL, 'lt', '<p>vfcv</p>', 454.00, 45.00, 45.00, 45.00, '<p>dccf</p>'),
(8, NULL, 'asdasd', '<p>asdas</p>', 44.00, 45.00, 45.00, 45.00, '<p>asdasd</p>'),
(9, NULL, 'asdas', '<p>asddas</p>', 44.00, 33.00, 33.00, 33.00, '<p>asdas</p>'),
(11, NULL, 'asdas', '<p>asdsa</p>', 33.00, 33.00, 33.00, 33.00, '<p>asdasd</p>'),
(12, NULL, 'asdasd', '<p>asd</p>', 33.00, 33.00, 33.00, 33.00, '<p>sadasd</p>'),
(13, NULL, 'asasd', '<p>sadasdsa</p>', 333.00, 33.00, 33.00, 33.00, '<p>asdsa</p>'),
(14, NULL, 'assad', '<p>4asdasd</p>', 44.00, 44.00, 44.00, 44.00, '<p>asdasd</p>'),
(16, NULL, 'aaSAD', '<p>ASD</p>', 44.00, 44.00, 44.00, 44.00, '<p>sdf</p>'),
(18, NULL, 'vvvvv', '<p>kjhkhj</p>', 66.00, 55.00, 55.00, 555.00, '<p>jhjkhjh</p>'),
(19, NULL, 'dddd', '<p>ddddd</p>', 33.00, 33.00, 33.00, 33.00, '<p>dddddddd</p>'),
(20, NULL, 'gggggggg', '<p>g</p>', 6.00, 6.00, 6.00, 6.00, '<p>g</p>'),
(21, NULL, 'xxxxx', '<p>fdf</p>', 44.00, 55.00, 55.00, 55.00, '<p>gfg</p>'),
(22, NULL, 'algo en ñ', '<p>&ntilde;&ntilde;&ntilde;</p>\n<p>&nbsp;</p>', 999.00, 88.00, 88.00, 88.00, '<p>&ntilde;&ntilde;&ntilde;&ntilde;</p>'),
(35, NULL, 'dddddddddddddddddd', '<p>ddddd</p>', 444.00, 4544.00, 444.00, 44.00, '<p>dsds</p>'),
(36, NULL, 'zzzzz', '<p>fgh</p>', 77.00, 77.00, 77.00, 77.00, '<p>gfhfgh</p>'),
(38, NULL, 'listo', '<p>sadasd</p>', 444.00, 44.00, 44.00, 44.00, '<p>asd</p>'),
(39, NULL, 'en jardin jj', '<p>en jardin jj</p>', 33.00, 33.00, 33.00, 33.00, '<p>en jardin jj</p>'),
(41, NULL, 'asdasdsad', '<p>asdasd</p>', 555.00, 55.00, 55.00, 55.00, '<p>sadfasdf</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_UNIQUE` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `resource`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) NOT NULL,
  `inherit` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol_UNIQUE` (`rol`),
  KEY `fk_Rol_Rol1` (`inherit`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`, `inherit`) VALUES
(1, 'guest', NULL),
(2, 'user', 1),
(3, 'admin', 2),
(4, 'super', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`,`Category`),
  KEY `fk_subcategories_category` (`Category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcar la base de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`id`, `Category`, `name`, `order`) VALUES
(1, 2, 'sillas & sillones', 2),
(2, 2, 'bancos & banquetas', 1),
(3, 2, 'aparadores & mas', 4),
(4, 2, 'cristales & vajilleros', 5),
(5, 2, 'bibliotecas & estanterias', 6),
(6, 2, 'lamparas & veladores', 1),
(7, 2, 'varios', 3),
(8, 1, 'sofas', 0),
(19, 1, 'iluminación lalala ñ í &', 1),
(23, 1, 'nueva subcategoria ñ &', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories_has_products`
--

CREATE TABLE IF NOT EXISTS `subcategories_has_products` (
  `subcategories_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  PRIMARY KEY (`subcategories_id`,`products_id`),
  KEY `fk_subcategories_has_products_products1` (`products_id`),
  KEY `fk_subcategories_has_products_subcategories1` (`subcategories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcar la base de datos para la tabla `subcategories_has_products`
--

INSERT INTO `subcategories_has_products` (`subcategories_id`, `products_id`) VALUES
(8, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 8),
(1, 9),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(1, 16),
(5, 16),
(7, 16),
(1, 18),
(19, 19),
(23, 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Rol` int(10) unsigned NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(32) NOT NULL,
  `confirmation_code` varchar(45) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `reset_code` varchar(32) DEFAULT NULL,
  `timestamp_reset_code` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`Rol`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_User_Rol1` (`Rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Volcar la base de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `Rol`, `username`, `email`, `password`, `confirmation_code`, `active`, `reset_code`, `timestamp_reset_code`) VALUES
(1, 2, 'user', 'user@user.com', 'user', 'user', 1, NULL, NULL),
(2, 3, 'admin', 'admin@admin.com', 'admin', 'admin', 1, NULL, NULL),
(3, 4, 'super', 'super@super.com', 'super', 'super', 1, NULL, NULL),
(36, 2, 'enkil2003', 'enkil@fibertel.com.ar', 'rb3937', '4eb201d410ff0', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userdata`
--

CREATE TABLE IF NOT EXISTS `userdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User` int(10) unsigned NOT NULL,
  `field` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`,`User`,`field`),
  KEY `fk_UserData_User1` (`User`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=421 ;

--
-- Volcar la base de datos para la tabla `userdata`
--

INSERT INTO `userdata` (`id`, `User`, `field`, `value`) VALUES
(411, 36, 'name', 'Ricardo martin'),
(412, 36, 'lastname', 'Buquet'),
(413, 36, 'newsletter', '0'),
(414, 36, 'address', 'Ciudad De La Paz 1314'),
(415, 36, 'zip', '1426'),
(416, 36, 'city', 'Capital'),
(417, 36, 'province', 'Ciudad autónoma de Buenos Aires'),
(418, 36, 'phone', '47868495'),
(419, 36, 'celphone', '1521604950'),
(420, 36, 'aditionalData', 'ndfnññççá');

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_Contact_User1` FOREIGN KEY (`User_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contactdata`
--
ALTER TABLE `contactdata`
  ADD CONSTRAINT `fk_ContactData_Contact1` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `fk_OrderDetail_Orders1` FOREIGN KEY (`Order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_OrderDetail_products1` FOREIGN KEY (`Product`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_Order_User1` FOREIGN KEY (`User`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `privilege`
--
ALTER TABLE `privilege`
  ADD CONSTRAINT `fk_Privilege_Resource1` FOREIGN KEY (`Resource`) REFERENCES `resource` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Privilege_Rol1` FOREIGN KEY (`Rol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
  ADD CONSTRAINT `fk_Rol_Rol1` FOREIGN KEY (`inherit`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `fk_subcategories_category` FOREIGN KEY (`Category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subcategories_has_products`
--
ALTER TABLE `subcategories_has_products`
  ADD CONSTRAINT `fk_subcategories_has_products_subcategories1` FOREIGN KEY (`subcategories_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subcategories_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_Rol1` FOREIGN KEY (`Rol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `userdata`
--
ALTER TABLE `userdata`
  ADD CONSTRAINT `fk_UserData_User1` FOREIGN KEY (`User`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
