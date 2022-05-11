<?php

//require '../../services/userService.php';

require $_SERVER['DOCUMENT_ROOT'].'/gestion-cabinet-medical-server/services/userService.php'; 

class Patient{
   public $idUtilisateur;    
   public $idPatient;
   public $nom;
   public $prenom;
   public $cne;
   public $adresse;
   public $email; 
   public $genre;
   public $tel;
   public $situationFamilliale ; 
   public $hauteur = 'NULL';
   public $imageProfile; 
   public $poid = 'NULL';
   public $groupeSanguin ;
}


class PatientService extends UserService{

   public function __construct($conn){
      parent::__construct($conn, 'patient', 'Patient');
   }

   // function get($id){
     
   //    $res = $this->conn->query("CALL getPatientById($id)");
   //    if ($res) {
   //       if (mysqli_num_rows($res) > 0) {
   //          $row = mysqli_fetch_assoc($res);
   //          return $row;
   //       }else{
   //          return false;
   //       }
   //    }else{
   //       return false;
   //    }
   // }
   
   function getAll(){
      $query = "SELECT u.idUtilisateur, u.cin, u.nom, u.prenom, u.email, u.situationFamilliale, u.genre, u.tel, u.adresse, u.imageProfile, u.dateNaissance, u.type, p.groupeSanguin, p.decede
      FROM Utilisateur u, Patient p
      WHERE u.type='$this->type' AND u.idUtilisateur=p.idUtilisateur" ;

      $res = $this->conn->query($query);
      if ($res) {
         if (mysqli_num_rows($res) > 0) {
            $patientArr = array();
            while($row = mysqli_fetch_assoc($res)){
               array_push($patientArr, $row); 
            }
            return $patientArr;
         }else{
            return array();
         }
      }else{
         return false;
      }
   }


   // function delete($id){



   //    try {     
   //       $res1 = $this->conn->query("SELECT idUtilisateur FROM Patient WHERE idPatient=$id");
   //       if ($res1 AND mysqli_num_rows($res1) > 0) {
   //          $idUtilisateur = mysqli_fetch_assoc($res1)['idUtilisateur'];

   //          $res2 = $this->conn->query("DELETE FROM Patient WHERE idPatient=$id");

   //          $res3 = $this->conn->query("DELETE FROM Utilisateur WHERE idUtilisateur=$idUtilisateur");

   //          if ($res3) {
   //             return true;
   //          }
   //       }
   //       return false;

   //    } catch (Exception $e) {
   //       return false;
   //    }
   // }


}


?>