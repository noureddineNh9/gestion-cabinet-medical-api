<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include_once '../../utils/functions.php';
include '../../database/connectionPDO.php';


if (isset($_POST['idCompteRendu']) && 
   isset($_FILES['fichier'])) 
{

   if (!empty($_POST['idCompteRendu']))
   {
      try {
         $idCompteRendu = $_POST['idCompteRendu'];
      
         $uploadResult = uploadFile($_FILES['fichier'], "compteRendu");
      
         if ($uploadResult) {
            $url = $uploadResult; 
            $s = $conn->prepare("UPDATE CompteRendu SET  
                                 url = :url 
                                 WHERE idCompteRendu = :idCompteRendu");
         
            $s->bindParam('idCompteRendu', $idCompteRendu);
            $s->bindParam('url', $url);
         
            $s->execute();
            $count = $s->rowCount();
            
            $res = $conn->query("SELECT * FROM CompteRendu WHERE idCompteRendu = $idCompteRendu");
            $data = $res->fetch(PDO::FETCH_ASSOC);
   
            $res2 = $conn->query("SELECT * FROM Audio WHERE idCompteRendu=$idCompteRendu");
            $audio = $res2->fetch(PDO::FETCH_ASSOC);

            if ($audio) {
               $data["audio"] = $audio;
            }else{
               $data["audio"] = null;
            }

            if ($count > 0) {
               echo json_encode($data);
            }else{
               throw new Exception();
            }
         }else{
            throw new Exception();
         }
      
      } catch (PDOException $e) {
         http_response_code(400);
         echo json_encode('erreur' );
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