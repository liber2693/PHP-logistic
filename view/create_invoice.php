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
		echo "NO EXIST";
		}else{
		$datos = $array->fetch_array();

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>INVOICE</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="create_docket.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Docket List</li>
              <li><i class="fa fa-file-text-o"></i>Create Invoice</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                INVOICE
              </header>
              <div class="panel-body">
                <form class="form-horizontal" method="post" action="../controllers/invoiceControllers.php">
                	<div class="form-group">
	                    <label class="col-lg-2 control-label"><strong>DOCKET #</strong></label>
	                    <div class="col-lg-10">
	                      <p class="form-control-static"><strong><?php echo $datos['codigo'];?></strong></p>
                        <input type="hidden" name="codigo_documento" id="codigo_documento" value="<?php echo $datos['codigo'];?>">
                        <input type="hidden" name="usuario_documento" id="usuario_documento" value="<?php echo $_SESSION['id_usuario'];?>">
                        <input type="hidden" value="<?php echo $tipo;?>" name="tipo" id="tipo">
                    	</div>
                  	</div>
        					<div class="form-group">
        						<label class="col-sm-2 control-label"><strong>SUPPLIER</strong></label>
        					</div>
        					<?php
        					for ($i=1; $i<7; $i++) {
        						# code...
        					?>
        					<div class="form-group <?php if($i!=1){echo"ocultar";}?>" id='campoSupplier<?php echo $i;?>'>
        						<label class="col-sm-2 control-label"><strong><?php echo "#" .$i;?></strong></label>
        						<div class="col-sm-4">
        							<input type="text" id="supplier[<?php echo $i;?>]" name="supplier[<?php echo $i;?>]" placeholder="Supplier <?php echo "#".$i;?>"  class="form-control">
        						</div>
        						<div class="col-sm-4">
        							<?php
        							if($i!=6){
        							?>
        							<button type="button" id="mas[<?php echo $i;?>]" name="mas[<?php echo $i;?>]" class="btn btn-primary" title="Bootstrap 3 themes generator" onclick="visible(<?php echo $i;?>)"><i class="fa fa-plus" aria-hidden="true"></i></button>
        							<?php
        							}
        							if ($i!=1) {
        								# code...
        							?>
        							<button type="button" id="menos[<?php echo $i;?>]" name="menos[<?php echo $i;?>]" class="btn btn-danger" title="Bootstrap 3 themes generator" onclick="invisible(<?php echo $i;?>)"><i class="fa fa-minus" aria-hidden="true"></i></button>
        							<?php
        							}
        							?>
        						</div>
        					</div>
        					<?php
        					}
        					?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>BILL TO</strong></label>
                    <div class="col-sm-10">
                      <input type="text" id="quien_paga" name="quien_paga" class="form-control round-input">
                    </div>
                  </div>
                  <header class="panel-heading">
                    ADD SERVICE
                  </header>
                  <br>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>SERVICE</strong></label>
                    <div class="col-sm-6">
                      <select name="lista_servicios" class="form-control  round-input" autocomplete='country-name' id="lista_servicios">
                      <option value="0">SELECT SERVICE</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="radio1">
                    <label class="col-sm-2 control-label"><strong>US $</strong></label>
                    <input type="radio" id="us_dolar" name="bill_to" >
                    <div class="col-sm-4 ocultar" id="campo_us">
                      <input type="text" id="dinero_us" data-thousands="." data-decimal="," data-prefix="$. " name="dinero_us" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group" id="radio2">
                    <label class="col-sm-2 control-label"><strong>CAD $</strong></label>
                    <input type="radio" id="cad_dolar" name="bill_to" >
                    <div class="col-sm-4 ocultar" id="campo_cad">
                      <input type="text" id="dinero_cad" data-thousands="." data-decimal="," data-prefix="$. " name="dinero_cad" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>NOTE</strong></label>
                    <div class="col-sm-8">
                      <textarea name="nota" id="nota" class="form-control round-input" placeholder="Note"></textarea>
                    </div>
                  </div>
                  <center>
                    <button type="button" id="guardar_servicio" name="guardar_servicio" class="btn btn-primary fa fa-plus"></button>
                  </center>
                  <section class="panel">
                    <header class="panel-heading">
                      SERVICES SELECTED
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
                        <label class="col-sm-10 control-label">There is no shipping way available</label>
                    </div>
                  <?php
                  }
                  else{
                  ?>
                  <div class="form-group">
                    <label class="control-label col-lg-2" for="inputSuccess"><strong>SHIP VIA:</strong></label>
                    <div class="col-lg-10">
                    <?php
                      while($envios = $resultadosEnvio->fetch_array()){
                    ?>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="envio[]" name="envio[]" value="<?php echo "<b>" .$envios['id'] ."<b>";?>"> <?php echo "<b>" .$envios['descripcion'] ."<b>";?>&nbsp &nbsp &nbsp &nbsp &nbsp
                      </label>
                    <?php
                      }
                    ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-lg-2" for="inputSuccess"><strong>OTHER</strong></label>
                    <div class="col-sm-6">
                        <input type="text" name="otro" id="otro" class="form-control round-input">
                    </div>
                  </div>
                  <?php
                  }
                  ?>
                  <center>
                    <button type="submit" id="enviar_invoice" name="enviar_invoice" class="btn btn-primary"><b>SAVE</b></button>
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
