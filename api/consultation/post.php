<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$idElement = $_POST['idElement'];
$idMedecin = $_POST['idMedecin'];
$type = $_POST['type'];
$motif = $_POST['motif'];
$duree = $_POST['duree'];
$hauteur = $_POST['hauteur'];
$poid = $_POST['poid'];
$remarques = $_POST['remarques'];

if (
   !empty($idElement) ||
   !empty($idMedecin) ||
   !empty($type) ||
   !empty($motif) ||
   !empty($duree) ||
   !empty($hauteur) ||
   !empty($poid) ||
   !empty($remarques)
) {

   try {
      $s = $conn->prepare("INSERT INTO 
         Consultation(idElement, idMedecin, type, motif, duree, hauteur, poid, remarques)
         values (:idElement, :idMedecin, :type, :motif, :duree, :hauteur, :poid, :remarques)
      ");

      $s->bindParam('idElement', $idElement);
      $s->bindParam('idMedecin', $idMedecin);
      $s->bindParam('type', $type);
      $s->bindParam('motif', $motif);
      $s->bindParam('duree', $duree);
      $s->bindParam('hauteur', $hauteur);
      $s->bindParam('poid', $poid);
      $s->bindParam('remarques', $remarques);

      $s->execute();

      // selectionner le dernier element
      $res = $conn->query("SELECT c.*, e.nom AS elementSante from Consultation c, ElementSante e WHERE c.idElement = e.idElement ORDER BY idConsultation DESC LIMIT 1;");
      $data = $res->fetch(PDO::FETCH_ASSOC);

      echo json_encode($data);
   } catch (PDOException $e) {
      http_response_code(400);
      echo json_encode('erreur');
   }
} else {
   http_response_code(400);
   echo json_encode('form non valide');
}