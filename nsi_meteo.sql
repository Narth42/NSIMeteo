-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 28 avr. 2023 à 14:49
-- Version du serveur : 10.3.38-MariaDB-0+deb10u1
-- Version de PHP : 7.3.31-1~deb10u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nsi_meteo`
--
CREATE DATABASE IF NOT EXISTS `nsi_meteo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nsi_meteo`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `cli_id` int(5) NOT NULL,
  `cli_nom` varchar(30) NOT NULL,
  `cli_prenom` varchar(30) NOT NULL,
  `cli_adresse` varchar(255) NOT NULL,
  `cli_mail` varchar(50) NOT NULL,
  `cli_tel` int(12) NOT NULL,
  `cli_mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `comm_id` int(5) NOT NULL,
  `comm_date` date NOT NULL,
  `comm_quantite` int(5) NOT NULL,
  `cli_id` int(5) NOT NULL,
  `prod_id` int(5) NOT NULL,
  `comm_etat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `prod_id` int(5) NOT NULL,
  `prod_nom` varchar(50) NOT NULL,
  `prod_prix` int(5) NOT NULL,
  `prod_provenance` varchar(30) NOT NULL,
  `prod_stock` int(5) NOT NULL,
  `prod_img` varchar(100) NOT NULL,
  `prod_desc` varchar(1000) NOT NULL,
  `type_id` int(11) NOT NULL,
  `nouveau` tinyint(1) NOT NULL,
  `special` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`prod_id`, `prod_nom`, `prod_prix`, `prod_provenance`, `prod_stock`, `prod_img`, `prod_desc`, `type_id`, `nouveau`, `special`) VALUES
(23, 'Parapluie Rouge', 10, 'France', 19, 'image/produit/umbrellaRed.png', 'Offrez-vous une protection Ã©lÃ©gante contre la pluie avec notre parapluie rouge vif. Avec sa toile impermÃ©able en polyester de haute qualitÃ©, ce parapluie vous gardera au sec mÃªme pendant les averses les plus intenses.', 20, 0, 0),
(24, 'Casquette Bleu', 12, 'Italie', 17, 'image/produit/capBlue.png', 'Mettez votre style en avant tout en vous protÃ©geant du soleil avec notre casquette bleue Ã©lÃ©gante. FabriquÃ©e en coton de haute qualitÃ©, cette casquette offre un confort optimal pour une utilisation prolongÃ©e.', 21, 0, 0),
(25, 'Bottes de pluie Rose', 15, 'France', 8, 'image/produit/bootsPink.png', 'Cette paire de bottes de pluie roses est dotÃ©e d\'un design Ã©lÃ©gant qui s\'adapte Ã  tous les styles vestimentaires. Que vous cherchiez des bottes de pluie pour accompagner une tenue dÃ©contractÃ©e ou pour ajouter une touche de couleur Ã  une tenue plus habillÃ©e sous la pluie, cette paire de bottes roses est un choix parfait pour toutes les occasions.', 23, 0, 0),
(26, 'Parapluie Orange', 20, 'Allemagne', 22, 'image/produit/umbrellaOrange.png', 'Voici notre tout nouveau parapluie ! ConÃ§u pour vous garder au sec tout en ajoutant une touche de style Ã  votre garde-robe, ce parapluie est le compagnon idÃ©al pour affronter les jours de pluie. Ce parapluie est fabriquÃ© Ã  partir de matÃ©riaux de qualitÃ© supÃ©rieure pour garantir une longue durÃ©e de vie.', 20, 1, 0),
(27, 'Casquette Rouge', 22, 'France', 13, 'image/produit/capRed.png', 'ConÃ§ue pour ajouter une touche de couleur vive Ã  votre tenue, cette casquette est le choix parfait pour les amateurs de style. FabriquÃ©e Ã  partir de matÃ©riaux de qualitÃ© supÃ©rieure, cette casquette est lÃ©gÃ¨re et confortable Ã  porter toute la journÃ©e. Que vous cherchiez une casquette pour accompagner une tenue dÃ©contractÃ©e ou pour ajouter une touche de couleur Ã  une tenue plus habillÃ©e, cette casquette rouge est un choix parfait pour toutes les occasions.', 21, 0, 0),
(28, 'Lunettes de Soleil Vertes', 75, 'France', 16, 'image/produit/sunglassesGreen.png', 'Les lunettes de soleil vertes sont un choix Ã©lÃ©gant pour ceux qui cherchent Ã  ajouter une touche de couleur Ã  leur garde-robe d\'Ã©tÃ©. Avec des verres teintÃ©s, ces lunettes protÃ¨gent vos yeux des rayons UV nocifs tout en vous donnant un look branchÃ©.', 22, 0, 0),
(29, 'Lunettes de Soleil Bleues', 92, 'Allemagne', 24, 'image/produit/sunglassesBlue.png', 'DÃ©couvrez les nouvelles lunettes de soleil bleues, le parfait mÃ©lange de style, de confort et de protection pour vos yeux. InspirÃ©es par les profondeurs envoÃ»tantes et les reflets scintillants de l\'ocÃ©an, ces lunettes de soleil sont l\'accessoire idÃ©al pour complÃ©ter votre look estival.', 22, 1, 0),
(31, 'Veste Orange', 130, 'France', 6, 'image/produit/jacketOrange.png', 'La veste orange est une crÃ©ation, alliant sophistication, qualitÃ© et style inÃ©galÃ©. ConÃ§ue pour les amateurs de mode Ã  la recherche d\'une piÃ¨ce unique et luxueuse, cette veste est l\'expression ultime de l\'Ã©lÃ©gance contemporaine. Ne manquez pas cette occasion unique de vous offrir la orange, une piÃ¨ce d\'exception qui rehaussera votre style et attirera tous les regards.', 20, 1, 0),
(32, 'Pin\'s NSI MÃ©tÃ©o', 1, 'France', 42, 'image/produit/logoPins.png', 'DÃ©couvrez notre magnifique pin NSI MÃ©tÃ©o, l\'accessoire parfait pour tous les passionnÃ©s de mÃ©tÃ©orologie ! Avec sa conception Ã©lÃ©gante et de haute qualitÃ©, ce pin est le complÃ©ment idÃ©al pour toutes vos tenues. Le pin reprÃ©sente le logo de la marque NSI MÃ©tÃ©o, qui est synonyme d\'excellence en matiÃ¨re de prÃ©visions mÃ©tÃ©orologiques. Avec ce pin, vous pouvez afficher votre passion pour les sciences mÃ©tÃ©orologiques et montrer votre soutien Ã  cette marque de renom.', 25, 0, 1),
(33, 'Lunettes de Soleil - Ã‰clipse solaire', 112, 'France', 14, 'image/produit/sunGlassesLimited.png', 'DÃ©couvrez nos lunettes de soleil Ã‰clipse solaire en Ã©dition limitÃ©e, un accessoire de mode incontournable pour tous les amateurs de style ! Avec leur design unique et exclusif, ces lunettes de soleil feront de vous une personne Ã  part, distinguÃ©e parmi les autres. Les lunettes de soleil sont fabriquÃ©es Ã  partir de matÃ©riaux de qualitÃ© supÃ©rieure pour garantir leur durabilitÃ© et leur rÃ©sistance aux rayures. Les verres polarisÃ©s offrent une protection contre les rayons UV nocifs du soleil, tout en amÃ©liorant la clartÃ© et la qualitÃ© visuelle.', 22, 0, 1),
(34, 'Casquette - Storm Chaser', 35, 'Angleterre', 22, 'image/produit/capLimited.png', 'DÃ©couvrez notre casquette exclusive Storm Chaser, une Ã©dition limitÃ©e pour les passionnÃ©s de mÃ©tÃ©o et les amateurs de mode ! Avec son design unique et sa touche de technologie, cette casquette sera le complÃ©ment parfait pour toutes vos tenues. La casquette est Ã©quipÃ©e d\'une hÃ©lice qui tourne avec le vent, pour ajouter une touche de mouvement et de dynamisme Ã  votre look. Elle est fabriquÃ©e Ã  partir de matÃ©riaux de haute qualitÃ© pour garantir sa durabilitÃ© et son confort, avec un ajustement parfait grÃ¢ce Ã  la bande de rÃ©glage Ã  l\'arriÃ¨re.', 21, 1, 1),
(35, 'Parapluie - MÃ©tÃ©o Froggy', 26, 'Allemagne', 2, 'image/produit/umbrellaLimited.png', 'DÃ©couvrez notre magnifique parapluie MÃ©tÃ©o Froggy en Ã©dition limitÃ©e, l\'accessoire parfait pour affronter les jours de pluie avec style ! Avec son design original et amusant, ce parapluie fera sensation oÃ¹ que vous alliez. Le parapluie est conÃ§u pour rÃ©sister aux intempÃ©ries grÃ¢ce Ã  sa structure solide et Ã  sa toile impermÃ©able de haute qualitÃ©. Il est Ã©galement Ã©quipÃ© d\'une poignÃ©e ergonomique pour un confort de transport optimal.', 20, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `support`
--

CREATE TABLE `support` (
  `sup_id` int(5) NOT NULL,
  `sup_sujet` varchar(100) NOT NULL,
  `sup_message` varchar(1000) NOT NULL,
  `sup_nom` varchar(50) NOT NULL,
  `sup_mail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `type_id` int(5) NOT NULL,
  `type_nom` varchar(30) NOT NULL,
  `type_desc` varchar(1000) NOT NULL,
  `type_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`type_id`, `type_nom`, `type_desc`, `type_img`) VALUES
(20, 'Parapluie', 'Accessoire de protection contre la pluie et les intempÃ©ries, pratique et indispensable lors des jours de pluie pour se protÃ©ger des gouttes d\'eau et rester au sec.', 'image/produit/umbrellaBlue.png'),
(21, 'Casquette', 'Accessoire de mode qui se porte sur la tÃªte pour protÃ©ger le visage et les yeux du soleil, souvent porte par les sportifs pour protÃ©ger leurs yeux et leur visage pendant les activitÃ©s en extÃ©rieur, mais Ã©galement par les personnes qui cherchent a se protÃ©ger du soleil tout en restant elegantes.', 'image/produit/capGreen.png'),
(22, 'Lunettes de Soleil', 'Les lunettes de soleil sont des accessoires qui protÃ¨gent les yeux de la lumiÃ¨re intense et des rayons UV nocifs du soleil. Les lunettes de soleil sont Ã©galement un accessoire de mode populaire et tendance, pouvant ajouter une touche de style et d\'Ã©lÃ©gance Ã  votre look.', 'image/produit/sunglassesOrange.png'),
(23, 'Bottes de pluie', 'Les bottes de pluie sont des chaussures spÃ©cialement conÃ§ues pour protÃ©ger les pieds de la pluie et des intempÃ©ries. Les bottes de pluie sont des chaussures pratiques et fonctionnelles qui vous permettront de profiter de vos activitÃ©s en extÃ©rieur mÃªme lorsqu\'il pleut.', 'image/produit/bootsPink.png'),
(24, 'Veste', 'VÃªtement d\'extÃ©rieur qui se porte par-dessus les vÃªtements pour protÃ©ger contre les intempÃ©ries et les tempÃ©ratures fraÃ®ches. VÃªtement polyvalent qui convient Ã  toutes les occasions et toutes les saisons.', 'image/produit/jacketRed.png'),
(25, 'LogoPins', 'Pin\'s NSI MÃ©tÃ©o, l\'accessoire parfait pour tous les passionnÃ©s de mÃ©tÃ©orologie ! Avec sa conception Ã©lÃ©gante et de haute qualitÃ©, ce pin est le complÃ©ment idÃ©al pour toutes vos tenues.', 'image/produit/logoPins.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`cli_id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`comm_id`),
  ADD KEY `cli_id` (`cli_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Index pour la table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`sup_id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `cli_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `comm_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `prod_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `support`
--
ALTER TABLE `support`
  MODIFY `sup_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
