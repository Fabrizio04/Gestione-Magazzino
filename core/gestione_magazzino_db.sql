SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `carico` (
  `id` int(11) NOT NULL,
  `da_magaz_id` int(11) NOT NULL,
  `magaz_id` int(11) NOT NULL,
  `bene_et_id` int(11) NOT NULL,
  `quantit` int(11) NOT NULL,
  `tecnico_id` int(11) NOT NULL,
  `dataora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `allegato` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `etichette` (
  `id` int(11) NOT NULL,
  `campo` varchar(100) NOT NULL,
  `magaz_tag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `magaz` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `fam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `magaz` (`id`, `nome`, `fam`) VALUES
(1, 'ACQUISTO', 0);

CREATE TABLE IF NOT EXISTS `magazzini` (
  `id` int(11) NOT NULL,
  `bene_et_id` int(11) NOT NULL,
  `magaz_id` int(11) NOT NULL,
  `totale` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `scarico` (
  `id` int(11) NOT NULL,
  `dataora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `da_magaz_id` int(11) NOT NULL,
  `tecnico_id` int(11) NOT NULL,
  `bene_et_id` int(11) NOT NULL,
  `quantit` int(100) NOT NULL,
  `rif_inst` varchar(100) NOT NULL,
  `utente` varchar(100) NOT NULL,
  `Allegato` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tecnico` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `carico`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `etichette`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `magaz`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `magazzini`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `scarico`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `carico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `etichette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `magaz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

ALTER TABLE `magazzini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scarico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tecnico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
