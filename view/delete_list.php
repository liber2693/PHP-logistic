<?php
include '../models/documentoModels.php';
include '../models/docketInvoiceDelete.php';

session_start();
if(empty($_SESSION['user']))
{
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}else{
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
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-archive"></i> File Delete</h3>
            <ol class="breadcrumb">
              <li><a href="create_docket.php"><i class="fa fa-home"></i>Home</a></li>
              <li><i class="fa fa-archive"></i>File Delete</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <?php
        $listaDelete = DocketInvoiceDelete::solo();
        $array1 = $listaDelete->ListDocketInvoice();
        ?>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <div class="table-responsive">
                <table class="table display" id="table_id">
                  <thead>
                    <tr>
                      <th><i class="fa fa-archive"></i> Code Docket</th>
                      <th><i class="fa fa-list"></i> Code invoice</th>
                      <th><i class="icon_profile"></i> Type</th>
                      <th><i class="icon_profile"></i> usuario</th>
                      <th><i class="icon_calendar fa fa-location-arrow"></i> Fecha</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=0;
                    while($datos=$array1->fetch_assoc())
                    {
                    $i++;
                    ?>
                    <tr>
                      <td>
                        <input type="hidden" name="id_registro" id="id_registro<?php echo $i;?>" value="<?php echo $datos['id'];?>">
                        <input type="hidden" name="detalle" id="detalle<?php echo $i;?>" value="<?php echo $datos['detalle'];?>">

                        <?php echo "<b>" .$datos['codigo_docket'] ."</b>";?>
                      </td>
                      <td>
                        <b>
                        <?php 
                          $invoice_code = ($datos['codigo_invoice']==null) ? "DOCKET" : $datos['codigo_invoice'] ;
                          echo $invoice_code;
                        ?>
                        </b>
                      </td>
                      <td>
                        <b>
                        <?php if($datos['tipo']=="F"){
                          echo "IVOICE";
                        }else if ($datos['tipo']=="E") {
                          echo "EXPORT";
                        } else if($datos['tipo']=="I") {
                          echo "IMPORT";
                        }?>
                        </b>
                      </td>
                      <td><?php echo "<b>" .$datos['usuario']."</b>";?></td>
                      <td><?php echo "<b>" .$datos['fecha_creacion']."</b>";?></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-warning" style="font-size:16px" onclick="detalle(document.getElementById('detalle<?php echo $i;?>').value)" data-toggle="modal" data-target="#myModal" title="Delete Docket"><i class="fa fa-eye"></i></button>
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
          </div>
        </div>
        <!-- page end-->
      </section>
  </section>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">DETALLE</h4>
        </div>
        <label>Detalle del por que se elimino</label>
        <!--<form class="form-inline" role="form" method="post" id="formulario_eliminar_documento" action="../controllers/documentoControllers.php">-->
          <div class="modal-body">
            <label for="origin">Description </label>
            <p  id="detalle_delete"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        <!--</form>-->
      </div>
    </div>
  </div>

  <!-- container section start -->
  <!-- javascripts -->
  <?php include('pie.php');?>
  <script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">
    $(document).ready( function () {
      $('#table_id').DataTable();
    });

    function detalle(detalle){
      $("#detalle_delete").html(detalle);
    }
  </script>
</body>
</html>
<?php
}
?>
