-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 26. lis 2017, 14:57
-- Verze serveru: 5.7.14
-- Verze PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `kalahari`
--
CREATE DATABASE IF NOT EXISTS `kalahari` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `kalahari`;

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `name`, `email`, `content`, `created_at`) VALUES
(1, 2, 'Tygger', 'tygger@skaut.cz', 'Ahoia, jak to fungí?', '2016-11-23 23:43:17'),
(2, 1, 'Pepa', '', 'ZDééééér 8938', '2016-11-23 23:48:02'),
(3, 1, 'HOOOOBO', 'foooo@hooosbo.gh', '\n\n\nTo čumíte!!', '2016-11-23 23:49:25'),
(4, 6, 'Bob', '', 'Hoi', '2016-11-24 17:29:47'),
(5, 6, 'Peppa', '', 'Haha', '2017-01-04 17:21:33'),
(6, 1, 'Lenka', '', 'Ahoiaaaaa!\n\nALSDJKlksajd342', '2017-01-05 12:40:47'),
(7, 8, 'Odpovídač', '', 'To je boží!!', '2017-01-05 14:28:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `text` text,
  `start_date` date NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `start_place` varchar(100) DEFAULT NULL,
  `end_date` date NOT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `end_place` varchar(100) DEFAULT NULL,
  `fee` varchar(30) DEFAULT NULL,
  `bring` text,
  `report` text,
  `notes` text,
  `gd_gallery` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `events`
--

INSERT INTO `events` (`id`, `user_id`, `name`, `text`, `start_date`, `start_time`, `start_place`, `end_date`, `end_time`, `end_place`, `fee`, `bring`, `report`, `notes`, `gd_gallery`, `updated_at`, `removed`) VALUES
(1, 0, 'První výprava', 'Tohle je popis první výpravy, bude to fakt boží!\nTadadada..', '2017-01-18', NULL, 'U pošty 12', '2017-01-19', NULL, 'Na hlavním nádraží v Plzni', '45 Kč', 'VZSS, baterku, kraviny', NULL, '..něco tajnýho, jen pro vedoucí..', NULL, '2017-01-05 18:59:52', 0),
(2, 0, 'Oddílová schůzka', '', '2017-01-26', '2017-01-05 16:00:00', 'Na klubovně Kalahari', '2017-01-26', '2017-01-05 18:00:00', 'tamtéž', NULL, 'VZSS na schůzku, oddílové tričko, skautský šátek', NULL, 'Nesmíme zapomenout vlčata odvést na konečnou, až skončíme..', NULL, '2017-01-24 23:34:56', 0),
(3, 0, 'Minulá Akce', NULL, '2016-12-14', '2017-01-05 08:53:00', 'Na hl. n', '2016-12-17', '2017-01-05 17:40:00', 'tamtéž', '800', 'VZSS_vyprava, teplé ponožky, sněžnice', 'Bylo to fakt super a párkrát jsme se ztratili a pak jsme málem umrzli a pak to zas tak super nebylo.\r\nAle zážitek prej nemusí bejt příjemnej, hlavně když je silnej!', '<b>Příště nezapomeňme vzít stany!!!</b>\r\n', '0B2lr-GXqNJC3SlYtb2kwZnhZNlk', '2017-01-05 18:59:37', 0),
(4, 0, 'Formulářov 2017', 'Tady pak doplníme popis akce,\nkaždopádně to chce něco vymyslet!\nHuh', '2017-02-25', NULL, NULL, '2026-02-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-07 00:00:37', 1),
(5, 0, 'Další výlet', 'Tentokrát jenom jednodenní, jde o první ročník tradiční akce.', '2017-01-22', NULL, 'U pošty 12 na Doubravce', '2017-01-29', NULL, 'tamtéž', NULL, 'VZSS, kraviny, blbosti, hrneček', NULL, ':D :D :D', NULL, '2017-01-07 16:40:38', 0),
(6, 0, 'Klídečíček', 'Příliš žluťoučký kůň se kamarádil se dvěma či třemi cibulemi z nezbedného rodu.', '2016-12-26', NULL, 'Doma', '2017-01-20', NULL, 'tamtéž', NULL, 'VZSS, cukroví, bačkory', NULL, 'Tohle bychom ani na stránkách mít nemuseli, ne?', NULL, '2017-01-06 18:30:43', 0),
(7, 0, 'Tádádydá', '', '2017-02-17', NULL, 'Před školou', '2017-02-19', NULL, 'Budějice', NULL, 'VZSSSSSSSS', NULL, 'A máš to na starost!', NULL, '2017-01-12 14:39:57', 0),
(8, 0, 'Huuhuhuhuhu', 'těšte se', '2017-03-23', NULL, 'na hlavním nádraží', '2017-03-25', NULL, 'tamtéž', NULL, 'VZSS, kraviny, blbosti, hrneček', NULL, 'Jak to jde?', NULL, '2017-03-06 20:20:39', 0),
(9, 0, 'Schozka', '... &@#', '2017-04-15', NULL, 'kdesi', '2017-04-15', NULL, 'jinde', NULL, 'předmět', NULL, '', NULL, '2017-03-06 20:27:53', 0),
(10, 0, 'Budoucno', '', '2018-02-15', NULL, 'Tudle', '2018-02-18', NULL, 'Tam', NULL, 'Nic', NULL, 'Hahahah hahaha', NULL, '2017-04-27 20:24:53', 0),
(11, 0, 'Podzemky', 'Těš se!!', '2018-06-03', NULL, 'Město', '2018-06-03', NULL, 'Lesy', NULL, 'Kyblík', NULL, '', NULL, '2017-04-27 21:00:22', 0),
(12, 0, 'Blublu víkend', '', '2019-01-20', NULL, 'kdekoliv', '2019-01-22', NULL, '', NULL, 'Sekačku a želé', NULL, '', NULL, '2017-04-27 21:19:16', 0),
(13, 0, 'To už bychom tohle fakt měli mít hotový', '', '2017-09-01', NULL, 'Internet', '2017-09-01', NULL, 'Internet', NULL, 'Web', NULL, 'Tak co? jak nám to jde?', NULL, '2017-04-27 21:21:48', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`) VALUES
(1, 'Article Jedna', 'Lorem ipusm dolor JEDNA', '2016-11-23 22:23:42'),
(2, 'Article Two', 'Lorem ipsum dolor two', '2016-11-23 22:23:42'),
(3, 'Article Three', 'Lorem ipsum dolor three', '2016-11-23 22:23:42'),
(4, 'ASD', 'dasdas asdasdfg df', '2016-11-24 00:07:54'),
(5, 'ASDSAd', 'feweewf dadasdas dasdeer  er aew  wefrwaer we', '2016-11-24 00:08:57'),
(6, 'prihlaseny', 'adsasdasd', '2016-11-24 16:23:50'),
(7, 'Happy New Year!', 'HAhsljashdlalsdj dalksdj la, asdj.\nasjdsasdlkjlasjdlasdl aslkjd', '2017-01-04 17:26:32'),
(8, 'Nová Databáze', 'Jmenuje se Kalahari!! :D A konečně funguje!', '2017-01-05 14:04:51');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `nickname`, `firstname`, `surname`) VALUES
(1, 'tygger@skaut.cz', '$2y$10$vm4dGXNZyymy2YUEGnTKluNOXvZUgmS6RLbagJxSMWZ1lfBi9fBYO', 'admin', 'Tygr', 'Martin', 'Kolář'),
(4, 'bobsak@asd.f', '$2y$10$2EyRBh8Jd1FnkYOvmo.x9e7aia6cfGe98SlJTJyLKme4jRCU0W5US', 'guest', 'Bobánek', 'Bob', 'Bob'),
(10, 'kalahari@skauting.cz', '$2y$10$rQrJLcDHLR3o6Dtlwa.6nO0yK/0cBRWesRWR9lrbcga9IFIjbrbRu', 'member', 'Kalahar', 'Kalahar', 'von Kalahari');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Klíče pro tabulku `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pro tabulku `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pro tabulku `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
