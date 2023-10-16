-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2023 a las 14:16:31
-- Versión del servidor: 10.4.16-MariaDB
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdtunegociov2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `condicion`) VALUES
(6580, 'OTROS', 1),
(6581, 'SERVICIOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idproveedor`, `idpersonal`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`) VALUES
(27, 50, 1, 'Boleta', '001', '00001', '2022-06-01 00:00:00', '18.00', '1260.00', 'Aceptado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_pago`
--

CREATE TABLE `comp_pago` (
  `id_comp_pago` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `serie_comprobante` varchar(4) NOT NULL,
  `num_comprobante` varchar(7) NOT NULL,
  `condicion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comp_pago`
--

INSERT INTO `comp_pago` (`id_comp_pago`, `nombre`, `serie_comprobante`, `num_comprobante`, `condicion`) VALUES
(2, 'Boleta', '000', '9999999', 1),
(3, 'Factura', '000', '9999999', 1),
(4, 'Nota de Venta', '000', '9999999', 1),
(5, 'Cotización', '000', '9999999', 1),
(6, 'NC', '000', '9999999', 1),
(7, 'NCB', '000', '9999999', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `idcotizacion` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `formapago` varchar(50) DEFAULT NULL,
  `descuento` double DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`idcotizacion`, `idcliente`, `idPersonal`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `total_venta`, `formapago`, `descuento`, `condicion`) VALUES
(60, 6, 1, 'Cotización', '001', '0000001', '2022-06-07 00:00:00', '55.00', NULL, NULL, 1),
(61, 51, 1, 'Cotización', '001', '0000002', '2022-06-07 00:00:00', '155.00', NULL, NULL, 1),
(62, 51, 1, 'Cotización', '001', '0000003', '2022-06-09 00:00:00', '158.00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_por_cobrar`
--

CREATE TABLE `cuentas_por_cobrar` (
  `idcpc` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL,
  `deudatotal` double NOT NULL,
  `fechavencimiento` date NOT NULL,
  `abonototal` decimal(11,2) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuentas_por_cobrar`
--

INSERT INTO `cuentas_por_cobrar` (`idcpc`, `idventa`, `fecharegistro`, `deudatotal`, `fechavencimiento`, `abonototal`, `condicion`) VALUES
(63, 564, '2022-04-23 00:00:00', 405, '2022-06-23', '405.00', 1),
(64, 587, '2022-05-31 00:00:00', 50, '2022-06-11', '0.00', 1),
(65, 588, '2022-06-01 00:00:00', 55, '2022-08-01', '55.00', 1),
(66, 590, '2022-06-07 00:00:00', 68, '2022-08-01', '68.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_negocio`
--

CREATE TABLE `datos_negocio` (
  `id_negocio` int(11) NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8 NOT NULL,
  `ndocumento` varchar(20) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 NOT NULL,
  `telefono` int(20) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `logo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pais` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ciudad` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `nombre_impuesto` varchar(10) NOT NULL,
  `monto_impuesto` float(4,2) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `simbolo` varchar(10) NOT NULL,
  `diasVencer` int(11) DEFAULT NULL,
  `validezcoti` char(3) DEFAULT NULL,
  `usuario_sol` varchar(30) DEFAULT NULL,
  `clave_sol` varchar(30) DEFAULT NULL,
  `estado_certificado` varchar(10) NOT NULL DEFAULT 'BETA',
  `ruta_certificado` varchar(100) DEFAULT NULL,
  `clave_certificado` varchar(50) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_negocio`
--

INSERT INTO `datos_negocio` (`id_negocio`, `nombre`, `ndocumento`, `documento`, `direccion`, `telefono`, `email`, `logo`, `pais`, `ciudad`, `nombre_impuesto`, `monto_impuesto`, `moneda`, `simbolo`, `diasVencer`, `validezcoti`, `usuario_sol`, `clave_sol`, `estado_certificado`, `ruta_certificado`, `clave_certificado`, `condicion`) VALUES
(17, 'Mi Negocio', 'RUC', '20000000001', 'AV. REPÚBLICA DE PANAMÁ NRO. 4050 URB. LIMATAMBO', 987451600, 'tunegocio@gmail.com', '1647694298.png', 'Perú', 'LIMA', 'IGV', 18.00, 'SOLES', 'S/', 90, NULL, 'MODDATOS', 'moddatos', 'BETA', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `iddetalle_compra` int(11) NOT NULL,
  `idcompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`iddetalle_compra`, `idcompra`, `idproducto`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(50, 27, 2406, 50, '25.00', '50.00'),
(51, 27, 2408, 25, '0.00', '100.00'),
(52, 27, 2407, 4, '2.50', '5.00');

--
-- Disparadores `detalle_compra`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_compra` FOR EACH ROW BEGIN
 UPDATE producto SET stock = stock + NEW.cantidad,
 		precio = NEW.precio_venta,
                precio_compra = NEW.precio_compra
 WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizacion`
--

CREATE TABLE `detalle_cotizacion` (
  `iddetalle_cotizacion` int(11) NOT NULL,
  `idcotizacion` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_cotizacion`
--

INSERT INTO `detalle_cotizacion` (`iddetalle_cotizacion`, `idcotizacion`, `idproducto`, `cantidad`, `precio_venta`, `descuento`) VALUES
(102, 60, 2406, 1, '50.00', '0.00'),
(103, 60, 2407, 1, '5.00', '0.00'),
(104, 61, 2407, 1, '5.00', '0.00'),
(105, 61, 2408, 1, '100.00', '0.00'),
(106, 61, 2406, 1, '50.00', '0.00'),
(107, 62, 2408, 1, '100.00', '0.00'),
(108, 62, 2409, 1, '3.00', '0.00'),
(109, 62, 2407, 1, '5.00', '0.00'),
(110, 62, 2406, 1, '50.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cuentas_por_cobrar`
--

CREATE TABLE `detalle_cuentas_por_cobrar` (
  `iddcpc` int(11) NOT NULL,
  `idcpc` int(11) NOT NULL,
  `montopagado` decimal(11,2) NOT NULL,
  `fechapago` datetime DEFAULT current_timestamp(),
  `formapago` varchar(50) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_cuentas_por_cobrar`
--

INSERT INTO `detalle_cuentas_por_cobrar` (`iddcpc`, `idcpc`, `montopagado`, `fechapago`, `formapago`, `observacion`) VALUES
(103, 63, '200.00', '2022-04-23 17:49:13', 'Efectivo', ''),
(104, 63, '205.00', '2022-04-23 17:49:31', 'Efectivo', ''),
(105, 65, '25.00', '2022-06-01 11:11:24', 'Efectivo', ''),
(106, 65, '30.00', '2022-06-01 11:11:44', 'Efectivo', ''),
(107, 66, '50.00', '2022-06-07 12:53:07', 'Efectivo', 'prueba'),
(108, 66, '18.00', '2022-06-07 12:53:24', 'Efectivo', '');

--
-- Disparadores `detalle_cuentas_por_cobrar`
--
DELIMITER $$
CREATE TRIGGER `tr_updCuentasPorCobrar` AFTER INSERT ON `detalle_cuentas_por_cobrar` FOR EACH ROW BEGIN
 UPDATE cuentas_por_cobrar SET abonototal = abonototal + NEW.montopagado 
 WHERE cuentas_por_cobrar.idcpc = NEW.idcpc;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `nombre_producto` varchar(250) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idproducto`, `nombre_producto`, `cantidad`, `precio_venta`, `descuento`) VALUES
(881, 578, 2406, '', 1, '50.00', '0.00'),
(882, 578, 2407, '', 1, '5.00', '0.00'),
(883, 578, 0, 'pro', 1, '50.00', '0.00'),
(884, 579, 2406, '', 1, '50.00', '0.00'),
(885, 579, 2407, '', 1, '5.00', '0.00'),
(886, 580, 2406, '', 1, '50.00', '0.00'),
(887, 580, 0, 'Producto Extra', 1, '150.00', '0.00'),
(888, 581, 2406, '', 1, '50.00', '0.00'),
(889, 582, 0, 'l', 1, '50.00', '0.00'),
(890, 582, 2406, '', 1, '50.00', '0.00'),
(891, 583, 2406, '', 1, '50.00', '0.00'),
(892, 584, 2407, NULL, 1, '5.00', '0.00'),
(893, 584, 2406, NULL, 1, '50.00', '0.00'),
(894, 585, 2407, NULL, 1, '5.00', '0.00'),
(895, 585, 2406, NULL, 1, '50.00', '0.00'),
(896, 586, 2407, NULL, 1, '300.00', '0.00'),
(897, 586, 2406, NULL, 1, '50.00', '0.00'),
(898, 587, 2406, NULL, 1, '50.00', '0.00'),
(899, 588, 2406, NULL, 1, '50.00', '0.00'),
(900, 588, 2407, NULL, 1, '5.00', '0.00'),
(901, 589, 2409, NULL, 90, '3.00', '0.00'),
(902, 590, 2410, NULL, 1, '50.00', '0.00'),
(903, 590, 2409, NULL, 6, '3.00', '0.00'),
(904, 591, 2409, NULL, 90, '3.00', '0.00'),
(905, 592, 2406, NULL, 1, '50.00', '0.00'),
(906, 592, 2407, NULL, 1, '5.00', '0.00'),
(907, 593, 2406, NULL, 1, '50.00', '0.00'),
(908, 594, 2406, NULL, 1, '50.00', '0.00');

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE producto SET stock = stock - NEW.cantidad 
 WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_nota`
--

CREATE TABLE `motivos_nota` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `motivos_nota`
--

INSERT INTO `motivos_nota` (`id`, `descripcion`, `condicion`) VALUES
(1, 'ANULACIÓN DE LA OPERACIÓN', 1),
(2, 'ANULACIÓN POR ERROR EN EL RUC', 1),
(3, 'CORRECCIÓN POR ERROR EN LA DESCRIPCIÓN', 1),
(4, 'DESCUENTO GLOBAL', 1),
(5, 'DESCUENTO POR ÍTEM', 1),
(6, 'DEVOLUCIÓN TOTAL', 1),
(7, 'DEVOLUCIÓN POR ÍTEM', 1),
(8, 'BONIFICACIÓN', 1),
(9, 'DISMINUCIÓN EN EL VALOR', 1),
(10, 'OTROS CONCEPTOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `idmovimiento` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo` varchar(25) NOT NULL,
  `vendedor` varchar(255) NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimiento`
--

INSERT INTO `movimiento` (`idmovimiento`, `fecha`, `tipo`, `vendedor`, `monto`, `descripcion`) VALUES
(57, '2022-06-07 13:01:26', 'Ingresos', 'Usuario Administrador', '100.00', 'SENCILLO'),
(58, '2022-06-07 13:01:42', 'Egresos', 'Usuario Administrador', '150.00', 'GASTO DE ALGO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `idopciones` int(11) NOT NULL,
  `nombre` varchar(450) NOT NULL,
  `tipo` varchar(200) NOT NULL,
  `condicion` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`idopciones`, `nombre`, `tipo`, `condicion`) VALUES
(1, 'Buenoi', 'CONDICIÓN DE HIGIENE Y PREPARACION', 1),
(2, 'Regular', 'CONDICIÓN DE HIGIENE Y PREPARACION', 1),
(3, 'Malo', 'CONDICIÓN DE HIGIENE Y PREPARACION', 1),
(4, 'Adecuado', 'ALMACENAMIENTO DE LOS ALIMENTOS EN LOS COMITE DE VASO DE LECHE', 1),
(5, 'Regular', 'ALMACENAMIENTO DE LOS ALIMENTOS EN LOS COMITE DE VASO DE LECHE', 1),
(6, 'Inadecuado', 'ALMACENAMIENTO DE LOS ALIMENTOS EN LOS COMITE DE VASO DE LECHE', 1),
(7, 'Al día', 'CONTROL DE DOCUMENTACION', 1),
(8, 'Atrazado', 'CONTROL DE DOCUMENTACION', 1),
(9, 'Siempre', 'CONTROL DE DOCUMENTACION', 1),
(10, 'Regular', 'CONTROL DE DOCUMENTACION', 1),
(11, 'Nunca', 'CONTROL DE DOCUMENTACION', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Inicio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Personal'),
(6, 'Consulta Compras'),
(7, 'Consulta Ventas'),
(8, 'Configuracion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `medida_derecha` varchar(50) DEFAULT NULL,
  `medida_izquierda` varchar(50) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `dipc` varchar(250) DEFAULT NULL,
  `addc` varchar(250) DEFAULT NULL,
  `productoc` varchar(250) DEFAULT NULL,
  `idzona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `fecha`, `medida_derecha`, `medida_izquierda`, `fecha_registro`, `dipc`, `addc`, `productoc`, `idzona`) VALUES
(6, 'Cliente', 'PUBLICO EN GENERAL', 'DNI', '00000000', 'Calle #12, Pacasmayo', '952761400', '', '0000-00-00', '0.255', '0.15', '2022-04-11 00:00:00', NULL, NULL, NULL, 0),
(46, 'Cliente', 'C1', 'DNI', '23445677', 'SD', '958741236', '', '0000-00-00', '0.152', '23', '2022-04-13 00:00:00', 'D', 'A', 'P', 0),
(47, 'Cliente', 'gh', 'DNI', '23445677', '', '', '', '0000-00-00', '0.152', '23', '2022-04-13 00:00:00', 'I', 'D', 'R', 0),
(48, 'Cliente', 'TU NEGOCIO', 'DNI', '78996532', 'Calle #12, Pacasmayo', '952761400', '', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 'Cliente', 'JORGE LUIS SANCHEZ SANDOVAL', 'DNI', '47268949', '', '', '', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 'Proveedor', 'TU NEGOCIO', 'DNI', '34556789', '', '', '', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(51, 'Cliente', 'FIESTAS FLORES EDWARD', 'DNI', '48492024', '', '930106778', '', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(52, 'Supervisor', 'supervisor01', 'DNI', '12345678', 'direccion 01', '955811462', 'supervisor@gmail.com', '1995-12-05', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `idpersonal` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idpersonal`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `imagen`, `condicion`) VALUES
(1, 'Usuario Administrador', 'DNI', '75663252', 'LIMA', '98632144', 'admin@Hotmail.com', 'Administrador', '1570311068.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `idunidad_medida` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(250) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `precio` decimal(11,2) DEFAULT NULL,
  `precioB` decimal(11,2) DEFAULT NULL,
  `precioC` decimal(11,2) DEFAULT NULL,
  `precioD` decimal(11,2) DEFAULT NULL,
  `preciosigv` decimal(11,2) DEFAULT NULL,
  `precio_compra` decimal(11,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT 'anonymous.png',
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `modelo` varchar(100) DEFAULT NULL,
  `numserie` varchar(50) DEFAULT NULL,
  `proigv` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idcategoria`, `idunidad_medida`, `codigo`, `nombre`, `stock`, `stock_minimo`, `precio`, `precioB`, `precioC`, `precioD`, `preciosigv`, `precio_compra`, `fecha`, `descripcion`, `imagen`, `condicion`, `modelo`, `numserie`, `proigv`) VALUES
(1, 12, 0, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'anonymous.png', 1, NULL, NULL, NULL),
(2406, 6580, 14, '4454554545', 'P1', 52, 5, '50.00', '49.00', '0.00', '0.00', NULL, '25.00', '0000-00-00', '', 'anonymous.png', 1, '', '', 'Gravada'),
(2407, 6580, 14, 'SIN CODIGO', 'AVENA', 95, 5, '5.00', '0.00', '0.00', '0.00', NULL, '2.50', '2022-04-23', '', 'anonymous.png', 1, '', '', 'Gravada'),
(2408, 6581, 14, 'SIN CODIGO', 'MANTENIMIENTO DE MOTOR', 25, 0, '100.00', '0.00', '0.00', '0.00', NULL, '0.00', '0000-00-00', '', 'anonymous.png', 1, '', '', 'Gravada'),
(2409, 6580, 14, 'SIN CODIGO', 'AGUA UN', 96, 5, '3.00', '0.00', '0.00', '0.00', NULL, '1.50', '0000-00-00', '', 'anonymous.png', 1, '', '12034', 'Gravada'),
(2410, 6580, 15, 'SIN CODIGO', 'AGUA PQ', 0, 1, '50.00', '0.00', '0.00', '0.00', NULL, '30.00', '0000-00-00', '', 'anonymous.png', 1, '', '', 'Gravada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `idunidad_medida` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`idunidad_medida`, `nombre`, `condicion`) VALUES
(14, 'UNIDAD', 1),
(15, 'PAQUETE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `idpersonal`, `login`, `clave`, `condicion`) VALUES
(1, 1, 'admin', '7676aaafb027c825bd9abab78b234070e702752f625b752e55e55b48e607e358', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(57, 1, 1),
(58, 1, 2),
(59, 1, 3),
(60, 1, 4),
(61, 1, 5),
(62, 1, 6),
(63, 1, 7),
(64, 1, 8),
(68, 20, 1),
(69, 20, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `idmotivo_nota` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `ventacredito` varchar(20) NOT NULL,
  `formapago` varchar(50) DEFAULT NULL,
  `numoperacion` varchar(100) DEFAULT NULL,
  `fechadeposito` datetime DEFAULT NULL,
  `descuento` double DEFAULT NULL,
  `totalrecibido` double DEFAULT NULL,
  `vuelto` double DEFAULT NULL,
  `nomCliente` varchar(250) DEFAULT NULL,
  `documento_rel` varchar(20) DEFAULT NULL,
  `dov_Estado` varchar(15) DEFAULT NULL,
  `dov_Nombre` varchar(100) DEFAULT NULL,
  `dov_IdEmpleado` int(11) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idPersonal`, `idmotivo_nota`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `ventacredito`, `formapago`, `numoperacion`, `fechadeposito`, `descuento`, `totalrecibido`, `vuelto`, `nomCliente`, `documento_rel`, `dov_Estado`, `dov_Nombre`, `dov_IdEmpleado`, `observacion`, `estado`) VALUES
(578, 6, 1, 0, 'Boleta', 'B001', '0000001', '2022-04-29 00:00:00', '18.00', '105.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Nota Credito'),
(579, 6, 1, 1, 'NCB', 'BN01', '0000001', '2022-04-30 00:00:00', '18.00', '55.00', '', '', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '578', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(580, 6, 1, 0, 'Boleta', 'B001', '0000002', '2022-04-30 00:00:00', '18.00', '200.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Nota Credito'),
(581, 6, 1, 1, 'NCB', 'BN01', '0000002', '2022-04-30 00:00:00', '18.00', '50.00', '', '', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '580', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(582, 6, 1, 0, 'Boleta', 'B001', '0000003', '2022-04-30 00:00:00', '18.00', '100.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Nota Credito'),
(583, 6, 1, 1, 'NCB', 'BN01', '0000003', '2022-04-30 00:00:00', '18.00', '50.00', '', '', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '582', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(584, 6, 1, 0, 'Boleta', 'B001', '0000004', '2022-05-02 00:00:00', '18.00', '55.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(585, 6, 1, 0, 'Factura', 'F001', '0000001', '2022-05-02 00:00:00', '18.00', '55.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(586, 6, 1, 0, 'Nota', 'P001', '0000001', '2022-05-23 00:00:00', '0.00', '320.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 30, 500, 180, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Activado'),
(587, 6, 1, 0, 'Boleta', 'B001', '0000005', '2022-05-31 00:00:00', '18.00', '50.00', 'Si', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(588, 49, 1, 0, 'Boleta', 'B001', '0000006', '2022-06-01 00:00:00', '18.00', '55.00', 'Si', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(589, 6, 1, 0, 'Boleta', 'B001', '0000007', '2022-06-07 00:00:00', '18.00', '270.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Nota Credito'),
(590, 6, 1, 0, 'Boleta', 'B001', '0000008', '2022-06-07 00:00:00', '18.00', '68.00', 'Si', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(591, 6, 1, 1, 'NCB', 'BN01', '0000004', '2022-06-07 00:00:00', '18.00', '270.00', '', '', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '589', 'ACEPTADO', NULL, NULL, '', 'Aceptado'),
(592, 6, 1, 0, 'Boleta', 'B001', '0000009', '2022-06-07 00:00:00', '18.00', '55.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', '20000000001-03-B001-0000009', 1, '', 'Aceptado'),
(593, 6, 1, 0, 'Boleta', 'B001', '0000010', '2022-06-09 00:00:00', '18.00', '50.00', 'No', 'Efectivo', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '', 'ACEPTADO', '20000000001-03-B001-0000010', 1, '', 'Nota Credito'),
(594, 6, 1, 1, 'NCB', 'BN01', '0000005', '2022-06-09 00:00:00', '18.00', '50.00', '', '', '', '0000-00-00 00:00:00', 0, 0, 0, NULL, '593', 'ACEPTADO', '20000000001-07-BN01-0000005', 1, '', 'Aceptado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `idzona` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `comite` varchar(400) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `responsable` varchar(450) NOT NULL,
  `dirresponsable` varchar(450) NOT NULL,
  `cocinero` varchar(450) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`idzona`, `nombre`, `comite`, `direccion`, `responsable`, `dirresponsable`, `cocinero`, `condicion`) VALUES
(1, 'Zona 01', 'Comite 01', 'direccion 01', '', '', '', 1),
(2, 'zona 03', 'Comite 03', 'direccion', 'responsable 01', 'dirección responsable 01', 'cocinero 01', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_compra_personal1_idx` (`idpersonal`);

--
-- Indices de la tabla `comp_pago`
--
ALTER TABLE `comp_pago`
  ADD PRIMARY KEY (`id_comp_pago`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`idcotizacion`),
  ADD KEY `idcliente` (`idcliente`),
  ADD KEY `idPersonal` (`idPersonal`);

--
-- Indices de la tabla `cuentas_por_cobrar`
--
ALTER TABLE `cuentas_por_cobrar`
  ADD PRIMARY KEY (`idcpc`);

--
-- Indices de la tabla `datos_negocio`
--
ALTER TABLE `datos_negocio`
  ADD PRIMARY KEY (`id_negocio`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`iddetalle_compra`),
  ADD KEY `fk_detalle_ingreso_ingreso_idx` (`idcompra`),
  ADD KEY `fk_detalle_compra_producto1_idx` (`idproducto`);

--
-- Indices de la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  ADD PRIMARY KEY (`iddetalle_cotizacion`),
  ADD KEY `idcotizacion` (`idcotizacion`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `detalle_cuentas_por_cobrar`
--
ALTER TABLE `detalle_cuentas_por_cobrar`
  ADD PRIMARY KEY (`iddcpc`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_producto1_idx` (`idproducto`);

--
-- Indices de la tabla `motivos_nota`
--
ALTER TABLE `motivos_nota`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`idmovimiento`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`idopciones`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idpersonal`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_producto_categoria1_idx` (`idcategoria`),
  ADD KEY `idunidad_medida` (`idunidad_medida`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`idunidad_medida`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD KEY `fk_usuario_personal1_idx` (`idpersonal`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_persona_idx` (`idcliente`),
  ADD KEY `fk_venta_Personal1_idx` (`idPersonal`),
  ADD KEY `idmotivo_nota` (`idmotivo_nota`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`idzona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6582;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `comp_pago`
--
ALTER TABLE `comp_pago`
  MODIFY `id_comp_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `idcotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `cuentas_por_cobrar`
--
ALTER TABLE `cuentas_por_cobrar`
  MODIFY `idcpc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `datos_negocio`
--
ALTER TABLE `datos_negocio`
  MODIFY `id_negocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `iddetalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  MODIFY `iddetalle_cotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `detalle_cuentas_por_cobrar`
--
ALTER TABLE `detalle_cuentas_por_cobrar`
  MODIFY `iddcpc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=909;

--
-- AUTO_INCREMENT de la tabla `motivos_nota`
--
ALTER TABLE `motivos_nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `idmovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `idopciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2411;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `idunidad_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=595;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `idzona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_personal1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`idpersonal`);

--
-- Filtros para la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  ADD CONSTRAINT `detalle_cotizacion_ibfk_1` FOREIGN KEY (`idcotizacion`) REFERENCES `cotizacion` (`idcotizacion`),
  ADD CONSTRAINT `detalle_cotizacion_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
