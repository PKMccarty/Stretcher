<?php
require_once '../../Controller/head.php';
require_once '../../Component/DbUtils.php';
require_once '../../Component/SelectUtils.php';
$conn = DbUtils::get_hosxp_connection();

$username = base64_encode('username');
$dashboard = base64_encode('dashboard');
$role = base64_encode('role');
$equipment = base64_encode('equipment');


?>
<link href="../../vendor/view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../../vendor/view/css/sb-admin-2.min.css" rel="stylesheet">
<div id="wrapper">

    <!-- Sidebar -->
    <?php
    require_once '../../Controller/nav_menu.php';
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">


            <!-- Topbar -->
            <?php
            require_once '../../Controller/nav.php';
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">ระบบจองเปล ผู้ดูแลระบบ</h1>
                </div>

                <div class="card">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-start">
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id=<?=$username?>"><img class="img-fluid" src="image/gear.png" alt=""></a><br>Username</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id=<?=$dashboard?>"><img class="img-fluid" src="image/gear.png" alt=""></a><br>Dashboard</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id=<?=$role?>"><img class="img-fluid" src="image/gear.png" alt=""></a><br>role</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id=<?=$equipment?>"><img class="img-fluid" src="image/gear.png" alt=""></a><br>Equipment</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id="><img class="img-fluid" src="image/gear.png" alt=""></a><br>รายการ กำลังดำเนินการ</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id="><img class="img-fluid" src="image/gear.png" alt=""></a><br>รายการ กำลังดำเนินการ</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id="><img class="img-fluid" src="image/gear.png" alt=""></a><br>รายการ กำลังดำเนินการ</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id="><img class="img-fluid" src="image/gear.png" alt=""></a><br>รายการ กำลังดำเนินการ</h6>
                            </div>
                            <div class="col-xl-3">
                                <h6 class="text-center btn btn-primary m-1 fs-2"><a href="page?id="><img class="img-fluid" src="image/gear.png" alt=""></a><br>รายการ กำลังดำเนินการ</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content here -->
                <div class="row">
                    <div class="col-xl-12 mb-4">
                        <?php
                        /*                         Dashboardbed::showbed(); */
                        require_once '../../Controller/footer.php';
                        ?>
                    </div>
                </div>
                <!-- end content -->

                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการจะออกจากระบบ?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">เลือก "Logout" ถ้าหากคุณต้องการออกจากระบบ.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="../../login/logout">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../vendor/view/vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/view/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../vendor/view/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../vendor/view/js/sb-admin-2.min.js"></script>
<script src="../../vendor/view/vendor/chart.js/Chart.min.js"></script>
<script src="../../vendor/view/js/demo/chart-area-demo.js"></script>