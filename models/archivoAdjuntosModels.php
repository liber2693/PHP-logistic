<?php 
//include '../config/conexion.php';
/***docket_import***/
class ArchivoAdjuntos{
	
	protected $id;
	protected $codigo;
	protected $url_ubicacion;
	protected $estatus_logico;
	protected $nombre_archivo;
	
	
	public function __construct($codigo,$url_ubicacion,$estatus_logico,$nombre_archivo,$id = ''){
		
		$db = new Conexion();

		$this->id = $id;
		$this->codigo = $codigo;
		$this->url_ubicacion = $url_ubicacion;
		$this->estatus_logico = $estatus_logico;
		$this->nombre_archivo = $nombre_archivo;	
		
	}

	static function ningunDato(){
		return new self('','','','','');
	} 
	static function soloCodigo($codigo){
		return new self($codigo,'','','','');
	}

	public function insertArchivoDocumento(){
		$db = new Conexion();
		$sql="INSERT INTO archivos_adjuntos(codigo,url_ubicacion,estatus_logico,nombre_archivo)
			VALUES ('$this->codigo','$this->url_ubicacion',1,'$this->nombre_archivo')";
		$db->query($sql) || die("ERROR insertando los registros de archivos");
	}
	public function SelectArchivoAdjunto(){
		$db = new Conexion();
		$sql="SELECT * FROM `archivos_adjuntos` WHERE codigo='$this->codigo' AND `estatus_logico`=1";
		$result = $db->query($sql);
		return $result;
	}
}
?>