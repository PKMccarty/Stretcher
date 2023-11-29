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
require_once '../../Component/DbUtils.php';
class wardselect {
	public static function checkward($ward){
        $conn = DbUtils::get_hosxp_connection();
        $values = [':ward'=>$ward];
        $sql = "SELECT name FROM ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward = :ward";
        $stmt = $conn->prepare($sql);
        $stmt->execute($values);
        if($value = $stmt->fetch()){
            $result = $value['name'];
        }
        return $result;
    }
}
?>