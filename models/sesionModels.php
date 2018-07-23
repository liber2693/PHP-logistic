<?php 
include '../config/conexion.php';
/***usuarios***/
class Sesion{

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
	}

	static function ningunDato(){
		return new self('','','','','','','','','','','');
	} 

	static function soloUsuario($usuario){
		return new self($usuario,'','','','','','','','','','');
	}
	static function usuarioContrasena($usuario,$password){
		return new self($usuario,$password,'','','','','','','','','');
	}

	public function selectUsuario(){
		$db = new Conexion();

		$sql = "SELECT * FROM usuarios WHERE usuario='$this->usuario'";

		$result = $db->query($sql);

		return $result;
	}
	public function validarUsuario(){
		$db = new Conexion();

		$sql = "SELECT * FROM usuarios WHERE usuario='$this->usuario' AND password='$this->password' AND estatus_logico=1";

		$result = $db->query($sql);

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
	}
	public function cerrarSesion(){

		$db = new Conexion();
		$sql = "UPDATE usuarios SET actividad = 0 WHERE id_usuario=$this->id_usuario";
		$db->query($sql);
	}
}
?>