<?php
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] = true) {
        $_SESSION['status'] = true;
    } else {
        header('Location:../../login/index.php');
        exit;
    }
} else {
    header('Location:../../login/index.php');
    exit;
}
$request = base64_encode('request');
$process = base64_encode('process');
$success = base64_encode('success');
$confirm = base64_encode('confirm');
require_once '../../Component/manage.php';
require_once '../../Component/DbUtils.php';
require_once '../../Component/DbUtilscart.php';
$conn2 = DbUtilscart::get_cart_connection();
$conn = DbUtils::get_hosxp_connection();
?>

<div class="card mb-5">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="true" href="index?page=<?php echo $request;?>">รายการร้องขอ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index?page=<?php echo $process;?>">รายการกำลังดำเนินการ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index?page=<?php echo $success;?>">รายการจบงาน - ยกเลิก</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="index?page=<?php echo $confirm;?>">รายการรอจบงาน</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <?= manage::gettable5($conn2); ?>
    </div>
</div>



<!--              <script>
        $(document).ready(function() {
            // Set the interval for refreshing the page (in milliseconds)
            var refreshInterval = 25000; // 25 seconds

            // Function to refresh the page
            function refreshPage() {
                location.reload();
            }

            // Use setInterval to repeatedly call the refreshPage function
            var intervalId = setInterval(refreshPage, refreshInterval);
        });
    </script>  -->