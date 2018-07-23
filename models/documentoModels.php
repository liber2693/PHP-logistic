<?php
include '../config/conexion.php';
/***docket***/
class Docket{

	protected $id;
	protected $codigo;
	protected $shipper; //vendedor
	protected $supplier; //provedor
	protected $telefono;
	protected $codigo_zip;
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
	protected $tipo;
	protected $fecha_creacion;
	protected $fecha_modificacion;
	protected $usuario;
	protected $estatus;

	public function __construct($codigo,$shipper,$supplier,$telefono,$codigo_zip,$fecha,$id_origen_pais,$lugar_origen,$id_destino_pais,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$tipo_dimension,$descripcion,$tipo,$fecha_creacion,$fecha_modificacion,$usuario,$estatus,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo = $codigo;
		$this->shipper = $shipper;
		$this->supplier = $supplier;
		$this->telefono = $telefono;
		$this->codigo_zip = $codigo_zip;
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
		$this->tipo = $tipo;
		$this->fecha_creacion = $fecha_creacion;
		$this->fecha_modificacion = $fecha_modificacion;
		$this->usuario = $usuario;
		$this->estatus = $estatus;

	}

	static function contar(){
		return new self('','','','','','','','','','','','','','','','','','','','','','','','','');
	}

	static function soloCodigo($codigo){
		return new self($codigo,'','','','','','','','','','','','','','','','','','','','','','','','');
	}
	public function selectContar(){
		$db = new Conexion();

		$sql = "SELECT COUNT(*) AS EXISTENCIA FROM `docket`";

		$result = $db->query($sql);

		return $result;
	}
	public function crearDocumento()
	{
		$db = new Conexion();
		$sql="INSERT INTO docket(codigo,shipper,supplier,telefono,codigo_zip,fecha, id_origen_pais, lugar_origen, id_destino_pais, lugar_destino, pieza, tipo_pieza, peso, tipo_peso, alto, ancho, largo, tipo_dimension, descripcion, tipo, fecha_creacion, usuario, estatus)
			VALUES ('$this->codigo','$this->shipper','$this->supplier','$this->telefono','$this->codigo_zip','$this->fecha','$this->id_origen_pais','$this->lugar_origen','$this->id_destino_pais','$this->lugar_destino','$this->pieza','$this->tipo_pieza','$this->peso','$this->tipo_peso','$this->alto','$this->ancho','$this->largo','$this->tipo_dimension','$this->descripcion','$this->tipo','$this->fecha_creacion','$this->usuario',1)";
		$db->query($sql) or trigger_error("ERROR insertando codigo de documento");
	}
	public function selectDocket(){
		$db = new Conexion();
		$sql="SELECT a.codigo,a.shipper,a.supplier,a.fecha,a.telefono,a.codigo_zip,a.id_origen_pais,a.lugar_origen,
					 a.id_destino_pais,a.lugar_destino, a.pieza,a.tipo_pieza,a.peso,a.tipo_peso,a.alto,a.ancho,a.largo,
					 a.tipo_dimension,a.descripcion, b.pais AS origen,c.pais AS destino
					 FROM docket a
					 JOIN paises b ON b.codigo=a.id_origen_pais
					 JOIN paises c ON c.codigo=a.id_destino_pais
					 WHERE a.codigo='$this->codigo' AND a.estatus=1";
					//print_r($sql);die();
		$resultado = $db->query($sql);
		return $resultado;
	}
	public function selectDocketAll(){
		$db = new Conexion();
		$sql="SELECT a.id,a.codigo,a.shipper,a.supplier,a.fecha,b.pais AS origen, c.pais AS destino,a.tipo, a.lugar_origen, a.lugar_destino FROM docket a
				JOIN  paises b ON b.codigo=a.id_origen_pais
				JOIN  paises c ON c.codigo=a.id_destino_pais
				WHERE a.estatus='1'";
		$resultado = $db->query($sql);
		return $resultado;
	}
	public function selectDocketInvoice(){
		$db = new Conexion();
		$sql="SELECT * FROM invoice WHERE codigo_docket='$this->codigo' ";
		$resultado = $db->query($sql);
		return $resultado;
	}

	public function UpdateDocumento(){
		$db = new Conexion();
		$sql="UPDATE docket SET shipper='$this->shipper', telefono='$this->telefono', codigo_zip='$this->codigo_zip', fecha='$this->fecha', id_origen_pais='$this->id_origen_pais', lugar_origen='$this->lugar_origen',id_destino_pais='$this->id_destino_pais', lugar_destino='$this->lugar_destino', pieza='$this->pieza', tipo_pieza='$this->tipo_pieza', peso='$this->peso', tipo_peso='$this->tipo_peso', alto='$this->alto', ancho='$this->ancho', largo='$this->largo', tipo_dimension='$this->tipo_dimension', descripcion='$this->descripcion', fecha_modificacion='$this->fecha_modificacion' WHERE codigo='$this->codigo' ";
		;
		$db->query($sql) or trigger_error("ERROR actualizando el documento");
	}
}
?>
