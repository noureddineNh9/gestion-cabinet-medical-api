<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';

if (isset($_POST['nom']) && 
   isset($_POST['description']) && 
   isset($_POST['type']) && 
   isset($_POST['idCompteRendu'])) 
{

   if (!empty($_POST['nom']) &&
      !empty($_POST['type']) &&
      !empty($_POST['idCompteRendu']))
   {

      $nom = $_POST['nom'];
      $description = $_POST['description'];
      $type = $_POST['type'];
      $idCompteRendu = $_POST['idCompteRendu'];

      try {
         $uploadResult = uploadFile($_FILES['fichier'], "compteRendu");
         if ($uploadResult) {
            $url = $uploadResult;
            
            $s = $conn->prepare("UPDATE CompteRendu SET 
                        url = :url
                        WHERE idCompteRendu = :idCompteRendu");

            $s->bindParam('url', $url);
            $s->bindParam('idCompteRendu', $idCompteRendu);

            $s->execute();

         }


         
         $s = $conn->prepare("UPDATE CompteRendu SET 
                              nom = :nom,
                              description = :description, 
                              type = :type   
                              WHERE idCompteRendu = :idCompteRendu");

         $s->bindParam('nom', $nom);
         $s->bindParam('description', $description);
         $s->bindParam('type', $type);
         $s->bindParam('idCompteRendu', $idCompteRendu);

         $s->execute();

         $res2 = $conn->query("SELECT * FROM CompteRendu WHERE idCompteRendu = $idCompteRendu");
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