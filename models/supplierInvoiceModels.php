<?php
//include '../config/conexion.php';
/***supplier_invoice***/
class SupplierInvoice{

	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $supplier;
	protected $dinero;
	protected $id_servicio;
	protected $nota;
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;


	public function __construct($codigo_invoice,$supplier,$dinero,$id_servicio,$nota,$usuario,$fecha_creacion,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->supplier = $supplier;
		$this->dinero = $dinero;
		$this->id_servicio = $id_servicio;
		$this->nota = $nota;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;

		$db->close();

	}

	static function ningundato(){
		return new self('','','','','','','','','');
	}
	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','','','','');
	}
	public function InsertProvedorInvoice(){
		$db = new Conexion();
		$sql="INSERT INTO supplier_invoice(codigo_invoice,supplier,dinero,id_servicio,nota,usuario,fecha_creacion,estatus)
				  VALUES ('$this->codigo_invoice','$this->supplier','$this->dinero','$this->id_servicio','$this->nota','$this->usuario','$this->fecha_creacion','1')";
		//print_r($sql);exit;
		$db->query($sql);

		$db->close();
	}
	public function SelectProvedorInvoice(){
		$db = new Conexion();
		$sql="SELECT a.id,a.codigo_invoice,a.supplier,a.dinero,b.descripcion,a.nota
			  FROM supplier_invoice a
			  JOIN servicios_catalogo b ON b.id = a.id_servicio
			  WHERE a.codigo_invoice = '$this->codigo_invoice'
			  AND  a.estatus IN (1,2)";
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
