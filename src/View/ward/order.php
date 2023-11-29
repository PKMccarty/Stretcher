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
    require_once '../../Component/Selectward.php';
    echo Selectward::showjob();
    echo Selectward::showjob2();
?>
<div style="height:100px !important;"></div>
<script>
        $(document).ready(function() {
            // Set the interval for refreshing the page (in milliseconds)
            var refreshInterval = 30000; // 5 seconds

            // Function to refresh the page
            function refreshPage() {
                location.reload();
            }

            // Use setInterval to repeatedly call the refreshPage function
            var intervalId = setInterval(refreshPage, refreshInterval);
        });
    </script>



