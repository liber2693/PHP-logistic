<?php
function recibirIPReal()
{
    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }

}
function calcularEdad($fecha_nacimiento){

	$dia=date("d");
	$mes=date("m");
	$ano=date("Y");


	$dianaz=date("d",strtotime($fecha_nacimiento));
	$mesnaz=date("m",strtotime($fecha_nacimiento));
	$anonaz=date("Y",strtotime($fecha_nacimiento));

	if (($mesnaz == $mes) && ($dianaz > $dia)) {
	$ano=($ano-1); }


	if ($mesnaz > $mes) {
	$ano=($ano-1);}

	$edad=($ano-$anonaz);

	return $edad;
}


function post($key)
{
   if($key)
   {
       //return isset($_POST[$key]) ? addslashes(trim($_POST[$key]," \t\r\0\x0B")) : null;
       return isset($_POST[$key]) ? addslashes(trim($_POST[$key]," ")) : null;
   }
}

//tipo de archivo
function tipo_archivo($tipo){
//echo "<pre>";print_r($tipo);die();
  switch ($tipo) {
    case 'application/pdf':
      $resul = '.pdf';   
    break;
    case 'image/jpeg':
      $resul = '.jpg';   
    break;
    case 'image/png':
      $resul = '.png';   
    break;

     
    default:
      $resul = null;
    break;
  }
  return $resul;
  
}

   //$nombre = post("nombre");


?>
