<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';
include '../../services/secretaireService.php';



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
         !empty($_POST['tel'])
         ){
            $secretaire = new Secretaire('secretaire');
            
            $uploadResult = uploadFile($_FILES['imageProfile'], "image");
            if ($uploadResult) {
               $secretaire->imageProfile = $uploadResult;  
            }
               
            $secretaire->idUtilisateur = $_POST['idUtilisateur'];
            $secretaire->nom = $_POST['nom'];
            $secretaire->prenom = $_POST['prenom'];
            $secretaire->cin = $_POST['cin'];
            $secretaire->adresse = $_POST['adresse'];
            $secretaire->email = $_POST['email']; 
            $secretaire->genre = $_POST['genre'];
            $secretaire->situationFamilliale = $_POST['situationFamilliale']; 
            $secretaire->tel = $_POST['tel'];
            $secretaire->dateNaissance = $_POST['dateNaissance'];

            $secretaireService = new SecretaireService($conn);
            $res = $secretaireService->put($secretaire, $motDePasse);
            
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
   echo json_encode("form non valide");
}









?>