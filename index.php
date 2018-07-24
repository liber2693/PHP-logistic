<?php
session_start();
if(!empty($_SESSION['user']))
{
  echo"<meta http-equiv='refresh' content='0;URL=view/create_docket.php'>";
}else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="theme/img/icono1.png">
  <title>LOGIN NETEX GLOBAL</title>
  <!-- Bootstrap CSS -->
  <link href="theme/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="theme/css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="theme/css/elegant-icons-style.css" rel="stylesheet" />
  <link href="theme/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="theme/css/style.css" rel="stylesheet">
  <link href="theme/css/style-responsive.css" rel="stylesheet" />
  <link href="css/estilos.css" rel="stylesheet" />
</head>
<body class="login-img3-body">
  <div class="container">
    <!--<form class="login-form" name="login" id="login" action="create_docket.php">-->
      <form class="login-form" name="login" id="login">
      <div class="login-wrap">
        <center><img src="theme/img/logonetex.png" width="160" height="90"></center>
        <!-- <p class="login-img"><i class="icon_lock_alt"></i>User Login</p> -->
        <label><b>USER</b></label>
        <div class="alert alert-danger ocultar" id="error2"><strong>Wrong user</strong></div>
        <div class="alert alert-success ocultar" id="error"><strong>Please. Login User</strong></div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Username" autofocus>
        </div>
        <label><b>PASSWORD</b></label>
        <div class="alert alert-success ocultar" id="error1"><strong>Please. Enter Password</strong></div>
        <div class="alert alert-danger ocultar" id="error3"><strong>Incorrect password</strong></div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
        </div>
        <!--<label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
        </label>-->
        <button class="btn btn-primary btn-lg btn-block" type="submit" id="enviar" id="enviar"><b>Login</b></button>
        <button class="btn btn-info btn-lg btn-block" type="reset"><b>Clean</b></button>
      </div>
    </form>
  </div>
</body>
  <!-- javascritp -->
  <script src="theme/js/jquery-1.8.3.min.js"></script>
  <script src="js/usuario.js"></script>
</html>
<?php
}

?>
