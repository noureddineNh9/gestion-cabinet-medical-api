<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

try {
   $res = $conn->query("select * from Prescription");
   $data = $res->fetchAll(PDO::FETCH_ASSOC);

   $prescriptionList = array();

   foreach ($data as $row) {

      $idPrescription = $row['idPrescription'];
      // selectionner le dernier element
      $res2 = $conn->query("SELECT * FROM Medicament WHERE idPrescription=$idPrescription");
      $medicaments = $res2->fetchAll(PDO::FETCH_ASSOC);

      $row["medicaments"] = $medicaments;

      array_push($prescriptionList, $row);
   }

   echo json_encode($prescriptionList);
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode('erreur');
}