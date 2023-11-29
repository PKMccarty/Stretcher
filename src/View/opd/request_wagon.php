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
require_once '../../Component/DbUtils.php';
require_once '../../Component/DbUtilscart.php';
require_once '../../Component/SelectUtils.php';
/* require_once 'submenu.php'; */
$conn = DbUtils::get_hosxp_connection();
$conn2 = DbUtilscart::get_cart_connection(); 
?>
<link href="../../vendor/view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../../vendor/view/css/sb-admin-2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .select2-selection {
  -webkit-box-shadow: 0;
  box-shadow: 0;
  background-color: #fff !important;
  border-color: #6e707e !important;
  border: 0;
  border-radius: 0;
  color: #495057 !important;
  font-size: 1rem;
  outline: 0;
  min-height: 38px;
  text-align: left;
}

.select2-selection__rendered {
  margin: 8px;
  color: #495057 !important;
border-color: #6e707e !important;
}

.select2-selection__arrow {
  margin: 8px;
  color: #495057 !important;
border-color: #6e707e !important;
} 

    </style>
<div id="wrapper">

    <!-- Sidebar -->
    <?php
     require_once '../../Controller/nav_menu.php'; 
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">


            <!-- Topbar -->
            <?php
            require_once '../../Controller/nav.php';
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?=connectConstant::SYSTEM_NAME;?></h1>
                </div>
                <div class="row">
                    <?php
                /*     Sessioncart::showward($conn, $conn2); */
                    ?>
                    <div class="col-xl-2"></div>
                    <div class="card col-xl-8 shadow me-4 p-5 mb-5">
                        <form id="formsave" onsubmit="return onsubmit_form(event)">
      <!--                   <div class="row">
                            <div class="col-xl">
                                <label class="form-label">หน่วยงาน:</label>
                                <?=SelectUtils::getshowward() ?>
                            </div>
                            <div class="col-xl">
                                <label class="form-label">ผู้ขอ:</label>
                                <?=SelectUtils::getshowname() ?>
                            </div>
                            </div> -->
                            <div class="row mt-3">
                                <div class="col-xl">
                                    <label class="form-label">จุดรับผู้ป่วย:</label>
                                    <input type="hidden" class="form-control" id="receivedis" name="receivedis" value="<?php echo $_SESSION['opdcheck'];?>">
                                    <input type="text" class="form-control" id="receive" name="receive" value="<?php echo $_SESSION['name'];?>" readonly>
                                </div>
<!--                                 <div class="col-xl">
                                    <label class="form-label">จุดส่งผู้ป่วย:</label>
                                    <input type="text" class="form-control" id="ward" name="ward" value="">
                                </div> -->
                                <div class="col-xl">
                                    <label class="form-label">จุดส่งผู้ป่วย:</label>
                                    <div class="input-group mb-3">
                                        <select id="wardopd" class="js2opd custom-select w-100" id="inputGroupSelect01" name="wardipd">
                                        <?=SelectUtils::getShowwardipd($conn)?>
                                        </select>
                                    </div>  
                                </div>
                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl">
                                    <!-- <label class="form-label">จุดรับผู้ป่วย:</label>
                                    <input type="text" class="form-control" id="receive" name="receive" value=""> -->
                                </div>
<!--                                 <div class="col-xl">
                                    <label class="form-label">จุดส่งผู้ป่วย:</label>
                                    <input type="text" class="form-control" id="ward" name="ward" value="">
                                </div> -->
<!--                                 <div class="col-xl">
                                    <label class="form-label">จุดส่งผู้ป่วย อื่นๆ:</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text" name="testohter" placeholder="อื่นๆ">
                                    </div>  
                                </div> -->
                            </div>
<!--                             <div class="row mt-3">
                                <div class="col-xl">
                                </div>
                                <div class="col-xl">
                                    <label class="form-label">IPD:</label>
                                    <div class="input-group mb-3">
                                        <select id="wardopd" class="js2opd custom-select" id="inputGroupSelect01" name="wardipd">
                                        <?=SelectUtils::getShowwardipd($conn)?>
                                        </select>
                                    </div>  
                                </div>
                            </div> -->
<!--                             <div class="row mt-3">
                                <div class="col-xl">
                                </div>
                                <div class="col-xl">
                                    <label class="form-label">OPD:</label>
                                    <div class="input-group mb-3">
                                        <select id="wardipd" class="js2ipd custom-select" id="inputGroupSelect02" name="wardopd">
                                            
                                            <?=SelectUtils::getShowwardopd($conn)?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                               <div class="col-xl">
                                    <label class="form-label">HN ผู้ป่วย:</label>
                                    <input type="text" class="form-control" id="hn" name="hn" required>
                                    <label for="note" style="color:red !important;">* ใส่ HN ให้ครบ 9 หลักป้องกันระบบมีปัญหา</label><br>
                                </div>
                                <div class="col-xl">
                                    <label class="form-label">ความเร่งด่วน:</label>
                                    <select class="form-control" id="priority" name="priority">
                                        <option value="">เลือก</option>
                                        <option value="1">ปกติ</option>
                                        <option value="2">ด่วน</option>
                                        <option value="3">ด่วนที่สุด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-xl">
                                    <label class="form-label">ประเภทการนัด</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appointment" value="1" id="appointment1" checked>
                                        <label class="form-check-label" for="appointment1">
                                            ทันที
                                        </label>
                                        </div>
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appointment" value="2" id="appointment2">
                                        <label class="form-check-label" for="appointment2">
                                            นัดล่วงหน้า
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl">
                                    <div id="showappointment">
                                        <label class="form-label">วัน - เวลา นัดล่วงหน้า:</label>
                                        <input type="text" class="form-control" name="appointmenttime" id="datetimepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-12">
                                    <label class="form-label">ประเภทเปล:</label>
                                </div>
                               <!--  <?=SelectUtils::getWardSelectOption3($conn) ?> -->
                               <?php
                                    $sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".wagon";
                                    $stmt = $conn2->query($sql);
                                    $keyValueArray = $stmt->fetchAll();
                                    $i= 1;
                                    $icon = '';
                                    foreach($keyValueArray as $row):
                                        
                                        if($row['wa_id'] == '1'){
                                            $icon = $row['wagon_img'];
                                        }
                                    else if($row['wa_id'] == '2'){
                                            $icon = $row['wagon_img'] ;
                                    }
                                    else if($row['wa_id'] == '3'){
                                            $icon = $row['wagon_img'] ;
                                    }
                                    else if($row['wa_id'] == '4'){
                                        $icon = $row['wagon_img'] ;
                                    }
                                    else if($row['wa_id'] == '5'){
                                        $icon = $row['wagon_img'] ;
                                    }
                                    else if($row['wa_id'] == '6'){
                                        $icon = $row['wagon_img'] ;
                                    } ?>
                                        <div class="col-xl-4">
                                        <div class="form-check form-check- inline">
                                        <input type="checkbox" class="form-check-input" id="wagon<?=$i?>" name="wagon[]" value="<?=$i?>">
                                        <label class="form-check-label" for="wagon<?=$i?>"><?=$icon?>  <?=$row['wa_name']?></label>
                                        </div></div>
                                    <?php    
                                        $i++;
                                    endforeach;
                                ?>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="note">Note</label><br>
                                <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary" id="btn_summary" onclick="summary_save()"><i class="fas fa-save"></i> บันทึก</button>
                        </form>
                        <div id="data_summary_save"></div>
                    </div>
                    <div class="col-xl-4"></div>
                </div>
               
                <!-- content here -->
                <div class="row">
                    <div class="col-xl-lg-12 mb-4">
                        <?php
                        /*                         Dashboardbed::showbed(); */
                        require_once '../../Controller/footer.php';
                        ?>
                    </div>
                </div>
                <!-- end content -->
<!--                 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการจะออกจากระบบ?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">เลือก "Logout" ถ้าหากคุณต้องการออกจากระบบ.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="../../login/logout">Logout</a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
  flatpickr("#datetimepicker", {
    enableTime: true, // อนุญาตให้เลือกเวลาด้วย
    dateFormat: "Y-m-d H:i", // รูปแบบวันที่และเวลา
    time_24hr: true,
/*     onClose: function(selectedDates, dateStr, instance) {
      // แปลงวันที่ในรูปแบบพุทธศักราคม (พ.ศ.)
      var gregorianDate = new Date(dateStr);
      var buddhistYear = gregorianDate.getFullYear() + 543;
      var buddhistDateStr = buddhistYear + dateStr.substring(4); // ใช้ปีพุทธศักราคมและเอาส่วนที่เหลือจากวันที่เดิม
      
      // แสดงวันที่ในรูปแบบพุทธศักราคม
      instance.setDate(buddhistDateStr, false, "Y-m-d H:i");
    } */
  });
});
</script>
<script>
    $(document).ready(function(){
        $('#showappointment').hide();
        $("#appointment2").click(function() {
            $('#showappointment').show();
        });
        $("#appointment1").click(function() {
            $('#showappointment').hide();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.js2opd').select2();
        $('.js2ipd').select2({
            width:'100'
        });
});
</script>
<script>
        $( document ).ready(function() {
    window.addEventListener('resize', function() {
  if (window.innerWidth < 768) {
    document.getElementById('element-to-hide').style.display = 'none';
  } else {
    document.getElementById('element-to-hide').style.display = 'block';
  }
});

    });
    function onchange_select_ward(){
        var ward = $("#ward").val();
        localStorage.setItem("ward_select", ward);
        Cookies.set('ward_select', ward, { path: '.', expires: 365 });
        get_table_data();
    }

    function onchange_select_wagon(){
        get_table_data();
    }
    function onchange_select_ward(){
        get_table_data();
    }
    function onchange_select_ward2(){
        get_table_data();
    }
    function onsubmit_form(event){
        event.preventDefault();
        get_table_data();
    }
    function summary_save(){
        var url_save = 'request-wagon-save.php';
        var ward = $("#ward").val();
        var receive = $("#receive").val();
        var hn = $("#hn").val();
        var wagon = $("#wagon").val();
        var wardopd = $("#wardopd").val();
        var wardipd = $("#wardipd").val();
        var priority = $("#priority").val();
        if(wagon1 == '' && wagon2 == '' && wagon3 == '' && wagon == ''){
            Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณาเลือกประเภทเปล',
                        showConfirmButton: false,
                        timer: 1500,
                        }).then(function() {
                        window.location = '#';
                        });
        }
        else if(receive == ''){
                        Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณากรอกจุดรับผู้ป่วย',
                        showConfirmButton: false,
                        timer: 1500,
                        }).then(function() {
                        window.location = '#';
                        });
        }else if(hn == ''){
                        Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณาใส่HN',
                        showConfirmButton: false,
                        timer: 1500,
                        }).then(function() {
                        window.location = '#';
                        });
        }else if(priority == ''){
                        Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณาเลือกความเร่งด่วน',
                        showConfirmButton: false,
                        timer: 1500,
                        }).then(function() {
                        window.location = '#';
                        });
        }
        else{
            $.post(url_save,$("#formsave").serialize(),function(data_save){
                  event.preventDefault();
                    $("#data_summary_save").html(data_save);
                    
                      /*  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500,
                        }).then(function() {
                        window.location = 'wagon_report';
                        }); */
                })
        }
    }

</script>
<script src="../../vendor/view/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>