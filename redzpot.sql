-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2019 a las 20:23:43
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `redzpot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `bit_id` int(11) NOT NULL,
  `bit_query` text NOT NULL,
  `usr_id` int(11) NOT NULL,
  `bit_fecha` datetime NOT NULL,
  `bit_ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cli_id` int(11) NOT NULL,
  `cli_rfc` varchar(13) NOT NULL,
  `cli_nom_empresa` varchar(150) NOT NULL,
  `cli_nom_representante` varchar(100) DEFAULT NULL,
  `cli_tel_representante` varchar(12) DEFAULT NULL,
  `cli_tel_empresa` varchar(12) DEFAULT NULL,
  `cli_correo_empresa` varchar(80) DEFAULT NULL,
  `cli_direccion` text,
  `cli_activo` tinyint(4) NOT NULL DEFAULT '0',
  `cli_fecha_vigencia` date NOT NULL,
  `cli_logo` text,
  `cli_slogan` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cli_id`, `cli_rfc`, `cli_nom_empresa`, `cli_nom_representante`, `cli_tel_representante`, `cli_tel_empresa`, `cli_correo_empresa`, `cli_direccion`, `cli_activo`, `cli_fecha_vigencia`, `cli_logo`, `cli_slogan`) VALUES
(1, 'CECF950802', 'Redzpot', 'Lalo', '8717470750', '8713874998', 'contacto@redzpot.com', 'redzpot', 1, '2019-12-30', 'anexos/logos_clientes/1.JPG', 'sdasdasd'),
(2, '2131231312321', 'Autolasa', 'memo', '87452123332', '87422661233', 'correo@correo.com', 'enrique segoviano', 1, '2019-07-06', 'anexos/logos_clientes/2.JPG', 'hola holaaaa'),
(3, 'TO12122OOIWIW', 'totoya', 'TOTOYA', '11561511511', '87894156161', 'TOTOYA@TOTOYA.COM', 'HONDA INDEPENDENCIA', 1, '2019-06-29', 'anexos/logos_clientes/3.JPG', 'TOYOTA PENDEJA'),
(4, 'T4E3L3LE3N3N3', 'Telnet', 'hackij', '87452155566', '87125346665', 'correo@corrre.com', 'asdsadlsajdjsdlajdljaskdslajlkjasdkljalsdlajsdkl', 1, '2019-06-29', 'anexos/logos_clientes/4.PNG', 'jjsjsjsjaISAHDSAJANKSNAKDLsd'),
(5, 'AASKDMASLKMDK', 'FRANCO', 'FRANCISCO', '87455552211', '89778742558', 'correo@csddlks.com', 'ASDASDNASLDNLAK', 1, '2020-02-06', 'anexos/logos_clientes/5.JPG', 'ssgdfsdsdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `img_id` int(11) NOT NULL,
  `cli_id` int(11) DEFAULT NULL,
  `img_ruta` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`img_id`, `cli_id`, `img_ruta`) VALUES
(1, 1, 'app/views/img/a.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `nvl_id` tinyint(1) NOT NULL,
  `nvl_nombre` varchar(45) NOT NULL,
  `nvl_permisos` text,
  `cli_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`nvl_id`, `nvl_nombre`, `nvl_permisos`, `cli_id`) VALUES
(1, 'Administrador', 'clientes@niveles_usuarios@poblaciones@usuarios@buzon_sugerencias@spot_imagen@spot_video@spot@', 1),
(2, 'Usuarios Redzpot', 'clientes@poblaciones@usuarios@buzon_sugerencias@spot_imagen@spot_video@spot_texto@', 1),
(3, 'Usuarios Autolasa', 'clientes@', 2),
(4, 'Clientes toyota', 'clientes@poblaciones@usuarios@buzon_sugerencias@spot_imagen@spot_video@spot@', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spots`
--

CREATE TABLE `spots` (
  `spo_id` int(11) NOT NULL,
  `cli_id` int(11) DEFAULT NULL,
  `spo_ban` varchar(25) NOT NULL,
  `spo_text` varchar(500) DEFAULT NULL,
  `spo_text_ruta` varchar(59) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `spots`
--

INSERT INTO `spots` (`spo_id`, `cli_id`, `spo_ban`, `spo_text`, `spo_text_ruta`) VALUES
(1, 1, '2', 'Aqui tiene que ha', 'spots/texto/1/1.txt'),
(2, 3, '1', 'AQUI ESTA EN MENSAJE QUE VA A APARECER EN EL BANNER DE TOTOYA', 'spots/texto/2/2.txt'),
(3, 2, '1', 'excelente se creo el archivo ahora hay que ver la manera de mostrarlo ahora le agrego mucho mas texto a mi archivo txt excelente se creo el archivo ahora hay que ver la manera de mostrarlo ahora le agrego mucho mas texto a mi archivo txt excelente se creo el archivo ahora hay que ver la manera de mostrarlo ahora le agrego mucho mas texto a mi archivo txt excelente se creo el archivo ahora hay que ver la manera de mostrarlo ahora le agrego mucho mas texto a mi archivo txt excelente se creo el arc', 'spots/texto/3/3.txt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usr_id` int(11) NOT NULL,
  `usr_alias` varchar(15) NOT NULL,
  `usr_pass` varchar(45) NOT NULL,
  `usr_nombre` varchar(100) NOT NULL,
  `usr_nivel` tinyint(1) NOT NULL DEFAULT '0',
  `usr_foto` text,
  `cli_id` varchar(45) NOT NULL,
  `usr_correoe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usr_id`, `usr_alias`, `usr_pass`, `usr_nombre`, `usr_nivel`, `usr_foto`, `cli_id`, `usr_correoe`) VALUES
(1, 'ADMINISTRADOR', '1960a382c6103ff170e75e15753edea3', 'SISTEM MASTER', 1, 'perfil/clientes/1/1.JPG', '1', 'redzpot@redzpot.com'),
(2, 'Jisus', 'c4ca4238a0b923820dcc509a6f75849b', 'Jesus Bañuelos', 2, 'perfil/clientes/1/2.JPG', '1', 'banuelos@redzpot.com'),
(3, 'cliente', 'c4ca4238a0b923820dcc509a6f75849b', 'cliente', 4, 'perfil/clientes/3/3.JPG', '3', 'totoya@totoya.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE `video` (
  `vid_id` int(11) NOT NULL,
  `cli_id` int(11) DEFAULT NULL,
  `vid_nombre` varchar(50) DEFAULT NULL,
  `vid_fec_ini` date DEFAULT NULL,
  `vid_fec_fin` date DEFAULT NULL,
  `vid_num` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`vid_id`, `cli_id`, `vid_nombre`, `vid_fec_ini`, `vid_fec_fin`, `vid_num`) VALUES
(1, 1, 'video1', '2019-05-27', '2020-12-30', 2),
(2, 1, 'video2', '2019-05-27', '2020-12-30', 1),
(3, 1, 'toyota1', '2019-05-27', '2020-12-30', 3),
(4, 1, 'toyota2', '2019-05-27', '2020-12-30', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`bit_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cli_id`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`img_id`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`nvl_id`);

--
-- Indices de la tabla `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`spo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usr_id`);

--
-- Indices de la tabla `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`vid_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `bit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `nvl_id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `spots`
--
ALTER TABLE `spots`
  MODIFY `spo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
  MODIFY `vid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
