<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$id = $_GET["id"];

try {
   $s = $conn->prepare("UPDATE CompteRendu SET  
                        url = ''  
                        WHERE idCompteRendu = :idCompteRendu");

   $s->bindParam('idCompteRendu', $id);

   $s->execute();
   $count = $s->rowCount();
   
   
   if ($count > 0) {
      echo json_encode("succes");
   }else{
      throw new Exception();
   }
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode('erreur' );
}

?>