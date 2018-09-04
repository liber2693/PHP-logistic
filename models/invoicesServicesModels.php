<?php
//include '../config/conexion.php';
/***invoices_services***/
class invoicesServices{

	protected $id;
	protected $codigo_invoice;
	protected $id_servicio;
	protected $precio_us;
	protected $precio_ca;
	protected $nota;
	protected $usuario;
	protected $fecha_registro;
	protected $estatus;

	public function __construct($codigo_invoice,$id_servicio,$precio_us,$precio_ca,$nota,$usuario,$fecha_registro,$estatus,$id = ''){

		$db = new Conexion();
		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->id_servicio = $id_servicio;
		$this->precio_us = $precio_us;
		$this->precio_ca = $precio_ca;
		$this->nota = $nota;
		$this->usuario = $usuario;
		$this->fecha_registro = $fecha_registro;
		$this->estatus = $estatus;

		$db->close();

	}

	static function ningunServicio(){
		return new self('','','','','','','','','');
	}
	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','');
	}

	public function InsertServiceInvoice(){
		$db = new Conexion();
		$sql="INSERT INTO invoices_services(codigo_invoice,id_servicio,precio_us,precio_ca,nota,usuario,fecha_registro,estatus)
			VALUES ('$this->codigo_invoice','$this->id_servicio','$this->precio_us','$this->precio_ca','$this->nota','$this->usuario','$this->fecha_registro',1)";
		$db->query($sql);

		$db->close();

	}
	public function SelectServiciosInvoice(){
		$db = new Conexion();
		$sql="SELECT b.id as codigo_ser, a.id as id_servicio,a.precio_us,a.precio_ca,a.nota,b.descripcion FROM invoices_services a JOIN servicios_catalogo b ON b.id=a.id_servicio WHERE a.codigo_invoice='$this->codigo_invoice' AND a.estatus IN (1,2)";
		$result = $db->query($sql);
		return $result;
	}
	public function DeleteServicio(){
		$db = new Conexion();
		$sql="DELETE FROM invoices_services WHERE id=$this->id";
		$result = $db->query($sql);
	}
}
?>
