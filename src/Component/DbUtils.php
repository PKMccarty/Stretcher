<?php
require_once "Database/connectConstant.php";

class DbUtils {
	public static function get_connection($servername, $username, $password, $dbname){
		$conn = null;
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);/*charset=utf8mb4;*/
			$conn->exec("set names utf8");
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $conn;
	}

    public static function get_hosxp_connection(){
		return DbUtils::get_connection(
			connectConstant::HOSXP_CONNECTION_SERVERNAME,
			connectConstant::HOSXP_CONNECTION_USERNAME,
			connectConstant::HOSXP_CONNECTION_PASSWORD,
			connectConstant::HOSXP_CONNECTION_KPHIS_DBNAME);
	}
}
?>