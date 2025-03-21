<?php
header('Content-Type: application/json'); // Responder en formato JSON

$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se recibió una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $bodega_id = $_POST['bodega_id'];
        $sucursal_id = $_POST['sucursal_id'];
        $moneda_id = $_POST['moneda_id'];
        $precio = $_POST['precio'];
        $materiales = implode(",", $_POST['materiales']); // Guardar checkboxes como texto separado por comas
        $descripcion = $_POST['descripcion'];

        // Verificar si el código ya existe en la base de datos
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM producto WHERE codigo = ?");
        $stmt->execute([$codigo]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(["success" => false, "message" => "El código del producto ya está registrado."]);
            exit();
        }

        // Insertar el nuevo producto
        $sql = "INSERT INTO producto (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, materiales, descripcion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codigo, $nombre, $bodega_id, $sucursal_id, $moneda_id, $precio, $materiales, $descripcion]);

        echo json_encode(["success" => true]);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error de conexión: " . $e->getMessage()]);
}
?>
