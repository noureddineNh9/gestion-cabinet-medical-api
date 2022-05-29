<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

try {
   $res = $conn->query("select * from CompteRendu");
   $data = $res->fetchAll(PDO::FETCH_ASSOC);

   $compteRenduList = array();

   foreach($data as $row){
      
      $idCompteRendu = $row['idCompteRendu'];
      // selectionner le dernier element
      $res2 = $conn->query("SELECT * FROM Audio WHERE idCompteRendu=$idCompteRendu");
      $audio = $res2->fetch(PDO::FETCH_ASSOC);
      if ($audio) {
         $row["audio"] = $audio;
      }else{
         $row["audio"] = null;
      }
      array_push($compteRenduList, $row);
   }

   echo json_encode($compteRenduList);
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode('erreur');
}

?>