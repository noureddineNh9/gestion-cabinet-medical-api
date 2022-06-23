<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$idPrescription = $_POST['idPrescription'];
$nom = $_POST['nom'];
$descriptionTraitement = $_POST['descriptionTraitement'];
$dureeParJour = $_POST['dureeParJour'];

$matin = $_POST['matin'];
$midi = $_POST['midi'];
$soir = $_POST['soir'];


if (
   !empty($idPrescription) ||
   !empty($nom) ||
   !empty($descriptionTraitement) ||
   !empty($dureeParJour)
) {

   try {
      $s = $conn->prepare("INSERT INTO 
         Medicament(idPrescription, nom, descriptionTraitement, dureeParJour, matin, midi, soir)
         values (:idPrescription, :nom, :descriptionTraitement, :dureeParJour, :matin, :midi, :soir)
      ");

      $s->bindParam('idPrescription', $idPrescription);
      $s->bindParam('nom', $nom);
      $s->bindParam('descriptionTraitement', $descriptionTraitement);
      $s->bindParam('dureeParJour', $dureeParJour);
      $s->bindParam('matin', $matin);
      $s->bindParam('midi', $midi);
      $s->bindParam('soir', $soir);

      $s->execute();

      // selectionner le dernier element
      $res = $conn->query("SELECT * FROM Medicament ORDER BY idMedicament DESC LIMIT 1;");
      $data = $res->fetch(PDO::FETCH_ASSOC);

      echo json_encode($data);
   } catch (PDOException $e) {
      http_response_code(400);
      echo json_encode('erreur');
   }
} else {
   http_response_code(400);
   echo json_encode('form non valide');
}