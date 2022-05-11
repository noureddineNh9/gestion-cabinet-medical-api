

DROP PROCEDURE IF EXISTS getPatientById;
DELIMITER $$
CREATE PROCEDURE getPatientById ( IN  v_id INT )
BEGIN
SELECT p.idUtilisateur, p.groupeSanguin, p.hauteur, p.poid, u.cin, u.nom, u.prenom, u.email, 
         u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.type 
FROM Patient p, Utilisateur u 
WHERE u.idUtilisateur=p.idUtilisateur 
AND idPatient=v_id;
END$$
DELIMITER ;



INSERT INTO Utilisateur(`cne`, `nom`, `prenom`, `email`, `motDePasse`, `situationFamilliale`, `genre`, `tel`, `adresse`, `type`) 
VALUES ('BE57778', 'amine', 'kali', 'amine@mail.com', '123', 'celibataire', 'male', '098765432', 'adressse 1111', 'patient');

INSERT INTO Patient(`idUtilisateur`, `groupeSanguin`, `hauteur`, `poid`) VALUES ('1', 'O+', '192.8', '80');




----------------------------------------------------------------------------------


DROP PROCEDURE IF EXISTS ajouterPatient_pr;
DELIMITER $$
CREATE PROCEDURE ajouterPatient_pr(
   IN v_cin varchar(50),
   IN v_nom varchar(50),
   IN v_prenom varchar(50),
   IN v_email varchar(50) ,
   IN v_motDePasse varchar(80),
   IN v_situationFamilliale varchar(50),
   IN v_genre varchar(25),
   IN v_tel varchar(50),
   IN v_adresse varchar(255),
   IN v_imageProfile varchar(255) ,
   IN v_groupeSanguin varchar(50),
   IN v_hauteur FLOAT,
   IN v_poid FLOAT
)
BEGIN

   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
   BEGIN
    	ROLLBACK;
         SIGNAL SQLSTATE '23000'
			SET MESSAGE_TEXT = 'Error in creating user';
     	   -- SELECT 'Error creating user' AS error;
   END;
   
   START TRANSACTION;

   INSERT INTO Utilisateur(`cne`, `nom`, `prenom`, `email`, `motDePasse`, `situationFamilliale`, `genre`, `tel`, `adresse`, `imageProfile`, `type`) 
   VALUES (v_cne, v_nom, v_prenom, v_email, v_motDePasse, v_situationFamilliale, v_genre, v_tel, v_adresse, v_imageProfile, 'patient');

   SELECT MAX(idUtilisateur) INTO @idUtilisateur FROM Utilisateur; 

   INSERT INTO Patient(`idUtilisateur`, `groupeSanguin`, `hauteur`, `poid`) VALUES (@idUtilisateur, v_groupeSanguin, v_hauteur, v_poid);

   SELECT p.idUtilisateur, p.idPatient, p.groupeSanguin, p.hauteur, p.poid, u.cne, u.nom, u.prenom, u.email, 
            u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.type 
   FROM Patient p, Utilisateur u 
   WHERE u.idUtilisateur=p.idUtilisateur 
   AND u.idUtilisateur=@idUtilisateur
   ORDER BY p.idUtilisateur 
   LIMIT 1;
   
   COMMIT;

    
END$$

DELIMITER ;


CALL ajouterPatient_pr('AP778', 'khalid', 'moral', 'khalid@mail.com', '123', 'celibataire', 'male', '098765432', 'adressse 1111',NULL, 'O+', '192.8', '80');



----------------------------------------------------------------------------------

DROP PROCEDURE IF EXISTS ajouterUtilisateur_pr;
DELIMITER $$
CREATE PROCEDURE ajouterUtilisateur_pr(
   IN v_cin varchar(50),
   IN v_nom varchar(50),
   IN v_prenom varchar(50),
   IN v_email varchar(50) ,
   IN v_motDePasse varchar(80),
   IN v_situationFamilliale varchar(50),
   IN v_genre varchar(25),
   IN v_tel varchar(50),
   IN v_adresse varchar(255),
   IN v_imageProfile varchar(255),
   IN v_dateNaissance date,
   IN v_type varchar(25)
)
BEGIN

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

DELIMITER ;



-----------------------------------------------------------------------------------------------------------



DROP PROCEDURE IF EXISTS modifierUtilisateur_pr;
DELIMITER $$
CREATE PROCEDURE modifierUtilisateur_pr(
   IN v_idUtilisateur INT,
   IN v_cin varchar(50),
   IN v_nom varchar(50),
   IN v_prenom varchar(50),
   IN v_email varchar(50) ,
   IN v_situationFamilliale varchar(50),
   IN v_genre varchar(25),
   IN v_tel varchar(50),
   IN v_adresse varchar(255),
   IN v_imageProfile varchar(255),
   IN v_dateNaissance date
)
BEGIN

   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
   BEGIN
    	ROLLBACK;
         SIGNAL SQLSTATE '23000'
			SET MESSAGE_TEXT = 'Error in creating user';
     	   -- SELECT 'Error creating user' AS error;
   END;
   
   START TRANSACTION;

   IF v_imageProfile != NULL THEN
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
