<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['codigo'])) {
        $codigo = $_GET['codigo'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM producto WHERE codigo = ?");
        $stmt->execute([$codigo]);

        $existe = $stmt->fetchColumn() > 0;

        echo json_encode(["existe" => $existe]);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión"]);
}
?>
