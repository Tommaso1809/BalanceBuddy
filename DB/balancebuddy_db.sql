-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 24, 2024 alle 19:59
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `balancebuddy_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ha`
--

CREATE TABLE `ha` (
  `portafoglio` int(11) DEFAULT NULL,
  `movimento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `movimento`
--

CREATE TABLE `movimento` (
  `IDmovimento` int(11) NOT NULL,
  `categoria` varchar(10) DEFAULT NULL,
  `dataInserimento` varchar(12) DEFAULT NULL,
  `importo` double DEFAULT NULL,
  `tipologia` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `portafoglio`
--

CREATE TABLE `portafoglio` (
  `IDportafoglio` int(11) NOT NULL,
  `entrate` double DEFAULT NULL,
  `uscite` double DEFAULT NULL,
  `budget` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `possiede`
--

CREATE TABLE `possiede` (
  `utente` varchar(20) DEFAULT NULL,
  `portafoglio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `email` varchar(20) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `cognome` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ha`
--
ALTER TABLE `ha`
  ADD KEY `portafoglio` (`portafoglio`),
  ADD KEY `movimento` (`movimento`);

--
-- Indici per le tabelle `movimento`
--
ALTER TABLE `movimento`
  ADD PRIMARY KEY (`IDmovimento`);

--
-- Indici per le tabelle `portafoglio`
--
ALTER TABLE `portafoglio`
  ADD PRIMARY KEY (`IDportafoglio`);

--
-- Indici per le tabelle `possiede`
--
ALTER TABLE `possiede`
  ADD KEY `utente` (`utente`),
  ADD KEY `portafoglio` (`portafoglio`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`email`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ha`
--
ALTER TABLE `ha`
  ADD CONSTRAINT `ha_ibfk_1` FOREIGN KEY (`portafoglio`) REFERENCES `portafoglio` (`IDportafoglio`),
  ADD CONSTRAINT `ha_ibfk_2` FOREIGN KEY (`movimento`) REFERENCES `movimento` (`IDmovimento`);

--
-- Limiti per la tabella `possiede`
--
ALTER TABLE `possiede`
  ADD CONSTRAINT `possiede_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`),
  ADD CONSTRAINT `possiede_ibfk_2` FOREIGN KEY (`portafoglio`) REFERENCES `portafoglio` (`IDportafoglio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
