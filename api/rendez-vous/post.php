<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$dateRDV = $_POST['dateRDV'];
$type = $_POST['type'];
$status = $_POST['status'];
$idPatient = $_POST['idPatient'];
$idMedecin = $_POST['idMedecin'];

if (!empty($dateRDV) &&
   !empty($type) &&
   !empty($status) &&
   !empty($idMedecin) &&
   !empty($idPatient))
{

   try {
      $s = $conn->prepare("INSERT INTO 
         RDV(dateRDV, type, status, idPatient, idMedecin)
         values (:dateRDV, :type, :status, :idPatient, :idMedecin)
      ");

      $s->bindParam('dateRDV', $dateRDV);
      $s->bindParam('type', $type);
      $s->bindParam('status', $status);
      $s->bindParam('idMedecin', $idMedecin, );
      $s->bindParam('idPatient', $idPatient);

      $s->execute();

      // selectionner le dernier element
      // $res = $conn->query("SELECT * FROM RDV ORDER BY idRDV DESC LIMIT 1;");
      $res = $conn->query("select r.*, CONCAT(u1.nom, ' ', u1.prenom) AS nomPatient, CONCAT(u2.nom, ' ', u2.prenom) AS nomMedecin
      from RDV r, Utilisateur u1, Utilisateur u2 
      WHERE u1.idUtilisateur = r.idPatient 
      AND u2.idUtilisateur = r.idMedecin
      ORDER BY idRDV DESC LIMIT 1");
      $data = $res->fetch(PDO::FETCH_ASSOC);

      echo json_encode($data);

   } catch (PDOException $e) {
      http_response_code(400);
      echo json_encode($e->getMessage());
   }
}else{
   http_response_code(400);
   echo json_encode('form non valide');
}