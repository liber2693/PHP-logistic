<?php 
//include '../config/conexion.php';
/***docket_invoice_delete***/
class DocketInvoiceDelete{
	
	protected $id;
	protected $codigo_docket;
	protected $codigo_invoice;
	protected $tipo;
	protected $detalle;
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;
	
	
	public function __construct($codigo_docket,$codigo_invoice,$tipo,$detalle,$usuario,$fecha_creacion,$estatus,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->codigo_docket = $codigo_docket;
		$this->codigo_invoice = $codigo_invoice;
		$this->tipo = $tipo;
		$this->detalle = $detalle;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;
		
	}

	static function contar(){
		return new self('','','','','','','','','');
	} 

	static function soloCodigo($codigo){
		return new self($codigo,'','','','','','','','');
	}
	public function InsertDocketInvoice()
	{
		$db = new Conexion();
		$sql="INSERT INTO docket_invoice_delete (codigo_docket, codigo_invoice, tipo, detalle, usuario, fecha_creacion, estatus) VALUES ('$this->codigo_docket','$this->codigo_invoice','$this->tipo','$this->detalle','$this->usuario','$this->fecha_creacion','5')";
		$db->query($sql) or trigger_error("ERROR insertando en la tabla eliminados");
	}
}
?>