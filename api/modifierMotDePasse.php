<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../database/connectionPDO.php';

$idUtilisateur = $_POST['idUtilisateur'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$confirmedPassword = $_POST['confirmedPassword'];

if (
   !empty($idUtilisateur) &&
   !empty($oldPassword) &&
   !empty($newPassword) &&
   !empty($confirmedPassword)
) {

   try {

      if ($newPassword !== $confirmedPassword) {
         throw new Exception();
      }

      $s = $conn->prepare("SELECT motDePasse FROM Utilisateur WHERE idUtilisateur = :idUtilisateur");

      $s->bindParam('idUtilisateur', $idUtilisateur);
      $s->execute();

      $res = $s->fetch(PDO::FETCH_ASSOC);

      if ($res) {
         $hash_password = $res['motDePasse'];

         // verifier si l'ancien mot de pass est correct
         if (password_verify($oldPassword, $hash_password)) {

            $new_hash_password = password_hash($newPassword, PASSWORD_DEFAULT);

            $s = $conn->prepare("UPDATE Utilisateur SET motDePasse = :motDePasse WHERE idUtilisateur = :idUtilisateur");

            $s->bindParam('motDePasse', $new_hash_password);
            $s->bindParam('idUtilisateur', $idUtilisateur);
            $s->execute();

            if ($s->rowCount()) {
               http_response_code(200);
               echo json_encode('success');
            } else {
               throw new Exception();
            }
         } else {
            throw new Exception();
         }
      } else {
         throw new Exception();
      }
   } catch (Exception $e) {
      http_response_code(400);
      echo json_encode('erreur');
   }
} else {
   http_response_code(400);
   echo json_encode('form non valide');
}