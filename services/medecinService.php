<?php


class Medecin{
   public $idUtilisateur;    
   public $cin;
   public $nom;
   public $prenom;
   public $email; 
   public $mituationFamilliale; 
   public $genre;
   public $tel;
   public $adresse;
   public $imageProfile; 
   public $dateNaissance; 
   public $type='medecin';
}


class MedecinService{
   protected $conn;

   public function __construct($conn){
      $this->conn = $conn;
   }
   
   function getAll(){
      try {
         $query = "SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, dateNaissance, type 
                  FROM Utilisateur 
                  WHERE type='medecin'";
      
         $res = $this->conn->query($query);  
         $data = $res->fetchAll(PDO::FETCH_ASSOC);
         
         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function post(Medecin $m, $motDePasse){
      $query = "CALL ajouterUtilisateur_pr('$m->cin','$m->nom','$m->prenom','$m->email', '$motDePasse', '$m->situationFamilliale','$m->genre','$m->tel','$m->adresse','$m->imageProfile', '$m->dateNaissance', '$m->type')";

      try {      
         $res = $this->conn->query($query);  
         $data = $res->fetch(PDO::FETCH_ASSOC);

         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function put(Medecin $m){
      $query = "CALL modifierUtilisateur_pr('$m->idUtilisateur' ,'$m->cin','$m->nom','$m->prenom','$m->email', '$m->situationFamilliale','$m->genre','$m->tel','$m->adresse','$m->imageProfile', '$m->dateNaissance')";

      try {     
         $res = $this->conn->query($query);      
         $data = $res->fetch(PDO::FETCH_ASSOC);

         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function delete($id){
      try {     
         $res2 = $this->conn->query("DELETE FROM Medecin WHERE idUtilisateur=$id");
         $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$id");
         
         return true;
      } catch (PDOException $e) {
         return false;
      }
   }

}


?>