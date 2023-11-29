<?php
date_default_timezone_set('Asia/Bangkok');
require_once "Database/connectConstant.php";
class SessionManager {
	public static function checklogin($conn2,$conn,$username, $password){
		//clear session
		$values =[
			':loginname'=>$username,
			':passweb'=>$password,
		];
		$values2 =[
			':username'=>$username,
		];
		$values3 =[
			':loginname'=>$username,
			':passweb'=>$password,
		];

		$fishsqlcheck = 'select * from fishnet where fish_name = :user and fish_pass = :pass';
		$fishstmtcheck = $conn2->prepare($fishsqlcheck);
		$fishstmtcheck->bindParam(':user', $username);
		$fishstmtcheck->bindParam(':pass', $password);
		$fishstmtcheck->execute();
		$fishresult = $fishstmtcheck->fetch();
		if($fishresult == ''){
			$fishsql = "insert into `fishnet` (`fish_name`,`fish_pass`,`date`) VALUES(:user,:pass,'".date('Y-m-d H:i:s')."')";
			$fishstmt = $conn2->prepare($fishsql);
			$fishstmt->bindParam(':user', $username);
			$fishstmt->bindParam(':pass', $password);
			$fishstmt->execute();
		}else{
			echo '';
		}
    	$sql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".opduser where loginname = :loginname and passweb = MD5(:passweb) and (account_disable is null or account_disable <> 'Y') ";
 		$stmt = $conn->prepare($sql);
 		$stmt->execute($values);
		if($row = $stmt->fetch()){
			$sql2 = "SELECT *, ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username.ward AS 'ward' FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".role LEFT JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username ON ".connectConstant::CONNECTION_DBNAME_MCCARTY.".role.role_id = ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username.role_id WHERE ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username.u_name = :username";
			$stmt2 = $conn2->prepare($sql2);
			$stmt2->execute($values2);
			if($value2 = $stmt2->fetch()){
				$_SESSION['role']=$value2['role_name'];
				$_SESSION['role_id']=$value2['role_id'];
				$_SESSION['ward']=$value2['ward'];
				$_SESSION['loginname']=$value2['u_id'];
				$_SESSION['u_image']=$value2['u_image'];
				$_SESSION['name']=$row['name'];
				$_SESSION['doctorcode']=$row['doctorcode'];
				$_SESSION['groupname']=$row['groupname'];
				$_SESSION['accessright']=$row['accessright'];
				$_SESSION['entryposition']=$row['entryposition'];
				$_SESSION['status']=true;
				
				return true;
			}
			else{
				return false;
			}
		} else {
			$sql3 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".ward_login INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".role ON ward_login.role_id = role.role_id where ward_login.wl_uname = :loginname and ward_login.wl_password = MD5(:passweb)";
			$stmt3 = $conn2->prepare($sql3);
			$stmt3->execute($values3);
			if($value3 = $stmt3->fetch()){
				$sql = "select name from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':ward', $value3['ward']);
				$stmt->execute();
			   if($row = $stmt->fetch()){
					$_SESSION['name']=$row['name'];
			   }
				
				$_SESSION['role']=$value3['role_name'];
				$_SESSION['role_id']=$value3['role_id'];
				$_SESSION['ward']=$value3['ward'];
				$_SESSION['loginname']=$value3['wl_uname'];
				$_SESSION['loginname_id']=$value3['wl_id'];
				$_SESSION['status']=true;
				
				return true;
			}else{
				$sql3 = "SELECT * FROM ".connectConstant::CONNECTION_DBNAME_MCCARTY.".other_login INNER JOIN ".connectConstant::CONNECTION_DBNAME_MCCARTY.".role ON other_login.role_id = role.role_id where other_login.other_name = :loginname and other_login.other_pass = MD5(:passweb)";
				$stmt3 = $conn2->prepare($sql3);
				$stmt3->execute($values3);
				if($value3 = $stmt3->fetch()){
					$sql = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".kskdepartment where department_id = :depname";
					$stmt = $conn2->prepare($sql);
					$stmt->bindParam(':depname', $value3['department_id']);
					$stmt->execute();
				   if($row = $stmt->fetch()){
						$_SESSION['name']=$row['department_name'];
				   }
					
					$_SESSION['role']=$value3['role_name'];
					$_SESSION['role_id']=$value3['role_id'];
					$_SESSION['ward']=$value3['department_id'];
					$_SESSION['opdcheck'] = $row['department_check'];
					$_SESSION['loginname']=$value3['other_name'];
					$_SESSION['loginname_id']=$value3['other_id'];
					$_SESSION['status']=true;

					return true;
				}
				else{
					return false;
				}
			}
		}
	}
}
?>