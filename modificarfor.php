<?php
$conexion = new mysqli("localhost", "root", "", "coffeeshop");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

// 1. Si recibimos el ID por GET y aún no se envió el formulario de actualización
if (isset($_GET['id_cliente']) && !isset($_POST['actualizar'])) {
    $id_cliente = $_GET['id_cliente'];

    $consulta = "SELECT * FROM usuario WHERE id_cliente = '$id_cliente'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        ?>

        <h2>Modificar datos del cliente</h2>
        <form method="POST" action="modificarfor.php">
            <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $cliente['nombre']; ?>" required><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required><br>
            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $cliente['telefono']; ?>" required><br><br>
            <input type="submit" name="actualizar" value="Guardar Cambios">
        </form>

        <?php
    } else {
        echo "<p>No se encontró ningún cliente con el ID <strong>$id_cliente</strong>.</p>";
    }

// 2. Si ya se envió el formulario para actualizar
} elseif (isset($_POST['actualizar'])) {
    $cli = $_POST['id_cliente'];
    $nom = $_POST['nombre'];
    $em = $_POST['email'];
    $tel = $_POST['telefono'];

    $consulta = "UPDATE usuario 
                 SET nombre='$nom', email='$em', telefono='$tel' 
                 WHERE id_cliente='$cli'";

    if ($conexion->query($consulta)) {
        echo "<p>✅ Cliente actualizado correctamente.</p>";
    } else {
        echo "<p>❌ Error al actualizar los datos.</p>";
    }
}

$conexion->close();
?>
