-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 sep 2023 om 12:11
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `article`
--

CREATE TABLE `article` (
  `article_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `calories` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `favourite`
--

CREATE TABLE `favourite` (
  `fav_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kitchentype`
--

CREATE TABLE `kitchentype` (
  `kitchentype_id` int(11) NOT NULL,
  `record_descriptor` varchar(1) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `amount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipe`
--

CREATE TABLE `recipe` (
  `recipe_id` int(11) NOT NULL,
  `kitchen_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `descr_short` varchar(500) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipestep`
--

CREATE TABLE `recipestep` (
  `step_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `step_num` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexen voor tabel `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user` (`user_id`),
  ADD KEY `comment_recipe` (`recipe_id`);

--
-- Indexen voor tabel `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`fav_id`),
  ADD KEY `fav_user` (`user_id`),
  ADD KEY `fav_recipe` (`recipe_id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD KEY `ingr-article` (`article_id`),
  ADD KEY `ingr-recipe` (`recipe_id`);

--
-- Indexen voor tabel `kitchentype`
--
ALTER TABLE `kitchentype`
  ADD PRIMARY KEY (`kitchentype_id`);

--
-- Indexen voor tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `rating_recipe` (`recipe_id`);

--
-- Indexen voor tabel `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `keuken_id` (`kitchen_id`,`type_id`,`user_id`),
  ADD KEY `recipe_users` (`user_id`),
  ADD KEY `recipe_type` (`type_id`);

--
-- Indexen voor tabel `recipestep`
--
ALTER TABLE `recipestep`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `step_recipe` (`recipe_id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `article`
--
ALTER TABLE `article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `favourite`
--
ALTER TABLE `favourite`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `kitchentype`
--
ALTER TABLE `kitchentype`
  MODIFY `kitchentype_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `recipe`
--
ALTER TABLE `recipe`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `recipestep`
--
ALTER TABLE `recipestep`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`),
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `favourite`
--
ALTER TABLE `favourite`
  ADD CONSTRAINT `fav_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingr-article` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ingr-recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

--
-- Beperkingen voor tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_kitchen` FOREIGN KEY (`kitchen_id`) REFERENCES `kitchentype` (`kitchentype_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_type` FOREIGN KEY (`type_id`) REFERENCES `kitchentype` (`kitchentype_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `recipestep`
--
ALTER TABLE `recipestep`
  ADD CONSTRAINT `step_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
