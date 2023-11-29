<?php
	require_once '../Controller/head.php';
    session_destroy();
	echo '-';
    echo "<script> Swal.fire({
		position: 'top-end',
		icon: 'success',
		title: 'ออกจากระบบเรียบร้อย',
		showConfirmButton: false,
		timer: 1500,
	  }).then(function() {
		  window.location = '../index.php';
	  });
		</script>";
?>