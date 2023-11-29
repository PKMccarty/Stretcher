<?php

error_reporting(0);

    require_once 'datethai.php';
    require_once 'DbUtils.php';
    require_once 'DbUtilscart.php';
    class SelectUtils {
        public static function getSelectOption($sql, $conn, $selectedValue){
            $stmt = $conn->query($sql);
            $keyValueArray = $stmt->fetchAll();
            return SelectUtils::getSelectOptionFromArray($keyValueArray, $selectedValue);
        }
        public static function getShowwardipd($conn){
             $conn2 = DbUtilscart::get_cart_connection(); 
            $result = '';

            $sql = "select ward,name from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward in (".connectConstant::LIST_WARD.")";
            $stmt = $conn->query($sql);

             $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".kskdepartment where department_id in (".connectConstant::LIST_DEPARTMENT.")";
            $stmt2 = $conn2->query($sql2); 

            $result .='<option value="">---- กรุณาเลือก ----</option>';

             foreach($stmt as $row): 
                $result .='<option value="'.$row['ward'].'">'.$row['name'].'</option>';
             endforeach; 

              foreach($stmt2 as $row2):
                $result .='<option value="'.$row2['department_check'].'">'.$row2['department_name'].'</option>';
            endforeach; 
           
            return $result;
        }
        public static function getShowwardopd($conn){
            
            $result = '';
            $sql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".kskdepartment";
            $stmt = $conn->query($sql);
            $result .='<option value="">---- กรุณาเลือก ----</option>';
            foreach($stmt as $row):
                $newStr = substr($row['department'], 4);
                $result .='<option value="'.$row['depcode'].'">'.$newStr.'</option>';
            endforeach;
           
            return $result;
        }
        public static function getSelectOptionFromArray($keyValueArray, $selectedValue){
            
            $resultText = "";
            foreach($keyValueArray as $row):
                $resultText .= '<option value="'.htmlspecialchars($row["hn"]).'"';
                if($selectedValue  != '' && $selectedValue == $row["hn"]){
                    $resultText .=  " selected ";
                }
                $resultText .=  ">".htmlspecialchars($row["hn"]).' '.htmlspecialchars($row["pname"]).htmlspecialchars($row["fname"]).' '.htmlspecialchars($row["lname"])."</option>";
            endforeach;
            return $resultText;
        }
        public static function getWardSelectOption($selectedValue){
            
            $conn = DbUtils::get_hosxp_connection();
            $sql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ipt,".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where ipt.hn=patient.hn and dchdate IS NULL";
            return SelectUtils::getSelectOption($sql, $conn, $selectedValue);
        }

        public static function getSelectOption3($sql, $conn2, $selectedValue){
            
            $stmt = $conn2->query($sql);
            $keyValueArray = $stmt->fetchAll();
            return SelectUtils::getSelectOptionFromArray3($keyValueArray, $selectedValue);
        }
        public static function getSelectOptionFromArray3($keyValueArray, $selectedValue){
            
            $resultText = "";
            $i=1;
            $icon = '';
            foreach($keyValueArray as $row):
                
                if($row['wa_id'] == '1'){
                    $icon = '<i class="fas fa-wheelchair" style="font-size:24px"></i>' ;
                }
               else if($row['wa_id'] == '2'){
                    $icon = '<img src="../../image/stretcher.png" width="25" height="25">' ;
               }
               else if($row['wa_id'] == '3'){
                    $icon = '<img src="../../image/oxygen-tank.png" width="25" height="25">' ;
               }
               else if($row['wa_id'] == '4'){
                    $icon = '<img src="../../image/car-elect.png" width="25" height="25">' ;
               }
                $resultText .= '<div id="wagon" class="col-xl-4">
                <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="wagon'.$i.'" name="wagon[]" value="'.$i.'" required>
                <label class="form-check-label" for="wagon'.$i.'">'.$icon.'  '.$row['wa_name'].'</label>
                </div></div>';
                
                $i++;
            endforeach;
            return $resultText;
        }
        public static function getWardSelectOption3($selectedValue){
            
            $conn2 = DbUtilscart::get_cart_connection();
            $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon";
            return SelectUtils::getSelectOption3($sql, $conn2, $selectedValue);
        }


        public static function getSelectOption2($sql, $conn, $selectedValue){
            
            $stmt = $conn->query($sql);
            $keyValueArray = $stmt->fetchAll();
            return SelectUtils::getSelectOptionFromArray2($keyValueArray, $selectedValue);
        }
        public static function getSelectOptionFromArray2($keyValueArray, $selectedValue2){
            
            $resultText2 = "";
            foreach($keyValueArray as $row):
                $resultText2 .= '<option value="'.htmlspecialchars($row["ward"]).'"';
                if($selectedValue2  != '' && $selectedValue2 == $row["name"]){
                    $resultText2 .=  " selected ";
                }
                $resultText2 .=  ">".htmlspecialchars($row["name"])."</option>";
            endforeach;
            return $resultText2;
        }
        public static function getWardSelectOption2($selectedValue){
            
            $conn = DbUtils::get_hosxp_connection();
            $sql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward";
            return SelectUtils::getSelectOption2($sql, $conn, $selectedValue);
        }

        public static function getshowward(){
           
                $resultText3 = '<input type="hidden" class="form-control" id="showward" name="showward" value="'.$_SESSION['groupname'].'" >
                <input type="text" class="form-control" id="showward" name="showward" value="'.$_SESSION['groupname'].'" disabled>';
            return $resultText3;
        }
        public static function getshowname(){
            
            $name = $_SESSION['name'];
            $resultText4 = '<input type="hidden" class="form-control" id="showname" name="showname" value="'.$name.'" >
            <input type="text" class="form-control" id="showname" name="showname" value="'.$name.'" disabled>';
            return $resultText4;
        }

        public static function wagon_job(){
            echo '<link rel="stylesheet" href="../../vendor/view/css/circle.css">';
            $conn2 = DbUtilscart::get_cart_connection();
            $conn = DbUtils::get_hosxp_connection();
            $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where s.sta_id=j.sta_id and jd.job_id=j.job_id and u_id = '".$_SESSION['loginname']."' and j.sta_id not in ('5','6') group by jd.job_id order by j.sta_id ASC";
            $stmt = $conn2->query($sql);
            $keyValueArray = $stmt->fetchAll();

            $checksql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where s.sta_id=j.sta_id and jd.job_id=j.job_id and u_id = '".$_SESSION['loginname']."' and j.sta_id not in ('5','6') group by jd.job_id";
            $checkstmt = $conn2->query($checksql);
            if($checkstmt->fetchAll()){
                $resultText = "";
                $i=1;
                $resultText .= '
                <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 hide-on-small">
                    <div class="d-sm-flex align-items-center justify-content-between mb-5">
                        <h1 class="h3 mb-0 text-gray-800">รายการรับ-ส่งผู้ป่วย กำลังดำเนินการ</h1>
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
                    <div class="col-xl-1 text-dark">
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
                        <h4>เจ้าหน้าที่เวรเปล</h4>
                    </div>
                    <div class="col-xl-2 text-dark">
                    <h4>สถานะ</h4>
                    </div>
                </div>';
                foreach($keyValueArray as $row):
    
    /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                    $stmt2 = $conn->query($sql2);
                    $result = $stmt2->fetch(); */
                     $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w where j.job_id=jd.job_id and jd.wa_id=w.wa_id and hn = '".$row['hn']."' and u_id ='".$_SESSION['loginname']."' and jd.job_id ='".$row['job_id']."'";
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
                        $f='primary';
                    }
                    else if($row['sta_id'] == '5'){
                        $f='danger';
                    }
                    $m='';
                    if($row['sta_id'] == 2 ||$row['sta_id'] == 3 || $row['sta_id'] == 4){
                        $sql5 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a,".connectConstant::CONNECTION_DBNAME_MCCARTY.".username u where a.u_id=u.u_id and job_id ='".$row['job_id']."'";
                        $stmt5 = $conn2->query($sql5);
                        $result5 = $stmt5->fetch();
    
                        $sql6 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$result5['u_name']."' and (account_disable is null or account_disable <> 'Y') ";
                        $stmt6 = $conn->prepare($sql6);
                        $stmt6->execute();
                        $result6 = $stmt6->fetch();
    
                        $m = $result6['name'];
                    }else{
                        $m = 'ยังไม่มีเจ้าหน้าที่';
                    }
                    $resultText .= '
    
                    <div class="row hide-on-small">
                        <div class="col-xl-1  mb-3">'.$row['hn'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_receive'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_send'].'</div>
                        <div class="col-xl-1  mb-3">'.$value4.'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_note'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_time'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_priority'].'</div>
                        <div class="col-xl-2  mb-3">'.$m.'</div>
                        <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>';
                        if($row['sta_id']==1){
                            $resultText .= '
                            <div class="col-xl-1  mb-3"><a class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">ยกเลิก</a></div>';     
                        }else if($row['sta_id']!=1){
                            $resultText .= '
                            <div class="col-xl-1  mb-3"><a class="btn btn-warning disabled">ยกเลิก</a></div>';     
                        }
                        $resultText .= ' </div>';
                endforeach;
                $resultText .= '</div>';
                $resultText .= '<div class="row" id="hide-off-small"><div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                    <h1 class="h3 mb-0 text-gray-800">รายการรับ-ส่งผู้ป่วย กำลังดำเนินการ</h1>
                    </div></div></div><div class="row" id="hide-off-small">';
    
                foreach($keyValueArray as $row):
    
                    /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                                    $stmt2 = $conn->query($sql2);
                                    $result = $stmt2->fetch(); */
                                    $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w where jd.job_id=j.job_id and jd.wa_id=w.wa_id and hn = '".$row['hn']."' and u_id ='".$_SESSION['loginname']."'";
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
                                        $f='primary';
                                    }
                                    else if($row['sta_id'] == '4'){
                                        $f='primary';
                    
                                    }
                                    else if($row['sta_id'] == '5'){
                                        $f='danger';
                                    }
                                    $resultText .= '
                                        <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>HN</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['hn'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>ส่งจาก</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_receive'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>จุดรับผู้ป่วย</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_send'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>อุปกรณ์</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$value4.'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>Note</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_note'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>เวลา</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_time'].'</div>
                                            </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>ความเร่งด่วน</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_priority'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-2 mb-3">
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>สถานะ</h5>
                                                    </div> <hr>
                                                    <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                                                </div>  
                                            </div>
                                            <hr>';
                                            if($row['sta_id'] == '1'){
                                                $resultText .='<div class="row">
                                                <div class="col-xl-1  mb-3">
                                                    <div class="col-xl-1 text-dark text-center">
                                                        <a class="btn btn-danger w-50" data-bs-toggle="modal" data-bs-target="#exampleModal15" data-bs-whatever="'.$row['job_id'].'" data-bs-whatever2="'.$row['hn'].'" data-bs-whatever3="'.$data.'">ยกเลิก</a>    
                                                    </div>
                                                </div>
                                            </div>';
                                            }else{
                                                $resultText .='<div class="row">
                                                <div class="col-xl-1  mb-3">
                                                    <div class="col-xl-1 text-dark text-center">
                                                        <a class="btn btn-danger w-50 disabled">ยกเลิก</a>    
                                                    </div>
                                                </div>
                                            </div>';
                                            }

                                        $resultText .='</div>';
                                endforeach;
                                $resultText .= '</div>';
                return $resultText;
            }
        }
        public static function showjob(){
            echo '<link rel="stylesheet" href="../../vendor/view/css/circle.css">';
            
            $conn2 = DbUtilscart::get_cart_connection();
            $conn = DbUtils::get_hosxp_connection();
            $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and u_id = '".$_SESSION['loginname']."' and j.sta_id IN (5,6) group by jd.job_id";
            $stmt = $conn2->query($sql);
            $keyValueArray = $stmt->fetchAll();

            $checksql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".status s where j.job_id=jd.job_id and s.sta_id=j.sta_id and u_id = '".$_SESSION['loginname']."' and j.sta_id IN (5,6) group by jd.job_id";
            $checkstmt = $conn2->query($checksql);
            if($checkstmt->fetchAll())
            {
                $resultText = "";
                $i=1;
                $resultText .= '
                <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100 hide-on-small">
                    <div class="d-sm-flex align-items-center justify-content-between mb-5">
                        <h1 class="h3 mb-0 text-gray-800">รายการรับ-ส่งผู้ป่วย</h1>
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
                    <div class="col-xl-2 text-dark">
                        <h4>ความเร่งด่วน</h4>
                    </div>
                    <div class="col-xl-2 text-dark">
                        <h4>สถานะ</h4>
                    </div>
                </div>';
                foreach($keyValueArray as $row):
    
    /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                    $stmt2 = $conn->query($sql2);
                    $result = $stmt2->fetch(); */
                    $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w where jd.job_id=j.job_id and jd.wa_id=w.wa_id and hn = '".$row['hn']."' and u_id ='".$_SESSION['loginname']."' and jd.job_id = '".$row['job_id']."'";
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
                        <div class="col-xl-1  mb-3">'.$row['hn'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_receive'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_send'].'</div>
                        <div class="col-xl-2  mb-3">'.$value4.'</div>
                        <div class="col-xl-2  mb-3">'.$row['job_note'].'</div>
                        <div class="col-xl-1  mb-3">'.$row['job_time'].'</div>
                        <div class="col-xl-2  mb-3">'.$row['job_priority'].'</div>
                        <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                    </div>';
                endforeach;
                $resultText .= '</div>';
                $resultText .= '<div class="row" id="hide-off-small"><div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                    <h1 class="h3 mb-0 text-gray-800">รายงานรับ-ส่งผู้ป่วย</h1>
                    </div></div></div><div class="row" id="hide-off-small">';
    
                foreach($keyValueArray as $row):
    
                    /*                  $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where ward ='".$row['ward']."'";
                                    $stmt2 = $conn->query($sql2);
                                    $result = $stmt2->fetch(); */
                                    $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w where jd.job_id=j.job_id and jd.wa_id=w.wa_id and hn = '".$row['hn']."' and u_id ='".$_SESSION['loginname']."'";
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
                                        <div class="card col-xl-5 shadow me-4 p-5 mb-5 mw-100">
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>HN</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['hn'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>ส่งจาก</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_receive'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>จุดรับผู้ป่วย</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_send'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>อุปกรณ์</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$value4.'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>Note</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_note'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>เวลา</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_time'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-1  mb-3"> 
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>ความเร่งด่วน</h5>
                                                    </div><hr>
                                                    <div class="col-xl-1 ms-3">'.$row['job_priority'].'</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-2 mb-3">
                                                    <div class="col-xl-1 text-dark">
                                                        <h5>สถานะ</h5>
                                                    </div> <hr>
                                                    <div class="col-xl-2 mb-3"> <div class="circle-container"><div class="circle-'.$f.'"></div><div class="icon-text"><p>'.$row['sta_name'].'</p></div></div></div>
                                                </div>  
                                            </div>
                                        </div>';
                                endforeach;
                                $resultText .= '</div>';
                return $resultText;
            }
        }
        public static function Headdata($login) {
            $loginname = $login;
            $conn2 = DbUtilscart::get_cart_connection();
            $conn = DbUtils::get_hosxp_connection();
            $sql = "SELECT *, j.u_id AS own FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept AS a INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job AS j ON a.job_id = j.job_id INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".status AS s ON j.sta_id = s.sta_id WHERE a.ac_st_id IN ('1','2') AND a.u_id = :name";
            $stmt = $conn2->prepare($sql);
            $stmt->bindParam(':name', $loginname);
            $stmt->execute();
            
            $resultText = '';
            $resultText .= '<h1 class="h3 mb-2 text-gray-800">Report '.connectConstant::SYSTEM_NAME;
            $resultText .= '</h1>
            <p class="mb-4">DataTables Report '.connectConstant::SYSTEM_NAME.'ทั้งหมด.</p>
            <!-- DataTales -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>HN</th>
                                    <th>จุดรับ</th>
                                    <th>จุดส่ง</th>
                                    <th>อุปกรณ์</th>
                                    <th>ผู้ร้องขอ</th>
                                    <th>Note</th>
                                    <th>วัน - เวลา</th>
                                    <th>ความเร่งด่วน</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $value=array();
                            foreach($stmt as $row):
                                $value='';
                                $value=array();
                                $sqlwa = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job_detail jd,".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon w where jd.wa_id=w.wa_id and jd.job_id = '".$row['job_id']."'";
                                $stmtwa = $conn2->query($sqlwa);
                                foreach($stmtwa as $result):
                                    array_push($value, $result['wa_name']);
                                endforeach;
                                $status = implode(",", $value);

                                $sql4 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username u,".connectConstant::CONNECTION_DBNAME_MCCARTY.".accept a,".connectConstant::CONNECTION_DBNAME_MCCARTY.".job j where j.job_id = '".$row['job_id']."' and a.u_id=u.u_id and j.job_id=a.job_id";
                                $stmt4 = $conn2->query($sql4);
                                $result4 = $stmt4->fetch();
                                
                                
                                $sql5 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where u_id = '".$row['own']."'";
                                $stmt5 = $conn2->query($sql5);
                                $result5 = $stmt5->fetch();

                                $sql2 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$result5['u_name']."'";
                                $stmt2 = $conn->query($sql2);
                                $result2 = $stmt2->fetch();

                                
                                $sql3 = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = '".$result4['u_name']."'";
                                $stmt3 = $conn->query($sql3);
                                $result3 = $stmt3->fetch();

                            $resultText .= '
                                <tr>
                                    <td>'.$row['hn'].'</td>
                                    <td>'.$row['job_receive'].'</td>
                                    <td>'.$row['job_send'].'</td>
                                    <td>'.$status.'</td>
                                    <td>'.$result2['name'].'</td>
                                    <td>'.$row['job_note'].'</td>
                                    <td>'.DateThai($row['job_date']).'  '.TimeThai($row['job_time']).'</td>
                                    <td>'.$row['job_priority'].'</td>
                                    <td>'.$row['sta_name'].'</td>
                                </tr>';
                            endforeach;
                            $resultText .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
            return $resultText;
        }

    }
