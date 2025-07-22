<?php
$cli = $_GET['id_cliente'];
$conexion = new mysqli("localhost", "root", "", "Coffeeshop");
if($conexion->connect_errno){
    echo "Fallo la conexion".$conexion->conect_errno;
     }
     $conexion->set_charset("utf8");
     
     $consulta="DELETE FROM usuario WHERE(id_cliente=$cli)";

$resultados=mysqli_query($conexion,$consulta);

if($resultados=false){
echo "error en la consulta";
}else
{
    echo "Pedido eliminado<br><br>";
  
  if(mysqli_affected_rows($conexion)==0){
    echo "No hay registros que eliminar en este criterio";
  }else{
    echo "Se ha eliminado el".mysqli_affected_rows($conexion)."registros";
  }

}

$conexion->close();

?>