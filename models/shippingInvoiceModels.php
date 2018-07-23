<?php 
//include '../config/conexion.php';
/***shipping_invoice***/
class ShippingInvoice{
	
	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $id_envio;
	protected $nota;
	protected $usuario;
	protected $fecha_creacion;
	protected $estatus;
		
	
	public function __construct($codigo_invoice,$id_envio,$nota,$usuario,$fecha_creacion,$estatus,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->id_envio = $id_envio;
		$this->nota = $nota;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->estatus = $estatus;
		
	}

	static function ningundato(){
		return new self('','','','','','','');
	} 
	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','');
	}

	public function InsertfactipoEnvio(){
		$db = new Conexion();
		$sql="INSERT INTO shipping_invoice(codigo_invoice, id_envio, nota, usuario, fecha_creacion, estatus) VALUES ('$this->codigo_invoice','$this->id_envio','$this->nota','$this->usuario','$this->fecha_creacion','1')";
		$result = $db->query($sql);
	}
	public function SelectViaEnvio(){
		$db = new Conexion();
		$sql="SELECT * FROM shipping_invoice a 
			  JOIN envios_via b ON b.id=a.id_envio
			  WHERE codigo_invoice ='$this->codigo_invoice' ";
		$result = $db->query($sql);
		return $result;
	}
}
?>

