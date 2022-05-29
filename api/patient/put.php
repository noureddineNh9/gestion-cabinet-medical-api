<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';
include '../../services/patientService.php';



if (
   isset($_POST['idUtilisateur']) and
   isset($_POST['cin']) and
   isset($_POST['nom']) and
   isset($_POST['prenom']) and
   isset($_POST['adresse']) and
   isset($_POST['email']) and 
   isset($_POST['genre']) and
   isset($_POST['situationFamilliale']) and 
   isset($_POST['tel']) and 
   isset($_POST['dateNaissance']) and 
   isset($_POST['decede']) and 
   isset($_POST['groupeSanguin']) and 
   isset($_FILES['imageProfile'])
   ) {
      if (
         !empty($_POST['idUtilisateur']) and
         !empty($_POST['nom']) and
         !empty($_POST['prenom']) and
         !empty($_POST['cin']) and
         !empty($_POST['adresse']) and
         !empty($_POST['email']) and 
         !empty($_POST['genre']) and
         !empty($_POST['situationFamilliale']) and 
         !empty($_POST['dateNaissance']) and 
         !empty($_POST['decede']) and 
         !empty($_POST['tel'])
         ){

            $patient = new Patient();
            
            $uploadResult = uploadFile($_FILES['imageProfile'], "image");
         
         
            if ($uploadResult) {
               $patient->imageProfile = $uploadResult;  
            }
               
            
            // $motDePasse = $_POST['motDePasse'];
            
            $patient->idUtilisateur = $_POST['idUtilisateur'];
            $patient->nom = $_POST['nom'];
            $patient->prenom = $_POST['prenom'];
            $patient->cin = $_POST['cin'];
            $patient->adresse = $_POST['adresse'];
            $patient->email = $_POST['email']; 
            $patient->genre = $_POST['genre'];
            $patient->situationFamilliale = $_POST['situationFamilliale']; 
            $patient->tel = $_POST['tel'];
            $patient->dateNaissance = $_POST['dateNaissance'];
            $patient->decede = json_decode($_POST['decede']);
            $patient->groupeSanguin = $_POST['groupeSanguin'];


            $patientService = new PatientService($conn);
            $res = $patientService->put($patient);
            
            if ($res) {
               echo json_encode($res);
            }else{
               http_response_code(400);
               echo json_encode('erreur 1');
            }
         }else{
            http_response_code(400);
            echo json_encode('erreur');
         }
}else{
   http_response_code(400);
   echo "form non valide";
}









?>