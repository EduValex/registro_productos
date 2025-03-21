<?php
$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";
$mensaje = "";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del producto
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM producto WHERE id = ?");
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            die("Producto no encontrado.");
        }
    } else {
        die("ID no proporcionado.");
    }

    // Obtener bodegas, sucursales y monedas
    $bodegas = $pdo->query("SELECT id, nombre FROM bodega")->fetchAll(PDO::FETCH_ASSOC);
    $sucursales = $pdo->query("SELECT id, nombre FROM sucursal")->fetchAll(PDO::FETCH_ASSOC);
    $monedas = $pdo->query("SELECT id, nombre FROM moneda")->fetchAll(PDO::FETCH_ASSOC);

    // Si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $bodega_id = $_POST['bodega_id'];
        $sucursal_id = $_POST['sucursal_id'];
        $moneda_id = $_POST['moneda_id'];
        $precio = $_POST['precio'];
        $materiales = $_POST['materiales'];
        $descripcion = $_POST['descripcion'];

        $sql = "UPDATE producto SET codigo=?, nombre=?, bodega_id=?, sucursal_id=?, moneda_id=?, precio=?, materiales=?, descripcion=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codigo, $nombre, $bodega_id, $sucursal_id, $moneda_id, $precio, $materiales, $descripcion, $id]);

        $mensaje = "✅ Producto actualizado correctamente";
        $producto = $_POST; // Actualizar datos en el formulario
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">

    <title>Editar Producto</title>
</head>
<body>
<div class="container">

    <h2>Editar Producto</h2>
    <form method="post">
        <label>Código:</label><input type="text" name="codigo" value="<?php echo $producto['codigo']; ?>" required><br>
        <label>Nombre:</label><input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br>

        <label>Bodega:</label>
        <select name="bodega_id">
            <?php foreach ($bodegas as $b) {
                $selected = ($b['id'] == $producto['bodega_id']) ? "selected" : "";
                echo "<option value='{$b['id']}' $selected>{$b['nombre']}</option>";
            } ?>
        </select><br>

        <label>Sucursal:</label>
        <select name="sucursal_id">
            <?php foreach ($sucursales as $s) {
                $selected = ($s['id'] == $producto['sucursal_id']) ? "selected" : "";
                echo "<option value='{$s['id']}' $selected>{$s['nombre']}</option>";
            } ?>
        </select><br>

        <label>Moneda:</label>
        <select name="moneda_id">
            <?php foreach ($monedas as $m) {
                $selected = ($m['id'] == $producto['moneda_id']) ? "selected" : "";
                echo "<option value='{$m['id']}' $selected>{$m['nombre']}</option>";
            } ?>
        </select><br>

        <label>Precio:</label><input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required><br>
        <label>Materiales:</label><textarea name="materiales" required><?php echo $producto['materiales']; ?></textarea><br>
        <label>Descripción:</label><textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea><br>

        <button type="submit">Actualizar Producto</button>
    </form>

    <p><?php echo $mensaje; ?></p>

    <a href="listar_producto.php">Volver a la lista</a>
    </div>
</body>
</html>
