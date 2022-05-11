<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 360000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("content-type: application/json");

if(strtoupper($_SERVER["REQUEST_METHOD"]) == "OPTIONS"){
    echo json_encode([]);
    exit;
}

include '../../database/connection.php';
include '../../services/patientService.php';

$idPatient = $_GET['id'];

$patientService = new PatientService($conn);

if (!empty($idPatient)) {
   $patient = $patientService->get($idPatient);
   if ($patient) {
      echo json_encode($patient);
   }else{
      echo 'le patient n\'exist pas';
   }

}else{
   echo 'erreur';
}



?>