<?php

class Conexion extends mysqli{

	private $DB_HOST = 'localhost';
	private $DB_USUARIO = 'root';
	private $DB_CONTRASENA = '';
	private $DB_NOMRBE = 'liber_bd';


	public function __construct(){
		parent:: __construct($this->DB_HOST, $this->DB_USUARIO, $this->DB_CONTRASENA, $this->DB_NOMRBE);

		$this->set_charset('utf-8');

		$this->connect_errno ? die('Error en la conexion'. mysqli_connect_errno()) : $m = 'Conectado, ';

		//echo $m;
	}

}
?>
