<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "feria_incos";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Para que las tildes se vean bien
$conn->set_charset("utf8");
?>