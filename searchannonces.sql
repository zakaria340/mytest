-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 06 Mars 2016 à 12:53
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `searchannonces`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE IF NOT EXISTS `tagsExtra` (
  `idTagsExtra` int(11) NOT NULL AUTO_INCREMENT,
  `idAnnonce` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  PRIMARY KEY (`idTagsExtra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tagsAnnonces` (
  `idTagAnnonces` int(11) NOT NULL AUTO_INCREMENT,
  `idAnnonce` int(11) NOT NULL,
  `idTags` int(11) NOT NULL,
  `Value` varchar(255) NOT NULL,
  PRIMARY KEY (`idTagAnnonces`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `annonces` (
  `idAnnonces` int(11) NOT NULL AUTO_INCREMENT,
  `idSite` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` int(11) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `extraKeywords` text NOT NULL,
  PRIMARY KEY (`idAnnonces`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `idSites` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `idFetchsAll` int(11) NOT NULL,
  `lastIdInsertId` int(11) NOT NULL,
  `prefix` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`idSites`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `sites`
--

INSERT INTO `sites` (`idSites`, `name`, `idFetchsAll`, `lastIdInsertId`, `prefix`, `logo`) VALUES
(1, 'avito', 4492092, 0, 1001, 'avito.png'),
(2, 'marocannonces', 4492609, 0, 1002, 'marocannonces.png'),
(3, 'wandaloo', 18678, 0, 1003, 'wandaloo.png'),
(4, 'Sarouty', 0, 0, 1004, 'sarouty.png');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `idTags` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idTags`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Contenu de la table `tags`
--

INSERT INTO `tags` (`idTags`, `name`, `slug`) VALUES
(1, 'Voitures', 'voitures'),
(2, 'INFORMATIQUE ET MULTIMEDIA', 'informatique-et-multimedia'),
(3, 'Téléphones', 'telephones'),
(4, 'Tablettes', 'tablettes'),
(5, 'Ordinateurs portables', 'ordinateurs-portables'),
(6, 'Ordinateurs de bureau', 'ordinateurs-de-bureau'),
(7, 'Accessoires informatique et Gadgets', 'accessoires-informatique-et-gadgets'),
(8, 'Jeux vidéo et Consoles', 'jeux-video-et-consoles'),
(9, 'Appareils photo et Caméras', 'appareils-photo-et-cameras'),
(10, 'Télévisions', 'televisions'),
(11, 'Image & Son', 'image-&-son'),
(12, 'VEHICULES', 'vehicules'),
(13, 'Motos', 'motos'),
(14, 'Studio', 'studio'),
(15, 'Appartement', 'appartement'),
(16, 'Villa', 'villa'),
(17, 'Duplex', 'duplex'),
(18, 'Terrain', 'terrain'),
(19, 'Vélos', 'velos'),
(20, 'Véhicules Professionnels', 'vehicules-professionnels'),
(21, 'Engins BTP', 'engins-btp'),
(22, 'Engins Agricole', 'engins-agricole'),
(23, 'Remorques et Caravanes', 'remorques-et-caravanes'),
(24, 'Camions', 'camions'),
(25, 'Autres', 'autres'),
(26, 'Bateaux', 'bateaux'),
(27, 'Pièces et Accessoires pour véhicules', 'pieces-et-accessoires-pour-vehicules'),
(28, 'IMMOBILIER', 'immobilier'),
(29, 'Appartements', 'appartements'),
(30, 'Maisons et Villas', 'maisons-et-villas'),
(31, 'Bureaux et Plateaux', 'bureaux-et-plateaux'),
(32, 'Magasins et Commerces', 'magasins-et-commerces'),
(33, 'Terrains et Fermes', 'terrains-et-fermes'),
(34, 'Autre Immobilier', 'autre-immobilier'),
(35, 'POUR LA MAISON ET JARDIN', 'pour-la-maison-et-jardin'),
(36, 'Electroménager et Vaisselles', 'electromenager-et-vaisselles'),
(37, 'Meubles et Décoration', 'meubles-et-decoration'),
(38, 'Jardin et Outils de bricolage', 'jardin-et-outils-de-bricolage'),
(39, 'HABILLEMENT ET BIEN ETRE', 'habillement-et-bien-etre'),
(40, 'Vêtements', 'vetements'),
(41, 'Chaussures', 'chaussures'),
(42, 'Montres et Bijoux', 'montres-et-bijoux'),
(43, 'Sacs et Accessoires', 'sacs-et-accessoires'),
(44, 'Vêtements pour enfant et bébé', 'vetements-pour-enfant-et-bebe'),
(45, 'Equipements pour enfant et bébé', 'equipements-pour-enfant-et-bebe'),
(46, 'Produits de beauté', 'produits-de-beaute'),
(47, 'LOISIRS ET DIVERTISSEMENT', 'loisirs-et-divertissement'),
(48, 'Sports et Loisirs', 'sports-et-loisirs'),
(49, 'Animaux', 'animaux'),
(50, 'Instruments de Musique', 'instruments-de-musique'),
(51, 'Art et Collections', 'art-et-collections'),
(52, 'Voyages et Billetterie', 'voyages-et-billetterie'),
(53, 'Films, Livres, Magazines', 'films,-livres,-magazines'),
(54, 'EMPLOI ET SERVICES', 'emploi-et-services'),
(55, 'Stages', 'stages'),
(56, 'Cours et Formations', 'cours-et-formations'),
(57, 'ENTREPRISES', 'entreprises'),
(58, 'Business et Affaires commerciales', 'business-et-affaires-commerciales'),
(59, 'Matériels Professionnels', 'materiels-professionnels'),
(60, 'Stocks et Vente en gros', 'stocks-et-vente-en-gros'),
(61, 'Articles de sport', 'articles-de-sport'),
(62, 'Materiel informatique', 'materiel-informatique'),
(63, 'Électroménager - Électronique', 'electromenager---electronique'),
(64, 'Autres Ventes', 'autres-ventes'),
(65, 'Téléphones Portables ', 'telephones-portables-'),
(66, 'PC bureaux - PC portables - Tablettes', 'pc-bureaux---pc-portables---tablettes'),
(67, 'Terrains constructibles', 'terrains-constructibles'),
(68, 'Villas - Maisons - Riads', 'villas---maisons---riads'),
(69, 'Location vacances', 'location-vacances'),
(70, 'Bureaux - Plateaux', 'bureaux---plateaux'),
(71, 'Studios', 'studios'),
(72, 'Articles bébé', 'articles-bebe');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE IF NOT EXISTS `villes` (
  `idVilles` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idVilles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Contenu de la table `villes`
--

INSERT INTO `villes` (`idVilles`, `name`, `slug`) VALUES
(1, 'Rabat', 'rabat'),
(2, 'Kénitra', 'kenitra'),
(3, 'Agadir', 'agadir'),
(4, 'Casablanca', 'casablanca'),
(5, 'Marrakech', 'marrakech'),
(6, 'Fès', 'fes'),
(7, 'Khouribga', 'khouribga'),
(8, 'Temara', 'temara'),
(9, 'Tanger', 'tanger'),
(10, 'Benslimane', 'benslimane'),
(11, 'Essaouira', 'essaouira'),
(12, 'Safi', 'safi'),
(13, 'Salé', 'sale'),
(14, 'El Jadida', 'el-jadida'),
(15, 'Meknès', 'meknes'),
(16, 'Oujda', 'oujda'),
(17, 'Tétouan', 'tetouan'),
(18, 'Béni Mellal', 'beni-mellal'),
(19, 'Taza', 'taza'),
(20, 'Al Hocïema', 'al-hociema'),
(21, 'Errachidia', 'errachidia'),
(22, 'Khénifra', 'khenifra'),
(23, 'Larache', 'larache'),
(24, 'Nador', 'nador'),
(25, 'Ouarzazate', 'ouarzazate'),
(26, 'Settat', 'settat'),
(27, 'Ain Aouda', 'ain-aouda'),
(28, 'Ain Harrouda', 'ain-harrouda'),
(29, 'Ait Baha', 'ait-baha'),
(30, 'Ait Melloul', 'ait-melloul'),
(31, 'Al Haouz', 'al-haouz'),
(32, 'Aousserd', 'aousserd'),
(33, 'Arfoud', 'arfoud'),
(34, 'Assa zag', 'assa-zag'),
(35, 'Assilah', 'assilah'),
(36, 'Azemmour', 'azemmour'),
(37, 'Azilal', 'azilal'),
(38, 'Azrou', 'azrou'),
(39, 'Ben Ahmed', 'ben-ahmed'),
(40, 'Figuig', 'figuig'),
(41, 'Asila', 'asila'),
(42, 'Dakhla', 'dakhla'),
(43, 'Boujdour', 'boujdour'),
(44, 'Mohammedia', 'mohammedia'),
(45, 'Tamesna', 'tamesna'),
(46, 'Ben Guerir', 'ben-guerir'),
(47, 'Berkane', 'berkane'),
(48, 'Berrechid', 'berrechid'),
(49, 'Bin El Ouidane', 'bin-el-ouidane'),
(50, 'Bir Jdid', 'bir-jdid'),
(51, 'Boujniba', 'boujniba'),
(52, 'Boulanouar', 'boulanouar'),
(53, 'Boulmane', 'boulmane'),
(54, 'Bouskoura', 'bouskoura'),
(55, 'Bousselham', 'bousselham'),
(56, 'Bouznika', 'bouznika'),
(57, 'Chefchaouen', 'chefchaouen'),
(58, 'Chichaoua', 'chichaoua'),
(59, 'Dar Chaffai', 'dar-chaffai'),
(60, 'Deroua', 'deroua'),
(61, 'El Borouj', 'el-borouj'),
(62, 'El Hajeb', 'el-hajeb'),
(63, 'El Harhoura', 'el-harhoura'),
(64, 'El Mansouria', 'el-mansouria'),
(65, 'El Gara', 'el-gara'),
(66, 'Es-Semara', 'es-semara'),
(67, 'Fnideq', 'fnideq'),
(68, 'Fquih Ben Saleh', 'fquih-ben-saleh'),
(69, 'Goulmima', 'goulmima'),
(70, 'Guelmim', 'guelmim'),
(71, 'Guercif', 'guercif'),
(72, 'Had Soualem', 'had-soualem'),
(73, 'Ifrane', 'ifrane'),
(74, 'Imouzzer', 'imouzzer'),
(75, 'Inzegan', 'inzegan'),
(76, 'Jamaat Shaim', 'jamaat-shaim'),
(77, 'Jrada', 'jrada'),
(78, 'Kelaat Es-Sraghna', 'kelaat-es-sraghna'),
(79, 'Khemisset', 'khemisset'),
(80, 'Ksar el-Kebir', 'ksar-el-kebir'),
(81, 'Ksar es-Seghir', 'ksar-es-seghir'),
(82, 'Lagouira', 'lagouira'),
(83, 'Lakhiaita', 'lakhiaita'),
(84, 'Laâyoune', 'laayoune'),
(85, 'Martil', 'martil'),
(86, 'Mediouna', 'mediouna'),
(87, 'Mehdia', 'mehdia'),
(88, 'Merzouga', 'merzouga'),
(89, 'Mdiq', 'mdiq'),
(90, 'Midelt', 'midelt'),
(91, 'Mirleft', 'mirleft');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
