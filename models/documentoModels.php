<?php
include '../config/conexion.php';
/***docket***/
class Docket{

	protected $id;
	protected $codigo;
	protected $shipper; //vendedor
	 //provedor
	protected $telefono;
	protected $cc;
	protected $consignee;
	protected $po;
	protected $fecha;
	protected $id_origen_pais;
	protected $lugar_origen;
	protected $id_destino_pais;
	protected $lugar_destino;
	protected $pieza;
	protected $tipo_pieza;
	protected $peso;
	protected $tipo_peso;
	protected $alto;
	protected $ancho;
	protected $largo;
	protected $tipo_dimension;
	protected $descripcion;
	protected $comentarios;
	protected $tipo;
	protected $fecha_creacion;
	protected $fecha_modificacion;
	protected $usuario;
	protected $estatus;

	public function __construct($codigo,$shipper,$telefono,$cc,$consignee,$po,$fecha,$id_origen_pais,$lugar_origen,$id_destino_pais,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$tipo_dimension,$descripcion,$comentarios,$tipo,$fecha_creacion,$fecha_modificacion,$usuario,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo = $codigo;
		$this->shipper = $shipper;
		$this->telefono = $telefono;
		$this->cc = $cc;
		$this->consignee = $consignee;
		$this->po = $po;
		$this->fecha = $fecha;
		$this->id_origen_pais = $id_origen_pais;
		$this->lugar_origen = $lugar_origen;
		$this->id_destino_pais = $id_destino_pais;
		$this->lugar_destino = $lugar_destino;
		$this->pieza = $pieza;
		$this->tipo_pieza = $tipo_pieza;
		$this->peso = $peso;
		$this->tipo_peso = $tipo_peso;
		$this->alto = $alto;
		$this->ancho = $ancho;
		$this->largo = $largo;
		$this->tipo_dimension = $tipo_dimension;
		$this->descripcion = $descripcion;
		$this->comentarios = $comentarios;
		$this->tipo = $tipo;
		$this->fecha_creacion = $fecha_creacion;
		$this->fecha_modificacion = $fecha_modificacion;
		$this->usuario = $usuario;
		$this->estatus = $estatus;

		$db->close();

	}

	static function contar(){
		return new self('','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}

	static function soloCodigo($codigo){
		return new self($codigo,'','','','','','','','','','','','','','','','','','','','','','','','','','');
	}
	public function selectContar(){
		$db = new Conexion();

		$sql = "SELECT COUNT(*) AS EXISTENCIA FROM `docket`";

		$result = $db->query($sql);

		$db->close();

		return $result;
	}
	public function crearDocumento()
	{
		$db = new Conexion();
		$sql="INSERT INTO docket(codigo,shipper,telefono,cc,consignee,po,fecha, id_origen_pais, lugar_origen, id_destino_pais, lugar_destino, pieza, tipo_pieza, peso, tipo_peso, alto, ancho, largo, tipo_dimension, descripcion, tipo, fecha_creacion, usuario, estatus)
			VALUES ('$this->codigo','$this->shipper','$this->telefono','$this->cc','$this->consignee','$this->po','$this->fecha','$this->id_origen_pais','$this->lugar_origen','$this->id_destino_pais','$this->lugar_destino','$this->pieza','$this->tipo_pieza','$this->peso','$this->tipo_peso','$this->alto','$this->ancho','$this->largo','$this->tipo_dimension','$this->descripcion','$this->tipo','$this->fecha_creacion','$this->usuario','1')";
		$db->query($sql) or trigger_error("ERROR insertando codigo de documento");

		$db->close();
	}

	public function selectDocket(){
		$db = new Conexion();
		$sql="SELECT a.codigo,a.shipper,a.fecha,a.telefono,a.cc,a.consignee,a.po,a.id_origen_pais,a.lugar_origen,
					 a.id_destino_pais,a.lugar_destino, a.pieza,a.tipo_pieza,a.peso,a.tipo_peso,a.alto,a.ancho,a.largo,
					 a.tipo_dimension,a.descripcion,a.comentarios, b.pais AS origen,c.pais AS destino
					 FROM docket a
					 JOIN paises b ON b.codigo=a.id_origen_pais
					 JOIN paises c ON c.codigo=a.id_destino_pais
					 WHERE a.codigo='$this->codigo' AND a.estatus='1'";
					//print_r($sql);die();
		$resultado = $db->query($sql);

		$db->close();

		return $resultado;
	}

	public function selectDocketAll(){
		$db = new Conexion();
		$sql="SELECT a.id,a.codigo,a.shipper,a.fecha, a.lugar_origen, a.lugar_destino, b.pais AS origen, c.pais AS destino,a.tipo,a.comentarios FROM docket a
				JOIN  paises b ON b.codigo=a.id_origen_pais
				JOIN  paises c ON c.codigo=a.id_destino_pais
				WHERE a.estatus='1'";
		$resultado = $db->query($sql);

		$db->close();

		return $resultado;
	}

	public function selectDocketInvoice(){
		$db = new Conexion();
		$sql="SELECT a.codigo_invoice,a.codigo_docket,a.codigo_usuario,a.fecha,a.tipo_documento,a.cliente,a.usuario,a.fecha_creacion,
			  a.fecha_modificacion,a.estatus,b.descripcion,a.pagos,a.comentarios FROM invoice a JOIN estatus b ON b.id=a.estatus
			  WHERE a.codigo_docket='$this->codigo' AND a.estatus IN(1,2)";
		$resultado = $db->query($sql);

		$db->close();

		return $resultado;
	}

	public function UpdateDocumento(){
		$db = new Conexion();
		$sql="UPDATE docket SET shipper='$this->shipper', telefono='$this->telefono', cc='$this->cc', consignee='$this->consignee', po='$this->po', fecha='$this->fecha', id_origen_pais='$this->id_origen_pais', lugar_origen='$this->lugar_origen',id_destino_pais='$this->id_destino_pais', lugar_destino='$this->lugar_destino', pieza='$this->pieza', tipo_pieza='$this->tipo_pieza', peso='$this->peso', tipo_peso='$this->tipo_peso', alto='$this->alto', ancho='$this->ancho', largo='$this->largo', tipo_dimension='$this->tipo_dimension', descripcion='$this->descripcion', fecha_modificacion='$this->fecha_modificacion' WHERE codigo='$this->codigo' ";
		;
		$db->query($sql) or trigger_error("ERROR actualizando el documento");

		$db->close();
	}

	//eliminar primero todo de invoice de un docket
	public function DeleteInvoiceDocket(){
		$db = new Conexion();
		//eliminar de la tabla factura una factura
		$sql1="UPDATE invoice SET fecha_modificacion='$this->fecha_modificacion', estatus='5' WHERE codigo_invoice='$this->codigo'";
		$db->query($sql1);
		//eliminar de la tabla servicios una factura
		$sql2="UPDATE invoices_services SET estatus='5' WHERE codigo_invoice='$this->codigo'";
		$db->query($sql2);
		//eliminar de la tabla envios una factura
		$sql3="UPDATE shipping_invoice SET estatus='5' WHERE codigo_invoice = '$this->codigo'";
		$db->query($sql3);
		//eliminar de la tabla proveedores una factura
		$sql4="UPDATE supplier_invoice SET estatus='5' WHERE codigo_invoice = '$this->codigo'";
		$db->query($sql4);

		$db->close();
	}
	//elimnar el documento
	public function DeleteDocket(){
		$db = new Conexion();
		$sql="UPDATE docket SET fecha_modificacion='$this->fecha_modificacion', usuario='$this->usuario', estatus = '5' WHERE codigo='$this->codigo'";
		$db->query($sql);

		$db->close();
	}

	public function SelectInvoiceDocket(){
		$db = new Conexion();
		$sql="SELECT a.codigo_invoice,a.codigo_docket,a.codigo_usuario,a.fecha,a.cliente,a.fecha_creacion,b.shipper,b.telefono,
					 b.lugar_origen,b.lugar_destino,b.pieza,b.tipo_pieza,b.peso,b.tipo_peso,b.alto,b.ancho,
					 b.largo,b.tipo_dimension,b.descripcion,b.comentarios,c.pais AS pais_origen,d.pais AS pais_destino, a.pagos, a.comentarios,b.fecha AS fecha_docket
					 FROM invoice a
					 JOIN docket b ON b.codigo=a.codigo_docket
					 JOIN paises c ON c.codigo=b.id_origen_pais
					 JOIN paises d ON d.codigo=b.id_destino_pais
					 WHERE
					 a.codigo_docket='$this->codigo' AND a.estatus IN (1,2)";
		$result = $db->query($sql);

		$db->close();

		return $result;
	}
	//cantidad de invoices por dockets
	public function SelectQuantityDocketInvoice(){
		$db = new Conexion();
		$sql="SELECT COUNT(*) AS total FROM invoice WHERE codigo_docket='$this->codigo' AND estatus IN(1,2)";
		$result = $db->query($sql);

		$db->close();

		return $result;
	}
	//cantidad de invoices por dockets con estatus PROCESADO
	public function SelectQuantityDocketInvoiceProcesadas(){
		$db = new Conexion();
		$sql="SELECT COUNT(*) AS total_pro FROM invoice WHERE codigo_docket='$this->codigo' AND estatus = 2";
		$result = $db->query($sql);

		$db->close();

		return $result;
	}
	//
	//agragar comentario a un documento
	public function InsertCommentsDocket(){
		$db = new Conexion();
		$sql = "UPDATE docket SET comentarios='$this->comentarios' WHERE codigo = '$this->codigo'";
		$db->query($sql);

		$db->close();
	}
}
?>
