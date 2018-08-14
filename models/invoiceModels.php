<?php
include '../config/conexion.php';
/***invoice***/
class Invoice{

	protected $id;
	protected $codigo_invoice; //clave UNIQUE
	protected $codigo_docket; //clave de referencia con el documento
	protected $codigo_usuario; //codigo registrado por el usuario que se lo proporciona otro sistema
	protected $fecha; //fecha a la que pertenece este invoice
	protected $tipo_documento;
	protected $cliente;
	protected $precio;
	protected $pagos;
	protected $comentarios;
	protected $usuario;
	protected $fecha_creacion;
	protected $fecha_modificacion;
	protected $estatus;


	public function __construct($codigo_invoice,$codigo_docket,$codigo_usuario,$fecha,$tipo_documento,$cliente,$precio,$pagos,$comentarios,$usuario,$fecha_creacion,$fecha_modificacion,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo_invoice = $codigo_invoice;
		$this->codigo_docket = $codigo_docket;
		$this->codigo_usuario = $codigo_usuario;
		$this->fecha = $fecha;
		$this->tipo_documento = $tipo_documento;
		$this->cliente = $cliente;
		$this->precio = $precio;
		$this->pagos = $pagos;
		$this->comentarios = $comentarios;
		$this->usuario = $usuario;
		$this->fecha_creacion = $fecha_creacion;
		$this->fecha_modificacion = $fecha_modificacion;
		$this->estatus = $estatus;

	}

	static function ningundato(){
		return new self('','','','','','','','','','','','','','');
	}

	static function soloCodigo($codigo_invoice){
		return new self($codigo_invoice,'','','','','','','','','','','','','');
	}
	public function InsertInvoice(){
		$db = new Conexion();
		if (!empty($this->fecha)) {
			$fechaSql = "fecha,";
			$var1="'$this->fecha',";
		}
		else{
			$fechaSql = null;
			$var1 = null;
		}
		$sql="INSERT INTO invoice(codigo_invoice, codigo_docket, codigo_usuario, ".$fechaSql." tipo_documento, cliente,precio,usuario,fecha_creacion,estatus) VALUES ('$this->codigo_invoice','$this->codigo_docket','$this->codigo_usuario', ".$var1." '$this->tipo_documento','$this->cliente','','$this->usuario','$this->fecha_creacion','1')";
		$result = $db->query($sql);
	}
	public function SelectInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM invoice WHERE codigo_invoice = '$this->codigo_invoice' AND estatus IN (1,2)";
		$result = $db->query($sql);
		return $result;
	}

	//actualizar una factura
	public function UpdateInvoice(){
		$db = new Conexion();
		$var1 = (!empty($this->fecha)) ? "fecha='$this->fecha'," : null ;
		$var2 = (!empty($this->codigo_usuario)) ? "codigo_usuario='$this->codigo_usuario'," : null ;
		$sql="UPDATE invoice SET  ".$var2." ".$var1." cliente='$this->cliente', usuario='$this->usuario', fecha_modificacion = '$this->fecha_modificacion' WHERE codigo_invoice='$this->codigo_invoice' AND estatus IN (1,2)";
		$result = $db->query($sql);
	}

	public function SelectInvoiceDocket(){
		$db = new Conexion();
		$sql="SELECT a.codigo_invoice,a.codigo_docket,a.codigo_usuario,a.fecha,a.cliente,a.fecha_creacion,b.shipper,b.telefono,
					 b.lugar_origen,b.lugar_destino,b.pieza,b.tipo_pieza,b.peso,b.tipo_peso,b.alto,b.ancho,
					 b.largo,b.tipo_dimension,b.descripcion,c.pais AS pais_origen,d.pais AS pais_destino, a.pagos,a.comentarios
					 FROM invoice a
					 JOIN docket b ON b.codigo=a.codigo_docket
					 JOIN paises c ON c.codigo=b.id_origen_pais
					 JOIN paises d ON d.codigo=b.id_destino_pais
					 WHERE
					 a.codigo_invoice='$this->codigo_invoice' AND a.estatus IN (1,2)";
		$result = $db->query($sql);
		return $result;
	}
	public function DeleteInvoice(){
		$db = new Conexion();
		//eliminar de la tabla factura una factura
		$sql1="UPDATE invoice SET fecha_modificacion='$this->fecha_modificacion', estatus='5' WHERE codigo_invoice='$this->codigo_invoice'";
		$db->query($sql1);
		//eliminar de la tabla servicios una factura
		$sql2="UPDATE invoices_services SET estatus='5' WHERE codigo_invoice='$this->codigo_invoice'";
		$db->query($sql2);
		//eliminar de la tabla envios una factura
		$sql3="UPDATE shipping_invoice SET estatus='5' WHERE codigo_invoice = '$this->codigo_invoice'";
		$db->query($sql3);
		//eliminar de la tabla proveedores una factura
		$sql4="UPDATE supplier_invoice SET estatus='5' WHERE codigo_invoice = '$this->codigo_invoice'";
		$db->query($sql4);
	}
	//cambiar estatus del registro para los procesos de las facturas
	public function UpdateStatusInvoice(){
		$db = new Conexion();
		$sql="UPDATE invoice SET estatus = 2 WHERE codigo_invoice='$this->codigo_invoice'";
		$result = $db->query($sql);

	}
	//agregar comentario a la factura
	public function UpdateComment(){
		$db = new Conexion();
		$sql="UPDATE invoice SET pagos = '$this->pagos', comentarios = '$this->comentarios' WHERE codigo_invoice='$this->codigo_invoice'";
		//echo "<pre>";print_r($sql);die();
		$result = $db->query($sql);

	}
}
?>
