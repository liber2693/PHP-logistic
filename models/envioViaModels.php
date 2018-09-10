<?php
//include '../config/conexion.php';
/***envios_via***/
class EnviosVia{

	protected $id;
	protected $descripcion;
	protected $tipo;
	protected $fecha_creacion;
	protected $estatus;


	public function __construct($descripcion,$tipo,$fecha_creacion,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->descripcion = $descripcion;
		$this->tipo = $tipo;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;

		$db->close();

	}

	static function ningundato(){
		return new self('','','','','');
	}

	public function SelectViaEnvio(){
		$db = new Conexion();
		$sql="SELECT * FROM `envios_via` WHERE `estatus`='ACTIVO' ORDER BY id ASC";
		$result = $db->query($sql);

		$db->close();

		return $result;
	}
}
?>
