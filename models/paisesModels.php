<?php 
include '../config/conexion.php';
/***paises***/
class Paises{
	
	protected $codigo;
	protected $pais;
	protected $estatus;
		
	public function __construct($codigo,$pais,$estatus){
		
		$db = new Conexion();

		$this->codigo = $codigo;
		$this->pais = $pais;
		$this->estatus = $estatus;
	}

	static function ningunPais(){
		return new self('','','');
	} 

	public function SelectPais(){
		$db = new Conexion();
		$sql="SELECT * FROM `paises` WHERE estatus='1' ORDER BY pais ASC";
		$result = $db->query($sql);
		return $result;
	}
}
?>