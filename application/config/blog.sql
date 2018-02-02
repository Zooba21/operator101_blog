-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Ven 02 Février 2018 à 15:51
-- Version du serveur :  5.7.21-0ubuntu0.17.10.1
-- Version de PHP :  7.1.11-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `categoryName`) VALUES
(1, 'Général'),
(2, 'front'),
(3, 'developpement'),
(4, ''),
(5, 'php'),
(6, 'Javascript');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `commentContent` mediumtext NOT NULL,
  `reported` enum('0','1','2') NOT NULL DEFAULT '0',
  `commentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `userId`, `postId`, `commentContent`, `reported`, `commentDate`) VALUES
(1, 1, 17, '  Génial !', '0', '2018-01-10 17:09:29'),
(2, 2, 17, 'Trop bien !', '2', '2018-01-11 18:21:39');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `redactorId` int(11) NOT NULL,
  `postTitle` varchar(100) NOT NULL,
  `postResume` varchar(500) NOT NULL,
  `postContent` longtext NOT NULL,
  `postThumbnail` varchar(100) DEFAULT NULL,
  `categoryId` int(11) NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `redactorId`, `postTitle`, `postResume`, `postContent`, `postThumbnail`, `categoryId`, `creationDate`, `modificationDate`) VALUES
(17, 1, 'Op&eacute;rator 101 : qu\'est-ce que c\'est ?', 'Tout sur la philosophie du blog et &agrave; quoi il est destin&eacute; !                                                                                                                                                                ', '<p>Ce blog est destin&eacute; &agrave; &eacute;changer entre d&eacute;veloppeurs ! Vos r&eacute;ussites, vos anecdotes, partager un projet qui vous tient &agrave; coeur o&ugrave; sur lequel vous avez rencontr&eacute; des difficult&eacute;s, bref : tout ce que vous voulez.&nbsp;</p><p>C&#39;est donc un blog d&#39;&eacute;change, alors : &eacute;changez ! <span class=\"fr-emoticon fr-deletable fr-emoticon-img\" style=\"background: url(https://cdnjs.cloudflare.com/ajax/libs/emojione/2.0.1/assets/svg/1f60b.svg);\">&nbsp;</span></p><p>On change la photo pour voir</p>', '/images/posts/thumbnail/17.png', 4, '2018-01-06 12:07:06', '2018-01-06 12:07:06'),
(18, 1, 'Le second article', 'Cr&eacute;er un blog, c\'est comment ?                ', '<p>Cr&eacute;er un blog, c&#39;est assez amusant ! Il faut penser &agrave; beaucoup de choses ! Vous en saurez plus bient&ocirc;t ;) test</p>', '/images/posts/thumbnail/18.png', 1, '2018-01-06 16:51:13', '2018-01-06 16:51:13');

-- --------------------------------------------------------

--
-- Structure de la table `postImages`
--

CREATE TABLE `postImages` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `alt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `avatarUrl` varchar(100) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `inscriptionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rights` enum('banned','user','redactor','moderator','administrator') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `lastName`, `firstName`, `mail`, `password`, `avatarUrl`, `phone`, `inscriptionDate`, `rights`) VALUES
(1, 'Masi', 'Albane', 'albane.martinelli@gmail.com', 'tijuana23', '/images/user/1.jpeg', '0695411186', '2018-01-03 12:01:50', 'administrator'),
(2, 'Benjamin', 'Masi', 'benjamin.masi45@gmail.com', 'taratata26', NULL, '0624845824', '2018-01-11 17:58:14', 'user');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `postId` (`postId`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `redactorId` (`redactorId`),
  ADD KEY `category` (`categoryId`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`redactorId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
