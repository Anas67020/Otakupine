-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Sep 2024 um 09:49
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `otakuopine_login`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comment`
--

CREATE TABLE `comment` (
  `user` text NOT NULL,
  `comment` text DEFAULT NULL,
  `titel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `comment`
--

INSERT INTO `comment` (`user`, `comment`, `titel`) VALUES
('Dominik', 'heqkufuq', 'JoJo\'s Bizarre Adventure'),
('Test', 'sehr gut!!!', 'Gleipnir'),
('Test', 'Best anime ever!!! WATCH IT!\r\nEverything is a jojo reference', 'JoJo\'s Bizarre Adventure'),
('Melek', 'JOJOOOOOOOOOOOOOOOOOO\r\nBEST ANIME!!!!!!!!!!!!!! WATCH NOW!!! ', 'JoJo\'s Bizarre Adventure'),
('Melek', 'sehr zu empfhelen! liebe den anime', 'Dragonball Super'),
('KingOfCats', 'Let\'s goooooooooooooo Jojo best anime', 'JoJo\'s Bizarre Adventure'),
('KingOfCats', 'Sehr guter Manga ', 'Vagabond'),
('Test', 'fettsack', 'The Rising of the Shield Hero'),
('Melek', 'Spannend!', 'One Piece'),
('Melek', 'Simp esdeth', 'Akame ga Kill!'),
('Melek', 'Koruuuuuuuuuu DX', 'Assassination Classroom'),
('Melek', 'be a Slayer! super gut Liebe Ihn! Gesund für Ihre kinder und Beziehung!', 'Demon Slayer'),
('Melek', 'Liebe Ihn aber 16+', 'Kakegurui'),
('Melek', 'Sehr Schön und Romantisch ^^', 'Sailor Moon Crystal'),
('Melek', 'Sehr Zu Emphelen!!! ist wirkklich spannend und süß', 'Spy X Family');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
