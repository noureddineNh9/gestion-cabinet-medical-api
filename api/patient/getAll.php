<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


include '../../database/connection.php';
include '../../services/patientService.php';

$patientService = new PatientService($conn);

$patients = $patientService->getAll();
if ($patients) {
   echo json_encode($patients);
}else{
   http_response_code(400);
   echo json_encode('erreur');
}




?>