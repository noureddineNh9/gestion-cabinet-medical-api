<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 360000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("content-type: application/json");

if(strtoupper($_SERVER["REQUEST_METHOD"]) == "OPTIONS"){
    echo json_encode([]);
    exit;
}


include './connection.php';


$res = $conn->query('select * from Classe');

$classes = array();

while($row = mysqli_fetch_assoc($res)){
   $item = array(
      "id" => $row['id_classe'],
      "nom" => $row['nom']
   );

   array_push($classes, $item);
}

echo json_encode($classes);



?>