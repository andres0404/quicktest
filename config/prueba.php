<?php

include_once("class.conexion.php");
echo "<pre>";
echo "nulo";
echo "0" !== NULL;
echo "\n";
$con = \Conmain\ConexionSQL::getInstance();
$query = "SELECT * FROM `order`";
$fetch = $con->consultar($query);
print_r($fetch);

$fila = $con->obtenerFila($fetch);
print_r($fila);

$pdo = $con->get_ObjPDO();
$statement = $pdo->prepare($query);
$pp = $statement->execute();
echo $statement->rowCount();

$resultado = $pdo->query($query);
echo $resultado->rowCount();
echo "</pre>";