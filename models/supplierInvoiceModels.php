<?php 
//include '../config/conexion.php';
/***supplier_invoice***/
class SupplierInvoice{
	
	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $supplier; 
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;
		
	
	public function __construct($codigo_invoice,$supplier,$usuario,$fecha_creacion,$estatus,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->supplier = $supplier;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;
		
	}

	static function ningundato(){
		return new self('','','','','','');
	} 
	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','');
	}
	public function InsertProvedorInvoice(){
		$db = new Conexion();
		$sql="INSERT INTO supplier_invoice(codigo_invoice,supplier,usuario,fecha_creacion,estatus) VALUES ('$this->codigo_invoice','$this->supplier','$this->usuario','$this->fecha_creacion','1')";
		$result = $db->query($sql);
	}
	public function SelectProvedorInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM `supplier_invoice` WHERE codigo_invoice = '$this->codigo_invoice'";
		$result = $db->query($sql);
		return $result;
	}
}
?>
