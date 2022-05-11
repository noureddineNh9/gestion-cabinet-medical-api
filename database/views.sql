

INSERT INTO `Utilisateur` (`cne`, `nom`, `prenom`, `email`, `motDePasse`, `situationFamilliale`, `genre`, `tel`, `adresse`, `imageProfile`, `type`) 
VALUES ('BE44564', 'prof ', 'koubi', 'koubi@mail.com', 'aze', 'marie', 'male', '09876543245', 'dsqsdqdsqd', NULL, 'medecin');

-------------------------------------------------------------------------------

DROP VIEW IF EXISTS patient_vw;
CREATE VIEW patient_vw AS 
SELECT p.idUtilisateur, p.idPatient, p.groupeSanguin, p.hauteur, p.poid, u.cne, u.nom, u.prenom, u.email, 
         u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.type 
FROM Patient p, Utilisateur u 
WHERE u.idUtilisateur=p.idUtilisateur ;


