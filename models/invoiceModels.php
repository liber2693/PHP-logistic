<?php 
include '../config/conexion.php';
/***invoice***/
class Invoice{
	
	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $codigo_docket; //clave de referencia con el documento
	protected $tipo_documento;
	protected $cliente;
	protected $precio;
	protected $usuario;
	protected $fecha_creacion;
	protected $fecha_modificacion;
	protected $estatus;
		
	
	public function __construct($codigo_invoice,$codigo_docket,$tipo_documento,$cliente,$precio,$usuario,$fecha_creacion,$fecha_modificacion,$estatus,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->codigo_docket = $codigo_docket;
		$this->tipo_documento = $tipo_documento;
		$this->cliente = $cliente;
		$this->precio = $precio;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->fecha_modificacion = $fecha_modificacion;
		$this->estatus = $estatus;
		
	}

	static function ningundato(){
		return new self('','','','','','','','','','');
	} 

	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','','');
	}
	public function InsertInvoice(){
		$db = new Conexion();
		$sql="INSERT INTO invoice(codigo_invoice, codigo_docket,tipo_documento, cliente,precio,usuario,fecha_creacion,estatus) VALUES ('$this->codigo_invoice','$this->codigo_docket','$this->tipo_documento','$this->cliente','','$this->usuario','$this->fecha_creacion','1')";
		$result = $db->query($sql);
	}
	public function SelectInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM invoice WHERE codigo_invoice = '$this->codigo_invoice'";
		$result = $db->query($sql);
		return $result;
	}

	//actualizar una factura 
	public function UpdateInvoice(){
		$db = new Conexion();
		$sql="UPDATE invoice SET cliente='$this->cliente', usuario='$this->usuario', fecha_modificacion = '$this->fecha_modificacion' WHERE codigo_invoice='$this->codigo_invoice'";
		$result = $db->query($sql);
	}

}
?>