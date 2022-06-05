<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';
include '../../services/patientService.php';



if (
   isset($_POST['cin']) and
   isset($_POST['nom']) and
   isset($_POST['prenom']) and
   isset($_POST['adresse']) and
   isset($_POST['ville']) and
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
   ) {

      $patient = new Patient();
      $uploadResult = uploadFile($_FILES['imageProfile'], "image");



      if ($uploadResult) {
         $patient->imageProfile = $uploadResult;
      }

      $motDePasse = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);

      $patient->nom = $_POST['nom'];
      $patient->prenom = $_POST['prenom'];
      $patient->cin = $_POST['cin'];
      $patient->adresse = $_POST['adresse'];
      $patient->ville = $_POST['ville'];
      $patient->email = $_POST['email'];
      $patient->genre = $_POST['genre'];
      $patient->situationFamilliale = $_POST['situationFamilliale'];
      $patient->tel = $_POST['tel'];
      $patient->dateNaissance = $_POST['dateNaissance'];

      // $patient->groupeSanguin = $_POST['groupeSanguin'];
      // $patient->hauteur = $_POST['hauteur'];
      // $patient->poid = $_POST['poid'];

      //$patient->imageProfile; 
      $patientService = new patientService($conn);
      $res = $patientService->post($patient, $motDePasse);

      if ($res) {
         echo json_encode($res);
      } else {
         http_response_code(400);
         echo json_encode('erreur 1');
      }
   } else {
      http_response_code(400);
      echo json_encode('erreur 2');
   }
} else {
   http_response_code(400);
   echo json_encode("form non valide");
}