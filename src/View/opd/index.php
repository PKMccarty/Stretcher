<?php
/* error_reporting(0); */
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
require_once '../../Component/Selectopd.php';
require_once '../../Component/datethai.php';
require_once '../../Component/Database/connectConstant.php';

/* var_dump($_SESSION); */
?>
<link href="../../vendor/view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../../vendor/view/css/sb-admin-2.min.css" rel="stylesheet">
<!-- Custom styles for this page -->
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
                    <h1 class="h3 mb-0 text-gray-800"><?php echo connectConstant::SYSTEM_NAME.' '.Selectopd::namedepartment($_SESSION['ward']);?></h1>
                </div>
                <!-- Content Row -->
                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg mb-4">
                    <?php include('order.php')?>
                        <!-- content here -->
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <?php
                                /*                         Dashboardbed::showbed(); */
                                require_once '../../Controller/footer.php';
                                ?>
                            </div>
                        </div>
                        <form action="order_confirm" method="post">
                            <div class="modal fade" id="exampleModal20" tabindex="-1" aria-labelledby="exampleModalLabel20" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel20">วัน - เวลานัดล่วงหน้า</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <br>
                                            <h2 id="modalData"></h2> <!-- Add this line for displaying data -->
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">ปิด</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal fade" id="exampleModal16" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ยืนยันรับผู้ป่วย</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="order_confirm" method="post">
                                        <div class="modal-bodyt2 mt-5 mb-5 ms-5">
                                            <h4>ยืนยันรับผู้ป่วย??</h4>
                                            <input type="hidden" class="form-control" name="ip" id="recipientt">
                                        </div>
                                        <div class="modal-bodyt3 mt-5 mb-5 ms-5">
                                            <input type="hidden" class="form-control" name="ip2" id="recipientt2">
                                        </div>
                                        <div class="modal-bodyt4 mt-5 mb-5 ms-5">
                                            <input type="hidden" class="form-control" name="ip3" id="recipientt3">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <input type="submit" name="editip" value="ยืนยัน" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal15" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ยืนยันยกเลิกการร้องขอเคลื่อนย้ายผู้ป่วย</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="cancel_wagon" method="post">
                                        <div class="modal-bodyt2 mt-5 mb-5 ms-5">
                                            <h4>ยืนยันยกเลิกการร้องขอเคลื่อนย้ายผู้ป่วย??</h4>
                                            <input type="hidden" class="form-control" name="ip" id="recipientt">
                                        </div>
                                        <div class="modal-bodyt3 mt-5 mb-5 ms-5">
                                            <input type="hidden" class="form-control" name="ip2" id="recipientt2">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <input type="submit" name="editip" value="ยืนยัน" class="btn btn-primary">
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
        <script>
             $(document).ready(function() {
            $('#display1').DataTable({
                order: [[3,'Desc']],pagingType: 'full_numbers'
            });
            $('#display2').DataTable({
                order: [[2,'Desc']],pagingType: 'full_numbers'
            }
            );
        });
        </script>
                <script>
    const exampleModal15 = document.getElementById('exampleModal15')
    exampleModal15.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipientt = button.getAttribute('data-bs-whatever')
        const recipientt2 = button.getAttribute('data-bs-whatever2')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        // Update the modal's content.
        const modalBodyInput = exampleModal15.querySelector('.modal-bodyt2 input')
        const modalBodyInput2 = exampleModal15.querySelector('.modal-bodyt3 input')
        modalBodyInput.value = recipientt
        modalBodyInput2.value = recipientt2
    })
</script>
        <script>
    const exampleModal16 = document.getElementById('exampleModal16')
    exampleModal16.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipientt = button.getAttribute('data-bs-whatever4')
        const recipientt2 = button.getAttribute('data-bs-whatever5')
        const recipientt3 = button.getAttribute('data-bs-whatever6')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        // Update the modal's content.
        const modalBodyInput = exampleModal16.querySelector('.modal-bodyt2 input')
        const modalBodyInput2 = exampleModal16.querySelector('.modal-bodyt3 input')
        const modalBodyInput3 = exampleModal16.querySelector('.modal-bodyt4 input')
        modalBodyInput.value = recipientt
        modalBodyInput2.value = recipientt2
        modalBodyInput3.value = recipientt3
    })
</script>
<script>
                    $(document).ready(function() {
            $('#exampleModal20').on('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var recipient = $(button).data('bs-whatever');

                var timestamp = Date.parse(recipient); // 7 คือการเพิ่ม TimeZone +7 เพื่อเปลี่ยน TimeZone ให้เป็น UTC

                var thaiBuddhistDate = new Date(timestamp);
thaiBuddhistDate.setFullYear(thaiBuddhistDate.getFullYear() + 543);

// ดึงวัน เดือน ปี และเวลา ชั่วโมง นาที
var thaiDay = thaiBuddhistDate.getDate();
var thaiMonth = thaiBuddhistDate.getMonth() + 1; // เดือนใน JavaScript เริ่มที่ 0
var thaiYear = thaiBuddhistDate.getFullYear();
var thaiHour = thaiBuddhistDate.getHours();
var thaiMinute = thaiBuddhistDate.getMinutes();
                var modalData = $('#modalData');
                modalData.text((thaiDay < 10 ? "0" : "") + thaiDay + "-" + (thaiMonth < 10 ? "0" : "") + thaiMonth + "-" + thaiYear + " " + (thaiHour < 10 ? "0" : "") + thaiHour + ": " + (thaiMinute < 10 ? "0" : "") + thaiMinute + " น.");
            });
        });

        </script>
<script src="../../vendor/view/vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/view/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../vendor/view/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../vendor/view/js/sb-admin-2.min.js"></script>


<script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- <script src="../../vendor/view/js/demo/datatables-demo.js"></script> -->