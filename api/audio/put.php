<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';

if (isset($_POST['nom']) && 
   isset($_POST['description']) && 
   isset($_POST['idSecretaire']) && 
   isset($_POST['idAudio'])) 
{

   if (!empty($_POST['nom']) &&
      !empty($_POST['idSecretaire']) &&
      !empty($_POST['idAudio']))
   {

      $nom = $_POST['nom'];
      $description = $_POST['description'];
      $idSecretaire = $_POST['idSecretaire'];
      $idAudio = $_POST['idAudio'];

      try {
         $uploadResult = uploadFile($_FILES['audio'], "audio");
         if ($uploadResult) {
            $url = $uploadResult;
            
            $s = $conn->prepare("UPDATE Audio SET 
                        url = :url
                        WHERE idAudio = :idAudio");

            $s->bindParam('url', $url);
            $s->bindParam('idAudio', $idAudio);

            $s->execute();

         }


         
         $s = $conn->prepare("UPDATE Audio SET 
                              nom = :nom,
                              description = :description,
                              idSecretaire = :idSecretaire
                              WHERE idAudio = :idAudio");

         $s->bindParam('nom', $nom);
         $s->bindParam('description', $description);
         $s->bindParam('idSecretaire', $idSecretaire);
         $s->bindParam('idAudio', $idAudio);

         $s->execute();

         $res2 = $conn->query("SELECT * FROM Audio WHERE idAudio = $idAudio");
         $data = $res2->fetch(PDO::FETCH_ASSOC);

         echo json_encode($data);


      } catch (PDOException $e) {
         http_response_code(400);
         echo json_encode($e->getMessage());
      }
   }else{
      http_response_code(400);
      echo json_encode('erreur 2');
   }
}else{
   http_response_code(400);
   echo json_encode("form non valide");
}