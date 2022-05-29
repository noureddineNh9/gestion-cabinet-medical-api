<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';
include '../../services/medecinService.php';



if (
   isset($_POST['cin']) and
   isset($_POST['nom']) and
   isset($_POST['prenom']) and
   isset($_POST['idService']) and
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
      !empty($_POST['idService']) and
      !empty($_POST['adresse']) and
      !empty($_POST['email']) and
      !empty($_POST['motDePasse']) and
      !empty($_POST['genre']) and
      !empty($_POST['situationFamilliale']) and
      !empty($_POST['tel']) and
      !empty($_POST['dateNaissance']) and
      !empty($_FILES['imageProfile'])
   ) {

      $medecin = new Medecin();

      //
      $uploadResult = uploadFile($_FILES['imageProfile'], "image");
      if ($uploadResult) {
         $medecin->imageProfile = $uploadResult;
      }

      $medecin->nom = $_POST['nom'];
      $medecin->prenom = $_POST['prenom'];
      $medecin->cin = $_POST['cin'];
      $medecin->idService = $_POST['idService'];
      $medecin->adresse = $_POST['adresse'];
      $medecin->email = $_POST['email'];
      $medecin->genre = $_POST['genre'];
      $medecin->situationFamilliale = $_POST['situationFamilliale'];
      $medecin->tel = $_POST['tel'];
      $medecin->dateNaissance = $_POST['dateNaissance'];
      $motDePasse = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);

      $medecinService = new MedecinService($conn);
      $res = $medecinService->post($medecin, $motDePasse);

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