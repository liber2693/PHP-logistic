<?php
include '../models/usuarioModels.php';
include '../funciones/funciones.php';
session_start();
$id_session = $_SESSION['id_usuario'];
$user_session = $_SESSION['user'];

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

	$lista_usuarios = User::soloId($id_session);
	$array = $lista_usuarios->ListUser();

	if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('id' => $resultado['id_usuario'],
                          'usuario' => $resultado['usuario'],
                          'nombre' => $resultado['nombre'],
                          'apellido' => $resultado['apellido'],
                          'rol' => $resultado['rol'],
                          'actividad' => $resultado['actividad'],
                          'estatus' => $resultado['estatus_logico'],
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
if (isset($_POST['id']) && !empty($_POST['id'])) {
	
	$id = $_POST['id'];
    $nombre = post('nombre');
    $apellido = post('apellido');
    $usuario = post('usuario_actualizar');
    $rol = $_POST['rol'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    $estatus = $_POST['estatus'];

    $actualizar_user = new User($usuario,$password2,$nombre,$apellido,$rol,'','','','',$estatus,$id);
    $respuesta = $actualizar_user->UpdateUser();
    //echo "<pre>";print_r($respuesta);die();
    
    echo json_encode($respuesta);
	
}
if(isset($_POST['id_registro'])){

	$id_registro = $_POST['id_registro'];

	$elimnar_usuario = User::soloId($id_registro);
	$result = $elimnar_usuario->DeleteUser();
	
	echo json_encode(1);
}

if(isset($_GET['text'])){
	
  $text = $_GET['text'];

  $buscar_user = new User($text,'','','','','','','','','','');
  $respuesta = $buscar_user->SelectUser();
  
  echo json_encode($respuesta);
  //echo "<pre>";print_r($respuesta);die();	
}
?>