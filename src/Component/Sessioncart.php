<?php
require_once 'DbUtils.php';
require_once "Database/connectConstant.php";
require_once 'DbUtilscart.php';
session_start();
class Sessioncart
{
    public static function showward($conn,$conn2)
    {
        $values =[
			':id'=>$_SESSION['loginname']
		];
       session_start();
           $sql2 = "select * from ".connectConstant::CONNECTION_DBNAME_MCCARTY.".username where u_name = :id ";
			$stmt2 = $conn2->prepare($sql2);
			$stmt2->execute($values);
            $value2 = $stmt2->fetch();
            $sql = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ward ='".$value2['ward']."'";
            $stmt = $conn->prepare($sql);
			$stmt->execute();
            $value = $stmt->fetch();
            $select = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward";
            $selectquery = $conn->prepare($select);
			$selectquery->execute();

            $showp = "select * from ".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ipt,".connectConstant::HOSXP_CONNECTION_HOSXP_DBNAME.".ward where ipt.ward=ward.ward and dchdate IS NULL and ipt.ward = '".$value['ward']."'";
            $showquery = $conn->prepare($showp);
			$showquery->execute();

        echo '<div class="card shadow me-4 p-5 mb-5">
                        <form action="/action_page.php">
            <div class="mb-3 mt-3">
                <label for="text" class="form-label">หน่วยงาน:</label>
                <input type="text" class="form-control" id="email" value="'.$value['name'].'">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">ผู้ขอ:</label>
                <input type="text" class="form-control" id="pwd" value="' . $_SESSION['name'] . '">
            </div>
            <label for="pwd" class="form-label">ประเภทเปล:</label>
            <select class="form-select" aria-label="Default select example">
            <option selected>-------</option>
            <option value="1">เปลนั่ง</option>
            <option value="2">เปลนอน</option>
          </select>
          <div class="mb-3 mt-3">
          <label for="pwd" class="form-label">ส่งตัวไปยัง:</label>
          <select class="form-select" name="name" aria-label="Default select example">;
          <option value="">----------</option>';
          while($row = $selectquery->fetch(PDO::FETCH_ASSOC)){
          echo '<option value="'.$row['ward'].'">'.$row['name'].'</option>';
          }
        echo '</select>
      </div>
      <div class="mb-3 mt-3">
      <label for="pwd" class="form-label">ผู้ป่วยที่ส่งตัว:</label>
      <select class="form-select" name="name" aria-label="Default select example">;
      <option value="">----------</option>';
      while($row2 = $showquery->fetch(PDO::FETCH_ASSOC)){
      echo '<option value="'.$row2['an'].'">'.$row2['an'].'</option>';
      }
    echo '</select>
  </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
            </div>
            ';
        return true;
    }
}
