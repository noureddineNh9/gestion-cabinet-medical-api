<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';
include '../../services/secretaireService.php';



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
   ) {

      $secretaire = new Secretaire();

      //
      $uploadResult = uploadFile($_FILES['imageProfile'], "image");
      if ($uploadResult) {
         $secretaire->imageProfile = $uploadResult;
      }

      $secretaire->nom = $_POST['nom'];
      $secretaire->prenom = $_POST['prenom'];
      $secretaire->cin = $_POST['cin'];
      $secretaire->adresse = $_POST['adresse'];
      $secretaire->email = $_POST['email'];
      $secretaire->genre = $_POST['genre'];
      $secretaire->situationFamilliale = $_POST['situationFamilliale'];
      $secretaire->tel = $_POST['tel'];
      $secretaire->dateNaissance = $_POST['dateNaissance'];
      $motDePasse = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);

      $secretaireService = new SecretaireService($conn);
      $res = $secretaireService->post($secretaire, $motDePasse);

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