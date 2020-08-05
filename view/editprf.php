<!DOCTYPE html>
<html>
    <title>Edit User Profile</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <div class="header">
            <header> 
                <?php
                session_start();
                $session = 0;
                if (isset($_SESSION["username"])) {
                    $session = 1;
                    $username = $_SESSION['username'];
                    $targetuphoto = "../images/images/" . $_SESSION['photo'];
                    ?>
                    <div class="username">
                        <a href="userprofile.php" ><?php echo $username ?></a>
                    </div>
                    <div class="uphoto">
                        <img src=<?php echo $targetuphoto ?>  >    
                    </div>
                    <form action="../controller/logout.php" method="Post" >
                        <input type="submit" value="Logout" class = "logout" name="logout" > 
                    </form>
                    <?php
                } else {

                    header("Location: home.php");
                }
                ?>
            </header>
        </div>
        <div class="main"> 
            <div class="menu">
                <ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <li><a href="regmain.php">Registration</a></li>
                    <li><a href="upload.php">Upload</a></li>
                    <li><a href="user.php">User Info</a></li>
                </ul>
            </div>
            <div class="content" >
                <h1>Registration</h1><br>
                <div id="msg" class="msg">
                    <?php
                    $sl_no = 0;
                    if (isset($_GET['status']) == 1) {
                        $st = $_GET['status'];
                        if ($st == 1) {
                            ?>
                            <div class="success">Deleted successfully</div><br>
                        <?php } elseif ($st == 3) {
                            ?>
                            <div class="failed">Invalid address !! </div><br>
                        <?php } elseif ($st == 5) {
                            ?>
                            <div class="success">Edited successfully !! </div><br>
                        <?php } elseif ($st == 4) {
                            ?>
                            <div class="success">Deleted successfully !! </div><br>
                        <?php } elseif ($st == 10) {
                            ?>
                            <div class="failed">Password did not match !! </div><br>
                        <?php } else {
                            ?>
                            <div class="failed">Failed to Delete</div><br>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
                $ph = 0;
                $check = 1;
                require_once '../controller/database.php';
                $database = new Database();
                $id = $_GET['id'];
                $select = "*";
                $table = "reg";
                $where = "WHERE id='$id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                if (!empty($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $fname = $row['firstname'];
                        $lname = $row['lastname'];
                        $mail = $row['mail'];
                        $pnum = $row['phonenum'];
                        $add = $row['address'];
                        $id = $row['id'];
                        $pass = $row['password'];
                        $user = $row['username'];
                        $src = "../images/images/" . $row['photo'];
                        $thana = $row['thana_id'];
                    }
                }
                $select = "*";
                $table = "thana";
                $where = "WHERE id='$thana'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                $row = mysqli_fetch_assoc($result);
                $thana_name = $row['Thana_name'];
                $dis_id = $row['district_id'];
                $select = "*";
                $table = "district";
                $where = "WHERE id='$dis_id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                $row = mysqli_fetch_assoc($result);
                $dis_name = $row['district_name'];
                $div_id = $row['divition_id'];
                $select = "*";
                $table = "division";
                $where = "WHERE id='$div_id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                $row = mysqli_fetch_assoc($result);
                $div_name = $row['divition_name'];
                ?>
                <form action="../controller/usercontrol.php" method="Post" enctype="multipart/form-data" >
                    <input type="hidden" name="id" value=<?php echo $id ?>>
                    <input type="hidden" name="ch" value=<?php echo $check ?>>
                    <input type="hidden" name="ph" value=<?php echo $ph ?>>
                    <label for="fname">First name</label><br>
                    <input type="text" id="fname" name="fname" value=<?php echo $fname ?> ><br><br>
                    <label for="lname">Last name</label><br>
                    <input type="text" id="lname" name="lname" value=<?php echo $lname ?> ><br><br>
                    <label for="email">Email address</label><br>
                    <input type="text" id="email" name="email" value=<?php echo $mail ?> ><br><br>
                    <label for="pnumber">Phone Number</label><br>
                    <input type="text" id="pnumber" name="pnumber" value=<?php echo $pnum ?> ><br><br>
                    <label for="pnumber">Username</label><br>
                    <input type="text" id="username" name="username" value=<?php echo $user ?> ><br><br>
                    <label for="pnumber">password</label><br>
                    <input type="password" id="password" name="pass" value=<?php echo $pass ?> ><br><br>
                    <label for="pnumber">Confirm password</label><br>
                    <input type="password" id="password" name="cpass" value=<?php echo $pass ?> ><br><br>
                    <label for="address">Enter your Address</label><br><br>
                    <?php
                    $select = "divition_name";
                    $table = "division";
                    $where = "";
                    $extention = "";
                    $result = $database->select($select, $table, $where, $extention);
                    ?>
                    <div class="selection" >
                        <label>Division</label>
                        <select name="Division" onchange="showdist(this.value)" >
                            <option value=<?php echo $div_name ?> > <?php echo $div_name ?> </option>
                            <option value="" > Select a division </option>
                            <?php
                            if (!empty($result)) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row["divition_name"] ?> "><?php echo $row["divition_name"] ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select> <br><br>
                        <?php
                        $select = "district_name";
                        $table = "district";
                        $where = "where divition_id='$div_id'";
                        $extention = "";
                        $result = $database->select($select, $table, $where, $extention);
                        ?>
                        <div id="dist">
                            <label>District</label>
                            <select name="dist"  onchange="showthana(this.value)"  >
                                <option value=<?php echo $dis_name ?> > <?php echo $dis_name ?> </option>
                                <option value="" > Select a district </option>
                                <?php
                                if (!empty($result)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value=<?php echo $row["district_name"] ?> ><?php echo $row["district_name"] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> <br>
                        </div><br>
                        <div id="thana">
                            <?php
                            $select = "Thana_name";
                            $table = "thana";
                            $where = "where district_id='$dis_id'";
                            $extention = "";
                            $result = $database->select($select, $table, $where, $extention);
                            ?>
                            <label>Thana</label>
                            <select name="thana"  >
                                <option value=<?php echo $thana_name ?> > <?php echo $thana_name ?> </option>
                                <option value="" > Select a thana </option>
                                <?php
                                if (!empty($result)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row["Thana_name"] ?> "><?php echo $row["Thana_name"] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div><br>
                    </div>    
                    <div id="box">
                        <br><input type="text" id="full_add" name="full_add" value=<?php echo $add ?> ><br>
                    </div><br>
                    <label for="photo">Photo:</label><br>
                    <div id="image" class="imagebox">
                        <img src=<?php echo $src ?> . width = "100px" height="150px" id="img_url" alt="your image"><br>
                        <input type="file" id="photo"  name="photo" onChange="img_pathUrl(this);">
                    </div>
                    <br><br>
                    <input type="submit" value="Submit" class = "Submit" name="submit_edit" onchange="showmsg()" >
                    <input type="submit" value="Cancel" name="Cancel" class = "Cancel" >
                </form>
            </div>
        </div>
        <div class="footer"><footer>
                <br>
                <pr>© Labib Tajremin</pr><br>
                2020

            </footer></div>
        <script  src="../js/jquery-3.5.1.min.js"></script>
        <script>

                        function img_pathUrl(input) {

                            $('#img_url')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
                        }

                        $(function () {
                            $("#msg").fadeIn(function () {
                                setTimeout(function () {
                                    $("#msg").fadeOut("slow");
                                }, 2500);
                            });

                        });
                        function showdist(str) {
                            var xhttp;
                            if (str == "") {
                                document.getElementById("dest").innerHTML = "";
                                this.value = 0;
                                showthana(str);
                                return;
                            }
                            xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("dist").innerHTML = this.responseText;
                                    showthana(str);
                                }
                            };
                            xhttp.open("GET", "reg2.php?q=" + str, true);
                            xhttp.send();
                        }

                        function showthana(str) {
                            var xhttp;
                            if (str == "") {
                                document.getElementById("thana").innerHTML = "";
                                this.value = 0;
                                showbox(str);
                                return;
                            }
                            xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("thana").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("GET", "reg3.php?q=" + str, true);
                            xhttp.send();
                        }

                        function showbox(str) {
                            var xhttp;
                            if (str == "") {
                                document.getElementById("box").innerHTML = "";
                                return;
                            }
                            xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("box").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("GET", "reg4.php", true);
                            xhttp.send();
                        }

                        function showmsg() {
                            var xhttp;
                            if (str == "") {
                                document.getElementById("msg").innerHTML = "";
                                return;
                            }
                            xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("msg").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("GET", "reg2.php?q=" + str, true);
                            xhttp.send();
                        }


        </script>
    </body>
</html>