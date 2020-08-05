<?php
$uname = $_POST['uname'];
$password = $_POST['password'];
$password = md5($password);
require_once 'database.php';
$database = new Database();
$select = "*";
$table = "reg";
$where = " where password='$password' AND username='$uname'";
$extention = "";
$result = $database->select($select, $table, $where, $extention);
$row = mysqli_fetch_assoc($result);
if (!empty($row)) {
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $mail = $row['mail'];
    $pnum = $row['phonenum'];
    $add = $row['address'];
    $id = $row['id'];
    $user = $row['username'];
    $thana = $row['thana_id'];
    $select = "*";
    $table = "thana";
    $where = "WHERE id='$thana'";
    $extention = "";
    $result2 = $database->select($select, $table, $where, $extention);
    $row2 = mysqli_fetch_assoc($result2);
    $thana_name = $row2['Thana_name'];
    $dis_id = $row2['district_id'];
    $select = "*";
    $table = "district";
    $where = "WHERE id='$dis_id'";
    $extention = "";
    $result2 = $database->select($select, $table, $where, $extention);
    $row2 = mysqli_fetch_assoc($result2);
    $dis_name = $row2['district_name'];
    $div_id = $row2['divition_id'];
    $select = "*";
    $table = "division";
    $where = "WHERE id='$div_id'";
    $extention = "";
    $result2 = $database->select($select, $table, $where, $extention);
    $row2 = mysqli_fetch_assoc($result2);
    $div_name = $row2['divition_name'];

    session_start();
    $_SESSION["username"] = $user;
    $_SESSION['photo'] = $row['photo'];
    $_SESSION["fname"] = $fname;
    $_SESSION["lname"] = $lname;
    $_SESSION["mail"] = $mail;
    $_SESSION["phone"] = $pnum;
    $_SESSION["divition"] = $div_name;
    $_SESSION["district"] = $dis_name;
    $_SESSION["thana"] = $thana_name;
    $_SESSION["address"] = $add;
    $_SESSION['id'] = $id;
    $st = 8;
    header("Location: ../view/home.php?status=$st");
} else {
    $st = 7;
    header("Location: ../view/home.php?status=$st");
}
?>
