<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$idConsultation = $_POST['idConsultation'];

if (!empty($idConsultation))
{

   try {
      $s = $conn->prepare("INSERT INTO 
         Prescription(idConsultation)
         values (:idConsultation)
      ");

      $s->bindParam('idConsultation', $idConsultation);
      $s->execute();

      // selectionner le dernier element
      $res = $conn->query("SELECT * FROM Prescription ORDER BY idPrescription DESC LIMIT 1");
      $data = $res->fetch(PDO::FETCH_ASSOC);

      $idPrescription = $data['idPrescription'];

      // selectionner le dernier element
      $res2 = $conn->query("SELECT * FROM Medicament WHERE idPrescription=$idPrescription");
      $medicaments = $res2->fetchAll(PDO::FETCH_ASSOC);

      $data["medicaments"] = $medicaments;

      echo json_encode($data);

   } catch (PDOException $e) {
      http_response_code(400);
      echo json_encode('erreur');
   }
}else{
   http_response_code(400);
   echo json_encode('form non valide');
}