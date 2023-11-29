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
    date_default_timezone_set('Asia/Bangkok');
    require_once '../../Controller/head.php';
    require_once '../../Component/line_api.php';
    require_once '../../Component/DbUtilscart.php';
    require_once '../../Component/DbUtils.php';
    $conn2 = DbUtilscart::get_cart_connection();
    $conn = DbUtils::get_hosxp_connection();
    $text = '';
    $status = 3;
    $sql ="select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where job_id =:ip";
    $stmt = $conn2->prepare($sql);
    $stmt->bindParam(':ip', $_POST['ip']);
    $stmt ->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $selectsql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd where job_id =:job_id";
    $selectstmt = $conn2->prepare($selectsql);
    $selectstmt->bindParam(':job_id', $row['job_id']);
    $selectstmt ->execute();
    while ($selectrow = $selectstmt->fetch(PDO::FETCH_ASSOC)){

        $updatedetail = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job SET `sta_id` = 2 where job_id = :job_id";
        $updatedetailstmt = $conn2->prepare($updatedetail);
        $updatedetailstmt->bindParam(':job_id', $row['job_id']);
        $updatedetailstmt ->execute();
    }


        $insertsql = "insert into ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept (`u_id`,`ac_st_id`,`job_id`,`accept_time`,`ac_receive_date`,`ac_receive_time`,`date`) values(:login,:sta,:job_id,'".date('h:i:sa')."','".date('Y-m-d')."','".date('h:i:sa')."','".date('Y-m-d')."')";

    try {
        $insertstmt = $conn2->prepare($insertsql);
        $insertstmt->bindParam(':login', $_SESSION['loginname']);
        $insertstmt->bindParam(':sta', $status);
        $insertstmt->bindParam(':job_id', $row['job_id']);
        $insertstmt ->execute();
    
        $seticon = 'success';
        $settext = 'รับเคสเรียบร้อย';
    }catch (PDOException  $e) {
            echo $e->getMessage();
        $seticon = 'error';
        $settext = 'รับเคสไม่สำเร็จ';
    }
        if($settext == 'รับเคสเรียบร้อย'){

        $sqlshowpatient = "select  CONCAT(pname,fname,' ',lname) as 'name' from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
        $stmtpatient=$conn->prepare($sqlshowpatient);
        $stmtpatient->bindParam(':hn', $row['hn']);
        $stmtpatient ->execute();
        $showpatient = $stmtpatient->fetch(PDO::FETCH_ASSOC);

        $token = connectConstant::CONNECTION_TOKEN_LINE;
        $text .= "\n"."------------------------------"."\n";
        $text .= "รับเคสเรียบร้อย";
        $text .= "\n"."------------------------------"."\n";
        $text .= "HN : ".$row['hn']."\n";
        $text .= "ชื่อ - สกุล : ".$showpatient['name']."\n";
        $text .= "พนักงานเปล : ".$_SESSION['name']."\n";
        $text .= "กำลังดำเนินการรับผู้ป่วย : ".$row['job_receive']."\n";
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
        window.location = 'process_job';
        });
        </script>";  
 
?>