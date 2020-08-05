<?php

require_once 'database.php';

class UserControl extends Database {

    public $database;

    public function __construct() {

        $this->database = new Database();
    }

    public function create($info) {
        $keys = array_keys($info);
        $column = "";
        $values = "";
        $endKey = end($keys);
        foreach ($keys as $key) {
            $comma = ($key != $endKey) ? ", " : " ";
            $column = $column . $key . $comma;
            $values = $values . " '" . $info[$key] . "' " . $comma;
        }
        $table = "reg";
        $this->database->insert($table, $column, $values);
    }

    public function edit($info, $id) {
        $keys = array_keys($info);
        $set = "";
        $endKey = end($keys);
        foreach ($keys as $key) {
            $comma = ($key != $endKey) ? ", " : " ";
            $set = $set . $key . " = " . " '" . $info[$key] . "' " . $comma;
        }
        $table = "reg";
        $where = "WHERE id = $id";
        $this->database->update($table, $set, $where);
    }

    public function deleteUser($id) {
        $table = "reg";
        $where = "WHERE id='$id'";
        $this->database->delete($table, $where);
    }

}

$usercontrol = new UserControl();

if (isset($_POST['Cancel'])) {
    header("Location: ../view/user.php");
}
if (isset($_POST['submit_reg'])) {
    $database = new Database();
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    if (!empty($_POST['email'])) {
        $mail = $_POST['email'];
    } else {
        $mail = "No_mail_added";
    }
    if (!empty($_POST['pnumber'])) {
        $pnum = $_POST['pnumber'];
    } else {
        $pnum = "No_phone_number";
    }
    if (!empty($_POST['full_add'])) {
        $addr = $_POST['full_add'];
    } else {
        $addr = "No_address";
    }
    if ($_FILES['photo']['name'] != "") {
        $photo = $_FILES['photo']['name'];
        $temp = $_FILES['photo']['tmp_name'];

        $p = 1;
    } else {
        $photo = "nophoto.jpeg";
        $temp = "";
        $p = 0;
    }
    if (isset($_GET['thana'])) {
        $thana = $_POST['thana'];
    } else {
        $thana = "";
    }
    $pass = $_POST['pass'];
    $user = $_POST['username'];
    $cpass = $_POST['cpass'];
    $target = "../images/images/" . basename($photo);
    if ($pass != $cpass) {
        $st = 10;
        header("Location: ../view/regmain.php?status=$st");
    } else {
        if ($p == 1) {
            if (move_uploaded_file($temp, $target)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Failed to upload image";
            }
        }
        $id = 0;
        $select = "id";
        $table = "thana";
        $where = "where Thana_name = '$thana'";
        $extention = "";
        $result = $database->select($select, $table, $where, $extention);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];
        $pass = md5($pass);
        $info["firstname"] = $fname;
        $info["lastname"] = $lname;
        $info["mail"] = $mail;
        $info["username"] = $user;
        $info["password"] = $pass;
        $info["phonenum"] = $pnum;
        $info["address"] = $addr;
        $info["thana_id"] = $id;
        $info["photo"] = $photo;
        $usercontrol->create($info);
        if (!is_null($fname) && !is_null($lname)) {
            $st = 1;
        } else {
            $st = 0;
        }
        header("Location: ../view/regmain.php?status=$st");
    }
}
if (isset($_POST['submit_edit'])) {

    $id = $_POST['id'];
    $info['firstname'] = $_POST['fname'];
    $info['lastname'] = $_POST['lname'];
    $info['mail'] = $_POST['email'];
    $info['username'] = $_POST['username'];
    $info['password'] = $_POST['pass'];
    $info['phonenum'] = $_POST['pnumber'];
    $info['address '] = $_POST['full_add'];
    $thana = $_POST['thana'];
    $database = new Database();
    $select = "id";
    $table = "thana";
    $where = "where Thana_name = '$thana'";
    $extention = "";
    $result = $database->select($select, $table, $where, $extention);
    $row = mysqli_fetch_assoc($result);
    $info['thana_id'] = $row["id"];
    $cpass = $_POST['cpass'];
    $dis = $_POST['dist'];
    $div = $_POST['Division'];
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $temp = $_FILES['photo']['tmp_name'];
        $target = "../images/images/" . basename($photo);
        $ph_check = 1;
        if (move_uploaded_file($temp, $target)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Failed to upload image";
        }
        $info['photo'] = $photo;
    }
    if ($info['password'] != $cpass) {
        $st = 10;
        header("Location: ../view/user.php?status=$st");
    } else {
        $info['password'] = md5($info['password']);
        $st = 5;
        $result = $usercontrol->edit($info, $id);
        header("Location: ../view/user.php?status=$st");
    }
}
if (isset($_GET['flag'])) {
    $id = $_GET['id'];
    $usercontrol->deleteUser($id);
    $st = 4;
    header("Location: ../view/user.php?status=$st");
}
?>