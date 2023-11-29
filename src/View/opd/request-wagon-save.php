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
    require_once '../../Component/DbUtilscart.php';
    require_once '../../Component/DbUtils.php';
    require_once '../../Component/line_api.php';
    require_once '../../Component/Database/connectConstant.php';
    $conn2 = DbUtilscart::get_cart_connection();
    $conn = DbUtils::get_hosxp_connection();
    if(empty($_POST['priority']) ? '' : $_POST['priority']=='1'){
        empty($_POST['priority']) ? '' : $_POST['priority'] = 'ปกติ';
        $priority = empty($_POST['priority']) ? '' : $_POST['priority'];
    }
    else if(empty($_POST['priority']) ? '' : $_POST['priority']=='2'){
        empty($_POST['priority']) ? '' : $_POST['priority'] = 'ด่วน';
        $priority = empty($_POST['priority']) ? '' : $_POST['priority'];
    }
    else if(empty($_POST['priority']) ? '' : $_POST['priority']=='3'){
        empty($_POST['priority']) ? '' : $_POST['priority'] = 'ด่วนมาก';
        $priority = empty($_POST['priority']) ? '' : $_POST['priority'];
    }
    $ward = empty($_POST['ward']) ? '' : $_POST['ward'];
    $wardipd = empty($_POST['wardipd']) ? '' : $_POST['wardipd'];
    $wardopd = empty($_POST['wardopd']) ? '' : $_POST['wardopd'];
    $wagon = empty($_POST['wagon']) ? '' : $_POST['wagon'];
    $appointment = empty($_POST['appointment']) ? '' : $_POST['appointment'];
    $appointmenttime = empty($_POST['appointmenttime']) ? '' : $_POST['appointmenttime'];
  if($appointment == '1'){
        if($_POST['receivedis']==$wardipd){
            $seticon = 'warning';
            $settext = 'ไม่สามารถเลือกหน่วยงานเดียวกันได้';
            echo '<a style="color:white !important;">สำเร็จ</a>';
            echo "<script> Swal.fire({
            position: 'top-end',
            icon: '$seticon',
            title: '$settext',
            showConfirmButton: false,
            timer: 1500,
            });
            </script>";
        }else{
            if($ward!=''){
            if($wardopd!='' && $wardipd!=''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else if($wardopd=='' && $wardipd!=''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else if($wardopd!='' && $wardipd==''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else{
                $send = empty($_POST['ward']) ? '' : $_POST['ward'];
                $checkward = true;
            }
            
        }else{
        
            if($wardopd=='' && $wardipd==''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else if($wardopd!='' && $wardipd!=''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }
            else{
                if($wardopd!=''){
                    $send = '';
                    $checwardksql = "SELECT * FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".kskdepartment WHERE depcode = :wardopd";
                    $checkwardstmt = $conn->prepare($checwardksql);
                    $checkwardstmt->bindParam(':wardopd', $wardopd);
                    $checkwardstmt->execute();
                    $checkwardresult = $checkwardstmt->fetch();
                    $newStr = substr($checkwardresult['department'], 4);
                    $send = $newStr;
                    $checkward = true;
                }
                else if($wardipd!=''){
                    $checkopd = "opd";
                    if(strpos($wardipd, $checkopd) !==false){
                        $wardopd = $wardipd;
                        $checwardksql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".kskdepartment WHERE department_check = :wardipd";
                        $checkwardstmt = $conn2->prepare($checwardksql);
                        $checkwardstmt->bindParam(':wardipd', $wardipd);
                        $checkwardstmt->execute();
                        $checkwardresult = $checkwardstmt->fetch();
                        $send = $checkwardresult['department_name'];
                        $checkward = true;
                    }else{

                    $send = '';
                    $firmipd = $wardipd;
                    $checwardksql = "SELECT * FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward WHERE ward = :wardipd";
                    $checkwardstmt = $conn->prepare($checwardksql);
                    $checkwardstmt->bindParam(':wardipd', $firmipd);
                    $checkwardstmt->execute();
                    $checkwardresult = $checkwardstmt->fetch();
                    $send = $checkwardresult['name'];
                    $checkward = true;
                    }
                }
                
                if($wagon!=''){
                    $checkward = true;
                }else{
                    $seticon = 'error';
                    $settext = 'กรุณาเลือกอุปกรณ์';
                    $checkward = false;
                }
            }
        }
        if($checkward == true){
            $text = '';
            $hn = empty($_POST['hn']) ? '' : $_POST['hn'];
            $wagon = empty($wagon) ? '' : $wagon;
            $note = empty($_POST['note']) ? '' : $_POST['note'];
            $receive = empty($_POST['receive']) ? '' : $_POST['receive'];
            $receivedis = empty($_POST['receivedis']) ? '' : $_POST['receivedis'];
            $loginname = empty($_SESSION['loginname']) ? '' : $_SESSION['loginname'];
            $ward = empty($_SESSION['ward']) ? '' : $_SESSION['ward'];

        $date = date('Y-m-d');
        $time = date('h:i:sa');
            $splitnote = preg_replace("/[^0-9]/", "", $hn);
            $length = strlen($splitnote);
            $checksql = "SELECT COUNT(*) AS count FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient WHERE hn = :hnToCheck";
            $checstmt = $conn->prepare($checksql);
            $checstmt->bindParam(':hnToCheck', $hn, PDO::PARAM_STR);
            $checstmt->execute();
            $resultcheck = $checstmt->fetch(PDO::FETCH_ASSOC);
            $count = $resultcheck['count'];
            if($wagon != ''){
            if($count > 0){
                if ($length==9) { 
                $addsql = "insert into job (`job_send`,`job_receive`,`job_priority`,`hn`,`job_note`,`u_id`,`job_time`,`sta_id`,`job_nurse_sta`,`receive_ipd`,`send_ipd`,`send_opd`,`appointment_id`,`job_date`) values(:send,:receive,:priority,:splitnote,:note,:loginname,:time,1,0,:receivedis,:wardipd,:wardopd,:appointment,:date)";
                $addstmt = $conn2->prepare($addsql);
                $addstmt->bindParam(':send', $send);
                $addstmt->bindParam(':receive', $receive);
                $addstmt->bindParam(':receivedis', $receivedis);
                $addstmt->bindParam(':priority', $priority);
                $addstmt->bindParam(':splitnote', $splitnote);
                $addstmt->bindParam(':note', $note);
                $addstmt->bindParam(':loginname', $loginname);
                $addstmt->bindParam(':time', $time);
                $addstmt->bindParam(':date', $date);
                $addstmt->bindParam(':appointment', $appointment);
                $addstmt->bindParam(':wardipd', $wardipd);
                $addstmt->bindParam(':wardopd', $wardopd);
                $addstmt->execute();
        
                $selectsql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where hn = :splitnote and u_id = :loginname and job_date = :date order by job_id DESC";
                $selectstmt = $conn2->prepare($selectsql);
                $selectstmt->bindParam(':splitnote', $splitnote);
                $selectstmt->bindParam(':loginname', $loginname);
                $selectstmt->bindParam(':date', $date);
                $selectstmt->execute();
                $value = $selectstmt->fetch();
        
        
                for($i=0;$i<count($wagon);$i++){
                $sql = "insert into job_detail (`job_id`,`wa_id`,`job_d_time`,`job_d_date`)values(:value,:wagon,:time,:date)";
                $sqlcheck = "select * from wagon where wa_id = :wagon";
                try {
                    $stmt = $conn2->prepare($sql);
                    $stmt->bindParam(':wagon', $wagon[$i]);
                    $stmt->bindParam(':value', $value['job_id']);
                    $stmt->bindParam(':time', $time);
                    $stmt->bindParam(':date', $date);
                    $stmt->execute();
        
                    $stmtcheck  = $conn2->prepare($sqlcheck );
                    $stmtcheck->bindParam(':wagon', $wagon[$i]);
                    $stmtcheck ->execute();
                    $rowcheck = $stmtcheck->fetch(PDO::FETCH_ASSOC);
        
                    $resultcheck[] = $rowcheck['wa_name'];
        
                    $seticon = 'success';
                    $settext = 'เพิ่มข้อมูลสำเร็จ';
                }catch (PDOException  $e) {
                    echo $e->getMessage();
                    $seticon = 'error';
                    $settext = 'เพิ่มข้อมูลไม่สำเร็จ';
                }
            }
                if($settext == 'เพิ่มข้อมูลสำเร็จ'){
                    
                                
                    $sqlshowpatient = "select  CONCAT(pname,fname,' ',lname) as 'name' from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
                    $stmtpatient=$conn->prepare($sqlshowpatient);
                    $stmtpatient->bindParam(':hn', $splitnote);
                    $stmtpatient ->execute();
                    $showpatient = $stmtpatient->fetch(PDO::FETCH_ASSOC);

                    $combinedWords = implode(",", $resultcheck);
                    $newStrr = substr($combinedWords, 2);
        
                    $token = connectConstant::CONNECTION_TOKEN_LINE;
                    $text .= "\n"."------------------------------"."\n";
                    $text .= "รายการร้องขอเปล";
                    $text .= "\n"."------------------------------"."\n";
                    $text .= "สถานะ : ปกติ"."\n";
                    $text .= "HN : ".$splitnote."\n";
                    $text .= "ชื่อ - สกุล : ".$showpatient['name']."\n";
                    $text .= "จาก : ".$receive."\n";
                    $text .= "ส่งไปยัง : ".$send."\n";
                    $text .= "อุปกรณ์ที่ร้องขอ : ".$newStrr."\n";
                    $text .= "ความเร่งด่วน : ".$priority."\n";
                    $text .= "บันทึก : ".$note."\n";
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
                        window.location = 'index';
                    });
                    </script>"; 
                } else {
                    $seticon = 'error';
                    $settext = 'กรุณาใส่ HN ให้ถูกต้อง';
                    echo '<a style="color:white !important;">สำเร็จ</a>';
                    echo "<script> Swal.fire({
                    position: 'top-end',
                    icon: '$seticon',
                    title: '$settext',
                    showConfirmButton: false,
                    timer: 1500,
                    });
                    </script>"; 
                }
        }else{
            $seticon = 'error';
            $settext = 'ไม่มี HN ในระบบ';
            echo '<a style="color:white !important;">สำเร็จ</a>';
            echo "<script> Swal.fire({
            position: 'top-end',
            icon: '$seticon',
            title: '$settext',
            showConfirmButton: false,
            timer: 1500,
            });
            </script>";
        }
        }
        }else{
            echo '<a style="color:white !important;">สำเร็จ</a>';
            echo "<script> Swal.fire({
            position: 'top-end',
            icon: '$seticon',
            title: '$settext',
            showConfirmButton: false,
            timer: 1500,
            });
            </script>";
        } 
    }
}else{
    if($appointmenttime==''){
        $seticon = 'warning';
        $settext = 'กรุณาใส่ วัน - เวลานัด';
        echo '<a style="color:white !important;">สำเร็จ</a>';
        echo "<script> Swal.fire({
        position: 'top-end',
        icon: '$seticon',
        title: '$settext',
        showConfirmButton: false,
        timer: 1500,
        });
        </script>";
    }
    else
    {
        if($_POST['receivedis']==$wardipd){
            $seticon = 'warning';
            $settext = 'ไม่สามารถเลือกหน่วยงานเดียวกันได้';
            echo '<a style="color:white !important;">สำเร็จ</a>';
            echo "<script> Swal.fire({
            position: 'top-end',
            icon: '$seticon',
            title: '$settext',
            showConfirmButton: false,
            timer: 1500,
            });
            </script>";
        }else{
            if($ward!=''){
            if($wardopd!='' && $wardipd!=''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else if($wardopd=='' && $wardipd!=''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else if($wardopd!='' && $wardipd==''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else{
                $send = empty($_POST['ward']) ? '' : $_POST['ward'];
                $checkward = true;
            }
            
        }else{
        
            if($wardopd=='' && $wardipd==''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }else if($wardopd!='' && $wardipd!=''){
                $seticon = 'error';
                $settext = 'กรุณาเลือกจุดส่งผู้ป่วยอย่างใด อย่างนึง';
                $checkward = false;
            }
            else{
                if($wardopd!=''){
                    $send = '';
                    $checwardksql = "SELECT * FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".kskdepartment WHERE depcode = :wardopd";
                    $checkwardstmt = $conn->prepare($checwardksql);
                    $checkwardstmt->bindParam(':wardopd', $wardopd);
                    $checkwardstmt->execute();
                    $checkwardresult = $checkwardstmt->fetch();
                    $newStr = substr($checkwardresult['department'], 4);
                    $send = $newStr;
                    $checkward = true;
                }
                else if($wardipd!=''){
                    $checkopd = "opd";
                    if(strpos($wardipd, $checkopd) !==false){
                        $wardopd = $wardipd;
                        $checwardksql = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".kskdepartment WHERE department_check = :wardipd";
                        $checkwardstmt = $conn2->prepare($checwardksql);
                        $checkwardstmt->bindParam(':wardipd', $wardipd);
                        $checkwardstmt->execute();
                        $checkwardresult = $checkwardstmt->fetch();
                        $send = $checkwardresult['department_name'];
                        $checkward = true;
                    }else{

                    $send = '';
                    $firmipd = $wardipd;
                    $checwardksql = "SELECT * FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward WHERE ward = :wardipd";
                    $checkwardstmt = $conn->prepare($checwardksql);
                    $checkwardstmt->bindParam(':wardipd', $firmipd);
                    $checkwardstmt->execute();
                    $checkwardresult = $checkwardstmt->fetch();
                    $send = $checkwardresult['name'];
                    $checkward = true;
                    }
                }
                
                if($wagon!=''){
                    $checkward = true;
                }else{
                    $seticon = 'error';
                    $settext = 'กรุณาเลือกอุปกรณ์';
                    $checkward = false;
                }
            }
        }
        if($checkward == true){
            $text = '';
            $hn = empty($_POST['hn']) ? '' : $_POST['hn'];
            $wagon = empty($wagon) ? '' : $wagon;
            $note = empty($_POST['note']) ? '' : $_POST['note'];
            $receive = empty($_POST['receive']) ? '' : $_POST['receive'];
            $receivedis = empty($_POST['receivedis']) ? '' : $_POST['receivedis'];
            $loginname = empty($_SESSION['loginname']) ? '' : $_SESSION['loginname'];
            $ward = empty($_SESSION['ward']) ? '' : $_SESSION['ward'];

        $date = date('Y-m-d');
        $time = date('h:i:sa');
            $splitnote = preg_replace("/[^0-9]/", "", $hn);
            $length = strlen($splitnote);
            $checksql = "SELECT COUNT(*) AS count FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient WHERE hn = :hnToCheck";
            $checstmt = $conn->prepare($checksql);
            $checstmt->bindParam(':hnToCheck', $hn, PDO::PARAM_STR);
            $checstmt->execute();
            $resultcheck = $checstmt->fetch(PDO::FETCH_ASSOC);
            $count = $resultcheck['count'];
            if($wagon != ''){
            if($count > 0){
                if ($length==9) { 
                $addsql = "insert into job (`job_send`,`job_receive`,`job_priority`,`hn`,`job_note`,`u_id`,`job_time`,`sta_id`,`job_nurse_sta`,`receive_ipd`,`send_ipd`,`send_opd`,`appointment_id`,`job_appointment_date`,`job_date`) values(:send,:receive,:priority,:splitnote,:note,:loginname,:time,1,0,:receivedis,:wardipd,:wardopd,:appointment,:appointmenttime,:date)";
                $addstmt = $conn2->prepare($addsql);
                $addstmt->bindParam(':send', $send);
                $addstmt->bindParam(':receive', $receive);
                $addstmt->bindParam(':receivedis', $receivedis);
                $addstmt->bindParam(':priority', $priority);
                $addstmt->bindParam(':splitnote', $splitnote);
                $addstmt->bindParam(':note', $note);
                $addstmt->bindParam(':loginname', $loginname);
                $addstmt->bindParam(':time', $time);
                $addstmt->bindParam(':date', $date);
                $addstmt->bindParam(':appointment', $appointment);
                $addstmt->bindParam(':appointmenttime', $appointmenttime);
                $addstmt->bindParam(':wardipd', $wardipd);
                $addstmt->bindParam(':wardopd', $wardopd);
                $addstmt->execute();
        
                $selectsql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".job where hn = :splitnote and u_id = :loginname and job_date = :date order by job_id DESC";
                $selectstmt = $conn2->prepare($selectsql);
                $selectstmt->bindParam(':splitnote', $splitnote);
                $selectstmt->bindParam(':loginname', $loginname);
                $selectstmt->bindParam(':date', $date);
                $selectstmt->execute();
                $value = $selectstmt->fetch();
        
        
                for($i=0;$i<count($wagon);$i++){
                $sql = "insert into job_detail (`job_id`,`wa_id`,`job_d_time`,`job_d_date`)values(:value,:wagon,:time,:date)";
                $sqlcheck = "select * from wagon where wa_id = :wagon";
                try {
                    $stmt = $conn2->prepare($sql);
                    $stmt->bindParam(':wagon', $wagon[$i]);
                    $stmt->bindParam(':value', $value['job_id']);
                    $stmt->bindParam(':time', $time);
                    $stmt->bindParam(':date', $date);
                    $stmt->execute();
        
                    $stmtcheck  = $conn2->prepare($sqlcheck );
                    $stmtcheck->bindParam(':wagon', $wagon[$i]);
                    $stmtcheck ->execute();
                    $rowcheck = $stmtcheck->fetch(PDO::FETCH_ASSOC);
        
                    $resultcheck[] = $rowcheck['wa_name'];
        
                    $seticon = 'success';
                    $settext = 'เพิ่มข้อมูลสำเร็จ';
                }catch (PDOException  $e) {
                    echo $e->getMessage();
                    $seticon = 'error';
                    $settext = 'เพิ่มข้อมูลไม่สำเร็จ';
                }
            }
                if($settext == 'เพิ่มข้อมูลสำเร็จ'){
                    
                                
                    $sqlshowpatient = "select  CONCAT(pname,fname,' ',lname) as 'name' from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".patient where hn = :hn";
                    $stmtpatient=$conn->prepare($sqlshowpatient);
                    $stmtpatient->bindParam(':hn', $splitnote);
                    $stmtpatient ->execute();
                    $showpatient = $stmtpatient->fetch(PDO::FETCH_ASSOC);

                    $combinedWords = implode(",", $resultcheck);
                    $newStrr = substr($combinedWords, 2);
        
                    $token = connectConstant::CONNECTION_TOKEN_LINE;
                    $text .= "\n"."------------------------------"."\n";
                    $text .= "รายการร้องขอเปล";
                    $text .= "\n"."------------------------------"."\n";
                    $text .= "สถานะ : นัดล่วงหน้า"."\n";
                    $text .= "วัน - เวลา : ".$appointmenttime."\n";
                    $text .= "HN : ".$splitnote."\n";
                    $text .= "ชื่อ - สกุล : ".$showpatient['name']."\n";
                    $text .= "จาก : ".$receive."\n";
                    $text .= "ส่งไปยัง : ".$send."\n";
                    $text .= "อุปกรณ์ที่ร้องขอ : ".$newStrr."\n";
                    $text .= "ความเร่งด่วน : ".$priority."\n";
                    $text .= "บันทึก : ".$note."\n";
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
                        window.location = 'index';
                    });
                    </script>"; 
                } else {
                    $seticon = 'error';
                    $settext = 'กรุณาใส่ HN ให้ถูกต้อง';
                    echo '<a style="color:white !important;">สำเร็จ</a>';
                    echo "<script> Swal.fire({
                    position: 'top-end',
                    icon: '$seticon',
                    title: '$settext',
                    showConfirmButton: false,
                    timer: 1500,
                    });
                    </script>"; 
                }
        }else{
            $seticon = 'error';
            $settext = 'ไม่มี HN ในระบบ';
            echo '<a style="color:white !important;">สำเร็จ</a>';
            echo "<script> Swal.fire({
            position: 'top-end',
            icon: '$seticon',
            title: '$settext',
            showConfirmButton: false,
            timer: 1500,
            });
            </script>";
        }
        }
        }else{
            echo '<a style="color:white !important;">สำเร็จ</a>';
            echo "<script> Swal.fire({
            position: 'top-end',
            icon: '$seticon',
            title: '$settext',
            showConfirmButton: false,
            timer: 1500,
            });
            </script>";
        } 
    }
    }
}