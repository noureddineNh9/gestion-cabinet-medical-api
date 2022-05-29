<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

try {
   $res = $conn->query("SELECT c.*, e.nom AS elementSante from Consultation c, ElementSante e WHERE c.idElement = e.idElement");
   $data = $res->fetchAll(PDO::FETCH_ASSOC);
   echo json_encode($data);
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode('erreur');
}