<?php 
include '../config/conexion.php';
/***invoice***/
class Invoice{
	
	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $codigo_docket; //clave de referencia con el documento
	protected $cliente;
	protected $precio;
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;
		
	
	public function __construct($codigo_invoice,$codigo_docket,$cliente,$precio,$usuario,$fecha_creacion,$estatus,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->codigo_docket = $codigo_docket;
		$this->cliente = $cliente;
		$this->precio = $precio;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;
		
	}

	static function ningundato(){
		return new self('','','','','','','','');
	} 

	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','');
	}
	public function InsertInvoice(){
		$db = new Conexion();
		$sql="INSERT INTO invoice(codigo_invoice, codigo_docket, cliente,precio,usuario,fecha_creacion,estatus) VALUES ('$this->codigo_invoice','$this->codigo_docket','$this->cliente','','$this->usuario','$this->fecha_creacion','ACTIVO')";
		$result = $db->query($sql);
	}
	public function SelectInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM invoice WHERE codigo_invoice = '$this->codigo_invoice'";
		$result = $db->query($sql);
		return $result;
	}
}
?>