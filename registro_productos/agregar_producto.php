<?php
$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";
$mensaje = "";

// Conectar a la BD
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener bodegas y monedas
    $bodegas = $pdo->query("SELECT id, nombre FROM bodega")->fetchAll(PDO::FETCH_ASSOC);
    $monedas = $pdo->query("SELECT id, nombre FROM moneda")->fetchAll(PDO::FETCH_ASSOC);

    // Procesar formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $codigo = trim($_POST['codigo']);
        $nombre = trim($_POST['nombre']);
        $bodega_id = $_POST['bodega_id'];
        $sucursal_id = $_POST['sucursal_id'];
        $moneda_id = $_POST['moneda_id'];
        $precio = $_POST['precio'];
        $materiales = $_POST['materiales'] ?? [];
        $descripcion = trim($_POST['descripcion']);

        // Validaciones
        if (empty($codigo) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/', $codigo)) {
            $mensaje = "❌ Error: Código inválido.";
        } elseif (empty($nombre) || strlen($nombre) < 2 || strlen($nombre) > 50) {
            $mensaje = "❌ Error: Nombre inválido.";
        } elseif (!is_numeric($precio) || $precio <= 0) {
            $mensaje = "❌ Error: Precio inválido.";
        } elseif (empty($descripcion) || strlen($descripcion) < 10 || strlen($descripcion) > 1000) {
            $mensaje = "❌ Error: Descripción inválida.";
        } elseif (empty($bodega_id) || empty($sucursal_id) || empty($moneda_id)) {
            $mensaje = "❌ Error: Selecciones incompletas.";
        } elseif (count($materiales) < 2) {
            $mensaje = "❌ Error: Seleccione al menos dos materiales.";
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM producto WHERE codigo = ?");
            $stmt->execute([$codigo]);
            if ($stmt->fetchColumn() > 0) {
                $mensaje = "❌ Error: Código ya existe.";
            } else {
                $sql = "INSERT INTO producto (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, materiales, descripcion)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$codigo, $nombre, $bodega_id, $sucursal_id, $moneda_id, $precio, implode(", ", $materiales), $descripcion]);
                $mensaje = "✅ Producto agregado exitosamente.";
            }
        }
    }
} catch (PDOException $e) {
    $mensaje = "❌ Error en la BD: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/validaciones.js" defer></script>
    <script src="js/cargar_sucursales.js" defer></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Formulario de Producto</h2>
        <form id="formProducto" method="post" class="form-grid">

            <div class="form-group col-2">
                <label>Código:</label>
                <input type="text" id="codigo" name="codigo">
                <span id="errorCodigo" class="error"></span>
            </div>

            <div class="form-group col-2">
                <label>Nombre:</label>
                <input type="text" id="nombre" name="nombre">
                <span id="errorNombre" class="error"></span>
            </div>

            <div class="form-group col-2">
                <label>Bodega:</label>
                <select id="bodega" name="bodega_id">
                    <option value=""></option>
                    <?php foreach ($bodegas as $b) { ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nombre']) ?></option>
                    <?php } ?>
                </select>
                <span id="errorBodega" class="error"></span>
            </div>

            <div class="form-group col-2">
                <label>Sucursal:</label>
                <select id="sucursal" name="sucursal_id">
                    <option value=""></option>
                </select>
                <span id="errorSucursal" class="error"></span>
            </div>

            <div class="form-group col-2">
                <label>Moneda:</label>
                <select id="moneda" name="moneda_id">
                    <option value=""></option>
                    <?php foreach ($monedas as $m) { ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nombre']) ?></option>
                    <?php } ?>
                </select>
                <span id="errorMoneda" class="error"></span>
            </div>

            <div class="form-group col-2">
                <label>Precio:</label>
                <input type="text" id="precio" name="precio" step="0.01">
                <span id="errorPrecio" class="error"></span>
            </div>

            <div class="form-group col-1">
                <label>Material del Producto:</label>
                <div class="checkbox-group">
                    <input type="checkbox" name="materiales[]" value="Madera"> Madera
                    <input type="checkbox" name="materiales[]" value="Metal"> Metal
                    <input type="checkbox" name="materiales[]" value="Plástico"> Plástico
                    <input type="checkbox" name="materiales[]" value="Vidrio"> Vidrio
                    <input type="checkbox" name="materiales[]" value="Textil"> Textil
                </div>
                <span id="errorMateriales" class="error"></span>
            </div>

            <div class="form-group col-1">
                <label>Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>
                <span id="errorDescripcion" class="error"></span>
            </div>

            <button type="submit">Guardar Producto</button>
        </form>

        <p class="mensaje"><?= $mensaje; ?></p>
    </div>
</body>
</html>
