<?php


class Utilisateur{
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
   public $type;

   public function __construct($type){
      $this->type = $type;
   }

}


class UserService{
   protected $conn;
   protected $type;
   protected $tableName;

   public function __construct($conn, $type, $tableName){
      $this->conn = $conn;
      $this->type = $type;
      $this->tableName = $tableName;
   }

   function get($id){
     
      $res = $this->conn->query("SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, type 
                           FROM Utilisateur 
                           WHERE type='$this->type'
                           AND idUtilisateur=$id
                        ");
      if ($res) {
         if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return $row;
         }else{
            return false;
         }
      }else{
         return false;
      }
   }
   
   function getAll(){
      $query = "SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, dateNaissance, type 
                FROM Utilisateur 
                WHERE type='$this->type'";
     
      $res = $this->conn->query($query);
      if ($res) {
         if (mysqli_num_rows($res) > 0) {
            $Arr = array();
            while($row = mysqli_fetch_assoc($res)){
               array_push($Arr, $row); 
            }
            return $Arr;
         }else{
            return array();
         }
      }else{
         return false;
      }
   }

   function post(Utilisateur $u, $motDePasse){

      $query = "CALL ajouterUtilisateur_pr('$u->cin','$u->nom','$u->prenom','$u->email', '$motDePasse', '$u->situationFamilliale','$u->genre','$u->tel','$u->adresse','$u->imageProfile', '$u->dateNaissance', '$u->type')";

      try {      
         $res = $this->conn->query($query);      
         if ($res) {
            $row = mysqli_fetch_assoc($res);
            return $row;
         }else{
            return false;
         }
      } catch (Exception $e) {
         return $query;
      }
   }

   function delete($id){
      try {     

         $res2 = $this->conn->query("DELETE FROM $this->tableName WHERE idUtilisateur=$id");
         if (mysqli_affected_rows($this->conn)) {
            $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$id");
            if (mysqli_affected_rows($this->conn)) {
               return true;
            }else{
               return false;
            }       
         }else{
            return false;
         }       
      } catch (Exception $e) {
         return false;
      }
   }

   function put(Utilisateur $u, $motDePasse){

      $query = "CALL modifierUtilisateur_pr('$u->idUtilisateur' ,'$u->cin','$u->nom','$u->prenom','$u->email', '$u->situationFamilliale','$u->genre','$u->tel','$u->adresse','$u->imageProfile', '$u->dateNaissance')";

      try {     
         $res = $this->conn->query($query);      
         if ($res) {
            $row = mysqli_fetch_assoc($res);
            return $row;
         }else{
            return false;
         }
      } catch (Exception $e) {
         return $query;
      }

   }

}


?>