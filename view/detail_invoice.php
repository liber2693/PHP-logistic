<?php
include '../models/invoiceModels.php';
include '../models/invoicesServicesModels.php';
include '../models/shippingInvoiceModels.php';
include '../models/supplierInvoiceModels.php';
session_start();
if(empty($_SESSION['user']))
{
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}
else
{
  if(isset($_GET['invoice'])){
    $codigo_factura = base64_decode($_GET['invoice']);
    $buscarInvoice = Invoice::soloCodigo($codigo_factura);
    $array = $buscarInvoice->SelectInvoice();
    if ($array->num_rows==0) {
    echo "NO EXIST";
    }else{
    $datos = $array->fetch_array();

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
            <h3 class="page-header"><i class="fa fa-file-text-o"></i><b>INVOICE</b></h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="../index.php"><b>Home</b></a></li>
              <li><i class="fa fa-home"></i><a href="detail_docket.php?docket=<?php echo base64_encode($datos['codigo_docket']);?>"><?php echo $datos['codigo_docket'];?></a></li>
              <li><i class="icon_document_alt"></i><b>Invoice Details</b></li>

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
                <div class="checkboxes">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="text-center">
                          <strong>DOCKET #: <?php echo $datos['codigo_docket'];?></strong>
                        </td>
                        <td class="text-center">
                          <strong>INVOICE #: <?php echo $datos['codigo_usuario'];?></strong>
                        </td>
                        <td class="text-center">
                          <strong>DATE:&nbsp;
                            <?php
                            $fecha = explode('-', $datos['fecha']);
                            echo "<b>" .$fecha[1] .'-' .$fecha[2] .'-' .$fecha[0] ."</b>";
                            ?></strong>
                        </td>
                        <td class="text-center">
                          <strong>BILL TO: <?php echo ucwords($datos['cliente']);?></strong>
                        </td>
                        <td class="text-center">
                          <strong>STATUS:
                          <?php
                          if ($datos['estatus'] == 1)
                          {
                          echo "<b>PENDING</b> &nbsp;"; ?> <i class="fa fa-circle" style="color: red;"></i>
                          <?php
                          }
                          if ($datos['estatus'] == 2)
                          {
                          echo "<b>READY TO BILL</b> &nbsp;"; ?><i class="fa fa-circle" style="color: green;"></i>
                          <?php
                          }
                          ?>
                        </strong>

                        </td>
                      </tr>
                    </tbody>
                  </table>



                </div>
              </div>
            </section>
          </div>
        </div>
        <?php
        $buscarSupplierInvoice = SupplierInvoice::soloCodigo($codigo_factura);
        $array3 = $buscarSupplierInvoice->SelectProvedorInvoice();
        ?>
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading no-border">
                <strong>SUPPLIER</strong>
              </header>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Supplier</th>
                    <th>Cost US$</th>
                  </tr>
                </thead>
                <?php
                if($array3->num_rows==0){
                ?>
                <tbody>
                  <tr>
                    <td colspan='5' class="text-center">NO SERVICES</td>
                  </tr>
                </tbody>
                <tbody>
                <?php
                }else{
                  $i=0;
                  while($datos_supli=$array3->fetch_assoc()){
                  $i++;
                ?>
                  <tr>
                    <td><?php echo "<b>" .$i ."</b>";?></td>
                    <td><?php echo "<b>" .ucwords($datos_supli['supplier']) ."</b>";?></td>
                    <td><?php echo "<b>" .$datos_supli['dinero'] ."</b>";?></td>
                  </tr>
                <?php
                  }
                }
                ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
      </div>
        <?php
        $buscarServInvoice = invoicesServices::soloCodigo($codigo_factura);
        $array1 = $buscarServInvoice->SelectServicosInvoice();
        ?>
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading no-border">
                <strong>SERVICES</strong>
              </header>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Notes</th>
                    <th>US$</th>
                    <th>CAD$</th>
                  </tr>
                </thead>
                <?php
                if($array1->num_rows==0){
                ?>
                <tbody>
                  <tr>
                    <td colspan='5' class="text-center">NO SERVICES</td>
                  </tr>
                </tbody>
                <tbody>
                <?php
                }else{
                  $i=0;
                  while($datos_servi=$array1->fetch_assoc()){
                  $i++;
                ?>
                  <strong><tr>
                    <td><?php echo  "<b>" .$i ."</b>";?></td>
                    <td><?php echo "<b>" .$datos_servi['descripcion'] ."</b>";?></td>
                    <td><?php echo "<b>" .ucfirst($datos_servi['nota']) ."</b>";?></td>
                    <td><?php echo "<b>" .$datos_servi['precio_us'] ."</b>";?></td>
                    <td><?php echo "<b>" .$datos_servi['precio_ca'] ."</b>";?></td>
                  </tr>
                <?php
                  }
                }
                ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading">
              SHIP VIA:
            </header>
            <?php
            $buscarViaEnvio = ShippingInvoice::soloCodigo($codigo_factura);
            $array2 = $buscarViaEnvio->SelectViaEnvio();
            if($array2->num_rows==0){
            ?>
            <div class="panel-body">
              <div class="form-group">
                <label class="col-sm-2 control-label">No ship via</label>
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
                    <?php
                      echo "<b>" .$i.".- ".$datos2['descripcion'] ."</b>";
                      $nota = ($datos2['id_envio']==6) ? ": &nbsp;".ucfirst($datos2['nota']) : "" ;
                      echo "<b>" .$nota ."</b>";
                    ?>
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
      <center>
        <a href="detail_docket.php?docket=<?php echo base64_encode($datos['codigo_docket']);?>">
          <button type="button" class="btn btn-danger"><strong>GO BACK</strong></button>
        </center>
    </section>
  </section>
    <!--main content end-->
</section>
  <!-- container section end -->
  <!-- javascripts -->
  <?php include('pie.php');?>


</body>

</html>
<?php
    }
  }else{
    echo"<meta http-equiv='refresh' content='0;URL=create_docket.php'>";
  }
}
?>
