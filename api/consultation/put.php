<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../database/connectionPDO.php';

$idConsultation = $_POST['idConsultation'];
$motif = $_POST['motif'];
$hauteur = $_POST['hauteur'];
$poid = $_POST['poid'];
$remarques = $_POST['remarques'];

if (
   !empty($idConsultation) ||
   !empty($motif) ||
   !empty($hauteur) ||
   !empty($poid) ||
   !empty($remarques)
) {
   try {
      $s = $conn->prepare("UPDATE Consultation SET 
                              motif = :motif,
                              hauteur = :hauteur,
                              poid = :poid,
                              remarques = :remarques
                              WHERE idConsultation = :idConsultation
                           ");

      $s->bindParam('motif', $motif);
      $s->bindParam('hauteur', $hauteur);
      $s->bindParam('poid', $poid);
      $s->bindParam('remarques', $remarques);
      $s->bindParam('idConsultation', $idConsultation);
      $s->execute();

      $count = $s->rowCount();

      if ($count) {
         echo json_encode("success");
      } else {
         throw new Exception();
      }
   } catch (Throwable $th) {
      http_response_code(400);
      echo json_encode('erreur');
   }
} else {
   http_response_code(400);
   echo json_encode("form non valide");
}