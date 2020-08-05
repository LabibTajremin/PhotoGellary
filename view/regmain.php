<!DOCTYPE html>
<html>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <div class="header"><header> 
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
            </header></div>
        <div class="main"> 
            <div class="menu">
                <ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <li><a class="active" href="regmain.php">Registration</a></li>
                    <li><a href="upload.php">Upload</a></li>
                    <li><a href="user.php">User Info</a></li>
                </ul>
            </div>
            <div class="content" >
                <h1>Registration</h1><br>
                <div class=" msg" id="msg">
                    <?php
                    if (isset($_GET['status']) == 1) {
                        $st = $_GET['status'];
                        if ($st == 1) {
                            ?>
                            <div class="success">Registered successfully</div><br>
                        <?php } elseif ($st == 10) {
                            ?>
                            <div class="failed">Password did not match !!!</div><br>
                        <?php } else {
                            ?>
                            <div class="failed">Registration Failed</div><br>
                            <?php
                        }
                    }
                    ?>
                </div>
                <form action="../controller/usercontrol.php" method="Post" enctype="multipart/form-data"  >
                    <label for="fname">First name</label><br>
                    <input type="text" id="fname" name="fname" placeholder="Enter your first name" required><br><br>
                    <label for="lname">Last name</label><br>
                    <input type="text" id="lname" name="lname" placeholder="Enter your last name" required><br><br>
                    <label for="email">Email address</label><br>
                    <input type="text" id="email" name="email"   placeholder="Enter a valid email address" ><br><br>
                    <label for="pnumber">Phone Number</label><br>
                    <input type="text" id="pnumber" name="pnumber"  placeholder="Enter a valid phone number" ><br><br>
                    <label for="pnumber">Username</label><br>
                    <input type="text" id="username" name="username" placeholder="Enter a valid Username" required><br><br>
                    <label for="pnumber">Password</label><br>
                    <input type="password" id="password" name="pass" placeholder="Enter a password" required><br><br>
                    <label for="pnumber">Confirm Password</label><br>
                    <input type="password" id="password" name="cpass" placeholder="Confirm your password" required><br><br>
                    <label for="address">Enter your Address</label><br><br>
                    <?php
                    require_once '../controller/database.php';
                    $database = new Database();
                    $select = "divition_name";
                    $table = "division";
                    $where = "";
                    $extention = "";
                    $result = $database->select($select, $table, $where, $extention);
                    ?>
                    <div class="selection">
                        <label>Division</label>
                        <select name="division" onchange="showdist(this.value)" >
                            <option value="">Select a division</option>
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
                        <div id="dist"></div><br>
                        <div id="thana"></div><br>
                    </div>    
                    <div id="box"></div><br>

                    <label for="photo">Photo:</label><br>
                    <input type="file" id="photo" name="photo" >
                    <br><br>
                    <input type="submit" value="Submit" name="submit_reg" class = "Submit"  onchange="showmsg()" >
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
                                document.getElementById("dist").innerHTML = "";
                                showthana(str);
                                return;
                            }
                            xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("dist").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("GET", "reg2.php?q=" + str, true);
                            xhttp.send();
//                            var xhttp2 = new XMLHttpRequest();
//                            xhttp2.onreadystatechange = function () {
//                                if (this.readyState == 4 && this.status == 200) {
//                                    document.getElementById("thana").innerHTML = this.responseText;
//                                }
//                            };
//                            xhttp2.open("GET", "reg3.php?q=" + str, true);
//                            xhttp2.send();

                        }



                        function showthana(str) {
                            var xhttp;
                            if (str == "") {
                                document.getElementById("thana").innerHTML = "";
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
