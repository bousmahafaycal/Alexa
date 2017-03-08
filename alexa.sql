
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 15 Mai 2016 à 11:34
-- Version du serveur: 10.0.20-MariaDB
-- Version de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `u107615049_alexa`
--

-- --------------------------------------------------------

--
-- Structure de la table `Article`
--

CREATE TABLE IF NOT EXISTS `Article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `Article`
--

INSERT INTO `Article` (`id`, `moderation`, `invisibleAuteur`, `affiche`, `idModerateur`, `idAuteur`, `gratuit`, `image`, `titre`, `corps`, `idCategorie`, `date_creation`) VALUES
(1, 1, 0, 1, 1, 1, 0, '1.jpg', 'La biométrie : enjeux et avenir', '\r\nLa mondialisation à permis d''accroître le volume des communications internationales. Ces dernières se sont diversifiées : déplacement physique, transaction financière, accès aux services... Cette forte croissance oblige les entreprises à s''équiper de systèmes fiables, permettant d''identifier les individus. Car plus les enjeux sont importants, plus les risques de fraude sont élevés. Il est donc tout à fait normal de constater, depuis quelques années, un intérêt grandissant pour les systèmes d''identification et d''authentification. \r\n\r\nUn système de sécurité fiable et efficace\r\n\r\nLa plupart des systèmes d''authentification présents sur le marché souffrent d''un gros défaut : ils nécessitent l''utilisation d''un identifiant externe tel qu''un badge, une carte, une clé ou un code...  Avec ce type de système on identifie l''objet et non la personne elle-même. Ces informations sont donc susceptibles d''être falsifiées et utilisées à mauvais escient. Les technologies biométriques de reconnaissance apportent un niveau de sécurité extrêmement élevé, tout en étant compatibles avec les systèmes de reconnaissance classiques. Elles sont de plus, applicables à un vaste champ d''applications : login sur ordinateur, contrôle d''accès, paiement sécurisé sur Internet, gestion horaire, etc...\r\n\r\n \r\n\r\nQuels sont les usages de la biométrie ?\r\n\r\n \r\n\r\nLa biométrie permet d''identifier et d''authentifier un individu à partir de critères reconnaissables et vérifiables, qui n''appartiennent qu''à lui. Il existe différents types de systèmes biométriques. En effet, tous,  ne se basent pas sur les mêmes données pour authentifier une personne. Certaines systèmes utilisent des critères biologiques de type : odeur, salive, urine, etc... pour identifier un individu. D''autres prennent en compte des données en rapport avec le comportement individuel : la manière d''utiliser un clavier, la dynamique d''une signature (vitesse de déplacement du stylo...), la voix, la façon de marcher, etc... Enfin, certains systèmes biométriques  analysent la morphologique des individus : réseau veineux, empreintes digitales, traits du visage... Ces différents éléments sont réputés pour être infalsifiables. De plus, ils ont l''avantage de changer assez peu dans la vie d''une personne.\r\n\r\n \r\n\r\nL''engouement des entreprises pour la biométrie\r\n\r\n\r\nLa biométrie est encore peu présente dans notre société. Pourtant, tout laisse à penser qu''elle a de beaux jours devant elle. La technologie biométrique améliore notre capacité à identifier une personne et permet de se protéger contre la fraude ou le vol. Elle se base sur la reconnaissance des caractéristiques physiques d''un individu. Ces dernières ne peuvent être changées, perdues ou volées, et c''est là son principal avantage. C''est d''ailleurs ce qui explique l''intérêt grandissant des entreprises pour cette technologie. Première entreprise française à avoir lancée sur le marché un dispositif de contrôle d''accès par reconnaissance du réseau veineux du doigt, SafeTIC s''est toujours intéressée de près à cette technologie. Lancé sur le marché, en février 2009, son système BIOVEIN a été développé en collaboration avec le fabricant Hitachi. Il permet une sécurisation sans faille des accès puisqu''il se base sur la reconnaissance de la seule signature corporelle infalsifiable : le réseau veineux.\r\n\r\n-----------------\r\nPour en savoir plus sur la biométrie, contactez-nous !\r\nhttp://www.safetic.eu/\r\n\r\nSource: www.fruitymag.com\r\n', 4, '2016-05-14 22:08:33'),
(2, 1, 0, 1, 0, 1, 0, '2.jpg', 'Taxe foncière : Qui doit payer la taxe foncière ?', 'La Taxe Foncière est un impôt obligatoire qui doit être payé par le propriétaire une fois par an. Si le bien immobilier est en location, le locataire doit s''affranchir de la taxe d''habitation mais pas de la taxe foncière.\r\n\r\nIl existe plusieurs taxes foncières. Ce texte traite uniquement de la taxe foncière sur les propriétés bâties.\r\n\r\nLa taxe foncière est redevable par le propriétaire au 1er janvier de l''année d''imposition. Si la propriété est vendue après le 1er janvier, le propriétaire peut se faire rembourser la partie de la taxe foncière au prorata. Mais dans tous les cas le propriétaire au 1er janvier doit payer la totalité de la taxe foncière. A noter que le remboursement éventuel doit être précisé sur l''acte de vente. De la même manière un nouvel acquéreur payera la totalité de la taxe foncière l''année suivante.\r\n\r\nQu''appelle-t-on propriété bâtie ?\r\nLes constructions à caractère de véritables bâtiments.\r\nLes installations commerciales ou industrielles destinées à abriter des personnes ou du matériel.\r\nLes bateaux utilisés comme habitation.\r\nCertains terrains considérés comme des dépendances de constructions.\r\n\r\nDans certains cas précis, les constructions peuvent être exonérées de façon permanente ou temporaire de taxe foncière.\r\nDe façon permanente :\r\nLes bâtiments agricoles ou les collectivités publiques et les bâtiments du service hospitalier public.\r\n\r\nDe façon temporaire :\r\nLes constructions neuves sont exonérées de taxe foncière pendant 2 ans à partir de l''achèvement des travaux.\r\nLes constructions dont les travaux ont été financés par des prêts de l''Etat à plus de 50% sont exonérées de taxe foncière pendant 10 ans ( prêts PAP ) ou 15 ans ( Prêts locatifs aidés ). A noter que pour les prêts à taux 0%, l''exonération est impossible.\r\nD''autres cas particuliers sont précisés sur le CGI ( Code Général des Impôts ).\r\n\r\nCertaines personnes peuvent être exonérées de la taxe foncière. Il s''agit :\r\nDes titulaires de l''allocation de la Sécurité Sociale.\r\nDes titulaires de l''allocation aux adultes handicapés.\r\nDes personnes âgées de plus de 75 ans.\r\nDans ces cas précis, le revenu fiscal de référence de 2006 ne doit pas dépasser le plafond de 9437 euros. De plus, l''exonération n''est effective que si ces personnes cohabitent uniquement avec leur conjoint ou des personnes à charge dont le revenu ne dépasse pas cette somme.\r\n\r\nPlus d''informations sur la fiscalité immobilière sur le site:\r\nhttp://www.placement-immo.com\r\nSource: http://www.libre-article.fr', 1, '2016-05-14 22:21:06'),
(3, 1, 0, 1, 1, 1, 1, '3.jpg', 'La taxe d''habitation : Qui doit payer la taxe d''habitation ?', 'La Taxe d''Habitation doit être payée par toute personne qui dispose d''un local imposable, c''est-à-dire un local dont il a la jouissance à titre privatif à tout moment, au 1er janvier de l''année d''imposition. \r\nUn local imposable est soumis à la taxe d''habitation lorsqu''il s''agit soit de logement, parking, remise, garage, soit de jardin, cour, terrasse dont le contribuable en possède la jouissance de manière privative.\r\n\r\nCertaines situations permettent d''être exonérés de la taxe d''habitation. \r\nIl s''agit d''abord des locaux soumis à la taxe professionnelle comme les boutiques, les bâtiments ruraux ou encore les logements des élèves dans les pensionnats. \r\n\r\nPour les particuliers dont le logement est la résidence principale, la taxe d''habitation subit un abattement obligatoire par exemple pour les enfants à charge, ou un abattement facultatif s''il s''agit de personnes aux revenus modestes.\r\n\r\nL''exonération totale de la taxe d''habitation est possible dans certains cas :\r\nPour les personnes âgées de plus de 60 ans\r\nOu veufs ou veuves\r\nOu titulaires de l''allocation spéciale du Fonds de Solidarité Vieillesse ou de l''allocation aux adultes handicapés\r\nOu titulaires du RMI\r\nDes conditions de plafond de revenus sont aussi exigées pour une exonération totale de la taxe d''habitation : Il convient au contribuable de ne pas dépasser 9437 euros de revenu annuel auxquels s''ajoutent 2520 euros par demi part supplémentaire.\r\n\r\nA noter que depuis l''année 2005, la redevance audiovisuelle est rattachée à la taxe d''habitation quel que soit le nombre de dispositif permettant la réception de la télévision. La déclaration de la redevance audiovisuelle se fait en même temps que celle concernant la taxe d''habitation. L''exonération de la taxe d''habitation permet l''exonération de la redevance audiovisuelle.\r\n\r\nLa taxe d''habitation concerne donc tous les contribuables qui disposent d''un logement à titre privatif. Hormis les cas pour lesquels l''exonération est totale, la taxe d''habitation est un impôt qui n''est pas en rapport avec les revenus des personnes concernées. Les derniers gouvernements successifs ont tous laissé entendre une mesure qui consisterait à envisager cette relation entre les revenus et l''habitation. \r\n\r\nIl ne reste plus qu''à attendre tranquillement chez soi !\r\n\r\nVous avez besoin d''aide pour déclarer vos impôts? Alors visitez le site de l''auteur:\r\nhttp://www.placement-immo.com\r\n\r\nSource: http://www.libre-article.fr', 1, '2016-05-14 22:30:42'),
(4, 1, 0, 1, 1, 1, 0, '4.jpg', 'Bourde de Sarkozy sur Twitter : son étonnante réponse', 'Voilà une gaffe que Nicolas Sarkozy aurait sans doute préféré éviter devant des entrepreneurs venus à sa rencontre. Cette semaine, lors d''un échange avec des patrons lyonnais, l''ancien président s''est retrouvé dans l''embarras après qu''un de ses interlocuteurs a déclaré : « Nous recrutons beaucoup grâce au Bon Coin. » Interrogation immédiate de Nicolas Sarkozy : « C''est quoi, Le Bon Coin ? ». Une bourde qui aurait pu passer inaperçue, mais qui a été largement relayée sur les réseaux sociaux grâce aux journalistes présents. Un manque de connaissance qui a valu à l''ancien président de nombreuses moqueries sur les réseaux sociaux et qui, à quelques mois de la primaire à droite, a renforcé l''impression de rupture qui existe entre les politiques et le monde de l''entrepreneuriat. Voire de la société tout court, vu l''importance qu''a pris ce site dans la vie quotidienne des Français, ne serait-ce que pour acheter un meuble ou jouet d''occasion.\r\n\r\nSa réponse sur Twitter :\r\n\r\nConscient de sa bourde, surtout en période de crise de l''emploi, Nicolas Sarkozy a utilisé son compte Twitter ce vendredi, pour rebondir et répondre à ses détracteurs. « Qui ne connaît pas Le Bon Coin ? Et si nous parlions d''emploi ensemble @leboncoin ? ». Un tweet destiné à éteindre l''incendie allumé avec sa petite phrase.\r\n\r\nCe à quoi leboncoin a répondu : \r\n\r\n@NicolasSarkozy C''est avec plaisir que nous parlerons d''emploi avec vous. Venez nous rencontrer qd vs le souhaitez.\r\n\r\nNS a répondu : Avec grand plaisir @leboncoin. Rdv dans vos locaux. -NS.\r\n\r\nAffaire rondement menée par l''ancien président de la République!', 3, '2016-05-15 10:23:35'),
(5, 0, 0, 0, 0, 1, 0, '5.jpg', 'Toulouse, une équipe miraculée ?', 'aaa', 5, '2016-05-15 10:25:21'),
(6, 1, 0, 1, 2, 2, 0, '6.jpg', 'Red Hot Chili Peppers : Anthony Kiedis hospitalisé d''urgence !', 'Pour l''heure, les représentants de l''artiste n''ont pas précisé de quoi il souffre...\r\n\r\nInvité par la station de radio KROQ à se produire lors du concert Weenie Roast, le 14 mai 2016, le groupe Red Hot Chili Peppers a été contraint d''annuler sa prestation en raison de problèmes de santé du chanteur Anthony Kiedis...\r\nComme le rapporte la presse américaine, le chanteur s''est plaint d''intenses douleurs à l''estomac quelques heures à peine avant de monter sur la scène du concert, qui se tenait à Irvine, en Californie. Anthony Kiedis a donc été transporté d''urgence à l''hôpital en ambulance, mais la nature exacte de ce dont il souffre n''a pas encore été dévoilée. L''annonce de l''annulation s''est faite sur la scène du Irvine Meadows Amphitheatre, devant les 16 000 spectateurs. C''est Flea, son complice au sein des Red Hot Chili Peppers, qui l''a annoncé en disant que le groupe était "dévasté" par cette annulation de dernière minute.\r\n\r\nLes spectateurs ont tout de même pu applaudir les autres participants, parmi lesquels Panic! at the Disco, Empire of the Sun, Garbage, Lumineers, Fitz and the Tantrums and Miike Snow, Blink-182...\r\n\r\nCette mésaventure intervient quelques jours seulement après l''annonce du grand retour en France des Red Hot Chili Peppers, qui sont attendus à la rentrée. Ils donneront notamment deux dates à l''AccorHotels Arena de Paris, les 15 et 16 octobre 2016.', 2, '2016-05-15 10:39:41'),
(7, 1, 0, 1, 2, 2, 0, '7.jpg', 'Stéphane Bern : La médecine esthétique... Il y pense !', 'Stéphane Bern n''est pas opposé à une petite retouche pour se faire retirer les poches sous les yeux...\r\nCe samedi 14 mai dès 21h sur France 2, Stéphane Bern commentera en compagnie de Marianne James la grande finale de l''Eurovision 2016. Bien entendu, les deux animateurs sont parmi les plus fervents supporters d''Amir Haddad, révélé par The Voice 3, qui représente notre beau pays au concours européen de la chanson. \r\n\r\nDans une interview accordée à Télé 7 Jours (en kiosques le lundi 16 mai), Stéphane Bern fait quelques confidences sur ce qu''il serait prêt à faire par amour... Faire une croix sur ses amis ? "Certainement pas." Faire annuler son titre de chevalier accordé par la reine Elizabeth II ? "Oh non ! Elizabeth II passe au-dessus de tout !" Changer de métier ? Non plus. La chirurgie esthétique n''est pas une option non plus. \r\n\r\nCependant, Stéphane Bern peut concevoir la médecine esthétique "par respect pour le public". Comprenez : pour garder une image agréable à l''écran. "D''ailleurs, j''aimerais bien me faire enlever les poches sous les yeux", confie l''animateur qui officie tous les jours sur RTL avec A la bonne heure ! entre 11h et 12h30.\r\nUNE RENTRÉE PLEINE DE CHANGEMENTS\r\nC''est désormais acté, Stéphane Bern ne reviendra pas pour une huitième saison de son magazine de milieu d''après-midi, Comment ça va bien !, sur France 2. La chaîne publique, qui bouleverse totalement sa grille et prépare un lifting de fond en comble en vue de la rentrée prochaine, n''a pas souhaité prolonger l''aventure CCVB avec Stéphane Bern. \r\n\r\nCependant, très fière des audiences réalisées par Secrets d''Histoire (à retrouver en prime time le mardi 17 mai pour un nouveau numéro consacré au Général de Gaulle), France 2 a choisi de proposer l''émission en hebdomadaire tout l''été. \r\n\r\nEt ce n''est pas tout, aux dernières nouvelles, la chaîne songerait même à une adaptation en quotidienne à la rentrée pour Secrets d''Histoire. De plus, Stéphane Bern serait sur le point d''obtenir un divertissement coprésenté par Amanda Scott, que l''on retrouve chaque semaine dans Du côté de chez Dave.', 2, '2016-05-15 10:43:44');

-- --------------------------------------------------------

--
-- Structure de la table `ArticlePaye`
--

CREATE TABLE IF NOT EXISTS `ArticlePaye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPersonne` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `ArticlePaye`
--

INSERT INTO `ArticlePaye` (`id`, `idPersonne`, `idArticle`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 3, 1),
(5, 4, 2),
(6, 5, 2),
(7, 4, 1),
(8, 1, 4),
(9, 1, 5),
(10, 7, 4),
(11, 2, 6),
(12, 2, 7),
(13, 9, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE IF NOT EXISTS `Categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `accroche` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Categorie`
--

INSERT INTO `Categorie` (`id`, `titre`, `accroche`) VALUES
(1, 'Economie', ''),
(2, 'People', ''),
(3, 'Politique', ''),
(4, 'Sciences', ''),
(5, 'Sport', '');

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE IF NOT EXISTS `Commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idModerateur` int(11) NOT NULL,
  `affiche` tinyint(1) NOT NULL,
  `moderation` tinyint(1) NOT NULL,
  `invisibleAuteur` tinyint(1) NOT NULL,
  `idArticle` int(11) NOT NULL,
  `corps` text NOT NULL,
  `date_commentaire` datetime NOT NULL,
  `idAuteur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `Commentaire`
--

INSERT INTO `Commentaire` (`id`, `idModerateur`, `affiche`, `moderation`, `invisibleAuteur`, `idArticle`, `corps`, `date_commentaire`, `idAuteur`) VALUES
(1, 1, 1, 1, 0, 2, 'C''est un article que je trouve assez intéressant. Tout le monde devrait être mieux informé au niveau de la fiscalité ...', '2016-05-14 22:23:22', 1),
(2, 1, 1, 1, 0, 1, 'La biométrie, c''est l''avenir !', '2016-05-14 22:25:05', 1),
(3, 1, 1, 1, 0, 3, 'Intéressant...', '2016-05-14 22:31:12', 1),
(4, 1, 1, 1, 0, 2, 'J''adore ce site, vive l''Irlande et la Guiness', '2016-05-15 09:18:08', 4),
(5, 1, 1, 1, 0, 2, 'Ah les taxes ...', '2016-05-15 09:18:21', 5),
(6, 1, 1, 1, 0, 1, 'J''adore la biométrie!', '2016-05-15 09:19:55', 4),
(7, 1, 1, 1, 0, 2, 'C''est vraiment incroyable!', '2016-05-15 09:27:36', 1),
(8, 2, 1, 1, 0, 4, 'Excellent!', '2016-05-15 10:30:16', 2),
(10, 2, 1, 1, 0, 4, 'Vive les frites', '2016-05-15 10:31:37', 7),
(11, 2, 1, 1, 0, 4, 'Rangi, veuillez vous calmer.', '2016-05-15 10:32:03', 2),
(12, 2, 1, 1, 0, 4, 'La droite c''est nul', '2016-05-15 10:32:42', 7),
(13, 2, 1, 1, 0, 4, 'Rangi, que diriez vous d''une photo de profil?', '2016-05-15 10:34:48', 2),
(14, 1, 1, 1, 0, 4, 'J''approuve @Rangi la droite c''est nul !!', '2016-05-15 10:35:10', 1),
(15, 1, 1, 1, 0, 3, 'J''ai pas de sous\r\n', '2016-05-15 10:35:47', 7),
(16, 1, 1, 1, 0, 1, 'La biométrie c''est bien, le basket c''est mieux \r\n', '2016-05-15 10:36:52', 7),
(17, 1, 1, 1, 0, 2, 'J''ai toujours pas de sous \r\n', '2016-05-15 10:37:16', 7),
(18, 1, 1, 1, 0, 1, 'Je ne suis pas d''accord ', '2016-05-15 10:38:58', 8),
(19, 1, 1, 1, 0, 2, 'Ce qui est bien, @rangi, c''est que vous pouvez parcourir tout notre site sans sortir une seule fois votre carte bleu ...', '2016-05-15 10:39:44', 1),
(20, 1, 1, 1, 0, 4, 'C''est toi Paul qui se cache derrière Daycopo?', '2016-05-15 10:44:12', 8),
(21, 2, 1, 1, 0, 4, 'EH OUI EH OUI', '2016-05-15 10:49:20', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

CREATE TABLE IF NOT EXISTS `Personne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `styleMobile` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `Personne`
--

INSERT INTO `Personne` (`id`, `supprime`, `nom`, `prenom`, `pseudo`, `image`, `sexe`, `droit`, `email`, `motDePasse`, `signature`, `points`, `pointCumule`, `style`, `styleMobile`) VALUES
(1, 0, 'Bousmaha', 'Fayçal', 'Fawassel', '1.jpeg', 0, 3, 'faycal.bousmaha.fac@gmail.com', '556ee49643921e0c263b96e1264cb52278cf25e4', 'Lorsqu''on veut on peut.\r\nProverbe malgache', 320, 320, 1, 1),
(3, 0, 'Nadji', 'Iliès', 'IliesNj', '0.jpg', 0, 0, 'ilies.nadji@gmail.com', '6b718819b95cc036748596759591b912bdae9a67', '', 199, 200, 1, 1),
(2, 0, 'Monties', 'Paul', 'Daycopo', '2.jpg', 0, 3, 'paul.monties@orange.fr', '531082c99de9b856e75db4ca02ab48a9c15f6f23', 'Droit au but!', 260, 260, 1, 1),
(4, 0, 'OConnel', 'Paul', 'OConnel', '4.jpg', 0, 2, 'paul.monties@wanadoo.fr', '531082c99de9b856e75db4ca02ab48a9c15f6f23', 'Mdr allez allez', 198, 200, 1, 1),
(5, 0, 'Bousmaha', 'Wassel', 'wassiloon', '5.jpg', 0, 1, 'wassel05@gmail.com', '4465ff26d8e4b02113b69ac1c0ab0d7d4dd12189', 'Les echecs, un jeu de roi !', 199, 200, 1, 1),
(6, 0, 'Dodard', 'Vivien', 'viviwrc', '0.jpg', 0, 0, 'vivien.dodard@hotmail.fr', 'efa32f21186ff3be3af1024846e7ed0004491c43', '', 200, 200, 1, 1),
(7, 0, 'Jayasuriya Kuranage Perera ', 'Ranga', 'Rangi', '0.jpg', 0, 0, 'ranga.jaya@hotmail.fr', 'e52b5a9329418e56262a0d8946ee0ef7d960a5c3', '', 199, 200, 1, 1),
(8, 0, 'ben', 'Mounia ', 'moon', '0.jpg', 1, 0, 'mounia.m@gmail.com', 'e3e08675ff2b4b95d09ebd6772a568a3e616edb2', 'MB', 200, 200, 2, 1),
(9, 0, 'Bard', 'Nicolas', 'chidoran', '0.jpg', 0, 0, 'ytub_chidoran@hotmail.fr', 'b6afe10b5987e4ce994d58b69879f3926fb95ac8', '', 199, 200, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Pouce`
--

CREATE TABLE IF NOT EXISTS `Pouce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idAuteur` int(11) NOT NULL,
  `idCommentaire` int(11) NOT NULL,
  `valeur` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `Pouce`
--

INSERT INTO `Pouce` (`id`, `idAuteur`, `idCommentaire`, `valeur`) VALUES
(1, 4, 2, 1),
(2, 4, 6, 0),
(3, 1, 4, 1),
(4, 1, 6, 1),
(5, 1, 2, 1),
(6, 1, 1, 1),
(10, 1, 3, 1),
(9, 1, 5, 0),
(11, 2, 10, 0),
(12, 2, 11, 1),
(18, 8, 2, 0),
(14, 2, 13, 1),
(15, 1, 11, 0),
(16, 1, 8, 1),
(17, 1, 10, 0),
(19, 8, 10, 1),
(20, 2, 8, 1),
(21, 1, 21, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
