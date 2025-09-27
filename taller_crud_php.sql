-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2025 a las 14:35:43
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
-- Base de datos: `taller_crud_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `nombre`) VALUES
(1, 'Técnico'),
(2, 'Administrador'),
(3, ' Operario'),
(4, ' Asistente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`) VALUES
(1, 'Electricidad'),
(2, 'Mantenimiento'),
(3, 'Recursos Humanos'),
(4, 'Contabilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `num_documento` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `salario` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `num_documento`, `fecha`, `salario`, `estado`, `correo`, `telefono`, `cargo_id`, `departamento_id`, `foto`, `password`) VALUES
(1, 'frank', '1000', '2025-08-08', 10000, 'activo', 'frank@gmail.com', '12345', 2, 2, '', ''),
(2, 'criss', '2000', '2025-09-14', 10000, 'activo', 'criss@gmail.com', '666', 3, 2, '', ''),
(3, 'juan camilo', '132654', '2025-08-08', 5000, 'activo', 'juanxd@gmail.com', '616', 2, 4, '', ''),
(50, 'drank', '50', '2025-09-01', 5000, 'activo', 'drikiki@gmail.com', '123456789', 2, 4, '', '$2y$10$pr17OrCBh5SnickDiGtvjejHRiD53lq4/EwbhQQE68OlkSNSSEBCe'),
(51, 'karen', '600', '2025-09-04', 5000, 'activo', 'karen@gmail.com', '123456', 2, 2, 'ASSETS/FOTOS/emp_20250927_134036000.jpg', '$2y$10$piD3GStuj6ylJ/2ciryMM.5zFm9zyjrKRmyRYMlsyyKEpP2KFqEUa'),
(52, 'paolo', '30', '2025-09-03', 500, 'activo', 'paolo@gmail.com', '123465', 3, 1, 'ASSETS/FOTOS/emp_20250927_134810000.jpg', '$2y$10$P7bBt5Lue5OwoF4MOITD0.PJdf4/grcLE8t6xT5hoc4OfWY7aeuVi'),
(53, 'adrian', '700', '2025-09-03', 4000, 'activo', 'drikiigm@gmail.com', '454554545', 3, 2, 'ASSETS/FOTOS/emp_20250927_143333000.jpg', '$2y$10$tk5sp2oiCVzJzSzNicfN2.hjSiq1tOQPz7ZI8RnHS8fYkkwqI6LVS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_documento_UNIQUE` (`num_documento`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`),
  ADD KEY `fk_empleados_cargo1_idx` (`cargo_id`),
  ADD KEY `fk_empleados_departamento1_idx` (`departamento_id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleados_cargo1` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleados_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
