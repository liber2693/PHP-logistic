<?php
//include '../config/conexion.php';
/***docket_import***/
class ArchivoAdjuntos{

	protected $id;
	protected $codigo;
	protected $url_ubicacion;
	protected $estatus_logico;
	protected $nombre_archivo;
	protected $identificador_docket;


	public function __construct($codigo,$url_ubicacion,$estatus_logico,$nombre_archivo,$identificador_docket,$id = ''){

		$db = new Conexion();

		$this->id = $id;
		$this->codigo = $codigo;
		$this->url_ubicacion = $url_ubicacion;
		$this->estatus_logico = $estatus_logico;
		$this->nombre_archivo = $nombre_archivo;
		$this->identificador_docket = $identificador_docket;

	}

	static function ningunDato(){
		return new self('','','','','','');
	}
	static function soloCodigo($codigo){
		return new self($codigo,'','','','','');
	}
	static function soloId($id){
		return new self('','','','','',$id);
	}

	public function insertArchivoDocumento(){
		$db = new Conexion();
		$sql="INSERT INTO archivos_adjuntos(codigo,url_ubicacion,estatus_logico,nombre_archivo,identificador_docket)
			VALUES ('$this->codigo','$this->url_ubicacion',1,'$this->nombre_archivo','$this->identificador_docket')";
		$db->query($sql) || die("ERROR insertando los registros de archivos");
	}
	public function SelectArchivoAdjunto(){
		$db = new Conexion();
		$sql="SELECT * FROM `archivos_adjuntos` WHERE codigo='$this->codigo' AND `estatus_logico`=1";
		$result = $db->query($sql);
		return $result;
	}
	public function SelectMax(){
		$db = new Conexion();
		$sql = "SELECT MAX(identificador_docket) AS max FROM `archivos_adjuntos` WHERE `codigo`='$this->codigo'";
		$result = $db->query($sql);
		return $result;
	}
	public function SelectIdRegister(){
		$db = new Conexion();
		$sql = "SELECT * FROM `archivos_adjuntos` WHERE id='$this->id'";
		$result = $db->query($sql);
		return $result;
	}
	public function DeleteArchivo(){
		$db = new Conexion();
		$sql = "DELETE FROM `archivos_adjuntos` WHERE id='$this->id'";
		$result = $db->query($sql);
	}


	
}
?>
