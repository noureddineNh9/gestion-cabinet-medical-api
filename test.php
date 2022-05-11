<?php

header("Access-Control-Allow-Origin: *");
$fichiers = $_FILES['fichiers'];


echo json_encode($fichiers);


?>