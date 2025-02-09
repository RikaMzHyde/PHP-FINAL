-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-02-2025 a las 17:12:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuarios_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `categoria` varchar(40) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`codigo`, `nombre`, `descripcion`, `categoria`, `precio`, `imagen`) VALUES
('DAU37753', 'Sopa Instantánea de Miso', 'Deliciosa sopa de miso tradicional agrega tofu frito, algas wakame y cebollas verdes para obtener sabores de sopa japonesa completos, abundantes y clásicos.', 'SOPAS', 4.99, 'productos/prd-sopa.png'),
('DZW36853', 'Galletas Shin Chan Banana', '¡Desde la marca favorita de Crayon Shin-chan, Chocobi, llega una edición limitada con un nuevo sabor: Banana! Este delicioso snack aparece en un packaging exclusivo.', 'GALLETAS', 2.95, 'productos/file (2).png'),
('INV49290', 'Kit Kat de Pink Lemonade', 'Disfruta del Kit Kat Pink Lemonade, una refrescante y deliciosa versión del clásico Kit Kat. Combina el crujiente de las obleas con una cobertura de sabor a limonada rosa.', 'DULCES Y SNACKS', 3.39, 'productos/INV492905ouZivZlwm.png'),
('JIF53242', 'Bebida Bubble Milk Tea', 'Ahora puedes disfrutar de tú Bubble Tea en casa, con auténticas bolitas de Tapioca y un exquisito té con leche al estilo Tailandes.', 'TES', 2.45, 'productos/prd-bubble-tea-rico-milk-japonshop.jpg'),
('NUM13241', 'Fideos Ramen Picante', 'Descubre el nuevo Sapporo Ichiban Cup Star BT21, una colaboración con los personajes LINE FRIENDS de BT21. Disfruta de fideos ramen combinados con sopa picante.', 'RAMEN', 2.49, 'productos/NUM13241Yi4UdchKHQ.png'),
('NUM13331', 'Bebida de Melocotón y Coco', 'Descubre la extraordinaria y divertida bebida de gelatina de coco con sabor a melocotón rosado (momo). Con una textura masticable y suave, menos azúcar y todo el sabor.', 'REFRESCOS', 2.59, 'productos/NUM13331file (3).png'),
('NUM14231', 'Té Verde con Matcha', 'Exquisito té verde Kuradash, extraído de las mejores hojas a dos temperaturas y combinado con Matcha. Edición limitada \"Rilakkuma\", con 4 diseños diferentes.', 'TES', 2.45, 'productos/prd-te-verde-kuradashi-matcha-edicion-limitada-rilakkuma-500-japonshop.png'),
('NUM17751', 'Caramelos de Frutas y Azuki ', 'Disfruta de un delicioso caramelo masticable con sabor a frutas y azuki y una suave cobertura que te recordará al hielo raspado tan característico de Japón.', 'CARAMELOS', 2.99, 'productos/prd-caramelos-blandos-helado-frutas-azuki-shirokuma-83-grs-japonshop_1.png'),
('NUM20241', 'Refresco Ocean Bomb Naranja', 'Disfruta del refresco Ocean Bomb de Naranja Edición Dragon Ball, con el auténtico sabor cítrico de la naranja y sin colorantes, totalmente transparente.', 'REFRESCOS', 2.46, 'productos/NUM20241oncrmnxGNm.png'),
('NUM22290', 'Sake Espumoso de Melocotón', 'Sake Dulce Espumoso de aroma fresco a melocotón rosado japonés. ¡Es el cava del Sake! Refrescante y muy ligero tan solo contiene un 7% de Alcohol.', 'OTRAS BEBIDAS', 9.99, 'productos/prd-sake-ozeki-sakura-momo-melocoton-japonshop.png'),
('NUM49940', 'Sticks Patata con 7 Vegetales', 'Sticks de Patatas Sapporo Potato Tubu-Tubu Disfruta de estos sticks elaborados con una cuidadosa mezcla de siete tipos de verduras, como calabaza en polvo, pasta de tomate, etc.', 'PATATAS', 3.19, 'productos/prd-snack-calbee-verduras-japonshop_2.png'),
('NUM54241', 'Milky Chocolate y Ramune', 'Chocolate Milky PekoChan Refresco Ramune, una edición limitada ideal para este invierno. Delicioso chocolate con leche que combina la frescura del ramune, crema y caramelo.', 'CHOCOLATES', 3.15, 'productos/prd-chocolate-pekochan-ramune-japonshop_1.png'),
('NUM90853', 'Cacahuetes al Wasabi', 'Los cacahuetes al wasabi Golden Turtle son cacahuetes cubiertos de wasabi. El wasabi proviene de la raíz de una planta semiacuática  y tiene un sabor cercano a la mostaza.', 'FRUTOS SECOS', 4.11, 'productos/cacahuete-wasabi.jpg'),
('OMP72558', 'Sticks de Patata de Salsa de Queso', 'Prueba los icónicos sticks Jagariko con su sabor más rompedor: Queso Cheddar. Una explosión de umami en cada mordisco, donde el delicioso gusto de patata asada inunda tu paladar', 'PATATAS', 2.99, 'productos/prd-sticks-jagariko-queso-calbee-55-grs-japonshop.jpg'),
('VUI00173', 'Sopa Instantánea de Crema de Maíz', '¡¡¡¡¡¡Me encanta la Sopa Instantánea de Crema de Maíz | Edición Pokemon !!!!!!\r\nCrema de maíz instantánea, con toppings de galletas saladas de Pokemon.', 'SOPAS', 0.99, 'productos/prd-sopa-maiz-pokemon-unidad-jap.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `codigo_articulo` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`id_detalle`, `id_pedido`, `codigo_articulo`, `precio`, `cantidad`) VALUES
(1, 5, 'INV49290', 3.39, 1),
(2, 6, 'INV49290', 3.39, 1),
(3, 7, 'INV49290', 3.39, 1),
(4, 8, 'NUM22290', 9.99, 1),
(5, 9, 'NUM13241', 2.49, 1),
(6, 10, 'DAU37753', 4.99, 1),
(7, 11, 'INV49290', 3.39, 1),
(8, 11, 'NUM13241', 2.49, 2),
(9, 12, 'DZW36853', 2.95, 1),
(10, 12, 'INV49290', 3.39, 1),
(11, 13, 'DAU37753', 4.99, 1),
(12, 13, 'DZW36853', 2.95, 1),
(13, 14, 'DAU37753', 4.99, 1),
(14, 14, 'DZW36853', 2.00, 1),
(15, 14, 'NUM14231', 2.45, 1),
(16, 14, 'NUM54241', 3.15, 1),
(17, 15, 'DAU37753', 4.99, 1),
(18, 15, 'DZW36853', 2.95, 1),
(19, 15, 'NUM14231', 2.45, 1),
(20, 15, 'NUM54241', 3.15, 1),
(21, 16, 'INV49290', 3.39, 1),
(22, 16, 'NUM13241', 2.49, 1),
(23, 16, 'DAU37753', 4.99, 1),
(24, 17, 'NUM13241', 2.49, 1),
(25, 17, 'DAU37753', 4.99, 1),
(26, 17, 'INV49290', 3.39, 1),
(27, 18, 'NUM13331', 2.59, 1),
(28, 19, 'INV49290', 3.39, 1),
(29, 21, 'INV49290', 3.39, 1),
(30, 22, 'INV49290', 3.39, 2),
(31, 23, 'NUM13241', 2.49, 1),
(32, 24, 'NUM13241', 2.49, 1),
(33, 25, 'NUM13241', 2.49, 1),
(34, 26, 'DAU37753', 4.99, 1),
(35, 26, 'DZW36853', 2.95, 1),
(36, 26, 'INV49290', 3.39, 1),
(37, 27, 'DAU37753', 4.99, 1),
(38, 27, 'NUM13241', 2.49, 1),
(39, 27, 'NUM13331', 2.59, 1),
(40, 28, 'DAU37753', 4.99, 1),
(41, 28, 'NUM13241', 2.49, 1),
(42, 28, 'NUM13331', 2.59, 1),
(43, 28, 'NUM14231', 2.45, 1),
(44, 28, 'NUM17751', 2.99, 1),
(45, 28, 'NUM20241', 2.46, 1),
(46, 28, 'NUM22290', 9.99, 1),
(47, 28, 'NUM49940', 3.19, 1),
(48, 28, 'NUM54241', 3.15, 1),
(49, 29, 'INV49290', 3.39, 1),
(50, 30, 'DZW36853', 2.95, 1),
(51, 31, 'INV49290', 3.39, 3),
(52, 32, 'NUM13241', 2.49, 1),
(53, 33, 'INV49290', 3.39, 1),
(54, 34, 'DZW36853', 2.95, 1),
(55, 34, 'INV49290', 3.39, 1),
(56, 34, 'NUM13241', 2.49, 1),
(57, 35, 'INV49290', 3.39, 1),
(58, 36, 'NUM22290', 9.99, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `Numero_pedido` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','En proceso','Completado','Cancelado') NOT NULL,
  `dni` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`Numero_pedido`, `fecha`, `total`, `estado`, `dni`) VALUES
(1, '2025-01-26 19:58:17', 3.39, 'Pendiente', '29057413H'),
(2, '2025-01-26 20:00:39', 8.38, 'Pendiente', '29057413H'),
(3, '2025-01-26 20:03:30', 8.38, 'Pendiente', '29057413H'),
(4, '2025-01-26 20:16:17', 3.39, 'Pendiente', '29057413H'),
(5, '2025-01-26 20:18:24', 3.39, 'Pendiente', '29057413H'),
(6, '2025-01-26 20:20:17', 3.39, 'Pendiente', '29057413H'),
(7, '2025-01-26 20:20:40', 3.39, 'Pendiente', '29057413H'),
(8, '2025-01-26 21:58:49', 9.99, 'Pendiente', '29057413H'),
(9, '2025-01-27 17:09:05', 2.49, 'Pendiente', '29057413H'),
(10, '2025-01-27 18:22:54', 4.99, 'Pendiente', '29057413H'),
(11, '2025-02-04 17:40:33', 8.37, 'Pendiente', '29057413H'),
(12, '2025-02-04 18:41:22', 6.34, 'Pendiente', '29057413H'),
(13, '2025-02-04 19:07:41', 7.94, 'Pendiente', '29057413H'),
(14, '2025-02-04 19:08:42', 13.54, 'Pendiente', '74366139D'),
(15, '2025-02-04 20:04:11', 13.54, 'Pendiente', '74366139D'),
(16, '2025-02-04 20:13:31', 10.87, 'Pendiente', '74366139D'),
(17, '2025-02-04 20:16:40', 10.87, 'Pendiente', '74366139D'),
(18, '2025-02-04 20:17:25', 2.59, 'Cancelado', '74366139D'),
(19, '2025-02-04 23:20:39', 3.39, 'Cancelado', '74366139D'),
(20, '2025-02-05 00:49:16', 0.00, 'Pendiente', '74366139D'),
(21, '2025-02-05 01:07:40', 3.39, 'Pendiente', '74366139D'),
(22, '2025-02-05 01:18:55', 6.78, 'Pendiente', '74366139D'),
(23, '2025-02-05 01:27:56', 2.49, 'Pendiente', '74366139D'),
(24, '2025-02-05 01:35:24', 2.49, 'Pendiente', '74366139D'),
(25, '2025-02-05 01:38:29', 2.49, 'Pendiente', '74366139D'),
(26, '2025-02-05 01:50:55', 11.33, 'Pendiente', '74366139D'),
(27, '2025-02-05 01:56:20', 10.07, 'Pendiente', '74366139D'),
(28, '2025-02-05 02:03:09', 34.30, 'Pendiente', '74366139D'),
(29, '2025-02-05 02:05:16', 3.39, 'Cancelado', '74366139D'),
(30, '2025-02-05 02:08:41', 2.95, 'Pendiente', '74366139D'),
(31, '2025-02-05 23:37:51', 10.17, 'Cancelado', '05149151A'),
(32, '2025-02-08 00:49:32', 2.49, 'Cancelado', '74017237V'),
(33, '2025-02-08 00:50:36', 3.39, 'Pendiente', '74366139D'),
(34, '2025-02-08 01:29:00', 8.83, 'Pendiente', '74366139D'),
(35, '2025-02-08 22:38:27', 3.39, 'Cancelado', '74017237V'),
(36, '2025-02-09 00:38:22', 9.99, 'Cancelado', '29058889E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(75) NOT NULL,
  `admin` tinyint(1) DEFAULT 0,
  `editor` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `nombre`, `direccion`, `localidad`, `provincia`, `telefono`, `email`, `password`, `admin`, `editor`) VALUES
('05149151A', 'Isabel', 'C/ Alcázar 2', 'Alicante', 'Alicante', '673411234', 'isa@gmail.com', '$2y$10$PCpGWNyAWGjUYHqKvTiwC.jmXzYQYqqfwWfbkT3WHVIDwR4XJ0PxG', 0, 0),
('18807927E', 'Edu', 'C/Huerta, 2', 'Alicante', 'Alicante', '672233112', 'edu@gmail.com', '$2y$10$0kR/ESsoHXYUOlkQJPAW7eezKIogyZPgpRDlc.7xuhavwXtDpKX.a', 1, 1),
('29058889E', 'Elvira', 'C/ Lardero', 'Madrid', 'Madrid', '634478901', 'elv@gmail.com', '$2y$10$PiGAZFIy92jbB07yFmFjx.ZV4p0b06WEeNIhO2KpYE08Um3Nhcsx.', 0, 0),
('42691358T', 'Teodoro', 'C/ falsa 123', 'Alicante', 'Alicante', '635567893', 'teo@gmail.com', '$2y$10$D/h7SwUiqckIQcevON3JYu4Zm7SDeHa6lW1WjqAEL8gAwCovjBe/e', 0, 0),
('43689471M', 'Marta', 'C/Gilabert', 'Alicante', 'Alicante', '653344221', 'marta@gmail.com', '$2y$10$kBBXVBXjiY/h0RVZfsX9UuaPboW4jPKPV4otTPx.F/zJNn3ESS8e2', 0, 0),
('54322310J', 'Javi', 'C/ Gilda, 12', 'Madrid', 'Madrid', '623345678', 'javi@gmail.com', '$2y$10$dYB0tGvolBtB.2xBB5PnaecpNbJ8v3hdkKwOgwu7NLHDX51BEGIRe', 0, 0),
('74017237V', 'Laura', 'C/Ciudad jardín', 'San Vicente', 'Alicante', '673344551', 'laura@gmail.com', '$2y$10$NVrOHY4uiADQKZM/IR2koeT41XR/J0lES8Sg6r0R/tX2yYpB60dq6', 1, 1),
('74366139D', 'Chris', 'Feder', 'Elche', 'Alica', '632200112', 'trnchris@gmail.com', '$2y$10$3OkJx.8s.qir5hOWRT3iTOXffAUhMjI0x2n0MrF3TJlS3qh4e/X6K', 0, 1),
('76590984H', 'Hugo', 'C/ Maldonado, 14', 'Madrid', 'Madrid', '690022331', 'hugo@gmail.com', '$2y$10$yLKzUSFcgyGahiydHTO9vugooHrHvaMV56KtPkVQwCPRqEf0.Rfcm', 0, 0),
('80387348W', 'Waldo', 'C/Africa', 'Elche', 'Alicante', '612312345', 'wal@gmail.com', '$2y$10$aA8vtln7ux.1AykbP.CYxeGiSWWT3fTJcbdUwivKHrkjKDYXWykWK', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`Numero_pedido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `Numero_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
