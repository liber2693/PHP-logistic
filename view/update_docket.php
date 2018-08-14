<?php
include '../models/documentoModels.php';
session_start();
if(empty($_SESSION['user']))
{
  //echo"<script>alert('You must login')</script>";
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}else{
  $codigo = base64_decode($_GET['docket']);
  $buscarDocket = Docket::soloCodigo($codigo);
  $array = $buscarDocket->selectDocket();
  if ($array->num_rows==0) {
    echo "no existe";
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
<body onload="llenar_paises(document.getElementById('id_origen').value,document.getElementById('id_destino').value)">
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
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i><b>EDIT DOCKET</b></h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-folder-open"></i><b>Update Docket</b></li>
            </ol>
          </div>
        </div>
      </section>
      <div class="col-lg-12">
        <!--tab nav start-->
        <section class="panel">
	      <header class="panel-heading tab-bg-primary ">
	        <ul class="nav nav-tabs">
	          <li class="">
	            <a data-toggle="tab" href="#home">Home</a>
	          </li>
	          <li class="">
	            <a data-toggle="tab" href="#about">About</a>
	          </li>
	          <li class="">
	            <a data-toggle="tab" href="#profile">Profile</a>
	          </li>
	          <li class="active">
	            <a data-toggle="tab" href="#contact">Contact</a>
	          </li>
	        </ul>
	      </header>
	      <div class="panel-body">
	        <div class="tab-content">
	          <div id="home" class="tab-pane">
	            Home
	          </div>
	          <div id="about" class="tab-pane">About</div>
	          <div id="profile" class="tab-pane">Profile</div>
	          <div id="contact" class="tab-pane active">Contact</div>
	        </div>
	      </div>
	    </section>
        <section class="panel">
          <header class="panel-heading">
          EDIT DOCKET
          </header>
          <div class="panel-body">
            <div class="tab-content">
              <div id="home" class="tab-pane active">
                <form class="form-horizontal" method="post" action="../controllers/documentoControllers.php" name="enviar_actualizacion" id="enviar_actualizacion">
                  <div class="form-group">
                    <label class="col-lg-2 control-label"><strong>DOCKET #</label>
                    <div class="col-lg-10">
                      <p class="form-control-static"><?php echo $codigo;?></strong></p>

                      <input type="hidden" name="codigo_docu" value="<?php echo $codigo;?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>SHIPPER</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="expedidor" id="expedidor" value="<?php echo $datos['shipper'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>DATE</strong></label>
                    <div class="col-sm-4">
                      <input name="fecha" type="text" class="form-control round-input fecha" readonly  placeholder="Enter Date" value="<?php echo $datos['fecha'];?>" id="fecha">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>PHONE</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="telefono" value="<?php echo $datos['telefono'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>CC #</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="cc" value="<?php echo $datos['cc'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>CONSIGNEE</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="consignee" value="<?php echo $datos['consignee'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>PO #</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="po" value="<?php echo $datos['po'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>ORIGIN COUNTRY</strong></label>
                    <div class="col-sm-2">
                      <input type="hidden" id="id_origen" value="<?php echo $datos['id_origen_pais'];?>">
                      <select name="pais_origen_Actualizacion" class="form-control round-input" autocomplete='country-name' id="pais_origen_Actualizacion">
                      </select>
                    </div>
                    <label class="col-sm-1 control-label"><strong>ORIGIN</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="origen" value="<?php echo $datos['lugar_origen'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>DESTINATION COUNTRY</strong></label>
                    <div class="col-sm-2">
                      <input type="hidden"  id="id_destino" value="<?php echo $datos['id_destino_pais'];?>">
                      <select name="pais_destino_Actualizacion" class="form-control round-input" autocomplete='country-name' id="pais_destino_Actualizacion">
                      </select>
                    </div>
                    <label class="col-sm-1 control-label"><strong>DESTINATION</strong></label>
                    <div class="col-sm-4">
                      <input type="text" name="destino" value="<?php echo $datos['lugar_destino'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>PIECES</strong></label>
                    <div class="col-sm-1">
                      <input type="text" name="pieza" value="<?php echo $datos['pieza'];?>" class="form-control round-input">
                    </div>
                    <label class="col-sm-1 control-label"><strong>TYPE</strong></label>
                    <div class="col-sm-3">
                      <input type="text" name="tipo_pieza" value="<?php echo $datos['tipo_pieza'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>WEIGHT</strong></label>
                    <div class="col-sm-1">
                      <input type="text" name="peso" value="<?php echo $datos['peso'];?>" class="form-control round-input">
                    </div>
                    <label class="col-sm-1 control-label"><strong>TYPE</strong></label>
                    <div class="col-sm-3">
                      <input type="text" name="tipo_peso" value="<?php echo $datos['tipo_peso'];?>" class="form-control round-input">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>HEIGHT</strong></label>
                    <div class="col-sm-1">
                      <input type="text" name="alto" value="<?php echo $datos['alto'];?>" class="form-control round-input">
                    </div>
                    <label class="col-sm-1 control-label"><strong>WIDTH</strong></label>
                    <div class="col-sm-1">
                      <input type="text" name="ancho"value="<?php echo $datos['ancho'];?>" class="form-control round-input">
                    </div>
                    <label class="col-sm-1 control-label"><strong>LONG</strong></label>
                    <div class="col-sm-1">
                      <input type="text" name="largo" value="<?php echo $datos['largo'];?>" class="form-control round-input">
                    </div>
                    <label class="col-sm-1 control-label"><strong>TYPE</strong></label>
                    <div class="col-sm-2">
                       <input type="text" name="medida" value="<?php echo $datos['tipo_dimension'];?>" class="form-control round-input">
                       <!--<select class="form-control m-bot15 round-input" autocomplete='tel-country-code' name="medida">
                        <option value=" ">SELECT</option>
                        <option value="CENTIMETERS" <?php //if ($datos['tipo_dimension']=='CENTIMETERS') { echo 'selected="selected"';}?> >CENTIMETERS</option>
                        <option value="INCHES" <?php //if ($datos['tipo_dimension']=='INCHES') { echo 'selected="selected"';}?> >INCHES</option>-->
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>DESCRIPTION</strong></label>
                    <div class="col-sm-8">
                      <textarea name="descripcion" class="form-control round-input" placeholder="Description"><?php echo $datos['descripcion'];?></textarea>
                    </div>
                  </div>
                  <div class="col-lg-offset-5 col-lg-9">
                    <button type="submit" name="actualizar_documento" id="actualizar_documento" class="btn btn-primary"><strong>UPDATE</strong></button>
                    <a href="docket_list.php">
                      <button type="button" class="btn btn-danger"><strong>GO BACK</strong></button>
                    </a>
                  </div>
                </form>
              </div>
              <!-- LA OTRA PANTALLA -->
              <div id="about" class="tab-pane">
                About
              </div>
            </div>
          </div>
        </section>
         <!--tab nav start-->
      </div>
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->
  <!-- javascripts -->
  <?php include('pie.php');?>
  <script src="../js/documento.js" type="text/javascript"></script>
</body>
</html>
<?php
  }
}
?>
