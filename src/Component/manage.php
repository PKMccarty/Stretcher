<?php
class manage {
    public static function getstatic($conn2){
        error_reporting(0);
        $x=100;
        $g=1;
        require_once '../../Component/DbUtils.php';
        $conn = DbUtils::get_hosxp_connection();
        $result ='';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where role_id = 1";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
                $result .='<div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">สถิติเจ้าหน้าที่เวรเปล</h6>
                </div><div class="card-body">';
                foreach($selectstmt as $value):
                    $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                    $stmtvalue = $conn->prepare($sqlvalue);
                    $stmtvalue ->execute();
                    $row = $stmtvalue->fetch();

                    $sqlvalue2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where u_name = '".$value['u_name']."'";
                    $stmtvalue2 = $conn2->prepare($sqlvalue2);
                    $stmtvalue2 ->execute();
                    $roww = $stmtvalue2->fetch();



                    $selectsql2 = "SELECT *,COUNT(*) as `row` FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username u ON a.u_id = u.u_id where a.u_id ='".$roww['u_id']."' GROUP BY a.u_id";
                    try{
                        $row2='';
                        $stmtvalue2 = $conn2->prepare($selectsql2);
                        $stmtvalue2 ->execute();
                        if(!$row2 = $stmtvalue2->fetch()){
                            $row2='0';
                        }else{
                            $row2 = $row2['row'];
                        }
                    }catch (PDOException  $e){
                        echo $e->getMessage();
                    }
                    $result .='<div class="container">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading ">
                            <a class="panel-title text-secondary" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$x.'">'.$row['name'].'<span
                            class="float-right">'.$row2.' รายการ</span></a>
                        </div>
                        <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: '.$row2.'%" aria-valuemin="0" aria-valuemax="1000"></div>
                        </div>
                        <div id="collapse'.$x.'" class="panel-collapse collapse">
                          <div class="panel-body">';
                          $result .= manage::tableprofile($roww['u_id']);
                $result .='</div>
                        </div>
                      </div>
                    </div> 
                  </div><hr><hr>';
                  $g++;
                  $x++;
                endforeach;
                $result .='</div></div>';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        $conn2=null;
        return array($result, $g);
    }
    public static function getstatic_daily($conn2){
        error_reporting(0);
        $x=1;
        require_once '../../Component/DbUtils.php';
        require_once '../../Component/datethai.php';
        $conn = DbUtils::get_hosxp_connection();
        $result ='';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where role_id = 1";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
                $result .='<div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">สถิติเจ้าหน้าที่เวรเปล ประจำวัน   '.DateThai(date("Y-m-d")).'</h6>
                </div><div class="card-body">';
                foreach($selectstmt as $value):
                    $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                    $stmtvalue = $conn->prepare($sqlvalue);
                    $stmtvalue ->execute();
                    $row = $stmtvalue->fetch();

                    $sqlvalue2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where u_name = '".$value['u_name']."'";
                    $stmtvalue2 = $conn2->prepare($sqlvalue2);
                    $stmtvalue2 ->execute();
                    $roww = $stmtvalue2->fetch();


                    $selectsql2 = "SELECT *,COUNT(*) as `row` FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username u ON a.u_id = u.u_id where a.date='".date('Y-m-d')."' and a.u_id ='".$roww['u_id']."' GROUP BY a.u_id";
                    try{
                        $row2='';
                        $stmtvalue2 = $conn2->prepare($selectsql2);
                        $stmtvalue2 ->execute();
                        if(!$row2 = $stmtvalue2->fetch()){
                            $row2='0';
                        }else{
                            $row2 = $row2['row'];
                        }
                    }catch (PDOException  $e){
                        echo $e->getMessage();
                    }
                    $result .='<div class="container">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading ">
                            <a class="panel-title text-secondary" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$x.'">'.$row['name'].'<span
                            class="float-right">'.$row2.' รายการ</span></a>
                        </div>
                        <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: '.$row2.'%" aria-valuemin="0" aria-valuemax="1000"></div>
                        </div>
                        <div id="collapse'.$x.'" class="panel-collapse collapse">
                          <div class="panel-body">';
                          $result .= manage::tableprofile_daily($roww['u_id']);
                          $result .='</div>
                        </div>
                      </div>
                    </div> 
                  </div><hr><hr>';
                    $x++;
                endforeach;
                $result .='</div></div>';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        $conn2=null;
        return $result;
    }
    public static function gettable($conn2){
        error_reporting(0);
        require_once '../../Component/DbUtils.php';
        require_once '../../Component/datethai.php';
        $conn = DbUtils::get_hosxp_connection();
        $result = '';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON job.u_id = username.u_id where job.sta_id not in ('2','3','4','6','5') order by job_id Desc";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
            $result .='
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">รายการเคสกำลังดำเนินการ</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-bordered" id="showingdisplay" width="100%" cellspacing="0" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th>Hn</th>
                                    <th>รับผู้ป่วย</th>
                                    <th>ส่งผู้ป่วย</th>
                                    <th>อุปกรณ</th>
                                    <th>ผู้ร้องขอ</th>
                                    <th>วัน - เวลาร้องขอ</th>
                                    <th>สถานะนัด</th>
                                    <th>วัน - เวลานัด</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach($selectstmt as $value):
                $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue = $conn->prepare($sqlvalue);
                $stmtvalue ->execute();
                if($row = $stmtvalue->fetch()){
                    $showname =  $row['name'];
                }
                else{
                    if($value['receive_ipd']!=''){
                        $checksql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
                        $checkstmt = $conn->prepare($checksql);
                        $checkstmt->bindParam(':ward',$value['receive_ipd']);
                        $checkstmt ->execute();
                        $checkrow = $checkstmt->fetch();
                        $showname = $checkrow['name'];
                    }else{
                        $showname = '';
                    }
                }
                $sqlvalue2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON accept.u_id = username.u_id where accept.job_id = '".$value['job_id']."'";
                $stmtvalue2 = $conn2->prepare($sqlvalue2);
                $stmtvalue2 ->execute();
                $row2 = $stmtvalue2->fetch();
                

                $sqlvalue4 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$row2['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue4 = $conn->prepare($sqlvalue4);
                $stmtvalue4 ->execute();
                $row4 = $stmtvalue4->fetch();
                try{

                }
                catch(PDOException  $e){
                    echo $e->getMessage();
                }

                $sqlvalue3 = "SELECT *
                FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail
                LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = '".$value['job_id']."'";
                $stmtvalue3 = $conn2->prepare($sqlvalue3);
                $stmtvalue3 ->execute();
                $waname = '';
                $waname2 = '';
                foreach($stmtvalue3 as $value2):
                    $waname .= $value2['wa_name'].',';
                endforeach;
                $waname2 = substr( $waname, 0, strlen( $waname ) - 1 );
                $result .= '<tr>
                            <td>'.$value['hn'].'</td>
                            <td>'.$value['job_receive'].'</td>
                            <td>'.$value['job_send'].'</td>';
                            $result .='<td>'.$waname2.'</td>';
                            if($showname==''){
                                $result .='<td>'.$value['job_receive'].'</td>';
                            }else{
                                $result .='<td>'.$showname.'</td>';
                            }
                            $result .='<td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>';
                            $ssql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".appointment where appointment_id = :app";
                            $stmtssql = $conn2->prepare($ssql);
                            $stmtssql->bindParam(':app',$value['appointment_id']);
                            $stmtssql->execute();
                            $rresult = $stmtssql->Fetch();
                            $result .='<td>'.$rresult['appointment_name'].'</td>';
                            if($value['job_appointment_date']==''){
                                $result .='<td></td>';
                            }else{
                                $result .='<td>'.Fulldate($value['job_appointment_date']).' น.</td>';
                            }
                            $result .='<td>'.$value['job_note'].'</td>';
                $result .='<td class="text-center">';
                if($value['sta_id']==1){
                    $result .='<a class="me-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จ่ายงาน</a>';
                }
                else if($value['sta_id']==4){
                    $result .='<a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal21" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จบงาน</a></td></tr>';
                }
                else if($value['sta_id']==5){
                    $result .='<a class="btn btn-success disabled">'.$value['sta_name'].'</a></td></tr>';
                }
                else if($value['sta_id']==6){
                    $result .='<a class="btn btn-success disabled">จบงาน</a></td></tr>';
                }
                else{
                    $result .='<a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$row2['u_name'].'">ยกเลิก</a></td></tr>';
                }
            endforeach;

            $result .='</tbody></table></div><a class="btn btn-primary mt-5 me-3">+ Report</a><a class="btn btn-primary mt-5">+ Export</a></div></div>';
            $result .='';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        return $result;
    }
    public static function gettable3($conn2){
        error_reporting(0);
        require_once '../../Component/DbUtils.php';
        require_once '../../Component/datethai.php';
        $conn = DbUtils::get_hosxp_connection();
        $result = '';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON job.u_id = username.u_id where job.sta_id not in ('1','6','5') order by job_id Desc";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
            $result .='
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">รายการเคสกำลังดำเนินการ</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-bordered" id="showingdisplay2" width="100%" cellspacing="0" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>Hn</th>
                                    <th>รับผู้ป่วย</th>
                                    <th>ส่งผู้ป่วย</th>
                                    <th>อุปกรณ</th>
                                    <th>ผู้ร้องขอ</th>
                                    <th>เจ้าหน้าที่</th>
                                    <th>วัน - เวลาร้องขอ</th>
                                    <th>วัน - เวลารับเคส</th>
                                    <th>วัน - เวลารับผู้ป่วย</th>
                                    <th>วัน - เวลาส่งผู้ป่วย</th>
                                    <th>สถานะนัด</th>
                                    <th>วัน - เวลานัด</th>
                                    <th>Log</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach($selectstmt as $value):
                $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue = $conn->prepare($sqlvalue);
                $stmtvalue ->execute();
                if($row = $stmtvalue->fetch()){
                    $showname =  $row['name'];
                }
                else{
                    if($value['receive_ipd']!=''){
                        $checksql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
                        $checkstmt = $conn->prepare($checksql);
                        $checkstmt->bindParam(':ward',$value['receive_ipd']);
                        $checkstmt ->execute();
                        $checkrow = $checkstmt->fetch();
                        $showname = $checkrow['name'];
                    }else{
                        $showname = '';
                    }
                }
                $sqlvalue2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON accept.u_id = username.u_id where accept.job_id = '".$value['job_id']."'";
                $stmtvalue2 = $conn2->prepare($sqlvalue2);
                $stmtvalue2 ->execute();
                $row2 = $stmtvalue2->fetch();
                

                $sqlvalue4 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$row2['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue4 = $conn->prepare($sqlvalue4);
                $stmtvalue4 ->execute();
                $row4 = $stmtvalue4->fetch();
                try{

                }
                catch(PDOException  $e){
                    echo $e->getMessage();
                }

                $sqlvalue3 = "SELECT *
                FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail
                LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = '".$value['job_id']."'";
                $stmtvalue3 = $conn2->prepare($sqlvalue3);
                $stmtvalue3 ->execute();
                $waname = '';
                $waname2 = '';
                foreach($stmtvalue3 as $value2):
                    $waname .= $value2['wa_name'].',';
                endforeach;
                $waname2 = substr( $waname, 0, strlen( $waname ) - 1 );
                $result .= '<tr>
                            <td>'.$value['sta_name'].'</td>
                            <td>'.$value['hn'].'</td>
                            <td>'.$value['job_receive'].'</td>
                            <td>'.$value['job_send'].'</td>';
                            $result .='<td>'.$waname2.'</td>';
                            if($showname==''){
                                $result .='<td>'.$value['job_receive'].'</td>';
                            }else{
                                $result .='<td>'.$showname.'</td>';
                            }
                            if($row4['name']!=''){  
                                $result .='<td>'.$row4['name'].'</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $result .='<td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>';
                            if($row2['ac_receive_date']!='' && $row2['ac_receive_time']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date']).' '.TimeThai($row2['ac_receive_time']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_receive_date_patient']!='' && $row2['ac_receive_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date_patient']).' '.TimeThai($row2['ac_receive_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_send_date_patient']!='' && $row2['ac_send_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_send_date_patient']).' '.TimeThai($row2['ac_send_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $ssql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".appointment where appointment_id = :app";
                            $stmtssql = $conn2->prepare($ssql);
                            $stmtssql->bindParam(':app',$value['appointment_id']);
                            $stmtssql->execute();
                            $rresult = $stmtssql->Fetch();
                            $result .='<td>'.$rresult['appointment_name'].'</td>';
                            if($value['job_appointment_date']==''){
                                $result .='<td></td>';
                            }else{
                                $result .='<td>'.Fulldate($value['job_appointment_date']).' น.</td>';
                            }
                            $result .='<td>'.$value['job_log'].'</td>';
                $result .='<td class="text-center">';
                if($value['sta_id']==1){
                    $result .='<a class="me-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จ่ายงาน</a>';
                }
                else if($value['sta_id']==4){
                    $result .='<a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal21" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จบงาน</a></td></tr>';
                }
                else if($value['sta_id']==5){
                    $result .='<a class="btn btn-success disabled">'.$value['sta_name'].'</a></td></tr>';
                }
                else if($value['sta_id']==6){
                    $result .='<a class="btn btn-success disabled">จบงาน</a></td></tr>';
                }
                else{
                    $result .='<a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$row2['u_name'].'">ยกเลิก</a></td></tr>';
                }
            endforeach;

            $result .='</tbody></table></div><a class="btn btn-primary mt-5 me-3">+ Report</a><a class="btn btn-primary mt-5">+ Export</a></div></div>';
            $result .='';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        return $result;
    }
    public static function gettable4($conn2){
        error_reporting(0);
        require_once '../../Component/DbUtils.php';
        require_once '../../Component/datethai.php';
        $conn = DbUtils::get_hosxp_connection();
        $result = '';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON job.u_id = username.u_id where job.sta_id not in ('1','2','3','4')  order by job_id Desc";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
            $result .='
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">รายการเคสกำลังดำเนินการ</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-bordered" id="showingdisplay3" width="100%" cellspacing="0" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>Hn</th>
                                    <th>รับผู้ป่วย</th>
                                    <th>ส่งผู้ป่วย</th>
                                    <th>อุปกรณ</th>
                                    <th>ผู้ร้องขอ</th>
                                    <th>เจ้าหน้าที่</th>
                                    <th>วัน - เวลาร้องขอ</th>
                                    <th>วัน - เวลารับเคส</th>
                                    <th>วัน - เวลารับผู้ป่วย</th>
                                    <th>วัน - เวลาส่งผู้ป่วย</th>
                                    <th>สถานะนัด</th>
                                    <th>วัน - เวลานัด</th>
                                    <th>Log</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach($selectstmt as $value):
                $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue = $conn->prepare($sqlvalue);
                $stmtvalue ->execute();
                if($row = $stmtvalue->fetch()){
                    $showname =  $row['name'];
                }
                else{
                    if($value['receive_ipd']!=''){
                        $checksql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
                        $checkstmt = $conn->prepare($checksql);
                        $checkstmt->bindParam(':ward',$value['receive_ipd']);
                        $checkstmt ->execute();
                        $checkrow = $checkstmt->fetch();
                        $showname = $checkrow['name'];
                    }else{
                        $showname = '';
                    }
                }
                $sqlvalue2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON accept.u_id = username.u_id where accept.job_id = '".$value['job_id']."'";
                $stmtvalue2 = $conn2->prepare($sqlvalue2);
                $stmtvalue2 ->execute();
                $row2 = $stmtvalue2->fetch();
                

                $sqlvalue4 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$row2['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue4 = $conn->prepare($sqlvalue4);
                $stmtvalue4 ->execute();
                $row4 = $stmtvalue4->fetch();
                try{

                }
                catch(PDOException  $e){
                    echo $e->getMessage();
                }

                $sqlvalue3 = "SELECT *
                FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail
                LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = '".$value['job_id']."'";
                $stmtvalue3 = $conn2->prepare($sqlvalue3);
                $stmtvalue3 ->execute();
                $waname = '';
                $waname2 = '';
                foreach($stmtvalue3 as $value2):
                    $waname .= $value2['wa_name'].',';
                endforeach;
                $waname2 = substr( $waname, 0, strlen( $waname ) - 1 );
                $result .= '<tr>
                            <td>'.$value['sta_name'].'</td>
                            <td>'.$value['hn'].'</td>
                            <td>'.$value['job_receive'].'</td>
                            <td>'.$value['job_send'].'</td>';
                            $result .='<td>'.$waname2.'</td>';
                            if($showname==''){
                                $result .='<td>'.$value['job_receive'].'</td>';
                            }else{
                                $result .='<td>'.$showname.'</td>';
                            }
                            if($row4['name']!=''){  
                                $result .='<td>'.$row4['name'].'</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $result .='<td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>';
                            if($row2['ac_receive_date']!='' && $row2['ac_receive_time']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date']).' '.TimeThai($row2['ac_receive_time']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_receive_date_patient']!='' && $row2['ac_receive_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date_patient']).' '.TimeThai($row2['ac_receive_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_send_date_patient']!='' && $row2['ac_send_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_send_date_patient']).' '.TimeThai($row2['ac_send_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $ssql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".appointment where appointment_id = :app";
                            $stmtssql = $conn2->prepare($ssql);
                            $stmtssql->bindParam(':app',$value['appointment_id']);
                            $stmtssql->execute();
                            $rresult = $stmtssql->Fetch();
                            $result .='<td>'.$rresult['appointment_name'].'</td>';
                            if($value['job_appointment_date']==''){
                                $result .='<td></td>';
                            }else{
                                $result .='<td>'.Fulldate($value['job_appointment_date']).' น.</td>';
                            }
                            $result .='<td>'.$value['job_log'].'</td></tr>';
            endforeach;

            $result .='</tbody></table></div><a class="btn btn-primary mt-5 me-3">+ Report</a><a class="btn btn-primary mt-5">+ Export</a></div></div>';
            $result .='';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        return $result;
    }
    public static function gettable5($conn2){
        /* error_reporting(0); */
        require_once '../../Component/DbUtils.php';
        require_once '../../Component/datethai.php';
        $conn = DbUtils::get_hosxp_connection();
        $result = '';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON job.u_id = username.u_id where job.sta_id not in ('1','2','3','5','6')  order by job_id Desc";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
            $result .='
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">รายการเคสกำลังดำเนินการ</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-bordered" id="showingdisplay3" width="100%" cellspacing="0" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>Hn</th>
                                    <th>รับผู้ป่วย</th>
                                    <th>ส่งผู้ป่วย</th>
                                    <th>อุปกรณ</th>
                                    <th>ผู้ร้องขอ</th>
                                    <th>เจ้าหน้าที่</th>
                                    <th>วัน - เวลาร้องขอ</th>
                                    <th>วัน - เวลารับเคส</th>
                                    <th>วัน - เวลารับผู้ป่วย</th>
                                    <th>วัน - เวลาส่งผู้ป่วย</th>
                                    <th>สถานะนัด</th>
                                    <th>วัน - เวลานัด</th>
                                    <th>Log</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach($selectstmt as $value):
                $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue = $conn->prepare($sqlvalue);
                $stmtvalue ->execute();
                if($row = $stmtvalue->fetch()){
                    $showname =  $row['name'];
                }
                else{
                    if($value['receive_ipd']!=''){
                        $checksql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
                        $checkstmt = $conn->prepare($checksql);
                        $checkstmt->bindParam(':ward',$value['receive_ipd']);
                        $checkstmt ->execute();
                        $checkrow = $checkstmt->fetch();
                        $showname = $checkrow['name'];
                    }else{
                        $showname = '';
                    }
                }
                $sqlvalue2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON accept.u_id = username.u_id where accept.job_id = '".$value['job_id']."'";
                $stmtvalue2 = $conn2->prepare($sqlvalue2);
                $stmtvalue2 ->execute();
                $row2 = $stmtvalue2->fetch();
                

                $sqlvalue4 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$row2['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue4 = $conn->prepare($sqlvalue4);
                $stmtvalue4 ->execute();
                $row4 = $stmtvalue4->fetch();
                try{

                }
                catch(PDOException  $e){
                    echo $e->getMessage();
                }

                $sqlvalue3 = "SELECT *
                FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail
                LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = '".$value['job_id']."'";
                $stmtvalue3 = $conn2->prepare($sqlvalue3);
                $stmtvalue3 ->execute();
                $waname = '';
                $waname2 = '';
                foreach($stmtvalue3 as $value2):
                    $waname .= $value2['wa_name'].',';
                endforeach;
                $waname2 = substr( $waname, 0, strlen( $waname ) - 1 );
                            $result .= '<tr>
                            <td>'.$value['sta_name'].'</td>
                            <td>'.$value['hn'].'</td>
                            <td>'.$value['job_receive'].'</td>
                            <td>'.$value['job_send'].'</td>';
                            $result .='<td>'.$waname2.'</td>';
                            if($showname==''){
                                $result .='<td>'.$value['job_receive'].'</td>';
                            }else{
                                $result .='<td>'.$showname.'</td>';
                            }
                            if($row4['name']!=''){  
                                $result .='<td>'.$row4['name'].'</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $result .='<td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>';
                            if($row2['ac_receive_date']!='' && $row2['ac_receive_time']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date']).' '.TimeThai($row2['ac_receive_time']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_receive_date_patient']!='' && $row2['ac_receive_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date_patient']).' '.TimeThai($row2['ac_receive_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_send_date_patient']!='' && $row2['ac_send_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_send_date_patient']).' '.TimeThai($row2['ac_send_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $ssql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".appointment where appointment_id = :app";
                            $stmtssql = $conn2->prepare($ssql);
                            $stmtssql->bindParam(':app',$value['appointment_id']);
                            $stmtssql->execute();
                            $rresult = $stmtssql->Fetch();
                            $result .='<td>'.$rresult['appointment_name'].'</td>';
                            if($value['job_appointment_date']==''){
                                $result .='<td></td>';
                            }else{
                                $result .='<td>'.Fulldate($value['job_appointment_date']).' น.</td>';
                            }
                            $result .='<td>'.$value['job_log'].'</td>';
                $result .='<td class="text-center">';
                if($value['sta_id']==1){
                    $result .='<a class="me-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จ่ายงาน</a>';
                }
                else if($value['sta_id']==4){
                    $result .='<a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal21" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จบงาน</a></td></tr>';
                }
                else if($value['sta_id']==5){
                    $result .='<a class="btn btn-success disabled">'.$value['sta_name'].'</a></td></tr>';
                }
                else if($value['sta_id']==6){
                    $result .='<a class="btn btn-success disabled">จบงาน</a></td></tr>';
                }
                else{
                    $result .='<a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$row2['u_name'].'">ยกเลิก</a></td></tr>';
                }
            endforeach;

            $result .='</tbody></table></div><a class="btn btn-primary mt-5 me-3">+ Report</a><a class="btn btn-primary mt-5">+ Export</a></div></div>';
            $result .='';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        return $result;
    }
    public static function gettable2($conn2){
        error_reporting(0);
        require_once '../../Component/DbUtils.php';
        require_once '../../Component/datethai.php';
        $conn = DbUtils::get_hosxp_connection();
        $result = '';
        $selectsql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON job.u_id = username.u_id where job.sta_id in ('6','5')";
        try {
            $selectstmt = $conn2->prepare($selectsql);
            $selectstmt ->execute();
            $result .='
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">รายการเคส</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-bordered" id="showdisplay1" width="100%" cellspacing="0" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>Hn</th>
                                    <th>ตึกที่ไปส่งผู้ป่วย</th>
                                    <th>ตึกที่รับผู้ป่วย</th>
                                    <th>วัน - เวลา ร้องขอ</th>
                                    <th>วัน - เวลา รับเคส</th>
                                    <th>วัน - เวลา รับผู้ป่วย</th>
                                    <th>วัน - เวลา ส่งผู้ป่วยถึงที่</th>
                                    <th>อุปกรณ</th>
                                    <th>ผู้ร้องขอ</th>
                                    <th>เจ้าหน้าที่</th>
                                    <th>Log</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach($selectstmt as $value):
                $sqlvalue = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue = $conn->prepare($sqlvalue);
                $stmtvalue ->execute();
                if($row = $stmtvalue->fetch()){
                    $showname =  $row['name'];
                }
                else{
                    if($value['receive_ipd']!=''){
                        $checksql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
                        $checkstmt = $conn->prepare($checksql);
                        $checkstmt->bindParam(':ward',$value['receive_ipd']);
                        $checkstmt ->execute();
                        $checkrow = $checkstmt->fetch();
                        $showname = $checkrow['name'];
                    }else{
                        $showname = '';
                    }
                }
                $sqlvalue2 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON accept.u_id = username.u_id where accept.job_id = '".$value['job_id']."'";
                $stmtvalue2 = $conn2->prepare($sqlvalue2);
                $stmtvalue2 ->execute();
                $row2 = $stmtvalue2->fetch();
                

                $sqlvalue4 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$row2['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmtvalue4 = $conn->prepare($sqlvalue4);
                $stmtvalue4 ->execute();
                $row4 = $stmtvalue4->fetch();
                try{

                }
                catch(PDOException  $e){
                    echo $e->getMessage();
                }

                $sqlvalue3 = "SELECT *
                FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail
                LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon ON job_detail.wa_id = wagon.wa_id where job_detail.job_id = '".$value['job_id']."'";
                $stmtvalue3 = $conn2->prepare($sqlvalue3);
                $stmtvalue3 ->execute();
                $waname = '';
                $waname2 = '';
                foreach($stmtvalue3 as $value2):
                    $waname .= $value2['wa_name'].',';
                endforeach;
                $waname2 = substr( $waname, 0, strlen( $waname ) - 1 );
                $result .= '<tr>
                            <td>'.$value['sta_name'].'</td>
                            <td>'.$value['hn'].'</td>
                            <td>'.$value['job_receive'].'</td>
                            <td>'.$value['job_send'].'</td>';
                            $result .='<td>'.$waname2.'</td>';
                            if($showname==''){
                                $result .='<td>'.$value['job_receive'].'</td>';
                            }else{
                                $result .='<td>'.$showname.'</td>';
                            }
                            if($row4['name']!=''){  
                                $result .='<td>'.$row4['name'].'</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($value['job_date']!='' && $value['job_time']!=''){
                                $result .= '<td>'.DateThai($value['job_date']).' '.TimeThai($value['job_time']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_receive_date']!='' && $row2['ac_receive_time']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date']).' '.TimeThai($row2['ac_receive_time']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_receive_date_patient']!='' && $row2['ac_receive_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_receive_date_patient']).' '.TimeThai($row2['ac_receive_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            if($row2['ac_send_date_patient']!='' && $row2['ac_send_time_patient']!=''){
                                $result .= '<td>'.DateThai($row2['ac_send_date_patient']).' '.TimeThai($row2['ac_send_time_patient']).' น.</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $result .='<td>'.$waname2.'</td>
                            <td>'.$showname.'</td>';
                            if($row4['name']!=''){  
                                $result .='<td>'.$row4['name'].'</td>';
                            }else{
                                $result .='<td></td>';
                            }
                            $result .='<td>'.$value['job_log'].'</td>';
                $result .='<td class="text-center">';
                if($value['sta_id']==1){
                    $result .='<a class="me-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$value['hn'].'">จ่ายงาน</a>';
                }
                else if($value['sta_id']==4){
                    $result .='<a class="btn btn-success disabled">'.$value['sta_name'].'</a></td></tr>';
                }
                else if($value['sta_id']==5){
                    $result .='<a class="btn btn-success disabled">'.$value['sta_name'].'</a></td></tr>';
                }
                else if($value['sta_id']==6){
                    $result .='<a class="btn btn-success disabled">จบงาน</a></td></tr>';
                }
                else{
                    $result .='<a class="btn btn-danger w-50" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever="'.$value['job_id'].'" data-bs-whatever2="'.$row2['u_name'].'">ยกเลิก</a></td></tr>';
                }
            endforeach;

            $result .='</tbody></table></div><a class="btn btn-primary mt-5 me-3">+ Report</a><a class="btn btn-primary mt-5">+ Export</a></div></div>';
            $result .='';
        }catch (PDOException  $e) {
                echo $e->getMessage();
        }
        return $result;
    }
        public static function getcustomer($conn2,$conn){
            error_reporting(0);
            require_once '../../Component/DbUtils.php';
            $conn = $conn;
            $conn2 = $conn2;
            $result ='';
            $result .='<td><select id="mySelect" class="form-control" name="select">';
            $result .='<option value="">----เลือกเจ้าหน้าที่ปฏิบัติงาน ----</option>';
            $dropsql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where role_id = 1";
            $stmtdrop = $conn2->prepare($dropsql);
            $stmtdrop ->execute();
                                    
            foreach($stmtdrop as $value5):
                $select5 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$value5['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                $stmt5 = $conn->prepare($select5);
                $stmt5 ->execute();
                $result5 = $stmt5->fetch();
                $result .='<option value="'.$value5['u_id'].'">'.$result5['name'].'</option>';
            endforeach;
            $result .='</select></td>';
            return $result;
        }
        public static function tableprofile($uid){
            require_once __DIR__.'/datethai.php';
            $conn2 = DbUtilscart::get_cart_connection();
    
            $values =[
                ':id'=>$uid
            ];
            $x=1;
            $sql ="select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a where j.job_id=a.job_id and a.u_id = :id";
            $stmt = $conn2->prepare($sql);
            $stmt->execute($values);
            $resultText = '';
            $resultText .= '
            <div class="table-responsive">
                <table class="table table-bordered display'.$x.'" width="100%" cellspacing="0">
                <thead>
            <tr>
            <th>จุดรับ</th>
            <th>จุดส่ง</th>
            <th>วันที่ - เวลา</th>
            <th>สถานะ</th>
            </tr></thead><tbody>';
            foreach($stmt as $row):
                if($row['ac_st_id'] == 1){
                    $st = 'สำเร็จ';
                }else if($row['ac_st_id'] == 2){
                    $st = 'ยกเลิก';
                }else{
                    $st = 'กำลังดำเนินการ';
                }
                $resultText .= '<tr><td>'.$row['job_receive'].'</td>';
                $resultText .= '<td>'.$row['job_send'].'</td>';
                $resultText .= '<td>'.DateThai($row['date']).'  '.TimeThai($row['accept_time']).'</td>';
                $resultText .= '<td>'.$st.'</td></tr>';
                $x++;
            endforeach;
            $resultText .='
            <tbody></table></div>';
    
    
            return $resultText;
    
        }
        public static function tableprofile_daily($uid){
            require_once __DIR__.'/datethai.php';
            $conn2 = DbUtilscart::get_cart_connection();
    
            $values =[
                ':id'=>$uid
            ];
            $x=100;
            $sql ="select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a where j.job_id=a.job_id and a.u_id = :id and j.job_date = '".date('Y-m-d')."'";
            $stmt = $conn2->prepare($sql);
            $stmt->execute($values);
            $resultText = '';
            $resultText .= '
            <div class="table-responsive">
                <table class="table table-bordered display'.$x.'" width="100%" cellspacing="0">
                <thead>
            <tr>
            <th>จุดรับ</th>
            <th>จุดส่ง</th>
            <th>วันที่ - เวลา</th>
            <th>สถานะ</th>
            </tr></thead><tbody>';
            foreach($stmt as $row):
                if($row['ac_st_id'] == 1){
                    $st = 'สำเร็จ';
                }else if($row['ac_st_id'] == 2){
                    $st = 'ยกเลิก';
                }else{
                    $st = 'กำลังดำเนินการ';
                }
                $resultText .= '<tr><td>'.$row['job_receive'].'</td>';
                $resultText .= '<td>'.$row['job_send'].'</td>';
                $resultText .= '<td>'.DateThai($row['date']).'  '.TimeThai($row['accept_time']).'</td>';
                $resultText .= '<td>'.$st.'</td></tr>';
                $x++;
            endforeach;
            $resultText .='
            <tbody></table></div>';
    
    
            return $resultText;
    
        }
    }
?>

