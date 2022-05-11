<?php

header("Access-Control-Allow-Origin: *");

include '../../database/connectionPDO.php';
include '../../services/secretaireService.php';

$secretaireService = new SecretaireService($conn);

$resultat = $secretaireService->getAll();

if ($resultat) {
   echo json_encode($resultat);
}else{
   http_response_code(400);
   echo 'empty !';
}

?>