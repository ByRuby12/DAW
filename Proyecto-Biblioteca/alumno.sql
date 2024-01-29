-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-11-2023 a las 09:54:58
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
-- Base de datos: `alumno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int(11) NOT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `editorial` varchar(100) DEFAULT NULL,
  `disponible` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id`, `isbn`, `titulo`, `autor`, `editorial`, `disponible`) VALUES
(1, '1234567891239', 'MondongoExas', 'MondongoEx', 'MondongoEx', 1),
(2, '9789012345670', 'The Art of Mindfulness', 'Chris MindfulMaster', 'Zen Publications', 1),
(3, '9788901234569', 'Mind-Bending Puzzles', 'Bella PuzzleMaster', 'Enigma Games', 1),
(4, '9781234567890', 'Ejemplo4', 'Autor3', 'Editorial XYZ', 1),
(5, '9781234567890', 'Ejemplo5', 'Autor1', 'Editorial XYZ', 1),
(6, '9781234567890', 'Ejemplo6', 'Autor2', 'Editorial XYZ', 0),
(7, '9781234567891', 'The Art of Programming', 'Alice Programmer', 'Tech Publications', 0),
(8, '9782345678902', 'The Science of Data', 'Bob Data Scientist', 'Data Insights Press', 1),
(9, '9783456789013', 'Journey to the Cosmos', 'Carl Astronomer', 'Stellar Books', 1),
(10, '9784567890124', 'Mysteries of the Deep', 'Diana Explorer', 'Oceanic Press', 1),
(11, '9785678901235', 'The Secret Garden', 'Eva Nature Lover', 'Green Thumb Publishing', 0),
(12, '9786789012346', 'Coding for Beginners', 'Frank CodeMaster', 'CodeCrafters Inc.', 1),
(13, '9787890123457', 'The Art of Cooking', 'Grace Chef', 'Gourmet Publishers', 1),
(14, '9788901234568', 'The History Chronicles', 'Henry Historian', 'Ancient Books Co.', 0),
(15, '9789012345679', 'Poetry of the Soul', 'Isaac Poet', 'Verse Creations', 1),
(16, '9780123456789', 'Mastering Chess', 'Jack ChessMaster', 'Strategic Games', 1),
(17, '9781234567890', 'The Mindful Athlete', 'Kate SportsMind', 'Peak Performance Press', 0),
(18, '9782345678901', 'The Quantum Realm', 'Leo Physicist', 'Quantum Books', 0),
(19, '9783456789012', 'Epic Fantasy Adventures', 'Mia FantasyWriter', 'Dreamscape Publications', 1),
(20, '9784567890123', 'Digital Artistry', 'Nathan DigitalArtist', 'Pixel Press', 0),
(21, '9785678901234', 'Exploring the Rainforest', 'Olivia Biologist', 'Rainforest Publications', 1),
(22, '9786789012345', 'Financial Freedom Guide', 'Paul FinanceGuru', 'Wealth Builders', 1),
(23, '9787890123456', 'The Art of Meditation', 'Quinn ZenMaster', 'Inner Peace Press', 1),
(24, '9788901234567', 'Innovation in Technology', 'Ryan Innovator', 'Tech Innovations', 1),
(25, '9789012345678', 'The Power of Positivity', 'Sara Optimist', 'Positive Living Books', 1),
(26, '9780123456780', 'Space Odyssey', 'Tom SpaceExplorer', 'Cosmic Ventures', 1),
(27, '9781234567892', 'Modern Architecture Wonders', 'Uma Architect', 'Architectural Press', 1),
(28, '9782345678903', 'Health and Wellness Guide', 'Victor WellnessExpert', 'Healthy Living Publications', 1),
(29, '9783456789014', 'World History Unveiled', 'Wendy HistoryBuff', 'Worldview Books', 1),
(30, '9784567890125', 'The Art of Communication', 'Xavier Communicator', 'Connection Press', 1),
(31, '9785678901236', 'Discovering Ancient Civilizations', 'Yara Archaeologist', 'Ancient History Publications', 1),
(32, '9786789012347', 'Sustainable Living Handbook', 'Zane EcoActivist', 'Green Earth Press', 1),
(33, '9787890123458', 'The Music Maestro', 'Aaron Musician', 'Harmony Publishing', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libroseliminados`
--

CREATE TABLE `libroseliminados` (
  `id` int(11) NOT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `editorial` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `fin_prestamo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rol` enum('alumno','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido1`, `apellido2`, `correo`, `usuario`, `contrasena`, `fecha_registro`, `rol`) VALUES
(1, 'Admin', 'Admin', 'Admin', 'admin@gmail.com', 'Admin', '$2y$10$HMFH4XzYEkzoUQEDtml0d.lDrKtd68z19NqfmqpDqsILTBV8Fj2Te', '2023-11-20 08:52:50', 'admin'),
(2, 'User', 'User', 'User', 'User@gmail.com', 'User', '$2y$10$V4qnuJV21AIjzKYvRmjQmu4VDsaFiJPDcK596uWwdruGmZ7rw9Sqy', '2023-11-20 08:53:32', 'alumno'),
(3, 'Scarlett', 'Hall', 'Wilson', 'scarlett.hall@example.com', 'scarletth', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-13 08:11:29', 'alumno'),
(4, 'Tomas', 'Cano', 'Nieto', 'tomas@gmail.com', 'tomas123', '$2y$10$ZXX4PzYVZYEvziNXIiNES.dCNYhih2wok/rcnh5aoAPbXzcmbi6Qq', '2023-11-20 08:06:01', 'admin'),
(5, 'Henry', 'Evans', 'Lee', 'henry.evans@example.com', 'henrye', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-13 08:11:35', 'alumno'),
(6, 'qweqwe', 'qweqwe', 'qweqwe', 'qweqwe@gmail.com', 'qweqwe', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-13 08:12:16', 'alumno'),
(7, 'John', 'Doe', 'Smith', 'john.doe1@example.com', 'johndoe1', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:15', 'alumno'),
(8, 'Jane', 'Doe', 'Johnson', 'jane.doe2@example.com', 'janedoe2', NULL, '2023-11-13 09:04:09', 'alumno'),
(9, 'Michael', 'Johnson', 'Brown', 'michael.johnson@example.com', 'michaelj', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:22', 'alumno'),
(10, 'Emily', 'Williams', 'Davis', 'emily.williams@example.com', 'emilyw', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:25', 'alumno'),
(11, 'Daniel', 'Smith', 'Taylor', 'daniel.smith@example.com', 'daniels', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:27', 'alumno'),
(12, 'Olivia', 'Johnson', 'Miller', 'olivia.johnson@example.com', 'oliviaj', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:31', 'alumno'),
(13, 'William', 'Anderson', 'White', 'william.anderson@example.com', 'williama', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:37', 'alumno'),
(14, 'Sophia', 'Martinez', 'Harris', 'sophia.martinez@example.com', 'sophiam', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:40', 'alumno'),
(15, 'James', 'Davis', 'Thomas', 'james.davis@example.com', 'jamesd', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:45', 'alumno'),
(16, 'Emma', 'Jackson', 'Moore', 'emma.jackson@example.com', 'emmaj', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:48', 'alumno'),
(17, 'Alexander', 'Brown', 'Garcia', 'alexander.brown@example.com', 'alexanderb', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:51', 'alumno'),
(18, 'Ava', 'Harris', 'Williams', 'ava.harris@example.com', 'avah', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:54', 'alumno'),
(19, 'Benjamin', 'Lee', 'Evans', 'benjamin.lee@example.com', 'benjaminl', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:51:57', 'alumno'),
(20, 'Mia', 'Garcia', 'Hall', 'mia.garcia@example.com', 'miag', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:00', 'alumno'),
(21, 'Elijah', 'Taylor', 'Clark', 'elijah.taylor@example.com', 'elijaht', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:04', 'alumno'),
(22, 'Amelia', 'Anderson', 'Brown', 'amelia.anderson@example.com', 'ameliaa', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:08', 'alumno'),
(23, 'Liam', 'Williams', 'Wilson', 'liam.williams@example.com', 'liamw', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:10', 'alumno'),
(24, 'Ella', 'Thomas', 'Martinez', 'ella.thomas@example.com', 'ellat', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:12', 'alumno'),
(25, 'Lucas', 'Miller', 'Gonzalez', 'lucas.miller@example.com', 'lucasm', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:14', 'alumno'),
(30, 'Luna', 'Hernandez', 'Smith', 'luna.hernandez@example.com', 'lunah', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:37', 'alumno'),
(31, 'Carter', 'Gonzalez', 'Moore', 'carter.gonzalez@example.com', 'carterg', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:42', 'alumno'),
(32, 'Chloe', 'Wilson', 'Anderson', 'chloe.wilson@example.com', 'chloew', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:44', 'alumno'),
(33, 'Grayson', 'Davis', 'Hernandez', 'grayson.davis@example.com', 'graysond', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:48', 'alumno'),
(34, 'Penelope', 'Smith', 'Johnson', 'penelope.smith@example.com', 'penelopes', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:52', 'alumno'),
(35, 'Logan', 'Hall', 'Williams', 'logan.hall@example.com', 'loganh', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:57', 'alumno'),
(36, 'Sofia', 'Brown', 'Garcia', 'sofia.brown@example.com', 'sofiab', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-10 10:52:59', 'alumno'),
(37, 'alooo', 'presidentess', 'alooo', 'presidentes@gmail.com', 'illojuan', '$2y$10$XmI3dqtai0Eo2ccG1MjpleSbdf.V1bmIfUP.VC5CKdFyaGeKbF9YW', '2023-11-14 11:25:36', 'alumno'),
(38, 'ErPepe', 'Yoquese', 'loquete', 'mandarin@gmail.com', 'errdiablo', '$2y$10$liiaX6lBh.uJdFVS9N7UZetuwEILgXDyYCQCYyq/DztarIQIMxdA6', '2023-11-13 08:52:11', 'alumno'),
(44, 'fresty', 'fresty', 'fresty', 'fresty@gmail.com', 'fresty', '$2y$10$Yzmi7Q1Kv4oRFa.ytG7vGuXTWZ/ZFGRWkwDD/gEhgxITNEJ6RBuk6', '2023-11-14 11:53:53', 'alumno'),
(46, 'cdfgr', 'cdfgr', 'cdfgr', 'cdfgr@gmail.com', 'cdfgr', '$2y$10$DNV6EDeLw3RCFiymQfOMK.KhlbW4PZxOESeIZBViYaogGB.jeeDGu', '2023-11-14 11:57:07', 'alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioseliminados`
--

CREATE TABLE `usuarioseliminados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rol` enum('alumno','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_usuario`,`id_libro`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
