<?php

require_once 'database.php';

class GellaryControl extends Database {

    public $database;

    public function __construct() {

        $this->database = new Database();
    }

    public function deleteAlbum() {
        $id = $_GET['id'];
        $table = "images";
        $where = "WHERE album_id='$id'";
        $result = $this->database->delete($table, $where);
        $table = "album";
        $where = "WHERE id='$id'";
        $result = $this->database->delete($table, $where);
        $st = 4;
        header("Location: ../view/editgellary.php?status=$st");
    }

    public function deleteImg() {
        $id = $_GET['id'];
        $table = "images";
        $where = "WHERE id='$id'";
        $result = $this->database->delete($table, $where);
        $st = 4;
        header("Location: ../view/gellary.php?status=$st");
    }

    public function gellaryEdit() {
        $id = $_POST['id'];
        $name = $_POST['al_name'];
        $table = "album";
        $set = "album_name = '$name'";
        $where = "WHERE id = '$id'";
        $result = $this->database->update($table, $set, $where);
        $st = 5;
        header("Location: ../view/editgellary.php?status=$st");
    }

    public function createAlbum() {
        $albumname = $_POST['al_name'];
        if (!empty($albumname)) {
            $table = "album";
            $column = "album_name";
            $values = "'$albumname'";
            $this->database->insert($table, $column, $values);

            $st = 1;
        } else {
            $st = 0;
        }
        header("Location: ../view/upload.php?status2=$st");
    }

    public function uploadPhoto() {
        $albumname = $_POST['album'];
        $select = "id";
        $table = "album";
        $where = "where album_name ='$albumname'";
        $extention = "";
        $result = $this->database->select($select, $table, $where, $extention);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];
        foreach ($_FILES['image']['name'] as $key => $val) {
            $photo = $_FILES['image']['name'][$key];
            $temp = $_FILES['image']['tmp_name'][$key];
            $target = "../images/albumimage/" . basename($photo);
            if (move_uploaded_file($temp, $target)) {
                $msg = "Image uploaded successfully";
                $st = 1;
            } else {
                $msg = "Failed to upload image";
                $st = 0;
            }
            $table = "images";
            $column = "image,album_id";
            $values = "'$photo','$id'";
            $this->database->insert($table, $column, $values);
        }
        header("Location: ../view/upload.php?status1=$st");
    }

    public function editImg($alname, $im_id, $return, $al_id) {
        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            $target = "../images/albumimage/" . basename($photo);
            $ph_check = 1;
            if (move_uploaded_file($temp, $target)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Failed to upload image";
            }
        }
        if ($ph_check == 1) {
            $table = "images";
            $set = "image = '$photo', album_id ='$al_id'";
            $where = "WHERE id = '$im_id'";
            $result = $this->database->update($table, $set, $where);
            $st = 5;
        } else {
            $table = "images";
            $set = "album_id ='$al_id'";
            $where = "WHERE id = '$im_id'";
            $result = $this->database->update($table, $set, $where);
            $st = 5;
        }
        $target = "../view/editphoto.php?status=" . $st . '&imid=' . $im_id . '&al=' . $return;
        header("Location: $target");
    }

}

$gellaryControl = new GellaryControl();

$database = new Database();

if (isset($_GET['flagimg'])) {
    $gellaryControl->deleteImg();
}
if (isset($_GET['flag'])) {
    $gellaryControl->deleteAlbum();
}
if (isset($_POST['Cancel'])) {
    header("Location: editgellary.php");
}
if (isset($_POST['submit_gedit'])) {
    $gellaryControl->gellaryEdit();
}
if (isset($_POST['upload_album'])) {
    $gellaryControl->createAlbum();
}
if (isset($_POST['upoad_photo'])) {
    $gellaryControl->uploadPhoto();
}

$alname = $_POST['album'];
$im_id = $_POST['im_id'];
$return = $_POST['prev'];
$select = "id";
$table = "album";
$where = "WHERE album_name='$alname'";
$extention = "";
$result = $database->select($select, $table, $where, $extention);
$row = mysqli_fetch_assoc($result);
$al_id = $row['id'];
if (isset($_POST['cancel_img_edit'])) {
    $target = "editphoto.php?al_id=" . $al_id;
    header("Location: $target");
}
if (isset($_POST['confirm_img_edit'])) {
    $gellaryControl->editImg($alname, $im_id, $return, $al_id);
}
?>