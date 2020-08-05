<!DOCTYPE html>
<html>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <?php
        $check = 2;
        require_once '../controller/database.php';
        $database = new Database();
        if (isset($_GET['q'])) {
            $stmt = $_GET['q'];
            $S = 0;
            if ($stmt != "NULL") {
                $S = 1;
                $select = "id";
                $table = "division";
                $where = "where divition_name = '$stmt'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                if (!empty($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row["id"];
                    }
                }
                $select = "district_name";
                $table = "district";
                $where = "where divition_id = '$id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
            }
        }
        if ($S == 1) {
            ?>
            <div class="selection" >
                <label>District</label>
                <select name = "dist" onchange="showthana(this.value)"  >
                    <option value="">Select a district</option>
                    <?php
                    if (!empty($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $row["district_name"] ?>" ><?php echo $row["district_name"] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select> <br>
            <?php }
            ?>
        </div>          
    </body>
</html>