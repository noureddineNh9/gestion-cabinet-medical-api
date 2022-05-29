<?php


class Medecin
{
   public $idUtilisateur;
   public $cin;
   public $nom;
   public $prenom;
   public $idService;
   public $email;
   public $mituationFamilliale;
   public $genre;
   public $tel;
   public $adresse;
   public $imageProfile;
   public $dateNaissance;
   public $type = 'medecin';
}


class MedecinService
{
   protected $conn;

   public function __construct($conn)
   {
      $this->conn = $conn;
   }

   function getAll()
   {
      try {
         $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, m.idService
                  FROM Utilisateur u, Medecin m
                  WHERE u.idUtilisateur = m.idUtilisateur 
                  AND type='medecin'";

         $res = $this->conn->query($query);
         $data = $res->fetchAll(PDO::FETCH_ASSOC);

         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function post(Medecin $m, $motDePasse)
   {
      try {

         $query = "INSERT INTO Utilisateur VALUES(null, :cin, :nom, :prenom,:email, :motDePasse, :situationFamilliale, :genre, :tel, :adresse, :imageProfile, :dateNaissance, 'medecin')";

         $s = $this->conn->prepare($query);

         $s->bindParam('cin', $m->cin);
         $s->bindParam('nom', $m->nom);
         $s->bindParam('prenom', $m->prenom);
         $s->bindParam('email', $m->email);
         $s->bindParam('motDePasse', $motDePasse);
         $s->bindParam('situationFamilliale', $m->situationFamilliale);
         $s->bindParam('genre', $m->genre);
         $s->bindParam('tel', $m->tel);
         $s->bindParam('adresse', $m->adresse);
         $s->bindParam('imageProfile', $m->imageProfile);
         $s->bindParam('dateNaissance', $m->dateNaissance);

         $s->execute();

         if ($s) {
            $res = $this->conn->query("SELECT idUtilisateur FROM Utilisateur ORDER BY idUtilisateur DESC LIMIT 1;");
            $lastUser = $res->fetch(PDO::FETCH_ASSOC);
            $idUtilisateur = $lastUser['idUtilisateur'];

            $res2 = $this->conn->query("INSERT INTO Medecin values($idUtilisateur, $m->idService)");

            if ($res2) {
               $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, m.idService
               FROM Utilisateur u, Medecin m
               WHERE u.idUtilisateur = m.idUtilisateur
               AND u.idUtilisateur = $idUtilisateur";

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

   function put(Medecin $m)
   {

      try {

         if ($m->imageProfile) {
            $res = $this->conn->query("UPDATE Utilisateur SET 
               imageProfile='$m->imageProfile'
               WHERE idUtilisateur= $m->idUtilisateur");
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

         $s = $this->conn->prepare($query);

         $s->bindParam('cin', $m->cin);
         $s->bindParam('nom', $m->nom);
         $s->bindParam('prenom', $m->prenom);
         $s->bindParam('email', $m->email);
         $s->bindParam('situationFamilliale', $m->situationFamilliale);
         $s->bindParam('genre', $m->genre);
         $s->bindParam('tel', $m->tel);
         $s->bindParam('adresse', $m->adresse);
         $s->bindParam('dateNaissance', $m->dateNaissance);
         $s->bindParam('idUtilisateur', $m->idUtilisateur);

         $s->execute();

         if ($s) {

            $res2 = $this->conn->query("UPDATE Medecin SET idService = $m->idService WHERE idUtilisateur = $m->idUtilisateur");

            if ($res2) {
               $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, m.idService
                  FROM Utilisateur u, Medecin m
                  WHERE u.idUtilisateur = m.idUtilisateur
                  AND u.idUtilisateur = $m->idUtilisateur";

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

   function delete($id)
   {
      try {
         $res2 = $this->conn->query("DELETE FROM Medecin WHERE idUtilisateur=$id");
         $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$id");

         return true;
      } catch (PDOException $e) {
         return false;
      }
   }
}