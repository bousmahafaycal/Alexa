-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 12 Mai 2016 à 00:02
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `alexa`
--

-- --------------------------------------------------------

--
-- Structure de la table `Article`
--

CREATE TABLE `Article` (
  `id` int(11) NOT NULL,
  `moderation` tinyint(1) NOT NULL,
  `invisibleAuteur` tinyint(1) NOT NULL,
  `affiche` tinyint(1) NOT NULL,
  `idModerateur` int(11) NOT NULL,
  `idAuteur` int(11) NOT NULL,
  `gratuit` tinyint(1) NOT NULL,
  `image` text NOT NULL,
  `titre` varchar(255) NOT NULL,
  `corps` text NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Article`
--

INSERT INTO `Article` (`id`, `moderation`, `invisibleAuteur`, `affiche`, `idModerateur`, `idAuteur`, `gratuit`, `image`, `titre`, `corps`, `idCategorie`, `date_creation`) VALUES
(1, 0, 0, 0, 2, 2, 0, '0.jpg', 'Fayçal a eu 15 en progra', 'C''est pas bien !!! Tu dois t''améliorer...', 1, '2016-04-05 00:00:00'),
(2, 1, 0, 1, 2, 2, 0, '', 'Fayçal est trop fort', 'C''est vrai ! tout le monde le dit', 1, '2016-04-07 00:00:00'),
(4, 1, 1, 0, 2, 1, 0, '', 'Bonjour', 'llslslsls', 1, '2016-04-08 00:00:00'),
(8, 1, 1, 1, 16, 0, 0, '', 'Titre fort', '', 0, '0000-00-00 00:00:00'),
(12, 1, 0, 1, 16, 2, 0, '', 'Massacre', 'Nizet est un pigeon', 0, '0000-00-00 00:00:00'),
(19, 1, 0, 1, 16, 2, 0, '', 'Hala réal', 'Nous esperons tous que le réal gagne la ligue des champions , n''est-ce pas Paul ?', 5, '0000-00-00 00:00:00'),
(55, 1, 0, 1, 0, 2, 0, '55.jpeg', 'Pour faire pleuvoir, les Emirats décident de construire une montagne', 'blablabla', 3, '2016-05-06 15:17:12'),
(59, 1, 0, 1, 0, 2, 0, '59.jpg', 'L''eau et le feu', 'L''eau et le feu blablabla', 4, '2016-05-09 02:25:21'),
(60, 0, 0, 0, 0, 2, 1, '60.jpg', 'ali x', 'blablabla', 1, '2016-05-09 15:00:24'),
(61, 0, 1, 0, 0, 32, 0, '61.jpeg', 'Aa', 'aaa', 1, '2016-05-09 18:21:00'),
(62, 0, 0, 0, 0, 32, 0, '0.jpg', 'Alibabab', 'aaaa', 1, '2016-05-09 19:12:34'),
(63, 1, 0, 1, 0, 2, 0, '63.jpeg', 'Bien choisir son vidéo projecteur', 'Un projecteur est un dispositif permettant de reproduire, par projection lumineuse et grâce à une lampe de projecteur, des images ou même un film sur un écran de réception prévu à cet effet, ou bien sur une surface murale blanche. Un peu tombé en désuétude ces dernières années avec l''avènement des écrans plats et des téléviseurs LCD et LED, le vidéoprojecteur nouvelle génération fait son come back et offre des possibilités incroyables, notamment en matière de home cinéma. De fait, les ventes pour ce type de matériel ne cessent d''augmenter, et on en trouve désormais divers modèles, tirant partie des dernières technologies pour nous offrir une qualité d''image absolument splendide.\r\n\r\nIl existe divers modèles de projecteurs, chacun fonctionnant avec différents types de lampes de projecteur. En voici les principaux représentants :\r\n\r\nLe vidéoprojecteur LCD (Liquid Crystal Display), qui fonctionne grâce à la technologie des cristaux liquides, offre l''avantage d''être le modèle de projecteur le moins onéreux du marché, en tous cas pour le modèle mono LCD de base. La technologie des cristaux liquides, découverte dans les années 90, évolue constamment pour nous offrir des applications de plus en plus pointues. Ainsi utilisée au départ pour les écrans, cette technologie a été détournée pour réaliser des projecteurs vidéo de grande qualité. La lampe de projecteur utilisée est une lampe à vapeur de métal, qui traverse un ou plusieurs panneaux LCD affichant les couleurs primaires avant d''atteindre le support sur lequel l''image sera projetée. Sur le modèle mono LCD, qui ne comporte qu''un seul panneau équipé de filtres, la résolution est moins importante que sur un modèle tri LCD qui, comme son nom l''indique, compte trois panneaux au lieu d''un, ce qui a également pour effet de multiplier la résolution. On trouvera désormais surtout des projecteurs fonctionnant selon le principe du tri LCD, dont on pourra aisément remplacer la lampe vidéoprojecteur qui, il faut bien l''admettre, est assez fragile.\r\n\r\nLes projecteurs DLP (Digital Light Processing) ou DMD (Digital Micromirror Device), qui offrent une qualité d''image supérieure à celle des projecteurs LCD, utilisent une technologie basée sur des milliers de micro miroirs qui réfléchissent ou bloquent la lumière. Inventée par Texas Instruments, la technologie DLP permet une image de bonne luminosité, sans effet de pixellisation, et un rendu des teintes foncées que les projecteurs LCD ont toujours du mal à atteindre. Ces projecteurs sont par contre beaucoup plus chers, la lampe projecteur est fragile, et l''appareil produit une chaleur très importante nécessitant un système de refroidissement souvent bruyant.\r\n\r\nEnfin, la technologie tri CRT (tri-tubes), repose sur l''utilisation de trois tubes cathodiques, chacun représentant une couleur primaire. C''est avec ce modèle de projecteur qu''on obtient l''image la plus lumineuse et la durée de vie des tubes est excellente. Malgré que ce type de projecteur soit le mieux adapté à un home cinéma, il est encore peu utilisé en raison de son prix et de son encombrement. Le dispositif produit en fait trois images, qui sont ensuite superposées sur le support de projection, permettant de projeter le résultat à plus de 10 mètres. On comprendra donc que les vrais amateurs de cinéma souhaitent dédier une pièce entière à leur installation et y mettre le prix !\r\n\r\nVous avez besoin de nouvelles lampes de projecteur pour votre projecteur multimédia ? Visitez la boutique en ligne de Projector Lamps World, qui propose toutes les références de lampe projecteur 100% d''origine et obtenues directement auprès du fabricant. Pour plus de visite http://www.projectorlampsworld.fr\r\n\r\nSource: http://www.libre-article.fr', 4, '2016-05-10 22:58:03');

-- --------------------------------------------------------

--
-- Structure de la table `ArticlePaye`
--

CREATE TABLE `ArticlePaye` (
  `id` int(11) NOT NULL,
  `idPersonne` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ArticlePaye`
--

INSERT INTO `ArticlePaye` (`id`, `idPersonne`, `idArticle`) VALUES
(12, 37, 63);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `accroche` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Categorie`
--

INSERT INTO `Categorie` (`id`, `titre`, `accroche`) VALUES
(1, 'Economie', 'C''est la catégorie fourre-tout'),
(2, 'People', ''),
(3, 'Politique', ''),
(4, 'Sciences', ''),
(5, 'Sport', '');

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE `Commentaire` (
  `id` int(11) NOT NULL,
  `idModerateur` int(11) NOT NULL,
  `affiche` tinyint(1) NOT NULL,
  `moderation` tinyint(1) NOT NULL,
  `invisibleAuteur` tinyint(1) NOT NULL,
  `idArticle` int(11) NOT NULL,
  `corps` text NOT NULL,
  `date_commentaire` datetime NOT NULL,
  `idAuteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Commentaire`
--

INSERT INTO `Commentaire` (`id`, `idModerateur`, `affiche`, `moderation`, `invisibleAuteur`, `idArticle`, `corps`, `date_commentaire`, `idAuteur`) VALUES
(1, 2, 1, 1, 0, 1, 'Ceci est un avis éclairé', '2016-04-06 15:00:00', 2),
(2, 2, 0, 1, 0, 1, 'DAAAAAAMN DANNIEL', '2016-04-06 17:34:00', 1),
(3, 2, 1, 1, 0, 2, 'Mais oui j''approuve !!!', '2016-04-06 00:00:00', 1),
(4, 2, 1, 1, 0, 1, 'Bonjour toto', '2016-04-17 01:15:35', 2),
(5, 2, 1, 1, 0, 4, 'C''est nul Paul ! Je m''attendais à mieux de ta part', '2016-04-17 01:19:39', 2),
(6, 2, 0, 1, 0, 1, 'Exemple de commentaire', '2016-04-17 19:56:55', 2),
(8, 2, 1, 1, 1, 1, 'Souhel a une coupe ..', '2016-04-25 15:19:32', 2),
(9, 2, 1, 1, 0, 20, 'Alibababa\r\n', '2016-05-02 16:22:20', 2),
(10, 2, 1, 1, 0, 1, 'allo', '2016-05-05 21:01:08', 2),
(11, 2, 1, 1, 0, 34, 'abba', '2016-05-05 22:28:52', 2),
(12, 2, 1, 1, 0, 55, 'aaaa', '2016-05-06 17:31:26', 2),
(13, 2, 1, 1, 0, 60, 'asssss', '2016-05-09 15:00:41', 2),
(14, 0, 0, 0, 0, 1, 'allelouia', '2016-05-10 14:44:04', 2),
(15, 2, 1, 1, 0, 19, 'alibaba', '2016-05-10 15:43:03', 2),
(16, 2, 1, 1, 0, 63, 'aaaaloo', '2016-05-11 00:44:45', 2),
(17, 0, 0, 0, 0, 63, 'qmmsss', '2016-05-11 00:51:30', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

CREATE TABLE `Personne` (
  `id` int(11) NOT NULL,
  `supprime` tinyint(1) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `sexe` int(11) NOT NULL,
  `droit` int(11) NOT NULL,
  `email` text NOT NULL,
  `motDePasse` text NOT NULL,
  `signature` text NOT NULL,
  `points` int(11) NOT NULL,
  `pointCumule` int(11) NOT NULL,
  `style` int(11) NOT NULL,
  `styleMobile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Personne`
--

INSERT INTO `Personne` (`id`, `supprime`, `nom`, `prenom`, `pseudo`, `image`, `sexe`, `droit`, `email`, `motDePasse`, `signature`, `points`, `pointCumule`, `style`, `styleMobile`) VALUES
(1, 1, 'Monties', 'Paul', 'Daycopo', '0.jpg', 0, 2, '', '42fa5f0a03d7f5fd1cf6d58b834641df6a559485', 'Droit au but', 200, 200, 0, 0),
(2, 0, 'Bousmaha', 'Fayçal', 'Fawassel', '2.jpg', 0, 3, 'faycal.bousmaha.fac@gmail.com', '1be30c4c04f7b6fb3e4122c2c4f83872b721c1d9', 'Fayçal est le meilleur !', 200, 200, 0, 0),
(3, 0, 'Bousmaha', 'Wassel', 'alibaba', '', 0, 0, 'wassel2005@gmail.com', '4465ff26d8e4b02113b69ac1c0ab0d7d4dd12189', 'signature', 200, 200, 0, 0),
(4, 0, 'Benkaci', 'Mounia', 'Moon Forceuse', '', 1, 0, 'moon@gmail.com', '6e06aa113747ae27ea0856f89159af88adc0f94b', 'signature', 200, 200, 0, 0),
(5, 0, 'Bodin', 'Diane', 'Les Bodin''s', '', 1, 0, 'bodins@gmail.com', '590829d28822e2ec0d25f70330318db21394ad4a', 'signature', 200, 200, 0, 0),
(10, 0, 'Bousmaha', 'Wassel', 'Wassel', '', 0, 0, 'lol@gmail.com', '316c836165ff7fcf21e42b3110a443b1b68ac919', 'signature', 200, 200, 0, 0),
(15, 0, 'Lopes', 'Stephanie', 'Steph', '', 1, 0, 'steph@gmail.com', 'bf5cf299ce6ad0978a1465386899de8d6e61819d', 'signature', 200, 200, 0, 0),
(16, 0, 'moderateur', 'moderateur', 'moderateur', '', 0, 1, 'moderateur@gmail.com', 'f1b9f75822c22f1e7e3f3f91aabfbcd795027963', 'signature', 200, 200, 0, 0),
(17, 0, 'php', 'ph', 'testPhoto', '0.jpg', 0, 0, 'aaaa@gmail.com', 'c455582f41f589213a7d34ccb3954c67476077da', 'signature', 200, 200, 0, 0),
(18, 0, 'Bous', 'Fay', 'Fawassel2', '0.jpg', 0, 0, 'fay@gmail.com', '34fb21d15946a55f05621e5275829ec517b2b441', 'signature', 200, 200, 0, 0),
(19, 0, 'image', 'image', 'TestImage', '0.jpg', 0, 0, 's@gmail.com', 'c455582f41f589213a7d34ccb3954c67476077da', 'signature', 200, 200, 0, 0),
(26, 0, 'pp', 'pp', 'pp', '0.jpg', 0, 0, 'pp@gmail.com', '6d3236ec3c88039ca534b81acad564e847ecb062', 'signature', 200, 200, 0, 0),
(27, 0, 'spp', 'spp', 'spp', '0.jpg', 0, 0, 'spp@gmail.com', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'signature', 200, 200, 0, 0),
(28, 0, 'd', 'sppd', 'sppd', '0.jpg', 0, 0, 'sppd@gmail.com', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'signature', 200, 200, 0, 0),
(29, 0, 'd', 'sppd', 'aa', '0.jpg', 0, 0, 'aa@gmail.com', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'signature', 200, 200, 0, 0),
(30, 0, 'd', 'sppd', 'aaa', '30.jpeg', 0, 0, 'aaa@gmail.com', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'signature', 200, 200, 0, 0),
(31, 0, 'ali', 'ali', 'ali', '31.jpg', 0, 0, 'ali@gmail.com', 'b42a6d93d796915222f6ffb2ffdd6137d93c1cdb', 'signature', 200, 200, 0, 0),
(32, 0, 'a', 'a', 'a', '32.jpg', 0, 0, 'a@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'signature', 200, 200, 0, 0),
(33, 0, 'a', 'a', 'az', '0.jpg', 0, 0, 'az@gmail.com', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'signature', 200, 200, 0, 0),
(34, 0, 'zz', 'zz', 'zz', '34.jpg', 0, 0, 'z@gmail.com', '395df8f7c51f007019cb30201c49e884b46b92fa', 'signature', 200, 200, 0, 0),
(35, 0, 'zzz', 'zzz', 'zzz', '35.jpeg', 0, 0, 'zzz@gmail.com', '395df8f7c51f007019cb30201c49e884b46b92fa', 'signature', 200, 200, 0, 0),
(36, 1, 'zzza', 'zzza', 'zzza', '36.jpeg', 0, 1, 'zzza@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'aaaa', 200, 200, 0, 0),
(37, 0, 'test', 'test', 'test', '37.jpeg', 0, 0, 'test@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'ballaaa', 190, 200, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Pouce`
--

CREATE TABLE `Pouce` (
  `id` int(11) NOT NULL,
  `idAuteur` int(11) NOT NULL,
  `idCommentaire` int(11) NOT NULL,
  `valeur` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Pouce`
--

INSERT INTO `Pouce` (`id`, `idAuteur`, `idCommentaire`, `valeur`) VALUES
(33, 2, 4, 1),
(34, 2, 5, 1),
(40, 2, 6, 1),
(41, 1, 1, 1),
(54, 1, 4, 0),
(55, 1, 2, 1),
(56, 2, 7, 0),
(57, 2, 8, 1),
(60, 2, 1, 0),
(61, 2, 9, 1),
(62, 2, 3, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Article`
--
ALTER TABLE `Article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ArticlePaye`
--
ALTER TABLE `ArticlePaye`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Personne`
--
ALTER TABLE `Personne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Pouce`
--
ALTER TABLE `Pouce`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Article`
--
ALTER TABLE `Article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT pour la table `ArticlePaye`
--
ALTER TABLE `ArticlePaye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `Personne`
--
ALTER TABLE `Personne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT pour la table `Pouce`
--
ALTER TABLE `Pouce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
