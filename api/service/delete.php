<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$id = $_GET["id"];

try {
   $res = $conn->query("delete from Service where $id=idService");
   
   echo json_encode("succes");
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode('erreur' );
}

?>