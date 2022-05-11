<?php

header("Access-Control-Allow-Origin: *");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';
include '../../services/medecinService.php';



if (isset($_GET['id'])) {
   $id = $_GET['id'];
   
   $medecinService = new MedecinService($conn);
   $res = $medecinService->delete($id);
   
   if ($res) {
      http_response_code(200);
      echo json_encode('ok');
   }else{
      http_response_code(400);
      echo json_encode('erreur');
   }

}else{
   http_response_code(400);
   echo json_encode("form non valide");
}









?>