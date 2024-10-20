-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-10-2024 a las 21:53:18
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
-- Base de datos: `proy_base`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios`
--

CREATE TABLE `accesorios` (
  `sku` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accesorios`
--

INSERT INTO `accesorios` (`sku`, `nombre`, `precio`, `stock`, `descripcion`, `foto`) VALUES
(12345, 'Esponjas', 12000, 15, 'Articulo para mantener el aseo en tu vehiculo', NULL),
(23456, 'Audio Inalambrico', 15000, 150, 'Accesorio Bluetooth para radio de vehiculos', NULL),
(44444, 'Kit Seguridad ', 500000, 90, 'Incluye Extintor, LLaves,Triangulo Seguridad', NULL),
(1111111, 'Cojin Reposa Cabeza', 50000, 700, 'Comodo Cojin para evitar dolores de cuello', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorio_tipo`
--

CREATE TABLE `accesorio_tipo` (
  `id_accesorio_tipo` int(11) NOT NULL,
  `sku_accesorio` int(11) DEFAULT NULL,
  `id_tipo_accesorio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accesorio_tipo`
--

INSERT INTO `accesorio_tipo` (`id_accesorio_tipo`, `sku_accesorio`, `id_tipo_accesorio`) VALUES
(9, 12345, 8),
(10, 23456, 6),
(11, 23456, 7),
(12, 44444, 4),
(13, 1111111, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anios`
--

CREATE TABLE `anios` (
  `id_anio` int(11) NOT NULL,
  `anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anios`
--

INSERT INTO `anios` (`id_anio`, `anio`) VALUES
(4, 2019),
(5, 2020),
(6, 2021),
(7, 2022),
(8, 2023),
(9, 2024),
(10, 2025);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id_color` int(11) NOT NULL,
  `nombre_color` varchar(100) NOT NULL,
  `codigo_color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id_color`, `nombre_color`, `codigo_color`) VALUES
(4, 'Rojo', '#FF0000'),
(5, 'Azul', '#0000FF'),
(6, 'Negro', '#000000'),
(7, 'Blanco', '#FFFFFF'),
(8, 'Gris', '#808080'),
(9, 'Verde', '#008000'),
(10, 'Amarillo', '#FFFF00'),
(11, 'Naranja', '#FFA500'),
(12, 'Marrón', '#8B4513'),
(13, 'Plata', '#C0C0C0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `financiamiento`
--

CREATE TABLE `financiamiento` (
  `id_financiamiento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tasa_interes` float NOT NULL,
  `plazo_maximo` varchar(50) NOT NULL,
  `requisitos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `financiamiento`
--

INSERT INTO `financiamiento` (`id_financiamiento`, `nombre`, `tasa_interes`, `plazo_maximo`, `requisitos`) VALUES
(3, 'Financiamiento directo', 3.5, '24 meses', 'Requiere verificación de ingresos y aprobación de crédito'),
(4, 'Leasing vehicular', 4.2, '36 meses', 'Requiere contrato de trabajo y antigüedad mínima de 1 año'),
(5, 'Crédito bancario', 5, '48 meses', 'Requiere buen historial crediticio y garantía de avalúo'),
(6, 'Crédito de concesionaria', 4.8, '60 meses', 'Sólo aplica para autos nuevos con garantía'),
(7, 'Financiamiento sin intereses', 0, '12 meses', 'Aplicable solo a pagos en cuotas con tarjeta de crédito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_accesorio`
--

CREATE TABLE `fotos_accesorio` (
  `id_foto` int(11) NOT NULL,
  `sku_accesorio` int(11) DEFAULT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos_accesorio`
--

INSERT INTO `fotos_accesorio` (`id_foto`, `sku_accesorio`, `foto`) VALUES
(4, 12345, 'fotos/full_image-1.webp'),
(5, 23456, 'fotos/41Nc7Ixem7S._SL500_.jpg'),
(6, 44444, 'fotos/Kit-de-Seguridad-para-Auto-y-Camioneta-300x300.webp'),
(7, 1111111, 'fotos/3ba3e564-63b1-4253-a6b2-3ab015fb9e47.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_vehiculos`
--

CREATE TABLE `fotos_vehiculos` (
  `id_foto` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `ruta_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos_vehiculos`
--

INSERT INTO `fotos_vehiculos` (`id_foto`, `id_vehiculo`, `ruta_foto`) VALUES
(10, 3, 'fotos_vehiculos/descarga (1).jpeg'),
(11, 3, 'fotos_vehiculos/descarga (2).jpeg'),
(12, 3, 'fotos_vehiculos/descarga (3).jpeg'),
(13, 3, 'fotos_vehiculos/descarga.jpeg'),
(14, 4, 'fotos_vehiculos/descarga.jpeg'),
(15, 4, 'fotos_vehiculos/ford-fiesta-2022-p.jpg'),
(16, 4, 'fotos_vehiculos/ford-fiesta-2022-rutamotor-02-1024x682.webp'),
(17, 4, 'fotos_vehiculos/ford-fiesta-2022-zaga-1.jpg'),
(18, 4, 'fotos_vehiculos/ford-fiesta-st.jpg'),
(19, 5, 'fotos_vehiculos/RT_V_0d008ceaa2eb419883ad5c2f1eea7838.jpg'),
(20, 5, 'fotos_vehiculos/RT_V_88e0f670ce6746d1ba0c16a1d77e0628.jpg'),
(21, 6, 'fotos_vehiculos/honda-civic-e-hev-1481115.jpg'),
(22, 6, 'fotos_vehiculos/NAZ_1d6e245013354690874907af24fbca7c.webp'),
(23, 6, 'fotos_vehiculos/nuevo-honda-civic-2022-2694147.webp'),
(24, 7, 'fotos_vehiculos/_20240529025920372_4fa1ac29_b28b_4574_af2c_cef6e16a3927.jpg'),
(25, 7, 'fotos_vehiculos/NUEVO VERSA PORTADA3.jpg'),
(26, 7, 'fotos_vehiculos/versa3.png'),
(27, 8, 'fotos_vehiculos/0_Hyundai_Avante_(CN7)_FL_2.jpg'),
(28, 8, 'fotos_vehiculos/01011167893-1-9-3.jpg'),
(29, 8, 'fotos_vehiculos/Hyundai-Avante-Elantra-facelift-1.webp'),
(30, 9, 'fotos_vehiculos/NAZ_a9d6488536804eebb9734f1121713be3.webp'),
(31, 9, 'fotos_vehiculos/Volkswagen_Golf_VIII_R_1X7A7089.jpg'),
(32, 10, 'fotos_vehiculos/1366_2000.jpeg'),
(33, 10, 'fotos_vehiculos/bmw-3-series-sedan-lci-modelfinder.png'),
(34, 10, 'fotos_vehiculos/BMW-330i-2024-13.jpeg'),
(35, 11, 'fotos_vehiculos/Mercedes_C300D_0000.jpg'),
(36, 11, 'fotos_vehiculos/Mercedes-Benz_W206_IMG_6380.jpg'),
(37, 12, 'fotos_vehiculos/RLD_default_pass_scaled.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre_marca`, `descripcion`, `logo`) VALUES
(4, 'Toyota', 'Fabricante japonés de automóviles conocido por su fiabilidad.', 'png-clipart-toyota-prius-car-toyota-camry-logo-toyota-emblem-text-thumbnail.png'),
(5, 'Ford', 'Marca estadounidense famosa por sus vehículos de pasajeros y camiones.', 'png-transparent-ford-motor-company-car-ford-mustang-ford-focus-company-logo-blue-text-logo.png'),
(6, 'Chevrolet', 'Marca de automóviles estadounidense con una amplia gama de modelos.', 'Chevrolet-logo.png'),
(7, 'Honda', 'Fabricante japonés de automóviles, motos y equipos de energía.', 'honda-logo-brand-symbol-with-name-black-design-japan-car-automobile-illustration-free-vector.jpg'),
(8, 'Nissan', 'Compañía automovilística japonesa que produce una variedad de vehículos.', 'nissan-logo-editorial-ilustrativo-sobre-fondo-blanco-icono-vectorial-logotipos-conjunto-de-iconos-redes-sociales-banner-plano-208329606.webp'),
(9, 'Hyundai', 'Fabricante surcoreano de automóviles con una creciente presencia global.', 'png-transparent-hyundai-motor-company-logo-hyundai-sonata-hyundai-i10-hyundai-blue-text-trademark-thumbnail.png'),
(10, 'Volkswagen', 'Marca alemana reconocida por su ingeniería y tecnología avanzada.', 'logotipo-volkswagen-historia_21.webp'),
(11, 'BMW', 'Fabricante alemán de automóviles de lujo y motocicletas.', 'BMW.svg.png'),
(12, 'Mercedes-Benz', 'Marca alemana de automóviles de lujo conocida por su innovación.', '07-mercedes-logo-2009-2011-hasta-hoy-1200x670.webp'),
(13, 'Subaru', 'Fabricante japonés de automóviles, famoso por sus vehículos AWD.', 'Subaru-Logo-with-White-Background_o.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL,
  `nombre_pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id_pais`, `nombre_pais`) VALUES
(4, 'Japón'),
(5, 'Alemania'),
(6, 'Estados Unidos'),
(7, 'Corea del Sur'),
(8, 'Francia'),
(9, 'Italia'),
(10, 'Suecia'),
(11, 'Reino Unido'),
(12, 'China'),
(13, 'España');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`) VALUES
(5, 'Ver contenido'),
(6, 'Editar contenido'),
(7, 'Eliminar contenido'),
(8, 'Crear contenido'),
(9, 'Administrar usuarios'),
(10, 'Ver reportes'),
(11, 'Exportar datos'),
(12, 'Acceso API'),
(13, 'Configurar sistema'),
(14, 'Gestión de pagos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores_seguro`
--

CREATE TABLE `proveedores_seguro` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores_seguro`
--

INSERT INTO `proveedores_seguro` (`id_proveedor`, `nombre_proveedor`) VALUES
(6, 'Banco Nacional'),
(7, 'Banco de Chile'),
(8, 'Banco Santander'),
(9, 'Banco BCI'),
(10, 'Banco Itaú');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(3, 'Administrador'),
(4, 'Editor'),
(5, 'Usuario'),
(6, 'Invitado'),
(7, 'Soporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`id_rol`, `id_permiso`) VALUES
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(4, 5),
(4, 6),
(4, 8),
(4, 10),
(5, 5),
(5, 8),
(6, 5),
(7, 5),
(7, 10),
(7, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguros`
--

CREATE TABLE `seguros` (
  `id_seguro` int(11) NOT NULL,
  `nombre_seguro` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_tipo_cobertura` int(11) DEFAULT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguros`
--

INSERT INTO `seguros` (`id_seguro`, `nombre_seguro`, `descripcion`, `id_proveedor`, `id_tipo_cobertura`, `precio`) VALUES
(4, 'Seguro Auto Básico', 'Cobertura básica contra accidentes y daños a terceros', 6, 5, 150000),
(5, 'Seguro Auto Completo', 'Cobertura completa contra accidentes, robos y desastres naturales', 6, 6, 300000),
(6, 'Seguro Auto Responsabilidad Civil', 'Protección contra daños a terceros en accidentes de auto', 7, 7, 180000),
(7, 'Seguro Auto a Terceros', 'Cobertura de daños a terceros y sus vehículos', 7, 8, 160000),
(8, 'Seguro Auto Protección Total', 'Cobertura contra robo, incendio y daños a vehículos', 8, 9, 350000),
(9, 'Seguro Auto Contra Desastres Naturales', 'Cobertura en caso de desastres naturales que afecten el vehículo', 8, 10, 320000),
(10, 'Seguro Auto de Flotas', 'Seguro para empresas con múltiples vehículos', 9, 5, 400000),
(11, 'Seguro Auto Clásico', 'Cobertura específica para vehículos clásicos', 9, 6, 250000),
(12, 'Seguro Auto para Jóvenes', 'Cobertura adaptada para conductores jóvenes', 10, 7, 200000),
(13, 'Seguro Auto Premium', 'Cobertura integral con beneficios exclusivos', 10, 8, 500000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`, `descripcion`, `precio_servicio`) VALUES
(3, 'Cambio de Aceite', 'Reemplazo del aceite del motor y del filtro de aceite.', 50000),
(4, 'Revisión de Frenos', 'Inspección y ajuste de frenos, incluyendo cambio de pastillas.', 30000),
(5, 'Alineación y Balanceo', 'Ajuste de la alineación y balanceo de las ruedas.', 25000),
(6, 'Cambio de Neumáticos', 'Sustitución de neumáticos desgastados por nuevos.', 80000),
(7, 'Revisión de Suspensión', 'Inspección del sistema de suspensión y amortiguadores.', 20000),
(8, 'Cambio de Batería', 'Reemplazo de batería por una nueva y prueba del sistema eléctrico.', 70000),
(9, 'Lavado y Detailing', 'Lavado exterior e interior completo del vehículo.', 40000),
(10, 'Cambio de Filtros de Aire', 'Sustitución de filtros de aire del motor y de la cabina.', 15000),
(11, 'Servicio de Climatización', 'Revisión y carga de aire acondicionado.', 35000),
(12, 'Revisión General', 'Inspección general del vehículo y diagnóstico de problemas.', 60000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_sucursal`
--

CREATE TABLE `servicio_sucursal` (
  `id_servicio` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_sucursal`
--

INSERT INTO `servicio_sucursal` (`id_servicio`, `id_sucursal`) VALUES
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(5, 4),
(5, 5),
(5, 6),
(6, 4),
(6, 5),
(6, 6),
(7, 4),
(7, 5),
(8, 4),
(8, 5),
(9, 4),
(9, 5),
(10, 4),
(10, 5),
(11, 4),
(11, 5),
(11, 6),
(12, 4),
(12, 5),
(12, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id_sucursal` int(11) NOT NULL,
  `nombre_sucursal` varchar(100) NOT NULL,
  `encargado_sucursal` varchar(100) NOT NULL,
  `direccion_sucursal` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id_sucursal`, `nombre_sucursal`, `encargado_sucursal`, `direccion_sucursal`) VALUES
(4, 'Sucursal Santiago Centro', 'Juan Pérez', 'Avenida Libertador Bernardo O’Higgins 1234, Santiago'),
(5, 'Sucursal Valparaíso', 'María González', 'Plaza Victoria 567, Valparaíso'),
(6, 'Sucursal Concepción', 'Carlos Fernández', 'Calle San Martín 890, Concepción'),
(7, 'Sucursal La Serena', 'Ana Torres', 'Avenida del Mar 456, La Serena'),
(8, 'Sucursal Antofagasta', 'Luis Morales', 'Avenida Chile 123, Antofagasta'),
(9, 'Sucursal Temuco', 'Fernanda Silva', 'Calle Manuel Montt 234, Temuco'),
(10, 'Sucursal Iquique', 'Andrés Ríos', 'Calle Baquedano 345, Iquique'),
(11, 'Sucursal Punta Arenas', 'Valeria Castro', 'Avenida Colón 678, Punta Arenas'),
(12, 'Sucursal Rancagua', 'Felipe Díaz', 'Calle José Pedro Alessandri 789, Rancagua'),
(13, 'Sucursal Osorno', 'Natalia Muñoz', 'Avenida Mackenna 321, Osorno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_accesorios`
--

CREATE TABLE `tipos_accesorios` (
  `id_tipo_accesorio` int(11) NOT NULL,
  `nombre_tipo_accesorio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_accesorios`
--

INSERT INTO `tipos_accesorios` (`id_tipo_accesorio`, `nombre_tipo_accesorio`) VALUES
(4, 'Accesorios de Seguridad'),
(5, 'Accesorios de Estilo'),
(6, 'Accesorios de Confort'),
(7, 'Accesorios de Tecnología'),
(8, 'Accesorios de Mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_pago`
--

CREATE TABLE `tipos_pago` (
  `id_tipo_pago` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_pago`
--

INSERT INTO `tipos_pago` (`id_tipo_pago`, `nombre`) VALUES
(6, 'Pago en efectivo'),
(7, 'Tarjeta de crédito'),
(8, 'Tarjeta de débito'),
(9, 'Transferencia bancaria'),
(10, 'Criptomoneda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cobertura`
--

CREATE TABLE `tipo_cobertura` (
  `id_tipo_cobertura` int(11) NOT NULL,
  `nombre_tipo_cobertura` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_cobertura`
--

INSERT INTO `tipo_cobertura` (`id_tipo_cobertura`, `nombre_tipo_cobertura`) VALUES
(5, 'Cobertura Básica'),
(6, 'Cobertura Completa'),
(7, 'Responsabilidad Civil'),
(8, 'Cobertura a Terceros'),
(9, 'Protección Total'),
(10, 'Cobertura de Robo'),
(11, 'Cobertura por Incendio'),
(12, 'Cobertura para Desastres Naturales'),
(13, 'Seguro para Flotas'),
(14, 'Cobertura para Vehículos Clásicos');

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
(4, 'Gasolina'),
(5, 'Diésel'),
(6, 'Eléctrico'),
(7, 'Híbrido'),
(8, 'Gas Natural'),
(9, 'Etanol'),
(10, 'Biofuel'),
(11, 'Gasoil'),
(12, 'Hidrógeno'),
(13, 'Gas Licuado de Petróleo (GLP)');

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
(4, 'Sedán'),
(5, 'SUV'),
(6, 'Camioneta'),
(7, 'Hatchback'),
(8, 'Coupé'),
(9, 'Convertible'),
(10, 'Familiar'),
(11, 'Minivan'),
(12, 'Pick-up'),
(13, 'Deportivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transmisiones`
--

CREATE TABLE `transmisiones` (
  `id_transmision` int(11) NOT NULL,
  `nombre_transmision` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transmisiones`
--

INSERT INTO `transmisiones` (`id_transmision`, `nombre_transmision`) VALUES
(4, 'Manual'),
(5, 'Automática'),
(6, 'Semiautomática'),
(7, 'CVT (Transmisión Variable Continua)'),
(8, 'Doble embrague'),
(9, 'Automática de 5 velocidades'),
(10, 'Automática de 6 velocidades'),
(11, 'Automática de 7 velocidades'),
(12, 'Manual de 5 velocidades'),
(13, 'Manual de 6 velocidades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `nombre_modelo` varchar(100) NOT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_anio` int(11) DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) DEFAULT NULL,
  `id_transmision` int(11) DEFAULT NULL,
  `id_tipo_combustible` int(11) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `nombre_modelo`, `id_marca`, `id_anio`, `precio`, `id_tipo_vehiculo`, `id_transmision`, `id_tipo_combustible`, `estado`, `id_pais`) VALUES
(3, 'Toyota Corolla', 4, 4, 20000000, 4, 4, 4, 'nuevo', 4),
(4, 'Ford Fiesta', 5, 5, 15000000, 5, 5, 5, 'nuevo', 5),
(5, 'Chevrolet Onix', 6, 6, 18000, 4, 4, 4, 'nuevo', 6),
(6, 'Honda Civic', 7, 7, 22000, 4, 6, 4, 'nuevo', 7),
(7, 'Nissan Versa', 8, 8, 19000, 7, 7, 5, 'usado', 4),
(8, 'Hyundai Elantra', 9, 9, 21000, 4, 4, 6, 'nuevo', 9),
(9, 'Volkswagen Golf', 10, 10, 23000, 4, 5, 4, 'nuevo', 10),
(10, 'BMW Serie 3', 11, 10, 35000, 8, 6, 4, 'nuevo', 11),
(11, 'Mercedes-Benz C-Class', 12, 9, 40000, 5, 7, 4, 'nuevo', 12),
(12, 'Subaru Impreza', 13, 8, 24000, 5, 5, 5, 'nuevo', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_colores`
--

CREATE TABLE `vehiculo_colores` (
  `id_vehiculo` int(11) NOT NULL,
  `id_color` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_colores`
--

INSERT INTO `vehiculo_colores` (`id_vehiculo`, `id_color`) VALUES
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 10),
(4, 4),
(4, 5),
(4, 7),
(4, 9),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(5, 12),
(5, 13),
(6, 5),
(6, 6),
(6, 7),
(7, 5),
(7, 6),
(7, 7),
(7, 12),
(7, 13),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 13),
(9, 7),
(9, 8),
(9, 9),
(9, 11),
(9, 12),
(10, 4),
(10, 6),
(10, 9),
(10, 10),
(11, 4),
(11, 5),
(11, 6),
(11, 13),
(12, 8),
(12, 9),
(12, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  ADD PRIMARY KEY (`sku`);

--
-- Indices de la tabla `accesorio_tipo`
--
ALTER TABLE `accesorio_tipo`
  ADD PRIMARY KEY (`id_accesorio_tipo`),
  ADD KEY `sku_accesorio` (`sku_accesorio`),
  ADD KEY `id_tipo_accesorio` (`id_tipo_accesorio`);

--
-- Indices de la tabla `anios`
--
ALTER TABLE `anios`
  ADD PRIMARY KEY (`id_anio`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  ADD PRIMARY KEY (`id_financiamiento`);

--
-- Indices de la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `sku_accesorio` (`sku_accesorio`);

--
-- Indices de la tabla `fotos_vehiculos`
--
ALTER TABLE `fotos_vehiculos`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `proveedores_seguro`
--
ALTER TABLE `proveedores_seguro`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD PRIMARY KEY (`id_rol`,`id_permiso`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `seguros`
--
ALTER TABLE `seguros`
  ADD PRIMARY KEY (`id_seguro`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_tipo_cobertura` (`id_tipo_cobertura`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `servicio_sucursal`
--
ALTER TABLE `servicio_sucursal`
  ADD PRIMARY KEY (`id_servicio`,`id_sucursal`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `tipos_accesorios`
--
ALTER TABLE `tipos_accesorios`
  ADD PRIMARY KEY (`id_tipo_accesorio`);

--
-- Indices de la tabla `tipos_pago`
--
ALTER TABLE `tipos_pago`
  ADD PRIMARY KEY (`id_tipo_pago`);

--
-- Indices de la tabla `tipo_cobertura`
--
ALTER TABLE `tipo_cobertura`
  ADD PRIMARY KEY (`id_tipo_cobertura`);

--
-- Indices de la tabla `tipo_combustible`
--
ALTER TABLE `tipo_combustible`
  ADD PRIMARY KEY (`id_tipo_combustible`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id_tipo_vehiculo`);

--
-- Indices de la tabla `transmisiones`
--
ALTER TABLE `transmisiones`
  ADD PRIMARY KEY (`id_transmision`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `id_anio` (`id_anio`),
  ADD KEY `id_tipo_vehiculo` (`id_tipo_vehiculo`),
  ADD KEY `id_transmision` (`id_transmision`),
  ADD KEY `id_tipo_combustible` (`id_tipo_combustible`),
  ADD KEY `id_pais` (`id_pais`);

--
-- Indices de la tabla `vehiculo_colores`
--
ALTER TABLE `vehiculo_colores`
  ADD PRIMARY KEY (`id_vehiculo`,`id_color`),
  ADD KEY `id_color` (`id_color`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorio_tipo`
--
ALTER TABLE `accesorio_tipo`
  MODIFY `id_accesorio_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `anios`
--
ALTER TABLE `anios`
  MODIFY `id_anio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  MODIFY `id_financiamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotos_vehiculos`
--
ALTER TABLE `fotos_vehiculos`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `proveedores_seguro`
--
ALTER TABLE `proveedores_seguro`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `seguros`
--
ALTER TABLE `seguros`
  MODIFY `id_seguro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipos_accesorios`
--
ALTER TABLE `tipos_accesorios`
  MODIFY `id_tipo_accesorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipos_pago`
--
ALTER TABLE `tipos_pago`
  MODIFY `id_tipo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_cobertura`
--
ALTER TABLE `tipo_cobertura`
  MODIFY `id_tipo_cobertura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipo_combustible`
--
ALTER TABLE `tipo_combustible`
  MODIFY `id_tipo_combustible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id_tipo_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `transmisiones`
--
ALTER TABLE `transmisiones`
  MODIFY `id_transmision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesorio_tipo`
--
ALTER TABLE `accesorio_tipo`
  ADD CONSTRAINT `accesorio_tipo_ibfk_1` FOREIGN KEY (`sku_accesorio`) REFERENCES `accesorios` (`sku`),
  ADD CONSTRAINT `accesorio_tipo_ibfk_2` FOREIGN KEY (`id_tipo_accesorio`) REFERENCES `tipos_accesorios` (`id_tipo_accesorio`);

--
-- Filtros para la tabla `fotos_accesorio`
--
ALTER TABLE `fotos_accesorio`
  ADD CONSTRAINT `fotos_accesorio_ibfk_1` FOREIGN KEY (`sku_accesorio`) REFERENCES `accesorios` (`sku`) ON DELETE CASCADE;

--
-- Filtros para la tabla `fotos_vehiculos`
--
ALTER TABLE `fotos_vehiculos`
  ADD CONSTRAINT `fotos_vehiculos_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `roles_permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `roles_permisos_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`);

--
-- Filtros para la tabla `seguros`
--
ALTER TABLE `seguros`
  ADD CONSTRAINT `seguros_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores_seguro` (`id_proveedor`),
  ADD CONSTRAINT `seguros_ibfk_2` FOREIGN KEY (`id_tipo_cobertura`) REFERENCES `tipo_cobertura` (`id_tipo_cobertura`);

--
-- Filtros para la tabla `servicio_sucursal`
--
ALTER TABLE `servicio_sucursal`
  ADD CONSTRAINT `servicio_sucursal_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `servicio_sucursal_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  ADD CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`id_anio`) REFERENCES `anios` (`id_anio`),
  ADD CONSTRAINT `vehiculos_ibfk_3` FOREIGN KEY (`id_tipo_vehiculo`) REFERENCES `tipo_vehiculo` (`id_tipo_vehiculo`),
  ADD CONSTRAINT `vehiculos_ibfk_4` FOREIGN KEY (`id_transmision`) REFERENCES `transmisiones` (`id_transmision`),
  ADD CONSTRAINT `vehiculos_ibfk_5` FOREIGN KEY (`id_tipo_combustible`) REFERENCES `tipo_combustible` (`id_tipo_combustible`),
  ADD CONSTRAINT `vehiculos_ibfk_6` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`);

--
-- Filtros para la tabla `vehiculo_colores`
--
ALTER TABLE `vehiculo_colores`
  ADD CONSTRAINT `vehiculo_colores_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`),
  ADD CONSTRAINT `vehiculo_colores_ibfk_2` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id_color`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
