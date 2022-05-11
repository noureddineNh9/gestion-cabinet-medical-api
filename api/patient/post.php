<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connection.php';
include '../../services/userService.php';



if (
   isset($_POST['cin']) and
   isset($_POST['nom']) and
   isset($_POST['prenom']) and
   isset($_POST['adresse']) and
   isset($_POST['email']) and 
   isset($_POST['motDePasse']) and 
   isset($_POST['genre']) and
   isset($_POST['situationFamilliale']) and 
   isset($_POST['tel']) and 
   isset($_POST['dateNaissance']) and 
   isset($_FILES['imageProfile'])
   ) {
      if (
         !empty($_POST['nom']) and
         !empty($_POST['prenom']) and
         !empty($_POST['cin']) and
         !empty($_POST['adresse']) and
         !empty($_POST['email']) and 
         !empty($_POST['motDePasse']) and 
         !empty($_POST['genre']) and
         !empty($_POST['situationFamilliale']) and 
         !empty($_POST['tel']) and 
         !empty($_POST['dateNaissance']) and 
         !empty($_FILES['imageProfile'])
         ){

            $user = new Utilisateur('patient');
            $uploadResult = uploadFile($_FILES['imageProfile'], "image");
         


            if ($uploadResult) {
               $user->imageProfile = $uploadResult;  
            }
               
            $motDePasse = $_POST['motDePasse'];
            
            $user->nom = $_POST['nom'];
            $user->prenom = $_POST['prenom'];
            $user->cin = $_POST['cin'];
            $user->adresse = $_POST['adresse'];
            $user->email = $_POST['email']; 
            $user->genre = $_POST['genre'];
            $user->situationFamilliale = $_POST['situationFamilliale']; 
            $user->tel = $_POST['tel'];
            $user->dateNaissance = $_POST['dateNaissance'];
            
            // $user->groupeSanguin = $_POST['groupeSanguin'];
            // $user->hauteur = $_POST['hauteur'];
            // $user->poid = $_POST['poid'];
            
            //$user->imageProfile; 
            $userService = new userService($conn, 'patient', 'Patient');
            $res = $userService->post($user, $motDePasse);
            
            if ($res) {
               echo json_encode($res);
            }else{
               http_response_code(400);
               echo json_encode('erreur 1');
            }
         }else{
            http_response_code(400);
            echo json_encode('erreur 2');
         }
}else{
   http_response_code(400);
   echo json_encode("form non valide");
}









?>