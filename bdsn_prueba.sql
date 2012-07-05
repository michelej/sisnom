-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 05, 2012 at 08:34 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bdsn_prueba`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajustes`
--

CREATE TABLE IF NOT EXISTS `ajustes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_INI` date NOT NULL,
  `FECHA_FIN` date DEFAULT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ajustes_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ajustes_asignaciones`
--

CREATE TABLE IF NOT EXISTS `ajustes_asignaciones` (
  `asignacion_id` int(11) NOT NULL,
  `ajuste_id` int(11) NOT NULL,
  KEY `fk_asignaciones_empleados_asignaciones1` (`asignacion_id`),
  KEY `fk_asignaciones_empleados_ajustes1` (`ajuste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ajustes_deducciones`
--

CREATE TABLE IF NOT EXISTS `ajustes_deducciones` (
  `deduccion_id` int(11) NOT NULL,
  `ajuste_id` int(11) NOT NULL,
  KEY `fk_deducciones_empleados_deducciones1` (`deduccion_id`),
  KEY `fk_deducciones_empleados_ajustes1` (`ajuste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asignaciones`
--

CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `ausencias`
--

CREATE TABLE IF NOT EXISTS `ausencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Remunerada , No Remunerada',
  `FECHA` date NOT NULL,
  `JUSTIFICACION` text COLLATE utf8_unicode_ci,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ausencias_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DESCRIPCION` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `cestatickets`
--

CREATE TABLE IF NOT EXISTS `cestatickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_INI` date NOT NULL,
  `FECHA_FIN` date NOT NULL,
  `FECHA_ELA` datetime NOT NULL,
  `VALOR_DIARIO` decimal(19,5) NOT NULL COMMENT '50% - UNIDAD TRIBUTARIA',
  `SUELDO_MINIMO` decimal(19,5) NOT NULL,
  `BLOQUEAR` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comerciales`
--

CREATE TABLE IF NOT EXISTS `comerciales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CANTIDAD` decimal(19,5) NOT NULL,
  `FECHA` date NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comerciales_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `contratos`
--

CREATE TABLE IF NOT EXISTS `contratos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_INI` date NOT NULL,
  `FECHA_FIN` date DEFAULT NULL,
  `MODALIDAD` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Fijo , Contratado , Eventuales',
  `departamento_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asignaciones_departamentos1` (`departamento_id`),
  KEY `fk_asignaciones_cargos1` (`cargo_id`),
  KEY `fk_asignaciones_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Table structure for table `deducciones`
--

CREATE TABLE IF NOT EXISTS `deducciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `programa_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_departamentos_programas1` (`programa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_cestatickets`
--

CREATE TABLE IF NOT EXISTS `detalle_cestatickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TOTAL` decimal(19,5) NOT NULL,
  `DIAS_ADICIONALES` int(11) NOT NULL,
  `DIAS_DESCONTAR` int(11) NOT NULL,
  `DIAS_LABORADOS` int(11) NOT NULL,
  `CARGO` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DEPARTAMENTO` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MODALIDAD` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `cestaticket_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_cestatickets_cestatickets1` (`cestaticket_id`),
  KEY `fk_detalle_cestatickets_empleados1` (`empleado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_eventualidades`
--

CREATE TABLE IF NOT EXISTS `detalle_eventualidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA` date NOT NULL,
  `VALOR` decimal(19,5) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `eventualidad_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_eventualidades_empleados1` (`empleado_id`),
  KEY `fk_detalle_eventualidades_eventualidades1` (`eventualidad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_recibos`
--

CREATE TABLE IF NOT EXISTS `detalle_recibos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTO` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `NOMBRE` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `MONTO` decimal(19,5) NOT NULL,
  `recibo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_recibos_recibos1` (`recibo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43643 ;

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NACIONALIDAD` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `CEDULA` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `SEXO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `APELLIDO` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FECHANAC` date NOT NULL,
  `INGRESO` date NOT NULL COMMENT 'FECHA DE INGRESO',
  `SALIDA` date DEFAULT NULL COMMENT 'Fecha de Salida de la empresa (Despido o otro)',
  `TELEFONO` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CELULAR` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DIRECCION` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ESTADO` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CIUDAD` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `MUNICIPIO` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EMAIL` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EDOCIVIL` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SOLTERO\nCASADO\nVIUDO\nDIVORCIADO\nCONCUBINATO\n',
  `ALFABETA` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SABE LEER?',
  `PRIMARIA` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'DONDE ESTUDIO PRIMARIA',
  `SECUNDARIA` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'DONDE ESTUDIO SCUNDARIA',
  `SUPERIOR` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'DONDE CURSO ESTUDIOS UNIVERSITARIOS',
  `SANGRE` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'O-\nO+\nA-\nA+\nB-\nB+\nAB-\nAB+',
  `PESO` int(11) DEFAULT NULL COMMENT 'EN KILOGRAMOS SIN DECIMALES',
  `EMFERMEDADES` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `OPERACIONES` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ALERGICO` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ESTATURA` int(11) DEFAULT NULL COMMENT 'ESTATURA EN CM',
  `COMPLEXION` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'PEQUENA\nMEDIANA\nGRANDE',
  `TCAMISA` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'TALLA CAMISA',
  `TPANTALOM` int(11) DEFAULT NULL COMMENT 'TALLA PANTALON',
  `TCALZADO` int(11) DEFAULT NULL COMMENT 'TALLA ZAPATO',
  `DISCAPACIDAD` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NOMEMERGENCIA` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TELEMERGECIA` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `BANCO` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NCUENTA` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TPAGO` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `grupo_id` int(11) NOT NULL,
  `localizacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleados_grupos1` (`grupo_id`),
  KEY `fk_empleados_localizaciones1` (`localizacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Table structure for table `eventualidades`
--

CREATE TABLE IF NOT EXISTS `eventualidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `TIPO` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Asignacion o Deduccion',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `experiencias`
--

CREATE TABLE IF NOT EXISTS `experiencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ORGANISMO` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `CARGO` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `FECHA_INI` date NOT NULL,
  `FECHA_FIN` date NOT NULL,
  `OBSERVACIONES` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_experiencias_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `familiares`
--

CREATE TABLE IF NOT EXISTS `familiares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `PARENTESCO` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Hijo, Hija, Padre, Madre, Hermano, Hermana',
  `DISCAPACIDAD` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No' COMMENT 'Si o No',
  `INSTRUCCION` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Ninguna',
  `FECHA` date NOT NULL,
  `FECHA_EFEC` date NOT NULL COMMENT 'Fecha en la que se hace efectivo para el sistema',
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_familiares_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `feriados`
--

CREATE TABLE IF NOT EXISTS `feriados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA` date NOT NULL,
  `DESCRIPCION` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `historiales`
--

CREATE TABLE IF NOT EXISTS `historiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SUELDO_BASE` decimal(19,5) NOT NULL,
  `FECHA_INI` date NOT NULL COMMENT 'Inicio ',
  `FECHA_FIN` date DEFAULT NULL COMMENT 'Fin',
  `FECHA_RET` date DEFAULT NULL COMMENT 'Fecha desde donde se va a pagar el sueldo retroactivo',
  `cargo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historiales_cargos1` (`cargo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Table structure for table `horas_extras`
--

CREATE TABLE IF NOT EXISTS `horas_extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nocturno, Domingos y Feriados',
  `FECHA` date NOT NULL,
  `COMENTARIO` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_horasextras_empleados1` (`empleado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `islr`
--

CREATE TABLE IF NOT EXISTS `islr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PORCENTAJE` decimal(19,5) NOT NULL,
  `FECHA` date NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_islr_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `localizaciones`
--

CREATE TABLE IF NOT EXISTS `localizaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departamento_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_localizaciones_departamentos1` (`departamento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `nominas`
--

CREATE TABLE IF NOT EXISTS `nominas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_INI` date NOT NULL,
  `FECHA_FIN` date NOT NULL,
  `QUINCENA` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Primera Quincena , Segunda',
  `FECHA_ELA` datetime NOT NULL COMMENT 'Fecha de Elaboracion de la nomina',
  `SUELDO_MINIMO` decimal(19,5) NOT NULL,
  `BLOQUEAR` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `prestamos`
--

CREATE TABLE IF NOT EXISTS `prestamos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CANTIDAD` decimal(19,5) NOT NULL,
  `FECHA` date NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prestamos_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `programas`
--

CREATE TABLE IF NOT EXISTS `programas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODIGO` int(11) NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TIPO` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Actividad  /  Proyecto',
  `NUMERO` int(11) NOT NULL COMMENT 'Numero de la Actividad o Proyecto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `recibos`
--

CREATE TABLE IF NOT EXISTS `recibos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CARGO` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEPARTAMENTO` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MODALIDAD` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SUELDO_BASE` decimal(19,5) DEFAULT NULL,
  `DIAS_LABORADOS` int(11) DEFAULT NULL,
  `nomina_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recibos_nominas1` (`nomina_id`),
  KEY `fk_recibos_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2991 ;

-- --------------------------------------------------------

--
-- Table structure for table `titulos`
--

CREATE TABLE IF NOT EXISTS `titulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TITULO` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'T.S.U , Profesional Universitario , Post-Grado , Maestria , Doctorado',
  `ESPECIALIDAD` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `INSTITUCION` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `FECHA` date NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_titulos_empleados1` (`empleado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `tribunales`
--

CREATE TABLE IF NOT EXISTS `tribunales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CANTIDAD` decimal(19,5) NOT NULL,
  `FECHA` date NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tribunales_empleados1` (`empleado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `APELLIDO` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `GRUPO` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ajustes`
--
ALTER TABLE `ajustes`
  ADD CONSTRAINT `fk_ajustes_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ajustes_asignaciones`
--
ALTER TABLE `ajustes_asignaciones`
  ADD CONSTRAINT `fk_asignaciones_empleados_ajustes1` FOREIGN KEY (`ajuste_id`) REFERENCES `ajustes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asignaciones_empleados_asignaciones1` FOREIGN KEY (`asignacion_id`) REFERENCES `asignaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ajustes_deducciones`
--
ALTER TABLE `ajustes_deducciones`
  ADD CONSTRAINT `fk_deducciones_empleados_ajustes1` FOREIGN KEY (`ajuste_id`) REFERENCES `ajustes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_deducciones_empleados_deducciones1` FOREIGN KEY (`deduccion_id`) REFERENCES `deducciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ausencias`
--
ALTER TABLE `ausencias`
  ADD CONSTRAINT `fk_ausencias_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comerciales`
--
ALTER TABLE `comerciales`
  ADD CONSTRAINT `fk_comerciales_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `fk_asignaciones_cargos1` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asignaciones_departamentos1` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asignaciones_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `fk_departamentos_programas1` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_cestatickets`
--
ALTER TABLE `detalle_cestatickets`
  ADD CONSTRAINT `fk_detalle_cestatickets_cestatickets1` FOREIGN KEY (`cestaticket_id`) REFERENCES `cestatickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_cestatickets_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_eventualidades`
--
ALTER TABLE `detalle_eventualidades`
  ADD CONSTRAINT `fk_detalle_eventualidades_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_eventualidades_eventualidades1` FOREIGN KEY (`eventualidad_id`) REFERENCES `eventualidades` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_recibos`
--
ALTER TABLE `detalle_recibos`
  ADD CONSTRAINT `fk_detalle_recibos_recibos1` FOREIGN KEY (`recibo_id`) REFERENCES `recibos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleados_grupos1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleados_localizaciones1` FOREIGN KEY (`localizacion_id`) REFERENCES `localizaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `experiencias`
--
ALTER TABLE `experiencias`
  ADD CONSTRAINT `fk_experiencias_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `familiares`
--
ALTER TABLE `familiares`
  ADD CONSTRAINT `fk_familiares_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `historiales`
--
ALTER TABLE `historiales`
  ADD CONSTRAINT `fk_historiales_cargos1` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `horas_extras`
--
ALTER TABLE `horas_extras`
  ADD CONSTRAINT `fk_horasextras_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `islr`
--
ALTER TABLE `islr`
  ADD CONSTRAINT `fk_islr_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `localizaciones`
--
ALTER TABLE `localizaciones`
  ADD CONSTRAINT `fk_localizaciones_departamentos1` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_prestamos_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `fk_recibos_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recibos_nominas1` FOREIGN KEY (`nomina_id`) REFERENCES `nominas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `titulos`
--
ALTER TABLE `titulos`
  ADD CONSTRAINT `fk_titulos_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tribunales`
--
ALTER TABLE `tribunales`
  ADD CONSTRAINT `fk_tribunales_empleados1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
--  Datos necesarios para el funcionamiento del sistema
--

INSERT INTO `asignaciones` (`id`, `DESCRIPCION`) VALUES
(1, 'Prima por Reconocimiento'),
(2, 'Prima por Hogar'),
(3, 'Prima por Antigüedad'),
(4, 'Prima por Transporte'),
(5, 'Prima por Hijos'),
(6, 'Prima de Nivelación y Eficiencia Profesional'),
(7, 'Bono Nocturno'),
(8, 'Recargo Domingos y Dias Feriados');

INSERT INTO `deducciones` (`id`, `DESCRIPCION`) VALUES
(1, 'S.S.O (4%)'),
(2, 'Régimen Prestacional de Empleo (0.50%)'),
(3, 'Fondo de Ahorro Obligatorio de Vivienda (FAOV) (1%)'),
(4, 'Fondo de Pensiones (3%)'),
(5, 'Caja de Ahorros'),
(6, 'Préstamo Caja de Ahorros'),
(7, 'Deducciones por Créditos Comerciales'),
(8, 'Deducciones por Tribunales'),
(9, 'Retención del Impuesto Sobre la Renta'),
(10, 'Ley de Vivienda y Habitat (1%)');

INSERT INTO `grupos` (`id`, `NOMBRE`) VALUES
(1, 'Empleado'),
(2, 'Obrero');


INSERT INTO `users` (`id`, `USERNAME`, `PASSWORD`, `NOMBRE`, `APELLIDO`, `GRUPO`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrador', '', 'Administrador');