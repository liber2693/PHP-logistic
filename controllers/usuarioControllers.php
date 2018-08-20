<?php
include '../models/usuarioModels.php';
include '../funciones/funciones.php';
session_start();
if (isset($_POST['usuario'])) {
	
	$nombre = post('nombre');
    $apellido = post('apellido');
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $password1 = md5($_POST['password1']);
    $password2 = md5($_POST['password2']);
	

    $crear_user = new User($usuario,$password2,$nombre,$apellido,$rol,'','','','','','');
    $respuesta = $crear_user->InsertUser();
	
	echo json_encode($respuesta);
}
if(isset($_GET['tabla']) && $_GET['tabla']==1){

	$lista_usuarios = User::ningunDato();
	$array = $lista_usuarios->ListUser();

	if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('id' => $resultado['id_usuario'],
                          'usuario' => $resultado['usuario'],
                          'nombre' => $resultado['nombre'],
                          'apellido' => $resultado['apellido'],
                          'rol' => $resultado['rol'],
                          'actividad' => $resultado['actividad'],
                        );
        }
	    $array->free();
    }else{
        $data=0;
    }

   	echo json_encode($data);
	
}
if(isset($_GET['id'])){
	$id = $_GET['id'];

	$usuario = User::soloId($id);
	$result = $usuario->idUser();
	$array = $result->fetch_assoc();

	echo json_encode($array); 
}
if (isset($_POST['id'])) {
	
	$id = $_POST['id'];
    $nombre = post('nombre');
    $apellido = post('apellido');
    $usuario = post('usuario');
    $rol = $_POST['rol'];
    $password1 = md5($_POST['password1']);
    $password2 = md5($_POST['password2']);
	
}

?>