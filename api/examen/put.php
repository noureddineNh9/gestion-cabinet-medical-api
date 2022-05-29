<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';




if (isset($_POST['idExamen']) && 
   isset($_POST['nom']) && 
   isset($_POST['description']) && 
   isset($_POST['type']) && 
   isset($_POST['nomFichiers']) && 
   isset($_FILES['fichiers'])) 
{

   if (!empty($_POST['idExamen']) &&
      !empty($_POST['nom']) &&
      !empty($_POST['type']))
   {

      $idExamen = $_POST['idExamen'];
      $nom = $_POST['nom'];
      $description = $_POST['description'];
      $type = $_POST['type'];
      $nomFichiers = $_POST['nomFichiers'];
      
      $fichiers = restructureFilesArray($_FILES['fichiers']);

      try {
         $s = $conn->prepare("UPDATE Examen SET 
                              nom = :nom,
                              description = :description, 
                              type = :type   
                              WHERE idExamen = :idExamen");

         $s->bindParam('nom', $nom);
         $s->bindParam('description', $description);
         $s->bindParam('type', $type);
         $s->bindParam('idExamen', $idExamen);

         $s->execute();

         $res2 = $conn->query("SELECT * FROM Examen WHERE idExamen = $idExamen");
         $row = $res2->fetch(PDO::FETCH_ASSOC);
      

         // inserer les documents
         foreach($fichiers as $key => $fichier){
            if ($fichier['size']) {
         
         
               $nom = $nomFichiers[$key];
               $url = null;
               $uploadResult = uploadFile($fichier, "document");
               if ($uploadResult) {
                  $url = $uploadResult; 
               }

               $s = $conn->prepare("INSERT INTO Document(nom, url, idExamen) 
                                 values(:nom, :url, :idExamen)");

               $s->bindParam('nom', $nom);
               $s->bindParam('url', $url);
               $s->bindParam('idExamen', $idExamen);

               $s->execute();
            }
         }

         // selectionner les documents de l"examen
         $res2 = $conn->query("SELECT * FROM Document WHERE idExamen=$idExamen");
         $documentArr = $res2->fetchAll(PDO::FETCH_ASSOC);

         $row["documents"] = $documentArr;

         echo json_encode($row);

      } catch (PDOException $e) {
         http_response_code(400);
         echo json_encode($fichiers);
      }
   }else{
      http_response_code(400);
      echo json_encode('erreur 2');
   }
}else{
   http_response_code(400);
   echo json_encode("form non valide");
}