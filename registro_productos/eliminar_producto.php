<?php
$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";    

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Verificar si el producto existe
        $stmt = $pdo->prepare("SELECT id FROM producto WHERE id = ?");
        $stmt->execute([$id]);
        $producto = $stmt->fetch();

        if ($producto) {
            // Si existe, eliminarlo
            $stmt = $pdo->prepare("DELETE FROM producto WHERE id = ?");
            $stmt->execute([$id]);
            echo "✅ Producto eliminado correctamente.";
        } else {
            echo "⚠️ Producto no encontrado.";
        }
    } else {
        echo "⚠️ ID de producto no proporcionado.";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<br><br>
<a href="listar_producto.php">Volver a la lista</a>
