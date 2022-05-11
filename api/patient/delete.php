<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../utils/functions.php';
include '../../database/connection.php';
include '../../services/patientService.php';



if (isset($_GET['id'])) {
   $id = $_GET['id'];
   
   $patientService = new PatientService($conn);
   $res = $patientService->delete($id);
   mysqli_close($conn);
   
   if ($res) {
      http_response_code(200);
      echo json_encode('ok');
   }else{
      http_response_code(400);
      echo json_encode('erreur in deleting this record');
   }

}else{
   http_response_code(400);
   echo "form non valide";
}









?>