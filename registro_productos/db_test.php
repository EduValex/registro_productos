<?php
$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
