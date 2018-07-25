<?php
include '../models/documentoModels.php';
include '../models/archivoAdjuntosModels.php';
session_start();
if(empty($_SESSION['user']))
{
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}else{
  $codigo=base64_decode($_GET['docket']);
  $buscarDocket = Docket::soloCodigo($codigo);
  $array = $buscarDocket->selectDocket();
  $datos = $array->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>NETEX GLOBAL</title>
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
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
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i> DOCKET</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="../index.php">Home</a></li>
              <li><i class="fa fa-archive"></i><a href="docket_list.php">Docket List</a></li>
              <li><i class="fa fa-archive"></i>Docket Details</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
              DOCKET
              </header>
              <div class="panel-body">
                <div class="checkboxes">
                  <label class="label_check" for="checkbox-01">
                    <strong>DOCKET # : <?php echo $codigo;?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>SHIPPER: <?php echo ucwords($datos['shipper']);?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>PHONE #: <?php echo $datos['telefono'];?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>PO #: <?php echo $datos['codigo_zip'];?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>DATE: <?php echo $datos['fecha'];?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>ORIGIN: <?php echo ucfirst($datos['origen']) .", " .ucwords($datos['lugar_origen']);?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>DESTINATION: <?php echo ucfirst($datos['destino']) .", " .ucwords($datos['lugar_destino']);?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>PIECES: <?php echo $datos['pieza'] ." " .ucfirst($datos['tipo_pieza']);?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>WEIGHT: <?php echo $datos['peso'] ." " .ucfirst($datos['tipo_peso']);?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>DIMENS: <?php echo $datos['alto'] . " X "  .$datos['ancho'] ." X " .$datos['largo'] ." " .ucfirst(strtolower($datos['tipo_dimension']));?></strong>
                  </label>
                  <label class="label_check" for="checkbox-02">
                    <strong>NOTES: <?php echo ucfirst($datos['descripcion']);?></strong>
                  </label>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!--Documentos del ddocket-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                ATTACHMENTS:
              </header>
              <?php
              $archivos = ArchivoAdjuntos::soloCodigo($codigo);
              $array2 = $archivos->SelectArchivoAdjunto();
              if($array2->num_rows==0){
              ?>
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">NO ATTACHMENTS</label>
                </div>
              </div>
              <?php
              }else{
                $i=0;
                while($datos2=$array2->fetch_assoc()){
                $i++;
              ?>
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    <?php echo "<b>" .$i ."</b>";?>&nbsp;
                    <a target="_blank" href="<?php echo $datos2['url_ubicacion'];?>"><?php echo "<b>" .$datos2['nombre_archivo'] ."</b>";?></a>
                  </label>
                </div>
              </div>
              <?php
                }
              }
              ?>
            </section>
          </div>
        </div>
        <?php
        $listaFacturasDocu = Docket::soloCodigo($codigo);
        $array1 = $listaFacturasDocu->selectDocketInvoice();
        ?>
        <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <div class="table-responsive">
                  <table class="table display" id="table_id">
                    <thead>
                      <tr>
                        <th><i class="fa fa-archive"></i> Invoice Number</th>
                        <th><i class="fa fa-list"></i> Bill to</th>
                        <th><i class="icon_calendar"></i> Date</th>
                        <th><i class="icon_cogs"></i> Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while($datos=$array1->fetch_assoc())
                      {
                      ?>
                      <tr>
                        <td><strong><?php echo $datos['codigo_invoice'];?></strong></td>
                        <td><strong><?php echo ucwords($datos['cliente']);?></strong></td>
                        <td><strong><?php echo $datos['fecha_creacion'];?></strong></td>
                        <td>
                          <div class="btn-group">
                            <!--<a class="btn btn-primary" style="font-size:16px" href="create_invoice.php?docket=<?php //echo base64_encode($datos['codigo']);?>" data-toggle="tooltip" title="Add Invoice"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-success" style="font-size:16px" href="update_invoice.php?invoice=<?php echo base64_encode($datos['codigo_invoice']);?>" data-toggle="tooltip" title="Edit Invoice"><i class="fa fa-pencil"></i></a>
                            <!--<a class="btn btn-danger" style="font-size:16px" href="#" data-toggle="tooltip" title="Delete Docket"><i class="fa fa-trash-o"></i></a>-->
                            <a class="btn btn-warning" style="font-size:16px" href="detail_invoice.php?invoice=<?php echo base64_encode($datos['codigo_invoice']);?>" data-toggle="tooltip" title="See Invoice"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-info" style="font-size:16px" href="#" data-toggle="tooltip" title="Download Detail"><i class="fa fa-file-pdf-o"></i></a>
                          </div>
                        </td>
                      </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </section>
              <center>
                <a href="create_invoice.php?docket=<?php echo base64_encode($codigo);?>">
                <button type="button" class="btn btn-primary"><strong>ADD INVOICE </strong></button>
                  <a href="docket_list.php">
                  <button type="button" class="btn btn-danger"><strong>GO BACK</strong></button>
              </center>
            </div>
            <!-- <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <a href="create_invoice.php?docket=<?php //echo base64_encode($codigo);?>"><center><button class="btn btn-primary">ADD INVOICE AT THIS DOCKET</button><center></a>
              </div>
            </div>
          </div> -->

        </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

  <!-- javascripts -->
  <?php include('pie.php');?>
  <script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">
    $(document).ready( function () {
      $('#table_id').DataTable();
    });
  </script>


</body>

</html>
<?php } ?>
