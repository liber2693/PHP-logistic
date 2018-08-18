<?php
//include("conexion/conexion.php");
session_start();
if(empty($_SESSION['user']))
{
  //echo"<script>alert('You must login')</script>";
  echo"<meta http-equiv='refresh' content='0;URL=../index.php'>";
}else{
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
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i><b>Manage Users</b></h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php"><b>Home</b></a></li>
              <li><i class="fa fa-folder-open"></i><b>Manage Users</b></li>
            </ol>
          </div>
        </div>
      </section>
      <section class="panel">
        <div class="panel-group">
          <div class="panel-group">
            <div class="panel panel-link">
              <div class="panel-body">
                <center>
                  <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-lg fa fa-plus"><b> Create User</b></a><br><br>
                </center>
                  <!--  Comeinza Tabla de usuarios -->
                <div class="row">
                  <div class="col-lg-12">
                    <section class="panel">
                      <header class="panel-heading">
                        Manage Users
                      </header>

                      <table class="table table-striped table-advance table-hover">
                        <tbody>
                          <tr>
                            <th><i class="fa fa-list"></i> #</th>
                            <th><i class="icon_profile"></i> Username</th>
                            <th><i class="fa fa-address-book-o"></i> Name</th>
                            <th><i class="icon_pin_alt"></i> Role</th>
                            <th><i class="icon_cogs"></i> Action</th>
                          </tr>
                          <tr>
                            <td><b>1</b></td>
                            <td><b>liber2693</b></td>
                            <td><b>Liber Lenin</b></td>
                            <td><b>Admin</b></td>
                            <td>
                              <div class="btn-group">
                                <a class="btn btn-warning" style="font-size:16px" href="#" data-toggle="tooltip" title="Add Invoice"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-danger" style="font-size:16px" href="#" data-toggle="tooltip" title="Docket Details"><i class="fa fa-times"></i></a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td><b>2</b></td>
                            <td><b>renford</b></td>
                            <td><b>Renford Jansen</b></td>
                            <td><b>Admin</b></td>
                            <td>
                              <div class="btn-group">
                                <a class="btn btn-warning" style="font-size:16px" href="#" data-toggle="tooltip" title="Add Invoice"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-danger" style="font-size:16px" href="#" data-toggle="tooltip" title="Docket Details"><i class="fa fa-times"></i></a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td><b>3</b></td>
                            <td><b>glenys</b></td>
                            <td><b>Glenys Alvarez</b></td>
                            <td><b>Employee</b></td>
                            <td>
                              <div class="btn-group">
                                <a class="btn btn-warning" style="font-size:16px" href="#" data-toggle="tooltip" title="Add Invoice"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-danger" style="font-size:16px" href="#" data-toggle="tooltip" title="Docket Details"><i class="fa fa-times"></i></a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </section>
                  </div>
                </div>
                <!-- TERMINA TABLA DE USUARIOS-->

              </div>
            </div><!--Link, succes, warning, danger, info-->
          </div>
          <!-- INICIO Formulario Importacion de documento -->
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                  <h4 class="modal-title"><b>Create User Form</b></h4>
                </div>
                <div class="modal-body">
                  <form role="form" name="importacion" id="importacion" action="../controllers/documentoControllers.php" enctype="multipart/form-data" method='post'>
                    <input type="hidden" value="I" name="tipoDocumento">
                    <div class="form-group">
                      <label for="shipper">Username <b style="color: red">*</b></label>
                      <input name="shipper" type="text" class="form-control round-input" id="shipper" placeholder="Username" >
                    </div>
                    <!--<div class="form-group">
                      <label for="fecha">Date <b style="color: red;">*</b></label>
                      <input name="fecha" type="text" class="form-control round-input fecha" id="fecha"  placeholder="Enter Date" readonly="true">
                    </div> -->
                    <div class="form-group">
                      <label for="origin">Name <b style="color: red">*</b></label>
                      <input name="telefono" type="text" class="form-control round-input" placeholder="Your Name"  autocomplete='off'>
                    </div>
                    <div class="form-group">
                      <label for="cc">Surname <b style="color: red">*</b></label>
                      <input name="cc" id="cc" type="text" class="form-control round-input" placeholder="Your Surname" autocomplete='off'>
                    </div>
                    <div class="form-group">
                      <label for="consignee">Password <b style="color: red">*</b></label>
                      <input name="consignee" id="consignee" type="text" class="form-control round-input" placeholder="Password" autocomplete='off'>
                    </div>
                    <div class="form-group">
                      <label for="po">Re-Password <b style="color: red">*</b></label>
                      <input name="po" id="po" type="text" class="form-control round-input" placeholder="Rewrite-Password" autocomplete='off'>
                    </div>
                    <div class="form-group">
                      <label for="origin">Role<b style="color: red;">*</b></label>
                      <select name="" class="form-control round-input" autocomplete='off' id="">
                        <option value="1" selected="selected">ADMIN</option>
                        <option value="2">EMPLOYEE</option>
                      </select><br>
                          <center><button type="submit" id="enviar_documento_import" name="enviar_documento" class="btn btn-primary"><b>Create</b></button>
                          <button type="reset" class="btn btn-info"><b>Reset</b></button></center>
                      </center>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- FIN Formulario Usuarios -->
        </div>

      </div>

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
?>
