<?php
//include '../config/conexion.php';
/***estatus***/
class Estatus{

	protected $id;
	protected $descripcion; //clave UNIQUE
	protected $estatus;

	public function __construct($descripcion,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->descripcion = $descripcion;
		$this->estatus = $estatus;

		$db->close();
	}

	static function ningundato(){
		return new self('','','');
	}

	/*public function SelectViaEnvio(){
		$db = new Conexion();
		$sql="SELECT * FROM `paises` WHERE estatus='1' ORDER BY pais ASC";
		$result = $db->query($sql);
		return $result;
	}*/
}
?>
