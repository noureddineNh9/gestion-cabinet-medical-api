<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$idUtilisateur = $_POST['idUtilisateur'];
$motDePasse = $_POST['motDePasse'];

if (
   !empty($idUtilisateur) &&
   !empty($motDePasse)
) {

   try {
      $hash_password = password_hash($motDePasse, PASSWORD_DEFAULT);


      $s = $conn->prepare("UPDATE Utilisateur SET motDePasse = :motDePasse WHERE idUtilisateur = :idUtilisateur");

      $s->bindParam('motDePasse', $hash_password);
      $s->bindParam('idUtilisateur', $idUtilisateur);
      $s->execute();

      if ($s->rowCount()) {
         http_response_code(200);
         echo json_encode('success');
      } else {
         throw new Exception();
      }
   } catch (Exception $e) {
      http_response_code(400);
      echo json_encode('error');
   }
} else {
   http_response_code(400);
   echo json_encode('form non valide');
}