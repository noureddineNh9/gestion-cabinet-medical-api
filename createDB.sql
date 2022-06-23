-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2022 at 02:00 AM
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
(5, 'grvdfvgdf', 'fgdvcqfgh,;j:   ythgrghj i; kliukyjthrgfe', 'medical', '2006-11-11', 12),
(6, 'conflit ', 'conflit à l\'école avec ses copains : ne supporte pas d\'être mis à l\'écart / frustrations', 'psychologue', '2010-03-19', 72),
(7, 'brûlure', 'brûlure main droite, a touché la porte du four à pizza', 'traumas', '2004-02-09', 72),
(8, 'douloureuse', 'séparation parents douloureuse, trouble du sommeil et refus de s\'alimenter.', 'psychologue', '2017-09-09', 72),
(9, 'vaccin', 'corona virus', 'medical', '2021-07-04', 72);

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
(21, '/uploads/audio/62953e7df2176.mp3', '2022-05-30', 26, 28),
(22, '/uploads/audio/6298b78c27e7a.mp3', '2022-06-02', 40, 28),
(23, '/uploads/audio/62a110b15688a.mp3', '2022-06-08', 41, 28),
(25, '/uploads/audio/62b06f11b2959.mp3', '2022-06-20', 43, 8),
(26, '/uploads/audio/62b070d7a4447.mp3', '2022-06-20', 44, 8),
(27, '/uploads/audio/62b0729de288d.mp3', '2022-06-20', 45, 8);

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
  `idConsultation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `CompteRendu`
--

INSERT INTO `CompteRendu` (`idCompteRendu`, `nom`, `description`, `date`, `type`, `url`, `idConsultation`) VALUES
(26, 'AZERTYUI', 'bgbgbgb', '2022-05-15', 'popoyyy', '', 4),
(37, 'oioio', 'ppppp', '2022-05-18', 'ioioi', '/uploads/compteRendu/6285375a4e409.doc', 4),
(40, 'ghgjh', 'ghjjjjjjjjjjjj', '2022-06-02', 'oiii', NULL, 4),
(41, 'eza', 'cdxvsdv', '2022-06-08', 'fdsq', NULL, 9),
(43, 'compte rendu de consultation', '', '2022-06-20', 'crc', '/uploads/compteRendu/62b06f2fe4b46.pdf', 13),
(44, 'compte rendu de consultation', '', '2022-06-20', 'crc', NULL, 14),
(45, 'compte rendu radiologie', '', '2022-06-20', 'crr', '/uploads/compteRendu/62b072de0729e.pdf', 14);

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
(4, 'dsqfsdfsd', '2022-05-13', 33, 'visite', 33, 54, 'fsdfsdfds kbdddd', 1, 21),
(5, 'azertyuio', '2022-05-20', 23, 'visite', 123, 34, 'cdsvefsevgdsf gth fgnhgf fgh fgh', 7, 2),
(6, 'dsqdqsdqs', '2022-05-29', 23, 'controle', 333, 33, '', 6, 2),
(9, ' dfsuigf sudi fus dfg sdfu sdlf shd jfgsdhj lfdsgh lfjgsqd jghqjlsdf ghlqjs djg', '2022-05-30', 43, 'controle', 23, 443, 'F HZ HCSLJ HCSJ QHJCL Hq jsc jkqs hcj dqshl vs H H DHVLJdsh vjhs dvjlsd', 1, 2),
(10, 'The href attribute requires a valid value to be accessible. Provide a valid, navigable address as the href value.', '2022-06-05', 23, 'controle', 34, 54, 'The href attribute requires a valid value to be accessible. Provide a valid, navigable address as the href value.', 1, 2),
(11, 'If you want a client-side solution to generate PDF document, JavaScript is the easiest way to convert HTML to PDF. There are various JavaScript library is available to generate PDF from HTML. ', '2022-06-05', 56, 'controle', 343, 54, 'If you want a client-side solution to generate PDF document, JavaScript is the easiest way to convert HTML to PDF. ', 1, 2),
(12, 'In this example script, we will share code snippets to handle PDF creation and HTML to PDF conversion related operations using JavaScript.', '2022-06-05', 76, 'visite', 44, 54, 'In this example script, we will share code snippets to handle PDF creation and HTML to PDF conversion related operations using JavaScript.', 1, 2),
(13, 'une douleur mineure au bas du dos', '2022-03-15', 60, 'visite', 170, 60, '', 12, 21),
(14, 'Le mal de dos a augmenté dans le dos, ce qui a conduit à l\'incapacité de bouger\r\n\r\n\r\n', '2022-04-09', 60, 'controle', 170, 62, '', 12, 21),
(15, 'Après avoir vu les radiologie , il nous semble qu\'on est au début du développement de la maladie siatique en première phase.', '2022-04-27', 60, 'visite', 170, 60, '', 12, 21),
(16, 'En raison de l\'évolution rapide de la maladie, une opération d\'urgence est nécessaire.', '2022-05-10', 90, 'visite', 170, 56, 'Une inflammation du muscle piriforme.', 12, 21),
(17, 'Après la réussite de l\'opération, on remarque la réactivité du corps réactif et la remarquable hospitalisation', '2022-05-20', 60, 'controle', 171, 57, 'Le patient devrait avoir au moins 10 séances de formation en médecine', 12, 21),
(18, 'controle après le kinésithérapie on note l\'amélioration de l\'etat du patient.', '2022-06-19', 45, 'controle', 171, 59, '\r\nLe patient doit éviter de lever des poids gros', 12, 21),
(19, 'Il arrive que le patient ait du mal à respirer certaines nuits.', '2022-05-17', 60, 'visite', 170, 63, 'cette allergie survient en présence de aéroallergènes, tels que le pollen, la poussière, la moisissure.', 11, 21),
(20, 'L\'état du patient était perturbé et avait de la difficulté à respirer chaque nuit.', '2022-06-09', 90, 'visite', 170, 61, 'La possibilité que le patient soit asthmatique.', 11, 21);

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
(24, 'vfvfv', '/uploads/compteRendu/629540c796c5e.png', 10),
(26, 'image', '/uploads/compteRendu/62b071f5ce27d.png', 11),
(27, 'fichier', '/uploads/compteRendu/62b0730c6d530.pdf', 11);

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
(7, 'el1', 'ezaeaze', '2022-05-20', 19),
(11, 'l\'allergie respiratoire ', 'maladie chronique , l\'allergie respiratoire est une reaction immunitaire inappropiée de notre organisme ', '2022-06-19', 72),
(12, 'siatique', 'une douleur du membre inférieur située sur le trajet du nerf sciatique.', '2022-06-19', 72);

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
(10, 'dsdqsd', 'dsqds', '2022-05-30', 'cxwcwx', 4),
(11, 'La radiographie du rachis lombaire', '', '2022-06-20', 'radio', 14);

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
(2, 7),
(34, 8),
(21, 18);

-- --------------------------------------------------------

--
-- Table structure for table `Medicament`
--

CREATE TABLE `Medicament` (
  `idMedicament` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `descriptionTraitement` text DEFAULT NULL,
  `dureeParJour` int(11) DEFAULT NULL,
  `matin` enum('avant','apres','auMilieu','aucun') DEFAULT 'aucun',
  `midi` enum('avant','apres','auMilieu','aucun') DEFAULT 'aucun',
  `soir` enum('avant','apres','auMilieu','aucun') DEFAULT 'aucun',
  `idPrescription` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Medicament`
--

INSERT INTO `Medicament` (`idMedicament`, `nom`, `descriptionTraitement`, `dureeParJour`, `matin`, `midi`, `soir`, `idPrescription`) VALUES
(20, 'sdfgh', 'zert', 21, 'aucun', 'avant', 'apres', 6),
(21, 'hygtfrds', 'gggg', 32, NULL, NULL, NULL, 6),
(22, 'voltaren 25mg', '2 capsule a chaque fois', 2, NULL, NULL, NULL, 9),
(23, 'farmablu 100mg', '1 capsule ', 1, 'apres', 'aucun', 'aucun', 9),
(24, 'celebrex 200mg', '3 capsule par jour', 15, 'avant', 'avant', 'avant', 10),
(25, 'aleve 220 mg', '1 capsule par jour', 10, 'aucun', 'aucun', 'avant', 10),
(26, 'naprosyn 500mg', '1 capsule', 15, 'apres', 'aucun', 'apres', 10);

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
(35, '', 0),
(72, '', 0);

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
(8, 'tyutyuddddddd', 4),
(9, NULL, 13),
(10, NULL, 14),
(11, NULL, 15);

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
(9, '2022-05-19', '2022-06-09 09:00:00', 'visite', 'confirme', 19, 2),
(11, '2022-05-22', '2022-06-08 09:00:00', 'controle', 'confirme', 17, 2),
(12, '2022-06-02', '2022-06-21 08:00:00', 'controle', 'confirme', 12, 2),
(13, '2022-06-02', '2022-06-06 23:00:00', 'visite', 'enAttente', 12, 2),
(14, '2022-06-02', '2022-06-17 21:48:00', 'controle', 'enAttente', 17, 2),
(15, '2022-06-03', '2022-06-21 10:00:00', 'controle', 'confirme', 35, 2),
(16, '2022-06-19', '2022-06-27 07:00:00', 'visite', 'confirme', 72, 21),
(17, '2022-06-19', '2022-07-01 08:00:00', 'visite', 'confirme', 17, 21),
(18, '2022-06-19', '2022-06-30 10:00:00', 'controle', 'confirme', 20, 21);

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
(28);

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
(7, 'Allergologie'),
(8, 'service B'),
(18, 'Orthopédie'),
(24, 'Matérnités');

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
(2, 'BE25432', 'Dr. Khalid', 'kalil', 'khalid@mail.com', '$2y$10$JfObH/5jIOvcEqFW3KlJd.djsU6Zwlj6x.6liZU9CS3kf8O0HQoki', 'marie', 'homme', '0987654321', 'qsdq', NULL, '/uploads/images/6289290e3cc24.jpg', '2022-05-01', 'medecin'),
(8, 'TR35678', 'Amina', 'saki', 'amina@mail.com', '$2y$10$sbp5cEwHKWq1f7i/SHqtxewOXh0OH/MaY8BqxFwTkCUWDqgX/bFea', 'marie', 'femme', 'qsdqs', 'qsdqsd', NULL, '/uploads/images/628a63ac979fb.jpg', '1988-05-19', 'secretaire'),
(12, 'GT3454', 'Mohammed', 'Gholam', 'mohammed@mail.com', '$2y$10$bfaW1oUHqUQIrzie4SfiquEYlD4SBW.pYtDkmXNHSAWD2nvfQl9wm', 'marie', 'homme', '0345678987', 'qsd', 'casa', '/uploads/images/629d1e939d255.jpeg', '1993-05-10', 'patient'),
(17, 'ER32221', 'omaima', 'sabir', 'sabir@mail.com', 'qsdqs', 'celibataire', 'femme', '0543456777', 'rabat', 'rabat', '/uploads/images/62a0eb07cced2.jpeg', '2013-05-06', 'patient'),
(19, 'ER23456', 'fatima', 'ghilal', 'ghilal@mail.com', '123', 'marie', 'femme', '0987654355', 'marakkech 456789, raz', 'marakkech', '/uploads/images/62a0eb4a0bbfa.jpg', '1998-11-11', 'patient'),
(20, 'ML9327', 'abdellah', 'ben aissa', 'abdellah@mail.com', '$2y$10$ozP35YQVOBmo/uizAgE/4u7aDEOfHa1qy621TcHosH7ZcJ2Lhn/0u', 'celibataire', 'homme', '0644259764', 'agadir 84765 ', 'agadir', '/uploads/images/62a0ea06ee4ba.jpg', '2000-05-10', 'patient'),
(21, 'DE345678', 'Dr. Amine', 'lahlou', 'lahlou@mail.com', '$2y$10$lRP6aLK49pC4fye11sWMzu4m9cyHNZCFqUat75nV01oq3XaFHEpqa', 'marie', 'homme', '0987654321', 'Casablanca , 23456789\r\nacd', NULL, '/uploads/images/62a1018612e39.jpg', '1987-12-12', 'medecin'),
(28, 'LO63228', 'ghita', 'bennani', 'bennani@mail.com', '$2y$10$FISUXDODDZOjqr6dAlxm2.p1kaL/jf.Z4CbE9XhegFtByxdBVsiwa', 'celibataire', 'femme', '0954532674', 'maroc, casablanca 6333', NULL, '/uploads/images/62a10240c4cc5.jpg', '1998-02-21', 'secretaire'),
(34, 'VE346534', 'Dr. Rachid', 'Tamir', 'rachid@mail.com', '$2y$10$85A3ibKfIrbpSBwXTucjx.DXj32bGUfTAz/5YYQAshS4wdf.osU1i', 'celibataire', 'homme', '0655775522', 'Agadir 4321', NULL, '/uploads/images/62a1019337064.jpg', '1997-06-09', 'medecin'),
(35, 'YH8543', 'amine', 'lotfi', 'lotfi@mail.com', '$2y$10$TaoYHTL7eIcPw.sxp2nVxe9TDDI/K5vo5iUvIvlvkJEpVIdwm4hGi', 'marie', 'homme', '0766539674', 'beni mellal 978986', 'beni mellal', '/uploads/images/62a0ea75156d7.jpg', '1986-02-22', 'patient'),
(72, 'P337115', 'ait touchent', 'abdellatif', 'abdellatif@gmail.com ', '$2y$10$svYN3q/0gIwCpmzq/h5As.ED5nXxRV58blmAH/A0kuJZQYTzC0pwK', 'marie', 'homme', '0767803598', 'casablanca moustakbal', 'ouarzazate', '/uploads/images/62af02a814ba4.jpeg', '1999-05-16', 'patient');

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
  ADD KEY `idConsultation` (`idConsultation`);

--
-- Indexes for table `Consultation`
--
ALTER TABLE `Consultation`
  ADD PRIMARY KEY (`idConsultation`),
  ADD KEY `idElement` (`idElement`),
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
  MODIFY `idAntecedent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Audio`
--
ALTER TABLE `Audio`
  MODIFY `idAudio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `CompteRendu`
--
ALTER TABLE `CompteRendu`
  MODIFY `idCompteRendu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `Consultation`
--
ALTER TABLE `Consultation`
  MODIFY `idConsultation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Document`
--
ALTER TABLE `Document`
  MODIFY `idDocument` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ElementSante`
--
ALTER TABLE `ElementSante`
  MODIFY `idElement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Examen`
--
ALTER TABLE `Examen`
  MODIFY `idExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Medicament`
--
ALTER TABLE `Medicament`
  MODIFY `idMedicament` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `Prescription`
--
ALTER TABLE `Prescription`
  MODIFY `idPrescription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `RDV`
--
ALTER TABLE `RDV`
  MODIFY `idRDV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Service`
--
ALTER TABLE `Service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

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
  ADD CONSTRAINT `CompteRendu_ibfk_1` FOREIGN KEY (`idConsultation`) REFERENCES `Consultation` (`idConsultation`);

--
-- Constraints for table `Consultation`
--
ALTER TABLE `Consultation`
  ADD CONSTRAINT `Consultation_ibfk_1` FOREIGN KEY (`idElement`) REFERENCES `ElementSante` (`idElement`),
  ADD CONSTRAINT `Consultation_ibfk_2` FOREIGN KEY (`idMedecin`) REFERENCES `Medecin` (`idUtilisateur`);

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
