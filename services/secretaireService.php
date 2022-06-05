<?php


class Secretaire
{
   public $idUtilisateur;
   public $cin;
   public $nom;
   public $prenom;
   public $email;
   public $stmituationFamilliale;
   public $genre;
   public $tel;
   public $adresse;
   public $imageProfile;
   public $dateNaissance;
   public $type = 'secretaire';
}


class SecretaireService
{
   protected $conn;

   public function __construct($conn)
   {
      $this->conn = $conn;
   }

   function getAll()
   {
      try {
         $query = "SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, dateNaissance, type 
                  FROM Utilisateur 
                  WHERE type='secretaire'";

         $res = $this->conn->query($query);
         $data = $res->fetchAll(PDO::FETCH_ASSOC);

         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function post(Secretaire $s, $motDePasse)
   {
      try {

         $query = "INSERT INTO Utilisateur VALUES(null, :cin, :nom, :prenom,:email, :motDePasse, :situationFamilliale, :genre, :tel, :adresse, NULL, :imageProfile, :dateNaissance, 'secretaire')";

         $stm = $this->conn->prepare($query);

         $stm->bindParam('cin', $s->cin);
         $stm->bindParam('nom', $s->nom);
         $stm->bindParam('prenom', $s->prenom);
         $stm->bindParam('email', $s->email);
         $stm->bindParam('motDePasse', $motDePasse);
         $stm->bindParam('situationFamilliale', $s->situationFamilliale);
         $stm->bindParam('genre', $s->genre);
         $stm->bindParam('tel', $s->tel);
         $stm->bindParam('adresse', $s->adresse);
         $stm->bindParam('imageProfile', $s->imageProfile);
         $stm->bindParam('dateNaissance', $s->dateNaissance);

         $stm->execute();

         if ($stm) {
            $res = $this->conn->query("SELECT idUtilisateur FROM Utilisateur ORDER BY idUtilisateur DESC LIMIT 1;");
            $lastUser = $res->fetch(PDO::FETCH_ASSOC);
            $idUtilisateur = $lastUser['idUtilisateur'];

            $res2 = $this->conn->query("INSERT INTO Secretaire values($idUtilisateur)");

            if ($res2) {
               $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type
               FROM Utilisateur u
               WHERE u.idUtilisateur = $idUtilisateur";

               $res = $this->conn->query($query);
               $data = $res->fetch(PDO::FETCH_ASSOC);

               return $data;
            } else {
               throw new Exception();
            }
         } else {
            throw new Exception();
         }
      } catch (PDOException $e) {
         return false;
      }
   }

   function put(Secretaire $s)
   {

      try {

         if ($s->imageProfile) {
            $res = $this->conn->query("UPDATE Utilisateur SET 
               imageProfile='$s->imageProfile'
               WHERE idUtilisateur= $s->idUtilisateur");
            if (!$res) {
               throw new Exception();
            }
         }

         $query = "UPDATE Utilisateur SET 
            cin = :cin,
            nom = :nom,
            prenom = :prenom,
            email = :email,
            situationFamilliale = :situationFamilliale,
            genre = :genre,
            tel = :tel,
            adresse = :adresse,
            dateNaissance = :dateNaissance
            WHERE idUtilisateur = :idUtilisateur";

         $stm = $this->conn->prepare($query);

         $stm->bindParam('cin', $s->cin);
         $stm->bindParam('nom', $s->nom);
         $stm->bindParam('prenom', $s->prenom);
         $stm->bindParam('email', $s->email);
         $stm->bindParam('situationFamilliale', $s->situationFamilliale);
         $stm->bindParam('genre', $s->genre);
         $stm->bindParam('tel', $s->tel);
         $stm->bindParam('adresse', $s->adresse);
         $stm->bindParam('dateNaissance', $s->dateNaissance);
         $stm->bindParam('idUtilisateur', $s->idUtilisateur);

         $stm->execute();

         if ($stm) {

            $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type
                  FROM Utilisateur u
                  WHERE u.idUtilisateur = $s->idUtilisateur";

            $res = $this->conn->query($query);
            $data = $res->fetch(PDO::FETCH_ASSOC);

            return $data;
         } else {
            throw new Exception();
         }
      } catch (PDOException $e) {
         return false;
      }
   }

   function delete($id)
   {
      try {
         $res2 = $this->conn->query("DELETE FROM Secretaire WHERE idUtilisateur=$id");
         $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$id");

         return true;
      } catch (PDOException $e) {
         return false;
      }
   }
}