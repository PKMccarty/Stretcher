<?php
if(isset($_SESSION['status'])){
    if($_SESSION['status']=true){
        $_SESSION['status']=true;
    }else{
        header('Location:../../login/index.php');
exit;
    }
}else{
    header('Location:../../login/index.php');
exit;
}
require_once '../../Controller/head.php';
require_once '../../Component/Selectwagon.php';
?>
    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../vendor/view/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>

#fstatus{
    font-size: 12px;
}
#fheader{
    font-size: 13px;
    font-weight: bold;
}
.centered-image {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

/* Media query for screens with a minimum width of 768px */
@media (min-width: 768px) {
    .centered-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
}
</style>
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
                <!-- content here -->
                <div class="container-lg mt-5">
                    <div class="card">
                        <div class="card-header">
                            Information
                        </div>
                        <div class="card-body">
                            <div class="container-flud">
                                <div class="row align-items-start mb-5">
                                    <div class="col-sm-1 me-5">
                                        <img class="rounded-circle centered-image" src="image/<?php echo $_SESSION['u_image']?>"  width="100" height="100" alt="Image">
                                    </div>
                                    <div class="col-sm fs-7 mt-3">
                                         <div id="fheader" class="col">
                                            <p><?=$_SESSION['name']?></p>
                                        </div>
                                        <div id="fstatus" class="col">
                                            <p>เคสที่ดำเนินการสำเร็จ <?=Selectwagon::countsuccess($_SESSION['loginname']);?> | ยกเลิก <?=Selectwagon::countfail($_SESSION['loginname']);?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <?=Selectwagon::tableprofile();?>
                                    </div>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-lg-12 mb-4">
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
<script>
        $(document).ready(function() {
            $('#display').DataTable({
                order: [[3,'Desc']],pagingType: 'full_numbers'
            });
        });
    </script>
<script src="../../vendor/view/js/sb-admin-2.min.js"></script>
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../vendor/view/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../../vendor/view/js/sb-admin-2.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../../vendor/view/js/demo/datatables-demo.js"></script>