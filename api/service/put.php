<?php
header("Access-Control-Allow-Origin: *");

include '../../database/connectionPDO.php';


if (isset($_POST['nom']) && isset($_POST['idService'])) {
   $nom = $_POST['nom'];
   $idService = $_POST['idService'];

   if (!empty($nom) and !empty($idService)) {
      try {
         $res = $conn->prepare("UPDATE Service set nom=:nom where idService=:idService ");
         $res->bindParam('nom', $nom);
         $res->bindParam('idService', $idService);
         $res->execute();
         echo json_encode("succes");
      } catch (PDOException $e) {
         echo json_encode($e->getMessage());
      }
   } else echo "remplir tous les champs !";
}