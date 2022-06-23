<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../database/connectionPDO.php';


$idMedicament = $_POST['idMedicament'];
$nom = $_POST['nom'];
$descriptionTraitement = $_POST['descriptionTraitement'];
$dureeParJour = $_POST['dureeParJour'];

// $matin = $_POST['matin'];
// $midi = $_POST['midi'];
// $soir = $_POST['soir'];


if (
   !empty($idMedicament) ||
   !empty($nom) ||
   !empty($descriptionTraitement) ||
   !empty($dureeParJour)
) {
   try {
      $s = $conn->prepare("UPDATE Medicament SET 
                              nom = :nom,
                              descriptionTraitement = :descriptionTraitement,
                              dureeParJour = :dureeParJour,
                              matin = :matin,
                              midi = :midi,
                              soir = :soir
                              WHERE idMedicament = :idMedicament
                           ");

      $s->bindParam('nom', $nom);
      $s->bindParam('descriptionTraitement', $descriptionTraitement);
      $s->bindParam('dureeParJour', $dureeParJour);
      $s->bindParam('matin', $matin, PDO::PARAM_STR);
      $s->bindParam('midi', $midi, PDO::PARAM_STR);
      $s->bindParam('soir', $soir, PDO::PARAM_STR);
      $s->bindParam('idMedicament', $idMedicament);
      $s->execute();

      $count = $s->rowCount();

      if ($count) {
         echo json_encode("success");
      } else {
         throw new Exception();
      }
   } catch (Throwable $th) {
      http_response_code(400);
      echo json_encode('erreur');
   }
} else {
   http_response_code(400);
   echo json_encode("form non valide");
}