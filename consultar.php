<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Coffeeshop");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar que se haya enviado no_pedido
if (isset($_GET['no_pedido']) && !empty($_GET['no_pedido'])) {
    $no_pedido = $_GET['no_pedido'];

    // Consulta multitabla actualizada con nombre de producto
    $sql = "SELECT 
                p.no_pedido,
                p.fecha,
                u.nombre AS nombre_cliente,
                u.email,
                u.telefono,
                pr.id_producto,
                pr.nombre AS nombre_producto,
                pr.precio,
                pr.descripcion
            FROM pedido p
            JOIN usuario u ON p.id_cliente = u.id_cliente
            JOIN producto pr ON p.id_producto = pr.id_producto
            WHERE p.no_pedido = ?";

    // Preparar consulta
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    // Cambia a "i" si no_pedido es entero
    $stmt->bind_param("s", $no_pedido);
    $stmt->execute();
    $resultado = $stmt->get_result();

    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Consulta de Pedido</title>
        <style>
            body {
                background-image: url('fondo-formulario.jpg');
                background-size: cover;
                background-position: center;
                font-family: Arial, sans-serif;
                color: #333;
                padding: 40px;
            }
            table {
                background-color: rgba(255, 255, 255, 0.9);
                border-collapse: collapse;
                width: 90%;
                margin: auto;
                box-shadow: 0 0 10px #999;
            }
            th, td {
                padding: 12px;
                border: 1px solid #aaa;
                text-align: center;
            }
            th {
                background-color: #c89f6d;
                color: white;
            }
            h2 {
                text-align: center;
                color: #5a3e28;
            }
        </style>
    </head>
    <body>";

    if ($resultado->num_rows > 0) {
        echo "<h2>Resultado del pedido</h2>";
        echo "<table>
                <tr>
                    <th>No Pedido</th>
                    <th>Fecha</th>
                    <th>Nombre Cliente</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>ID Producto</th>
                    <th>Nombre Producto</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                </tr>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['no_pedido']}</td>
                    <td>{$fila['fecha']}</td>
                    <td>{$fila['nombre_cliente']}</td>
                    <td>{$fila['email']}</td>
                    <td>{$fila['telefono']}</td>
                    <td>{$fila['id_producto']}</td>
                    <td>{$fila['nombre_producto']}</td>
                    <td>\${$fila['precio']}</td>
                    <td>{$fila['descripcion']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>No se encontró ningún pedido con ese número.</h2>";
    }

    echo "</body></html>";

    $stmt->close();
} else {
    echo "<p>Error: No se recibió el número de pedido.</p>";
}

$conexion->close();
?>
