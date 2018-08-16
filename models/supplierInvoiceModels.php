<?php
//include '../config/conexion.php';
/***supplier_invoice***/
class SupplierInvoice{

	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $supplier;
	protected $dinero;
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;


	public function __construct($codigo_invoice,$supplier,$dinero,$usuario,$fecha_creacion,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->supplier = $supplier;
		$this->dinero = $dinero;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;

		$db->close();

	}

	static function ningundato(){
		return new self('','','','','','','');
	}
	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','','');
	}
	public function InsertProvedorInvoice(){
		$db = new Conexion();
		$sql="INSERT INTO supplier_invoice(codigo_invoice,supplier,dinero,usuario,fecha_creacion,estatus) VALUES ('$this->codigo_invoice','$this->supplier','$this->dinero','$this->usuario','$this->fecha_creacion','1')";
		$db->query($sql);

		$db->close();
	}
	public function SelectProvedorInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM `supplier_invoice` WHERE codigo_invoice = '$this->codigo_invoice' AND  estatus IN (1,2)";
		$result = $db->query($sql);

		$db->close();

		return $result;
	}
	public function DeleteProvedorInvoice(){
		$db = new Conexion();
		$sql="DELETE FROM `supplier_invoice` WHERE id = '$this->id'";
		$db->query($sql);

		$db->close();

	}
}
?>
