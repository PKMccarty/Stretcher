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
    require_once '../../Component/DbUtils.php';
    $conn2 = DbUtilscart::get_cart_connection();
    $conn = DbUtils::get_hosxp_connection();
    $text = '';
    $stat = '3';
    $sql ="select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where job_id =:job_id";
    $stmt = $conn2->prepare($sql);
    $stmt->bindParam(':job_id', $_POST['ip']);
    $stmt ->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $selectsql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd where job_id =:job_id";
    try {
        $selectstmt = $conn2->prepare($selectsql);
        $selectstmt->bindParam(':job_id', $row['job_id']);
        $selectstmt ->execute();
    
        $seticon = 'success';
        $settext = 'รับผู้ป่วยเรียบร้อย';
    }catch (PDOException  $e) {
            echo $e->getMessage();
        $seticon = 'error';
        $settext = 'รับผู้ป่วยไม่สำเร็จ';
    }
    while ($selectrow = $selectstmt->fetch(PDO::FETCH_ASSOC)){

        $updateaccept2 = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept SET `ac_receive_date_patient` = '".date('Y-m-d')."',ac_receive_time_patient ='".date('h:i:sa')."' where job_id =:job_id";
        $updateaccept2 = $conn2->prepare($updateaccept2);
        $updateaccept2->bindParam(':job_id', $row['job_id']);
        $updateaccept2 ->execute();


        $updatedetail = "UPDATE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job SET `sta_id` = :sta where job_id = :job_id";
        $updatedetailstmt = $conn2->prepare($updatedetail);
        $updatedetailstmt->bindParam(':job_id', $row['job_id']);
        $updatedetailstmt->bindParam(':sta', $stat);
        $updatedetailstmt ->execute();
    }
        if($settext == 'รับผู้ป่วยเรียบร้อย'){

        $sqlshowpatient = "select  CONCAT(pname,fname,' ',lname) as 'name' from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
        $stmtpatient=$conn->prepare($sqlshowpatient);
        $stmtpatient->bindParam(':hn', $row['hn']);
        $stmtpatient ->execute();
        $showpatient = $stmtpatient->fetch(PDO::FETCH_ASSOC);
        
        $token = connectConstant::CONNECTION_TOKEN_LINE;
        $text .= "\n"."------------------------------"."\n";
        $text .= "รับผู้ป่วยแล้ว";
        $text .= "\n"."------------------------------"."\n";
        $text .= "HN : ".$row['hn']."\n";
        $text .= "ชื่อ - สกุล : ".$showpatient['name']."\n";
        $text .= "พนักงานเปล : ".$_SESSION['name']."\n";
        $text .= "กำลังดำเนินการส่งผู้ป่วยไปยัง : ".$row['job_send']."\n";
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