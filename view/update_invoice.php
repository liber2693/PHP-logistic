<?php
include '../models/invoiceModels.php';
include '../models/supplierInvoiceModels.php';
include '../models/envioViaModels.php';
include '../models/shippingInvoiceModels.php';
session_start();
if(empty($_SESSION['user']))
{
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}
else
{
	if(isset($_GET['invoice']) && !empty($_GET['invoice'])) {
		$codigo =base64_decode($_GET['invoice']);

		$buscarIvoice = Invoice::soloCodigo($codigo);
		$array = $buscarIvoice->SelectInvoice();
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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i><b>Update Invoice of Docket: <?php echo $datos['codigo_docket'];?></b></h3>
            <ol class="breadcrumb">
              <li><a href="create_docket.php"><i class="fa fa-home"></i>Home</a></li>
              <li><a href="detail_docket.php?docket=<?php echo base64_encode($datos['codigo_docket']);?>"><i class="icon_document_alt"></i>Docket: <?php echo $datos['codigo_docket'];?></a></li>
              <li><i class="fa fa-file-text-o"></i><b>Update Invoice</b></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <form class="form-horizontal" id="update_invoice" method="post" action="../controllers/invoiceControllers.php">
             <input type="hidden" name="update" value="update">
            <section class="panel">
              <header class="panel-heading">
                <b>INVOICE</b>
              </header><br><br>
              <div class="panel-body">
                	<div class="form-group">
                    <label class="col-lg-2 control-label"><b>Invoice #</b></label>
                    <div class="col-lg-10">
                      <?php // echo "<pre>";print_r($datos); ?>
                      <div class="col-sm-4">
                        <input type="text" id="codigo_usuario" name="codigo_usuario" class="form-control round-input" value="<?php echo $datos['codigo_usuario'];?>">
                      </div>
                      <input type="hidden" name="codigo_invoice" id="codigo_invoice" value="<?php echo $datos['codigo_invoice'];?>">
                      <input type="hidden" name="usuario_documento" id="usuario_documento" value="<?php echo $_SESSION['id_usuario'];?>">
                      <input type="hidden" name="tipo" id="tipo" value="<?php echo $datos['tipo_documento'];?>">
                    </div>
                    <label class="col-sm-2 control-label"><br><br><strong>Date</strong></label>
                    <div class="col-sm-4">
                      <br><br><input name="fecha" type="text" class="form-control round-input fecha" readonly  placeholder="Enter Date" value="<?php echo $datos['fecha'];?>"><br>
                    </div>
                  </div>
                  <div class="form-group">
        						<label class="col-sm-2 control-label"><strong>Supplier</strong></label>
        					</div>
                  <div id="mensaje_actulaizacion_invoice_supplier">
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><b>New Supplier</b></label>
                    <div class="col-sm-3">
                      <input type="text" id="supplierActualizar" placeholder="New Supplier"  class="form-control round-input limpiar">
                    </div>
                    <div class="col-sm-3">
                      <input type="text" id="pago_supplier" name="pago_supplier" placeholder="Cost" onchange="MASK(this,this.value,'-$##,###,##0.00',1)" class="form-control round-input limpiar">
                      <!--<input type="text" id="pago_supplier" placeholder="Cost" data-thousands="," data-decimal="." data-prefix="$. " name="pago_supplier" class="form-control round-input limpiar">-->
                    </div>
                    <div class="col-sm-3">
                      <button type="button" id="masActualizar" class="btn btn-primary" title="New Supplier" onclick="registrarSupplier()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                  </div>
                  <section class="panel">
                    <header class="panel-heading">
                      <b>SUPPLIER</b>
                    </header>
                    <table class="table table-condensed"  id="seleccion_supplier">
                      <thead>
                        <tr>
                          <th>Supplier</th>
                          <th>Price</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </section>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><b>Bill to</b></label>
                    <div class="col-sm-10">
                      <input type="text" id="quien_paga" value="<?php echo $datos['cliente'];?>" name="quien_paga" class="form-control round-input">
                    </div>
                  </div>
                  <!-- probando -->
                  <header class="panel-heading">
                    <b>ADD SERVICE</b>
                  </header>
                  <br>
                  <div id="mensaje_actulaizacion_servicios">
                  </div>
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
                      <input type="text" id="dinero_us" name="dinero_us" placeholder="$" onchange="MASK(this,this.value,'-$##,###,##0.00',1)" class="form-control round-input limpiar">

                      <!--<input type="text" id="dinero_us" data-thousands="." data-decimal="," data-prefix="$. " name="dinero_us" class="form-control round-input limpiar">-->
                    </div>
                  </div>
                  <div class="form-group" id="radio2">
                    <label class="col-sm-2 control-label"><b>$ CAD</b></label>
                    <input type="radio" id="cad_dolar" name="bill_to" >
                    <div class="col-sm-4 ocultar" id="campo_cad">

                      <input type="text" id="dinero_cad" name="dinero_cad" placeholder="$" onchange="MASK(this,this.value,'-$##,###,##0.00',1)" class="form-control round-input limpiar">

                      <!--<input type="text" id="dinero_cad" data-thousands="." data-decimal="," data-prefix="$. " name="dinero_cad" class="form-control round-input limpiar">-->
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
                      <b>SERVICES SELECTED</b>
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
                      while($envios = $resultadosEnvio->fetch_assoc()){
                        $id_envio = $envios['id'];
                        $buscarShippingEnvios=ShippingInvoice::CodigoIdSelecc($codigo,$id_envio);
                        $resultEnvio=$buscarShippingEnvios->EditViaEnvio();
                        $chek = ($resultEnvio->num_rows!=0) ? 'checked="checked"' : '' ;
                        $datoNota=$resultEnvio->fetch_assoc();
                        $resultEnvio->free();
                    ?>
                      <label class="checkbox-inline">
                        <input type="hidden" name="id_envio_seleccionado[]" value="<?php echo $datoNota['id'];?>">
                        <input type="checkbox" id="envio" name="envio[]" <?php echo $chek;?>  value="<?php echo $envios['id'];?>"> <?php echo "<b>" .$envios['descripcion'] ."</b>";?>
                      </label>
                    <?php
                      }
                      $resultadosEnvio->free();
                      $mostrarClase = ($datoNota['id_envio']==6) ? "" : "ocultar" ;
                    ?>
                    </div>
                  </div>
                  <div class="form-group <?php echo $mostrarClase;?>"  id="campo_otro">
                    <label class="control-label col-lg-2" for="inputSuccess"><b>Other</b></label>
                    <div class="col-sm-6">
                        <input type="text" name="otro" id="otro" value="<?php echo $datoNota['nota'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <?php
                  }
                  ?>
              </div>
            </section>
            <center>
              <button type="submit" id="enviar_update_invoice" name="enviar_update_invoice" class="btn btn-primary"><b>UPDATE INVOICE</b></button>
              <!--button type="reset" class="btn btn-info"><b>Reset</b></button>-->
            </center>
          </form>
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

  <script type="text/javascript" src="../js/jquery.maskMoney.min.js"></script>
  <script type="text/javascript" src="../js/funciones.js"></script>
  <script type="text/javascript" src="../js/invoice_update.js"></script>


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
