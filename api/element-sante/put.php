<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../database/connectionPDO.php';



if (
   isset($_POST['idElement']) and
   isset($_POST['nom']) and
   isset($_POST['description']) 
   ) {
      if (
         !empty($_POST['idElement']) and
         !empty($_POST['nom']) and
         !empty($_POST['description'])
         ){
            $idElement = $_POST['idElement'];
            $nom = $_POST['nom'];
            $description = $_POST['description'];

            try {
               $s = $conn->prepare("UPDATE ElementSante SET 
                                       nom = :nom,
                                       description = :description
                                       WHERE idElement = :idElement
                                    ");
               $s->bindParam('nom', $nom);
               $s->bindParam('description', $description);
               $s->bindParam('idElement', $idElement);
               $s->execute();

               $count = $s->rowCount();
               
               if ($count) {
                   echo json_encode("success");
               }else{
                  throw new Exception();
               }

   
            } catch (Throwable $th) {
               http_response_code(400);
               echo json_encode('erreur');
            }
            
         }else{
            http_response_code(400);
            echo json_encode('erreur');
         }
}else{
   http_response_code(400);
   echo json_encode("form non valide");
}









?>