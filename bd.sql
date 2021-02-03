-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2021 a las 04:32:44
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_ventas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `desactiva_producto` (IN `_id` INT)  NO SQL
UPDATE productos p SET p.estado=0 WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detalle_compra` (IN `_identrada` INT)  NO SQL
SELECT ed.id,p.id as idproducto,p.nombre,m.medida,p.precio,ed.cantidad,ed.costo,ed.fecha_vencimiento
FROM entradas_detalle ed INNER JOIN productos p
ON ed.idproducto=p.id
INNER JOIN mediciones m
ON p.medida=m.id
WHERE ed.identrada=_identrada$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `elimina_ventastemporales` (IN `_caja` INT)  NO SQL
DELETE vd.* FROM ventadetalle_temp vd
INNER JOIN ventas v ON v.id = vd.venta_id
WHERE (v.caja = _caja)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `historialAperturas` ()  NO SQL
SELECT a.id,a.fecha,a.monto,u.usuario,a.caja FROM aperturas a INNER JOIN usuarios u
on a.usuario=u.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `incrementa_factura` ()  NO SQL
SELECT MAX(RIGHT(v.factura,8)) as maximo,(SELECT base_factura FROM config)as base,
(SELECT rango_inicial FROM config) as rango_inicial
FROM ventas v 
WHERE LEFT(v.factura,9)=(SELECT base_factura FROM config)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_detalle` (IN `_idventa` INT)  NO SQL
SELECT v.id,p.nombre,m.medida,v.cantidad,v.precio,(v.precio_venta-v.precio) as descuento,v.precio*v.cantidad as total,v.impuesto FROM
ventadetalle v INNER JOIN productos p
ON v.producto_id=p.id
INNER JOIN mediciones m
ON p.medida=m.id
WHERE v.venta_id=_idventa$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_ventas` ()  SELECT v.id,v.factura,u.usuario,v.fecha,v.caja FROM ventas v INNER JOIN usuarios u
on u.id=v.usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login` (IN `usuario` VARCHAR(50), IN `pass` VARCHAR(256))  SELECT * FROM usuarios u WHERE u.id_usuario=usuario and u.clave=pass$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proximosa_vencer` (IN `_fecha` DATE)  NO SQL
SELECT p.codigo,p.nombre,m.medida,p.existencia,e.fecha_vencimiento FROM entradas_detalle e INNER JOIN productos p 
ON e.idproducto=p.id
INNER JOIN mediciones m 
ON p.medida=m.id
WHERE e.fecha_vencimiento<=_fecha$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_usuario` (IN `_correo` VARCHAR(100), IN `_usuario` VARCHAR(50), IN `_clave` VARCHAR(256), IN `_privilegio` VARCHAR(50))  insert into usuarios(correo,usuario,clave,privilegio)
        values(_correo,_usuario,_clave,_privilegio)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_venta` (`_cliente` VARCHAR(90))  INSERT INTO ventas(cliente,fecha) VALUES(_cliente,now())$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_cierre` (IN `_fecha` DATE, IN `_caja` INT)  NO SQL
SELECT v.id,p.nombre,sum(v.cantidad)as cantidad,v.precio,sum(v.precio_venta-v.precio) as descuento,
sum(v.precio*v.cantidad) as total,
ventas.caja,v.impuesto
FROM ventadetalle_temp v INNER JOIN productos p 
ON v.producto_id=p.id INNER JOIN ventas 
ON ventas.id=v.venta_id 
WHERE date(ventas.fecha)=_fecha AND ventas.caja=_caja
GROUP by p.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_diario` (IN `_fecha` DATE)  NO SQL
SELECT v.id,p.nombre,m.medida,sum(v.cantidad)as cantidad,v.precio,sum(v.precio_venta-v.precio) as descuento,
sum(v.precio*v.cantidad) as total,
v.impuesto,ventas.caja
FROM ventadetalle v INNER JOIN productos p 
ON v.producto_id=p.id INNER JOIN ventas 
ON ventas.id=v.venta_id 
INNER JOIN mediciones m
ON p.medida=m.id
WHERE date(ventas.fecha)=_fecha
GROUP by p.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_inventario` ()  NO SQL
SELECT * FROM productos p INNER JOIN mediciones m
ON m.id=p.medida
WHERE p.estado=1 AND p.existencia>0
ORDER by nombre ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_minimos` ()  NO SQL
SELECT * FROM productos p INNER JOIN mediciones m
ON m.id=p.medida
WHERE p.estado=1 AND p.existencia<=p.minimo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selecciona_apertura` (IN `_caja` VARCHAR(100))  NO SQL
SELECT * FROM aperturas WHERE estado='abierta' AND caja=_caja$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verifica_apertura_caja` (IN `_caja` INT)  NO SQL
SELECT COUNT(*)as numero FROM aperturas 
WHERE caja=_caja AND estado='abierta'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verifica_base` ()  NO SQL
SELECT COUNT(*) as cantidad FROM ventas v
WHERE LEFT(v.factura,9)=(SELECT base_factura FROM config)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verifica_login_caja` (IN `_caja` INT)  NO SQL
SELECT COUNT(*)as numero FROM aperturas 
WHERE caja<>_caja AND estado='abierta'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_compra` ()  NO SQL
SELECT e.id,e.fecha,p.nombre as proveedor
FROM entradas e INNER JOIN proveedores p
ON e.idproveedor=p.id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperturas`
--

CREATE TABLE `aperturas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aperturas`
--

INSERT INTO `aperturas` (`id`, `fecha`, `monto`, `usuario`, `caja`, `estado`) VALUES
(1, '2016-10-05', '2442.00', 35, 1, 'cerrada'),
(2, '2016-10-05', '2200.00', 35, 2, 'cerrada'),
(3, '2016-10-06', '1230.00', 32, 1, 'cerrada'),
(4, '2016-10-06', '3200.00', 32, 1, 'cerrada'),
(6, '2016-11-03', '0.00', 32, 1, 'abierta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(4, 'Medicamento'),
(2, 'Golosina'),
(3, 'Cosmetico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estados`
--

CREATE TABLE `cat_estados` (
  `id` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_estados`
--

INSERT INTO `cat_estados` (`id`, `estado`) VALUES
(1, 'Cerrada'),
(2, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `empresa` varchar(200) DEFAULT NULL,
  `propietario` varchar(100) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `cai` varchar(100) DEFAULT NULL,
  `rtn` varchar(100) DEFAULT NULL,
  `base_factura` varchar(20) DEFAULT NULL,
  `rango_del` varchar(20) DEFAULT NULL,
  `rango_al` varchar(20) DEFAULT NULL,
  `rango_inicial` varchar(20) DEFAULT NULL,
  `fecha_autorizada` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `empresa`, `propietario`, `telefono`, `correo`, `direccion`, `cai`, `rtn`, `base_factura`, `rango_del`, `rango_al`, `rango_inicial`, `fecha_autorizada`) VALUES
(1, 'Farmacia Santa Rosa', 'Yanet Polanco', '2222-2222', 'correo@correo.com', 'La Masica, AtlÃ¡ntida barrio el centro', '0000', '0000', '00-128-09', '00001520', '00006520', '00003500', '2016-10-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idproveedor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id`, `fecha`, `idproveedor`) VALUES
(1, '2016-10-26', 1),
(2, '2016-11-03', 2),
(3, '2021-02-02', 1),
(4, '2021-02-02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas_detalle`
--

CREATE TABLE `entradas_detalle` (
  `id` int(11) NOT NULL,
  `identrada` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` decimal(11,2) DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entradas_detalle`
--

INSERT INTO `entradas_detalle` (`id`, `identrada`, `idproducto`, `cantidad`, `costo`, `fecha_vencimiento`) VALUES
(2, 1, 1, 2, '12.00', '2016-10-29'),
(4, 2, 1, 11, '20.00', '2016-11-30'),
(5, 3, 6, 10, '30.00', '0000-00-00'),
(6, 4, 4, 10, '10.00', '0000-00-00'),
(7, 4, 4, 1, '10.00', '0000-00-00');

--
-- Disparadores `entradas_detalle`
--
DELIMITER $$
CREATE TRIGGER `entradasdetalle_delete` AFTER DELETE ON `entradas_detalle` FOR EACH ROW UPDATE productos set existencia=existencia-OLD.cantidad
WHERE id=OLD.idproducto
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `entradasdetalle_insert` BEFORE INSERT ON `entradas_detalle` FOR EACH ROW UPDATE productos SET existencia=existencia+new.cantidad
WHERE id=new.idproducto
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediciones`
--

CREATE TABLE `mediciones` (
  `id` int(11) NOT NULL,
  `medida` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mediciones`
--

INSERT INTO `mediciones` (`id`, `medida`) VALUES
(1, 'Caja'),
(2, 'Bote'),
(5, 'Unidad'),
(4, 'Frasco'),
(6, 'Blister');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(11,2) DEFAULT '0.00',
  `minimo` int(11) DEFAULT '0',
  `estado` int(11) DEFAULT '1',
  `impuesto` int(11) NOT NULL DEFAULT '0',
  `descuento` int(11) NOT NULL DEFAULT '0',
  `medida` int(11) DEFAULT '0',
  `categoria` int(11) DEFAULT '0',
  `existencia` int(11) DEFAULT '0',
  `margen` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `precio`, `minimo`, `estado`, `impuesto`, `descuento`, `medida`, `categoria`, `existencia`, `margen`) VALUES
(1, '01', 'amoxicilina 5mg', '30.00', 5, 1, 0, 0, 6, 4, 18, 25),
(2, '02', 'amoxicilina 5mg', '1.05', 150, 1, 15, 0, 5, 4, -21, 5),
(3, '03', 'panadol ultra', '5.00', 5, 1, 0, 0, 5, 4, 12, 25),
(4, '04', 'panadol multisintomas', '10.50', 0, 1, 0, 0, 1, 4, 10, 5),
(5, '09', 'ppp', '0.00', 0, 0, 0, 0, 1, 4, 0, 5),
(6, 'hules', 'sdcf', '31.50', 0, 1, 0, 0, 5, 3, 20, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(400) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `tel1` varchar(12) DEFAULT NULL,
  `tel2` varchar(12) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `descripcion`, `direccion`, `tel1`, `tel2`, `correo`, `contacto`) VALUES
(1, 'Cisco', 'Tecnologia', '', '', '', '', ''),
(2, 'proveedor y', 'yyy', 'barrio ingles', '', '', '', ''),
(3, 'x', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(256) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `privilegio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_usuario`, `correo`, `usuario`, `clave`, `estado`, `privilegio`) VALUES
(32, 'pavon96', 'davidpavon96@gmail.com', 'David F. Pavon', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 0, 'admin'),
(34, 'yanetP2016', NULL, 'Yanet Polanco', '$2a$07$usesomesillystringforehToTmfI15HzsDZWNRB.QMSymoWmCyGC', 0, 'admin'),
(35, 'dpavon', 'davidpavon96@gmail.com', 'David PavÃ³n', '$2a$07$usesomesillystringforeoNxr78TNtWX4MRkZ4l88chEiEQV.z2O', 0, 'admin'),
(36, 'jgaleas', NULL, 'Juan Galeas', '$2a$07$usesomesillystringforeh13SwIG2YuGjH7WNZPTqAnpzOR7aksC', 0, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventadetalle`
--

CREATE TABLE `ventadetalle` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `impuesto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventadetalle`
--

INSERT INTO `ventadetalle` (`id`, `producto_id`, `venta_id`, `cantidad`, `precio`, `precio_venta`, `impuesto`) VALUES
(1, 1, 1, 1, '12.50', '12.50', 0),
(2, 2, 1, 1, '1.05', '1.05', 15),
(3, 1, 2, 2, '12.50', '12.50', 0),
(4, 2, 2, 2, '1.05', '1.05', 15),
(5, 1, 3, 1, '12.50', '12.50', 0),
(6, 2, 4, 1, '1.05', '1.05', 15),
(7, 1, 5, 1, '12.50', '12.50', 0),
(8, 2, 6, 1, '1.05', '1.05', 15),
(9, 3, 7, 1, '5.00', '5.00', 0),
(10, 3, 8, 1, '5.00', '5.00', 0),
(11, 1, 9, 1, '15.00', '15.00', 0),
(12, 1, 10, 1, '15.00', '15.00', 0),
(13, 3, 10, 2, '5.00', '5.00', 0),
(14, 1, 11, 1, '15.00', '15.00', 0),
(15, 3, 11, 2, '5.00', '5.00', 0),
(16, 1, 12, 1, '15.00', '15.00', 0),
(17, 3, 12, 1, '5.00', '5.00', 0),
(18, 3, 13, 1, '5.00', '5.00', 0),
(19, 1, 14, 1, '30.00', '30.00', 0),
(20, 1, 15, 2, '30.00', '30.00', 0),
(21, 2, 15, 3, '1.05', '1.05', 15),
(22, 4, 16, 1, '0.00', '0.00', 0),
(23, 1, 17, 3, '30.00', '30.00', 0),
(24, 2, 17, 4, '1.05', '1.05', 15);

--
-- Disparadores `ventadetalle`
--
DELIMITER $$
CREATE TRIGGER `rebaja_inventario` AFTER INSERT ON `ventadetalle` FOR EACH ROW UPDATE productos SET existencia=existencia-new.cantidad
WHERE id=new.producto_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventadetalle_temp`
--

CREATE TABLE `ventadetalle_temp` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `impuesto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventadetalle_temp`
--

INSERT INTO `ventadetalle_temp` (`id`, `producto_id`, `venta_id`, `cantidad`, `precio`, `precio_venta`, `impuesto`) VALUES
(24, 2, 17, 4, '1.05', '1.05', 15),
(23, 1, 17, 3, '30.00', '30.00', 0),
(22, 4, 16, 1, '0.00', '0.00', 0),
(21, 2, 15, 3, '1.05', '1.05', 15),
(20, 1, 15, 2, '30.00', '30.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `factura` varchar(20) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `factura`, `usuario`, `fecha`, `caja`) VALUES
(1, '00-128-09-00003500', 35, '2016-10-05 18:16:34', 1),
(2, '00-128-09-00003501', 35, '2016-10-05 18:29:25', 2),
(3, '00-128-09-00003502', 32, '2016-10-06 00:26:44', 1),
(4, '00-128-09-00003503', 32, '2016-10-06 00:27:08', 1),
(5, '00-128-09-00003504', 34, '2016-10-06 12:00:11', 1),
(6, '00-128-09-00003505', 34, '2016-10-06 12:00:23', 1),
(7, '00-128-09-00003506', 32, '2016-10-06 18:15:05', 1),
(8, '00-128-09-00003507', 32, '2016-10-10 17:19:37', 1),
(9, '00-128-09-00003508', 32, '2016-10-26 10:16:15', 1),
(10, '00-128-09-00003509', 32, '2016-11-03 09:11:26', 1),
(11, '00-128-09-00003510', 32, '2016-11-03 09:12:42', 1),
(12, '00-128-09-00003511', 32, '2016-11-03 09:17:39', 1),
(13, '00-128-09-00003512', 32, '2016-11-03 10:02:37', 1),
(14, '00-128-09-00003513', 32, '2016-11-03 10:03:20', 1),
(15, '00-128-09-00003514', 32, '2016-11-03 10:23:53', 1),
(16, '00-128-09-00003515', 32, '2016-11-03 10:24:50', 1),
(17, '00-128-09-00003516', 32, '2016-11-03 11:48:57', 1),
(18, '00-128-09-00003517', 36, '2021-02-02 20:57:22', 1),
(19, '00-128-09-00003518', 36, '2021-02-02 21:05:28', 1),
(20, '00-128-09-00003519', 36, '2021-02-02 21:06:48', 1),
(21, '00-128-09-00003520', 36, '2021-02-02 21:13:33', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aperturas`
--
ALTER TABLE `aperturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cat_estados`
--
ALTER TABLE `cat_estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entradas_detalle`
--
ALTER TABLE `entradas_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventadetalle`
--
ALTER TABLE `ventadetalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventadetalle_temp`
--
ALTER TABLE `ventadetalle_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aperturas`
--
ALTER TABLE `aperturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cat_estados`
--
ALTER TABLE `cat_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `entradas_detalle`
--
ALTER TABLE `entradas_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `ventadetalle`
--
ALTER TABLE `ventadetalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `ventadetalle_temp`
--
ALTER TABLE `ventadetalle_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
