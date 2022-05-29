<?php


header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';
//idRDV, type, status, dateRDV, dateCreation,
try {
   $res = $conn->query("select r.*, CONCAT(u1.nom, ' ', u1.prenom) AS nomPatient, CONCAT(u2.nom, ' ', u2.prenom) AS nomMedecin
      from RDV r, Utilisateur u1, Utilisateur u2 
      WHERE u1.idUtilisateur = r.idPatient 
      AND u2.idUtilisateur = r.idMedecin");
   $data = $res->fetchAll(PDO::FETCH_ASSOC);
   echo json_encode($data);
} catch (PDOException $e) {
   http_response_code(400);
   echo json_encode($e->getMessage());
}

?>