<?php

// Obtener datos del formulario
$cli = $_GET['id_cliente'];
$nom = $_GET['nombre'];
$em = $_GET['email'];
$tel = $_GET['telefono'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Coffeeshop");

if ($conexion->connect_errno) {
    echo"Fallo la conexión: " . $conexion->connect_error;
   // die("Fallo la conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// Consulta con sentencia preparada para evitar inyección SQL
$consulta = "INSERT INTO usuario (id_cliente, nombre, email, telefono) 
             VALUES($cli, '$nom', '$em', '$tel')";

//$resultado = $conexion->query($consulta);
$resultado=mysqli_query($conexion, $consulta);


//if ($conexion->errno) {
   // die($conexion->errno);
    
//}
if ($resultado ==false) {
  echo "Error en la consulta: " ;
    
}else {
    echo   "Registro guardado exitosamente<br><br>";
   echo "<table><br> <td>$cli<td><br>";
    echo "<table><br> <td>$nom<td><br>";
    echo "<table><br> <td>$em<td><br>";
   echo "<table><br> <td>$tel<td><br>";
   ;
}


$conexion->close();
?>