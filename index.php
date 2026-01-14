<?php
$mysqli = new mysqli("db", "app", "app", "app");

if ($mysqli->connect_error) {
    die("Error de conexión");
}

echo "Hola Javi";
