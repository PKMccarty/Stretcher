<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index">
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="/image/llogo.png" width="55" height="45">
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
      </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>หน้าหลัก</span></a>
    </li>

    <!-- Divider -->
    <?php
        if($_SESSION['role_id']==1){
    ?>
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="request_job">
                <i class="fas fa-fw fa-table"></i>
                <span>รายการร้องขอใหม่</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="process_job">
                <i class="fas fa-fw fa-table"></i>
                <span>รายการกำลังดำเนินการ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="tables_data">
                <i class="fas fa-fw fa-table"></i>
                <span>รายการ Report</span>
            </a>
        </li>
        <?php }else if($_SESSION['role_id']==2) {?>
        <li class="nav-item">
            <a class="nav-link" href="tables_data">
                <i class="fas fa-fw fa-table"></i>
                <span>รายการรับ - ส่งผู้ป่วย</span>
            </a>
        </li>
        <?php }else if($_SESSION['role_id']==4) { ?>
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="tables_data">
                <i class="fas fa-fw fa-table"></i>
                <span>รายการ Report</span>
            </a>
        </li>
    <?php } else if($_SESSION['role_id']==5) { ?>
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="request_wagon">
                <i class="fas fa-fw fa-table"></i>
                <span>เรียกเปล</span>
            </a>
        </li>
    <?php }else if($_SESSION['role_id']==6){ ?>
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="request_wagon">
                <i class="fas fa-fw fa-table"></i>
                <span>เรียกเปล</span>
            </a>
        </li>
    <?php } ?>
    <hr class="sidebar-divider">
<!--     <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Addons
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> -->

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>