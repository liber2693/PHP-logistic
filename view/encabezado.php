<header class="header dark-bg">
  <div class="toggle-nav">
    <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
  </div>

  <!--logo start-->
  <a href="create_docket.php" class="logo">
    <img src="../theme/img/logonetex.png" border="1" width="110" height="40"> <!--style="max-width:33%;width:auto;max-width:35%;height:auto;"-->
    <span class="lite"></span></a>
  <!--logo end-->

  <div class="top-nav notification-row">
    <!-- notificatoin dropdown start-->
    <ul class="nav pull-right top-menu">
      <!-- user login dropdown start-->
      <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="profile-ava">
                <?php
                /*$idusuario=$_SESSION['id_usuario'];
                $etiqueta = '<img alt="" src="';
                $ruta = '../theme/img/';
                $tipo = '.jpg';
                $cierre = '">';
                echo $etiqueta.$ruta.$idusuario.$tipo.$cierre;*/
                ?>
                  <img alt="" src="../theme/img/sidebar_usuario-corporativo.jpg">
              </span>
              <?php
              $nombre=$_SESSION['nombre'];
              $apellido=$_SESSION['apellido'];
              ?>
              <span class="username"><b><?php echo ucfirst($nombre).' '.ucfirst($apellido);?></b></span>
              <b class="caret"></b>
        </a>
        <ul class="dropdown-menu extended logout">
          <div class="log-arrow-up"></div>
          <li>
            <a href="../controllers/sesionControllers.php?close=<?php echo md5('cerra');?>"><i class="icon_key_alt"></i> Log Out</a>
          </li>

          <li>
          <!--  <a href="#"><i class="fa fa-question"></i> Documentation</a> -->
          </li>
        </ul>
      </li>
      <!-- user login dropdown end -->
    </ul>
    <!-- notificatoin dropdown end-->
  </div>
  
</header>
