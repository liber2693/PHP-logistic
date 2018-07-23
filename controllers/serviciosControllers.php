<?php
include '../models/serviciosCatalogoModels.php';
$tipo=$_GET['tipo'];
$consulta = new ServiciosCatalogo('',$tipo,'','','');
//$consulta = ServiciosCatalogo::ningundato();
$array1=$consulta->SelectServicos();
while($resultado = $array1->fetch_assoc()) { 
  $data []= array('id' => $resultado['id'], 
  				  'descripcion' => $resultado['descripcion']
  				); 
} 
echo json_encode($data);
$array1->free_result();
 
?>