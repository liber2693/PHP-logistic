<?php
include '../models/serviciosCatalogoModels.php';
$tipo=$_GET['tipo'];
$consulta = new ServiciosCatalogo('',$tipo,'','','');
//$consulta = ServiciosCatalogo::ningundato();
$array=$consulta->SelectServicos();
if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) { 
          $data []= array('id' => $resultado['id'], 
  				  'descripcion' => $resultado['descripcion']
                        ); 
        } 
    }else{
        $data=0;
    }
//echo "<pre>";print_r($data);die();
echo json_encode($data);
//$array1->free_result();
 
?>