<?php
require_once "Database/connectConstant.php";
class DbUtilscart {
	public static function get_connection_cart($servername, $username, $password, $dbname){
		$conn2 = null;
		try {
			$conn2 = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);/*charset=utf8mb4;*/
			$conn2->exec("set names utf8");
			$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $conn2;
	}

    public static function get_cart_connection(){
		return DbUtilscart::get_connection_cart(
			connectConstant::CONNECTION_SERVERNAME_MCCARTY,
			connectConstant::CONNECTION_USERNAME_MCCARTY,
			connectConstant::CONNECTION_PASSWORD_MCCARTY,
			connectConstant::CONNECTION_DBNAME_MCCARTY);
	}
}
?>