<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

include '../../database/connectionPDO.php';

$login = $_POST['login'];
$password = $_POST['password'];

if (
   !empty($login) &&
   !empty($password)
) {

   try {
      $s = $conn->prepare("SELECT * FROM Admin WHERE login = :login AND password = :password ");

      $s->bindParam('login', $login);
      $s->bindParam('password', $password);
      $s->execute();

      $res = $s->fetch(PDO::FETCH_ASSOC);

      if ($res) {

         session_start();

         $_SESSION['idUser'] = 'admin';
         $_SESSION['type'] = 'admin';

         echo json_encode(array(
            "user" => array(
               "idUtilisateur" => $login,
               "type" => "admin"
            ),
            "idSession" => session_id()
         ));
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