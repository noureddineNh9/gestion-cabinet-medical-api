<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


include '../../database/connectionPDO.php';
include '../../services/medecinService.php';

$medcinService = new MedecinService($conn);
$data = $medcinService->getAll();

if ($data) {
   echo json_encode($data);
}else{
   http_response_code(400);
   echo 'empty !';
}

?>