<?php
include '../config/conexion.php';
/***usuarios***/
class User{

	protected $id_usuario;
	protected $usuario;
	protected $password;
	protected $nombre;
	protected $apellido;
	protected $rol;
	protected $fecha_ultima_conexion;
	protected $hora_ultima_conexion;
	protected $actividad;
	protected $ip_equipo_conexion;
	protected $estatus_logico;

	public function __construct($usuario,$password,$nombre,$apellido,$rol,$fecha_ultima_conexion,$hora_ultima_conexion,$actividad,$ip_equipo_conexion,$estatus_logico, $id_usuario = ''){
		$db = new Conexion();

		$this->id_usuario = $id_usuario;
		$this->usuario = $usuario;
		$this->password = $password;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->rol = $rol;
		$this->fecha_ultima_conexion = $fecha_ultima_conexion;
		$this->hora_ultima_conexion = $hora_ultima_conexion;
		$this->actividad = $actividad;
		$this->ip_equipo_conexion = $ip_equipo_conexion;
		$this->estatus_logico = $estatus_logico;

		$db->close();
	}

	static function ningunDato(){
		return new self('','','','','','','','','','','');
	}

	static function soloId($id_usuario){
		return new self('','','','','','','','','','',$id_usuario);
	}
	static function usuarioContrasena($usuario,$password){
		return new self($usuario,$password,'','','','','','','','','');
	}

	public function InsertUser(){
		$db = new Conexion();

		$sql = "SELECT usuario FROM usuarios WHERE usuario='$this->usuario'";
		$result = $db->query($sql);
		if($result->num_rows==0){
			$sql1 = "INSERT INTO usuarios (usuario, password, nombre, apellido, rol, actividad, estatus_logico) VALUES ('$this->usuario','$this->password','$this->nombre','$this->apellido','$this->rol',0,1)";
			$db->query($sql1);
			
			return 1;
		}
		else
		{
			return 0;
		}
		$db->close();	
	}
	public function ListUser(){
		$db = new Conexion();

		$sql = "SELECT id_usuario,usuario,nombre,apellido,rol,actividad FROM usuarios ORDER BY id_usuario DESC";

		$result = $db->query($sql);

		$db->close();

		return $result;
	}
	public function idUser(){
		$db = new Conexion();

		$sql = "SELECT id_usuario,usuario,nombre,apellido,rol,actividad FROM usuarios WHERE id_usuario=$this->id_usuario";

		$result = $db->query($sql);

		$db->close();

		return $result;	
	}
	public function actualizarDatos(){

		$db = new Conexion();
		$sql = "UPDATE usuarios SET fecha_ultima_conexion='$this->fecha_ultima_conexion',
									hora_ultima_conexion='$this->hora_ultima_conexion',
									actividad = 1,
									ip_equipo_conexion = '$this->ip_equipo_conexion'
								WHERE id_usuario=$this->id_usuario";
		$db->query($sql);

		$db->close();
	}
	public function cerrarSesion(){

		$db = new Conexion();
		$sql = "UPDATE usuarios SET actividad = 0 WHERE id_usuario=$this->id_usuario";
		$db->query($sql);

		$db->close();
	}
}

?>
