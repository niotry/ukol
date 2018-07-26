-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 26. čec 2018, 19:23
-- Verze serveru: 10.1.26-MariaDB
-- Verze PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `rtsoft`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `likes`
--

CREATE TABLE `likes` (
  `id` int(10) NOT NULL,
  `id_project` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `likes`
--

INSERT INTO `likes` (`id`, `id_project`, `id_user`) VALUES
(13, 154, 3),
(22, 157, 2),
(26, 157, 1),
(27, 167, 1),
(28, 160, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `type` varchar(10) COLLATE utf8_bin NOT NULL,
  `isProject` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Vypisuji data pro tabulku `projects`
--

INSERT INTO `projects` (`id`, `name`, `date`, `type`, `isProject`) VALUES
(132, 'pokus3', '2011-12-10', 'Omezený', 1),
(154, 'hah^2', '2018-08-07', 'Omezený', 0),
(157, 'izi5', '2011-03-12', 'Neomezený', 0),
(160, 'projektík', '2003-03-03', 'Neomezený', 0),
(164, 'hah^48', '2001-01-01', 'Neomezený', 0),
(166, 'lulik11', '2000-11-02', 'Omezený', 0),
(167, 'lulik12', '2000-11-03', 'Omezený', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` text COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'Marešek', '$2y$10$.zhbT.77dL0zovqQyzDbdedV/jhufK4IU5rOnlP4BpiUqXb.5IGqC', 'niotry@seznam.cz'),
(2, 'Marešek2', '$2y$10$O5B1bxJb3a59LGETSxcnIup1w/fE49HXhdhXSoY3fzBCeoXGeiltW', 'gasos4i@seznam.cz'),
(3, 'lucie', '$2y$10$Vt2Iqf0SUN47lmyhxN8tDeFjmyfGlGQjw4N05bty1sTm7gGSVPyFW', 'qwe@seznam.c'),
(4, 'Marešek3', '$2y$10$n8TA5nLyMjjDzwL269NVQuaxJsP4LkwW.xQhCyF13j1sCTr0sUBQ2', 'gasos4i@seznam.cz'),
(5, 'Marešek4', '$2y$10$RomRrFAsCXRwlDw0qB.E1O4esIR8YzkVnwP3dyMJ9QVt5jhJVu08a', 'gasos4i@seznam.cz'),
(6, 'Marešek8', '$2y$10$h559kPGnqrAuk2UVBryjruQSWat1BPoeQOggG/rvfEVy8T2xa0ryu', 'gasos4i@seznam.cz');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_ibfk_1` (`id_project`);

--
-- Klíče pro tabulku `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`(100));

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pro tabulku `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
