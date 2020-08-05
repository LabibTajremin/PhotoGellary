<!DOCTYPE html>
<html>
    <title>Edit gallery</title>
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
            <div class="menu"><ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <li><a href="regmain.php">Registration</a></li>
                    <li><a href="upload.php">Upload</a></li>
                    <li><a href="user.php">User Info</a></li>
                </ul></div>
            <div class="content" >
                <?php
                require_once '../controller/database.php';
                $database = new Database();
                $id = $_GET['id'];
                $select = "*";
                $table = "album";
                $where = "WHERE id='$id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                $row = mysqli_fetch_assoc($result);
                $name = $row['album_name'];
                ?>
                <form action="../controller/gellarycontrol.php" method="Post" >
                    <input type="hidden" name="id" value=<?php echo $id ?>>
                    <label for="fname">Album Name</label><br>
                    <input type="text" id="al_name" name="al_name" value=<?php echo $name ?> ><br><br>
                    <input type="submit" value="Submit" class = "Submit" name="submit_gedit" onchange="showmsg()" >
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

                        $(function () {
                            $("#msg").fadeIn(function () {
                                setTimeout(function () {
                                    $("#msg").fadeOut("slow");
                                }, 2500);
                            });

                        });
        </script>
    </body>
</html>