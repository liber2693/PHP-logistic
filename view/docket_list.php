<?php
include '../models/documentoModels.php';
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
            <h3 class="page-header"><i class="fa fa-archive"></i> Docket List</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="create_docket.php">Home</a></li>
              <li><i class="fa fa-archive"></i>Docket List</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <?php
        $listaDocumentos = Docket::contar();
        $array1 = $listaDocumentos->selectDocketAll();
        ?>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <div class="table-responsive">
                <table class="table display" id="table_id">
                  <thead>
                    <tr>
                      <th><i class="fa fa-archive"></i> Type</th>
                      <th><i class="fa fa-list"></i> Docket Number</th>
                      <th><i class="icon_profile"></i> Shipper</th>
                      <th><i class="icon_calendar"></i> Date</th>
                      <th><i class="fa fa-location-arrow"></i> Origin</th>
                      <th><i class="fa fa-location-arrow"></i> Destination</th>
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
                        <?php $tipo = ($datos['tipo']=='E') ? "EXPORT" : "IMPORT" ; echo $tipo;?>
                        <input type="hidden" name="tipo_documento" id="tipo_documento<?php echo $i;?>" value="<?php echo $datos['tipo'];?>">
                        <input type="hidden" name="codigo_documento" id="codigo_documento<?php echo $i;?>" value="<?php echo $datos['codigo'];?>">
                      </td>
                      <td><?php echo "<b>" .$datos['codigo'] ."</b>";?></td>
                      <td><?php echo "<b>" .ucwords($datos['shipper']) ."</b>";?></td>
                      <td><?php echo "<b>" .$datos['fecha'] ."</b>";?></td>
                      <td><?php echo "<b>" .ucwords($datos['origen'] .", " .$datos['lugar_origen']) ."</b>";?></td>
                      <td><?php echo "<b>" .ucwords($datos['destino'] .", " .$datos['lugar_destino']) ."</b>";?></td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-primary" style="font-size:15px" href="create_invoice.php?docket=<?php echo base64_encode($datos['codigo']);?>" data-toggle="tooltip" title="Add Invoice"><i class="fa fa-plus"></i></a>
                          <a class="btn btn-success" style="font-size:15px" href="update_docket.php?docket=<?php echo base64_encode($datos['codigo']);?>" data-toggle="tooltip" title="Edit Docket"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-warning" style="font-size:15px" href="detail_docket.php?docket=<?php echo base64_encode($datos['codigo']);?>" data-toggle="tooltip" title="Docket Details"><i class="fa fa-eye"></i></a>
                          <a class="btn btn-info" style="font-size:15px" href="docket_pdf.php?docket=<?php echo base64_encode($datos['codigo']);?>" data-toggle="tooltip" title="Docket Report"><i class="fa fa-file-pdf-o"></i></a>
                          <button class="btn btn-danger" style="font-size:16px" onclick="eliminar_documento(document.getElementById('codigo_documento<?php echo $i;?>').value,document.getElementById('tipo_documento<?php echo $i;?>').value)" data-toggle="modal" data-target="#myModal" title="Delete Docket"><i class="fa fa-trash-o"></i></button>
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
          <h4 class="modal-title">Elimnar Factura</h4>
        </div>
        <label>Esta seguro de eliminar el documento esto eliminara todas las facturas asociadas a este documento </label>
        <form class="form-inline" role="form" method="post" id="formulario_eliminar_documento" action="../controllers/documentoControllers.php">
          <div class="modal-body">
            <input type="hidden"  class="form-control m-bot15 round-input"  name="codigo_documento_elimanar" id="codigo_documento_elimanar">
            <input type="hidden"  class="form-control m-bot15 round-input"  name="tipo_documento_eliminar" id="tipo_documento_eliminar">
            <label for="origin">Description </label>
            <textarea class="form-control round-input" id="descripcion_eliminar" name="descripcion_eliminar" ></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" name="boton_eliminar" class="btn btn-success">Confirmar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </form>
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

    function eliminar_documento(id,tipo){
      console.log(id,tipo);
      $("#codigo_documento_elimanar").val(id);
      $("#tipo_documento_eliminar").val(tipo);
      $("#formulario_eliminar_documento").submit(function(event) {
        var codigo = $("#codigo_documento_elimanar").val();
        var tipo = $("#tipo_documento_eliminar").val();
        var descripcion = $("#descripcion_eliminar").val();
        if (descripcion.length==0) {
            $("#descripcion_eliminar").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#descripcion_eliminar").css({"border":"0"});
        }
      });
    }
  </script>
</body>
</html>
<?php
}
?>
