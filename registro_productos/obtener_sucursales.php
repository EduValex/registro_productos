<?php
$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";

header("Content-Type: application/json");

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET["bodega_id"]) && is_numeric($_GET["bodega_id"])) {
        $bodega_id = $_GET["bodega_id"];
        
        $stmt = $pdo->prepare("SELECT id, nombre FROM sucursal WHERE bodega_id = ?");
        $stmt->execute([$bodega_id]);
        $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($sucursales);
    } else {
        echo json_encode([]); // Retorna vacío si no hay ID válido
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
