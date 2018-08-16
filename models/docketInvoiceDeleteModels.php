<?php
//include '../config/conexion.php';
/***docket_invoice_delete***/
class DocketInvoiceDelete{

	protected $id;
	protected $codigo_docket;
	protected $codigo_invoice;
	protected $codigo_usuario;
	protected $tipo;
	protected $detalle;
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;


	public function __construct($codigo_docket,$codigo_invoice,$codigo_usuario,$tipo,$detalle,$usuario,$fecha_creacion,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo_docket = $codigo_docket;
		$this->codigo_invoice = $codigo_invoice;
		$this->codigo_usuario = $codigo_usuario;
		$this->tipo = $tipo;
		$this->detalle = $detalle;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;

		$db->close();

	}

	static function solo(){
		return new self('','','','','','','','','');
	}

	static function soloCodigo($codigo){
		return new self($codigo,'','','','','','','','');
	}
	public function InsertDocketInvoice()
	{
		$db = new Conexion();
		$sql="INSERT INTO docket_invoice_delete (codigo_docket, codigo_invoice, codigo_usuario, tipo, detalle, usuario, fecha_creacion, estatus) VALUES ('$this->codigo_docket','$this->codigo_invoice', '$this->codigo_usuario','$this->tipo','$this->detalle','$this->usuario','$this->fecha_creacion','5')";
		$db->query($sql) or trigger_error("ERROR insertando en la tabla eliminados");

		$db->close();

	}
	//lista de los archos eleiminados entre (documentos y facturas del documento)
	public function ListDocketInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM docket_invoice_delete a JOIN usuarios b ON b.id_usuario=a.usuario WHERE estatus = '5'";
		$result = $db->query($sql) or trigger_error("ERROR Selecionando docuemntos y facturas eliminadas");

		$db->close();

		return $result;
	}
	//buscar los registros
	public function SelectIdDelete(){
		$db = new Conexion();
		$sql="SELECT * FROM docket_invoice_delete WHERE id=$this->id AND estatus = '5'";
		$result = $db->query($sql) or trigger_error("ERROR Selecionando docuemntos y facturas eliminadas");

		$db->close();

		return $result;
	}
	//regresar una factura
	public function ReturnInvoice(){
		$db = new Conexion();
		//eliminar de la tabla factura una factura
		$sql1="UPDATE invoice SET estatus='1' WHERE codigo_invoice='$this->codigo_invoice'";
		$db->query($sql1);
		//eliminar de la tabla servicios una factura
		$sql2="UPDATE invoices_services SET estatus='1' WHERE codigo_invoice='$this->codigo_invoice'";
		$db->query($sql2);
		//eliminar de la tabla envios una factura
		$sql3="UPDATE shipping_invoice SET estatus='1' WHERE codigo_invoice = '$this->codigo_invoice'";
		$db->query($sql3);
		//eliminar de la tabla proveedores una factura
		$sql4="UPDATE supplier_invoice SET estatus='1' WHERE codigo_invoice = '$this->codigo_invoice'";
		$db->query($sql4);
		//eliminar el registro d ela tabla de los eliminados
		$sql="DELETE FROM docket_invoice_delete WHERE codigo_invoice='$this->codigo_invoice' AND estatus = '5'";
		$result = $db->query($sql) or trigger_error("ERROR eliminando los registros en la tabla eliminado");

		$db->close();

	}
	//buscar todos los registros de una carpeta completa documento y facturas
	public function SelectAllDocInv(){
		$db = new Conexion();
		$sql="SELECT * FROM docket_invoice_delete WHERE codigo_docket='$this->codigo_docket' AND estatus = '5'";
		$result = $db->query($sql) or trigger_error("ERROR Selecionando docuemntos y facturas");

		$db->close();

		return $result;
	}
	//Retornar y eliminar un documento
	public function ReturnDocket(){
		$db = new Conexion();
		//se cambia el estatus en la tabla de documento
		$sql1="UPDATE docket SET estatus = 1 WHERE codigo='$this->codigo_docket'";
		$db->query($sql1) or trigger_error("ERROR actualizando el estatus de un docuemnto para ser retornado");
		//Se elimina el registro en la tabla de eliminados
		$sql2="DELETE FROM docket_invoice_delete WHERE id=$this->id AND estatus = '5'";
		$db->query($sql2) or trigger_error("ERROR eliminando los registros en la tabla eliminado");

		$db->close();

	}
}
?>
