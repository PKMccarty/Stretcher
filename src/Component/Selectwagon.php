<?php
require_once "Database/connectConstant.php";
require_once 'DbUtils.php';
require_once 'DbUtilscart.php';
require_once 'datethai.php';
class Selectwagon
{
    public static function newrequestjob(){
        echo '<link rel="stylesheet" href="../../vendor/view/css/circle.css">';
        $conn2 = DbUtilscart::get_cart_connection();
        $conn = DbUtils::get_hosxp_connection();
        $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and j.sta_id not in ('2','3','4','5','6') group by j.job_id order by j.sta_id";
        $stmt = $conn2->query($sql);
        $keyValueArray = $stmt->fetchAll();

        $checksql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and j.sta_id not in ('2','3','4','5','6') group by j.job_id order by j.sta_id";
        $checkstmt = $conn2->query($checksql);
        $checkstmt->execute();
        if($checkstmt->fetch()){
            $resultText = "";
            $i=1;
            $resultText .= '
            <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 hide-on-small">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                    <h1 class="h3 mb-0 text-gray-800">รายการร้องขอใหม่</h1>
                </div>                
            <div class="row mb-5">
                <div class="col-xl-1 text-dark">
                    <h4>HN</h4>
                </div>
                <div class="col-xl-1 text-dark">
                    <h4>จุดรับผู้ป่วย</h4>    
                </div>
                <div class="col-xl-1 text-dark">
                    <h4>จุดส่งผู้ป่วย</h4>
                </div>
                <div class="col-xl-2 text-dark">
                    <h4>อุปกรณ์</h4>
                </div>
                <div class="col-xl-2 text-dark">
                    <h4>Note</h4>
                </div>
                <div class="col-xl-1 text-dark">
                    <h4>เวลา</h4>
                </div>
                <div class="col-xl-1 text-dark">
                    <h4>ความเร่งด่วน</h4>
                </div>
                <div class="col-xl-2 text-dark">
                    <h4>สถานะ</h4>
                </div>
                <div class="col-xl-1 text-dark">
                    <h4>Action</h4>
                </div>
            </div>';
            foreach($keyValueArray as $row):
    
    /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                $stmt2 = $conn->query($sql2);
                $result = $stmt2->fetch(); */
                $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and job.job_id = '".$row['job_id']."' and hn = '".$row['hn']."'";
                $stmt4 = $conn2->query($sql4);
                $value3 ='';
                $stack = 0;
                $dataa ='';
                foreach($stmt4 as $value2):
                    $value3 .= $value2['wa_name'].',';
                    $dataa .= $value2['wa_id'].',';
                    $stack++;
                endforeach;
    
                $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
    
                $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
                $stmt3 = $conn->query($sql3);
                $result2 = $stmt3->fetch();
                if($row['job_priority'] == 'normal'){
                    $row['job_priority'] = 'ธรรมดา';
                }
                else if($row['job_priority'] == 'quick'){
                    $row['job_priority'] = 'ด่วน';
                }
                else if($row['job_priority'] == 'veryquick'){
                    $row['job_priority'] = 'ด่วนที่สุด';
                }
                if($row['sta_id'] == '1'){
                    $f='info';
                }
               else if($row['sta_id'] == '2'){
                    $f='primary';
                }
                else if($row['sta_id'] == '3'){
                    $f='warning';
                }
                else if($row['sta_id'] == '4'){
                    $f='secondary';
    
                }
                else if($row['sta_id'] == '5'){
                    $f='danger';
                }
                else if($row['sta_id'] == '6'){
                    $f='success';
                }
                $resultText .= '
    
                <div class="row hide-on-small">
                    <div class="col-xl-1 mb-3">'.$row['hn'].'</div>
                    <div class="col-xl-1 mb-3">'.$row['job_receive'].'</div>
                    <div class="col-xl-1 mb-3">'.$row['job_send'].'</div>
                    <div class="col-xl-2 mb-3">'.$value4.'</div>
                    <div class="col-xl-2 mb-3">'.$row['job_note'].'</div>
                    <div class="col-xl-1 mb-3">'.$row['job_time'].'</div>
                    <div class="col-xl-1 mb-3">'.$row['job_priority'].'</div>
                    <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>';
                    if($row['sta_id'] == 1){
                        $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>
                        </div>';
                    }
                    else if($row['sta_id'] == 2){
                        $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">รับผู้ป่วย</a></div>
                        </div>';
                    }
                    else if($row['sta_id'] == 3){
                        $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">ส่งผู้ป่วย</a></div>
                        </div>';
                    }
                    else if($row['sta_id'] == 4){
                        $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">ส่งเรียบร้อย</a></div>
                        </div>';
                    }
                    else if($row['sta_id'] == 5){
                        $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-danger disabled">ยกเลิก</a></div>
                        </div>';
                    }
            endforeach;
            $resultText .= '</div>';
            $resultText .= '<div class="row" id="hide-off-small"><div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <h1 class="h3 mb-0 text-gray-800">รายการร้องขอใหม่</h1>
                </div></div></div><div class="row" id="hide-off-small">';
    
            foreach($keyValueArray as $row):
    
                /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                                $stmt2 = $conn->query($sql2);
                                $result = $stmt2->fetch(); */
                                $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and hn = '".$row['hn']."'";
                                $stmt4 = $conn2->query($sql4);
                                $value3 ='';
                                $stack = 0;
                                $dataa ='';
                                foreach($stmt4 as $value2):
                                    $value3 .= $value2['wa_name'].',';
                                    $dataa .= $value2['wa_id'].',';
                                    $stack++;
                                endforeach;
                    
                                $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                                $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
                
                                $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
                                $stmt3 = $conn->query($sql3);
                                $result2 = $stmt3->fetch();
                                if($row['job_priority'] == 'normal'){
                                    $row['job_priority'] = 'ธรรมดา';
                                }
                                else if($row['job_priority'] == 'quick'){
                                    $row['job_priority'] = 'ด่วน';
                                }
                                else if($row['job_priority'] == 'veryquick'){
                                    $row['job_priority'] = 'ด่วนที่สุด';
                                }
                                if($row['sta_id'] == '1'){
                                    $f='info';
                                }
                               else if($row['sta_id'] == '2'){
                                    $f='primary';
                                }
                                else if($row['sta_id'] == '3'){
                                    $f='warning';
                                }
                                else if($row['sta_id'] == '4'){
                                    $f='success';
                
                                }
                                else if($row['sta_id'] == '5'){
                                    $f='danger';
                                }
                                $psql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
                            $qstmt = $conn->prepare($psql);
                            $qstmt->bindParam(':hn', $row['hn']);
                            $qstmt->execute();
                            $qrow = $qstmt->fetch();
                            $resultText .= '
                                <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 font-weight-bold">
                                <div class="row ">
                                    <div class="col-xl-1  mb-3"> 
                                        <div class="col-xl-1 text-dark">
                                            <h5>HN</h5>
                                        </div>
                                        <div class="ms-5">'.$row['hn'].'</div>
                                    <hr class="border border-dark"></div>
                                </div>
                                <div class="row ">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>ชื่อ - สกุลผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$qrow['pname'].$qrow['fname'].' '.$qrow['lname'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                        <div class="row">
                                            <div class="col-xl-1  mb-3"> 
                                                <div class="col-xl-1 text-dark">
                                                    <h5>จุดรับผู้ป่วย</h5>
                                                </div>
                                                <div class="ms-5">'.$row['job_receive'].'</div>
                                            <hr class="border border-dark"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-1  mb-3"> 
                                                <div class="col-xl-1 text-dark">
                                                    <h5>จุดส่งผู้ป่วย</h5>
                                                </div>
                                                <div class="ms-5">'.$row['job_send'].'</div>
                                            <hr class="border border-dark"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-1  mb-3"> 
                                                <div class="col-xl-1 text-dark">
                                                    <h5>เวลาร้องขอ</h5>
                                                </div>
                                                <div class="ms-5">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).' น.</div>
                                            <hr class="border border-dark"></div>
                                        </div>
                                        <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>นัดล่วงหน้า</h5>
                                            </div>';
                                        if($row['job_appointment_date'] !=''){
                                            $resultText .='<div class="ms-5">'.Fulldate($row['job_appointment_date']).'</div>';
                                        }else{
                                            $resultText .='<div class="ms-5">ปกติ</div>';
                                        }                       
                                        $resultText .='<hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                    <div class="col-xl-1  mb-3"> 
                                        <div class="col-xl-1 text-dark">
                                            <h5>อุปกรณ์</h5>
                                        </div>
                                        <div class="ms-5">'.$value4.'</div>
                                    <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>NOTE</h5>
                                                </div>';
                                                if($row['job_note'] !=''){
                                                    $resultText .='<div class="ms-5">'.$row['job_note'].'</div>';
                                                }else{
                                                    $resultText .='<div class="ms-5">ไม่มี</div>';
                                                }                       
                                                $resultText .='<hr class="border border-dark"></div>
                                    </div>
                                        <div class="row">
                                            <div class="col-xl-1  mb-3"> 
                                                <div class="col-xl-1 text-dark">
                                                    <h5>ความเร่งด่วน</h5>
                                                </div>
                                                <div class="ms-5">'.$row['job_priority'].'</div>
                                            <hr class="border border-dark"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-2 mb-3">
                                                <div class="col-xl-1 text-dark">
                                                    <h5>สถานะ</h5>
                                                </div> 
                                                <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                                              <hr class="border border-dark"></div>  
                                        </div>';
                                        if($row['sta_id'] == '1'){
                                            $resultText .= '<div class="row">
                                            <div class="col-xl-1  mb-3">
                                                <div class="col-xl-1 text-dark">
                                                <div class="text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'">รับเคส</a></div></div></div>
                                        </div>';
                                        }
                                        $resultText .=' </div>';
                            endforeach;
                            $resultText .= '</div></div>';
            return $resultText;
        }
    }
    public static function showjobwagon(){
        echo '<link rel="stylesheet" href="../../vendor/view/css/circle.css">';
        $conn2 = DbUtilscart::get_cart_connection();
        $conn = DbUtils::get_hosxp_connection();
        $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and j.sta_id not in ('1','2','3') order by j.sta_id";
        $stmt = $conn2->query($sql);
        $keyValueArray = $stmt->fetchAll();

        $checksql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and j.sta_id not in ('1','2','3') group by hn order by j.sta_id";
        $checkstmt = $conn2->query($checksql);
        if($checkstmt->fetchAll()){
            $resultText = "";
        $i=1;
        $resultText .= '
        <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 hide-on-small">
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <h1 class="h3 mb-0 text-gray-800">รายการร้องขอรับ-ส่งผู้ป่วย</h1>
            </div>                
        <div class="row mb-5">
            <div class="col-xl-1 text-dark">
                <h4>HN</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>จุดรับผู้ป่วย</h4>    
            </div>
            <div class="col-xl-1 text-dark">
                <h4>จุดส่งผู้ป่วย</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>อุปกรณ์</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>Note</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>ความเร่งด่วน</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>สถานะ</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>Action</h4>
            </div>
        </div>';
        foreach($keyValueArray as $row):

/*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
            $stmt2 = $conn->query($sql2);
            $result = $stmt2->fetch(); */
            $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and jd.job_id = '".$row['job_id']."'";
            $stmt4 = $conn2->query($sql4);
            $value3 ='';
            $stack = 0;
            $dataa ='';
            foreach($stmt4 as $value2):
                $value3 .= $value2['wa_name'].',';
                $dataa .= $value2['wa_id'].',';
                $stack++;
            endforeach;

            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );

            $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
            $stmt3 = $conn->query($sql3);
            $result2 = $stmt3->fetch();
            if($row['job_priority'] == 'normal'){
                $row['job_priority'] = 'ธรรมดา';
            }
            else if($row['job_priority'] == 'quick'){
                $row['job_priority'] = 'ด่วน';
            }
            else if($row['job_priority'] == 'veryquick'){
                $row['job_priority'] = 'ด่วนที่สุด';
            }
            if($row['sta_id'] == '1'){
                $f='info';
            }
           else if($row['sta_id'] == '2'){
                $f='primary';
            }
            else if($row['sta_id'] == '3'){
                $f='warning';
            }
            else if($row['sta_id'] == '4'){
                $f='success';

            }
            else if($row['sta_id'] == '5'){
                $f='danger';
            }
            $resultText .= '

            <div class="row hide-on-small">
                <div class="col-xl-1 mb-3">'.$row['hn'].'</div>
                <div class="col-xl-1 mb-3">'.$row['job_receive'].'</div>
                <div class="col-xl-1 mb-3">'.$row['job_send'].'</div>
                <div class="col-xl-2 mb-3">'.$value4.'</div>
                <div class="col-xl-2 mb-3">'.$row['job_note'].'</div>
                <div class="col-xl-2 mb-3">'.$row['job_priority'].'</div>
                <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>';
                if($row['sta_id'] == 1){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 2){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">รับผู้ป่วย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 3){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">ส่งผู้ป่วย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 4){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">ส่งเรียบร้อย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 5){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-danger disabled">ยกเลิก</a></div>
                    </div>';
                }
        endforeach;
        $resultText .= '</div>';
        $resultText .= '<div class="row" id="hide-off-small"><div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
        <div class="d-sm-flex align-items-center justify-content-between mb-5">
            <h1 class="h3 mb-0 text-gray-800">รายการร้องขอรับ-ส่งผู้ป่วย</h1>
            </div></div></div><div class="row" id="hide-off-small">';

        foreach($keyValueArray as $row):

            /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                            $stmt2 = $conn->query($sql2);
                            $result = $stmt2->fetch(); */
                            $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and hn = '".$row['hn']."'";
                            $stmt4 = $conn2->query($sql4);
                            $value3 ='';
                            $stack = 0;
                            $dataa ='';
                            foreach($stmt4 as $value2):
                                $value3 .= $value2['wa_name'].',';
                                $dataa .= $value2['wa_id'].',';
                                $stack++;
                            endforeach;
                
                            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
            
                            $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
                            $stmt3 = $conn->query($sql3);
                            $result2 = $stmt3->fetch();
                            if($row['job_priority'] == 'normal'){
                                $row['job_priority'] = 'ธรรมดา';
                            }
                            else if($row['job_priority'] == 'quick'){
                                $row['job_priority'] = 'ด่วน';
                            }
                            else if($row['job_priority'] == 'veryquick'){
                                $row['job_priority'] = 'ด่วนที่สุด';
                            }
                            if($row['sta_id'] == '1'){
                                $f='info';
                            }
                           else if($row['sta_id'] == '2'){
                                $f='primary';
                            }
                            else if($row['sta_id'] == '3'){
                                $f='warning';
                            }
                            else if($row['sta_id'] == '4'){
                                $f='success';
            
                            }
                            else if($row['sta_id'] == '5'){
                                $f='danger';
                            }
                            $resultText .= '
                                <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 font-weight-bold">
                                    <div class="row ">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>HN</h5>
                                            </div>
                                            <div class="ms-5">'.$row['hn'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>จุดรับผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_receive'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>จุดส่งผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_send'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>อุปกรณ์</h5>
                                            </div>
                                            <div class="ms-5">'.$value4.'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>Note</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_note'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>ความเร่งด่วน</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_priority'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 mb-3">
                                            <div class="col-xl-1 text-dark">
                                                <h5>สถานะ</h5>
                                            </div> 
                                            <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                                          <hr class="border border-dark"></div>  
                                    </div>';
                                    if($row['sta_id'] == '1'){
                                        $resultText .= '<div class="row">
                                        <div class="col-xl-1  mb-3">
                                            <div class="col-xl-1 text-dark">
                                            <div class="text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'">รับเคส</a></div></div></div>
                                    </div>';
                                    }
                                    $resultText .=' </div>';
                        endforeach;
                        $resultText .= '</div>';
                        return $resultText;
        }
        
    }
    public static function showprogressjob(){
        echo '<link rel="stylesheet" href="../../vendor/view/css/circle.css">';
        $conn2 = DbUtilscart::get_cart_connection();
        $conn = DbUtils::get_hosxp_connection();
        $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and a.job_id=j.job_id and a.u_id = '".$_SESSION['loginname']."' and j.sta_id in ('2','3','4') group by j.job_id order by j.sta_id ASC";
        $stmt = $conn2->query($sql);
        $keyValueArray = $stmt->fetchAll();

        $checksql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and a.job_id=j.job_id and a.u_id = '".$_SESSION['loginname']."' and j.sta_id in ('2','3','4') group by j.job_id";
        $checkstmt = $conn2->query($checksql);
        if($checkstmt->fetchAll()){
            $resultText = "";
        $i=1;
        $resultText .= '
        <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 hide-on-small">
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <h1 class="h3 mb-0 text-gray-800">รายการที่กำลังดำเนินการ</h1>
            </div>                
        <div class="row mb-5">
            <div class="col-xl-1 text-dark">
                <h4>HN</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>จุดรับผู้ป่วย</h4>    
            </div>
            <div class="col-xl-1 text-dark">
                <h4>จุดส่งผู้ป่วย</h4>
            </div>
            <div class="col-xl-3 text-dark">
                <h4>อุปกรณ์</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>Note</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>เวลา</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>ความเร่งด่วน</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>สถานะ</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>Action</h4>
            </div>
        </div>';
        foreach($keyValueArray as $row):

/*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
            $stmt2 = $conn->query($sql2);
            $result = $stmt2->fetch(); */
            $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and jd.job_id = '".$row['job_id']."'";
            $stmt4 = $conn2->query($sql4);
            $value3 ='';
            $stack = 0;
            $dataa ='';
            foreach($stmt4 as $value2):
                $value3 .= $value2['wa_name'].',';
                $dataa .= $value2['wa_id'].',';
                $stack++;
            endforeach;

            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );

            if($row['job_priority'] == 'normal'){
                $row['job_priority'] = 'ธรรมดา';
            }
            else if($row['job_priority'] == 'quick'){
                $row['job_priority'] = 'ด่วน';
            }
            else if($row['job_priority'] == 'veryquick'){
                $row['job_priority'] = 'ด่วนที่สุด';
            }
            if($row['sta_id'] == '1'){
                $f='info';
            }
           else if($row['sta_id'] == '2'){
                $f='primary';
            }
            else if($row['sta_id'] == '3'){
                $f='warning';
            }
            else if($row['sta_id'] == '4'){
                $f='success';

            }
            else if($row['sta_id'] == '5'){
                $f='danger';
            }
            $resultText .= '

            <div class="row hide-on-small">
                <div class="col-xl-1  mb-3">'.$row['hn'].'</div>
                <div class="col-xl-1  mb-3">'.$row['job_receive'].'</div>
                <div class="col-xl-1  mb-3">'.$row['job_send'].'</div>
                <div class="col-xl-3  mb-3">'.$value4.'</div>
                <div class="col-xl-1  mb-3">'.$row['job_note'].'</div>
                <div class="col-xl-1  mb-3">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).'น</div>
                <div class="col-xl-1  mb-3">'.$row['job_priority'].'</div>
                <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>';
                if($row['sta_id'] == 1){
                    $resultText .= '<div class="col-xl-1  mb-3"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 2){
                    $resultText .= '<div class="col-xl-1  mb-3"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever4="'.$row['job_id'].'" data-bs-whatever5="'.$row['hn'].'" data-bs-whatever6="'.$data.'">รับผู้ป่วย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 3){
                    $resultText .= '<div class="col-xl-1  mb-3"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal17" data-bs-whatever7="'.$row['job_id'].'" data-bs-whatever8="'.$row['hn'].'" data-bs-whatever9="'.$data.'">ส่งผู้ป่วย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 4){
                    $resultText .= '<div class="col-xl-1  mb-3"><a class="btn btn-success disabled">รอยืนยัน</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 5){
                    echo '';
                }
        endforeach;
        $resultText .= '</div>';
        $resultText .= '<div class="row" id="hide-off-small"><div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
        <div class="d-sm-flex align-items-center justify-content-between mb-5">
            <h1 class="h3 mb-0 text-gray-800">รายการที่กำลังดำเนินการ</h1>
            </div></div></div><div class="row" id="hide-off-small">';

        foreach($keyValueArray as $row):

            /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                            $stmt2 = $conn->query($sql2);
                            $result = $stmt2->fetch(); */
                            $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and jd.job_id = '".$row['job_id']."'";
                            $stmt4 = $conn2->query($sql4);
                            $value3 ='';
                            $stack = 0;
                            $dataa ='';
                            foreach($stmt4 as $value2):
                                $value3 .= $value2['wa_name'].',';
                                $dataa .= $value2['wa_id'].',';
                                $stack++;
                            endforeach;
                
                            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
            
                            $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
                            $stmt3 = $conn->query($sql3);
                            $result2 = $stmt3->fetch();
                            if($row['job_priority'] == 'normal'){
                                $row['job_priority'] = 'ธรรมดา';
                            }
                            else if($row['job_priority'] == 'quick'){
                                $row['job_priority'] = 'ด่วน';
                            }
                            else if($row['job_priority'] == 'veryquick'){
                                $row['job_priority'] = 'ด่วนที่สุด';
                            }
                            if($row['sta_id'] == '1'){
                                $f='info';
                            }
                           else if($row['sta_id'] == '2'){
                                $f='primary';
                            }
                            else if($row['sta_id'] == '3'){
                                $f='warning';
                            }
                            else if($row['sta_id'] == '4'){
                                $f='success';
            
                            }
                            else if($row['sta_id'] == '5'){
                                $f='danger';
                            }
                            $psql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
                            $qstmt = $conn->prepare($psql);
                            $qstmt->bindParam(':hn', $row['hn']);
                            $qstmt->execute();
                            $qrow = $qstmt->fetch();
                            $resultText .= '
                                <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 font-weight-bold">
                                <div class="row ">
                                    <div class="col-xl-1  mb-3"> 
                                        <div class="col-xl-1 text-dark">
                                            <h5>HN</h5>
                                        </div>
                                        <div class="ms-5">'.$row['hn'].'</div>
                                    <hr class="border border-dark"></div>
                                </div>
                                <div class="row ">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>ชื่อ - สกุลผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$qrow['pname'].$qrow['fname'].' '.$qrow['lname'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>จุดรับผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_receive'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>จุดส่งผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_send'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>เวลาร้องขอ</h5>
                                            </div>
                                            <div class="ms-5">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).' น.</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>นัดล่วงหน้า</h5>
                                            </div>';
                                        if($row['job_appointment_date'] !=''){
                                            $resultText .='<div class="ms-5">'.Fulldate($row['job_appointment_date']).'</div>';
                                        }else{
                                            $resultText .='<div class="ms-5">ปกติ</div>';
                                        }                       
                                        $resultText .='<hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                    <div class="col-xl-1  mb-3"> 
                                        <div class="col-xl-1 text-dark">
                                            <h5>อุปกรณ์</h5>
                                        </div>
                                        <div class="ms-5">'.$value4.'</div>
                                    <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>NOTE</h5>
                                                </div>';
                                                if($row['job_note'] !=''){
                                                    $resultText .='<div class="ms-5">'.$row['job_note'].'</div>';
                                                }else{
                                                    $resultText .='<div class="ms-5">ไม่มี</div>';
                                                }                       
                                                $resultText .='<hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>ความเร่งด่วน</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_priority'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 mb-3">
                                            <div class="col-xl-1 text-dark">
                                                <h5>สถานะ</h5>
                                            </div> 
                                            <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                                          <hr class="border border-dark"></div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3">
                                            <div class="col-xl-1 text-dark">';
                                            if($row['sta_id'] == 1){
                                                $resultText .= '<div class="text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>';
                                            }
                                            else if($row['sta_id'] == 2){
                                                $resultText .= '<div class="text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever4="'.$row['job_id'].'" data-bs-whatever5="'.$row['hn'].'" data-bs-whatever6="'.$data.'">รับผู้ป่วย</a></div>';
                                            }
                                            else if($row['sta_id'] == 3){
                                                $resultText .= '<div class="text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal17" data-bs-whatever7="'.$row['job_id'].'" data-bs-whatever8="'.$row['hn'].'" data-bs-whatever9="'.$data.'">ส่งผู้ป่วย</a></div>';
                                            }
                                            else if($row['sta_id'] == 4){
                                                $resultText .= '<div class="text-center"><a class="btn btn-success w-50 disabled">รอยืนยัน</a></div>';
                                            }
                                            else if($row['sta_id'] == 5){
                                                echo '';
                                            }
                                       $resultText .= '</div></div>
                                    </div>
                                </div>';
                        endforeach;
                        $resultText .= '</div>';
        return $resultText;
        }
    }
    public static function countsuccess($id){

        $values =[
			':id'=>$id
		];
        $conn2 = DbUtilscart::get_cart_connection();
        $countsql = "select COUNT(ac_st_id)as 'count' from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept where ac_st_id = '1' and accept.u_id = :id";
        $countstmt = $conn2->prepare($countsql);
        $countstmt->execute($values);
        $result = $countstmt->fetch();

        $resultText = $result['count'];

        return $resultText;

    }
    public static function countfail($id){

        $values =[
			':id'=>$id
		];
        $conn2 = DbUtilscart::get_cart_connection();
        $countsql = "select COUNT(ac_st_id)as 'count' from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept where ac_st_id = '2' and accept.u_id = :id";
        $countstmt = $conn2->prepare($countsql);
        $countstmt->execute($values);
        $result = $countstmt->fetch();

        $resultText = $result['count'];

        return $resultText;

    }
    public static function tableprofile(){
        $conn2 = DbUtilscart::get_cart_connection();

        $values =[
			':id'=>$_SESSION['loginname']
		];

        $sql ="select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a where j.job_id=a.job_id and a.u_id = :id";
        $stmt = $conn2->prepare($sql);
        $stmt->execute($values);
        $resultText = '';
        $resultText .= '
        <div class="table-responsive">
            <table class="table table-bordered" id="display" width="100%" cellspacing="0">
            <thead>
        <tr>
        <th>จุดรับ</th>
        <th>จุดส่ง</th>
        <th>วัน - เวลา</th>
        </tr></thead><tbody>';
        foreach($stmt as $row):
/*             if($row['ac_st_id'] == 1){
                $st = 'สำเร็จ';
            }else if($row['ac_st_id'] == 2){
                $st = 'ยกเลิก';
            }else{
                $st = 'กำลังดำเนินการ';
            } */
            $resultText .= '<tr>';
            $resultText .= '<td>'.$row['job_receive'].'</td>';
            $resultText .= '<td>'.$row['job_send'].'</td>';
            $resultText .= '<td>'.DateThai($row['date']).' '.TimeThai($row['accept_time']).'</td>';
            $resultText .= '</tr>';
        endforeach;
        $resultText .='
        <tbody></table></div>';


        return $resultText;

    }
    public static function showjobwagon2(){
        echo '<link rel="stylesheet" href="../../vendor/view/css/circle.css">';
        $conn2 = DbUtilscart::get_cart_connection();
        $conn = DbUtils::get_hosxp_connection();
        $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and j.sta_id not in ('1','2','3') order by j.sta_id";
        $stmt = $conn2->query($sql);
        $keyValueArray = $stmt->fetchAll();

        $checksql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and j.sta_id not in ('1','2','3') group by hn order by j.sta_id";
        $checkstmt = $conn2->query($checksql);
        if($checkstmt->fetchAll()){
            $resultText = "";
        $i=1;
        $resultText .= '
        <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 hide-on-small">
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <h1 class="h3 mb-0 text-gray-800">รายการร้องขอรับ-ส่งผู้ป่วย</h1>
            </div>                
        <div class="row mb-5">
            <div class="col-xl-1 text-dark">
                <h4>HN</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>จุดรับผู้ป่วย</h4>    
            </div>
            <div class="col-xl-1 text-dark">
                <h4>จุดส่งผู้ป่วย</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>อุปกรณ์</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>Note</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>ความเร่งด่วน</h4>
            </div>
            <div class="col-xl-2 text-dark">
                <h4>สถานะ</h4>
            </div>
            <div class="col-xl-1 text-dark">
                <h4>Action</h4>
            </div>
        </div>';
        foreach($keyValueArray as $row):

/*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
            $stmt2 = $conn->query($sql2);
            $result = $stmt2->fetch(); */
            $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and jd.job_id = '".$row['job_id']."'";
            $stmt4 = $conn2->query($sql4);
            $value3 ='';
            $stack = 0;
            $dataa ='';
            foreach($stmt4 as $value2):
                $value3 .= $value2['wa_name'].',';
                $dataa .= $value2['wa_id'].',';
                $stack++;
            endforeach;

            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );

            $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
            $stmt3 = $conn->query($sql3);
            $result2 = $stmt3->fetch();
            if($row['job_priority'] == 'normal'){
                $row['job_priority'] = 'ธรรมดา';
            }
            else if($row['job_priority'] == 'quick'){
                $row['job_priority'] = 'ด่วน';
            }
            else if($row['job_priority'] == 'veryquick'){
                $row['job_priority'] = 'ด่วนที่สุด';
            }
            if($row['sta_id'] == '1'){
                $f='info';
            }
           else if($row['sta_id'] == '2'){
                $f='primary';
            }
            else if($row['sta_id'] == '3'){
                $f='warning';
            }
            else if($row['sta_id'] == '4'){
                $f='success';

            }
            else if($row['sta_id'] == '5'){
                $f='danger';
            }
            $resultText .= '

            <div class="row hide-on-small">
                <div class="col-xl-1 mb-3">'.$row['hn'].'</div>
                <div class="col-xl-1 mb-3">'.$row['job_receive'].'</div>
                <div class="col-xl-1 mb-3">'.$row['job_send'].'</div>
                <div class="col-xl-2 mb-3">'.$value4.'</div>
                <div class="col-xl-2 mb-3">'.$row['job_note'].'</div>
                <div class="col-xl-2 mb-3">'.$row['job_priority'].'</div>
                <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>';
                if($row['sta_id'] == 1){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 2){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">รับผู้ป่วย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 3){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">ส่งผู้ป่วย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 4){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-success disabled">ส่งเรียบร้อย</a></div>
                    </div>';
                }
                else if($row['sta_id'] == 5){
                    $resultText .= '<div class="col-xl-1 mb-3"><a class="btn btn-danger disabled">ยกเลิก</a></div>
                    </div>';
                }
        endforeach;
        $resultText .= '</div>';
        $resultText .= '<div class="row" id="hide-off-small"><div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
        <div class="d-sm-flex align-items-center justify-content-between mb-5">
            <h1 class="h3 mb-0 text-gray-800">รายการร้องขอรับ-ส่งผู้ป่วย</h1>
            </div></div></div><div class="row" id="hide-off-small">';

        foreach($keyValueArray as $row):

            /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                            $stmt2 = $conn->query($sql2);
                            $result = $stmt2->fetch(); */
                            $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon where job.job_id=jd.job_id and jd.wa_id=wagon.wa_id and hn = '".$row['hn']."'";
                            $stmt4 = $conn2->query($sql4);
                            $value3 ='';
                            $stack = 0;
                            $dataa ='';
                            foreach($stmt4 as $value2):
                                $value3 .= $value2['wa_name'].',';
                                $dataa .= $value2['wa_id'].',';
                                $stack++;
                            endforeach;
                
                            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
                            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
            
                            $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$row['job_send']."'";
                            $stmt3 = $conn->query($sql3);
                            $result2 = $stmt3->fetch();
                            if($row['job_priority'] == 'normal'){
                                $row['job_priority'] = 'ธรรมดา';
                            }
                            else if($row['job_priority'] == 'quick'){
                                $row['job_priority'] = 'ด่วน';
                            }
                            else if($row['job_priority'] == 'veryquick'){
                                $row['job_priority'] = 'ด่วนที่สุด';
                            }
                            if($row['sta_id'] == '1'){
                                $f='info';
                            }
                           else if($row['sta_id'] == '2'){
                                $f='primary';
                            }
                            else if($row['sta_id'] == '3'){
                                $f='warning';
                            }
                            else if($row['sta_id'] == '4'){
                                $f='success';
            
                            }
                            else if($row['sta_id'] == '5'){
                                $f='danger';
                            }
                            $resultText .= '
                                <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 font-weight-bold">
                                    <div class="row ">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>HN</h5>
                                            </div>
                                            <div class="ms-5">'.$row['hn'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>จุดรับผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_receive'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>จุดส่งผู้ป่วย</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_send'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>อุปกรณ์</h5>
                                            </div>
                                            <div class="ms-5">'.$value4.'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>Note</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_note'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-1  mb-3"> 
                                            <div class="col-xl-1 text-dark">
                                                <h5>ความเร่งด่วน</h5>
                                            </div>
                                            <div class="ms-5">'.$row['job_priority'].'</div>
                                        <hr class="border border-dark"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 mb-3">
                                            <div class="col-xl-1 text-dark">
                                                <h5>สถานะ</h5>
                                            </div> 
                                            <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                                          <hr class="border border-dark"></div>  
                                    </div>';
                                    if($row['sta_id'] == '1'){
                                        $resultText .= '<div class="row">
                                        <div class="col-xl-1  mb-3">
                                            <div class="col-xl-1 text-dark">
                                            <div class="text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'">รับเคส</a></div></div></div>
                                    </div>';
                                    }
                                    $resultText .=' </div>';
                        endforeach;
                        $resultText .= '</div>';
                        return $resultText;
        }
        
    }
    public static function alert_request($id){
        $resultText ='';
        $conn = DbUtils::get_hosxp_connection();
        $decode = base64_decode($id);
        $conn2 = DbUtilscart::get_cart_connection();
        $sql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id WHERE job.job_id = :id";
        $stmt = $conn2->prepare($sql);
        $stmt->bindParam(':id',$decode);
        $stmt->execute();
        $row = $stmt->fetch();

        $psql = "SELECT CONCAT(`pname`,`fname`, ' ',`lname`) AS fullname FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient WHERE hn = :hn";
        $qstmt = $conn->prepare($psql);
        $qstmt->bindParam(':hn', $row['hn']);
        $qstmt->execute();
        $qrow = $qstmt->fetch();


        $sql4 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w ON jd.wa_id = w.wa_id WHERE jd.job_id = :job_id";
        $stmt4 = $conn2->prepare($sql4);
        $stmt4->bindParam(':job_id',$row['job_id']);
        $stmt4->execute();
        $value3 ='';
        $stack = 0;
        $dataa ='';
        foreach($stmt4 as $value2):
            $value3 .= $value2['wa_name'].',';
            $dataa .= $value2['wa_id'].',';
            $stack++;
        endforeach;

        $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
        $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
        
        $resultText .='<div class="card mb-5">
        <div class="card-header">
          รายการร้องขอเคลื่อนย้ายผู้ป่วย
        </div>
        <div class="card-body">
          <h5 class="card-title">HN</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$row['hn'].'</p>
          </div>
          <hr>
          <h5 class="card-title">ชื่อ - สกุล</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$qrow['fullname'].'</p>
          </div>
          <hr>
          <h5 class="card-title">จุดรับผู้ป่วย</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$row['job_receive'].'</p>
          </div>
          <hr>
          <h5 class="card-title">จุดส่งผู้ป่วย</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$row['job_send'].'</p>
          </div>
          <hr>
          <h5 class="card-title">เวลาร้องขอ</h5>
          <div class="col-xl-12">
            <p class="card-text">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).' น.</p>
          </div>
          <hr>
          <h5 class="card-title">นัดล่วงหน้า</h5>
          <div class="col-xl-12">';
          if($row['job_appointment_date']!=''){
            $resultText .='<p class="card-text">'.Fulldate($row['job_appointment_date']).'</p>';
          }else{
            $resultText .='<p class="card-text">ปกติ</p>';
          }
            
$resultText .='</div>
          <hr>
          <h5 class="card-title">อุปกรณ์</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$value4.'</p>
          </div>
          <hr>
          <h5 class="card-title">NOTE</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$row['job_note'].'</p>
          </div>
          <hr>
          <h5 class="card-title">ความเร่งด่วน</h5>
          <div class="col-xl-12">
            <p class="card-text">'.$row['job_priority'].'</p>
          </div>
          <hr>
          <h5 class="card-title">สถานะ</h5>
          <div class="col-xl-12">
            <span class="badge badge-success" style="font-size: 16px;">'.$row['sta_name'].'</span>
          </div>
          <hr>
          <div class="col-xl-12 text-center">
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a>
          </div>
        </div>
      </div>';
        return $resultText;
    }
    public static function request_job(){
        echo '<style>.boxxy{width: 60px !important;}.circle {
            width: 35px;
            height: 35px;
            background-color: #28a745; /* Bootstrap primary color */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 5px;
            font-weight: bold;
            position: relative;
            z-index: 2;
          }
      
          .line {
            border: 1px solid #28a745; /* Bootstrap primary color */
            flex: 1;
            margin-top: 20px;
            margin-bottom: 20px;
          }

          </style>';
        $resultText ='';
        $status = '1';
        $x=1;
        $head = "heading";
        $conn = DbUtils::get_hosxp_connection();
        $conn2 = DbUtilscart::get_cart_connection();
        $sql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id WHERE job.sta_id = :id";
        $stmt = $conn2->prepare($sql);
        $stmt->bindParam(':id',$status);
        $stmt->execute();
        $resultText .='<div class="accordion" id="accordionExample">';
        foreach($stmt as $row):
            $int = strval($x);
            $header = $head.$int;
    
            $psql = "SELECT CONCAT(`pname`,`fname`, ' ',`lname`) AS fullname FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient WHERE hn = :hn";
            $qstmt = $conn->prepare($psql);
            $qstmt->bindParam(':hn', $row['hn']);
            $qstmt->execute();
            $qrow = $qstmt->fetch();
    
    
            $sql4 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w ON jd.wa_id = w.wa_id WHERE jd.job_id = :job_id";
            $stmt4 = $conn2->prepare($sql4);
            $stmt4->bindParam(':job_id',$row['job_id']);
            $stmt4->execute();
            $value3 ='';
            $stack = 0;
            $dataa ='';
            foreach($stmt4 as $value2):
                $value3 .= $value2['wa_name'].',';
                $dataa .= $value2['wa_id'].',';
                $stack++;
            endforeach;
    
            $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
            $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
            
            if($row['sta_id']=='1'){
                $badge =  'badge-success';
            }
            else if($row['sta_id']=='3'){
                $badge = 'badge-primary';
            }
            else if($row['sta_id']=='4'){
                $badge = 'badge-info';
            }
    
            $word_to_find = "opd";
            if (stristr($row['receive_ipd'], $word_to_find)) {
                 $word = "OPD";
            } else {
                 $word = "IPD";
            }       
            
            $word_to_find2 = "opd";
            if (stristr($row['send_ipd'], $word_to_find2)) {
                 $word2 = "OPD";
            } else {
                 $word2 = "IPD";
            }
            $resultText .='
                <div class="card mb-3">
                    <div class="card-header bg-white p-3" id="'.$header.'">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#job'.$row['job_id'].'" aria-expanded="true" aria-controls="job'.$row['job_id'].'">
                        <div class="boxxyy"><span class="boxxy badge badge-danger float-right w-50">'.$row['job_priority'].'</span></div><br>               
                        <div class="row justify-content-center mx-auto w-50">
                                <div class="circle">'.$word.'</div>
                                <div class="line"></div>
                                <div class="circle">'.$word2.'</div>
                        </div>
                        HN:'.$row['hn'].'<span class="badge '.$badge.' float-right">'.$row['sta_name'].'</span>
                        </button>
                    </h2>
                    </div>
            <div id="job'.$row['job_id'].'" class="collapse" aria-labelledby="'.$header.'" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="card mb-5">
                    <div class="card-header">
                    รายการร้องขอเคลื่อนย้ายผู้ป่วย
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">HN</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$row['hn'].'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">ชื่อ - สกุล</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$qrow['fullname'].'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">จุดรับผู้ป่วย</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$row['job_receive'].'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">จุดส่งผู้ป่วย</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$row['job_send'].'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">เวลาร้องขอ</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).' น.</p>
                    </div>
                    <hr>
                    <h5 class="card-title">นัดล่วงหน้า</h5>
                    <div class="col-xl-12">';
                    if($row['job_appointment_date']!=''){
                        $resultText .='<p class="card-text">'.Fulldate($row['job_appointment_date']).'</p>';
                    }else{
                        $resultText .='<p class="card-text">ปกติ</p>';
                    }
                        
            $resultText .='</div>
                    <hr>
                    <h5 class="card-title">อุปกรณ์</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$value4.'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">NOTE</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$row['job_note'].'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">ความเร่งด่วน</h5>
                    <div class="col-xl-12">
                        <p class="card-text">'.$row['job_priority'].'</p>
                    </div>
                    <hr>
                    <h5 class="card-title">สถานะ</h5>
                    <div class="col-xl-12">
                        <span class="badge badge-success" style="font-size: 16px;">'.$row['sta_name'].'</span>
                    </div>
                    <hr>';
                    if($row['sta_id'] == 1){
                        $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>';
                    }
                    else if($row['sta_id'] == 2){
                        $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever4="'.$row['job_id'].'" data-bs-whatever5="'.$row['hn'].'" data-bs-whatever6="'.$data.'">รับผู้ป่วย</a></div>';
                    }
                    else if($row['sta_id'] == 3){
                        $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal17" data-bs-whatever7="'.$row['job_id'].'" data-bs-whatever8="'.$row['hn'].'" data-bs-whatever9="'.$data.'">ส่งผู้ป่วย</a></div>';
                    }
                    else if($row['sta_id'] == 4){
                        $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50 disabled">รอยืนยัน</a></div>';
                    }
                    else if($row['sta_id'] == 5){
                        echo '';
                    }
                $resultText .='</div>
                </div></div>
                </div>
              </div>';
            $x++;
        endforeach;
        $resultText .='</div>';
        return $resultText;
    }
    public static function process_job(){
        echo '<style>.boxxy{width: 60px !important;}.circle {
            width: 35px;
            height: 35px;
            background-color: #28a745; /* Bootstrap primary color */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 5px;
            font-weight: bold;
            position: relative;
            z-index: 2;
          }
      
          .line {
            border: 1px solid #28a745; /* Bootstrap primary color */
            flex: 1;
            margin-top: 20px;
            margin-bottom: 20px;
          }

          </style>';
        $resultText ='';
     /*    var_dump($_SESSION); */
        $x=1;
        $head = "heading";
        $conn = DbUtils::get_hosxp_connection();
        $conn2 = DbUtilscart::get_cart_connection();
        $sql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status ON job.sta_id = status.sta_id JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept ON job.job_id = accept.job_id WHERE job.sta_id in ('2','3','4') and accept.u_id = :id order by job.sta_id ASC";
        $stmt = $conn2->prepare($sql);
        $stmt->bindParam(':id',$_SESSION['loginname']);
        $stmt->execute();
        $resultText .='<div class="accordion" id="accordionExample">';
        foreach($stmt as $row):
        $int = strval($x);
        $header = $head.$int;

        $psql = "SELECT CONCAT(`pname`,`fname`, ' ',`lname`) AS fullname FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient WHERE hn = :hn";
        $qstmt = $conn->prepare($psql);
        $qstmt->bindParam(':hn', $row['hn']);
        $qstmt->execute();
        $qrow = $qstmt->fetch();


        $sql4 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w ON jd.wa_id = w.wa_id WHERE jd.job_id = :job_id";
        $stmt4 = $conn2->prepare($sql4);
        $stmt4->bindParam(':job_id',$row['job_id']);
        $stmt4->execute();
        $value3 ='';
        $stack = 0;
        $dataa ='';
        foreach($stmt4 as $value2):
            $value3 .= $value2['wa_name'].',';
            $dataa .= $value2['wa_id'].',';
            $stack++;
        endforeach;

        $value4 = substr( $value3, 0, strlen( $value3 ) - 1 );
        $data = substr( $dataa, 0, strlen( $dataa ) - 1 );
        
        if($row['sta_id']=='2'){
            $badge =  'badge-secondary';
        }
        else if($row['sta_id']=='3'){
            $badge = 'badge-primary';
        }
        else if($row['sta_id']=='4'){
            $badge = 'badge-info';
        }

        $word_to_find = "opd";
        if (stristr($row['receive_ipd'], $word_to_find)) {
             $word = "OPD";
        } else {
             $word = "IPD";
        }       
        
        $word_to_find2 = "opd";
        if (stristr($row['send_ipd'], $word_to_find2)) {
             $word2 = "OPD";
        } else {
             $word2 = "IPD";
        }
        $resultText .='
            <div class="card mb-3">
                <div class="card-header bg-white p-3" id="'.$header.'">
                <h2 class="mb-0">
                    <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#job'.$row['job_id'].'" aria-expanded="true" aria-controls="job'.$row['job_id'].'">
                    <div class="boxxyy"><span class="boxxy badge badge-danger float-right w-50">'.$row['job_priority'].'</span></div><br>               
                    <div class="row justify-content-center mx-auto w-50">
                            <div class="circle">'.$word.'</div>
                            <div class="line"></div>
                            <div class="circle">'.$word2.'</div>
                    </div>
                    HN:'.$row['hn'].'<span class="badge '.$badge.' float-right">'.$row['sta_name'].'</span>
                    </button>
                </h2>
                </div>
        <div id="job'.$row['job_id'].'" class="collapse" aria-labelledby="'.$header.'" data-parent="#accordionExample">
            <div class="card-body">
                <div class="card mb-5">
                <div class="card-header">
                รายการร้องขอเคลื่อนย้ายผู้ป่วย
                </div>
                <div class="card-body">
                <h5 class="card-title">HN</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$row['hn'].'</p>
                </div>
                <hr>
                <h5 class="card-title">ชื่อ - สกุล</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$qrow['fullname'].'</p>
                </div>
                <hr>
                <h5 class="card-title">จุดรับผู้ป่วย</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$row['job_receive'].'</p>
                </div>
                <hr>
                <h5 class="card-title">จุดส่งผู้ป่วย</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$row['job_send'].'</p>
                </div>
                <hr>
                <h5 class="card-title">เวลาร้องขอ</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).' น.</p>
                </div>
                <hr>
                <h5 class="card-title">นัดล่วงหน้า</h5>
                <div class="col-xl-12">';
                if($row['job_appointment_date']!=''){
                    $resultText .='<p class="card-text">'.Fulldate($row['job_appointment_date']).'</p>';
                }else{
                    $resultText .='<p class="card-text">ปกติ</p>';
                }
                    
        $resultText .='</div>
                <hr>
                <h5 class="card-title">อุปกรณ์</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$value4.'</p>
                </div>
                <hr>
                <h5 class="card-title">NOTE</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$row['job_note'].'</p>
                </div>
                <hr>
                <h5 class="card-title">ความเร่งด่วน</h5>
                <div class="col-xl-12">
                    <p class="card-text">'.$row['job_priority'].'</p>
                </div>
                <hr>
                <h5 class="card-title">สถานะ</h5>
                <div class="col-xl-12">
                    <span class="badge badge-success" style="font-size: 16px;">'.$row['sta_name'].'</span>
                </div>
                <hr>';
                if($row['sta_id'] == 1){
                    $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">รับเคส</a></div>';
                }
                else if($row['sta_id'] == 2){
                    $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal16" data-bs-whatever4="'.$row['job_id'].'" data-bs-whatever5="'.$row['hn'].'" data-bs-whatever6="'.$data.'">รับผู้ป่วย</a></div>';
                }
                else if($row['sta_id'] == 3){
                    $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#exampleModal17" data-bs-whatever7="'.$row['job_id'].'" data-bs-whatever8="'.$row['hn'].'" data-bs-whatever9="'.$data.'">ส่งผู้ป่วย</a></div>';
                }
                else if($row['sta_id'] == 4){
                    $resultText .= '<div class="col-xl-12 text-center"><a class="btn btn-success w-50 disabled">รอยืนยัน</a></div>';
                }
                else if($row['sta_id'] == 5){
                    echo '';
                }
            $resultText .='</div>
            </div></div>
            </div>
          </div>';
        $x++;
        endforeach;
        $resultText .='</div>';
        return $resultText;
    }
}
?>
      