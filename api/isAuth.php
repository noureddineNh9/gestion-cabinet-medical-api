<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 360000");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, Set-Cookie, Cookie, Bearer');
header("content-type: application/json");


include '../database/connectionPDO.php';


if (isset($_POST['idSession'])) {
   $idSession = $_POST['idSession'];

   session_id($idSession);
   session_start();

   if ($_SESSION['idUser']) {

      $idUtilisateur = $_SESSION['idUser'];
      $type = $_SESSION['type'];

      if ($type === 'user') {


         try {
            $s = $conn->prepare("SELECT idUtilisateur, cin, nom, prenom, email, situationFamilliale, genre, tel, adresse, imageProfile, dateNaissance, type
               FROM Utilisateur WHERE idUtilisateur = $idUtilisateur");
            $s->execute();
            $user = $s->fetch(PDO::FETCH_ASSOC);

            if ($user) {
               echo json_encode($user);
            } else {
               throw new Exception();
            }
         } catch (Exception $e) {
            http_response_code(400);
            echo json_encode('false');
         }
      } else if ($type === "admin") {

         try {
            $s = $conn->prepare("SELECT login
               FROM Admin WHERE login = '$idUtilisateur'");
            $s->execute();
            $res = $s->fetch(PDO::FETCH_ASSOC);

            if ($res) {
               echo json_encode(array(
                  "idUtilisateur" => $idUtilisateur,
                  "type" => "admin"
               ));
            } else {
               throw new Exception();
            }
         } catch (Exception $e) {
            http_response_code(400);
            echo json_encode('false');
         }
      } else {
         http_response_code(400);
         echo json_encode('false');
      }
   } else {
      http_response_code(400);
      echo json_encode('false');
   }
} else {

   http_response_code(400);
}