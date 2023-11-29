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
require_once '../../Component/manage.php';
require_once '../../Component/DbUtils.php';
require_once '../../Component/DbUtilscart.php';
$conn2 = DbUtilscart::get_cart_connection();
$conn = DbUtils::get_hosxp_connection();
?>
<div class="row">
                            <div class="col-lg-6 mb-4">
                                <?= manage::getstatic_daily($conn2); ?>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <?php
                                    $result = manage::getstatic($conn2);
                                    echo $result[0];
                                ?>
                            </div>
                        </div>

        <!--           <script>
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