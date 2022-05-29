<?php

header("Access-Control-Allow-Origin: *");

include '../../database/connectionPDO.php';




if (isset($_POST['nom'])) {
   if (!empty($_POST['nom'])){
      $nom = $_POST['nom'];

      try {
         $res = $conn->query("INSERT INTO Service(nom) values('$nom')");
         // selectionner le dernier element
         $res2 = $conn->query("SELECT * FROM Service ORDER BY idService DESC LIMIT 1;");
         $service = $res2->fetch(PDO::FETCH_ASSOC);

         echo json_encode($service);

      } catch (Throwable $th) {
         http_response_code(400);
         echo json_encode('erreur');
      }
   }else{
      http_response_code(400);
      echo json_encode('erreur 2');
   }
}else{
   http_response_code(400);
   echo json_encode("form non valide");
}









?>