<?php
    require_once __DIR__.'../../Component/DbUtilscart.php';
    require_once __DIR__.'../../Component/datethai.php';
    class notify
    {
        public static function alert()
        {
            $status ='1';
            $conn2 = DbUtilscart::get_cart_connection();
            $sqlcount ="select count(*) as cc from job where sta_id = :sta";
            $stmt2 = $conn2->prepare($sqlcount);
            $stmt2->bindParam(':sta',$status);
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            if($row2['cc']==0){
                $row2['cc'] = '';
            }
            else
            {
                $row2['cc']=$row2['cc'];
            }
            $reult = '';
            $reult .='<li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">'.$row2['cc'].'</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown mb-5">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>';
                $sql = "select * from job where sta_id = :sta order by job_date DESC";
                $stmt = $conn2->prepare($sql);
                $stmt->bindParam(':sta',$status);
                $stmt->execute();
                foreach($stmt as $row):
                    $coding = base64_encode($row['job_id']);
                   $reult .='<a class="dropdown-item d-flex align-items-center" href="alert_request?id='.$coding.'">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">'.DateThai($row['job_date']).' '.TimeThai($row['job_time']).' น.</div>
                        <span class="font-weight-bold">แผนก '.$row['job_receive'].' ร้องขอเคลื่อนย้ายผู้ป่วย HN '.$row['hn'].' ไปยัง '.$row['job_send'].'<br>';
                        if($row['job_note']==''){
                            echo '';
                        }else{
                           $reult .='NOTE : '.$row['job_note'];
                        }
                        $reult .='</span>
                    </div>
                </a>';
                endforeach;
/*             $reult .='<a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>'; */
/*             $reult .='<a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: Weve noticed unusually high spending for your account.
                    </div>
                </a>'; */
            $reult .='</div></li>';
        return $reult;
        }
        public static function normal_alert()
        {
            $reult ='<li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter"></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>';
/*                    $reult .='<a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500"></div>
                        <span class="font-weight-bold">แผนก </span>
                    </div>
                </a>'; */
/*             $reult .='<a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>'; */
/*             $reult .='<a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: Weve noticed unusually high spending for your account.
                    </div>
                </a>'; */
            $reult .='</div></li>';
            return $reult;
        }
    }
?>