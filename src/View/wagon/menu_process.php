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
    require_once '../../Component/Selectwagon.php';
?>
<?= Selectwagon::showprogressjob(null);?>

<div style="height:100px !important;"></div>
