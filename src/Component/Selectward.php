<?php
require_once 'DbUtils.php';
require_once 'DbUtilscart.php';
require_once 'datethai.php';
class Selectward
{
    public static function showjob2()
    { 
        echo '<style>.thover:hover{cursor:pointer !important;}</style>';
        $conn = DbUtils::get_hosxp_connection();
        $conn2 = DbUtilscart::get_cart_connection();
        $result = '';
        $result .= '
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">รายการร้องขอเคลื่อนย้ายผู้ป่วย</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="display2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>HN</th>
                                <th>นำส่งผู้ป่วย</th>
                                <th>เวลาร้องขอ</th>
                                <th>อุปกรณ์</th>
                                <th>Note</th>
                                <th>ความเร่งด่วน</th>
                                <th>เจ้าหน้าที่เคลื่อนย้ายผู้ป่วย</th>
                                <th>สถานะ</th>
                                <th>สถานะนัด</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        $sql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON status.sta_id = job.sta_id WHERE job.receive_ipd = :ward and job.sta_id not in ('4','5','6')";
        try{
            $stmt = $conn2->prepare($sql);
            $stmt->bindParam(':ward' , $_SESSION['ward'], PDO::PARAM_STR);
            $stmt->execute();
            foreach($stmt as $value):
                $value3 ='';
                $dataa ='';
                $value4 ='';
                $data ='';
                $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = :job_id";
                try{
                    $stmt2 = $conn2->prepare($sql2);
                    $stmt2->bindParam(':job_id' , $value['job_id'], PDO::PARAM_STR);
                    $stmt2->execute();
                    foreach($stmt2 as $value2):
                        $value3 .= $value2['wa_name'].',';
                        $dataa .= $value2['wa_id'].',';
                    endforeach;
                $sql3 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username u ON a.u_id = u.u_id where job_id = :job_id";
                    try{
                        $stmtcheck = $conn2->prepare($sql3);
                        $stmtcheck->bindParam(':job_id' , $value['job_id'], PDO::PARAM_STR);
                        $stmtcheck->execute();
                        if($checkresult = $stmtcheck->fetch()){
                            $sql4 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = :u_name and (account_disable is null or account_disable <> 'Y') ";
                            $stmtcheck2 = $conn->prepare($sql4);
                            $stmtcheck2->bindParam(':u_name' , $checkresult['u_name'], PDO::PARAM_STR);
                            $stmtcheck2->execute();
                            $checkresult2 = $stmtcheck2->fetch();
                            $checkname = $checkresult2['name'];
                        }
                        else{
                            $checkname = '';
                        }
                    }catch (PDOException  $e) {
                        echo $e->getMessage();
                    }
                    $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                    $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
                        $result.= '<tr>
                        <td>'.$value['hn'].'</td>
                        <td>'.$value['job_send'].'</td>
                        <td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>
                        <td>'.$value4.'</td>
                        <td>'.$value['job_note'].'</td>
                        <td>'.$value['job_priority'].'</td>
                        <td>'.$checkname.'</td>
                        <td>'.$value['sta_name'].'</td>';
                        $sqlapp = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".appointment where appointment_id = :app";
                            $stmtapp = $conn2->prepare($sqlapp);
                            $stmtapp->bindParam(':app',$value['appointment_id']);
                            $stmtapp->execute();
                            $approw = $stmtapp->fetch();
                        if($value['appointment_id']==1){
                            $result .='<td>'.$approw['appointment_name'].'</td>';
                        }else{
                            
                            $result .='<td><a class="thover" data-bs-toggle="modal" data-bs-target="#exampleModal20" data-bs-whatever="'.$value['job_appointment_date'].'">'.$approw['appointment_name'].'</a></td>';
                        }
                        if($value['sta_id']==1){
                            $result.='<td class="text-center"><a class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">ยกเลิก</a></td>';
                        }else{
                            $result.='<td class="text-center"><a class="btn btn-danger disabled">ยกเลิก</a></td>';
                        }
                                $result.='</tr>';
                }
                catch (PDOException  $e) {
                    echo $e->getMessage();
                }
            endforeach;
            $result .= '</tbody></table></div></div></div>';
            return $result;
        }catch (PDOException  $e) {
            echo $e->getMessage();
        }
    }
    public static function showjob()
    { 
        echo '<style>.thover:hover{cursor:pointer !important;}</style>';
        $conn = DbUtils::get_hosxp_connection();
        $conn2 = DbUtilscart::get_cart_connection();
        $result = '';
        $result .= '
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">รายการรับผู้ป่วย</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="display1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>HN</th>
                                <th>ส่งจาก</th>
                                <th>อุปกรณ์</th>
                                <th>เวลาร้องขอ</th>
                                <th>เวลาดำเนินการ</th>
                                <th>เจ้าหน้าที่เวรเปล</th>
                                <th>ความเร่งด่วน</th>
                                <th>สถานะ</th>
                                <th>สถานะนัด</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        $sql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job INNER JOIN status ON status.sta_id = job.sta_id WHERE job.send_ipd = :ward and job.sta_id not in ('4','5','6')";
        try{
            $stmt = $conn2->prepare($sql);
            $stmt->bindParam(':ward' , $_SESSION['ward'], PDO::PARAM_STR);
            $stmt->execute();
            foreach($stmt as $value):

                $sql2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail INNER JOIN wagon ON wagon.wa_id = job_detail.wa_id WHERE job_detail.job_id = :job_id";
                try{
                $stmt2 = $conn2->prepare($sql2);
                $stmt2->bindParam(':job_id' , $value['job_id'], PDO::PARAM_INT);
                $stmt2->execute();
                $value2 = $stmt2->fetch();
                $sql3 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept WHERE accept.job_id = :job_id";
                    try{
                        $stmt3 = $conn2->prepare($sql3);
                        $stmt3->bindParam(':job_id' , $value['job_id'], PDO::PARAM_INT);
                        $stmt3->execute();
                    if($value3 = $stmt3->fetch()){
                        $time_pro = DateThai($value3['date']).' '.TimeThai($value3['accept_time']);
                        $sql4 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username WHERE username.u_id = :u_id";
                        try{
                            $stmt4 = $conn2->prepare($sql4);
                            $stmt4->bindParam(':u_id' , $value3['u_id'], PDO::PARAM_INT);
                            $stmt4->execute();
                            $value4 = $stmt4->fetch();
                            $sql5 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = :u_name and (account_disable is null or account_disable <> 'Y') ";
                            $value4['u_name'];
                            try{
                                $stmt5 = $conn->prepare($sql5);
                                $stmt5->bindParam(':u_name' , $value4['u_name'], PDO::PARAM_STR);
                                $stmt5->execute();
                                $value5 = $stmt5->fetch();
                                $pname = $value5['name'];
                            }catch (PDOException  $e) {
                                echo $e->getMessage();
                            }
                        }catch (PDOException  $e) {
                            echo $e->getMessage();
                        }
                    }else{
                        $time_pro = '';
                        $pname = '';
                    }
                    $value3 ='';
                    $dataa ='';
                    $value4 ='';
                    $data ='';
                    $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = :job_id";
                        $stmt2 = $conn2->prepare($sql2);
                        $stmt2->bindParam(':job_id' , $value['job_id'], PDO::PARAM_STR);
                        $stmt2->execute();
                        foreach($stmt2 as $value2):
                            $value3 .= $value2['wa_name'].',';
                            $dataa .= $value2['wa_id'].',';
                        endforeach;
                   $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                    $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
                    $result.= '<tr>
                                <td>'.$value['hn'].'</td>
                                <td>'.$value['job_receive'].'</td>
                                <td>'.$value4.'</td>
                                <td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>';
                                if($time_pro==''){
                                    $result.='<td></td>';
                                }
                                else{
                                    $result.='<td>'.$time_pro.'  น.</td>';
                                }
                                $result.='<td>'.$pname.'</td>
                                <td>'.$value['job_priority'].'</td>
                                <td>'.$value['sta_name'].'</td>';
                                $sqlapp = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".appointment where appointment_id = :app";
                                $stmtapp = $conn2->prepare($sqlapp);
                                $stmtapp->bindParam(':app',$value['appointment_id']);
                                $stmtapp->execute();
                                $approw = $stmtapp->fetch();
                            if($value['appointment_id']==1){
                                $result .='<td>'.$approw['appointment_name'].'</td>';
                            }else{
                                
                                $result .='<td><a class="thover" data-bs-toggle="modal" data-bs-target="#exampleModal20" data-bs-whatever="'.$value['job_appointment_date'].'">'.$approw['appointment_name'].'</a></td>';
                            }
                                if($value['sta_id']==4){
                                    $result.=' <td><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever4="'.$value['job_id'].'" data-bs-whatever5="'.$value['hn'].'">รับผู้ป่วย</a></td>';
                                }
                                else{
                                    $result.=' <td></td>';
                                }
                             $result.='</tr>';
                    }catch (PDOException  $e) {
                        echo $e->getMessage();
                    }
                }catch (PDOException  $e) {
                    echo $e->getMessage();
                }
            endforeach;
            $result .= '</tbody></table></div></div></div>';
            return $result;
        }catch (PDOException  $e) {
            echo $e->getMessage();
        }
    }
}