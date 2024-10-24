-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2024 a las 06:33:03
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
-- Base de datos: `renzo_motors`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorio`
--

CREATE TABLE `accesorio` (
  `sku_accesorio` varchar(8) NOT NULL,
  `stock_accesorio` int(11) NOT NULL,
  `nombre_accesorio` varchar(100) NOT NULL,
  `descripcion_accesorio` text NOT NULL,
  `precio_accesorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accesorio`
--

INSERT INTO `accesorio` (`sku_accesorio`, `stock_accesorio`, `nombre_accesorio`, `descripcion_accesorio`, `precio_accesorio`) VALUES
('0NY4BINL', 40, 'Pino Aromático Piña Colada unidad', 'Pino Aromático Fragancia Piña Colada para Vehículos', 3100),
('1HTLA8Z0', 20, 'Limpiador de Ruedas Meguiaras ULTIMATE', 'Limpiador de Ruedas spray', 5000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `rut_administrador` varchar(100) NOT NULL,
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_prueba`
--

CREATE TABLE `agenda_prueba` (
  `id_sucursal` int(11) NOT NULL,
  `rut_usuario` varchar(100) NOT NULL,
  `rut_conductor` varchar(100) NOT NULL,
  `nombre_conductor` varchar(100) NOT NULL,
  `correo_conductor` varchar(100) NOT NULL,
  `telefono_conductor` varchar(100) NOT NULL,
  `vehiculo_modelo_prueba` int(11) NOT NULL,
  `fecha_prueba` date NOT NULL,
  `hora_prueba` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio`
--

CREATE TABLE `anio` (
  `id_anio` int(11) NOT NULL,
  `anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anio`
--

INSERT INTO `anio` (`id_anio`, `anio`) VALUES
(2, 2018),
(3, 2020),
(4, 2024),
(5, 2023);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobertura`
--

CREATE TABLE `cobertura` (
  `id_cobertura` int(11) NOT NULL,
  `nombre_tipo_cobertura` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cobertura`
--

INSERT INTO `cobertura` (`id_cobertura`, `nombre_tipo_cobertura`) VALUES
(1, 'Robo'),
(2, 'Accidentes'),
(3, 'Fallo de Ruedas'),
(4, 'Fallo de Frenos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `id_color` int(11) NOT NULL,
  `codigo_color` varchar(100) NOT NULL,
  `nombre_color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `codigo_color`, `nombre_color`) VALUES
(3, '#000000', 'Negro'),
(4, '#a8a8a8', 'Plateado'),
(5, '#ffa200', 'Naranja'),
(6, '#eb0000', 'Rojo'),
(7, '#000080', 'Azul Marino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color_vehiculo`
--

CREATE TABLE `color_vehiculo` (
  `id_color` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color_vehiculo`
--

INSERT INTO `color_vehiculo` (`id_color`, `id_vehiculo`) VALUES
(4, 9),
(6, 9),
(6, 10),
(7, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `financiamiento`
--

CREATE TABLE `financiamiento` (
  `id_financiamiento` int(11) NOT NULL,
  `nombre_financiamiento` varchar(100) NOT NULL,
  `plazo_maximo_meses` int(11) NOT NULL,
  `tasa_interes` float NOT NULL,
  `requisitos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `financiamiento`
--

INSERT INTO `financiamiento` (`id_financiamiento`, `nombre_financiamiento`, `plazo_maximo_meses`, `tasa_interes`, `requisitos`) VALUES
(1, 'Banco Falabella Clientes', 15, 0.15, 'Ser parte de Banco Falabella y contar con tarjeta de Crédito Falabella\r\nVehículos sobre $10.000.000'),
(2, 'Banco de Chile', 18, 0.3, 'Vehículos sobre $8.000.000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_accesorio`
--

CREATE TABLE `fotos_accesorio` (
  `id_foto_accesorio` int(11) NOT NULL,
  `foto_accesorio` varchar(255) NOT NULL,
  `sku_accesorio` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos_accesorio`
--

INSERT INTO `fotos_accesorio` (`id_foto_accesorio`, `foto_accesorio`, `sku_accesorio`) VALUES
(1, 'fotos/Aromatio_piña_colada2.jpg', '0NY4BINL'),
(2, 'fotos/Aromatico_piña_colada.jpg', '0NY4BINL'),
(3, 'fotos/Limpiador_ruedas.jpg', '1HTLA8Z0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_vehiculo`
--

CREATE TABLE `fotos_vehiculo` (
  `id_foto_vehiculo` int(11) NOT NULL,
  `ruta_foto` varchar(255) NOT NULL,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos_vehiculo`
--

INSERT INTO `fotos_vehiculo` (`id_foto_vehiculo`, `ruta_foto`, `id_vehiculo`) VALUES
(1, 'fotos_vehiculos/Ct_ROJO.jpg', 9),
(2, 'fotos_vehiculos/Ct_GRIS.jpg', 9),
(3, 'fotos_vehiculos/Dodge_challeger_rojo.png', 10),
(4, 'fotos_vehiculos/Dodge_challenger_gris.png', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(100) NOT NULL,
  `logo_marca` varchar(255) NOT NULL,
  `descripcion_marca` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nombre_marca`, `logo_marca`, `descripcion_marca`) VALUES
(2, 'Chevrolet', 'Chevrolet-Logo-2010.png', 'Chevrolet, también conocida como Chevy, es una icónica marca estadounidense reconocida por su amplia gama de vehículos, desde autos compactos hasta camionetas y SUV'),
(3, 'Kya', 'Kya-Logo.jpg', 'Kia es una marca surcoreana que se ha ganado una reputación por fabricar vehículos confiables, con diseño moderno y tecnologías avanzadas.'),
(4, 'Lamborghini', 'Lamborghini_logo.jpg', 'Lamborghini es una marca italiana de autos deportivos de lujo, conocida por su diseño vanguardista y alto rendimiento en superdeportivos.'),
(5, 'Volkswagen', 'Volkswagen-logo.jpg', 'Volkswagen, de origen alemán, es una de las marcas más reconocidas a nivel mundial, famosa por su calidad de ingeniería y diseño.'),
(9, 'Dodge', 'dodge-logo_1919x428.jpg', 'Dodge es una marca automotriz estadounidense, famosa por sus vehículos potentes y de alto rendimiento, especialmente muscle cars como el Charger y el Challenger. Fundada en 1900, Dodge se ha destacado por su enfoque en la fuerza, velocidad y durabilidad, creando una sólida reputación en el mundo del automovilismo deportivo y utilitario.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opinion_vehiculo`
--

CREATE TABLE `opinion_vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `titulo_resenia` varchar(100) NOT NULL,
  `resenia` text NOT NULL,
  `autor_resenia` varchar(100) DEFAULT NULL,
  `fecha_resenia` date NOT NULL,
  `anonima` tinyint(1) NOT NULL,
  `calificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL,
  `nombre_pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id_pais`, `nombre_pais`) VALUES
(1, 'Chile'),
(3, 'Italia'),
(4, 'Corea del Sur'),
(5, 'Brasil'),
(6, 'Estados Unidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `nombre_permiso`) VALUES
(2, 'Gestión Vehículos'),
(3, 'Gestión de Administradores'),
(4, 'Gestión de Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertenece_tipo`
--

CREATE TABLE `pertenece_tipo` (
  `id_tipo_accesorio` int(11) NOT NULL,
  `sku_accesorio` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pertenece_tipo`
--

INSERT INTO `pertenece_tipo` (`id_tipo_accesorio`, `sku_accesorio`) VALUES
(1, '0NY4BINL'),
(1, '1HTLA8Z0'),
(2, '0NY4BINL'),
(10, '1HTLA8Z0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`) VALUES
(1, 'Banco de Chile'),
(2, 'Banco Falabella'),
(3, 'Banco Santander'),
(4, 'Banco Renzo Motors');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_accesorio`
--

CREATE TABLE `registro_accesorio` (
  `codigo_verificador` bigint(20) NOT NULL,
  `sucursal_compra` varchar(100) NOT NULL,
  `correo_compra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_compra_accesorio`
--

CREATE TABLE `registro_compra_accesorio` (
  `sku_accesorio` varchar(8) NOT NULL,
  `rut_usuario` varchar(100) NOT NULL,
  `cantidad_accesorio` int(11) NOT NULL,
  `fecha_compra_a` date NOT NULL,
  `codigo_verificador` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_reserva`
--

CREATE TABLE `registro_reserva` (
  `id_registro_reserva` int(11) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `sucursal_reserva` int(11) NOT NULL,
  `correo_reserva` varchar(100) NOT NULL,
  `correo_cliente` varchar(100) NOT NULL,
  `telefono_cliente` int(11) NOT NULL,
  `metodo_pago` varchar(100) NOT NULL,
  `precio_reserva` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `color_reserva` int(11) NOT NULL,
  `compra_concretada` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_vehiculo`
--

CREATE TABLE `reserva_vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `hora_reserva` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(2, 'Administrador Superior'),
(3, 'Recursos Humanos'),
(4, 'Administrador de Accesorios'),
(5, 'Administrador de Vehículos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`id_rol`, `id_permiso`) VALUES
(2, 2),
(2, 3),
(2, 4),
(3, 3),
(4, 4),
(5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro`
--

CREATE TABLE `seguro` (
  `id_seguro` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `nombre_seguro` varchar(100) NOT NULL,
  `descripcion_seguro` text NOT NULL,
  `precio_seguro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguro`
--

INSERT INTO `seguro` (`id_seguro`, `id_proveedor`, `nombre_seguro`, `descripcion_seguro`, `precio_seguro`) VALUES
(1, 1, 'Seguro anti-robo BdC', 'dasdawd', 100000),
(3, 3, 'Seguro de fallo Ruedas', 'Ruedas malas', 50000),
(4, 4, 'Seguro contra accidentes Renzo-Motors', 'No chocar', 120000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_cobertura`
--

CREATE TABLE `seguro_cobertura` (
  `id_seguro` int(11) NOT NULL,
  `id_cobertura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguro_cobertura`
--

INSERT INTO `seguro_cobertura` (`id_seguro`, `id_cobertura`) VALUES
(1, 1),
(1, 3),
(1, 4),
(3, 3),
(4, 2),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `descripcion_servicio` text NOT NULL,
  `nombre_servicio` varchar(100) NOT NULL,
  `telefono_encargado` varchar(100) NOT NULL,
  `precio_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `descripcion_servicio`, `nombre_servicio`, `telefono_encargado`, `precio_servicio`) VALUES
(1, 'Cambio de Aceite para todo vehículo', 'Cambio de aceite', '911111111', 70000),
(2, 'asdasda', 'Cambio de ruedas', '922222222', 12340);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `encargado_sucursal` varchar(100) NOT NULL,
  `nombre_sucursal` varchar(100) NOT NULL,
  `direccion_sucursal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_sucursal`, `encargado_sucursal`, `nombre_sucursal`, `direccion_sucursal`) VALUES
(1, 'Mr. Renzo Motors', 'Gran Central Renzo Motors', 'Caletera General San Martin 6700, Colina, Santiago, Región Metropolitana'),
(2, 'Joaquín Rojas Paredes', 'Santiago centro', 'Portugal 306, Santiago, Región Metropolitana'),
(3, 'Francisca Sepúlveda Contreras', 'Santiago Sur', 'Av. Gabriela 3041-3235, 8830503 La Pintana, Región Metropolitana'),
(4, 'Camila Gutiérrez Zambrano', 'Concepción Centro', 'Angol 920, 4030483 Concepción, Bío Bío'),
(5, 'Claudio Méndez Araya', 'Coquimbo Centro', 'Avenida Varela 1524, 1781107 Coquimbo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal_servicio`
--

CREATE TABLE `sucursal_servicio` (
  `id_sucursal` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursal_servicio`
--

INSERT INTO `sucursal_servicio` (`id_sucursal`, `id_servicio`) VALUES
(1, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_accesorio`
--

CREATE TABLE `tipo_accesorio` (
  `id_tipo_accesorio` int(11) NOT NULL,
  `nombre_tipo_accesorio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_accesorio`
--

INSERT INTO `tipo_accesorio` (`id_tipo_accesorio`, `nombre_tipo_accesorio`) VALUES
(1, 'Limpieza'),
(2, 'Aromatico'),
(3, 'Seguridad'),
(4, 'Comodidad'),
(5, 'Decoración'),
(9, 'Luces'),
(10, 'Ruedas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_combustible`
--

CREATE TABLE `tipo_combustible` (
  `id_tipo_combustible` int(11) NOT NULL,
  `nombre_tipo_combustible` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_combustible`
--

INSERT INTO `tipo_combustible` (`id_tipo_combustible`, `nombre_tipo_combustible`) VALUES
(1, 'Gasolina 93'),
(2, 'Gasolina 95'),
(3, 'Gasolina 97'),
(4, 'Diésel'),
(5, 'Gas Licuado de Petróleo'),
(7, 'Premium (de alto octanaje)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id_tipo_pago` int(11) NOT NULL,
  `nombre_tipo_pago` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_tipo_pago`, `nombre_tipo_pago`) VALUES
(2, 'Debito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_rueda`
--

CREATE TABLE `tipo_rueda` (
  `id_tipo_rueda` int(11) NOT NULL,
  `nombre_tipo_rueda` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_rueda`
--

INSERT INTO `tipo_rueda` (`id_tipo_rueda`, `nombre_tipo_rueda`) VALUES
(1, 'Ruedas convencionales (All-Season)'),
(2, 'Ruedas todoterreno (All-Terrain Tires)'),
(4, 'Neumático Radial'),
(5, 'Ruedas de alto rendimiento (Performance Tires)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id_tipo_vehiculo` int(11) NOT NULL,
  `nombre_tipo_vehiculo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`id_tipo_vehiculo`, `nombre_tipo_vehiculo`) VALUES
(1, 'Monovolumen (Minivan)'),
(2, 'Convertible'),
(3, 'Sedán'),
(5, 'Muscle Car'),
(6, 'SUV');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transmision`
--

CREATE TABLE `transmision` (
  `id_transmision` int(11) NOT NULL,
  `nombre_transmision` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transmision`
--

INSERT INTO `transmision` (`id_transmision`, `nombre_transmision`) VALUES
(1, 'Manual (Mecánica)'),
(2, 'Automática de 6 velocidades'),
(4, 'Automática de 8 velocidades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `rut_usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_financiamiento`
--

CREATE TABLE `usuario_financiamiento` (
  `rut_usuario` varchar(100) NOT NULL,
  `id_financiamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_pago`
--

CREATE TABLE `usuario_pago` (
  `rut_usuario` varchar(100) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_registrado`
--

CREATE TABLE `usuario_registrado` (
  `rut` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `tipo_persona` enum('usuario','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `usuario_registrado`
--
DELIMITER $$
CREATE TRIGGER `actualizar_persona` AFTER UPDATE ON `usuario_registrado` FOR EACH ROW BEGIN
    IF OLD.tipo_persona <> NEW.tipo_persona THEN
        IF NEW.tipo_persona = 'administrador' THEN
            -- Insertar administrador
            INSERT INTO administrador (rut_administrador) VALUES (NEW.rut);
            -- Eliminar usuario existente
            DELETE FROM usuario WHERE rut_usuario = OLD.rut;
        ELSEIF NEW.tipo_persona = 'usuario' THEN
            -- Insertar usuario.
            INSERT INTO usuario (rut_usuario) VALUES (NEW.rut);
            -- Eliminar administrador existente
            DELETE FROM administrador WHERE rut_administrador = OLD.rut;
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `eliminar_usuario` BEFORE DELETE ON `usuario_registrado` FOR EACH ROW BEGIN
    -- Eliminar al administrador
    IF OLD.tipo_persona = 'administrador' THEN
        DELETE FROM administrador WHERE rut_administrador = OLD.rut;
    END IF;

    -- Eliminar al usuario
    IF OLD.tipo_persona = 'usuario' THEN
        DELETE FROM usuario WHERE rut_usuario = OLD.rut;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertar_usuario` AFTER INSERT ON `usuario_registrado` FOR EACH ROW BEGIN
    IF NEW.tipo_persona = 'administrador' THEN
        INSERT INTO administrador (rut_administrador) VALUES (NEW.rut);
    ELSEIF NEW.tipo_persona = 'usuario' THEN
        INSERT INTO usuario (rut_usuario) VALUES (NEW.rut);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_seguro`
--

CREATE TABLE `usuario_seguro` (
  `id_seguro` int(11) NOT NULL,
  `rut_usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `nombre_modelo` varchar(100) NOT NULL,
  `precio_modelo` int(11) NOT NULL,
  `estado_vehiculo` enum('usado','nuevo') NOT NULL,
  `descripcion_vehiculo` text NOT NULL,
  `cantidad_vehiculo` int(11) NOT NULL,
  `cantidad_puertas` enum('2','4') NOT NULL,
  `caballos_fuerza` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_anio` int(11) NOT NULL,
  `id_tipo_combustible` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `id_transmision` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `id_tipo_rueda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id_vehiculo`, `nombre_modelo`, `precio_modelo`, `estado_vehiculo`, `descripcion_vehiculo`, `cantidad_vehiculo`, `cantidad_puertas`, `caballos_fuerza`, `id_marca`, `id_anio`, `id_tipo_combustible`, `id_pais`, `id_transmision`, `id_tipo_vehiculo`, `id_tipo_rueda`) VALUES
(9, 'Chevrolet Tracker', 19000000, 'usado', 'La Chevrolet Tracker es un SUV compacto y moderno, ideal para quienes buscan versatilidad y tecnología avanzada en su vehículo diario. Con un diseño atractivo, amplio espacio interior, y eficiencia en combustible, la Tracker es perfecta para la vida urbana. Equipado con tecnología de conectividad como Apple CarPlay y Android Auto, y con múltiples características de seguridad, este SUV ofrece comodidad y tranquilidad en cada viaje.\r\n\r\nIdeal para: Familias, jóvenes profesionales y conductores urbanos que buscan un vehículo eficiente y seguro.', 20, '4', 132, 2, 4, 1, 5, 1, 6, 4),
(10, 'Dodge Challenger', 30000000, 'nuevo', 'El Dodge Challenger 2023 es un muscle car icónico que combina potencia bruta con un diseño retro y moderno a la vez. Equipado con motores de alto rendimiento, como el V8 HEMI, ofrece una experiencia de conducción emocionante, ideal para los entusiastas de la velocidad. Su interior incluye tecnología avanzada y confort, manteniendo su legado como un verdadero clásico americano con un toque contemporáneo.', 10, '2', 305, 9, 5, 7, 6, 4, 5, 5);

--
-- Disparadores `vehiculo`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_estado_vehiculo` AFTER UPDATE ON `vehiculo` FOR EACH ROW BEGIN
    IF OLD.estado_vehiculo <> NEW.estado_vehiculo THEN
        IF NEW.estado_vehiculo = 'usado' THEN

            DELETE FROM vehiculo_nuevo WHERE id_vehiculo_nuevo = OLD.id_vehiculo;

            INSERT INTO vehiculo_usado (id_vehiculo_usado, kilometraje)
            VALUES (NEW.id_vehiculo, 0);
        ELSEIF NEW.estado_vehiculo = 'nuevo' THEN

            DELETE FROM vehiculo_usado WHERE id_vehiculo_usado = OLD.id_vehiculo;

            INSERT INTO vehiculo_nuevo (id_vehiculo_nuevo)
            VALUES (NEW.id_vehiculo);
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Agregar_vehiculo` AFTER INSERT ON `vehiculo` FOR EACH ROW BEGIN
    IF NEW.estado_vehiculo = 'usado' THEN
        INSERT INTO vehiculo_usado (id_vehiculo_usado, kilometraje)
        VALUES (NEW.id_vehiculo, 0);
    ELSEIF NEW.estado_vehiculo = 'nuevo' THEN
        INSERT INTO vehiculo_nuevo (id_vehiculo_nuevo)
        VALUES (NEW.id_vehiculo);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Eliminar_vehiculo` BEFORE DELETE ON `vehiculo` FOR EACH ROW BEGIN
    -- Eliminar de vehiculo_usado si existe
    DELETE FROM vehiculo_usado WHERE id_vehiculo_usado = OLD.id_vehiculo;

    -- Eliminar de vehiculo_nuevo si existe
    DELETE FROM vehiculo_nuevo WHERE id_vehiculo_nuevo = OLD.id_vehiculo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_nuevo`
--

CREATE TABLE `vehiculo_nuevo` (
  `id_vehiculo_nuevo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_nuevo`
--

INSERT INTO `vehiculo_nuevo` (`id_vehiculo_nuevo`) VALUES
(10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_ofertado`
--

CREATE TABLE `vehiculo_ofertado` (
  `patente` varchar(100) NOT NULL,
  `modelo_oferta` varchar(100) NOT NULL,
  `marca_oferta` varchar(100) NOT NULL,
  `pais_oferta` varchar(100) NOT NULL,
  `imagen_oferta` varchar(255) NOT NULL,
  `kilometraje` int(11) NOT NULL,
  `anio_oferta` int(11) NOT NULL,
  `nombre_duenio` varchar(100) NOT NULL,
  `titulo_propiedad` varchar(255) NOT NULL,
  `correo_duenio` varchar(100) NOT NULL,
  `telefono_duenio` varchar(100) NOT NULL,
  `precio_solicitud` int(11) NOT NULL,
  `rut_duenio` varchar(100) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `rut_usuario` varchar(100) NOT NULL,
  `rut_administrador` varchar(100) DEFAULT NULL,
  `aprobacion` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_sucursal`
--

CREATE TABLE `vehiculo_sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_usado`
--

CREATE TABLE `vehiculo_usado` (
  `id_vehiculo_usado` int(11) NOT NULL,
  `kilometraje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorio`
--
ALTER TABLE `accesorio`
  ADD PRIMARY KEY (`sku_accesorio`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`rut_administrador`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `agenda_prueba`
--
ALTER TABLE `agenda_prueba`
  ADD PRIMARY KEY (`id_sucursal`,`rut_usuario`),
  ADD KEY `rut_usuario` (`rut_usuario`);

--
-- Indices de la tabla `anio`
--
ALTER TABLE `anio`
  ADD PRIMARY KEY (`id_anio`);

--
-- Indices de la tabla `cobertura`
--
ALTER TABLE `cobertura`
  ADD PRIMARY KEY (`id_cobertura`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `color_vehiculo`
--
ALTER TABLE `color_vehiculo`
  ADD PRIMARY KEY (`id_color`,`id_vehiculo`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indices de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  ADD PRIMARY KEY (`id_financiamiento`);

--
-- Indices de la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  ADD PRIMARY KEY (`id_foto_accesorio`),
  ADD KEY `sku_accesorio` (`sku_accesorio`);

--
-- Indices de la tabla `fotos_vehiculo`
--
ALTER TABLE `fotos_vehiculo`
  ADD PRIMARY KEY (`id_foto_vehiculo`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `opinion_vehiculo`
--
ALTER TABLE `opinion_vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`,`rut`),
  ADD KEY `rut` (`rut`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `pertenece_tipo`
--
ALTER TABLE `pertenece_tipo`
  ADD PRIMARY KEY (`id_tipo_accesorio`,`sku_accesorio`),
  ADD KEY `FK` (`sku_accesorio`,`id_tipo_accesorio`) USING BTREE;

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `registro_accesorio`
--
ALTER TABLE `registro_accesorio`
  ADD PRIMARY KEY (`codigo_verificador`);

--
-- Indices de la tabla `registro_compra_accesorio`
--
ALTER TABLE `registro_compra_accesorio`
  ADD PRIMARY KEY (`sku_accesorio`,`rut_usuario`),
  ADD KEY `rut_usuario` (`rut_usuario`),
  ADD KEY `codigo_verificador` (`codigo_verificador`);

--
-- Indices de la tabla `registro_reserva`
--
ALTER TABLE `registro_reserva`
  ADD PRIMARY KEY (`id_registro_reserva`),
  ADD KEY `id_vehiculo` (`id_vehiculo`,`rut`);

--
-- Indices de la tabla `reserva_vehiculo`
--
ALTER TABLE `reserva_vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`,`rut`),
  ADD KEY `rut` (`rut`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`id_rol`,`id_permiso`),
  ADD KEY `FK` (`id_permiso`,`id_rol`) USING BTREE;

--
-- Indices de la tabla `seguro`
--
ALTER TABLE `seguro`
  ADD PRIMARY KEY (`id_seguro`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `seguro_cobertura`
--
ALTER TABLE `seguro_cobertura`
  ADD PRIMARY KEY (`id_seguro`,`id_cobertura`),
  ADD KEY `id_cobertura` (`id_cobertura`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `sucursal_servicio`
--
ALTER TABLE `sucursal_servicio`
  ADD PRIMARY KEY (`id_sucursal`,`id_servicio`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `tipo_accesorio`
--
ALTER TABLE `tipo_accesorio`
  ADD PRIMARY KEY (`id_tipo_accesorio`);

--
-- Indices de la tabla `tipo_combustible`
--
ALTER TABLE `tipo_combustible`
  ADD PRIMARY KEY (`id_tipo_combustible`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id_tipo_pago`);

--
-- Indices de la tabla `tipo_rueda`
--
ALTER TABLE `tipo_rueda`
  ADD PRIMARY KEY (`id_tipo_rueda`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id_tipo_vehiculo`);

--
-- Indices de la tabla `transmision`
--
ALTER TABLE `transmision`
  ADD PRIMARY KEY (`id_transmision`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`rut_usuario`);

--
-- Indices de la tabla `usuario_financiamiento`
--
ALTER TABLE `usuario_financiamiento`
  ADD PRIMARY KEY (`rut_usuario`,`id_financiamiento`),
  ADD KEY `id_financiamiento` (`id_financiamiento`);

--
-- Indices de la tabla `usuario_pago`
--
ALTER TABLE `usuario_pago`
  ADD PRIMARY KEY (`rut_usuario`,`id_tipo_pago`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`);

--
-- Indices de la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  ADD PRIMARY KEY (`rut`),
  ADD UNIQUE KEY `Correo_unico` (`correo`);

--
-- Indices de la tabla `usuario_seguro`
--
ALTER TABLE `usuario_seguro`
  ADD PRIMARY KEY (`id_seguro`,`rut_usuario`),
  ADD KEY `FK` (`rut_usuario`,`id_seguro`) USING BTREE;

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `id_anio` (`id_anio`),
  ADD KEY `id_tipo_combustible` (`id_tipo_combustible`),
  ADD KEY `id_pais` (`id_pais`),
  ADD KEY `id_transmision` (`id_transmision`),
  ADD KEY `id_tipo_vehiculo` (`id_tipo_vehiculo`),
  ADD KEY `fk_tipo_rueda` (`id_tipo_rueda`);

--
-- Indices de la tabla `vehiculo_nuevo`
--
ALTER TABLE `vehiculo_nuevo`
  ADD PRIMARY KEY (`id_vehiculo_nuevo`);

--
-- Indices de la tabla `vehiculo_ofertado`
--
ALTER TABLE `vehiculo_ofertado`
  ADD PRIMARY KEY (`patente`),
  ADD KEY `rut_usuario` (`rut_usuario`),
  ADD KEY `rut_administrador` (`rut_administrador`);

--
-- Indices de la tabla `vehiculo_sucursal`
--
ALTER TABLE `vehiculo_sucursal`
  ADD PRIMARY KEY (`id_sucursal`,`id_vehiculo`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indices de la tabla `vehiculo_usado`
--
ALTER TABLE `vehiculo_usado`
  ADD PRIMARY KEY (`id_vehiculo_usado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anio`
--
ALTER TABLE `anio`
  MODIFY `id_anio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cobertura`
--
ALTER TABLE `cobertura`
  MODIFY `id_cobertura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  MODIFY `id_financiamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  MODIFY `id_foto_accesorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotos_vehiculo`
--
ALTER TABLE `fotos_vehiculo`
  MODIFY `id_foto_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registro_accesorio`
--
ALTER TABLE `registro_accesorio`
  MODIFY `codigo_verificador` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_reserva`
--
ALTER TABLE `registro_reserva`
  MODIFY `id_registro_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `id_seguro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_accesorio`
--
ALTER TABLE `tipo_accesorio`
  MODIFY `id_tipo_accesorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_combustible`
--
ALTER TABLE `tipo_combustible`
  MODIFY `id_tipo_combustible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_rueda`
--
ALTER TABLE `tipo_rueda`
  MODIFY `id_tipo_rueda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id_tipo_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transmision`
--
ALTER TABLE `transmision`
  MODIFY `id_transmision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`rut_administrador`) REFERENCES `usuario_registrado` (`rut`),
  ADD CONSTRAINT `administrador_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `agenda_prueba`
--
ALTER TABLE `agenda_prueba`
  ADD CONSTRAINT `agenda_prueba_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `agenda_prueba_ibfk_2` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`);

--
-- Filtros para la tabla `color_vehiculo`
--
ALTER TABLE `color_vehiculo`
  ADD CONSTRAINT `color_vehiculo_ibfk_1` FOREIGN KEY (`id_color`) REFERENCES `color` (`id_color`),
  ADD CONSTRAINT `color_vehiculo_ibfk_2` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  ADD CONSTRAINT `fotos_accesorio_ibfk_1` FOREIGN KEY (`sku_accesorio`) REFERENCES `accesorio` (`sku_accesorio`);

--
-- Filtros para la tabla `fotos_vehiculo`
--
ALTER TABLE `fotos_vehiculo`
  ADD CONSTRAINT `fotos_vehiculo_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `opinion_vehiculo`
--
ALTER TABLE `opinion_vehiculo`
  ADD CONSTRAINT `opinion_vehiculo_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`),
  ADD CONSTRAINT `opinion_vehiculo_ibfk_2` FOREIGN KEY (`rut`) REFERENCES `usuario_registrado` (`rut`);

--
-- Filtros para la tabla `pertenece_tipo`
--
ALTER TABLE `pertenece_tipo`
  ADD CONSTRAINT `pertenece_tipo_ibfk_1` FOREIGN KEY (`id_tipo_accesorio`) REFERENCES `tipo_accesorio` (`id_tipo_accesorio`),
  ADD CONSTRAINT `pertenece_tipo_ibfk_2` FOREIGN KEY (`sku_accesorio`) REFERENCES `accesorio` (`sku_accesorio`);

--
-- Filtros para la tabla `registro_compra_accesorio`
--
ALTER TABLE `registro_compra_accesorio`
  ADD CONSTRAINT `registro_compra_accesorio_ibfk_1` FOREIGN KEY (`sku_accesorio`) REFERENCES `accesorio` (`sku_accesorio`),
  ADD CONSTRAINT `registro_compra_accesorio_ibfk_2` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`),
  ADD CONSTRAINT `registro_compra_accesorio_ibfk_3` FOREIGN KEY (`codigo_verificador`) REFERENCES `registro_accesorio` (`codigo_verificador`);

--
-- Filtros para la tabla `registro_reserva`
--
ALTER TABLE `registro_reserva`
  ADD CONSTRAINT `registro_reserva_ibfk_1` FOREIGN KEY (`id_vehiculo`,`rut`) REFERENCES `reserva_vehiculo` (`id_vehiculo`, `rut`);

--
-- Filtros para la tabla `reserva_vehiculo`
--
ALTER TABLE `reserva_vehiculo`
  ADD CONSTRAINT `reserva_vehiculo_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`),
  ADD CONSTRAINT `reserva_vehiculo_ibfk_2` FOREIGN KEY (`rut`) REFERENCES `usuario_registrado` (`rut`);

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permiso` (`id_permiso`);

--
-- Filtros para la tabla `seguro`
--
ALTER TABLE `seguro`
  ADD CONSTRAINT `seguro_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `seguro_cobertura`
--
ALTER TABLE `seguro_cobertura`
  ADD CONSTRAINT `seguro_cobertura_ibfk_1` FOREIGN KEY (`id_seguro`) REFERENCES `seguro` (`id_seguro`),
  ADD CONSTRAINT `seguro_cobertura_ibfk_2` FOREIGN KEY (`id_cobertura`) REFERENCES `cobertura` (`id_cobertura`);

--
-- Filtros para la tabla `sucursal_servicio`
--
ALTER TABLE `sucursal_servicio`
  ADD CONSTRAINT `sucursal_servicio_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `sucursal_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario_registrado` (`rut`);

--
-- Filtros para la tabla `usuario_financiamiento`
--
ALTER TABLE `usuario_financiamiento`
  ADD CONSTRAINT `usuario_financiamiento_ibfk_1` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`),
  ADD CONSTRAINT `usuario_financiamiento_ibfk_2` FOREIGN KEY (`id_financiamiento`) REFERENCES `financiamiento` (`id_financiamiento`);

--
-- Filtros para la tabla `usuario_pago`
--
ALTER TABLE `usuario_pago`
  ADD CONSTRAINT `usuario_pago_ibfk_1` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`),
  ADD CONSTRAINT `usuario_pago_ibfk_2` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tipo_pago` (`id_tipo_pago`);

--
-- Filtros para la tabla `usuario_seguro`
--
ALTER TABLE `usuario_seguro`
  ADD CONSTRAINT `usuario_seguro_ibfk_1` FOREIGN KEY (`id_seguro`) REFERENCES `seguro` (`id_seguro`),
  ADD CONSTRAINT `usuario_seguro_ibfk_2` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `fk_tipo_rueda` FOREIGN KEY (`id_tipo_rueda`) REFERENCES `tipo_rueda` (`id_tipo_rueda`),
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`),
  ADD CONSTRAINT `vehiculo_ibfk_2` FOREIGN KEY (`id_anio`) REFERENCES `anio` (`id_anio`),
  ADD CONSTRAINT `vehiculo_ibfk_3` FOREIGN KEY (`id_tipo_combustible`) REFERENCES `tipo_combustible` (`id_tipo_combustible`),
  ADD CONSTRAINT `vehiculo_ibfk_4` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`),
  ADD CONSTRAINT `vehiculo_ibfk_5` FOREIGN KEY (`id_transmision`) REFERENCES `transmision` (`id_transmision`),
  ADD CONSTRAINT `vehiculo_ibfk_6` FOREIGN KEY (`id_tipo_vehiculo`) REFERENCES `tipo_vehiculo` (`id_tipo_vehiculo`);

--
-- Filtros para la tabla `vehiculo_nuevo`
--
ALTER TABLE `vehiculo_nuevo`
  ADD CONSTRAINT `vehiculo_nuevo_ibfk_1` FOREIGN KEY (`id_vehiculo_nuevo`) REFERENCES `vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `vehiculo_ofertado`
--
ALTER TABLE `vehiculo_ofertado`
  ADD CONSTRAINT `vehiculo_ofertado_ibfk_1` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`),
  ADD CONSTRAINT `vehiculo_ofertado_ibfk_2` FOREIGN KEY (`rut_administrador`) REFERENCES `administrador` (`rut_administrador`);

--
-- Filtros para la tabla `vehiculo_sucursal`
--
ALTER TABLE `vehiculo_sucursal`
  ADD CONSTRAINT `vehiculo_sucursal_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `vehiculo_sucursal_ibfk_2` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `vehiculo_usado`
--
ALTER TABLE `vehiculo_usado`
  ADD CONSTRAINT `vehiculo_usado_ibfk_1` FOREIGN KEY (`id_vehiculo_usado`) REFERENCES `vehiculo` (`id_vehiculo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
