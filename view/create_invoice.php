<?php
include '../models/documentoModels.php';
//include '../models/serviciosCatalogoModels.php';
include '../models/envioViaModels.php';
session_start();
if(empty($_SESSION['user']))
{
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}
else
{
	if(isset($_GET['docket']) && !empty($_GET['docket'])) {
		$codigo = base64_decode($_GET['docket']);
    $tipo = substr($codigo, 0,1);
		$buscarDocket = Docket::soloCodigo($codigo);
		$array = $buscarDocket->selectDocket();
		if ($array->num_rows==0) {
		echo "no existe";
		}else{
		$datos = $array->fetch_array();
    $array->free();

	//echo "<pre>";print_r($datos);die();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>NETEX GLOBAL</title>
  <?php include('cabecera.php');?>
</head>
<body>
  <!-- container section start -->
	<section id="container" class="">
    <?php include('encabezado.php');?>
    <!--header end-->
    <!--sidebar start-->
     <?php include('menu.php');?>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i> <b>Create Invoice of Docket : <?php echo $codigo;?></b></h3>
            <ol class="breadcrumb">
              <li><a href="create_docket.php"><i class="fa fa-home"></i><b>Home</b></a></li>
              <li><a href="detail_docket.php?docket=<?php echo base64_encode($codigo);?>"><i class="icon_document_alt"></i>Docket: <?php echo $codigo;?></a></li>
              <li><i class="fa fa-file-text-o"></i><b>Create Invoice</b></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                <b>INVOICE</b>
              </header>
              <div class="panel-body">
                <form class="form-horizontal" id="crear_invoice" method="post" action="../controllers/invoiceControllers.php">
                	<div class="form-group">
	                    <label class="col-lg-2 control-label"><b>Docket #</b></label>
	                    <div class="col-lg-10">
	                      <p class="form-control-static"><strong><?php echo $datos['codigo'];?></strong></p>
                        <input type="hidden" name="codigo_documento" id="codigo_documento" value="<?php echo $datos['codigo'];?>">
                        <input type="hidden" name="usuario_documento" id="usuario_documento" value="<?php echo $_SESSION['id_usuario'];?>">
                        <input type="hidden" value="<?php echo $tipo;?>" name="tipo" id="tipo">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><b>Invoice #</b></label>
                      <div class="col-sm-4">
                        <input type="text" id="codigo_usuario" name="codigo_usuario" class="form-control round-input">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><b>Date</b></label>
                      <div class="col-sm-4">
                        <input type="text" id="fecha" name="fecha" class="form-control round-input fecha" placeholder="Enter Date" readonly="true">
                      </div>
                    </div>
          			<div class="form-group">
                      <div id="mensaje_suppleir"></div>
                      <label class="col-sm-2 control-label"><b>Supplier</b></label>
                      <div class="col-sm-2">
                        <input type="text" id="supplier" name="supplier" placeholder="Supplier"  class="form-control limpiar">
                      </div>
                      <div class="col-sm-3">
                        <select name="select_servicio" class="form-control" id="select_servicio">
                          <option value="0">Select Service</option>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" id="guardar_supplier" name="guardar_supplier" class="btn btn-primary" title="New Supplier"><i class="fa fa-plus" aria-hidden="true"></i></button>
                      </div>
                    </div>
                   	<div class="form-group" id="radio3">
	                    <label class="col-sm-2 control-label"><b>$ US</b></label>
	                    <input type="radio" id="us_dolar_supplier" name="bill_to_supplier" >
	                    <div class="col-sm-4 ocultar" id="campo_us_supplier">
	                		<input type="text" id="dinero_suppli_us" name="dinero_suppli_us" placeholder="Cost" onchange="MASK(this,this.value,'-$##,###,##0.00',1)" class="form-control limpiar">
	                    </div>
	                  </div>
	                  <div class="form-group" id="radio4">
	                    <label class="col-sm-2 control-label"><b>$ CAD</b></label>
	                    <input type="radio" id="cad_dolar_supplier" name="bill_to_supplier" >
	                    <div class="col-sm-4 ocultar" id="campo_cad_supplier">
	                     	<input type="text" id="dinero_suppli_cad" name="dinero_suppli_cad" class="form-control round-input limpiar" onchange="MASK(this,this.value,'-$##,###,##0.00',1)">
	                    </div>
	                </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label"><b>Note</b></label>
                      <div class="col-sm-8">
                        <textarea name="nota_supplier" id="nota_supplier" class="form-control resize limpiar" placeholder="Note Supplier" rows="4"></textarea>
                      </div>
                    </div>
                    <section class="panel">
                      <header class="panel-heading">
                        <b>SELECTED SUPPLIER</b>
                      </header>
                      <table class="table table-condensed"  id="lista_supplier_tabla">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Supplier</th>
                            <th>Service</th>
                            <th>Notes</th>
                            <th>US$ AMT</th>
                          	<th>CAD$ AMT</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </section>
                  <!--viejo registro de los supplier 03-09-2018 -->
        					<!--<div class="form-group <?php //if($i!=1){echo"ocultar";}?>" id='campoSupplier<?php //echo $i;?>'>
        						<label class="col-sm-1 control-label"><?php //echo("<b>" ."#".$i ."</b>"); ?></label>
        						<div class="col-sm-2">
        							<input type="text" id="supplier<?php //echo $i;?>" name="supplier[<?php //echo $i;?>]" placeholder="Supplier <?php //echo "#".$i;?>"  class="form-control">
        						</div>
                    <div class="col-sm-3">
                      <select name="select_servicio[<?php //echo $i;?>]" class="form-control" id="select_servicio<?php //echo $i;?>">
                        <option value="0">Select Service</option>
                      </select>
                    </div>
                    <div class="col-sm-2">
                      <input type="text" id="dinero<?php //echo $i;?>" name="dinero[<?php //echo $i;?>]" placeholder="Cost <?php //echo "#".$i;?>" onchange="MASK(this,this.value,'-$##,###,##0.00',1)" class="form-control">
                    </div>-->
                    <!--<input type="text" id="dinero<?php //echo $i;?>" name="dinero[<?php //echo $i;?>]" placeholder="Cost <?php //echo "#".$i;?>" data-thousands="," data-decimal="." data-prefix="$. "  class="form-control"> -->
                    <!--<div class="col-sm-4">
        							<?php
        							//if($i!=6){
        							?>
        							<button type="button" id="mas[<?php //echo $i;?>]" name="mas[<?php //echo $i;?>]" class="btn btn-primary" title="Bootstrap 3 themes generator" onclick="visible(<?php //echo $i;?>)"><i class="fa fa-plus" aria-hidden="true"></i></button>
        							<?php
        							/*}
        							if ($i!=1) {
        								# code...*/
        							?>
        							<button type="button" id="menos[<?php //echo $i;?>]" name="menos[<?php //echo $i;?>]" class="btn btn-danger" title="Bootstrap 3 themes generator" onclick="invisible(<?php //echo $i;?>)"><i class="fa fa-minus" aria-hidden="true"></i></button>
        							<?php
        							//}
        							?>
        						</div>
        					</div>-->
        					<?php
        					//}
        					?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><b>Bill to</b></label>
                    <div class="col-sm-6">
                      <input type="text" id="quien_paga" name="quien_paga" class="form-control round-input">
                    </div>
                  </div>
                  
                  <!-- probando -->
                  <header class="panel-heading">
                    <b>ADD SERVICE</b>
                  </header>
                  <br>
                  <div id="mensaje_servicios_selec"></div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><b>Service</b></label>
                    <div class="col-sm-6">
                      <select name="lista_servicios" class="form-control  round-input" autocomplete='country-name' id="lista_servicios">
                      <option value="0">Select Service</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="radio1">
                    <label class="col-sm-2 control-label"><b>$ US</b></label>
                    <input type="radio" id="us_dolar" name="bill_to" >
                    <div class="col-sm-4 ocultar" id="campo_us">
                      <input type="text" id="dinero_us" name="dinero_us" class="form-control round-input limpiar" onchange="MASK(this,this.value,'-$##,###,##0.00',1)">
                      <!--<input type="text" id="dinero_us" data-thousands="," data-decimal="." data-prefix="$. " name="dinero_us" class="form-control round-input limpiar">-->
                    </div>
                  </div>
                  <div class="form-group" id="radio2">
                    <label class="col-sm-2 control-label"><b>$ CAD</b></label>
                    <input type="radio" id="cad_dolar" name="bill_to" >
                    <div class="col-sm-4 ocultar" id="campo_cad">
                      <input type="text" id="dinero_cad" name="dinero_cad" class="form-control round-input limpiar" onchange="MASK(this,this.value,'-$##,###,##0.00',1)">
                      <!--<input type="text" id="dinero_cad" data-thousands="," data-decimal="." data-prefix="$. " name="dinero_cad" class="form-control round-input limpiar">-->
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><b>Note</b></label>
                    <div class="col-sm-8">
                      <textarea name="nota" id="nota" class="form-control resize limpiar" placeholder="Note" rows="4"></textarea>
                    </div>
                  </div>
                  <center>
                    <button type="button" id="guardar_servicio" name="guardar_servicio" class="btn btn-primary fa fa-plus"></button>
                  </center>
                  <section class="panel">
                    <header class="panel-heading">
                      <b>SELECTED SERVICES</b>
                    </header>
                    <table class="table table-condensed"  id="seleccion_servicios_tabla">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Description</th>
                          <th>Notes</th>
                          <th>US$ AMT</th>
                          <th>CAD$ AMT</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </section>
                  <?php
                  $buscarViaEnvio = EnviosVia::ningundato();
                  $resultadosEnvio = $buscarViaEnvio->SelectViaEnvio();
                  if ($resultadosEnvio->num_rows==0) {
                  ?>
                    <div class="form-group">
                        <label class="col-sm-10 control-label">No ship via available</label>
                    </div>
                  <?php
                  }
                  else{
                  ?>
                  <div id="mensaje_create_invoice"></div>
                  <div class="form-group" id="via_envio">
                    <label class="control-label col-lg-2" for="inputSuccess"><b>Ship Via:</b></label>
                    <div class="col-lg-10">
                    <?php
                      while($envios = $resultadosEnvio->fetch_array()){
                    ?>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="envio<?php echo $envios['id'];?>"  name="envio[]" value="<?php echo $envios['id'];?>"> <?php echo "<b>" .$envios['descripcion'] ."</b>";?>
                      </label>
                    <?php
                      }
                      $resultadosEnvio->free();
                    ?>
                    </div>
                  </div>
                  <div class="form-group ocultar" id="campo_otro">
                    <label class="control-label col-lg-2" for="inputSuccess"><b>Other</b></label>
                    <div class="col-sm-4">
                        <input type="text" name="otro" id="otro" class="form-control round-input">
                    </div>
                  </div>
                  <?php
                  }
                  ?>
                  <center>
                    <button type="submit" id="enviar_invoice" name="enviar_invoice" class="btn btn-primary"><b>Save</b></button>
                    <!--button type="reset" class="btn btn-info"><b>Reset</b></button>-->
                  </center>
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <?php include('pie.php');?>
  <script type="text/javascript" src="../js/invoice.js"></script>
  <script type="text/javascript" src="../js/funciones.js"></script>
  <script type="text/javascript" src="../js/jquery.maskMoney.min.js"></script>


  </body>

</html>
<?php
		}
	}
	else{
		echo"<meta http-equiv='refresh' content='0;URL=create_docket.php'>";
	}
}
?>
