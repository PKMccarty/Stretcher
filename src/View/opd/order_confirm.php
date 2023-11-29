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
    require_once '../../Component/line_api.php';
    require_once '../../Component/DbUtilscart.php';
    $conn2 = DbUtilscart::get_cart_connection();

    $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept where job_id = :job_id";
    $stmt = $conn2->prepare($sql);
    $stmt->bindParam(':job_id' , $_POST['ip'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    $sql2 = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept SET `ac_send_succ` = '1'  where job_id = :job_id";
    $stmt2 = $conn2->prepare($sql2);
    $stmt2->bindParam(':job_id' , $_POST['ip'], PDO::PARAM_STR);
    $stmt2->execute();

    $sql3 = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job SET `sta_id` = '6'  where job_id = :job_id and hn = :hn";
    $stmt3 = $conn2->prepare($sql3);
    $stmt3->bindParam(':job_id' , $_POST['ip'], PDO::PARAM_STR);
    $stmt3->bindParam(':hn' , $_POST['ip2'], PDO::PARAM_STR);
    $stmt3->execute();
    $seticon = 'success';
    $settext = 'ส่งผู้ป่วยเรียบร้อย';
    $conn2=null;
    echo '<a style="color:white !important;">สำเร็จ</a>';
    echo "<script> Swal.fire({
    position: 'top-end',
    icon: '$seticon',
    title: '$settext',
    showConfirmButton: false,
    timer: 1500,
    }).then(function() {
    window.location = 'index';
    });
    </script>";
?>