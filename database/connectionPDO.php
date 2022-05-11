<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "cabinet_medical_db";

  try {
     $conn = new PDO("mysql:host=$hostname;dbname=$dbname",$username, $password);

  } catch (PDOException $e) {
     echo "Connection feild ".$e->getMessage();
  }
?>