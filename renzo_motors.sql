-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2024 a las 16:34:48
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
('0NY4BINL', 35, 'Pino Aromático Piña Colada unidad', 'Pino Aromático Fragancia Piña Colada para Vehículos', 3100),
('1HTLA8Z0', 20, 'Limpiador de Ruedas Meguiaras ULTIMATE', 'Limpiador de Ruedas spray', 5000),
('AROM5MNB', 110, 'Difusor de Aromas USB', 'Difusor portátil con fragancias recargables, funciona por USB.', 14990),
('AROM6XZQ', 100, 'Ambientador Colgante Aroma Vainilla', 'Clásico ambientador colgante con fragancia a vainilla.', 1990),
('AROM9KDL', 95, 'Ambientador en Gel Ocean Breeze', 'Ambientador de larga duración con fragancia fresca marina.', 3490),
('COM5ZTQG', 70, 'Organizador de Asiento', 'Práctico organizador para respaldos de asiento, incluye porta botellas.', 12990),
('COM6YTPQ', 85, 'Cojín de Masaje para Auto', 'Cojín con masajeador incorporado para relajación en viajes.', 25990),
('COM8PLZX', 100, 'Soporte para Smartphone', 'Soporte ajustable para smartphones, se fija al parabrisas.', 7990),
('COMQ7NBG', 80, 'Almohadilla Ergonómica para Asiento', 'Almohadilla con memoria para mejorar la postura en viajes largos.', 9990),
('DEC4RM2J', 150, 'Protector de Volante de Cuero', 'Protector de volante con diseño clásico en cuero sintético.', 15990),
('DEC5LUZG', 110, 'Cubre Volante Deportivo', 'Cubre volante con diseño deportivo y ajuste universal.', 12990),
('DEC6YNBZ', 80, 'Tiradores de Puerta Cromados', 'Juego de tiradores de puerta con acabado cromado.', 19990),
('DEC7YMZN', 85, 'Cobertor de Asiento', 'Cobertor universal para asientos con diseño elegante.', 20990),
('LMP2G5RC', 70, 'Cepillo para Llantas', 'Cepillo ergonómico para limpiar llantas de manera efectiva.', 7490),
('LMP3A7XK', 120, 'Esponja Ultra Suave', 'Esponja de microfibra ideal para lavar autos sin rayar la pintura.', 5990),
('LMP6TRCD', 120, 'Limpiador de Vidrios', 'Producto especializado para un acabado sin marcas.', 4990),
('LMP8MWZY', 120, 'Cera Pulidora', 'Cera de alta calidad para pulido y protección de la pintura.', 15990),
('LUC8TRQP', 95, 'Luces Xenón H4', 'Luces delanteras Xenón de alta intensidad.', 29990),
('LUC9ZQXT', 80, 'Luces para Retroceso LED', 'Luces de retroceso LED con alta luminosidad.', 16990),
('LUCX3V8K', 100, 'Juego de Focos LED H7', 'Focos LED de alta potencia con luz blanca fría para mejor visibilidad.', 25990),
('LUCY8NBX', 90, 'Luces Ambientales LED', 'Luces decorativas LED para interiores con colores ajustables.', 21990),
('RUE7XQPL', 150, 'Protectores de Llantas', 'Protectores duraderos contra bordillos y rayones.', 9990),
('RUE8KM4C', 150, 'Cadenas para Nieve', 'Cadenas resistentes para neumáticos, ideales para condiciones extremas.', 38990),
('RUE9XPLT', 90, 'Tapa de Válvula Cromada', 'Tapas cromadas para válvulas de neumáticos.', 2990),
('RUEQ6T2L', 85, 'Tapabarros Antideslizante', 'Tapabarros universal con material antideslizante para mayor seguridad.', 13990),
('SEG7WQXT', 65, 'Extintor Automotriz', 'Extintor de incendios compacto para autos, incluye soporte.', 19990),
('SEG9XMQT', 80, 'Cámara de Reversa', 'Cámara de alta resolución para asistencia de estacionamiento.', 32990),
('SEGZ8TRM', 75, 'Kit de Triángulos de Emergencia', 'Conjunto de dos triángulos reflectantes para emergencias.', 12990);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `rut_administrador` varchar(100) NOT NULL,
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`rut_administrador`, `id_rol`) VALUES
('11.111.111-1', 2),
('22.222.222-2', 3),
('33.333.333-3', 3),
('44.444.444-4', 9);

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

--
-- Volcado de datos para la tabla `agenda_prueba`
--

INSERT INTO `agenda_prueba` (`id_sucursal`, `rut_usuario`, `rut_conductor`, `nombre_conductor`, `correo_conductor`, `telefono_conductor`, `vehiculo_modelo_prueba`, `fecha_prueba`, `hora_prueba`) VALUES
(1, '20.275.341-8', '20.275.341-8', 'Lucas  Ayala', 'layala@ing.ucsc.cl', '+56979939711', 9, '2024-12-18', '11:30:00');

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
(5, 2023),
(6, 1984),
(7, 2021),
(8, 2025),
(9, 2022),
(11, 2019),
(12, 2017),
(13, 2016);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arriendo_vehiculo`
--

CREATE TABLE `arriendo_vehiculo` (
  `cod_arriendo` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `fecha_arriendo` date NOT NULL,
  `hora_arriendo` time NOT NULL,
  `recibido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_accesorio`
--

CREATE TABLE `carrito_accesorio` (
  `id_carrito` int(11) NOT NULL,
  `sku_accesorio` varchar(8) NOT NULL,
  `cantidad_accesorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_usuario`
--

CREATE TABLE `carrito_usuario` (
  `id_carrito` int(11) NOT NULL,
  `rut_usuario` varchar(100) NOT NULL,
  `valor_carrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito_usuario`
--

INSERT INTO `carrito_usuario` (`id_carrito`, `rut_usuario`, `valor_carrito`) VALUES
(1, '24.012.271-5', 0),
(2, '26.050.994-3', 0),
(3, '12345678-9', 35000),
(4, '87654321-0', 45000),
(5, '11223344-5', 12000),
(6, '99887766-3', 55000),
(7, '44556677-8', 67000),
(8, '12312312-1', 31000),
(9, '32132132-2', 80000),
(10, '99988877-6', 22000),
(11, '54321678-9', 43000),
(12, '22334455-4', 50000),
(13, '55667788-1', 29000),
(14, '66778899-2', 63000),
(15, '12332145-6', 47000),
(16, '43214321-0', 51000),
(17, '87656789-0', 60000),
(18, '20.275.341-8', 0),
(19, '24.012.271-9', 0);

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
  `nombre_color` varchar(100) NOT NULL,
  `codigo_color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `nombre_color`, `codigo_color`) VALUES
(3, 'Negro', '#000000'),
(4, 'Plateado', '#a8a8a8'),
(5, 'Naranja', '#ffa200'),
(6, 'Rojo', '#eb0000'),
(7, 'Azul Marino', '#000080'),
(8, 'Dorado', '#bfc200'),
(9, 'Blanco', '#f7f7f7');

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
(3, 2),
(3, 3),
(3, 4),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 31),
(3, 40),
(3, 42),
(3, 43),
(3, 44),
(3, 47),
(3, 48),
(3, 49),
(3, 50),
(3, 53),
(3, 120),
(4, 1),
(4, 3),
(4, 5),
(4, 6),
(4, 7),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 18),
(4, 19),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 40),
(4, 51),
(4, 120),
(5, 1),
(5, 2),
(5, 4),
(5, 5),
(5, 6),
(5, 16),
(5, 40),
(5, 43),
(5, 45),
(5, 47),
(5, 48),
(5, 53),
(6, 1),
(6, 2),
(6, 4),
(6, 6),
(6, 10),
(6, 12),
(6, 14),
(6, 17),
(6, 24),
(6, 25),
(6, 44),
(6, 45),
(6, 46),
(6, 47),
(6, 48),
(6, 49),
(6, 53),
(7, 3),
(7, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 17),
(7, 20),
(7, 23),
(7, 45),
(7, 49),
(7, 50),
(7, 51),
(7, 52),
(7, 120),
(8, 2),
(8, 3),
(8, 6),
(8, 8),
(8, 11),
(8, 12),
(8, 14),
(8, 25),
(8, 31),
(8, 34),
(8, 40),
(8, 42),
(8, 43),
(8, 44),
(8, 47),
(8, 49),
(8, 52),
(8, 53),
(8, 120),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 11),
(9, 12),
(9, 13),
(9, 19),
(9, 20),
(9, 21),
(9, 22),
(9, 31),
(9, 42),
(9, 43),
(9, 44),
(9, 48),
(9, 50),
(9, 51),
(9, 52),
(9, 53);

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
(8, 'fotos/armoatico_pino2.jpeg', '0NY4BINL'),
(9, 'fotos/armoatico_pino1.png', '0NY4BINL'),
(10, 'fotos/limpia_ruedas_1.jpg', '1HTLA8Z0'),
(11, 'fotos/limpia_ruedas_2.jpg', '1HTLA8Z0'),
(12, 'fotos/Air_Auto_4.jpg', 'AROM6XZQ'),
(14, 'fotos/craneo_valvula.jpg', 'RUE9XPLT'),
(15, 'fotos/camara.jpg', 'SEG9XMQT'),
(16, 'fotos/soporte_accesorio.jpg', 'COM8PLZX'),
(17, 'fotos/cubre_manubrio_deportivo.jpg', 'DEC5LUZG'),
(18, 'fotos/extintor.jpg', 'SEG7WQXT'),
(19, 'fotos/led_h7.jpg', 'LUCX3V8K'),
(20, 'fotos/retroceso_light.jpg', 'LUC9ZQXT'),
(21, 'fotos/organizador-de-asientos.jpg', 'COM5ZTQG'),
(22, 'fotos/tirante.jpg', 'DEC6YNBZ'),
(23, 'fotos/cepillo.jpg', 'LMP2G5RC'),
(26, 'fotos/asiento_calor.jpg', 'COMQ7NBG'),
(27, 'fotos/cojin.jpg', 'COM6YTPQ'),
(28, 'fotos/cobertor.jpg', 'DEC7YMZN'),
(29, 'fotos/usb_humificador.jpg', 'AROM5MNB'),
(30, 'fotos/ambientador_ocean.jpg', 'AROM9KDL'),
(31, 'fotos/cubre_manubrio.jpg', 'DEC4RM2J'),
(32, 'fotos/esponja_ultra.jpg', 'LMP3A7XK'),
(33, 'fotos/ultra_glass.jpg', 'LMP6TRCD'),
(34, 'fotos/cera.jpg', 'LMP8MWZY'),
(36, 'fotos/ice_blue_light.jpg', 'LUCY8NBX'),
(37, 'fotos/llanta.jpg', 'RUE8KM4C'),
(38, 'fotos/proteje_llanta.jpg', 'RUE7XQPL'),
(39, 'fotos/tapabarros.jpg', 'RUEQ6T2L'),
(40, 'fotos/kit_trinagulo.jpg', 'SEGZ8TRM'),
(41, 'fotos/bombilla_b-neon.jpg', 'LUC8TRQP');

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
(9, 'fotos_vehiculos/8-1.webp', 53),
(10, 'fotos_vehiculos/csm_Rivian-R1-teaser_ee3173ed7c.jpg', 53),
(11, 'fotos_vehiculos/rivian_r1t_1.jpg', 53),
(12, 'fotos_vehiculos/imagen-chevrolet-spark-gt-8_1919x1278.jpg', 1),
(13, 'fotos_vehiculos/01011167365-1-1-3.jpg', 1),
(14, 'fotos_vehiculos/2022-kia-sportage.jpg', 2),
(15, 'fotos_vehiculos/2022-kia-sportage-front-quarter.jpg', 2),
(16, 'fotos_vehiculos/lamborghini-aventador-ultimae-2970746.webp', 3),
(17, 'fotos_vehiculos/lamborghini-aventador-blanco-769098-1280x853.webp', 3),
(18, 'fotos_vehiculos/1.hyundai-new-tucson-galeria-1.avif', 120),
(19, 'fotos_vehiculos/Hyundai_Tucson_Hybrid_Adventure_NX4_HEV_Creamy_White_Pearl_(2).jpg', 120),
(20, 'fotos_vehiculos/hyundai-tucson-3458049.webp', 120),
(21, 'fotos_vehiculos/P90536600-mini-cooper-s-02-2024-600px.jpg', 52),
(22, 'fotos_vehiculos/B364C72C-2119-4955-B4E0-F138D7C16143_1024x1024@2x.jpg', 52),
(23, 'fotos_vehiculos/VW-Jetta-Rutamotor-0.jpg', 4),
(24, 'fotos_vehiculos/still-jetta-22-250tsi-rising-blue-metallic-amb-dsc08870.png', 4),
(26, 'fotos_vehiculos/bentley-continental-gt-2024-01.jpg', 51),
(27, 'fotos_vehiculos/2a6bfc169c146e0f4d466bc429dec9c1.jpeg', 5),
(28, 'fotos_vehiculos/Dodge.383.magnum-black.front.view-sstvwf.jpg', 5),
(29, 'fotos_vehiculos/toyota-corolla4.jpg', 6),
(30, 'fotos_vehiculos/Toyota-Corolla-Hybrid-Sedan-Advance-2023-3.jpg', 6),
(31, 'fotos_vehiculos/NPAZ_122ed2e7a1fe4f819d19b795bc6a6c9f.webp', 50),
(32, 'fotos_vehiculos/P90543284_highRes_rolls-royce-ghost-pr-scaled.webp', 50),
(33, 'fotos_vehiculos/NAZ_4a84d32cd6034b0e810535b26d1537cf.jpg', 50),
(34, 'fotos_vehiculos/jag-f-type-r-21my-velocity-blue-reveal-switzerland-02-12-19-01-1575360812.avif', 49),
(35, 'fotos_vehiculos/last-jaguar-f-type.jpg', 49),
(36, 'fotos_vehiculos/1000.webp', 49),
(37, 'fotos_vehiculos/NAZ_6071cb9fac6049229f558b6f9f67495f.webp', 48),
(38, 'fotos_vehiculos/1600.webp', 48),
(39, 'fotos_vehiculos/331887-Volvo-XC90-Rutamotor-exterior.webp', 47),
(40, 'fotos_vehiculos/xc90-fuel-gallery-2-1x1.webp', 47),
(41, 'fotos_vehiculos/xc90-hybrid-hero-4x3.webp', 47),
(42, 'fotos_vehiculos/mustang-mach-1-ext-8.jpg', 7),
(43, 'fotos_vehiculos/mustang-gt-performance_pista-9.jpg', 7),
(45, 'fotos_vehiculos/mobile.jpg', 46),
(46, 'fotos_vehiculos/NAZ_92dcbdb9c062418baa3355403bfcf440.jpg', 45),
(47, 'fotos_vehiculos/Ext231696-1.jpg', 45),
(48, 'fotos_vehiculos/citroen-New-C5-AirCross-tijuca-blue.jpg', 44),
(49, 'fotos_vehiculos/CL-21.038.004.jpg', 44),
(50, 'fotos_vehiculos/GAZ_7be979dd534245ba955630c256afb635.jpg', 44),
(51, 'fotos_vehiculos/renault-clio-lanzamiento-rutamotor55.webp', 43),
(52, 'fotos_vehiculos/Renault_Clio_R.S._Line_(V)_–_f_17102021.jpg', 43),
(53, 'fotos_vehiculos/renault-clio-front-view.jpg', 43),
(54, 'fotos_vehiculos/JWyQusUJf0DJ7QSbiZK643-FZncCPC_foto_.jpeg', 42),
(55, 'fotos_vehiculos/7bwfvntmkt7356xgpy018an34.jpg', 42),
(56, 'fotos_vehiculos/NAZ_fd157bb97a48425f8ba542bff3f441ef.webp', 42),
(57, 'fotos_vehiculos/2018_Suzuki_Swift_SZ5_Boosterjet_SHVS_1.0_Front.jpg', 41),
(58, 'fotos_vehiculos/Fotos-Blog-Hidalgo-2.png', 41),
(59, 'fotos_vehiculos/conoce-eclipse-cross.webp', 40),
(60, 'fotos_vehiculos/eclipse-cross-mitsubishi-1-1.webp', 40),
(61, 'fotos_vehiculos/1366_2000.jpeg', 8),
(62, 'fotos_vehiculos/trim-LX.jpg', 8),
(63, 'fotos_vehiculos/descarga.jpg', 31),
(64, 'fotos_vehiculos/2019_Nissan_Altima_SL_2.5L_front_3.22.19.jpg', 31),
(65, 'fotos_vehiculos/Aston_Martin-DB11_2017_C01.webp', 25),
(66, 'fotos_vehiculos/aston-martin-db11-carretera-407557.jpg', 25),
(67, 'fotos_vehiculos/1aegm9p2fidlgyqngx3yd23rc.jpg', 11),
(68, 'fotos_vehiculos/mazda-cx-5-2024.jpg', 11),
(70, 'fotos_vehiculos/Subaru_Forester_Genf_2019_1Y7A5496.jpg', 12),
(71, 'fotos_vehiculos/se6xnbjj6xuvejdfkhb8.png', 13),
(72, 'fotos_vehiculos/1366_2000.jpeg', 13),
(73, 'fotos_vehiculos/mclaren-720s-spider-by-mso.jpg', 24),
(74, 'fotos_vehiculos/720S-Coupe_hero_crop-16x9.webp', 24),
(75, 'fotos_vehiculos/Bugatti_Chiron_1.jpg', 23),
(76, 'fotos_vehiculos/bugatti-chiron-1500.webp', 23),
(77, 'fotos_vehiculos/5ea6cc155d40a35d05a53091-09_ferrari-250_europavignale_coupã©_488_gtb_esterni.avif', 22),
(78, 'fotos_vehiculos/ferrari-488-gtb-6.jpg', 22),
(79, 'fotos_vehiculos/5ea6cdda5d40a35d05a53137-12_ferrari-250_gt_pinin_farina_coupã©_488_gtb_esterni.avif', 22),
(80, 'fotos_vehiculos/2B1B53F155074C1591397D78EE530FA4_54F74867AE7F4D2B87128A2C3F761F1D_CZ25W12IX0011-911-carrera-gts-front.avif', 21),
(81, 'fotos_vehiculos/0683EEF17ADA4D6ABAA276C65235E96C_29BC6C3357784A859B8A0E4B36EE15F8_CZ25W14IX0010-911-carrera-4-gts-side.avif', 21),
(82, 'fotos_vehiculos/E969499404154DB79BAD58EF5CC8CFAB_82BBE0A2462E47C4B1DB34EA0B23B853_CZ25W12IX0010-911-carrera-gts-side.avif', 21),
(83, 'fotos_vehiculos/images.jpeg', 20),
(84, 'fotos_vehiculos/2020-lexus-rx-350-450h-131-1563213245.avif', 20),
(85, 'fotos_vehiculos/79effabfe0c598922cae6356a654c3f6.jpg', 19),
(87, 'fotos_vehiculos/Infiniti_Q50S_001-1264x734.jpg', 19),
(88, 'fotos_vehiculos/25RDX_EXT_360_UGP_0001.avif', 18),
(89, 'fotos_vehiculos/840_560.jpg', 18),
(90, 'fotos_vehiculos/escalade_v_21284_v9-1.jpg', 17),
(91, 'fotos_vehiculos/my25-escalade-features-exterior-intro-l-v2.avif', 17),
(92, 'fotos_vehiculos/2022_buick_enclave_4dr-suv_avenir_fq_oem_1_1600.jpg', 16),
(93, 'fotos_vehiculos/26f838d52e7a4cafb83754bed3cc9e2c_768x460.jpg', 16),
(94, 'fotos_vehiculos/escalade_v_21284_v9-1.jpg', 16),
(95, 'fotos_vehiculos/147bd033dc1ee2844d16dccf76c9f9381290f188.jpeg', 14),
(96, 'fotos_vehiculos/6790366268094dd9e9d146fd71caf91ebf5e03b7.jpeg', 14),
(97, 'fotos_vehiculos/hmg-prod.s3.amazonaws-3-1080x675.png', 15),
(98, 'fotos_vehiculos/2022-gmc-sierra-1500-at4x-107-1652106261.avif', 15),
(99, 'fotos_vehiculos/25MY_Forester_Touring_-1.jpg', 12),
(100, 'fotos_vehiculos/3f505d9a-b9ee-443d-bfd0-e7a965dcdc69.jpg', 51),
(101, 'fotos_vehiculos/HP.jpg', 46),
(102, 'fotos_vehiculos/Dodge_challeger_rojo.png', 10),
(103, 'fotos_vehiculos/Dodge_challenger_gris.png', 10),
(104, 'fotos_vehiculos/Kia_seltos.jpg', 34),
(105, 'fotos_vehiculos/Chevrolet-Tracker-2021_2.jpg', 9),
(106, 'fotos_vehiculos/CHEVROLET-TRACKER.png', 9);

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
(3, 'Kia', 'Kya-Logo.jpg', 'Kia es una marca surcoreana que se ha ganado una reputación por fabricar vehículos confiables, con diseño moderno y tecnologías avanzadas.'),
(4, 'Lamborghini', 'Lamborghini_logo.jpg', 'Lamborghini es una marca italiana de autos deportivos de lujo, conocida por su diseño vanguardista y alto rendimiento en superdeportivos.'),
(5, 'Volkswagen', 'Volkswagen-logo.jpg', 'Volkswagen, de origen alemán, es una de las marcas más reconocidas a nivel mundial, famosa por su calidad de ingeniería y diseño.'),
(9, 'Dodge', 'dodge-logo_1919x428.jpg', 'Dodge es una marca automotriz estadounidense, famosa por sus vehículos potentes y de alto rendimiento, especialmente muscle cars como el Charger y el Challenger. Fundada en 1900, Dodge se ha destacado por su enfoque en la fuerza, velocidad y durabilidad, creando una sólida reputación en el mundo del automovilismo deportivo y utilitario.'),
(10, 'Toyota', 'Toyota_logo_(Red).svg.png', 'Marca japonesa conocida por su fiabilidad y calidad.'),
(11, 'Ford', 'png-transparent-ford-motor-company-ford-fiesta-ford-mustang-car-ford-emblem-truck-logo.png', 'Fabricante estadounidense con una larga tradición en automóviles y camionetas.'),
(12, 'Honda', 'png-transparent-honda-logo-car-toyota-honda-cr-v-honda-angle-trademark-rectangle.png', 'Reconocida por su innovación y eficiencia en vehículos.'),
(13, 'Hyundai', 'png-transparent-hyundai-motor-company-logo-hyundai-sonata-hyundai-i10-hyundai-blue-text-trademark-thumbnail.png', 'Marca surcoreana destacada por su diseño moderno y tecnología avanzada.'),
(14, 'Nissan', 'png-transparent-nissan-car-logo-nissan-emblem-trademark-desktop-wallpaper.png', 'Fabricante japonés con una gama diversa de vehículos.'),
(15, 'Mazda', 'png-transparent-mazda-logo-mazda-rx-8-car-mazda-premacy-mazda-familia-mazda-emblem-text-trademark.png', 'Marca japonesa conocida por su diseño y rendimiento deportivo.'),
(16, 'Subaru', 'png-clipart-subaru-impreza-wrx-sti-car-logo-high-definition-television-subaru-emblem-desktop-wallpaper.png', 'Reconocida por su enfoque en seguridad y tracción integral.'),
(17, 'Tesla', 'png-transparent-tesla-motors-electric-car-electric-vehicle-logo-t-uuml-rkiye-angle-company-text.png', 'Líder en el mercado de vehículos eléctricos e innovadores.'),
(18, 'Jeep', 'png-clipart-jeep-car-logo-brand-product-jeep-text-logo.png', 'Marca estadounidense especializada en vehículos todoterreno.'),
(19, 'GMC', 'png-transparent-2018-gmc-acadia-denali-t-shirt-logo-brand-cars-logo-brands-text-trademark-rectangle-thumbnail.png', 'Fabricante de camionetas y SUV robustos y confiables.'),
(20, 'Buick', 'Buick_2022_logo.png', 'Marca estadounidense con énfasis en lujo y confort.'),
(21, 'Cadillac', 'cadillac-logo-0.png', 'Reconocida por su elegancia y desempeño en el segmento premium.'),
(22, 'Acura', 'Acura-Color.jpg', 'La división de lujo de Honda.'),
(23, 'Infiniti', 'png-transparent-infiniti-g37-car-nissan-infinity-angle-emblem-trademark.png', 'La marca premium de Nissan.'),
(24, 'Lexus', 'png-clipart-lexus-ls-car-logo-emblem-car-angle-emblem.png', 'División de lujo de Toyota, conocida por su refinamiento y fiabilidad.'),
(25, 'Porsche', 'png-clipart-porsche-logo-porsche-911-car-porsche-cayenne-porsche-cayman-porsche-logo-emblem-logo-thumbnail.png', 'Marca alemana famosa por sus autos deportivos y lujo.'),
(26, 'Ferrari', 'avdwexqe8.webp', 'Símbolo de velocidad y exclusividad italiana.'),
(27, 'Bugatti', 'png-transparent-bugatti-veyron-car-bugatti-chiron-bugatti-vision-gran-turismo-bugatti-emblem-label-text-thumbnail.png', 'Fabricante de autos de lujo y alto rendimiento.'),
(28, 'McLaren', 'png-transparent-mclaren-automotive-mclaren-720s-mclaren-senna-mclaren-f1-gtr-mclaren-logo-text-logo-car.png', 'Marca británica de autos deportivos de alto rendimiento.'),
(29, 'Aston Martin', 'png-transparent-aston-martin-logo-aston-martin-vantage-car-aston-martin-db9-ford-motor-company-james-bond-angle-emblem-logo-thumbnail.png', 'Fabricante británico reconocido por su lujo y estilo.'),
(30, 'Mitsubishi', 'png-transparent-mitsubishi-lancer-evolution-mitsubishi-motors-car-mitsubishi-eclipse-mitsubishi-angle-text-triangle.png', 'Marca japonesa con una variedad de autos económicos y todoterreno.'),
(31, 'Suzuki', 'png-transparent-icon-suzuki-logo-motorcycle-car-suzuki-emblem-text-logo.png', 'Fabricante japonés especializado en autos pequeños y económicos.'),
(32, 'Peugeot', 'png-clipart-peugeot-logo-peugeot-car-brand.png', 'Marca francesa conocida por su diseño elegante y práctico.'),
(33, 'Renault', 'png-transparent-renault-logo-renault-symbol-jaguar-cars-peugeot-renault-angle-logo-car.png', 'Fabricante francés con una gama de autos versátiles.'),
(34, 'Citroën', 'png-transparent-citroen-car-logo-brand-citroen-angle-logos-line.png', 'Marca francesa reconocida por su innovación y confort.'),
(35, 'Fiat', 'fiat-3.svg', 'Fabricante italiano especializado en autos compactos y urbanos.'),
(36, 'Alfa Romeo', 'gratis-png-alfa-romeo-giulia-car-2015-alfa-romeo-4c-fiat-s-p-a-alfa-romeo-logo-thumbnail.png', 'Marca italiana famosa por su diseño y rendimiento deportivo.'),
(37, 'Volvo', 'png-clipart-ab-volvo-emblem-logo-product-design-brand-volvo-logo-emblem-text.png', 'Marca sueca reconocida por su seguridad y calidad.'),
(38, 'Land Rover', 'png-transparent-range-rover-sport-jaguar-land-rover-car-land-rover-defender-land-rover-emblem-label-logo.png', 'Fabricante británico especializado en SUVs de lujo todoterreno.'),
(39, 'Jaguar', 'png-transparent-jaguar-cars-luxury-vehicle-logo-jaguar-angle-animals-company.png', 'Marca británica conocida por su diseño elegante y desempeño.'),
(40, 'Rolls-Royce', 'png-transparent-rolls-royce-holdings-plc-car-rolls-royce-phantom-vii-rolls-royce-wraith-rolls-text-rectangle-trademark-thumbnail.png', 'Famosa por sus vehículos de lujo supremo.'),
(41, 'Bentley', 'bentley_logo_icon_247481.webp', 'Reconocida por autos de lujo y gran rendimiento.'),
(42, 'Mini', 'png-clipart-mini-logo-2018-mini-cooper-bmw-car-logo-benz-logo-angle-emblem.png', 'Marca británica famosa por sus autos compactos y estilo único.'),
(43, 'Rivian', 'Rivian-Logo.jpg', 'Fabricante emergente especializado en vehículos eléctricos todoterreno.');

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

--
-- Volcado de datos para la tabla `opinion_vehiculo`
--

INSERT INTO `opinion_vehiculo` (`id_vehiculo`, `rut`, `titulo_resenia`, `resenia`, `autor_resenia`, `fecha_resenia`, `anonima`, `calificacion`) VALUES
(9, '24.012.271-9', 'La mejor Compra', 'Le agradezco a Renzo Motors por venderme esta Joya, nunca Taxi', NULL, '2024-12-02', 1, 5);

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
(6, 'Estados Unidos'),
(7, 'Mexico'),
(8, 'Japón'),
(9, 'Corea del Sur'),
(10, 'Francia'),
(11, 'Alemania'),
(12, 'Taiwan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabra_prohibida`
--

CREATE TABLE `palabra_prohibida` (
  `id_palabra_prohibida` int(11) NOT NULL,
  `palabra` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Personal'),
(8, 'Ventas'),
(9, 'Solicitudes'),
(11, 'Mantenedores');

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
(1, 'LMP2G5RC'),
(1, 'LMP3A7XK'),
(1, 'LMP6TRCD'),
(1, 'LMP8MWZY'),
(2, '0NY4BINL'),
(2, 'AROM5MNB'),
(2, 'AROM6XZQ'),
(2, 'AROM9KDL'),
(3, 'SEG7WQXT'),
(3, 'SEG9XMQT'),
(3, 'SEGZ8TRM'),
(4, 'COM5ZTQG'),
(4, 'COM6YTPQ'),
(4, 'COM8PLZX'),
(4, 'COMQ7NBG'),
(5, 'DEC4RM2J'),
(5, 'DEC5LUZG'),
(5, 'DEC6YNBZ'),
(5, 'DEC7YMZN'),
(5, 'LUCY8NBX'),
(9, 'LUC8TRQP'),
(9, 'LUC9ZQXT'),
(9, 'LUCX3V8K'),
(9, 'LUCY8NBX'),
(10, '1HTLA8Z0'),
(10, 'RUE7XQPL'),
(10, 'RUE8KM4C'),
(10, 'RUE9XPLT'),
(10, 'RUEQ6T2L');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion_especial`
--

CREATE TABLE `promocion_especial` (
  `id_promocion` int(11) NOT NULL,
  `nombre_promocion` varchar(100) NOT NULL,
  `descripcion_promocion` text NOT NULL,
  `icono_promocion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promocion_especial`
--

INSERT INTO `promocion_especial` (`id_promocion`, `nombre_promocion`, `descripcion_promocion`, `icono_promocion`) VALUES
(4, 'Dueño Único', 'Para aquellos vehículos con 1 solo dueño', 'Usuario_unico.png'),
(5, 'Calificación S', 'Aquellos vehículos usados en perfecto estado', 'Splus_promo.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion_vehiculo`
--

CREATE TABLE `promocion_vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `id_promocion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `imagen_proveedor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `imagen_proveedor`) VALUES
(1, 'Banco de Chile', 'fotos_proveedor/banco_de_chile.png'),
(2, 'Banco Falabella', 'fotos_proveedor/banco-falabella-logo-0.png'),
(3, 'Banco Santander', 'fotos_proveedor/Santander_bank_logo.png'),
(4, 'Renzo Motors', 'fotos_proveedor/logo_renzo_motor.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_accesorio`
--

CREATE TABLE `registro_accesorio` (
  `codigo_verificador` bigint(20) NOT NULL,
  `sucursal_compra` varchar(100) NOT NULL,
  `correo_compra` varchar(100) NOT NULL,
  `fecha_compra_a` date NOT NULL,
  `listado_compra` text NOT NULL,
  `valor_compra` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_accesorio`
--

INSERT INTO `registro_accesorio` (`codigo_verificador`, `sucursal_compra`, `correo_compra`, `fecha_compra_a`, `listado_compra`, `valor_compra`, `id_carrito`) VALUES
(123555, 'Santiago Centro', 'maria.lopez@example.com', '2024-11-29', 'Accesorio3', 45000, 2),
(123891, 'Concepcion Centro', 'diego.fuentes@example.com', '2024-11-26', 'Accesorio7', 67000, 5),
(234556, 'Gran Central Renzo Motors', 'juan.perez@example.com', '2024-11-30', 'Accesorio1, Accesorio2', 35000, 1),
(237829, 'Gran Central Renzo Motors', 'tomas.pena@example.com', '2024-11-20', 'Accesorio14', 29000, 11),
(284927, 'Concepcion Centro', 'isabel.mendez@example.com', '2024-11-21', 'Accesorio13', 50000, 10),
(328745, 'Coquimbo Centro', 'daniela.salas@example.com', '2024-11-17', 'Accesorio17', 51000, 14),
(382194, 'Coquimbo Centro', 'luis.castro@example.com', '2024-11-22', 'Accesorio12', 43000, 9),
(521893, 'Gran Central Renzo Motors', 'ana.rojas@example.com', '2024-11-25', 'Accesorio8', 31000, 6),
(547853, 'Coquimbo Centro', 'laura.martinez@example.com', '2024-11-27', 'Accesorio6', 55000, 4),
(578291, 'Santiago Centro', 'jorge.silva@example.com', '2024-11-24', 'Accesorio9', 80000, 7),
(578489, 'Concepcion Centro', 'ignacio.paredes@example.com', '2024-11-16', 'Accesorio18', 60000, 15),
(583990, 'Santiago Sur', 'camila.vega@example.com', '2024-11-23', 'Accesorio10, Accesorio11', 22000, 8),
(654784, 'Santiago Sur', 'pedro.gomez@example.com', '2024-11-28', 'Accesorio4, Accesorio5', 12000, 3),
(783294, 'Santiago Sur', 'carlos.navarro@example.com', '2024-11-18', 'Accesorio16', 47000, 13),
(853929, 'Santiago Centro', 'sara.ortega@example.com', '2024-11-19', 'Accesorio15', 63000, 12),
(4021220240000, '4', 'layala@ing.ucsc.cl', '2024-12-02', '0NY4BINL:5, ', 15500, 18),
(123456789012345, 'Gran Central Renzo Motors', 'cliente1@example.com', '2024-01-15', 'Accesorio A', 150, 1),
(123456789012346, 'Santiago Centro', 'cliente2@example.com', '2024-02-20', 'Accesorio B', 120, 2),
(123456789012347, 'Santiago Sur', 'cliente3@example.com', '2024-03-05', 'Accesorio C', 180, 3),
(123456789012348, 'Coquimbo Centro', 'cliente4@example.com', '2024-04-10', 'Accesorio D', 200, 4),
(123456789012349, 'Concepción Centro', 'cliente5@example.com', '2024-05-25', 'Accesorio E', 110, 5),
(123456789012350, 'Gran Central Renzo Motors', 'cliente6@example.com', '2024-06-30', 'Accesorio F', 130, 6),
(123456789012351, 'Santiago Centro', 'cliente7@example.com', '2024-07-15', 'Accesorio G', 170, 7),
(123456789012352, 'Santiago Sur', 'cliente8@example.com', '2024-08-01', 'Accesorio H', 140, 8),
(123456789012353, 'Coquimbo Centro', 'cliente9@example.com', '2024-09-20', 'Accesorio I', 160, 9),
(123456789012354, 'Concepción Centro', 'cliente10@example.com', '2024-10-05', 'Accesorio J', 150, 10),
(123456789012355, 'Gran Central Renzo Motors', 'cliente11@example.com', '2024-11-12', 'Accesorio K', 180, 11),
(123456789012356, 'Santiago Centro', 'cliente12@example.com', '2024-12-01', 'Accesorio L', 120, 12),
(123456789012357, 'Santiago Sur', 'cliente13@example.com', '2024-01-03', 'Accesorio M', 140, 13),
(123456789012358, 'Coquimbo Centro', 'cliente14@example.com', '2024-02-18', 'Accesorio N', 160, 14),
(123456789012359, 'Concepción Centro', 'cliente15@example.com', '2024-03-25', 'Accesorio O', 110, 15),
(123456789012360, 'Gran Central Renzo Motors', 'cliente16@example.com', '2024-04-05', 'Accesorio P', 190, 1),
(123456789012361, 'Santiago Centro', 'cliente17@example.com', '2024-05-15', 'Accesorio Q', 135, 2),
(123456789012362, 'Santiago Sur', 'cliente18@example.com', '2024-06-22', 'Accesorio R', 145, 3),
(123456789012363, 'Coquimbo Centro', 'cliente19@example.com', '2024-07-10', 'Accesorio S', 150, 4),
(123456789012364, 'Concepción Centro', 'cliente20@example.com', '2024-08-30', 'Accesorio T', 130, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_arriendo`
--

CREATE TABLE `registro_arriendo` (
  `id_registro_arriendo` int(11) NOT NULL,
  `cod_arriendo` int(11) NOT NULL,
  `nombre_arrendedor` varchar(255) NOT NULL,
  `correo_arrendedor` varchar(255) NOT NULL,
  `telefono_arrendedor` varchar(20) NOT NULL,
  `sucursal_arriendo` varchar(255) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `valor_arriendo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_reserva`
--

CREATE TABLE `registro_reserva` (
  `id_registro_reserva` int(11) NOT NULL,
  `rut_cliente` varchar(100) DEFAULT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `sucursal_reserva` varchar(100) DEFAULT NULL,
  `correo_cliente` varchar(100) DEFAULT NULL,
  `telefono_cliente` varchar(100) DEFAULT NULL,
  `metodo_pago` varchar(100) DEFAULT NULL,
  `precio_reserva` int(11) DEFAULT NULL,
  `color_reserva` varchar(100) DEFAULT NULL,
  `compra_concretada` tinyint(1) DEFAULT NULL,
  `num_reserva_vehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_reserva`
--

INSERT INTO `registro_reserva` (`id_registro_reserva`, `rut_cliente`, `nombre_cliente`, `sucursal_reserva`, `correo_cliente`, `telefono_cliente`, `metodo_pago`, `precio_reserva`, `color_reserva`, `compra_concretada`, `num_reserva_vehiculo`) VALUES
(2, '123456789', 'aaa', '3', 'a@a', '123456789', 'Credito', 250000, '7', 0, 3),
(4, '1234', 'Comodidad', '1', 'Comodidad@aaa.com', '123', 'Credito', 250000, '4', 1, 5),
(11, '1233213', 'asd', '3', 'acd@ads', '233332', 'Credito', 300000, '6', 1, 12),
(12, '317692641', 'AAA', '3', 'aaa@aaa.cl', '12345678', 'Credito', 300000, '7', 1, 13),
(13, '317692641', 'AAA', '3', 'aaa@aaa.cl', '12345678', 'Credito', 300000, '7', NULL, 14),
(14, '317692641', 'AAA', '3', 'aaa@aaa.cl', '12345678', 'Credito', 300000, '7', NULL, 16),
(15, '317692641', 'AAA', '3', 'aaa@aaa.cl', '12345678', 'Credito', 300000, '7', NULL, 17),
(16, '317692641', 'AAA', '3', 'aaa@aaa.cl', '12345678', 'Credito', 300000, '7', NULL, 18),
(17, '62338030-0', 'Juanisimo', '5', 'maaaaaaaaaaaa@ing.ucsc.cl', '123456789', 'NULL', 180000, '8', 0, 19),
(18, '62338030-0', 'Matías aaaaaaaaaaaaa', '5', 'maaaaaaaaaaaa@ing.ucsc.cl', '123456789', 'NULL', 180000, '8', NULL, 20),
(19, '62338030-0', 'Matías aaaaaaaaaaaaa', '5', 'maaaaaaaaaaaa@ing.ucsc.cl', '123456789', 'NULL', 180000, '8', NULL, 21),
(20, '62338030-0', 'Matías aaaaaaaaaaaaa', '5', 'maaaaaaaaaaaa@ing.ucsc.cl', '123456789', 'NULL', 180000, '8', NULL, 22),
(21, '62338030-0', 'Matías aaaaaaaaaaaaa', '5', 'maaaaaaaaaaaa@ing.ucsc.cl', '123456789', 'NULL', 180000, '8', NULL, 23),
(22, '62338030-0', 'Matías aaaaaaaaaaaaa', '5', 'maaaaaaaaaaaa@ing.ucsc.cl', '123456789', 'NULL', 180000, '8', NULL, 24),
(23, '24.012.271-9', 'Matías', '9', 'mcarrascoa@ing.ucsc.cl', '123456789', 'NULL', 190000, '7', 1, 25);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reservas_por_local`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `reservas_por_local` (
`nombre_sucursal` varchar(100)
,`reservas_concretadas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_vehiculo`
--

CREATE TABLE `reserva_vehiculo` (
  `num_reserva_vehiculo` int(11) NOT NULL,
  `id_vehiculo` int(11) DEFAULT NULL,
  `rut` varchar(100) DEFAULT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `hora_reserva` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva_vehiculo`
--

INSERT INTO `reserva_vehiculo` (`num_reserva_vehiculo`, `id_vehiculo`, `rut`, `fecha_reserva`, `hora_reserva`) VALUES
(3, 10, '216379020', '2024-10-26', '02:30:31'),
(5, 9, '216379020', '2024-10-26', '02:33:35'),
(6, 10, '216379020', '2024-10-26', '13:41:53'),
(7, 10, '216379020', '2024-10-26', '13:43:49'),
(8, 10, '216379020', '2024-10-26', '13:48:16'),
(9, 10, '216379020', '2024-10-26', '13:49:39'),
(10, 10, '216379020', '2024-10-26', '13:49:49'),
(11, 10, '216379020', '2024-10-26', '13:52:15'),
(12, 10, '216379020', '2024-10-26', '13:54:04'),
(13, 10, '216379020', '2024-11-03', '20:19:52'),
(14, 10, '216379020', '2024-11-03', '20:19:52'),
(16, 10, '216379020', '2024-11-03', '20:26:08'),
(17, 10, '216379020', '2024-11-03', '20:26:08'),
(18, 10, '216379020', '2024-11-03', '20:26:08'),
(19, 34, '20.050.994-3', '2024-11-03', '20:41:17'),
(20, 34, '20.050.994-3', '2024-11-03', '20:41:17'),
(21, 34, '20.050.994-3', '2024-11-03', '20:41:17'),
(22, 34, '20.050.994-3', '2024-11-03', '20:41:17'),
(23, 34, '20.050.994-3', '2024-11-03', '20:41:17'),
(24, 34, '20.050.994-3', '2024-11-03', '20:41:17'),
(25, 9, '24.012.271-9', '2024-12-02', '03:20:18');

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
(2, 'Encargado General'),
(3, 'Recursos Humanos'),
(8, 'Admin. Mantenedores'),
(9, 'Analista de Ventas'),
(10, 'Admin. Solicitudes');

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
(2, 3),
(2, 8),
(2, 9),
(2, 11),
(3, 3),
(8, 11),
(9, 8),
(10, 9);

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
(1, 1, 'Seguro anti-robo BdC', 'Protección confiable contra robos, respaldada por BdC para tu tranquilidad y seguridad.', 100000),
(3, 3, 'Seguro de fallo Ruedas', 'Protección ante daños o fallos en tus ruedas, asegurando tu tranquilidad en cada viaje.', 50000),
(4, 4, 'Seguro contra accidentes ', 'Cobertura integral para protegerte frente a imprevistos y garantizar tu seguridad.', 120000);

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
  `telefono_encargado` int(11) NOT NULL,
  `imagen_servicio` varchar(250) NOT NULL,
  `precio_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `descripcion_servicio`, `nombre_servicio`, `telefono_encargado`, `imagen_servicio`, `precio_servicio`) VALUES
(1, 'Un cambio de aceite es un servicio esencial para el mantenimiento de vehículos, el cual consiste en retirar el aceite usado del motor y reemplazarlo por aceite nuevo para garantizar una lubricación óptima de las piezas móviles. Durante el proceso, también se sustituye el filtro de aceite, que atrapa partículas y sedimentos. Este servicio ayuda a mantener el motor limpio, reduce el desgaste y prolonga su vida útil. En la sucursal, el cliente puede elegir entre distintos tipos de aceites (mineral, sintético o semisintético), según las especificaciones de su vehículo. Se realiza en un área designada con personal capacitado y herramientas especializadas, asegurando eficiencia y calidad.', 'Cambio de aceite', 911111111, 'imagen_servicio/cambio_aceite.jpg', 70000),
(2, 'Un cambio de ruedas es un servicio que asegura la correcta instalación de los neumáticos en un vehículo, mejorando su desempeño y seguridad en carretera. Este procedimiento incluye desmontar las ruedas usadas, inspeccionar los neumáticos y los componentes del sistema de rodamiento (como baleros y frenos), e instalar las nuevas ruedas o neumáticos.\r\n\r\nEl personal utiliza herramientas específicas como gatos hidráulicos, desmontadoras y balanceadoras para garantizar una instalación precisa. Además, se verifica la presión de los neumáticos y el torque de las tuercas para cumplir con las especificaciones del fabricante. Este servicio es ideal para reemplazar neumáticos desgastados o dañados, o cuando se requiere una actualización estacional, como el cambio a neumáticos de invierno o verano.', 'Cambio de ruedas', 922222222, 'imagen_servicio/cambio_ruedas.jpg', 12340),
(4, 'El cambio de pastillas de freno es un servicio fundamental para mantener la seguridad y el rendimiento del sistema de frenado de un vehículo. Este procedimiento implica desmontar las ruedas para acceder al sistema de frenos, retirar las pastillas desgastadas y reemplazarlas por nuevas. Antes de la instalación, se inspeccionan los discos de freno para asegurarse de que estén en buen estado o determinar si requieren rectificación o reemplazo.\r\n\r\nEl técnico aplica lubricante en las partes móviles del sistema para garantizar un funcionamiento suave y realiza un ajuste adecuado de las nuevas pastillas. Al finalizar, se prueba el sistema de frenado para confirmar que funciona correctamente. Este servicio ayuda a prevenir ruidos, vibraciones y, sobre todo, asegura una respuesta eficiente del freno al conducir.', 'Cambio de Pastillas de Freno', 912147483, 'imagen_servicio/Cambio_pastillas_freno.jpg', 27000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_ayuda`
--

CREATE TABLE `solicitud_ayuda` (
  `id_ayuda` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `asunto_solicitud` varchar(40) NOT NULL,
  `descripcion_solicitud` varchar(200) NOT NULL,
  `tipo_solicitud` enum('comentario','sugerencia','reclamo','duda') NOT NULL,
  `respuesta_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_ayuda`
--

INSERT INTO `solicitud_ayuda` (`id_ayuda`, `rut`, `asunto_solicitud`, `descripcion_solicitud`, `tipo_solicitud`, `respuesta_admin`) VALUES
(1, '11223344-5', 'Consulta sobre garantía', '¿Cuál es el plazo de garantía para los accesorios de luces LED?', 'duda', NULL),
(2, '12.456.789-9', 'Problema con mi compra', 'El accesorio recibido no corresponde al solicitado, ¿qué debo hacer?', 'reclamo', 'Le recomendamos iniciar un proceso de devolución.'),
(3, '12312312-1', 'Sugerencia de mejora', 'Sería ideal incluir más opciones de colores para los cubre volantes.', 'sugerencia', NULL),
(4, '12332145-6', 'Duda sobre instalación', '¿Cómo se instala la cámara de reversa en mi modelo de auto?', 'duda', NULL),
(5, '12345678-9', 'Producto defectuoso', 'El organizador de asiento llegó con un cierre roto, ¿pueden cambiarlo?', 'reclamo', 'Por supuesto, puede realizar un cambio sin costo adicional.'),
(6, '20.003.205-2', 'Ambientador no funciona', 'El difusor USB no emite fragancia, ¿hay alguna solución?', 'reclamo', 'Puede intentar reiniciarlo o solicitar un reemplazo.'),
(7, '20.050.994-3', 'Comentario sobre el sitio', 'La interfaz de la página es muy intuitiva, excelente trabajo.', 'comentario', NULL),
(8, '20.123.657-9', 'Pedido incompleto', 'Faltaron las cadenas para nieve en mi envío, ¿qué hago?', 'reclamo', 'Nos disculpamos, el pedido será enviado nuevamente.'),
(9, '20.275.341-8', 'Consulta sobre compatibilidad', '¿Las luces Xenón H4 son compatibles con un auto 2018?', 'duda', NULL),
(10, '216379020', 'Sugerencia de categoría', 'Podrían incluir más accesorios para motos.', 'sugerencia', NULL),
(11, '22334455-4', 'Garantía no respetada', 'Compré el protector de volante, pero se dañó en menos de un mes.', 'reclamo', 'Le reembolsaremos el costo total o puede optar por un cambio.'),
(12, '24.012.271-5', 'Dificultad para rastrear pedido', 'No puedo rastrear mi pedido en su sistema.', 'duda', 'Le hemos enviado por correo el estado actualizado de su envío.'),
(13, '26.050.994-3', 'Queja por atención al cliente', 'No me han respondido sobre un reclamo previo.', 'reclamo', 'Hemos revisado su caso, pronto nos pondremos en contacto.'),
(14, '32132132-2', 'Duda sobre instalación de luces', '¿Qué tipo de herramientas necesito para instalar las luces LED?', 'duda', NULL),
(15, '43214321-0', 'Sugerencia de accesorio', 'Agregar un kit de reparación rápida de neumáticos sería útil.', 'sugerencia', NULL),
(16, '44556677-8', 'Consulta sobre precios', '¿Hay descuentos por comprar más de 5 unidades?', 'duda', 'Contáctenos para aplicar descuentos por volumen.'),
(17, '54321678-9', 'Reclamo por envío tardío', 'Mi pedido lleva más de dos semanas sin llegar.', 'reclamo', 'Estamos trabajando con la empresa de transporte para resolverlo.'),
(18, '55667788-1', 'Comentario positivo', 'Me encantaron los productos, son de muy buena calidad.', 'comentario', NULL),
(19, '66778899-2', 'Dificultad para realizar compra', 'El carrito de compras no permite agregar más de 10 productos.', 'duda', 'Se ha solucionado, por favor intente nuevamente.'),
(20, '87654321-0', 'Queja por producto roto', 'El extintor llegó abollado, ¿es seguro usarlo?', 'reclamo', 'Le enviaremos uno nuevo a la brevedad.'),
(21, '87656789-0', 'Consulta sobre colores', '¿Qué colores están disponibles para el cobertor de asientos?', 'duda', NULL),
(22, '99887766-3', 'Ambientador sin fragancia', 'El ambientador en gel no tiene olor, ¿qué hago?', 'reclamo', 'Podemos enviarle un reemplazo.'),
(23, '99988877-6', 'Solicitud de ayuda técnica', '¿Cómo instalo las cadenas para nieve en un SUV?', 'duda', 'Le hemos enviado un manual por correo electrónico.'),
(24, '11223344-5', 'Sugerencia de categoría', 'Podrían incluir limpiadores para llantas más específicos.', 'sugerencia', NULL),
(25, '12.456.789-9', 'Consulta sobre compatibilidad', '¿El cojín de masaje es compatible con cualquier modelo de asiento?', 'duda', NULL),
(26, '12312312-1', 'Reclamo por calidad', 'La luz de retroceso LED dejó de funcionar al mes.', 'reclamo', 'Le reembolsaremos su compra o puede solicitar un cambio.'),
(27, '12332145-6', 'Comentario sobre envío', 'La entrega fue rápida y los productos llegaron en buen estado.', 'comentario', NULL),
(28, '12345678-9', 'Consulta sobre medidas', '¿Cuáles son las dimensiones del protector de volante?', 'duda', NULL),
(29, '20.003.205-2', 'Problema con el pago', 'No puedo completar el pago con tarjeta de crédito.', 'duda', 'Le sugerimos intentar con otro método de pago.'),
(30, '20.050.994-3', 'Queja por empaque', 'El empaque llegó dañado, aunque el producto estaba bien.', 'reclamo', NULL),
(31, '20.123.657-9', 'Sugerencia de sistema', 'Podrían incluir un chat en vivo para asistencia.', 'sugerencia', NULL),
(32, '20.275.341-8', 'Problema con factura', 'Mi factura no corresponde al pedido realizado.', 'reclamo', 'Estamos corrigiendo su factura, le llegará por correo.'),
(33, '216379020', 'Consulta sobre garantías', '¿Cuál es la política de garantías para productos electrónicos?', 'duda', NULL),
(34, '22334455-4', 'Solicitud de asesoramiento', '¿Qué accesorios son ideales para un auto familiar?', 'duda', 'Le hemos enviado una lista de sugerencias.'),
(35, '24.012.271-5', 'Queja por servicio técnico', 'El servicio técnico no respondió a mi consulta.', 'reclamo', NULL),
(36, '26.050.994-3', 'Sugerencia de mejora', 'Podrían mejorar la velocidad de respuesta en soporte técnico.', 'sugerencia', NULL),
(37, '32132132-2', 'Comentario positivo', 'Excelente experiencia de compra, repetiré pronto.', 'comentario', NULL),
(38, '43214321-0', 'Consulta sobre limpieza', '¿El limpiador de vidrios es seguro para cristales polarizados?', 'duda', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `nombre_sucursal` varchar(100) NOT NULL,
  `encargado_sucursal` varchar(100) NOT NULL,
  `direccion_sucursal` varchar(100) NOT NULL,
  `zona_sucursal` enum('Norte','Centro','Sur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_sucursal`, `nombre_sucursal`, `encargado_sucursal`, `direccion_sucursal`, `zona_sucursal`) VALUES
(1, 'Gran Central Renzo Motors', 'Mr. Renzo Motors', '-33.3042316,-70.708928', 'Centro'),
(2, 'Santiago centro', 'Joaquín Rojas Paredes', '-33.4462135,-70.6383408', 'Centro'),
(3, 'Santiago Sur', 'Francisca Sepúlveda Contreras', '-33.5847473,-70.6193912', 'Centro'),
(4, 'Concepción Centro', 'Camila Gutiérrez Zambrano', '-36.8239637,-73.0578559', 'Sur'),
(5, 'Coquimbo Centro', 'Claudio Méndez Araya', '-29.9580085,-71.3402436', 'Norte'),
(8, 'Central Subacuática RenzoMotors', 'Delfino Ahumado', '-36.8214746,-73.148423', 'Sur'),
(9, 'Iglú RenzoMotors', 'kowalski', '-63.7286844,-59.1659038', 'Sur'),
(10, 'Iquique Centro', 'Alonso Quijano', '-20.2167431,-70.1480809', 'Norte');

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
(1, 2),
(2, 1),
(2, 4),
(3, 4),
(4, 1),
(4, 4),
(5, 1),
(5, 4),
(8, 2),
(9, 2),
(10, 2);

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
(5, 'Gas Licuado'),
(7, 'Premium');

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
(1, 'Convencionales'),
(2, 'Todoterreno'),
(4, 'Radiales'),
(5, 'Alto rendimiento'),
(6, 'Aleación');

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
(6, 'SUV'),
(7, 'Deportivo'),
(8, 'Camioneta');

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
(1, 'Manual'),
(2, 'Automática 6V'),
(4, 'Automática 8V'),
(5, 'Variable Continua CVT'),
(6, 'Doble Embrague');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `rut_usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`rut_usuario`) VALUES
('11223344-5'),
('12.456.789-9'),
('12312312-1'),
('12332145-6'),
('12345678-9'),
('20.003.205-2'),
('20.050.994-3'),
('20.123.657-9'),
('20.275.341-8'),
('216379020'),
('22334455-4'),
('24.012.271-5'),
('24.012.271-9'),
('26.050.994-3'),
('32132132-2'),
('43214321-0'),
('44556677-8'),
('54321678-9'),
('55667788-1'),
('66778899-2'),
('87654321-0'),
('87656789-0'),
('99887766-3'),
('99988877-6');

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
-- Volcado de datos para la tabla `usuario_registrado`
--

INSERT INTO `usuario_registrado` (`rut`, `nombre`, `apellido`, `correo`, `contrasenia`, `tipo_persona`) VALUES
('11.111.111-1', 'Matías', 'Admin', 'mcarrascob@ing.ucsc.cl', '$2y$10$w9HvwZiN6IttWdniLCEwXuOp5zi6LBBVs.r.bmHhuqxcTftsfjpQC', 'administrador'),
('11223344-5', 'Pedro', 'Gomez', 'pedro.gomez@example.com', '$2a$10$L1Q9XXsGzUOqKjZ2Qd9.ZeWt7Y17eUCSdoHMYRFPuvfYXYF5Wr08a', 'usuario'),
('12.456.789-9', 'Benjamin', 'Cifuentes', 'benja.cifuentes.r@gmail.com', '$2y$10$iK3F4bOoLfM.oToM.ju2YurgnnBjfOBAOhOufO5WtJ6aVBUnoUy1S', 'usuario'),
('12312312-1', 'Ana', 'Rojas', 'ana.rojas@example.com', '$2a$10$79FWvY/9sGmUCR9QhLpYxuQK2MtspxRWK9.FCKIRX3tUnMI6OtDlm', 'usuario'),
('12332145-6', 'Carlos', 'Navarro', 'carlos.navarro@example.com', '$2a$10$zUgDweQoqc2RbSYGyZTFNO/Hmlt1uWo8FUy.I9sGcTXgFWcP5Va7a', 'usuario'),
('12345678-9', 'Juan', 'Perez', 'juan.perez@example.com', '$2a$10$X8O9vHJJe5KYFJ/8JLKUhuGEA0C9RwtCSjKgkwUPv8Oi9P5Llf71u', 'usuario'),
('20.003.205-2', 'Juan', 'Perez', 'nmarileo@ing.ucsc.cl', '$2y$10$2YxAZ.9oAjJkU5a7QgOoNuzNg6tbp7PN05j.bNlzHSeWEr.lUbStO', 'usuario'),
('20.050.994-3', 'Matías', 'Carrasco', 'mcscoa@ing.ucsc.cl', 'Clave', 'usuario'),
('20.123.657-9', 'PILAR', 'Guzman', 'nataliamarileo98@gmail.com', '$2y$10$0EBVhz8YzhTgDjrpcVARA.DIAxpJnghJ0giVpWjVv7PyIDa.nFiLi', 'usuario'),
('20.275.341-8', 'Lucas ', 'Ayala', 'layala@ing.ucsc.cl', '$2y$10$4gMz8hewcjVXcTM5MSVE3e85iXCiJKCnYDMMH0UOG0yWySjF79EXC', 'usuario'),
('216379020', 'aaa', 'bbb', 'aaa@bbb.ccc', '12345', 'usuario'),
('22.222.222-2', 'Natalia', 'Marileo', 'nataliamarileo14@gmail.com', '$2y$10$2n0MHmE7FwYBfMBBEc3STO/J5nfh9w9bQmb0E4VaxIvRr6dr4yLKS', 'administrador'),
('22334455-4', 'Isabel', 'Mendez', 'isabel.mendez@example.com', '$2a$10$xFbfzUnIM6frOu/13pA6bOxZIC3zLr6ZPuq6FIcsgg9xMNfR9PvhW', 'usuario'),
('24.012.271-5', 'Juan', 'Perez', 'juan@gmail.com', '$2y$10$PbCPq7zBTgB6da4pkIt07urS4hhKZt7hLtQG.xFmjB.MlaxbWDyUG', 'usuario'),
('24.012.271-9', 'Matías', 'Carrasco', 'mcarrascoa@ing.ucsc.cl', '$2y$10$L0JcVczCWnWPEHM6gKziGeq/bmE7XXKIrJlcTboqwAKCRg0iuXv5C', 'usuario'),
('26.050.994-3', 'Samue', 'De Luque', 'sdeluque@ing.ucsc.cl', '$2y$10$2RUdvmraN52rEVAyfFTeluGA9VsgD0Lm47sDYaGGRkDH8OiAbisHi', 'usuario'),
('32132132-2', 'Jorge', 'Silva', 'jorge.silva@example.com', '$2a$10$Lqs8IvDm.pH41qjZqD.druTnUC9sUVIZt4LJ/W28xLzx38aHYD5K2', 'usuario'),
('33.333.333-3', 'Benjamín', 'Cifuentes', 'bcifuentesb@ing.ucsc.cl', 'ADMIn3.', 'administrador'),
('43214321-0', 'Daniela', 'Salas', 'daniela.salas@example.com', '$2a$10$JdHNs6O8nE4WKH.U21Rj9OX1Vi1BcAzhmyKw0.SAZHVE6jtE3HyPG', 'usuario'),
('44.444.444-4', 'Lucas', 'Ayala', 'layalac@ing.ucsc.cl', 'ADMIn4.', 'administrador'),
('44556677-8', 'Diego', 'Fuentes', 'diego.fuentes@example.com', '$2a$10$MY8JKmFY98XFKvWqj.0mP.Z73NFEDUZy2qsPpl0P8c0uF7YI8PqB6', 'usuario'),
('54321678-9', 'Luis', 'Castro', 'luis.castro@example.com', '$2a$10$NQJU6D76P/kU5WBXx63QkeR76hK/FdFgUXRp5BNIlFT4uSx5TiMtG', 'usuario'),
('55667788-1', 'Tomas', 'Pena', 'tomas.pena@example.com', '$2a$10$gNE8Q7PDPTOcPphBQEOmL.9OB5vcW3j.yPMXlYZ91CF6OT27u5Aa6', 'usuario'),
('66778899-2', 'Sara', 'Ortega', 'sara.ortega@example.com', '$2a$10$.GVYB2A2ksH4uPy39qRC4.5weQcfbMjShB/TMIsHFxsW4mofJqeym', 'usuario'),
('87654321-0', 'Maria', 'Lopez', 'maria.lopez@example.com', '$2a$10$Q6fXJ8Qjd3n/OdY8ZkF/UuaPQAIENsyRnOElFZhdv8Gl9ZOr9YZ6G', 'usuario'),
('87656789-0', 'Ignacio', 'Paredes', 'ignacio.paredes@example.com', '$2a$10$A2OQ6Y7HFlXplEwZR5AuAeLfIAsNl5lC1ZcmR/5WHUwBhRP5l1IFK', 'usuario'),
('99887766-3', 'Laura', 'Martinez', 'laura.martinez@example.com', '$2a$10$9fOIJdLXAcvuwMlRQ68yRuT9ox.2VrPfIGzOjFKn3F/OVuE1KH9pq', 'usuario'),
('99988877-6', 'Camila', 'Vega', 'camila.vega@example.com', '$2a$10$XtGRFuhr3dqlpWBKJbCv1.fu26KhDwvU8AfVRZ0oJmT0ogGS6EZe2', 'usuario');

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
  `id_contratacion_seguro` int(11) NOT NULL,
  `id_seguro` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `marca_s` varchar(50) NOT NULL,
  `modelo_s` varchar(50) NOT NULL,
  `anio_s` int(4) NOT NULL,
  `telefono` int(11) NOT NULL,
  `patente` varchar(30) NOT NULL,
  `numero_motor` varchar(14) NOT NULL,
  `numero_chasis` varchar(14) NOT NULL,
  `fecha_inicio_con` date NOT NULL,
  `fecha_termino_cont` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_seguro`
--

INSERT INTO `usuario_seguro` (`id_contratacion_seguro`, `id_seguro`, `rut`, `id_tipo_vehiculo`, `marca_s`, `modelo_s`, `anio_s`, `telefono`, `patente`, `numero_motor`, `numero_chasis`, `fecha_inicio_con`, `fecha_termino_cont`) VALUES
(20, 3, '22.222.222-2', 2, 'susuki', 'susuki 2', 2001, 971938850, 'BBCI24', '12F345678', '12FGTGDFDFDF', '2024-11-26', '2025-11-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `nombre_modelo` varchar(100) NOT NULL,
  `precio_modelo` int(11) NOT NULL,
  `estado_vehiculo` enum('Usado','Nuevo') NOT NULL,
  `descripcion_vehiculo` text NOT NULL,
  `cantidad_vehiculo` int(11) NOT NULL,
  `cantidad_puertas` enum('2','4') NOT NULL,
  `caballos_fuerza` int(11) NOT NULL,
  `documento_tecnico` varchar(100) DEFAULT NULL,
  `kilometraje` int(11) NOT NULL DEFAULT 0,
  `id_marca` int(11) NOT NULL,
  `id_anio` int(11) NOT NULL,
  `id_tipo_combustible` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `id_transmision` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `id_tipo_rueda` int(11) NOT NULL,
  `arriendo` tinyint(1) NOT NULL DEFAULT 0,
  `valor_garantia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id_vehiculo`, `nombre_modelo`, `precio_modelo`, `estado_vehiculo`, `descripcion_vehiculo`, `cantidad_vehiculo`, `cantidad_puertas`, `caballos_fuerza`, `documento_tecnico`, `kilometraje`, `id_marca`, `id_anio`, `id_tipo_combustible`, `id_pais`, `id_transmision`, `id_tipo_vehiculo`, `id_tipo_rueda`, `arriendo`, `valor_garantia`) VALUES
(1, 'Spark GT', 8500000, 'Usado', 'Un hatchback compacto con gran eficiencia de combustible.', 5, '4', 82, 'documento_general.pdf', 0, 2, 3, 1, 1, 2, 3, 1, 0, 0),
(2, 'Sportage', 20000000, 'Nuevo', 'SUV compacto ideal para familias.', 4, '4', 150, 'documento_general.pdf', 0, 3, 5, 3, 9, 5, 6, 1, 1, 1200000),
(3, 'Aventador', 500000000, 'Usado', 'Superdeportivo de alto rendimiento.', 2, '2', 700, 'documento_general.pdf', 0, 4, 4, 7, 3, 6, 7, 6, 0, 0),
(4, 'Jetta', 18000000, 'Usado', 'Sedán confiable y eficiente.', 6, '4', 147, 'documento_general.pdf', 0, 5, 5, 2, 11, 2, 3, 1, 0, 0),
(5, 'Charger', 25000000, 'Nuevo', 'Muscle car icónico con gran potencia.', 3, '4', 370, 'documento_general.pdf', 15000, 9, 6, 3, 6, 6, 5, 1, 0, 0),
(6, 'Corolla', 16500000, 'Usado', 'Sedán japonés confiable y eficiente.', 7, '4', 132, 'documento_general.pdf', 0, 10, 7, 1, 8, 5, 3, 1, 0, 0),
(7, 'Mustang', 30000000, 'Nuevo', 'Deportivo americano icónico.', 2, '2', 450, 'documento_general.pdf', 0, 11, 8, 3, 6, 2, 7, 1, 0, 0),
(8, 'Civic', 17500000, 'Usado', 'Sedán japonés compacto, eficiente y tecnológico.', 6, '4', 158, 'documento_general.pdf', 0, 12, 3, 2, 8, 5, 3, 1, 0, 0),
(9, 'Chevrolet Tracker', 19000000, 'Usado', 'La Chevrolet Tracker es un SUV compacto y moderno, ideal para quienes buscan versatilidad y tecnología avanzada en su vehículo diario. Con un diseño atractivo, amplio espacio interior, y eficiencia en combustible, la Tracker es perfecta para la vida urbana. Equipado con tecnología de conectividad como Apple CarPlay y Android Auto, y con múltiples características de seguridad, este SUV ofrece comodidad y tranquilidad en cada viaje.\r\n\r\nIdeal para: Familias, jóvenes profesionales y conductores urbanos que buscan un vehículo eficiente y seguro.', 20, '2', 132, 'documento_general.pdf', 0, 2, 4, 1, 5, 1, 6, 1, 0, 0),
(10, 'Dodge Challenger', 30000000, 'Usado', 'El Dodge Challenger 2023 es un muscle car icónico que combina potencia bruta con un diseño retro y moderno a la vez. Equipado con motores de alto rendimiento, como el V8 HEMI, ofrece una experiencia de conducción emocionante, ideal para los entusiastas de la velocidad. Su interior incluye tecnología avanzada y confort, manteniendo su legado como un verdadero clásico americano con un toque contemporáneo.', 11, '4', 320, 'documento_general.pdf', 0, 9, 5, 7, 6, 4, 5, 6, 0, 0),
(11, 'CX-5', 24000000, 'Usado', 'SUV japonés con diseño y desempeño deportivo.', 4, '4', 187, 'documento_general.pdf', 0, 15, 8, 3, 8, 5, 6, 1, 0, 0),
(12, 'Forester', 22000000, 'Usado', 'SUV seguro con tracción integral.', 4, '4', 182, 'documento_general.pdf', 0, 16, 9, 4, 8, 2, 6, 1, 0, 0),
(13, 'Model S', 75000000, 'Usado', 'Sedán eléctrico con tecnología de punta.', 3, '4', 1020, 'documento_general.pdf', 0, 17, 8, 7, 6, 6, 3, 6, 0, 0),
(14, 'Wrangler', 30000000, 'Nuevo', 'Todoterreno robusto y aventurero.', 4, '4', 285, 'documento_general.pdf', 0, 18, 4, 3, 6, 1, 6, 1, 0, 0),
(15, 'Sierra 1500', 35000000, 'Usado', 'Camioneta confiable y poderosa.', 3, '4', 355, 'documento_general.pdf', 0, 19, 9, 2, 6, 2, 8, 1, 0, 0),
(16, 'Enclave', 45000000, 'Nuevo', 'SUV premium con interior lujoso.', 3, '4', 310, 'documento_general.pdf', 0, 20, 5, 3, 6, 6, 6, 1, 1, 2200000),
(17, 'Escalade', 80000000, 'Usado', 'SUV de lujo emblemático.', 2, '4', 420, 'documento_general.pdf', 0, 21, 4, 2, 6, 6, 6, 1, 1, 4000000),
(18, 'RDX', 45000000, 'Usado', 'SUV deportivo de lujo.', 3, '4', 272, 'documento_general.pdf', 0, 22, 8, 3, 8, 5, 6, 1, 1, 2200000),
(19, 'Q50', 47000000, 'Usado', 'Sedán de lujo con alto rendimiento.', 3, '4', 300, 'documento_general.pdf', 0, 23, 9, 2, 8, 2, 3, 1, 0, 0),
(20, 'RX 350', 50000000, 'Usado', 'SUV de lujo refinado y eficiente.', 3, '4', 295, 'documento_general.pdf', 0, 24, 4, 3, 8, 5, 6, 1, 0, 0),
(21, '911 Carrera', 120000000, 'Usado', 'Deportivo alemán icónico.', 1, '2', 379, 'documento_general.pdf', 0, 25, 8, 7, 11, 6, 7, 6, 0, 0),
(22, '488 GTB', 130000000, 'Usado', 'Superdeportivo italiano con diseño espectacular.', 1, '2', 660, 'documento_general.pdf', 0, 26, 5, 7, 3, 6, 7, 6, 0, 0),
(23, 'Chiron', 280000000, 'Nuevo', 'Hiperauto con velocidad extrema y lujo.', 1, '2', 1500, 'documento_general.pdf', 0, 27, 7, 7, 3, 6, 7, 6, 0, 0),
(24, '720S', 200000000, 'Usado', 'Deportivo británico de alto rendimiento.', 1, '2', 710, 'documento_general.pdf', 0, 28, 9, 7, 3, 6, 7, 6, 0, 0),
(25, 'DB11', 210000000, 'Usado', 'Coupé de lujo con diseño elegante.', 1, '2', 630, 'documento_general.pdf', 0, 29, 9, 3, 3, 6, 7, 1, 0, 0),
(31, 'Altima', 21000000, 'Nuevo', 'Sedán elegante y confortable.', 3, '4', 188, 'documento_general.pdf', 12000, 14, 5, 1, 8, 6, 3, 1, 0, 0),
(34, 'Kia Seltos', 18000000, 'Usado', 'El Kia Seltos 2020 es un SUV compacto que combina un diseño moderno y atractivo con una funcionalidad excepcional. Su diseño exterior se caracteriza por líneas agresivas y una parrilla frontal distintiva, lo que le otorga una presencia imponente en la carretera.', 13, '4', 127, 'documento_general.pdf', 1000, 3, 3, 4, 7, 5, 6, 1, 0, 0),
(40, 'Eclipse Cross', 19000000, 'Usado', 'SUV japonés compacto con diseño futurista.', 5, '4', 152, 'documento_general.pdf', 0, 30, 7, 3, 8, 5, 6, 1, 0, 0),
(41, 'Swift', 14500000, 'Nuevo', 'Auto compacto y económico, ideal para ciudad.', 10, '4', 83, 'documento_general.pdf', 0, 31, 5, 1, 8, 5, 3, 1, 1, 800000),
(42, '3008', 25000000, 'Usado', 'SUV francés elegante y bien equipado.', 5, '4', 130, 'documento_general.pdf', 0, 32, 4, 2, 10, 5, 6, 1, 1, 1200000),
(43, 'Clio', 12000000, 'Usado', 'Auto compacto y versátil de diseño francés.', 8, '4', 90, 'documento_general.pdf', 0, 33, 11, 1, 10, 1, 3, 1, 1, 750000),
(44, 'C5 Aircross', 23000000, 'Nuevo', 'SUV cómodo y tecnológico.', 4, '4', 177, 'documento_general.pdf', 0, 34, 7, 2, 10, 5, 6, 1, 1, 1100000),
(45, '500', 14000000, 'Usado', 'Icónico auto compacto italiano.', 10, '2', 70, 'documento_general.pdf', 0, 35, 13, 1, 3, 6, 3, 1, 1, 700000),
(46, 'Giulia', 26000000, 'Usado', 'Sedán deportivo italiano con diseño sofisticado.', 3, '4', 280, 'documento_general.pdf', 0, 36, 8, 3, 3, 6, 3, 1, 0, 0),
(47, 'XC90', 35000000, 'Usado', 'SUV premium sueco con enfoque en seguridad.', 4, '4', 316, 'documento_general.pdf', 0, 37, 9, 4, 11, 5, 6, 1, 1, 2000000),
(48, 'Defender', 43000000, 'Usado', 'SUV todoterreno británico con lujo y capacidad extrema.', 2, '4', 395, 'documento_general.pdf', 0, 38, 5, 3, 11, 6, 6, 1, 1, 2200000),
(49, 'F-Type', 67000000, 'Usado', 'Deportivo británico de diseño atractivo y alto rendimiento.', 1, '2', 575, 'documento_general.pdf', 0, 39, 4, 7, 11, 6, 7, 6, 0, 0),
(50, 'Ghost', 250000000, 'Nuevo', 'Sedán de lujo supremo.', 1, '4', 563, 'documento_general.pdf', 0, 40, 8, 7, 11, 5, 3, 6, 0, 0),
(51, 'Continental GT', 220000000, 'Usado', 'Coupé británico de lujo.', 1, '2', 626, 'documento_general.pdf', 0, 41, 7, 7, 11, 5, 7, 6, 0, 0),
(52, 'Cooper S', 18000000, 'Usado', 'Hatchback británico compacto y dinámico.', 8, '4', 189, 'documento_general.pdf', 0, 42, 9, 3, 11, 2, 3, 1, 0, 0),
(53, 'R1T', 67000000, 'Usado', 'Camioneta eléctrica todoterreno.', 1, '4', 835, 'documento_general.pdf', 0, 43, 5, 7, 6, 2, 8, 6, 0, 0),
(120, 'Tucson', 23000000, 'Usado', 'SUV versátil con diseño moderno y gran capacidad.', 5, '4', 180, 'documento_general.pdf', 0, 13, 7, 3, 9, 2, 6, 1, 1, 1300000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_favorito`
--

CREATE TABLE `vehiculo_favorito` (
  `id_vehiculo` int(11) NOT NULL,
  `rut` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_favorito`
--

INSERT INTO `vehiculo_favorito` (`id_vehiculo`, `rut`) VALUES
(9, '20.003.205-2'),
(24, '24.012.271-9'),
(46, '24.012.271-9');

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

--
-- Volcado de datos para la tabla `vehiculo_ofertado`
--

INSERT INTO `vehiculo_ofertado` (`patente`, `modelo_oferta`, `marca_oferta`, `pais_oferta`, `imagen_oferta`, `kilometraje`, `anio_oferta`, `nombre_duenio`, `titulo_propiedad`, `correo_duenio`, `telefono_duenio`, `precio_solicitud`, `rut_duenio`, `fecha_solicitud`, `rut_usuario`, `rut_administrador`, `aprobacion`) VALUES
('AAAAAA', 'Ft-Crew', 'Foton', 'Chile', 'imagenes_propiedad/ASAD12_FT-CREW.jpg', 3040, 2020, 'Matías', 'documentos_propiedad/ASAD12_propiedad_FT_CREW.pdf', 'mcarrascoa@ing.ucsc.cl', '123456789', 3900000, '26.050.994-8', '2024-11-30', '26.050.994-3', '11.111.111-1', 0),
('ASAD12', 'Ft-Crew', 'Foton', 'Chile', 'imagenes_propiedad/ASAD12_FT-CREW.jpg', 3040, 2020, 'Matías', 'documentos_propiedad/ASAD12_propiedad_FT_CREW.pdf', 'mcarrascoa@ing.ucsc.cl', '123456789', 3900000, '26.050.994-8', '2024-11-30', '26.050.994-3', '11.111.111-1', 1),
('ASAD13\r\n', 'Ft-Crew', 'Foton', 'Chile', 'imagenes_propiedad/ASAD12_FT-CREW.jpg', 3040, 2020, 'Matías', 'documentos_propiedad/ASAD12_propiedad_FT_CREW.pdf', 'mcarrascoa@ing.ucsc.cl', '123456789', 3900000, '26.050.994-8', '2024-11-30', '26.050.994-3', NULL, NULL),
('ASAD14\r\n', 'Ft-Crew', 'Foton', 'Chile', 'imagenes_propiedad/ASAD12_FT-CREW.jpg', 3040, 2020, 'Matías', 'documentos_propiedad/ASAD12_propiedad_FT_CREW.pdf', 'mcarrascoa@ing.ucsc.cl', '123456789', 3900000, '26.050.994-8', '2024-11-30', '26.050.994-3', '11.111.111-1', 0),
('ASAD15\r\n', 'Ft-Crew', 'Foton', 'Chile', 'imagenes_propiedad/ASAD12_FT-CREW.jpg', 3040, 2020, 'Matías', 'documentos_propiedad/ASAD12_propiedad_FT_CREW.pdf', 'mcarrascoa@ing.ucsc.cl', '123456789', 3900000, '26.050.994-8', '2024-11-30', '26.050.994-3', '11.111.111-1', 1),
('ASAD30', 'Ft-Crew', 'Foton', 'Chile', 'imagenes_propiedad/ASAD12_FT-CREW.jpg', 3040, 2020, 'Matías', 'documentos_propiedad/ASAD12_propiedad_FT_CREW.pdf', 'mcarrascoa@ing.ucsc.cl', '123456789', 3900000, '26.050.994-8', '2024-11-30', '26.050.994-3', '11.111.111-1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_sucursal`
--

CREATE TABLE `vehiculo_sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `unidades_arriendo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_sucursal`
--

INSERT INTO `vehiculo_sucursal` (`id_sucursal`, `id_vehiculo`, `unidades_arriendo`) VALUES
(1, 2, 4),
(1, 3, NULL),
(1, 6, NULL),
(1, 7, NULL),
(1, 8, NULL),
(1, 9, NULL),
(1, 10, NULL),
(1, 11, NULL),
(1, 12, NULL),
(1, 13, NULL),
(1, 14, NULL),
(1, 15, NULL),
(1, 16, 3),
(1, 17, 2),
(1, 18, 3),
(1, 19, NULL),
(1, 20, NULL),
(1, 21, NULL),
(1, 23, NULL),
(1, 24, NULL),
(1, 25, NULL),
(1, 34, NULL),
(1, 40, NULL),
(1, 41, 10),
(1, 42, 5),
(1, 43, 8),
(1, 45, 10),
(1, 46, NULL),
(1, 48, 2),
(1, 50, NULL),
(1, 51, NULL),
(2, 1, NULL),
(2, 3, NULL),
(2, 4, NULL),
(2, 5, NULL),
(2, 6, NULL),
(2, 7, NULL),
(2, 8, NULL),
(2, 9, NULL),
(2, 10, NULL),
(2, 12, NULL),
(2, 13, NULL),
(2, 14, NULL),
(2, 15, NULL),
(2, 16, 3),
(2, 18, 3),
(2, 19, NULL),
(2, 20, NULL),
(2, 21, NULL),
(2, 22, NULL),
(2, 25, NULL),
(2, 31, NULL),
(2, 34, NULL),
(2, 40, NULL),
(2, 41, 10),
(2, 43, 8),
(2, 44, 4),
(2, 45, 10),
(2, 46, NULL),
(2, 47, 4),
(2, 48, 2),
(2, 49, NULL),
(2, 51, NULL),
(2, 52, NULL),
(2, 53, NULL),
(3, 1, NULL),
(3, 3, NULL),
(3, 4, NULL),
(3, 6, NULL),
(3, 8, NULL),
(3, 9, NULL),
(3, 10, NULL),
(3, 18, 3),
(3, 20, NULL),
(3, 22, NULL),
(3, 25, NULL),
(3, 34, NULL),
(3, 40, NULL),
(3, 41, 10),
(3, 42, 5),
(3, 43, 8),
(3, 44, 4),
(3, 47, 4),
(3, 48, 2),
(3, 49, NULL),
(3, 52, NULL),
(3, 53, NULL),
(3, 120, 5),
(4, 2, 4),
(4, 3, NULL),
(4, 4, NULL),
(4, 6, NULL),
(4, 7, NULL),
(4, 9, NULL),
(4, 10, NULL),
(4, 11, NULL),
(4, 12, NULL),
(4, 17, 2),
(4, 22, NULL),
(4, 23, NULL),
(4, 24, NULL),
(4, 31, NULL),
(4, 34, NULL),
(4, 42, 5),
(4, 43, 8),
(4, 44, 4),
(4, 45, 10),
(4, 47, 4),
(4, 48, 2),
(4, 49, NULL),
(4, 50, NULL),
(4, 53, NULL),
(4, 120, 5),
(5, 1, NULL),
(5, 3, NULL),
(5, 5, NULL),
(5, 6, NULL),
(5, 9, NULL),
(5, 10, NULL),
(5, 11, NULL),
(5, 46, NULL),
(5, 48, 2),
(5, 50, NULL),
(5, 120, 5),
(8, 9, NULL),
(9, 9, NULL),
(10, 9, NULL);

-- --------------------------------------------------------

--
-- Estructura para la vista `reservas_por_local`
--
DROP TABLE IF EXISTS `reservas_por_local`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reservas_por_local`  AS SELECT `s`.`nombre_sucursal` AS `nombre_sucursal`, count(`rr`.`id_registro_reserva`) AS `reservas_concretadas` FROM (`registro_reserva` `rr` join `sucursal` `s` on(`rr`.`sucursal_reserva` = `s`.`id_sucursal`)) WHERE `rr`.`compra_concretada` = 1 GROUP BY `s`.`nombre_sucursal` ;

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
-- Indices de la tabla `arriendo_vehiculo`
--
ALTER TABLE `arriendo_vehiculo`
  ADD PRIMARY KEY (`cod_arriendo`),
  ADD KEY `arriendo PK` (`id_vehiculo`,`rut`) USING BTREE,
  ADD KEY `fk_rut_usuario_registrado` (`rut`);

--
-- Indices de la tabla `carrito_accesorio`
--
ALTER TABLE `carrito_accesorio`
  ADD PRIMARY KEY (`id_carrito`,`sku_accesorio`),
  ADD KEY `sku_accesorio` (`sku_accesorio`);

--
-- Indices de la tabla `carrito_usuario`
--
ALTER TABLE `carrito_usuario`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `rut_usuario` (`rut_usuario`);

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
-- Indices de la tabla `palabra_prohibida`
--
ALTER TABLE `palabra_prohibida`
  ADD PRIMARY KEY (`id_palabra_prohibida`);

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
-- Indices de la tabla `promocion_especial`
--
ALTER TABLE `promocion_especial`
  ADD PRIMARY KEY (`id_promocion`);

--
-- Indices de la tabla `promocion_vehiculo`
--
ALTER TABLE `promocion_vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`,`id_promocion`),
  ADD KEY `FK_promo` (`id_promocion`,`id_vehiculo`) USING BTREE;

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `registro_accesorio`
--
ALTER TABLE `registro_accesorio`
  ADD PRIMARY KEY (`codigo_verificador`),
  ADD KEY `fk_id_carrito` (`id_carrito`);

--
-- Indices de la tabla `registro_arriendo`
--
ALTER TABLE `registro_arriendo`
  ADD PRIMARY KEY (`id_registro_arriendo`),
  ADD KEY `cod_arriendo` (`cod_arriendo`);

--
-- Indices de la tabla `registro_reserva`
--
ALTER TABLE `registro_reserva`
  ADD PRIMARY KEY (`id_registro_reserva`),
  ADD KEY `id_reserva_vehiculo` (`num_reserva_vehiculo`);

--
-- Indices de la tabla `reserva_vehiculo`
--
ALTER TABLE `reserva_vehiculo`
  ADD PRIMARY KEY (`num_reserva_vehiculo`) USING BTREE,
  ADD KEY `id_vehiculo` (`id_vehiculo`),
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
-- Indices de la tabla `solicitud_ayuda`
--
ALTER TABLE `solicitud_ayuda`
  ADD PRIMARY KEY (`id_ayuda`),
  ADD KEY `rut` (`rut`);

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
  ADD PRIMARY KEY (`id_contratacion_seguro`),
  ADD KEY `id_seguro` (`id_seguro`),
  ADD KEY `id_tipo_vehiculo` (`id_tipo_vehiculo`),
  ADD KEY `rut` (`rut`);

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
-- Indices de la tabla `vehiculo_favorito`
--
ALTER TABLE `vehiculo_favorito`
  ADD PRIMARY KEY (`id_vehiculo`,`rut`),
  ADD KEY `rut` (`rut`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anio`
--
ALTER TABLE `anio`
  MODIFY `id_anio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `arriendo_vehiculo`
--
ALTER TABLE `arriendo_vehiculo`
  MODIFY `cod_arriendo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carrito_usuario`
--
ALTER TABLE `carrito_usuario`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `cobertura`
--
ALTER TABLE `cobertura`
  MODIFY `id_cobertura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  MODIFY `id_financiamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  MODIFY `id_foto_accesorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `fotos_vehiculo`
--
ALTER TABLE `fotos_vehiculo`
  MODIFY `id_foto_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `palabra_prohibida`
--
ALTER TABLE `palabra_prohibida`
  MODIFY `id_palabra_prohibida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `promocion_especial`
--
ALTER TABLE `promocion_especial`
  MODIFY `id_promocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `registro_accesorio`
--
ALTER TABLE `registro_accesorio`
  MODIFY `codigo_verificador` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456789012365;

--
-- AUTO_INCREMENT de la tabla `registro_arriendo`
--
ALTER TABLE `registro_arriendo`
  MODIFY `id_registro_arriendo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `registro_reserva`
--
ALTER TABLE `registro_reserva`
  MODIFY `id_registro_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `reserva_vehiculo`
--
ALTER TABLE `reserva_vehiculo`
  MODIFY `num_reserva_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `id_seguro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `solicitud_ayuda`
--
ALTER TABLE `solicitud_ayuda`
  MODIFY `id_ayuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id_tipo_rueda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id_tipo_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `transmision`
--
ALTER TABLE `transmision`
  MODIFY `id_transmision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_seguro`
--
ALTER TABLE `usuario_seguro`
  MODIFY `id_contratacion_seguro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

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
-- Filtros para la tabla `arriendo_vehiculo`
--
ALTER TABLE `arriendo_vehiculo`
  ADD CONSTRAINT `arriendo_vehiculo_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`),
  ADD CONSTRAINT `fk_rut_usuario_registrado` FOREIGN KEY (`rut`) REFERENCES `usuario_registrado` (`rut`);

--
-- Filtros para la tabla `carrito_accesorio`
--
ALTER TABLE `carrito_accesorio`
  ADD CONSTRAINT `carrito_accesorio_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito_usuario` (`id_carrito`),
  ADD CONSTRAINT `carrito_accesorio_ibfk_2` FOREIGN KEY (`sku_accesorio`) REFERENCES `accesorio` (`sku_accesorio`);

--
-- Filtros para la tabla `carrito_usuario`
--
ALTER TABLE `carrito_usuario`
  ADD CONSTRAINT `carrito_usuario_ibfk_1` FOREIGN KEY (`rut_usuario`) REFERENCES `usuario` (`rut_usuario`);

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
-- Filtros para la tabla `promocion_vehiculo`
--
ALTER TABLE `promocion_vehiculo`
  ADD CONSTRAINT `promocion_vehiculo_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`),
  ADD CONSTRAINT `promocion_vehiculo_ibfk_2` FOREIGN KEY (`id_promocion`) REFERENCES `promocion_especial` (`id_promocion`);

--
-- Filtros para la tabla `registro_accesorio`
--
ALTER TABLE `registro_accesorio`
  ADD CONSTRAINT `fk_id_carrito` FOREIGN KEY (`id_carrito`) REFERENCES `carrito_usuario` (`id_carrito`);

--
-- Filtros para la tabla `registro_arriendo`
--
ALTER TABLE `registro_arriendo`
  ADD CONSTRAINT `registro_arriendo_ibfk_1` FOREIGN KEY (`cod_arriendo`) REFERENCES `arriendo_vehiculo` (`cod_arriendo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_reserva`
--
ALTER TABLE `registro_reserva`
  ADD CONSTRAINT `registro_reserva_ibfk_1` FOREIGN KEY (`num_reserva_vehiculo`) REFERENCES `reserva_vehiculo` (`num_reserva_vehiculo`);

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
-- Filtros para la tabla `solicitud_ayuda`
--
ALTER TABLE `solicitud_ayuda`
  ADD CONSTRAINT `solicitud_ayuda_ibfk_1` FOREIGN KEY (`rut`) REFERENCES `usuario_registrado` (`rut`);

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
  ADD CONSTRAINT `usuario_seguro_ibfk_3` FOREIGN KEY (`id_tipo_vehiculo`) REFERENCES `tipo_vehiculo` (`id_tipo_vehiculo`),
  ADD CONSTRAINT `usuario_seguro_ibfk_4` FOREIGN KEY (`rut`) REFERENCES `usuario_registrado` (`rut`);

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
-- Filtros para la tabla `vehiculo_favorito`
--
ALTER TABLE `vehiculo_favorito`
  ADD CONSTRAINT `vehiculo_favorito_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculo_favorito_ibfk_2` FOREIGN KEY (`rut`) REFERENCES `usuario_registrado` (`rut`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
