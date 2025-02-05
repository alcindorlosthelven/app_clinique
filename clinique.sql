-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 05 fév. 2025 à 13:53
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
  `id_medecin` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `date_prelevement` varchar(50) DEFAULT NULL,
  `payer` varchar(50) DEFAULT NULL,
  `indication` varchar(255) NOT NULL,
  `remarque` varchar(255) NOT NULL,
  `technicien` varchar(255) NOT NULL,
  `deverson` varchar(20) NOT NULL DEFAULT 'n/a',
  `exantus` varchar(20) NOT NULL DEFAULT 'n/a',
  `raison_suppression` varchar(255) NOT NULL DEFAULT 'n/a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `demmande_imagerie`
--

INSERT INTO `demmande_imagerie` (`id`, `id_patient`, `id_medecin`, `statut`, `date`, `date_prelevement`, `payer`, `indication`, `remarque`, `technicien`, `deverson`, `exantus`, `raison_suppression`) VALUES
(51, 7, '0', 'supprimer', '2024-12-04 12:23:16', 'n/a', 'oui', '0', '0', '0', '0', '0', 'raison 1'),
(52, 7, '0,12,11', 'n/a', '2024-12-04 13:03:15', 'n/a', 'oui', '0', '0', '0', '0', '0', '0');

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
  `id_demande` bigint(11) DEFAULT NULL,
  `id_imagerie` int(11) DEFAULT NULL,
  `prix` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `resultat` text,
  `remarque` text,
  `conclusion` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `examens_demande_imagerie`
--

INSERT INTO `examens_demande_imagerie` (`id`, `id_demande`, `id_imagerie`, `prix`, `statut`, `resultat`, `remarque`, `conclusion`) VALUES
(44, 51, 11, '150', 'n/a', 'n/a', 'n/a', 'n/a'),
(45, 52, 11, '150', 'n/a', 'n/a', 'n/a', 'n/a');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `heure` varchar(20) NOT NULL,
  `montant` varchar(20) NOT NULL,
  `rabais` varchar(50) NOT NULL,
  `montant_apres_rabais` varchar(50) NOT NULL,
  `contenue` text NOT NULL,
  `type` varchar(25) NOT NULL,
  `user` int(11) NOT NULL,
  `methode_paiement` varchar(110) NOT NULL,
  `note` varchar(255) NOT NULL,
  `monnaie` varchar(255) NOT NULL,
  `versement` varchar(20) NOT NULL,
  `balance` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`id`, `id_patient`, `date`, `heure`, `montant`, `rabais`, `montant_apres_rabais`, `contenue`, `type`, `user`, `methode_paiement`, `note`, `monnaie`, `versement`, `balance`) VALUES
(27, 6, '2024-10-25', '19:14:11', '150', '0', '150', '[{\"id\":null,\"id_demande\":45,\"id_imagerie\":\"11\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"150\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'cash', 'la note', '0', '', ''),
(28, 6, '2024-10-25', '19:47:08', '100', '0', '100', '[{\"id\":null,\"id_demande\":46,\"id_imagerie\":\"10\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"100\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'cash', '0', '0', '', ''),
(29, 6, '2024-10-29', '11:31:31', '150', '0', '150', '[{\"id\":null,\"id_demande\":47,\"id_imagerie\":\"11\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"150\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'cash', 'raerewr', '0', '', ''),
(30, 6, '2024-10-29', '13:00:43', '100', '0', '100', '[{\"id\":null,\"id_demande\":48,\"id_imagerie\":\"10\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"100\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'cash', '0', '0', '', ''),
(31, 7, '2024-12-02', '10:51:33', '150', '0', '150', '[{\"id\":null,\"id_demande\":\"50\",\"id_imagerie\":\"11\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"150\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'carte credit', '0', '0', '', ''),
(32, 7, '2024-12-04', '12:23:16', '150', '0', '150', '[{\"id\":null,\"id_demande\":51,\"id_imagerie\":\"11\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"150\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'cash', 'n/a', '0', '0', '0'),
(33, 7, '2024-12-04', '13:03:15', '150', '0', '150', '[{\"id\":null,\"id_demande\":52,\"id_imagerie\":\"11\",\"statut\":\"n\\/a\",\"resultat\":\"n\\/a\",\"remarque\":\"n\\/a\",\"prix\":\"150\",\"conclusion\":\"n\\/a\"}]', 'Categorie 1', 1, 'cash', 'n/a', '0', '0', '0');

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
(10, 'examens 1', 'examens 1', 2, '100', '100', 'htg', '0'),
(11, 'examens 2', 'examens 2', 2, '150', '150', 'htg', '0'),
(12, 'examens 3', 'examens 3', 2, '100', '100', 'htg', '0');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `produit` varchar(255) NOT NULL,
  `quantite` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `options` text NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `telephone` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `no_identite` varchar(20) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `code`, `nom`, `prenom`, `email`, `date_naissance`, `sexe`, `telephone`, `password`, `no_identite`, `balance`) VALUES
(6, '392145', 'alcindor', 'losthelven', 'alcindorlos@gmail.com', '2024-07-03', 'f', '37391567', '81dc9bdb52d04dc20036dbd8313ed055', '543465345434', 5701),
(7, '721410', 'pierre', 'judith', 'johndanger010@gmail.com', '2024-12-02', 'm', 'safsdfd', '81dc9bdb52d04dc20036dbd8313ed055', '543534543', 0);

-- --------------------------------------------------------

--
-- Structure de la table `personel_medical`
--

CREATE TABLE `personel_medical` (
  `id` int(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `specialiter` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personel_medical`
--

INSERT INTO `personel_medical` (`id`, `nom`, `prenom`, `telephone`, `email`, `password`, `specialiter`, `type`) VALUES
(11, 'junior', 'augustin', '5345345', 'adad@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'dafsdf', 'médecin'),
(12, 'judith', 'pierre', '54353254', 'serveurdediersgl@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'dsdafsdf', 'médecin radiologue'),
(13, 'medecin', 'externe', '654234324324324', 'a@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'medecin externe', 'médecin externe');

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
(1, 1, 'admin', 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'utilisateur', 'oui', 'oui'),
(17, 1, 'alcindor', 'losthelven', 'lalcindor39', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'utilisateur', 'non', '0'),
(18, 1, 'technicient', 'x', 'xtechnicient7', '81dc9bdb52d04dc20036dbd8313ed055', 'technicien', 'utilisateur', 'oui', '0'),
(19, 1, 'receptioniste', 'x', 'xreceptioniste22', '81dc9bdb52d04dc20036dbd8313ed055', 'réceptionniste', 'utilisateur', 'oui', '0'),
(20, 1, 'comptabilite', 'x', 'xcomptabilite7', '81dc9bdb52d04dc20036dbd8313ed055', 'comptabilité', 'utilisateur', 'oui', '0');

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
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `id_demande` (`id_demande`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_patient` (`id_patient`);

--
-- Index pour la table `imagerie`
--
ALTER TABLE `imagerie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_imagerie_categorie_examens_imagerie` (`id_categorie`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telephone` (`telephone`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `demmande_imagerie`
--
ALTER TABLE `demmande_imagerie`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `examens_demande_imagerie`
--
ALTER TABLE `examens_demande_imagerie`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `imagerie`
--
ALTER TABLE `imagerie`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `personel_medical`
--
ALTER TABLE `personel_medical`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Contraintes pour la table `examens_demande_imagerie`
--
ALTER TABLE `examens_demande_imagerie`
  ADD CONSTRAINT `examens_demande_imagerie_ibfk_1` FOREIGN KEY (`id_demande`) REFERENCES `demmande_imagerie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `imagerie`
--
ALTER TABLE `imagerie`
  ADD CONSTRAINT `FK_imagerie_categorie_examens_imagerie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_examens_imagerie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
