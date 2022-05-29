<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';

if (isset($_POST['nom']) && 
   isset($_POST['description']) && 
   isset($_POST['type']) && 
   isset($_POST['idConsultation'])) 
{

   if (!empty($_POST['nom']) &&
      !empty($_POST['type']) &&
      !empty($_POST['idConsultation']))
   {

      $nom = $_POST['nom'];
      $description = $_POST['description'];
      $type = $_POST['type'];
      $idConsultation = $_POST['idConsultation'];


      try {
         $s = $conn->prepare("INSERT INTO CompteRendu(nom, description, type, idConsultation) 
                              values(:nom, :description, :type, :idConsultation)");

         $s->bindParam('nom', $nom);
         $s->bindParam('description', $description);
         $s->bindParam('type', $type);
         $s->bindParam('idConsultation', $idConsultation);

         $s->execute();

         $res2 = $conn->query("SELECT * FROM CompteRendu ORDER BY idCompteRendu DESC LIMIT 1;");
         $data = $res2->fetch(PDO::FETCH_ASSOC);

         $data["Audio"] = null;

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