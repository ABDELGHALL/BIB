-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 11 déc. 2024 à 11:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `onlinelibrary`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AjouterLivre` (IN `p_titre` VARCHAR(255), IN `p_auteur` VARCHAR(255), IN `p_genre` VARCHAR(100), IN `p_annee_publication` INT, IN `p_stock` INT)   BEGIN
    INSERT INTO livres (titre, auteur, genre, annee_publication, stock)
    VALUES (p_titre, p_auteur, p_genre, p_annee_publication, p_stock);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ApprouverEmprunt` (IN `empruntID` INT)   BEGIN
    DECLARE livreID INT;
    DECLARE stockDispo INT;

    SELECT id_livre INTO livreID
    FROM emprunts
    WHERE id_emprunt = empruntID;

    SELECT stock INTO stockDispo
    FROM livres
    WHERE id_livre = livreID;

    IF stockDispo > 0 THEN
        INSERT INTO emprunts (id_livre, id_membre, date_emprunt)
        SELECT id_livre, id_membre, date_emprunt
        FROM emprunts
        WHERE id_emprunt = empruntID;

        UPDATE livres
        SET stock = stock - 1
        WHERE id_livre = livreID;

        DELETE FROM emprunts
        WHERE id_emprunt = empruntID;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Le stock est insuffisant pour approuver cet emprunt.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GererRetour` (IN `p_id_emprunt` INT, IN `p_date_retour` DATE)   BEGIN
    DECLARE livre_id INT;

    SELECT id_livre INTO livre_id
    FROM Emprunts
    WHERE id_emprunt = p_id_emprunt;

    IF livre_id IS NOT NULL THEN
        UPDATE Emprunts
        SET date_retour = p_date_retour
        WHERE id_emprunt = p_id_emprunt;

        UPDATE Livres
        SET stock = stock + 1
        WHERE id_livre = livre_id;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Emprunt introuvable.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RejeterEmprunt` (IN `empruntID` INT)   BEGIN
    DELETE FROM emprunts
    WHERE id_emprunt = empruntID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ReserverLivre` (IN `p_id_livre` INT, IN `p_id_membre` INT, IN `p_date_emprunt` DATE)   BEGIN
    DECLARE stock_disponible INT;

    SELECT stock INTO stock_disponible
    FROM Livres
    WHERE id_livre = p_id_livre;

    IF stock_disponible > 0 THEN
        INSERT INTO Emprunts (id_livre, id_membre, date_emprunt)
        VALUES (p_id_livre, p_id_membre, p_date_emprunt);

        UPDATE Livres
        SET stock = stock - 1
        WHERE id_livre = p_id_livre;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Le livre n\'est pas disponible.';
    END IF;
END$$

--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalculerRetards` () RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE total_retards INT;
    
   
    SELECT COUNT(*)
    INTO total_retards
    FROM emprunts
    WHERE date_retour IS NULL
      AND DATEDIFF(CURDATE(), date_emprunt) > 30;
    
    RETURN total_retards;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `VerifierDisponibilite` (`livreID` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE stockDispo INT;

    -- Récupérer le stock du livre
    SELECT stock INTO stockDispo
    FROM Livres
    WHERE id_livre = livreID;

    -- Retourner le statut de disponibilité
    IF stockDispo > 0 THEN
        RETURN 'Disponible';
    ELSE
        RETURN 'Indisponible';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `eid` varchar(122) NOT NULL,
  `name` varchar(122) NOT NULL,
  `password` varchar(122) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`eid`, `name`, `password`) VALUES
('admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `note` int(11) DEFAULT NULL CHECK (`note` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id_emprunt` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `emprunts`
--
DELIMITER $$
CREATE TRIGGER `after_insert_emprunts` AFTER INSERT ON `emprunts` FOR EACH ROW BEGIN
    UPDATE Livres
    SET stock = stock - 1
    WHERE id_livre = NEW.id_livre;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_emprunts` AFTER UPDATE ON `emprunts` FOR EACH ROW BEGIN
    IF NEW.date_retour IS NOT NULL AND OLD.date_retour IS NULL THEN
        UPDATE Livres
        SET stock = stock + 1
        WHERE id_livre = NEW.id_livre;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_emprunts` BEFORE INSERT ON `emprunts` FOR EACH ROW BEGIN
    DECLARE stock_disponible INT;

    SELECT stock INTO stock_disponible
    FROM Livres
    WHERE id_livre = NEW.id_livre;

    IF stock_disponible <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Le livre n''est pas disponible en stock.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id_livre` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `annee_publication` year(4) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id_livre`, `titre`, `auteur`, `genre`, `annee_publication`, `stock`) VALUES
(21, 'Naruto', 'Shonen Jump', 'Manga', '2012', 18);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id_membre` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `adresse` text NOT NULL,
  `password` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id_membre`, `nom`, `email`, `telephone`, `adresse`, `password`) VALUES
(17, 'abdo', 'abdoallaoui0631@gmail.com', '0631797200', 'Casa', 'abdo');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `id_livre` (`id_livre`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id_emprunt`),
  ADD KEY `id_livre` (`id_livre`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id_livre`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_membre`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id_emprunt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id_livre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id_livre`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`id_membre`) REFERENCES `members` (`id_membre`);

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `emprunts_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id_livre`),
  ADD CONSTRAINT `emprunts_ibfk_2` FOREIGN KEY (`id_membre`) REFERENCES `members` (`id_membre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
