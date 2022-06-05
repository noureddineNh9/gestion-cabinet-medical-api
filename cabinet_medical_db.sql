-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2022 at 02:55 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cabinet_medical_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterUtilisateur_pr` (IN `v_cin` VARCHAR(50), IN `v_nom` VARCHAR(50), IN `v_prenom` VARCHAR(50), IN `v_email` VARCHAR(50), IN `v_motDePasse` VARCHAR(80), IN `v_situationFamilliale` VARCHAR(50), IN `v_genre` VARCHAR(25), IN `v_tel` VARCHAR(50), IN `v_adresse` VARCHAR(255), IN `v_imageProfile` VARCHAR(255), IN `v_dateNaissance` DATE, IN `v_type` VARCHAR(25))  BEGIN

   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
   BEGIN
    	ROLLBACK;
         SIGNAL SQLSTATE '23000'
			SET MESSAGE_TEXT = 'Error in creating user';
     	   -- SELECT 'Error creating user' AS error;
   END;
   
   START TRANSACTION;
   
   INSERT INTO Utilisateur(`cin`, `nom`, `prenom`, `email`, `motDePasse`, `situationFamilliale`, `genre`, `tel`, `adresse`, `imageProfile`, `dateNaissance`, `type`) 
   VALUES(v_cin,v_nom,v_prenom,v_email, v_motDePasse, v_situationFamilliale,v_genre,v_tel,v_adresse,v_imageProfile,v_dateNaissance,v_type);

   SELECT MAX(idUtilisateur) INTO @idUtilisateur FROM Utilisateur; 

   IF v_type = 'medecin' THEN
      INSERT INTO Medecin(`idUtilisateur`) VALUES (@idUtilisateur);
   ELSEIF v_type = 'patient' THEN
      INSERT INTO Patient(`idUtilisateur`) VALUES (@idUtilisateur);   
   ELSEIF v_type = 'secretaire' THEN
      INSERT INTO Secretaire(`idUtilisateur`) VALUES (@idUtilisateur);
   ELSE 
      SIGNAL SQLSTATE '23000';
   END IF;


   SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, dateNaissance,  type 
   FROM Utilisateur 
   WHERE idUtilisateur=@idUtilisateur;
   
   COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `modifierUtilisateur_pr` (IN `v_idUtilisateur` INT, IN `v_cin` VARCHAR(50), IN `v_nom` VARCHAR(50), IN `v_prenom` VARCHAR(50), IN `v_email` VARCHAR(50), IN `v_situationFamilliale` VARCHAR(50), IN `v_genre` VARCHAR(25), IN `v_tel` VARCHAR(50), IN `v_adresse` VARCHAR(255), IN `v_imageProfile` VARCHAR(255), IN `v_dateNaissance` DATE)  BEGIN

   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
   BEGIN
    	ROLLBACK;
         SIGNAL SQLSTATE '23000'
			SET MESSAGE_TEXT = 'Error in creating user';
     	   -- SELECT 'Error creating user' AS error;
   END;
   
   START TRANSACTION;

   IF v_imageProfile != '' THEN
      UPDATE Utilisateur SET 
      imageProfile=v_imageProfile
      WHERE idUtilisateur=v_idUtilisateur;
   END IF;

   UPDATE Utilisateur SET 
            cin=v_cin,
            nom=v_nom,
            prenom=v_prenom,
            email=v_email,
            situationFamilliale=v_situationFamilliale,
            genre=v_genre,
            tel=v_tel,
            adresse=v_adresse,
            dateNaissance=v_dateNaissance
            WHERE idUtilisateur=v_idUtilisateur;

   SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, dateNaissance, type 
   FROM Utilisateur 
   WHERE idUtilisateur=v_idUtilisateur;
   
   COMMIT;

    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `login` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`login`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `Antecedent`
--

CREATE TABLE `Antecedent` (
  `idAntecedent` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('medical','familial','psychologue','traumas','autre') NOT NULL,
  `date` date DEFAULT curdate(),
  `idPatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Antecedent`
--

INSERT INTO `Antecedent` (`idAntecedent`, `nom`, `description`, `type`, `date`, `idPatient`) VALUES
(2, 'azeaze', 'sdfsdfds', 'psychologue', '2022-05-26', 12),
(4, 'vaccin', 'qsdsq sqdq sfcv fvgsdvpas de prescription\r\nds sd sdgsdg', 'medical', '2009-02-01', 12),
(5, 'grvdfvgdf', 'fgdvcqfgh,;j:   ythgrghj i; kliukyjthrgfe', 'medical', '2006-11-11', 12);

-- --------------------------------------------------------

--
-- Table structure for table `Audio`
--

CREATE TABLE `Audio` (
  `idAudio` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date` date DEFAULT curdate(),
  `idCompteRendu` int(11) DEFAULT NULL,
  `idSecretaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Audio`
--

INSERT INTO `Audio` (`idAudio`, `url`, `date`, `idCompteRendu`, `idSecretaire`) VALUES
(18, '/uploads/audio/6287f8122c35b.mp3', '2022-05-20', 38, 8),
(21, '/uploads/audio/62953e7df2176.mp3', '2022-05-30', 26, 28),
(22, '/uploads/audio/6298b78c27e7a.mp3', '2022-06-02', 40, 28);

-- --------------------------------------------------------

--
-- Table structure for table `CompteRendu`
--

CREATE TABLE `CompteRendu` (
  `idCompteRendu` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT curdate(),
  `type` varchar(25) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `idConsultation` int(11) DEFAULT NULL,
  `idSecretaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `CompteRendu`
--

INSERT INTO `CompteRendu` (`idCompteRendu`, `nom`, `description`, `date`, `type`, `url`, `idConsultation`, `idSecretaire`) VALUES
(26, 'AZERTYUI', 'bgbgbgb', '2022-05-15', 'popoyyy', '', 4, NULL),
(37, 'oioio', 'ppppp', '2022-05-18', 'ioioi', '/uploads/compteRendu/6285375a4e409.doc', 4, NULL),
(38, 'zerzerze', 'sqfqsfd', '2022-05-20', ' fdgdfg', '', 5, NULL),
(40, 'ghgjh', 'ghjjjjjjjjjjjj', '2022-06-02', 'oiii', NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Consultation`
--

CREATE TABLE `Consultation` (
  `idConsultation` int(11) NOT NULL,
  `motif` text DEFAULT NULL,
  `dateCreation` date DEFAULT curdate(),
  `duree` float DEFAULT NULL,
  `type` enum('visite','controle') NOT NULL,
  `hauteur` float DEFAULT NULL,
  `poid` float DEFAULT NULL,
  `remarques` text DEFAULT NULL,
  `idElement` int(11) DEFAULT NULL,
  `idMedecin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Consultation`
--

INSERT INTO `Consultation` (`idConsultation`, `motif`, `dateCreation`, `duree`, `type`, `hauteur`, `poid`, `remarques`, `idElement`, `idMedecin`) VALUES
(2, 'Returns a string with a locality-sensitive representation of the time portion of this date, based on system settings. az\r\n\r\n', '2022-05-12', 45, 'visite', 2345, 44, 'Returns a string with a locality-sensitive representation of the time portion of this date, based on system settings.\r\n\r\nReturns a string with \r\n\r\n', 6, 2),
(3, 'Consultation créeConsultation créeConsultation crée', '2022-05-12', 343, 'visite', 187, 80, 'Consultation créeConsultation créeConsultation crée', 6, 2),
(4, 'dsqfsdfsd', '2022-05-13', 33, 'visite', 33, 54, 'fsdfsdfds kbdddd', 1, 2),
(5, 'fdsfsd fd sdgdfgs gsfg', '2022-05-20', 23, 'visite', 123, 34, 'cdsvefsevgdsf gth fgnhgf fgh fgh', 7, 2),
(6, 'dsqdqsdqs', '2022-05-29', 23, 'controle', 333, 33, '', 6, 2),
(9, ' dfsuigf sudi fus dfg sdfu sdlf shd jfgsdhj lfdsgh lfjgsqd jghqjlsdf ghlqjs djg', '2022-05-30', 43, 'controle', 23, 443, 'F HZ HCSLJ HCSJ QHJCL Hq jsc jkqs hcj dqshl vs H H DHVLJdsh vjhs dvjlsd', 1, 2),
(10, 'The href attribute requires a valid value to be accessible. Provide a valid, navigable address as the href value.', '2022-06-05', 23, 'controle', 34, 54, 'The href attribute requires a valid value to be accessible. Provide a valid, navigable address as the href value.', 1, 2),
(11, 'If you want a client-side solution to generate PDF document, JavaScript is the easiest way to convert HTML to PDF. There are various JavaScript library is available to generate PDF from HTML. ', '2022-06-05', 56, 'controle', 343, 54, 'If you want a client-side solution to generate PDF document, JavaScript is the easiest way to convert HTML to PDF. ', 1, 2),
(12, 'In this example script, we will share code snippets to handle PDF creation and HTML to PDF conversion related operations using JavaScript.', '2022-06-05', 76, 'visite', 44, 54, 'In this example script, we will share code snippets to handle PDF creation and HTML to PDF conversion related operations using JavaScript.', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Diplome`
--

CREATE TABLE `Diplome` (
  `idDiplome` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `idMedecin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Document`
--

CREATE TABLE `Document` (
  `idDocument` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `idExamen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Document`
--

INSERT INTO `Document` (`idDocument`, `nom`, `url`, `idExamen`) VALUES
(20, 'fdsfsdf', '/uploads/compteRendu/628944ad22e56.pdf', 5),
(21, 'dsqsdqd', '/uploads/compteRendu/628971b937cc3.doc', 5),
(22, 'ioioio', '/uploads/compteRendu/62953ca5a5b1d.docx', 5),
(23, 'image', '/uploads/compteRendu/62953ef651849.png', 9),
(24, 'vfvfv', '/uploads/compteRendu/629540c796c5e.png', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ElementSante`
--

CREATE TABLE `ElementSante` (
  `idElement` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `dateCreation` date DEFAULT curdate(),
  `idPatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ElementSante`
--

INSERT INTO `ElementSante` (`idElement`, `nom`, `description`, `dateCreation`, `idPatient`) VALUES
(1, 'Fièvre', '\'aze\' is assigned a value but never used  no-unused-varsùù azertyuio ', '2022-05-11', 12),
(6, 'diabète', 'ue le patient apporte lors de la consultation comme demande, plainte, symptôme. C\'est la clé  ', '2022-05-11', 12),
(7, 'el1', 'ezaeaze', '2022-05-20', 19);

-- --------------------------------------------------------

--
-- Table structure for table `Examen`
--

CREATE TABLE `Examen` (
  `idExamen` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT curdate(),
  `type` varchar(25) DEFAULT NULL,
  `idConsultation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Examen`
--

INSERT INTO `Examen` (`idExamen`, `nom`, `description`, `date`, `type`, `idConsultation`) VALUES
(5, 'radio 4', 'bvbvbcv', '2022-05-15', 'rd', 4),
(9, 'scanner', 'fsdfsdf', '2022-05-19', 'fdslfsdf', 4),
(10, 'dsdqsd', 'dsqds', '2022-05-30', 'cxwcwx', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Medecin`
--

CREATE TABLE `Medecin` (
  `idUtilisateur` int(11) NOT NULL,
  `idService` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Medecin`
--

INSERT INTO `Medecin` (`idUtilisateur`, `idService`) VALUES
(21, 7),
(34, 7),
(2, 8),
(26, 8),
(27, 18);

-- --------------------------------------------------------

--
-- Table structure for table `Medicament`
--

CREATE TABLE `Medicament` (
  `idMedicament` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `descriptionTraitement` text DEFAULT NULL,
  `dureeParJour` int(11) DEFAULT NULL,
  `dosage` varchar(25) DEFAULT NULL,
  `idPrescription` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Medicament`
--

INSERT INTO `Medicament` (`idMedicament`, `nom`, `descriptionTraitement`, `dureeParJour`, `dosage`, `idPrescription`) VALUES
(3, 'remix', 'ds qgdjqsgljdk qsgljd qsglhj dqgjls dk', 234, '23', 7),
(6, 'qsd', 'qsdqsd', 22, '33', 7),
(9, 'remix', 'kf,sof,sk', 12, '100m', 8),
(14, 'fdfsd', 'sdfsdf', 3, '4', 8);

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `idUtilisateur` int(11) DEFAULT NULL,
  `groupeSanguin` varchar(10) DEFAULT NULL,
  `decede` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Patient`
--

INSERT INTO `Patient` (`idUtilisateur`, `groupeSanguin`, `decede`) VALUES
(12, '', 0),
(17, 'O-', 0),
(19, '', 0),
(20, '', 0),
(35, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Prescription`
--

CREATE TABLE `Prescription` (
  `idPrescription` int(11) NOT NULL,
  `conseilsMedicaux` text DEFAULT NULL,
  `idConsultation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Prescription`
--

INSERT INTO `Prescription` (`idPrescription`, `conseilsMedicaux`, `idConsultation`) VALUES
(6, NULL, 3),
(7, 'azFF', 2),
(8, 'tyutyuddddddd', 4);

-- --------------------------------------------------------

--
-- Table structure for table `RDV`
--

CREATE TABLE `RDV` (
  `idRDV` int(11) NOT NULL,
  `dateCreation` date DEFAULT curdate(),
  `dateRDV` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` enum('visite','controle') NOT NULL,
  `status` enum('enAttente','confirme','termine') NOT NULL,
  `idPatient` int(11) NOT NULL,
  `idMedecin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `RDV`
--

INSERT INTO `RDV` (`idRDV`, `dateCreation`, `dateRDV`, `type`, `status`, `idPatient`, `idMedecin`) VALUES
(9, '2022-05-19', '2022-01-13 14:00:00', 'controle', 'enAttente', 12, 2),
(11, '2022-05-22', '2022-05-19 09:04:00', 'controle', 'confirme', 12, 2),
(12, '2022-06-02', '2022-06-03 21:27:00', 'controle', 'enAttente', 12, 2),
(13, '2022-06-02', '2022-06-09 21:47:00', 'visite', 'confirme', 12, 2),
(14, '2022-06-02', '2022-06-17 21:48:00', 'controle', 'enAttente', 17, 2),
(15, '2022-06-03', '2022-06-04 09:00:00', 'controle', 'confirme', 35, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Secretaire`
--

CREATE TABLE `Secretaire` (
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Secretaire`
--

INSERT INTO `Secretaire` (`idUtilisateur`) VALUES
(8),
(28),
(29);

-- --------------------------------------------------------

--
-- Table structure for table `Service`
--

CREATE TABLE `Service` (
  `idService` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Service`
--

INSERT INTO `Service` (`idService`, `nom`) VALUES
(7, 'service A'),
(8, 'service B'),
(18, 'service C');

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `cin` varchar(10) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `motDePasse` varchar(80) NOT NULL,
  `situationFamilliale` enum('marie','celibataire','Divorce','pacse','veuf') NOT NULL,
  `genre` enum('homme','femme') NOT NULL,
  `tel` varchar(25) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(30) DEFAULT NULL,
  `imageProfile` varchar(255) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `type` enum('patient','medecin','secretaire') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Utilisateur`
--

INSERT INTO `Utilisateur` (`idUtilisateur`, `cin`, `nom`, `prenom`, `email`, `motDePasse`, `situationFamilliale`, `genre`, `tel`, `adresse`, `ville`, `imageProfile`, `dateNaissance`, `type`) VALUES
(2, 'BE25432', 'Dr. Khalid', 'kalil', 'khalid@mail.com', '$2y$10$1KRrakC.r13AyvXxKkUNf.yKDFFw4R80gUogPRLxxjBQm0dCWCd/S', 'marie', 'homme', '0987654321', 'qsdq', NULL, '/uploads/images/6289290e3cc24.jpg', '2022-05-01', 'medecin'),
(8, 'TR35678', 'faearr', 'koo', 'fae@mail.com', '$2y$10$sbp5cEwHKWq1f7i/SHqtxewOXh0OH/MaY8BqxFwTkCUWDqgX/bFea', 'marie', 'femme', 'qsdqs', 'qsdqsd', NULL, '/uploads/images/628a63ac979fb.jpg', '1988-05-19', 'secretaire'),
(12, 'GT3454', 'Mohammed', 'Gholam', 'mohammed@mail.com', '$2y$10$bfaW1oUHqUQIrzie4SfiquEYlD4SBW.pYtDkmXNHSAWD2nvfQl9wm', 'marie', 'homme', '0345678987', 'qsd', NULL, '/uploads/images/62799ce9e6e82.jpg', '1993-05-10', 'patient'),
(17, 'ER32221', 'omar', 'sabir', 'omar@mail.com', 'qsdqs', 'celibataire', 'homme', '0543456777', 'casablanca, 34567', NULL, '/uploads/images/627d9eed7eb4e.jpg', '1999-05-06', 'patient'),
(19, 'ER23456', 'hamza', 'ghali', 'hamza@mail.com', '123', 'marie', 'homme', '0987654355', 'marakkech 456789, raz', NULL, '/uploads/images/6287e74615083.jpg', '1965-11-11', 'patient'),
(20, 'dqsdqs', 'dsqdsq', 'qsdqsd', 'qsdqs', '$2y$10$ozP35YQVOBmo/uizAgE/4u7aDEOfHa1qy621TcHosH7ZcJ2Lhn/0u', 'marie', 'homme', 'dsqdqsdqs', 'cxdwvdsezrfsdf', NULL, '/uploads/images/628a11726abb6.png', '2020-05-10', 'patient'),
(21, 'DE345678', 'Dr.amine', 'lahlou', 'lahlou@mail.com', '$2y$10$sjjMtWHl3MLhteriLyd9YOrLJvvg11LU6Ae5rO7d0wZ.qWKvgGL0S', 'marie', 'homme', '0987654321', 'Casablanca , 23456789\r\nacd', NULL, '/uploads/images/628ab9e741f4d.png', '1997-12-12', 'medecin'),
(26, 'ezaeaze', 'aze', 'azeaze', 'fdsfdsf', '$2y$10$6XohxCId4aOkOHE/dgQN7.hJWPKAFAfy2/KCqK6QRSPTzmPyaz36q', 'celibataire', 'homme', 'fdsfsdf', 'sdfsdfs', NULL, '/uploads/images/628ab580af3dd.png', '2022-05-05', 'medecin'),
(27, 'fsdfsdf', 'fsdfsd', 'sdfdsf', 'sdfds@miiil', '$2y$10$t8Rywi7o2tYOVB5cXJWS0e6FW44IkBBetRa1uyMnl51HEU.I6eaF.', 'marie', 'homme', 'sdfsd', 'sdfsd', NULL, '/uploads/images/628abe168eb78.png', '2022-05-05', 'medecin'),
(28, 'jkhjk', 'frfrfr', 'jhjgh', 'hjkhjk', '$2y$10$FISUXDODDZOjqr6dAlxm2.p1kaL/jf.Z4CbE9XhegFtByxdBVsiwa', 'celibataire', 'femme', 'hjkhj', 'hjkhj', NULL, '/uploads/images/6299386444be7.jpg', '2022-05-06', 'secretaire'),
(29, 'vbnvb', 'ana', 'vbnvbn', 'vbnvb', '$2y$10$K09pX5oTArbQYH.CvXauXe/XG029r64vOELYRSiQn9njGnfR72OR6', 'celibataire', 'femme', 'nxgfncvn', 'vvv', NULL, '/uploads/images/628ac5e8173b6.png', '2022-05-10', 'secretaire'),
(34, 'A3RRX5', 'ssss', 'cqcq', 'admindsqd', '$2y$10$hb4N89Nx/cyTsHyDhzEjW.4BVYeQYCmChhAU/CL5N2D.Ozyza0kOW', 'marie', 'homme', '055557676', 'dfsfsdf', NULL, '/uploads/images/62972706d2df1.jpg', '2022-06-09', 'medecin'),
(35, 'dqsjfq', 'amine', 'kafri', 'qslcùmkqslcqs', '$2y$10$TaoYHTL7eIcPw.sxp2nVxe9TDDI/K5vo5iUvIvlvkJEpVIdwm4hGi', 'marie', 'homme', 'fdsjhfsdkj', 'sdjhfkjds', 'azeaz', '/uploads/images/6297cd273c7c7.jpeg', '1999-02-22', 'patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `Antecedent`
--
ALTER TABLE `Antecedent`
  ADD PRIMARY KEY (`idAntecedent`),
  ADD KEY `idPatient` (`idPatient`);

--
-- Indexes for table `Audio`
--
ALTER TABLE `Audio`
  ADD PRIMARY KEY (`idAudio`),
  ADD KEY `idSecretaire` (`idSecretaire`),
  ADD KEY `idCompteRendu` (`idCompteRendu`);

--
-- Indexes for table `CompteRendu`
--
ALTER TABLE `CompteRendu`
  ADD PRIMARY KEY (`idCompteRendu`),
  ADD KEY `idConsultation` (`idConsultation`),
  ADD KEY `idSecretaire` (`idSecretaire`);

--
-- Indexes for table `Consultation`
--
ALTER TABLE `Consultation`
  ADD PRIMARY KEY (`idConsultation`),
  ADD KEY `idElement` (`idElement`),
  ADD KEY `idMedecin` (`idMedecin`);

--
-- Indexes for table `Diplome`
--
ALTER TABLE `Diplome`
  ADD PRIMARY KEY (`idDiplome`),
  ADD KEY `idMedecin` (`idMedecin`);

--
-- Indexes for table `Document`
--
ALTER TABLE `Document`
  ADD PRIMARY KEY (`idDocument`),
  ADD KEY `Document_ibfk_1` (`idExamen`);

--
-- Indexes for table `ElementSante`
--
ALTER TABLE `ElementSante`
  ADD PRIMARY KEY (`idElement`),
  ADD KEY `idPatient` (`idPatient`);

--
-- Indexes for table `Examen`
--
ALTER TABLE `Examen`
  ADD PRIMARY KEY (`idExamen`),
  ADD KEY `idConsultation` (`idConsultation`);

--
-- Indexes for table `Medecin`
--
ALTER TABLE `Medecin`
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`),
  ADD KEY `idService` (`idService`);

--
-- Indexes for table `Medicament`
--
ALTER TABLE `Medicament`
  ADD PRIMARY KEY (`idMedicament`),
  ADD KEY `idPrescription` (`idPrescription`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD PRIMARY KEY (`idPrescription`),
  ADD KEY `idConsultation` (`idConsultation`);

--
-- Indexes for table `RDV`
--
ALTER TABLE `RDV`
  ADD PRIMARY KEY (`idRDV`),
  ADD KEY `idPatient` (`idPatient`),
  ADD KEY `idMedecin` (`idMedecin`);

--
-- Indexes for table `Secretaire`
--
ALTER TABLE `Secretaire`
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`idService`);

--
-- Indexes for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `cin` (`cin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Antecedent`
--
ALTER TABLE `Antecedent`
  MODIFY `idAntecedent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Audio`
--
ALTER TABLE `Audio`
  MODIFY `idAudio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `CompteRendu`
--
ALTER TABLE `CompteRendu`
  MODIFY `idCompteRendu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `Consultation`
--
ALTER TABLE `Consultation`
  MODIFY `idConsultation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Diplome`
--
ALTER TABLE `Diplome`
  MODIFY `idDiplome` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Document`
--
ALTER TABLE `Document`
  MODIFY `idDocument` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ElementSante`
--
ALTER TABLE `ElementSante`
  MODIFY `idElement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Examen`
--
ALTER TABLE `Examen`
  MODIFY `idExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Medicament`
--
ALTER TABLE `Medicament`
  MODIFY `idMedicament` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Prescription`
--
ALTER TABLE `Prescription`
  MODIFY `idPrescription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `RDV`
--
ALTER TABLE `RDV`
  MODIFY `idRDV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Service`
--
ALTER TABLE `Service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Antecedent`
--
ALTER TABLE `Antecedent`
  ADD CONSTRAINT `Antecedent_ibfk_1` FOREIGN KEY (`idPatient`) REFERENCES `Patient` (`idUtilisateur`);

--
-- Constraints for table `Audio`
--
ALTER TABLE `Audio`
  ADD CONSTRAINT `Audio_ibfk_2` FOREIGN KEY (`idSecretaire`) REFERENCES `Secretaire` (`idUtilisateur`),
  ADD CONSTRAINT `Audio_ibfk_3` FOREIGN KEY (`idCompteRendu`) REFERENCES `CompteRendu` (`idCompteRendu`) ON DELETE CASCADE;

--
-- Constraints for table `CompteRendu`
--
ALTER TABLE `CompteRendu`
  ADD CONSTRAINT `CompteRendu_ibfk_1` FOREIGN KEY (`idConsultation`) REFERENCES `Consultation` (`idConsultation`),
  ADD CONSTRAINT `CompteRendu_ibfk_2` FOREIGN KEY (`idSecretaire`) REFERENCES `Secretaire` (`idUtilisateur`);

--
-- Constraints for table `Consultation`
--
ALTER TABLE `Consultation`
  ADD CONSTRAINT `Consultation_ibfk_1` FOREIGN KEY (`idElement`) REFERENCES `ElementSante` (`idElement`),
  ADD CONSTRAINT `Consultation_ibfk_2` FOREIGN KEY (`idMedecin`) REFERENCES `Medecin` (`idUtilisateur`);

--
-- Constraints for table `Diplome`
--
ALTER TABLE `Diplome`
  ADD CONSTRAINT `Diplome_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `Medecin` (`idUtilisateur`);

--
-- Constraints for table `Document`
--
ALTER TABLE `Document`
  ADD CONSTRAINT `Document_ibfk_1` FOREIGN KEY (`idExamen`) REFERENCES `Examen` (`idExamen`) ON DELETE CASCADE;

--
-- Constraints for table `ElementSante`
--
ALTER TABLE `ElementSante`
  ADD CONSTRAINT `ElementSante_ibfk_1` FOREIGN KEY (`idPatient`) REFERENCES `Patient` (`idUtilisateur`);

--
-- Constraints for table `Examen`
--
ALTER TABLE `Examen`
  ADD CONSTRAINT `Examen_ibfk_1` FOREIGN KEY (`idConsultation`) REFERENCES `Consultation` (`idConsultation`);

--
-- Constraints for table `Medecin`
--
ALTER TABLE `Medecin`
  ADD CONSTRAINT `Medecin_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`idUtilisateur`),
  ADD CONSTRAINT `Medecin_ibfk_2` FOREIGN KEY (`idService`) REFERENCES `Service` (`idService`);

--
-- Constraints for table `Medicament`
--
ALTER TABLE `Medicament`
  ADD CONSTRAINT `Medicament_ibfk_1` FOREIGN KEY (`idPrescription`) REFERENCES `Prescription` (`idPrescription`);

--
-- Constraints for table `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `Patient_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`idUtilisateur`);

--
-- Constraints for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD CONSTRAINT `Prescription_ibfk_1` FOREIGN KEY (`idConsultation`) REFERENCES `Consultation` (`idConsultation`);

--
-- Constraints for table `RDV`
--
ALTER TABLE `RDV`
  ADD CONSTRAINT `RDV_ibfk_1` FOREIGN KEY (`idPatient`) REFERENCES `Patient` (`idUtilisateur`),
  ADD CONSTRAINT `RDV_ibfk_2` FOREIGN KEY (`idMedecin`) REFERENCES `Medecin` (`idUtilisateur`);

--
-- Constraints for table `Secretaire`
--
ALTER TABLE `Secretaire`
  ADD CONSTRAINT `Secretaire_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
