-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2024 a las 23:22:22
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
('DZW36853', 'Galletas Snack Shin Chan Banana Tokyo', '¡Desde la marca favorita de Crayon Shin-chan, Chocobi, llega una edición limitada con un nuevo sabor: Banana! Este delicioso snack aparece en un packaging exclusivo inspirado en la isla de Dinos Island, que aparece en la película de Shin-chan.', 'DULCES Y SNACKS', 2.95, 'productos/file (2).png'),
('INV49290', 'Kit Kat de Pink Lemonade', 'Disfruta del Kit Kat Pink Lemonade, una refrescante y deliciosa versión del clásico Kit Kat. Combina el crujiente de las obleas con una cobertura de vibrante sabor a limonada rosa, logrando el equilibrio perfecto entre dulzura y acidez.', 'DULCES Y SNACKS', 3.39, 'productos/INV492905ouZivZlwm.png'),
('NUM13241', 'Fideos Ramen Picante Sundubu Jjigae', 'Descubre el nuevo Sapporo Ichiban Cup Star BT21, una deliciosa colaboración con los personajes LINE FRIENDS de BT21. Disfruta de fideos ramen combinados con una sopa picante y llena de sabor.', 'RAMEN Y SOPAS', 2.49, 'productos/NUM13241Yi4UdchKHQ.png'),
('NUM13331', 'Bebida Coreana de Melocotón Momo y Coco Jelly', 'Descubre la extraordinaria y divertida bebida de gelatina de coco con sabor a melocotón rosado (momo). Con una textura masticable y suave, menos azúcar (-28%) y concentrado de fruta real, es una opción deliciosa y ligera. Además, su diseño con personajes de Pokémon hace que sea aún más irresistible.', 'BEBIDAS', 2.59, 'productos/NUM13331file (3).png'),
('NUM20241', 'Refresco Clear Ocean Bomb Naranja', 'Disfruta del refresco Ocean Bomb de Naranja Edición Dragon Ball, con el auténtico sabor cítrico de la naranja y sin colorantes, totalmente transparente. Con la imagen icónica de Shenlong, esta edición especial es perfecta para fans y coleccionistas de Dragon Ball.', 'BEBIDAS', 2.46, 'productos/NUM20241oncrmnxGNm.png');

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
('29057413H', 'Hugoaso', 'Calle Arrzon', 'Alciante', 'Alicante', '612233445', 'hugo@dominio.com', '$2y$10$ufk6RpjofOzSz4kTEiBNn.TcpMsDS/oLvr1IVqKGIlWXU6IVAiNNa', 0, 1),
('33389031W', 'Fitipaldi', 'Calle villuela, 19', 'San Vicente', 'Alicante', '642255669', 'fito@gmail.com', '$2y$10$0vYYnQe.LGrFFhKKfRE2YOxwFNHyb9rm4QiGIAforYeABXwe8UiyW', 1, 1),
('53033469T', 'Tatiana', 'Calle Dolores, 62', 'Alicante', 'Alicante', '612233445', 'tati@gmail.com', '$2y$10$3cP8JDsLiYXNgptdbORrEeqZhkyb62gTmP/xMzjDjp7.a4CssSboa', 0, 0),
('60368927E', 'Elmer', 'Calle falsa 123', 'Alicante', 'Alicante', '888888888', 'elmer@gmail.com', '$2y$10$TC.MuDhkkCmncol1TFl8ROf86eFr3PNiMFQJ6AV4/tmsqmi.K7IBW', 1, 1),
('62116894N', 'Nuria', 'Calle Lagos 6', 'Alicante', 'Alicante', '678811990', 'nuria@gmail.com', '$2y$10$v8DSjsjxOZl88lIVtnbKO.l4mIPhE5708.s5VAEKTJZPabweeVACy', 0, 1),
('74017237V', 'Laura', 'C/Ciudad jardín', 'San Vicente', 'Alicante', '673344551', 'laura@gmail.com', '$2y$10$NVrOHY4uiADQKZM/IR2koeT41XR/J0lES8Sg6r0R/tX2yYpB60dq6', 1, 1),
('83102934K', 'Kim', 'C/ Albuquerque', 'Alicante', 'Alicante', '634410237', 'kim@gmail.com', '$2y$10$puPw5DAueqj4nuNL2JRIlOZEtR6dKfp8oGfqNU0pxASJQjYZQijlq', 1, 1),
('83186230Z', 'Zara', 'asdsa', 'asd', 'asd', '999999999', 'z@z.com', '$2y$10$KN6e3PXkHLWsKogxJKNWX.ec7zWPRCSX598JrVGJb0ixwYf8USg0S', 1, 1),
('83647123J', 'Javier', 'Calle Raspas', 'Alicante', 'Alicante', '634451892', 'jav@hotmail.com', '$2y$10$JtrfieaEoXW.po88t/w9DuMsTfT8LzrHXQ3b2xgb492g441becwzm', 1, 1),
('96545804S', 'Sara', 'asds', 'qasdas', 'asdsd', '111111111', 'a@a.com', '$2y$10$.ust4Skrmr7M55E2T5yObux3WxW1nQHsu0LaOIjwqfKtJtUa1GC46', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
