<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	ingresar un valor numero (o formula) formatear con -$##,###,##0.00<br>
	<input onchange="MASK(this,this.value,'-$##,###,##0.00',1)"><br>
	<br>
	ingresar un valor numero (o formula) formatear con 00/00/0000<br>
	<input onchange="MASK(this,this.value,'00/00/0000',1)"><br>
</body>
<script type="text/javascript" src="../js/funciones.js"></script>
</html>