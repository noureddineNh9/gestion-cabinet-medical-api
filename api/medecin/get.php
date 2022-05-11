<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 360000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../../database/connection.php';
include '../../services/userService.php';

$id = $_GET['id'];


$medcinService = new UserService($conn, 'medecin', 'Medecin');

if (!empty($id)) {
   $medcin = $medcinService->get($id);
   if ($medcin) {
      echo json_encode($medcin);
   }else{
      echo 'le patient n\'exist pas';
   }

}else{
   echo 'erreur';
}



?>