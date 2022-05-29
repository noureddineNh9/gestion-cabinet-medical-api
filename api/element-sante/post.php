<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

if (
   isset($_POST['nom']) &&
   isset($_POST['description']) &&
   isset($_POST['idPatient'])
) {

   if (
      !empty($_POST['nom']) &&
      !empty($_POST['description']) &&
      !empty($_POST['idPatient'])
   ) {

      $nom = $_POST['nom'];
      $description = $_POST['description'];
      $idPatient = $_POST['idPatient'];

      try {
         $res = $conn->query("INSERT INTO ElementSante(nom, description, idPatient) 
                              values('$nom','$description', $idPatient)");

         // selectionner le dernier element
         $res2 = $conn->query("SELECT * FROM ElementSante ORDER BY idElement DESC LIMIT 1;");
         $data = $res2->fetch(PDO::FETCH_ASSOC);

         echo json_encode($data);
      } catch (PDOException $e) {
         http_response_code(400);
         echo json_encode('erreur');
      }
   } else {
      http_response_code(400);
      echo json_encode('erreur 2');
   }
} else {
   http_response_code(400);
   echo json_encode("form non valide");
}