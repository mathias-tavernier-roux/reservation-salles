-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 05 déc. 2020 à 23:17
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservationsalles`
--

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES
(1, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(2, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(3, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(4, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(5, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(6, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(7, 'Gros test', 'hey', '2020-12-02 10:42:00', '2020-12-02 10:43:00', 1),
(8, 'Titre', 'test', '2020-12-02 13:00:00', '2020-12-02 15:00:00', 1),
(9, 'Titre', 'jhv', '2020-12-02 15:00:00', '2020-12-02 16:00:00', 1),
(11, 'Titre', 'pas conflit', '2020-12-02 16:00:00', '2020-12-02 19:00:00', 1),
(12, 'Fiesta', 'Grosse fiesta vendredi', '2020-12-04 10:00:00', '2020-12-04 18:00:00', 1),
(13, 'Jeudi ravioli', 'Grosse pose dej', '2020-12-03 12:00:00', '2020-12-03 14:00:00', 25),
(14, 'HOW TO', 'How to php', '2020-12-03 18:00:00', '2020-12-03 19:00:00', 1),
(15, 'Brunch', 'Brunch time', '2020-12-06 12:00:00', '2020-12-06 16:00:00', 1),
(16, 'Tennis', 'Tennis avec robin', '2020-12-05 08:00:00', '2020-12-05 12:00:00', 25),
(17, 'Pierre', 'Gvdkd', '2020-12-11 18:00:00', '2020-12-11 19:00:00', 1),
(18, 'Fin du monde', 'Haaaa', '2039-12-04 13:00:00', '2039-12-04 14:00:00', 1),
(19, 'test', 'test', '2020-12-18 13:00:00', '2020-12-18 16:00:00', 27),
(20, 't', 'y', '2020-12-18 16:00:00', '2020-12-18 18:00:00', 28);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(1, 'robin', '$2y$10$ykef4JZwTM11hjgZbuiUA.nOX3i0f7C6G359prF0/FRCHj800iZWe'),
(15, 'robions', '$2y$10$02ktI7WLL.Pap6w5EMM58OKo.IgSKe3H/r2psWn5vXGRUbTgkgRKu'),
(17, 'robinet', '$2y$10$zH1iCKarqT4zDfiXqm5Th.OtuLNW/lWt2bXVJ2Arq5WKVjnYsrugm'),
(18, 'caca', '$2y$10$Xg6nEEVSiVIJGCesTb.i9uFkGJ136qBvggGZdstJbWlYT519wKqMG'),
(19, 'tata', '$2y$10$WCYXnzCh7RTTAaizw7lOnOZuMQNCETxEvIDgMCzmZYx9nKbPABDHi'),
(20, '()', '()'),
(21, 'mouai', '$2y$10$GWBMqc.6pLPXw.SpUtfRy.iV7m0OwcnrB9URAIdysVDlRJxOnTkfS'),
(22, 'test123', '$2y$10$J0sIKK7xWuqjiTIcCzEFhOua2UNg9lBbYIEzKBOzqsCSk.YMprSFG'),
(23, 'huhu', '$2y$10$uKZAkIVFu30z4k7MjSVIEOh/uLbL.ZkvXYc0laWYLJmROXMWRS5zK'),
(24, 'coco', '$2y$10$P.k596kIkwEGEXrGw45AD.wTP3AStxLg36bJ3i6GyTY4g7dGUIBZ.'),
(25, 'cacao', '$2y$10$iAlEcs6s//jre0Xg.tUHU.ehQ09G/knBzJwGh/q0R/L1OCvpI43fm'),
(26, 'toto', '$2y$10$NldFMBaD0u/N57Nj9XvIQOXFGI.uDpLUOefGAARDolC1QqL.43nTC'),
(27, 'MH13', '$2y$10$x2uObpvWrixUrabYI83Hg.hf1l9UDVvVCl.GynvVF3OzCzxB/gUPS'),
(28, 'MH13300', 'df68887539d27c997babe25b76dcbe941a347e07e83f0084d88a4e02e1c8ab6a');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
