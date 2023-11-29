<?php
require_once '../Controller/head.php';
require_once '../Component/Database/connectConstant.php';
$keyrecaptcha = "6LdH-B0pAAAAABNkdTVF1OeNVWvrI7mhmORoVqOK";
if(isset($_SESSION['status']))
{
    if($_SESSION['status'] === true){
        
        if($_SESSION['role_id'] == '1'){
            echo "<script>window.location.href = '/view/wagon/index';</script> ";
        }
       else if($_SESSION['role_id'] == '5'){
            echo "<script>window.location.href = '/view/ward/index';</script> ";
        }
        else if($_SESSION['role_id'] == '6'){
            echo "<script>window.location.href = '/view/opd/index';</script> ";
        }
        else if($_SESSION['role_id'] == '4'){
            echo "<script>window.location.href = '/view/manage/index';</script> ";
        }
    }
    else if($_SESSION['status'] === false)    {?>
    <!-- Include SweetAlert and reCAPTCHA API -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/animate/animate.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/css-hamburgers/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/css/util.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/css/main.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 justify-content-center">
            <form action="checklogin.php" method="post" class="login100-form validate-form" onsubmit="return validateForm()">
                <span class="login100-form-title">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img class="img-fluid" src="../image/stretcher-logo.png" width="550" height="550" alt="IMG">
                    </div>
                </span>
                <div class="wrap-input100 validate-input" data-validate="Valid Username is required: ex@abc.xyz">
                    <input class="input100" type="text" name="username" placeholder="Username" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="container-login100-form-btn">
                    <div class="g-recaptcha" data-sitekey="<?php echo $keyrecaptcha; ?>"></div>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        เข้าสู่ระบบ
                    </button>
                </div>
            </form>
            <div class="text-center p-t-12">
                <span class="txt1">
                    ไม่ทราบ/ลืม Username Password
                </span>
                <a class="txt2" href="https://line.me/ti/g/BHWnjrYRx0">
                    ติดต่อศูนย์คอม คลิก.
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Include other scripts -->
<script src="../vendor/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="../vendor/login/vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/login/vendor/select2/select2.min.js"></script>
<script src="../vendor/login/vendor/tilt/tilt.jquery.min.js"></script>
<script src="../vendor/login/js/main.js"></script>
<!-- ... (previous code) ... -->

<script>
    function validateForm() {
        var recaptchaValue = grecaptcha.getResponse();
        if (recaptchaValue.length === 0) {
            // reCAPTCHA not selected, show SweetAlert notification
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'กรุณายืนยันตัวตน recaptcha',
            });
            return false;
        }
        return true;
    }
</script>
<?php      
    }
}else{ ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/animate/animate.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/css-hamburgers/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/vendor/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/css/util.css">
<link rel="stylesheet" type="text/css" href="../vendor/login/css/main.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 justify-content-center">
            <form action="checklogin.php" method="post" class="login100-form validate-form" onsubmit="return validateForm()">
                <span class="login100-form-title">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img class="img-fluid" src="../image/stretcher-logo.png" width="550" height="550" alt="IMG">
                    </div>
                </span>
                <div class="wrap-input100 validate-input" data-validate="Valid Username is required: ex@abc.xyz">
                    <input class="input100" type="text" name="username" placeholder="Username" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="container-login100-form-btn">
                    <div class="g-recaptcha" data-sitekey="<?php echo $keyrecaptcha; ?>"></div>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        เข้าสู่ระบบ
                    </button>
                </div>
            </form>
            <div class="text-center p-t-12">
                <span class="txt1">
                    ไม่ทราบ/ลืม Username Password
                </span>
                <a class="txt2" href="https://line.me/ti/g/BHWnjrYRx0">
                    ติดต่อศูนย์คอม คลิก.
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Include other scripts -->
<script src="../vendor/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="../vendor/login/vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/login/vendor/select2/select2.min.js"></script>
<script src="../vendor/login/vendor/tilt/tilt.jquery.min.js"></script>
<script src="../vendor/login/js/main.js"></script>
<!-- ... (previous code) ... -->

<script>
    function validateForm() {
        var recaptchaValue = grecaptcha.getResponse();
        if (recaptchaValue.length === 0) {
            // reCAPTCHA not selected, show SweetAlert notification
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'กรุณายืนยันตัวตน recaptcha',
            });
            return false;
        }
        return true;
    }
</script>
<?php }
/* 
echo '<pre>';
print_r($_SERVER);
echo '</pre>'; */
?>