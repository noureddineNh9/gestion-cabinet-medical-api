DROP DATABASE IF EXISTS cabinet_medical_db;
CREATE DATABASE cabinet_medical_db;

use cabinet_medical_db;


CREATE TABLE Utilisateur(
   idUtilisateur int PRIMARY KEY AUTO_INCREMENT,
   cin varchar(10) NOT NULL UNIQUE,
   nom varchar(25) NOT NULL,
   prenom varchar(25) NOT NULL,
   email varchar(50) NOT NULL,
   motDePasse varchar(80) NOT NULL,
   situationFamilliale ENUM('marie', 'celibataire', 'divorce', 'pacse', 'veuf') NOT NULL,
   genre ENUM('homme', 'femme') NOT NULL,
   tel varchar(25) NOT NULL,
   ville varchar(30),
   adresse varchar(255),
   imageProfile varchar(255),
   dateNaissance date,
   type ENUM('patient', 'medecin', 'secretaire') NOT NULL
);

CREATE TABLE Service(
   idService INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(25) NOT NULL
);

CREATE TABLE Patient(
   idUtilisateur int UNIQUE,
   groupeSanguin varchar(10),
   decede boolean DEFAULT false,
   FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);

CREATE TABLE Medecin(
   idUtilisateur int UNIQUE NOT NULL,
   idService INT,
   FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
   FOREIGN KEY (idService) REFERENCES Service(idService)
);

CREATE TABLE Secretaire(
   idUtilisateur int UNIQUE NOT NULL,
   FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);

CREATE TABLE Diplome(
   idDiplome INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(25) NOT NULL,
   idMedecin INT,
   FOREIGN KEY (idMedecin) REFERENCES Medecin(idUtilisateur)
);

CREATE TABLE Antecedent(
   idAntecedent INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(50) NOT NULL,
   description text,
   type ENUM('medical', 'familial', 'psychologue', 'traumas', 'autre') NOT NULL,
   date date DEFAULT CURRENT_DATE,
   idPatient INT NOT NULL,
   FOREIGN KEY (idPatient) REFERENCES Patient(idUtilisateur)
);

CREATE TABLE RDV(
   idRDV INT PRIMARY KEY AUTO_INCREMENT,
   dateCreation date DEFAULT CURRENT_DATE,
   dateRDV date NOT NULL,
   type ENUM('visite', 'controle') NOT NULL,
   status ENUM('enAttente', 'confirme', 'termine') NOT NULL,
   idPatient INT NOT NULL,
   idMedecin INT NOT NULL,
   FOREIGN KEY (idPatient) REFERENCES Patient(idUtilisateur),
   FOREIGN KEY (idMedecin) REFERENCES Medecin(idUtilisateur)
);

CREATE TABLE ElementSante(
   idElement INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(50) NOT NULL,
   description text,
   dateCreation date DEFAULT CURRENT_DATE,
   idPatient INT NOT NULL,
   FOREIGN KEY (idPatient) REFERENCES Patient(idUtilisateur)
);


CREATE TABLE Consultation(
   idConsultation INT PRIMARY KEY AUTO_INCREMENT,
   motif text,
   date date DEFAULT CURRENT_DATE,
   duree float,
   type ENUM('visite', 'controle') NOT NULL,
   hauteur float,
   poid float,
   remarques text,
   idElement INT,
   idMedecin INT,
   FOREIGN KEY (idElement) REFERENCES ElementSante(idElement),
   FOREIGN KEY (idMedecin) REFERENCES Medecin(idUtilisateur)
);

CREATE TABLE Prescription(
   idPrescription INT PRIMARY KEY AUTO_INCREMENT,
   conseilsMedicaux text,
   idConsultation INT,
   FOREIGN KEY (idConsultation) REFERENCES Consultation(idConsultation)
);

CREATE TABLE Medicament(
   idMedicament INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(50) NOT NULL,
   descriptionTraitement text,
   dureeParJour INT,
   dosage varchar(25),
   idPrescription INT,
   FOREIGN KEY (idPrescription) REFERENCES Prescription(idPrescription)
);

CREATE TABLE CompteRendu(
   idCompteRendu INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(50) NOT NULL,
   description text,
   date date DEFAULT CURRENT_DATE,
   type varchar(25),
   url varchar(255) NOT NULL,
   idConsultation INT,
   idSecretaire INT,
   FOREIGN KEY (idConsultation) REFERENCES Consultation(idConsultation),
   FOREIGN KEY (idSecretaire) REFERENCES Secretaire(idUtilisateur)
);

CREATE TABLE Audio(
   idAudio INT PRIMARY KEY AUTO_INCREMENT,
   url varchar(255) NOT NULL,
   date date DEFAULT CURRENT_DATE,
   idCompteRendu INT,
   idSecretaire INT,
   FOREIGN KEY (idCompteRendu) REFERENCES CompteRendu(idCompteRendu) ON DELETE CASCADE,
   FOREIGN KEY (idSecretaire) REFERENCES Secretaire(idUtilisateur)
);

CREATE TABLE Examen(
   idExamen INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(50) NOT NULL,
   description text,
   date date DEFAULT CURRENT_DATE,
   type varchar(25),
   idConsultation INT,
   FOREIGN KEY (idConsultation) REFERENCES Consultation(idConsultation)
);

CREATE TABLE Document(
   idDocument INT PRIMARY KEY AUTO_INCREMENT,
   nom varchar(50) NOT NULL,
   description text,
   type varchar(25),
   url varchar(255) NOT NULL,
   idExamen INT,
   FOREIGN KEY (idExamen) REFERENCES Examen(idExamen)
);


CREATE TABLE Admin(
   login varchar(50) PRIMARY KEY,
   password varchar(100) NOT NULL
);

INSERT INTO Admin VALUES('admin', 'admin');
