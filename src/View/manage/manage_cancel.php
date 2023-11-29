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
    require_once '../../Component/DbUtilscart.php';
    require_once '../../Component/line_api.php';
    require_once '../../Component/Database/connectConstant.php';
    require_once '../../Component/DbUtils.php';
    $conn2 = DbUtilscart::get_cart_connection();
    $conn = DbUtils::get_hosxp_connection();
    $text = '';
    $jobid = empty($_POST['job_id']) ? null : $_POST['job_id'];
    $log = empty($_POST['log']) ? null : $_POST['log'];

            $sql2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where job_id = :job_id";
            $stmt2 = $conn2->prepare($sql2);
            $stmt2->bindParam(':job_id', $jobid);
            $stmt2->execute();
            $rowcheck = $stmt2->fetch();

        $sql = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job SET `sta_id` = 5,`job_log` = :log where job_id = :job_id";
        try {
            $stmt = $conn2->prepare($sql);
            $stmt->bindParam(':job_id', $jobid);
            $stmt->bindParam(':log', $log);
            $stmt->execute();
    
            $seticon = 'success';
            $settext = 'ยกเลิกเรียบร้อย';
        }catch (PDOException  $e) {
            echo $e->getMessage();
            $seticon = 'error';
            $settext = 'ยกเลิกไม่สำเร็จ';
        }
    if($_POST['job_id']){
        $porter = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a SET `ac_st_id` = 2 where job_id = :job_id";
        $porterstmt = $conn2->prepare($porter);
        $porterstmt->bindParam(':job_id', $jobid);
        $porterstmt->execute();
    }
    if($settext == 'ยกเลิกเรียบร้อย'){
       
        $sqlshowpatient = "select  CONCAT(pname,fname,' ',lname) as 'name' from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
        $stmtpatient=$conn->prepare($sqlshowpatient);
        $stmtpatient->bindParam(':hn', $rowcheck['hn']);
        $stmtpatient ->execute();
        $showpatient = $stmtpatient->fetch(PDO::FETCH_ASSOC);

        $token = connectConstant::CONNECTION_TOKEN_LINE;
        $text .= "\n"."------------------------------"."\n";
        $text .= "ยกเลิกรายการร้องขอเปล";
        $text .= "\n"."------------------------------"."\n";
        $text .= "เหตุผลที่ยกเลิก"."\n";
        $text .= " x ".$log."\n";
        $text .= "\n"."------------------------------"."\n";
        $text .= "HN : ".$rowcheck['hn']."\n";
        $text .= "ชื่อ - สกุล : ".$showpatient['name']."\n";
        $text .= "กดลิ้ง : https://stc.cphhospital.go.th/login/index";
        send_line_notify($text, $token);

    }
    $conn2=null;
        echo '<a style="color:white !important;">สำเร็จ</a>';
        echo "<script> Swal.fire({
        position: 'top-end',
        icon: '$seticon',
        title: '$settext',
        showConfirmButton: false,
        timer: 1500,
        }).then(function() {
            window.location = 'index?page=cHJvY2Vzcw==';
        });
        </script>";
?>