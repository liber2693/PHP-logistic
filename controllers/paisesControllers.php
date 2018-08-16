<?php
include '../models/paisesModels.php';
include '../funciones/funciones.php';


$consulta = Paises::ningunPais();
$array1=$consulta->SelectPais();
if(isset($_GET['origen']) && !empty($_GET['origen'])){

	$codigo = $_GET['origen'];

	if ($array1->num_rows!=0) {

	    while ($resultado = $array1->fetch_assoc()){

	    $sele = ($codigo==$resultado['codigo']) ? 'selected' : '' ;

	    	echo '<option '.$sele.' value="'.$resultado['codigo'].'">'.$resultado['pais'].'</option>';
	    }
	    $array1->free();
	}
}
if (isset($_GET['destino']) && !empty($_GET['destino'])) {
	$codigo = $_GET['destino'];

	if ($array1->num_rows!=0) {

	    while ($resultado = $array1->fetch_assoc()){

	    $sele = ($codigo==$resultado['codigo']) ? 'selected' : '' ;


	       echo '<option '.$sele.' value="'.$resultado['codigo'].'">'.$resultado['pais'].'</option>';
	    }
	    $array1->free();
	}
}

	if ($array1->num_rows!=0) {
		echo '<option value="0">Select Country</option>';
	    while ($resultado = $array1->fetch_assoc()){
	        echo '<option value="'.$resultado['codigo'].'">'.$resultado['pais'].'</option>';
	    }
	    $array1->free();
	}else{
		echo '<option value="0">Select Country</option>';
	}

?>
