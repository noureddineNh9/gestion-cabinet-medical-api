<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 360000");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, Set-Cookie, Cookie, Bearer');
header("content-type: application/json");


if (isset($_POST['idSession'])) {
   $idSession = $_POST['idSession'];

   session_id($idSession);
   session_start();

   if (session_destroy()) {
      echo json_encode("ok");
   } else {
      http_response_code(400);
   }
} else {
   http_response_code(400);
}