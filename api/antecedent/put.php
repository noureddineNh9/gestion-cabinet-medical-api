<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

if (
    isset($_POST['idAntecedent']) and
    isset($_POST['nom']) and
    isset($_POST['type']) and
    isset($_POST['date']) and
    isset($_POST['description'])
) {
    if (
        !empty($_POST['idAntecedent']) and
        !empty($_POST['nom']) and
        !empty($_POST['type']) and
        !empty($_POST['date']) and
        !empty($_POST['description'])
    ) {
        $idAntecedent = $_POST['idAntecedent'];
        $nom = $_POST["nom"];
        $description = $_POST["description"];
        $date = $_POST["date"];
        $type = $_POST["type"];

        try {
            $s = $conn->prepare("UPDATE Antecedent SET 
                                    nom = :nom,
                                    description = :description,
                                    type = :type,
                                    date = :date
                                    WHERE idAntecedent = :idAntecedent");

            $s->bindParam('nom', $nom);
            $s->bindParam('description', $description);
            $s->bindParam('type', $type);
            $s->bindParam('date', $date);
            $s->bindParam('idAntecedent', $idAntecedent);
            $s->execute();

            $res = $conn->query("SELECT * from Antecedent where idAntecedent = $idAntecedent");
            $data = $res->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        } catch (Throwable $th) {
            http_response_code(400);
            echo json_encode('erreur');
        }
    } else {
        http_response_code(400);
        echo json_encode('erreur');
    }
} else {
    http_response_code(400);
    echo json_encode("form non valide");
}