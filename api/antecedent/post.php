<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

if (isset($_POST["nom"]) and isset($_POST['description']) and isset($_POST['type']) and isset($_POST['date']) and isset($_POST['idPatient'])) {
  if (!empty($_POST["nom"]) and !empty($_POST['description']) and !empty($_POST['type']) and !empty($_POST['date']) and !empty($_POST['idPatient'])) {

    $nom = $_POST["nom"];
    $description = $_POST["description"];
    $type = $_POST["type"];
    $date = $_POST["date"];
    $idPatient = $_POST["idPatient"];

    try {
      $s = $conn->prepare("INSERT into Antecedent values(null, :nom, :description, :type, :date, :idPatient)");

      $s->bindParam('nom', $nom);
      $s->bindParam('description', $description);
      $s->bindParam('type', $type);
      $s->bindParam('date', $date);
      $s->bindParam('idPatient', $idPatient);

      $s->execute();

      // selectionner le dernier element
      $res2 = $conn->query("SELECT * from Antecedent ORDER BY idAntecedent DESC LIMIT 1");
      $data = $res2->fetch(PDO::FETCH_ASSOC);

      echo json_encode($data);
    } catch (PDOException $e) {
      http_response_code(400);
      echo json_encode('erreur');
    }
  } else {
    http_response_code(400);
    echo json_encode('erreur');
  }
} else {
  http_response_code(400);
  echo json_encode('erreur');
}