<?php


class Secretaire{
   public $idUtilisateur;    
   public $cin;
   public $nom;
   public $prenom;
   public $email; 
   public $situationFamilliale; 
   public $genre;
   public $tel;
   public $adresse;
   public $imageProfile; 
   public $dateNaissance; 
   public $type='secretaire';

}


class SecretaireService{
   protected $conn;

   public function __construct($conn){
      $this->conn = $conn;
   }
   
   function getAll(){
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

   function post(Secretaire $s, $motDePasse){
      $query = "CALL ajouterUtilisateur_pr('$s->cin','$s->nom','$s->prenom','$s->email', '$motDePasse', '$s->situationFamilliale','$s->genre','$s->tel','$s->adresse','$s->imageProfile', '$s->dateNaissance', '$s->type')";

      try {      
         $res = $this->conn->query($query);  
         $data = $res->fetch(PDO::FETCH_ASSOC);

         return $data;
      } catch (PDOException $e) {
         return false;
      }
   }

   function put(Secretaire $s){
      $query = "CALL modifierUtilisateur_pr('$s->idUtilisateur' ,'$s->cin','$s->nom','$s->prenom','$s->email', '$s->situationFamilliale','$s->genre','$s->tel','$s->adresse','$s->imageProfile', '$s->dateNaissance')";

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
         $res2 = $this->conn->query("DELETE FROM Secretaire WHERE idUtilisateur=$id");
         $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$id");
         
         return true;
      } catch (PDOException $e) {
         return false;
      }
   }

}


?>