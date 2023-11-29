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
error_reporting(0);
require_once '../../Controller/head.php';
require_once '../../Component/DbUtils.php';
require_once '../../Component/Database/connectConstant.php';
require_once '../../Component/DbUtilscart.php';
/* require_once '../../Component/SelectUtils.php'; */
require_once '../../Component/manage.php';
$conn2 = DbUtilscart::get_cart_connection();
$conn = DbUtils::get_hosxp_connection();

$username = base64_encode('username');
$dashboard = base64_encode('dashboard');
$role = base64_encode('role');
$equipment = base64_encode('equipment');
$result = manage::getstatic($conn2);
$x = $result[1];
?>
<link href="../../vendor/view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../../vendor/view/css/sb-admin-2.min.css" rel="stylesheet">
<link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" /> -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
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
                    <h1 class="h3 mb-0 text-gray-800"><?= connectConstant::SYSTEM_NAME ?></h1>
                </div>
                <!-- Content Row -->
                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg mb-4">
                    <?php include('tables_data_show.php'); ?>
                    
                        <!-- content here -->
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <?php
                                /*                         Dashboardbed::showbed(); */
                                require_once '../../Controller/footer.php';
                                ?>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal14" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลส่วนตัว </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body2 m-5">
                                            <label for="">HN</label>
                                            <input type="text" class="form-control" name="ip" id="recipient">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <input type="submit" name="editip" value="ยืนยัน" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end content -->
                        <div class="modal fade" id="exampleModal15" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ยืนยันการจ่ายงาน</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="manage_send.php" method="post">
                                        <div class="modal-body2 m-5">
                                            <label for="">HN</label>
                                            <input type="text" class="form-control" name="ip2" id="recipient2">
                                        </div>
                                        <div class="modal-body3 m-5">
                                            <label for="">เลือกเจ้าหน้าที่</label>
                                            <input type="hidden" class="form-control" name="ip" id="recipient">
                                            <?= manage::getcustomer($conn2, $conn) ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <input type="submit" name="editip" value="ยืนยัน" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="exampleModal16" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ยืนยันยกเลิกข้อมูล</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="./manage_cancel" method="post">
                                        <div class="modal-body2 mt-5 mb-5 ms-5">
                                            <h4>ท่านต้องการยกเลิก??</h4>
                                            <input type="hidden" class="form-control" name="job_id" id="recipient">
                                        </div>
                                        <div class="modal-body3 m-5">
                                            <label for="exampleFormControlTextarea1">เหตุผลยกเลิก</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="log"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <input type="submit" name="editip" value="บันทึก" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

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
        <script src="manage.js"></script>
        <script>
            const exampleModal14 = document.getElementById('exampleModal14')
            exampleModal14.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const recipient = button.getAttribute('data-bs-whatever')
                // If necessary, you could initiate an AJAX request here
                // and then do the updating in a callback.
                // Update the modal's content.
                const modalBodyInput = exampleModal14.querySelector('.modal-body2 input')
                modalBodyInput.value = recipient
            })
        </script>
        <script>
            const exampleModal15 = document.getElementById('exampleModal15')
            exampleModal15.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const recipient = button.getAttribute('data-bs-whatever')
                const recipient2 = button.getAttribute('data-bs-whatever2')
                const recipient3 = button.getAttribute('data-bs-whatever3')
                // If necessary, you could initiate an AJAX request here
                // and then do the updating in a callback.
                // Update the modal's content.
                const modalBodyInput = exampleModal15.querySelector('.modal-body2 input')
                const modalBodyInput2 = exampleModal15.querySelector('.modal-body3 input')
                const modalBodyInput3 = exampleModal15.querySelector('.modal-body4 input')
                modalBodyInput.value = recipient2
                modalBodyInput2.value = recipient
                modalBodyInput3.value = recipient3
            })
        </script>
        <script>
            const exampleModal16 = document.getElementById('exampleModal16')
            exampleModal16.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const recipient = button.getAttribute('data-bs-whatever')
                // If necessary, you could initiate an AJAX request here
                // and then do the updating in a callback.
                // Update the modal's content.
                const modalBodyInput = exampleModal16.querySelector('.modal-body2 input')
                modalBodyInput.value = recipient
            })
        </script>
        <script>
            // Get the select element
            var select = document.getElementById('mySelect');

            // Get the input element
            var input = document.getElementById('selectedValue');

            // Add an event listener to the select element
            select.addEventListener('change', function() {
                // Get the selected value from the select element
                var selectedValue = select.options[select.selectedIndex].text;

                // Set the input element's value to the selected value
                input.value = selectedValue;
            });
        </script>
        <script src="../../vendor/view/vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/view/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../vendor/view/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../../vendor/view/js/sb-admin-2.min.js"></script>

        <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- <script src="../../vendor/view/js/demo/datatables-demo.js"></script> -->