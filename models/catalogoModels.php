<?php
//include '../config/conexion.php';
/***catalogo***/
class Catalogo{

	protected $id;
	protected $correlativo;
	protected $tipo;
	protected $descripcion;
	protected $estatus;

	public function __construct($id,$correlativo,$tipo,$descripcion,$estatus){

		$db = new Conexion();

		$this->id = $id;
		$this->correlativo = $correlativo;
		$this->tipo = $tipo;
		$this->descripcion = $descripcion;
		$this->estatus = $estatus;
	}

	static function ningunCatalogo(){
		return new self('','','','','');
	}

	public function SelectCodigo(){
		$db = new Conexion();
		$sql="SELECT * FROM `catalogo` WHERE tipo='$this->tipo'";
		$result = $db->query($sql);
		return $result;
	}
	public function UpdateCorrelativo(){
		$db = new Conexion();
		$sql="UPDATE catalogo SET correlativo='$this->correlativo' WHERE id=$this->id AND tipo='$this->tipo'";
		$result = $db->query($sql);

	}
}
?>
