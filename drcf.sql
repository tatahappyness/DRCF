-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 17 mai 2019 à 02:35
-- Version du serveur :  5.7.23
-- Version de PHP :  7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `drcf`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectation_dossier`
--

CREATE TABLE `affectation_dossier` (
  `id` int(4) NOT NULL,
  `affect_dos_enreg_be_livre_num` int(4) NOT NULL,
  `affect_dos_enreg_be_num` varchar(15) DEFAULT NULL,
  `affect_dos_date_crea` datetime DEFAULT NULL,
  `affect_dos_user_id` int(4) DEFAULT NULL,
  `affect_dos_user_id_exp` int(4) DEFAULT NULL,
  `affect_dos_etat` tinyint(1) DEFAULT NULL,
  `affect_dos_etat_acceptation` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `affectation_dossier`
--

INSERT INTO `affectation_dossier` (`id`, `affect_dos_enreg_be_livre_num`, `affect_dos_enreg_be_num`, `affect_dos_date_crea`, `affect_dos_user_id`, `affect_dos_user_id_exp`, `affect_dos_etat`, `affect_dos_etat_acceptation`) VALUES
(1, 345, '019', '2019-05-06 15:52:09', 6, 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `distribution_dossier`
--

CREATE TABLE `distribution_dossier` (
  `id` int(11) NOT NULL,
  `dist_dos_enreg_be_id_id` int(11) NOT NULL,
  `dist_dos_user_id_id` int(11) NOT NULL,
  `dist_dos_date_crea` datetime NOT NULL,
  `dist_dos_action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dist_dos_date_envoi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `distribution_dossier`
--

INSERT INTO `distribution_dossier` (`id`, `dist_dos_enreg_be_id_id`, `dist_dos_user_id_id`, `dist_dos_date_crea`, `dist_dos_action`, `dist_dos_date_envoi`) VALUES
(129, 60, 2, '2019-05-06 03:42:35', 'Lire', NULL),
(130, 59, 2, '2019-05-06 03:43:26', 'Lire', NULL),
(131, 58, 2, '2019-05-06 03:44:09', 'Lire', NULL),
(135, 59, 6, '2019-05-06 16:43:54', 'Verifier', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrement_be`
--

CREATE TABLE `enregistrement_be` (
  `id` int(11) NOT NULL,
  `enreg_be_user_id_id` int(11) NOT NULL,
  `enreg_be_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enreg_be_date` date NOT NULL,
  `enreg_be_serv_titulaire` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enreg_be_contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enreg_beobserve` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enreg_be_date_crea` datetime NOT NULL,
  `enreg_be_livre_num` int(11) NOT NULL,
  `enreg_be_serv_lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enreg_be_etat_lire` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_verifier` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_rejeter` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_viser` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_visa` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_verif_after_rejet` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_vise_after_rejet` tinyint(1) DEFAULT NULL,
  `enreg_be_etat_between_deleg_chek` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `enregistrement_be`
--

INSERT INTO `enregistrement_be` (`id`, `enreg_be_user_id_id`, `enreg_be_num`, `enreg_be_date`, `enreg_be_serv_titulaire`, `enreg_be_contenu`, `enreg_beobserve`, `enreg_be_date_crea`, `enreg_be_livre_num`, `enreg_be_serv_lieu`, `enreg_be_etat_lire`, `enreg_be_etat_verifier`, `enreg_be_etat_rejeter`, `enreg_be_etat_viser`, `enreg_be_etat_visa`, `enreg_be_etat_verif_after_rejet`, `enreg_be_etat_vise_after_rejet`, `enreg_be_etat_between_deleg_chek`) VALUES
(58, 2, '021', '2019-05-03', 'DRREN', 'Desicision membres de commission pour le Testing des  Sujets d\'examen des sujets', 'POUR VISA', '2019-05-06 03:23:55', 343, 'TOLIARA', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 2, '019', '2019-05-03', 'DREN', 'Décision de Travaux de Suivi et Contrôle a l\'examen ', 'POUR VISA', '2019-05-06 03:34:12', 345, 'TOLIARA', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 2, '020', '2019-05-03', 'DREN', 'Décision portant désignation des membres de Commission d’Élaboration des sujets d\'examen BEPC-session 2019 ', 'POUR VISA', '2019-05-06 03:37:59', 344, 'TOLIARA', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrement_def`
--

CREATE TABLE `enregistrement_def` (
  `id` int(11) NOT NULL,
  `enreg_def_user_id_id` int(11) NOT NULL,
  `enreg_def_enreg_be_livre_num` int(4) DEFAULT NULL,
  `enreg_def_num` int(11) DEFAULT NULL,
  `enreg_def_objet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enreg_def_titulaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enreg_def_montant` double DEFAULT NULL,
  `enreg_def_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enreg_def_date_crea` datetime DEFAULT NULL,
  `enreg_def_visa` int(11) DEFAULT NULL,
  `enreg_def_motif_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enreg_def_motif_desc` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enreg_def_etat_viser` tinyint(1) DEFAULT NULL,
  `enreg_def_etat_rejeter` tinyint(1) DEFAULT NULL,
  `enreg_def_etat_vise_after_reject` tinyint(1) DEFAULT NULL,
  `enreg_def_date_paraphe` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enregistrement_tef`
--

CREATE TABLE `enregistrement_tef` (
  `id` int(4) NOT NULL,
  `enreg_tef_user_id` int(4) NOT NULL,
  `enreg_tef_enreg_be_livre_num` int(4) NOT NULL,
  `enreg_tef_enreg_be_num` varchar(15) DEFAULT NULL,
  `enreg_tef_num` varchar(10) DEFAULT NULL,
  `enreg_tef_objet` varchar(10) DEFAULT NULL,
  `enreg_tef_num_visa` varchar(100) DEFAULT NULL,
  `enreg_tef_date` date DEFAULT NULL,
  `enreg_tef_date_crea` datetime DEFAULT NULL,
  `enreg_tef_etat` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `enregistrement_visa`
--

CREATE TABLE `enregistrement_visa` (
  `id` int(11) NOT NULL,
  `enreg_visa_user_id_id` int(11) NOT NULL,
  `enreg_visa_enreg_be_id_id` int(11) NOT NULL,
  `enreg_visa_livre_num` int(11) DEFAULT NULL,
  `enreg_visa_livre_date_crea` datetime DEFAULT NULL,
  `enreg_visa_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enreg_visa_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lecture_dossier`
--

CREATE TABLE `lecture_dossier` (
  `id` int(11) NOT NULL,
  `lect_dos_enreg_be_id_id` int(11) NOT NULL,
  `lect_dos_user_id_id` int(11) NOT NULL,
  `lect_dos_situation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lect_dos_paraphe_date_crea` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lecture_dossier`
--

INSERT INTO `lecture_dossier` (`id`, `lect_dos_enreg_be_id_id`, `lect_dos_user_id_id`, `lect_dos_situation`, `lect_dos_paraphe_date_crea`) VALUES
(13, 60, 2, '', '2019-05-06'),
(14, 59, 2, '', '2019-05-06'),
(15, 58, 2, '', '2019-05-06');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20190214100731');

-- --------------------------------------------------------

--
-- Structure de la table `mouvement_historique`
--

CREATE TABLE `mouvement_historique` (
  `id` int(4) NOT NULL,
  `mouv_histo_enreg_be_livre_num` int(4) NOT NULL,
  `mouv_histo_enreg_be_num` varchar(15) DEFAULT NULL,
  `mouv_histo_exp` varchar(255) DEFAULT NULL,
  `mouv_histo_dest` varchar(255) DEFAULT NULL,
  `mouv_histo_type` varchar(100) DEFAULT NULL,
  `mouv_histo_date_envoi_crea` datetime DEFAULT NULL,
  `mouv_histo_date_retour_crea` datetime DEFAULT NULL,
  `mouv_histo_date_reception_crea` datetime DEFAULT NULL,
  `mouv_histo_etat_envoi` tinyint(1) DEFAULT NULL,
  `mouv_histo_etat_retour` tinyint(1) DEFAULT NULL,
  `mouv_histo_etat_reception` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mouvement_historique`
--

INSERT INTO `mouvement_historique` (`id`, `mouv_histo_enreg_be_livre_num`, `mouv_histo_enreg_be_num`, `mouv_histo_exp`, `mouv_histo_dest`, `mouv_histo_type`, `mouv_histo_date_envoi_crea`, `mouv_histo_date_retour_crea`, `mouv_histo_date_reception_crea`, `mouv_histo_etat_envoi`, `mouv_histo_etat_retour`, `mouv_histo_etat_reception`) VALUES
(1, 345, '019', '6', NULL, 'ENVOI_AU_DELEGUE', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rejeter_dossier`
--

CREATE TABLE `rejeter_dossier` (
  `id` int(11) NOT NULL,
  `rejet_dos_enreg_be_id_id` int(11) NOT NULL,
  `rejet_dos_user_id` int(11) NOT NULL,
  `rejet_dos_date_crea` datetime NOT NULL,
  `rejet_dos_motif_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rejet_dos_motif_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `im` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `img`, `im`) VALUES
(2, 'admin', 'ADMIN_USER', '$2y$10$A6qlapCztxFYM3EMSD618.Ygkfs8b7O6P098e1hUc5bTj9SZqQED6', NULL, 123456),
(4, 'florent', 'ROLE_USER', '$2y$10$Zk56o92mv/BkmxiQVioLludnaqlMjeJxLOs.qAIA5TcBie6SOcyjG', NULL, 348806399),
(5, 'zaza', 'ROLE_USER', '$2y$10$yYEhvS3dIinCN.YKjzIl5OYQ0ZASHWrgCe4/tiwmQLUy2p1BaMb7q', NULL, 432156),
(6, 'toto', 'ROLE_USER', '$2y$10$kNyBzubxzzZCGm4Cw6b8pOcS/iOvbDu/PGySYDmKmxPI.vJq4.p6.', NULL, 98765);

-- --------------------------------------------------------

--
-- Structure de la table `verification_dossier`
--

CREATE TABLE `verification_dossier` (
  `id` int(11) NOT NULL,
  `verif_dos_enreg_be_id_id` int(11) NOT NULL,
  `verif_dos_user_id_id` int(11) NOT NULL,
  `verif_dos_mode_pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_date_et_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_num_compt` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_intitule_activ_prest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_realise_pysique` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_montant` float DEFAULT NULL,
  `verif_dos_visa_cf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_cas_possible` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_dos_date_crea` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `verification_dossier`
--

INSERT INTO `verification_dossier` (`id`, `verif_dos_enreg_be_id_id`, `verif_dos_user_id_id`, `verif_dos_mode_pass`, `verif_dos_date_et_num`, `verif_dos_num_compt`, `verif_dos_intitule_activ_prest`, `verif_dos_realise_pysique`, `verif_dos_montant`, `verif_dos_visa_cf`, `verif_dos_cas_possible`, `verif_dos_date_crea`) VALUES
(1, 59, 6, '', '', '', '', '', 0, '', 'Choisir...', '2019-05-06 16:43:54');

-- --------------------------------------------------------

--
-- Structure de la table `viser_dossier`
--

CREATE TABLE `viser_dossier` (
  `id` int(11) NOT NULL,
  `vise_dos_user_id_id` int(11) NOT NULL,
  `vise_dos_enreg_be_id_id` int(11) NOT NULL,
  `vise_dos_date_crea` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `viser_dossier`
--

INSERT INTO `viser_dossier` (`id`, `vise_dos_user_id_id`, `vise_dos_enreg_be_id_id`, `vise_dos_date_crea`) VALUES
(2, 5, 1, '2019-04-25 00:00:00'),
(5, 4, 57, '2019-05-04 01:41:22');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affectation_dossier`
--
ALTER TABLE `affectation_dossier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `distribution_dossier`
--
ALTER TABLE `distribution_dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DDF9AE85A74CA520` (`dist_dos_enreg_be_id_id`),
  ADD KEY `IDX_DDF9AE85DB20BB0C` (`dist_dos_user_id_id`);

--
-- Index pour la table `enregistrement_be`
--
ALTER TABLE `enregistrement_be`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9470DD3D61CC6F11` (`enreg_be_user_id_id`);

--
-- Index pour la table `enregistrement_def`
--
ALTER TABLE `enregistrement_def`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2AA26B9E757CA53D` (`enreg_def_user_id_id`);

--
-- Index pour la table `enregistrement_tef`
--
ALTER TABLE `enregistrement_tef`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enregistrement_visa`
--
ALTER TABLE `enregistrement_visa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3B95220FA4D37117` (`enreg_visa_user_id_id`),
  ADD KEY `IDX_3B95220F4347B8FB` (`enreg_visa_enreg_be_id_id`);

--
-- Index pour la table `lecture_dossier`
--
ALTER TABLE `lecture_dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B0CB3639F341EA` (`lect_dos_enreg_be_id_id`),
  ADD KEY `IDX_B0CB363D92946FE` (`lect_dos_user_id_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `mouvement_historique`
--
ALTER TABLE `mouvement_historique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rejeter_dossier`
--
ALTER TABLE `rejeter_dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7E68F5CB17A5AC07` (`rejet_dos_enreg_be_id_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Index pour la table `verification_dossier`
--
ALTER TABLE `verification_dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2622B0E6570DDF4` (`verif_dos_user_id_id`),
  ADD KEY `IDX_2622B0E673148E7D` (`verif_dos_enreg_be_id_id`);

--
-- Index pour la table `viser_dossier`
--
ALTER TABLE `viser_dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2E77DF4F49929F8` (`vise_dos_user_id_id`),
  ADD KEY `IDX_2E77DF4CE0960E6` (`vise_dos_enreg_be_id_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affectation_dossier`
--
ALTER TABLE `affectation_dossier`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `distribution_dossier`
--
ALTER TABLE `distribution_dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT pour la table `enregistrement_be`
--
ALTER TABLE `enregistrement_be`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `enregistrement_def`
--
ALTER TABLE `enregistrement_def`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enregistrement_tef`
--
ALTER TABLE `enregistrement_tef`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enregistrement_visa`
--
ALTER TABLE `enregistrement_visa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lecture_dossier`
--
ALTER TABLE `lecture_dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `mouvement_historique`
--
ALTER TABLE `mouvement_historique`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `rejeter_dossier`
--
ALTER TABLE `rejeter_dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `verification_dossier`
--
ALTER TABLE `verification_dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `viser_dossier`
--
ALTER TABLE `viser_dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `distribution_dossier`
--
ALTER TABLE `distribution_dossier`
  ADD CONSTRAINT `FK_DDF9AE85A74CA520` FOREIGN KEY (`dist_dos_enreg_be_id_id`) REFERENCES `enregistrement_be` (`id`),
  ADD CONSTRAINT `FK_DDF9AE85DB20BB0C` FOREIGN KEY (`dist_dos_user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `enregistrement_be`
--
ALTER TABLE `enregistrement_be`
  ADD CONSTRAINT `FK_9470DD3D61CC6F11` FOREIGN KEY (`enreg_be_user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `enregistrement_def`
--
ALTER TABLE `enregistrement_def`
  ADD CONSTRAINT `FK_2AA26B9E757CA53D` FOREIGN KEY (`enreg_def_user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `enregistrement_visa`
--
ALTER TABLE `enregistrement_visa`
  ADD CONSTRAINT `FK_3B95220F4347B8FB` FOREIGN KEY (`enreg_visa_enreg_be_id_id`) REFERENCES `enregistrement_be` (`id`),
  ADD CONSTRAINT `FK_3B95220FA4D37117` FOREIGN KEY (`enreg_visa_user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `lecture_dossier`
--
ALTER TABLE `lecture_dossier`
  ADD CONSTRAINT `FK_B0CB3639F341EA` FOREIGN KEY (`lect_dos_enreg_be_id_id`) REFERENCES `enregistrement_be` (`id`),
  ADD CONSTRAINT `FK_B0CB363D92946FE` FOREIGN KEY (`lect_dos_user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `rejeter_dossier`
--
ALTER TABLE `rejeter_dossier`
  ADD CONSTRAINT `FK_7E68F5CB17A5AC07` FOREIGN KEY (`rejet_dos_enreg_be_id_id`) REFERENCES `enregistrement_be` (`id`);

--
-- Contraintes pour la table `verification_dossier`
--
ALTER TABLE `verification_dossier`
  ADD CONSTRAINT `FK_2622B0E6570DDF4` FOREIGN KEY (`verif_dos_user_id_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2622B0E673148E7D` FOREIGN KEY (`verif_dos_enreg_be_id_id`) REFERENCES `enregistrement_be` (`id`);

--
-- Contraintes pour la table `viser_dossier`
--
ALTER TABLE `viser_dossier`
  ADD CONSTRAINT `FK_2E77DF4CE0960E6` FOREIGN KEY (`vise_dos_enreg_be_id_id`) REFERENCES `enregistrement_be` (`id`),
  ADD CONSTRAINT `FK_2E77DF4F49929F8` FOREIGN KEY (`vise_dos_user_id_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
