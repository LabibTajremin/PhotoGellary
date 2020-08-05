<!DOCTYPE html>
<html>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <?php
        require_once '../controller/database.php';
        $database = new Database();
        $stmt = '';
        if (!empty($_GET['q'])) {
            $stmt = $_GET['q'];
        }
        if ($stmt != NULL) {
            $select = "id";
            $table = "district";
            $where = "where district_name = '$stmt'";
            $extention = "";
            $result = $database->select($select, $table, $where, $extention);
            $id = 0;
            if (!empty($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["id"];
                }
            }
            $select = "Thana_name";
            $table = "thana";
            $where = "where district_id = '$id'";
            $extention = "";
            $result = $database->select($select, $table, $where, $extention);
            ?>
            <div class="selection" ">
                <label>Thana</label>
                <select name = "thana"onchange="showbox(this.value)" >
                    <option value="NULL">Select a thana</option>
                    <?php
                    if (!empty($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>

                            <option value="<?php echo $row["Thana_name"] ?>" ><?php echo $row["Thana_name"] ?></option>
                            <?php
                        }
                    }
                    ?> 
                </select> <br>
                <?php
            }
            ?>
        </div>          
    </body>
</html>