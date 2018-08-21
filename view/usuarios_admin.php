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
    	<div  align="center"  class="loader" style="display: none;" id="loader_imagen"></div>
    	<section class="wrapper">
        <div class="row">
			<div class="col-lg-12">
				<h3 class="page-header"><i class="fa fa-laptop"></i><b>Manage Users</b></h3>
				<ol class="breadcrumb">
				  <li><i class="fa fa-home"></i><a href="index.php"><b>Home</b></a></li>
				  <li><i class="fa fa-folder-open"></i><b>Manage Users</b></li>
				</ol>
			</div>
        </div>
        <div class="row">
          	<div class="col-lg-12">
            	<section class="panel">
              		<header class="panel-heading">
                		<b>CREATE USERS</b>
              		</header>
              		<div class="panel-body form-horizontal">
              			<div id="mensaje_usuario"></div>
		                <!--<form class="">-->
							<div class="form-group">
								<label class="col-sm-4 control-label"><b>NAME</b></label>
								<div class="col-sm-4" id="nombre_div">
									<input type="text" class="form-control user_campus" id="nombre" name="nombre">
								</div>
              </div>
              <div class="form-group">
								<label class="col-sm-4 control-label"><b>SURNAME</b></label>
								<div class="col-sm-4" id="apellido_div">
								  <input type="text" class="form-control user_campus" id="apellido" name="apellido">
								</div>
							</div>
							<div class="form-group">
                <label class="col-sm-4 control-label"><b>USERNAME</b></label>
                <div class="col-sm-4" id="usuario_div">
                	<input type="text" id="usuario" name="usuario" maxlength="100" class="form-control user_campus">
                </div>
                <span class="help-block" id="ya_existe" style="color: red;"></span>
							</div>
							<div class="form-group">
                  <label class="col-sm-4 control-label"><b>ROLE</b></label>
                    <div class="col-sm-4" id="rol_div">
                      <select class="form-control" id="rol" name="rol">
                      	<option value="0" selected>SELECT</option>
                      	<option value="1">ADMIN</option>
                      	<option value="2">EMPLOYEE</option>
                      </select>
                    </div>
          		</div>
							<div class="form-group">
								<label class="col-sm-4 control-label"><b>PASSWORD</b></label>
                  <div class="col-sm-4" id="password1_div">
                   	<input type="password" id="password1" autocomplete="off" name="password1" class="form-control user_campus">
                   	<span class="help-block" id="campo_password1" style="color: red;"></span>
				          </div>
              </div>
              <div class="form-group">
								<label class="col-sm-4 control-label"><b>RE-PASSWORD</b></label>
                <div class="col-sm-4" id="password2_div">
                   	<input type="password" id="password2" autocomplete="off" name="password2" class="form-control user_campus">
                   	<span class="help-block" id="campo_password2" style="color: red;"></span>
			          </div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-5 col-lg-4">
									<button type="button" id="guardar"  name="guardar" class="btn btn-primary fa fa-plus"><b> CREATE USER</b></button>
								</div>
							</div>
		                <!--</form>-->
              		</div>
            	</section>
            </div>
        </div>
		<div class="row">
          	<div class="col-lg-12">
            	<section class="panel">
              		<div class="table-responsive">
		                <table class="table display" id="table_id">
							<thead>
								<tr>
									<th><i class="fa fa-archive"></i>User</th>
									<th><i class="fa fa-list"></i> Nombre</th>
									<th><i class="icon_profile"></i> Apellido</th>
									<th><i class="icon_calendar"></i> Role</th>
									<th><i class="fa fa-location-arrow"></i> Actividad</th>
									<th><i class="fa fa-location-arrow"></i> Estatus</th>
									<th><i class="icon_cogs"></i> Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
		                </table>
              		</div>
            	</section>
          	</div>
        </div>
    </section>
</section>

<!-- Modal Actualziar Usuario-->
<div id="myModalActualziar" class="modal fade" role="dialog">
 	<div class="modal-dialog">
  		<!-- Modal content-->
    	<div class="modal-content">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 class="modal-title"><b>UPDATE USER</b></h4>
	     	</div>
			<form role="form">
				<div class="modal-body">
					<div id="mensaje_usuario_update"></div>
					<input type="hidden" name="id_usuario" id="id_usuario">
					<div class="form-group">
          	<label><b>NAME</b></label>
						<div id="Actualizar_nombre_div">
							<input type="text" class="form-control user_campus upt" id="Actualizar_nombre" name="Actualizar_nombre">
						</div>
					</div>
					<div class="form-group">
						<label><b>SURNAME</b></label>
						<div id="Actualizar_apellido_div">
							<input type="text" class="form-control user_campus upt" id="Actualizar_apellido" name="Actualizar_apellido">
						</div>
					</div>
					<div class="form-group">
          <label><b>USERNAME</b></label>
          <div id="Actualziar_usuario_div">
          	<input type="text" id="Actualizar_usuario" name="Actualizar_usuario" maxlength="100" class="form-control user_campus upt">
          	<span class="help-block ocultar" id="ya_existe_actualizar" style="color: red;"></span>
          </div>
          </div>
          <div class="form-group">
              <label><b>ROLE</b></label>
              <div id="Actualziar_rol_div">
			             <select class="form-control upt" id="Actualizar_rol" name="Actualizar_rol">
				                 <option value="1">ADMIN</option>
				                 <option value="2">EMPLOYEE</option>
                  </select>
              </div>
         </div>
					<div class="form-group">
						<label><b>PASSWORD</b></label>
            <div id="Actualziar_password1_div">
             	<input type="password" id="Actualizar_password1" autocomplete="off" name="Actualizar_password1" class="form-control user_campus upt">
             	<span class="help-block" id="Actualziar_campo_password1" style="color: red;"></span>
						</div>
					</div>
					<div class="form-group">
						<label><b>RE-PASSWORD</b></label>
            <div id="Actualziar_password2_div">
           	  <input type="password" id="Actualizar_password2" autocomplete="off" name="Actualizar_password2" class="form-control user_campus upt">
             	<span class="help-block" id="Actualziar_campo_password2" style="color: red;"></span>
						</div>
					</div>
					<div class="form-group">
                    <label>Status User</label>
	                    <div>
	                      	<label class="checkbox-inline">
	                            <input type="checkbox" id="Actualizar_estatus" value="1"> Status
	                        </label>
	                    </div>
	                </div>
				</div>
				<div class="modal-footer">
					<button type="button" name="boton_actualizar" id="boton_actualizar" class="btn btn-success"><b>Update User</b></button>
					<button type="button" id="cancelar_actualizar" class="btn btn-primary" data-dismiss="modal"><b>Close</b></button>
				</div>
			</form>
    	</div>
  	</div>
</div>

<!-- Modal para confirmar elimnar un Usuario-->
<div id="myModalEliminar" class="modal fade" role="dialog">
  <div class="modal-dialog">
  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>DELETE USER</b></center></h4>
      </div>
      <br>
      <form class="form-inline" role="form">
        <div class="modal-body text-center">
          <h4><b><center>Do you want to delete this user?</center></b></h4>
          <input type="hidden" class="user_campus" id="id_registro" name="id_registro">
        </div>
        <div class="modal-footer">
          <button type="button" name="boton_confimar_eliminar" id="boton_confimar_eliminar" class="btn btn-success"><b>Confirm</b></button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Cancel</b></button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- container section start -->

  <!-- javascripts -->
  <?php include('pie.php');?>

  	<script src="../js/usuario_admin.js" type="text/javascript"></script>


</body>

</html>
<?php
}
?>
