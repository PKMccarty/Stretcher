<?php

require_once '../Controller/head.php';
require_once '../Component/Database/connectConstant.php';
require_once '../Component/SessionManager.php';
require_once '../Component/DbUtils.php';
require_once '../Component/DbUtilscart.php';


$username = $_POST['username'];
$password = $_POST['password'];

$conn = DbUtils::get_hosxp_connection();
$conn2 = DbUtilscart::get_cart_connection();

if(SessionManager::checklogin($conn2,$conn,$username, $password)){
	if($_SESSION['role']=='จัดการ'){
		echo '<a style="color:white !important;">สำเร็จ</a>';
		$seticon = 'success';
		$settext = '<h4>เข้าสู่ระบบสำเร็จ</h4>';
		echo "<script> Swal.fire({
		position: 'top-end',
		icon: '$seticon',
		title: '$settext',
		showConfirmButton: false,
		timer: 1500,
		}).then(function() {
		window.location = '../view/manage/index';
		});
		</script>";
	}
	else if($_SESSION['role']=='OPD'){
		echo '<a style="color:white !important;">สำเร็จ</a>';
		$seticon = 'success';
		$settext = '<h4>เข้าสู่ระบบสำเร็จ</h4>';
		echo "<script> Swal.fire({
		position: 'top-end',
		icon: '$seticon',
		title: '$settext',
		showConfirmButton: false,
		timer: 1500,
		}).then(function() {
		window.location = '../view/opd/index';
		});
		</script>";
	}
	else if($_SESSION['role']=='IPD'){
		echo '<a style="color:white !important;">สำเร็จ</a>';
		$seticon = 'success';
		$settext = '<h4>เข้าสู่ระบบสำเร็จ</h4>';
		echo "<script> Swal.fire({
		position: 'top-end',
		icon: '$seticon',
		title: '$settext',
		showConfirmButton: false,
		timer: 1500,
		}).then(function() {
			window.location = '../view/ward/index';
		});
		</script>";
	}else{
		echo '<a style="color:white !important;">สำเร็จ</a>';
		$seticon = 'success';
		$settext = '<h4>เข้าสู่ระบบสำเร็จ</h4>';
		echo "<script> Swal.fire({
		position: 'top-end',
		icon: '$seticon',
		title: '$settext',
		showConfirmButton: false,
		timer: 1500,
		}).then(function() {
		window.location = '../view/wagon/index';
		});
		</script>"; 
	} 
} else {
  	echo '<a style="color:white !important;">สำเร็จ</a>';
	$seticon = 'error';
	$settext = '<h4>เข้าสู่ระบบล้มเหลว</h4>';
	echo "<script> Swal.fire({
	position: 'top-end',
	icon: '$seticon',
	title: '$settext',
	showConfirmButton: false,
	timer: 1500,
	}).then(function() {
		window.location = '../index';
	});
	</script>";
}

?>