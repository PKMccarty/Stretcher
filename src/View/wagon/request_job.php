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
require_once '../../Component/Database/connectConstant.php';
require_once '../../Component/Selectwagon.php';
?>
<link href="../../vendor/view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../../vendor/view/css/sb-admin-2.min.css" rel="stylesheet">
<div id="wrapper">
<style>
.collapse.show {
    visibility: visible;
    animation: fadeIn 0.5s ease-in-out;
}

.collapse:not(.show) {
    visibility: hidden;
    animation: fadeOut 0.5s ease-in-out;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes fadeOut {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}

</style>
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
                    <h4 class="mb-0 text-gray-800"><?=connectConstant::SYSTEM_NAME?></h4>
                </div>

            

                <div class="row mb-5">
                    <div class="col-xl-12">
                        <?=Selectwagon::request_job()?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <?php
/*                         Dashboardbed::showbed(); */
                        require_once '../../Controller/footer.php';
                        ?>
                    </div>
                </div>
                <!-- end content -->
                <div class="modal fade" id="exampleModal16" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันรับผู้ป่วย</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="order_receive" method="post" onsubmit="return checkSubmit()">
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
                                    <input type="submit" id="submitbtn" name="editip" value="ยืนยัน" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal17" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันส่งผู้ป่วย</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="order_sending" method="post" onsubmit="return checkSubmit2()">
                                <div class="modal-bodytt2 mt-5 mb-5 ms-5">
                                    <h4>ยืนยันส่งผู้ป่วย??</h4>
                                    <input type="hidden" class="form-control" name="ip" id="recipienttt">
                                </div>
                                <div class="modal-bodytt3 mt-5 mb-5 ms-5">
                                    <input type="hidden" class="form-control" name="ip2" id="recipienttt2">
                                </div>
                                <div class="modal-bodytt4 mt-5 mb-5 ms-5">
                                    <input type="hidden" class="form-control" name="ip3" id="recipienttt3">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <input type="submit" id="submitbtn2" name="editip" value="ยืนยัน" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal15" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันรับเคส</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="order_request" method="post" onsubmit="return checkSubmit3()">
                                <div class="modal-body2 mt-5 mb-5 ms-5">
                                    <h4>ท่านต้องการรับเคสนี้??</h4>
                                    <input type="hidden" class="form-control" name="ip" id="recipient">
                                </div>
                                <div class="modal-body3 mt-5 mb-5 ms-5">
                                    <input type="hidden" class="form-control" name="ip2" id="recipient2">
                                </div>
                                <div class="modal-body4 mt-5 mb-5 ms-5">
                                    <input type="hidden" class="form-control" name="ip3" id="recipient3">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <input type="submit" id="submitbtn3" name="editip" value="ยืนยัน" class="btn btn-primary">
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
    function checkSubmit() {
        var e = document.getElementById('submitbtn');
        e.style.display = "none";
    }
</script>
<script>
    function checkSubmit2() {
        var e = document.getElementById3('submitbtn2');
        e.style.display = "none";
    }
</script>
<script>
    function checkSubmit3() {
        var e = document.getElementById3('submitbtn3');
        e.style.display = "none";
    }
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
        modalBodyInput.value = recipient
        modalBodyInput2.value = recipient2
        modalBodyInput3.value = recipient3
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
    const exampleModal17 = document.getElementById('exampleModal17')
    exampleModal17.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipienttt = button.getAttribute('data-bs-whatever7')
        const recipienttt2 = button.getAttribute('data-bs-whatever8')
        const recipienttt3 = button.getAttribute('data-bs-whatever9')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        // Update the modal's content.
        const modalBodyInput = exampleModal17.querySelector('.modal-bodytt2 input')
        const modalBodyInput2 = exampleModal17.querySelector('.modal-bodytt3 input')
        const modalBodyInput3 = exampleModal17.querySelector('.modal-bodytt4 input')
        modalBodyInput.value = recipienttt
        modalBodyInput2.value = recipienttt2
        modalBodyInput3.value = recipienttt3
    })
</script>

<script src="../../vendor/view/js/sb-admin-2.min.js"></script>
<script src="../../vendor/view/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>