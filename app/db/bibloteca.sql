-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2024 at 04:16 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibloteca`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_libros`
--

CREATE TABLE `t_libros` (
  `libro_id` int NOT NULL,
  `libro_titulo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `libro_autor` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `libro_categoria` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `libro_fecha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `libro_editorial` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_libros`
--

INSERT INTO `t_libros` (`libro_id`, `libro_titulo`, `libro_autor`, `libro_categoria`, `libro_fecha`, `libro_editorial`) VALUES
(1, 'Física Universitaria con Física Moderna', 'Hugh D. Young, Roger A. Freedman', 'Ciencias Basicas', '2007', 'Cengage Learning'),
(2, 'Cálculo. Trascendentes Tempranas', 'James Stewart', 'Ciencias Basicas', '2009', 'Cengage Learning'),
(3, 'Biología', 'Neil A. Campbell, Jane B. Reece', 'Ciencias Basicas', '2008', 'Pearson'),
(5, ' Introducción a la Química Orgánica', 'William H. Brown, Thomas Poon', 'Ciencias Basicas', 'Cengage Learning', 'Cengage Learning'),
(8, 'Psicología', 'David G. Myers', 'Ciencias Basicas', '2014', 'McGraw-Hill Education'),
(9, 'Estructuras de Datos y Algoritmos en Java', 'Robert Lafore', 'Sistemas Computacionales', '2018', 'Prentice Hall'),
(10, 'Redes de Computadoras', 'Andrew S. Tanenbaum', 'Sistemas Computacionales', '2021', 'Pearson'),
(11, 'Ingeniería de Métodos', 'Mikell P. Groover', 'Industrial', '2021', 'McGraw-Hill'),
(12, 'Diseño de Sistemas de Producción y Operaciones', 'R. Dan Reid y Nada R. Sanders', 'Industrial', '2018', 'Cengage Learning'),
(13, 'Administración: Una Perspectiva Global y Empresarial', 'Harold Koontz y Heinz Weihrich', 'Gestión Empresarial', '2015', 'McGraw-Hill'),
(14, 'Comportamiento Organizacional', 'Stephen P. Robbins y Timothy A. Judge', 'Gestión Empresarial', '2017', 'Pearson');

-- --------------------------------------------------------

--
-- Table structure for table `t_prestamos`
--

CREATE TABLE `t_prestamos` (
  `prestamo_id` int NOT NULL,
  `prestamo_nombre` varchar(200) NOT NULL,
  `prestamo_semestre` varchar(100) NOT NULL,
  `prestamo_carrera` varchar(200) NOT NULL,
  `prestamo_Ncontrol` varchar(200) NOT NULL,
  `prestamo_prestamo` date NOT NULL,
  `prestamo_entrega` date NOT NULL,
  `id_libro` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_prestamos`
--

INSERT INTO `t_prestamos` (`prestamo_id`, `prestamo_nombre`, `prestamo_semestre`, `prestamo_carrera`, `prestamo_Ncontrol`, `prestamo_prestamo`, `prestamo_entrega`, `id_libro`) VALUES
(1, 'Misael Juarez Aguilar', '7', 'Sistemas Computacionales', 'L211190030', '2014-11-11', '2024-11-18', 3),
(2, 'Karla Guzman Gomez', '7', 'Sistemas Computacionales', 'L211190020', '2024-11-14', '2024-11-25', 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_usuarios`
--

CREATE TABLE `t_usuarios` (
  `usuario_id` int NOT NULL,
  `usuario_nombre` varchar(100) NOT NULL,
  `usuario_apellidoP` varchar(100) NOT NULL,
  `usuario_apellidoM` varchar(100) NOT NULL,
  `usuario_usuario` varchar(100) NOT NULL,
  `usuario_pass` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_usuarios`
--

INSERT INTO `t_usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellidoP`, `usuario_apellidoM`, `usuario_usuario`, `usuario_pass`) VALUES
(1, 'Misael', 'Juarez', 'Aguilar', 'Misael', '$2y$10$SVtWMVFImVzu6fxEsPOKtOBy.q0rX2bQgueujmdgdRTsQt/W.YIz.'),
(2, 'Luis', 'Torres', 'Puebla', 'luis', '$2y$10$iLCrFeOENPlQOexErcfgrudJLvTHgJTSY1KZijVPOLp.zaaXBF3ny'),
(3, 'Karla', 'Guzman', 'Gomez', 'karla', '$2y$10$5zLU2liYjVDH4M7HmLZJj.wFvsjGYODLUd88o8VpSCtq8xe2RzfOS'),
(4, 'Karla Andrea', 'Matinez', 'Aguilar', 'andrea', '$2y$10$J7rifPknCC9Y7jGBTnQhL.2f74Kw/uoKnsTEfYlCZWe4xnm7dFJCS'),
(5, 'Mauricio', 'Ivan', 'Palma', 'mau', '$2y$10$kDkjAEc7nSf6hi3wm/8Bre9lWEEpA0tMRHhjfnY.ET7xHHHd1a0Rm'),
(6, 'Roque Antonio', 'Alvarez', 'Guitierrez', 'roque', '$2y$10$cpI4.CaTMUVp6kmmoqpL3usnhh3zawCYDrqH2jo6EOZWIk/28c3zq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_libros`
--
ALTER TABLE `t_libros`
  ADD PRIMARY KEY (`libro_id`);

--
-- Indexes for table `t_prestamos`
--
ALTER TABLE `t_prestamos`
  ADD PRIMARY KEY (`prestamo_id`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indexes for table `t_usuarios`
--
ALTER TABLE `t_usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_libros`
--
ALTER TABLE `t_libros`
  MODIFY `libro_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `t_prestamos`
--
ALTER TABLE `t_prestamos`
  MODIFY `prestamo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_usuarios`
--
ALTER TABLE `t_usuarios`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_prestamos`
--
ALTER TABLE `t_prestamos`
  ADD CONSTRAINT `t_prestamos_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `t_libros` (`libro_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
