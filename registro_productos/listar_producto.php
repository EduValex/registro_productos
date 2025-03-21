<?php
$host = "localhost";
$dbname = "productos_db";
$user = "postgres";
$password = "admin";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $productos = $pdo->query("SELECT p.id, p.codigo, p.nombre, b.nombre AS bodega, s.nombre AS sucursal, 
                                     m.nombre AS moneda, p.precio 
                              FROM producto p
                              JOIN bodega b ON p.bodega_id = b.id
                              JOIN sucursal s ON p.sucursal_id = s.id
                              JOIN moneda m ON p.moneda_id = m.id")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                window.location.href = "eliminar_producto.php?id=" + id;
            }
        }
    </script>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Lista de Productos</h2>
        <table border="1">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Bodega</th>
                <th>Sucursal</th>
                <th>Moneda</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($productos as $p) { ?>
                <tr>
                    <td><?= htmlspecialchars($p['codigo']) ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['bodega']) ?></td>
                    <td><?= htmlspecialchars($p['sucursal']) ?></td>
                    <td><?= htmlspecialchars($p['moneda']) ?></td>
                    <td><?= htmlspecialchars($p['precio']) ?></td>
                    <td>
                        <a href="editar_producto.php?id=<?= $p['id'] ?>" class="btn-editar">✏️ Editar</a>
                        <button onclick="confirmarEliminacion(<?= $p['id'] ?>)" class="btn-eliminar">🗑️ Eliminar</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
