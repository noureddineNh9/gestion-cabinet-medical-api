<?php

//require '../../services/userService.php';


class Patient
{
   public $idUtilisateur;
   public $idPatient;
   public $nom;
   public $prenom;
   public $cne;
   public $adresse;
   public $email;
   public $genre;
   public $tel;
   public $situationFamilliale;
   public $imageProfile;
   public $groupeSanguin;
   public $decede;
}


class PatientService
{
   protected $conn;

   public function __construct($conn)
   {
      $this->conn = $conn;
   }

   function getAll()
   {
      $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, p.groupeSanguin, p.decede
      FROM Utilisateur u, Patient p
      WHERE u.type='patient' AND u.idUtilisateur=p.idUtilisateur";

      try {
         $s = $this->conn->query($query);
         $data = $s->fetchAll(PDO::FETCH_ASSOC);

         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function post(Patient $p, $motDePasse)
   {
      try {

         $query = "INSERT INTO Utilisateur VALUES(null, :cin, :nom, :prenom,:email, :motDePasse, :situationFamilliale, :genre, :tel, :adresse, :imageProfile, :dateNaissance, 'patient')";

         $stm = $this->conn->prepare($query);

         $stm->bindParam('cin', $p->cin);
         $stm->bindParam('nom', $p->nom);
         $stm->bindParam('prenom', $p->prenom);
         $stm->bindParam('email', $p->email);
         $stm->bindParam('motDePasse', $motDePasse);
         $stm->bindParam('situationFamilliale', $p->situationFamilliale);
         $stm->bindParam('genre', $p->genre);
         $stm->bindParam('tel', $p->tel);
         $stm->bindParam('adresse', $p->adresse);
         $stm->bindParam('imageProfile', $p->imageProfile);
         $stm->bindParam('dateNaissance', $p->dateNaissance);

         $stm->execute();

         if ($stm) {
            $res = $this->conn->query("SELECT idUtilisateur FROM Utilisateur ORDER BY idUtilisateur DESC LIMIT 1;");
            $lastUser = $res->fetch(PDO::FETCH_ASSOC);
            $idUtilisateur = $lastUser['idUtilisateur'];

            $res2 = $this->conn->query("INSERT INTO Patient values($idUtilisateur,null, null)");

            if ($res2) {

               $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, p.groupeSanguin, p.decede
               FROM Utilisateur u, Patient p
               WHERE u.idUtilisateur=p.idUtilisateur 
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
      // try {
      //    $query = "CALL ajouterUtilisateur_pr('$p->cin','$p->nom','$p->prenom','$p->email', '$motDePasse', '$p->situationFamilliale','$p->genre','$p->tel','$p->adresse','$p->imageProfile', '$p->dateNaissance', 'patient')";

      //    $res = $this->conn->prepare($query);
      //    $res->execute();
      //    $res->closeCursor();

      //    $query2 = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, p.groupeSanguin, p.decede
      //    FROM Utilisateur u, Patient p
      //    WHERE u.type='patient' AND u.idUtilisateur=p.idUtilisateur ORDER BY idUtilisateur DESC LIMIT 1";

      //    $res2 = $this->conn->query($query2);

      //    $data = $res2->fetch(PDO::FETCH_ASSOC);

      //    return $data;
      // } catch (PDOException $e) {
      //    return false;
      // }
   }

   function put(Patient $p)
   {
      try {
         if ($p->imageProfile) {
            $res = $this->conn->query("UPDATE Utilisateur SET 
               imageProfile='$p->imageProfile'
               WHERE idUtilisateur= $p->idUtilisateur");
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

         $stm->bindParam('cin', $p->cin);
         $stm->bindParam('nom', $p->nom);
         $stm->bindParam('prenom', $p->prenom);
         $stm->bindParam('email', $p->email);
         $stm->bindParam('situationFamilliale', $p->situationFamilliale);
         $stm->bindParam('genre', $p->genre);
         $stm->bindParam('tel', $p->tel);
         $stm->bindParam('adresse', $p->adresse);
         $stm->bindParam('dateNaissance', $p->dateNaissance);
         $stm->bindParam('idUtilisateur', $p->idUtilisateur);

         $stm->execute();

         if ($stm) {


            $s = $this->conn->prepare("UPDATE Patient SET
            decede = :decede,
            groupeSanguin = :groupeSanguin
            WHERE idUtilisateur = :idUtilisateur
         ");
            $s->bindParam('decede', $p->decede, PDO::PARAM_BOOL);
            $s->bindParam('groupeSanguin', $p->groupeSanguin);
            $s->bindParam('idUtilisateur', $p->idUtilisateur);

            $s->execute();

            $query2 = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, p.groupeSanguin, p.decede
         FROM Utilisateur u, Patient p
         WHERE u.idUtilisateur=p.idUtilisateur AND u.idUtilisateur=$p->idUtilisateur";

            $res2 = $this->conn->query($query2);

            $data = $res2->fetch(PDO::FETCH_ASSOC);

            return $data;
         } else {
            throw new Exception();
         }
      } catch (PDOException $e) {
         return $e->getMessage();
      }
   }

   function delete($id)
   {

      try {

         $res1 = $this->conn->query("DELETE FROM Patient WHERE idUtilisateur=$id");

         if ($res1->rowCount() > 0) {

            $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$id");

            if ($res3->rowCount()) {
               return true;
            }
         }
         return false;
      } catch (Exception $e) {
         return false;
      }
   }
}