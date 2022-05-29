<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../database/connectionPDO.php';

$login = $_POST['login'];
$motDePasse = $_POST['motDePasse'];

if (
   !empty($login) &&
   !empty($motDePasse)
) {

   try {
      $s = $conn->prepare("SELECT motDePasse FROM Utilisateur WHERE email = :login OR cin = :login ");

      $s->bindParam('login', $login);
      $s->execute();

      $res = $s->fetch(PDO::FETCH_ASSOC);

      if ($res) {
         $hash_password = $res['motDePasse'];

         if (password_verify($motDePasse, $hash_password)) {
            $res = $conn->query("select * from Utilisateur WHERE email = '$login' OR cin = '$login'");
            $data = $res->fetch(PDO::FETCH_ASSOC);

            session_start();

            $_SESSION['idUser'] = $data['idUtilisateur'];
            $_SESSION['type'] = 'user';

            echo json_encode(array(
               "user" => $data,
               "idSession" => session_id()
            ));
         } else {
            throw new Exception(('wrong password'));
         }
      } else {
         throw new Exception('user not exist');
      }
   } catch (Exception $e) {
      http_response_code(400);
      echo json_encode($e->getMessage());
   }
} else {
   http_response_code(400);
   echo json_encode('form non valide');
}