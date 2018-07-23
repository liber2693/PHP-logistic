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

    
?>