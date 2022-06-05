<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';

if (
   isset($_POST['idCompteRendu']) &&
   isset($_POST['idSecretaire']) &&
   isset($_FILES['audio'])
) {

   if (
      !empty($_POST['idSecretaire']) &&
      !empty($_POST['idCompteRendu'])
   ) {

      $idCompteRendu = $_POST['idCompteRendu'];
      $idSecretaire = $_POST['idSecretaire'];
      $url = null;

      $uploadResult = uploadFile($_FILES['audio'], "audio");

      if ($uploadResult) {
         $url = $uploadResult;
      }

      try {
         $s = $conn->prepare("INSERT INTO Audio( idCompteRendu, url, idSecretaire) 
                              values(:idCompteRendu, :url, :idSecretaire)");

         $s->bindParam('url', $url);
         $s->bindParam('idCompteRendu', $idCompteRendu);
         $s->bindParam('idSecretaire', $idSecretaire);

         $s->execute();

         $res2 = $conn->query("SELECT * FROM Audio ORDER BY idAudio DESC LIMIT 1;");
         $data = $res2->fetch(PDO::FETCH_ASSOC);

         echo json_encode($data);
      } catch (PDOException $e) {
         http_response_code(400);
         echo json_encode($e->getMessage());
      }
   } else {
      http_response_code(400);
      echo json_encode('erreur 2');
   }
} else {
   http_response_code(400);
   echo json_encode("form non valide");
}