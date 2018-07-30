
<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active">
            <a class="" href="create_docket.php">
              <i class="fa fa-laptop fa "></i>
              <span>Create Docket</span>
            </a>
          </li>
          <li class="active">
            <a class="" href="docket_list.php">
              <i class="fa fa-list-alt"></i>
              <span>Docket list</span>
            </a>
          </li>
          <?php
          if ($_SESSION['id_usuario'] == 1){
           ?>
          <li class="active">
            <a class="" href="delete_list.php">
              <i class="fa fa-trash-o"></i>
              <span>Deleted Docket</span>
            </a>
          </li>
          <?php
            }
            ?>
        </ul>
      </div>
    </aside>
