<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

try {
   $res = $conn->query("select * from Examen");
   $data = $res->fetchAll(PDO::FETCH_ASSOC);

   $examenList = array();

   foreach($data as $row){
      
      $idExamen = $row['idExamen'];
      // selectionner le dernier element
      $res2 = $conn->query("SELECT * FROM Document WHERE idExamen=$idExamen");
      $documentArr = $res2->fetchAll(PDO::FETCH_ASSOC);
      
      $row["documents"] = $documentArr;
      array_push($examenList, $row);
   }

   echo json_encode($examenList);
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode('erreur');
}

?>