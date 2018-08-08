<?php
include '../models/sesionModels.php';
include '../funciones/funciones.php';
date_default_timezone_set('America/Caracas');
$fecha=date("Y-m-d");
$hora=date("H:m:s");
if(!empty(post("usuario")) && !empty(post("password")))
{
	$usuario=post("usuario");
	$password=md5(post("password"));


	$consulta_usuario = Sesion::soloUsuario($usuario);
	$array1 = $consulta_usuario->selectUsuario();
	if ($array1->num_rows!=0) {

		$valida_usuario = Sesion::usuarioContrasena($usuario,$password);
		$array2 = $valida_usuario->validarUsuario();
		if($array2->num_rows!=0){
			session_start();
	 		$resultado_usuario=$array2->fetch_assoc();
			$id_usuario=$resultado_usuario['id_usuario'];
			$nombre=$resultado_usuario['nombre'];
			$apellido=$resultado_usuario['apellido'];
			$user=$resultado_usuario['usuario'];
			$tipo_usuario=$resultado_usuario['rol'];
			$maquina_ip = recibirIPReal();
			$actualizar = new Sesion('','','','','',$fecha,$hora,'',$maquina_ip,'',$id_usuario);
			$actualizar->actualizarDatos();

			//Variables SESSION
			$_SESSION['id_usuario']=$id_usuario;
			$_SESSION['nombre']=$nombre;
			$_SESSION['apellido']=$apellido;
			$_SESSION['user']=$user;
			$_SESSION['tipo_usuario']=$tipo_usuario;
			$_SESSION['acceso']='loco1234';
			$array2->free();

			echo json_encode(3); //LOGEADO con exito
			//	echo "<meta http-equiv='refresh' content='0;URL=../inicio.php'>";
		}
		else{
		echo json_encode(2); //contraseña invalidad
		// 	echo"<meta http-equiv='refresh' content='0;URL=../index.php?error=u'>";
		}
	}else{
		echo json_encode(1); //no existe el usuario
	}
}
if(isset($_GET['close'])){
	session_start();
	$id_usuario = $_SESSION['id_usuario'];
	$actualizar = new Sesion('','','','','','','','','','',$id_usuario);
	$actualizar->cerrarSesion();
		unset($_SESSION['user']);
		unset($_SESSION['nombre']);
		unset($_SESSION['apellido']);
		unset($_SESSION['tipo_usuario']);
		unset($_SESSION['acceso']);
		session_destroy();
		echo "<meta http-equiv='refresh' content='0;URL=../index.php'>";
}
//$conexion->close();
?>
