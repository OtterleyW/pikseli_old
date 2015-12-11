-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Palvelin: localhost
-- Luontiaika: 11.12.2015 klo 19:52
-- Palvelimen versio: 5.5.34-cll-lve
-- PHP:n versio: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tietokanta: `c5zsddtr_pikseli`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `hevonen_kisat`
--

CREATE TABLE IF NOT EXISTS `hevonen_kisat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pvm` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `kutsu_url` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  `paikka` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `laji` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `luokka` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `sijoitus` int(11) NOT NULL,
  `osallistujat` int(11) NOT NULL,
  `hevonen_id` int(11) NOT NULL,
  `teksti` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=3322 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `hevonen_kuva`
--

CREATE TABLE IF NOT EXISTS `hevonen_kuva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hevonen_id` int(11) NOT NULL,
  `kuvaaja_id` int(11) NOT NULL,
  `osoite` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `iso_kuva` varchar(10) COLLATE utf8_swedish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=461 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `hevonen_kuvaaja`
--

CREATE TABLE IF NOT EXISTS `hevonen_kuvaaja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nimi` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `hevonen_suku`
--

CREATE TABLE IF NOT EXISTS `hevonen_suku` (
  `id` int(11) NOT NULL,
  `isa_id` int(11) NOT NULL,
  `ema_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Rakenne taululle `hevonen_tekstit`
--

CREATE TABLE IF NOT EXISTS `hevonen_tekstit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hevonen_id` int(11) NOT NULL,
  `pvm` date NOT NULL,
  `otsikko` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  `kirjoittaja` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `tekstin_tyyppi` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `teksti` longtext COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=214 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `hevonen_tiedot`
--

CREATE TABLE IF NOT EXISTS `hevonen_tiedot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `nimi` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `lempinimi` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `vhtunnus` varchar(20) COLLATE utf8_swedish_ci DEFAULT NULL,
  `rotu` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `rotu_lyhenne` varchar(50) COLLATE utf8_swedish_ci DEFAULT NULL,
  `sukupuoli` varchar(10) COLLATE utf8_swedish_ci DEFAULT NULL,
  `syntymaaika` date DEFAULT NULL,
  `ika` int(11) NOT NULL,
  `saka` int(11) DEFAULT NULL,
  `painotus` varchar(50) COLLATE utf8_swedish_ci DEFAULT NULL,
  `koulutustaso` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `kasvattaja` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `kasvattaja_url` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `omistaja` varchar(200) COLLATE utf8_swedish_ci DEFAULT 'o',
  `omistaja_url` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `meriitit` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `luonne` longtext COLLATE utf8_swedish_ci,
  `kaytto` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `kilpailu_tyyppi` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `vari` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `sukuselvitys` longtext COLLATE utf8_swedish_ci,
  `suvun_pituus` int(11) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_swedish_ci DEFAULT NULL,
  `saavutukset` mediumtext COLLATE utf8_swedish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=3630 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
