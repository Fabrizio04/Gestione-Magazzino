-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Lug 18, 2018 alle 20:44
-- Versione del server: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `magazzino`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `carico`
--

CREATE TABLE IF NOT EXISTS `carico` (
  `id` int(11) NOT NULL,
  `da_magaz_id` int(11) NOT NULL,
  `magaz_id` int(11) NOT NULL,
  `bene_et_id` int(11) NOT NULL,
  `quantit` int(11) NOT NULL,
  `tecnico_id` int(11) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `allegato` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `etichette`
--

CREATE TABLE IF NOT EXISTS `etichette` (
  `id` int(11) NOT NULL,
  `campo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `magaz`
--

CREATE TABLE IF NOT EXISTS `magaz` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `magaz`
--

INSERT INTO `magaz` (`id`, `nome`) VALUES
(1, 'ACQUISTO');

-- --------------------------------------------------------

--
-- Struttura della tabella `magazzini`
--

CREATE TABLE IF NOT EXISTS `magazzini` (
  `id` int(11) NOT NULL,
  `bene_et_id` int(11) NOT NULL,
  `magaz_id` int(11) NOT NULL,
  `totale` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `scarico`
--

CREATE TABLE IF NOT EXISTS `scarico` (
  `id` int(11) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `da_magaz_id` int(11) NOT NULL,
  `tecnico_id` int(11) NOT NULL,
  `bene_et_id` int(11) NOT NULL,
  `quantit` int(100) NOT NULL,
  `rif_inst` varchar(100) NOT NULL,
  `utente` varchar(100) NOT NULL,
  `Allegato` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `tecnico`
--

CREATE TABLE IF NOT EXISTS `tecnico` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carico`
--
ALTER TABLE `carico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `etichette`
--
ALTER TABLE `etichette`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magaz`
--
ALTER TABLE `magaz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magazzini`
--
ALTER TABLE `magazzini`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scarico`
--
ALTER TABLE `scarico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carico`
--
ALTER TABLE `carico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `etichette`
--
ALTER TABLE `etichette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `magaz`
--
ALTER TABLE `magaz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `magazzini`
--
ALTER TABLE `magazzini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scarico`
--
ALTER TABLE `scarico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tecnico`
--
ALTER TABLE `tecnico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
