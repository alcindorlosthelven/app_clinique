-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 09 juil. 2024 à 14:08
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `clinique`
--

-- --------------------------------------------------------

--
-- Structure de la table `acces`
--

CREATE TABLE `acces` (
  `acces` varchar(50) NOT NULL,
  `titre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acces_user`
--

CREATE TABLE `acces_user` (
  `id` bigint(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `acces` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_examens_imagerie`
--

CREATE TABLE `categorie_examens_imagerie` (
  `id` int(11) NOT NULL,
  `categorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie_examens_imagerie`
--

INSERT INTO `categorie_examens_imagerie` (`id`, `categorie`) VALUES
(3, 'Categorie -2'),
(2, 'Categorie 1');

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE `configuration` (
  `id` bigint(20) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `valeur` text,
  `categorie` enum('image','text','video','non_modifiable') DEFAULT 'image'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `configuration`
--

INSERT INTO `configuration` (`id`, `nom`, `valeur`, `categorie`) VALUES
(6, 'logo', 'app/DefaultApp/public/fichier/sgl.png', 'image'),
(7, 'background', 'app/DefaultApp/public/fichier/sgl_splashs.jpg', 'image'),
(8, 'transparence', '90', 'text'),
(22, 'sms_id', '4C4C286F-3E3F-4AE0-8F61-22A13FC9A567', 'text'),
(23, 'sms_secret', 'solz2579PzrfJKib+cIk+5eFEFlvk+OiSJhcXszdHqoVD37QwqRyjeMmjjofQe3P0fHrG0Y6DzafPE3vzDgOAw==', 'text'),
(24, 'theme', '2', 'text'),
(25, 'telehone', '+509 37391567', 'text'),
(26, 'whatstapp', '+509 37391567', 'text'),
(27, 'nom', 'SGL', 'text'),
(28, 'copyright', 'SGL', 'text'),
(29, 'address', 'Complex kayla , entre delmas 35 et 37', 'text');

-- --------------------------------------------------------

--
-- Structure de la table `demmande_imagerie`
--

CREATE TABLE `demmande_imagerie` (
  `id` bigint(10) NOT NULL,
  `id_patient` int(11) DEFAULT NULL,
  `id_imagerie` int(11) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `id_admision` varchar(50) DEFAULT NULL,
  `id_medecin` varchar(50) DEFAULT NULL,
  `id_medecin2` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_prelevement` varchar(50) DEFAULT NULL,
  `remarque` text,
  `no_dossier` varchar(50) DEFAULT NULL,
  `institution` varchar(50) DEFAULT NULL,
  `payer` varchar(50) DEFAULT NULL,
  `technicien` varchar(50) DEFAULT NULL,
  `indication` text,
  `id_assurance` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id`, `nom`, `logo`) VALUES
(1, 'CLINIQUE - 1', '');

-- --------------------------------------------------------

--
-- Structure de la table `examens_demande_imagerie`
--

CREATE TABLE `examens_demande_imagerie` (
  `id` bigint(10) NOT NULL,
  `id_demande` bigint(10) DEFAULT NULL,
  `id_imagerie` int(11) DEFAULT NULL,
  `prix` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `resultat` text,
  `remarque` text,
  `conclusion` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `imagerie`
--

CREATE TABLE `imagerie` (
  `id` int(10) NOT NULL,
  `nom` varchar(50) DEFAULT 'n/a',
  `nom_alternatif` varchar(50) DEFAULT 'n/a',
  `id_categorie` int(11) DEFAULT NULL,
  `prix` varchar(50) DEFAULT NULL,
  `cout` varchar(50) DEFAULT NULL,
  `devise` varchar(50) DEFAULT NULL,
  `principale` varchar(50) DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `imagerie`
--

INSERT INTO `imagerie` (`id`, `nom`, `nom_alternatif`, `id_categorie`, `prix`, `cout`, `devise`, `principale`) VALUES
(7, 'examens -2', 'examens -2', 3, '5000', '5000', 'htg', '0'),
(8, 'examens 3', 'examens 3', 2, '501', '500', 'htg', '0');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date_naissance` varchar(50) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personel_medical`
--

CREATE TABLE `personel_medical` (
  `id` int(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `identifiant` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL DEFAULT '1',
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `objet` varchar(50) DEFAULT NULL,
  `connect` enum('oui','non') DEFAULT 'non',
  `all_access` varchar(10) DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `id_entreprise`, `nom`, `prenom`, `pseudo`, `password`, `role`, `objet`, `connect`, `all_access`) VALUES
(1, 1, 'admin', 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '0', 'utilisateur', 'oui', 'oui');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acces`
--
ALTER TABLE `acces`
  ADD PRIMARY KEY (`acces`) USING BTREE;

--
-- Index pour la table `acces_user`
--
ALTER TABLE `acces_user`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_acces_user_utilisateur` (`id_user`) USING BTREE,
  ADD KEY `FK_acces_user_acces` (`acces`) USING BTREE;

--
-- Index pour la table `categorie_examens_imagerie`
--
ALTER TABLE `categorie_examens_imagerie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorie` (`categorie`);

--
-- Index pour la table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `demmande_imagerie`
--
ALTER TABLE `demmande_imagerie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_demmande_imagerie_patient` (`id_patient`),
  ADD KEY `FK_demmande_imagerie_imagerie` (`id_imagerie`),
  ADD KEY `FK_demmande_imagerie_categorie_examens_imagerie` (`id_categorie`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examens_demande_imagerie`
--
ALTER TABLE `examens_demande_imagerie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_demande_id_imagerie` (`id_demande`,`id_imagerie`),
  ADD KEY `FK_examens_demande_imagerie_imagerie` (`id_imagerie`);

--
-- Index pour la table `imagerie`
--
ALTER TABLE `imagerie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_imagerie_categorie_examens_imagerie` (`id_categorie`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `personel_medical`
--
ALTER TABLE `personel_medical`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `nom_prenom` (`nom`,`prenom`),
  ADD KEY `FK_utilisateur_entreprise` (`id_entreprise`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `acces_user`
--
ALTER TABLE `acces_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie_examens_imagerie`
--
ALTER TABLE `categorie_examens_imagerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `demmande_imagerie`
--
ALTER TABLE `demmande_imagerie`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `examens_demande_imagerie`
--
ALTER TABLE `examens_demande_imagerie`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `imagerie`
--
ALTER TABLE `imagerie`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personel_medical`
--
ALTER TABLE `personel_medical`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `acces_user`
--
ALTER TABLE `acces_user`
  ADD CONSTRAINT `FK_acces_user_acces` FOREIGN KEY (`acces`) REFERENCES `acces` (`acces`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_acces_user_utilisateur` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `imagerie`
--
ALTER TABLE `imagerie`
  ADD CONSTRAINT `FK_imagerie_categorie_examens_imagerie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_examens_imagerie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
