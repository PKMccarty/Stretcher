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

<?= manage::gettable2($conn2);?>

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