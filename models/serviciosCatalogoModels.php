<?php 
include '../config/conexion.php';
/***servicios_catalogo***/
class ServiciosCatalogo{
	
	protected $id;
	protected $descripcion;
	protected $tipo_servicio;
	protected $fecha_creacion;
	protected $estatus;
	
	
	public function __construct($descripcion,$tipo_servicio,$fecha_creacion,$estatus,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->descripcion = $descripcion;
		$this->tipo_servicio = $tipo_servicio;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;
		
	}

	static function ningundato(){
		return new self('','','','','');
	} 

	public function SelectServicos(){
		$db = new Conexion();
		$sql="SELECT * FROM servicios_catalogo WHERE estatus=1 AND tipo_servicio='$this->tipo_servicio' ORDER BY descripcion ASC";
		$result = $db->query($sql);
		return $result;
	}
	public function ContarServicos(){
		$db = new Conexion();
		$sql="SELECT COUNT(*) AS total FROM `servicios_catalogo` WHERE `estatus`=1";
		$result = $db->query($sql);
		return $result;
	}
}
?>