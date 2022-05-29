<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$idPrescription = $_POST['idPrescription'];
$conseilsMedicaux = $_POST['conseilsMedicaux'];

if (!empty($idConsultation) || 
   !empty($conseilsMedicaux)
)
{

   try {
      $s = $conn->prepare("UPDATE Prescription SET 
         conseilsMedicaux = :conseilsMedicaux
         WHERE idPrescription = :idPrescription
      ");

      $s->bindParam('idPrescription', $idPrescription);
      $s->bindParam('conseilsMedicaux', $conseilsMedicaux);
      $s->execute();

      $count = $s->rowCount();
      if ($s->rowCount() > 0) {
         echo json_encode("succes");
      }else{
         throw new Exception();
      }
   } catch (PDOException $e) {
      http_response_code(400);
      echo json_encode('erreur');
   }
}else{
   http_response_code(400);
   echo json_encode('form non valide');
}