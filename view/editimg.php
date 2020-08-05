<!DOCTYPE html>
<html>
    <title>Edit Photo</title>
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
            <div class="menu"><ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <li><a href="regmain.php">Registration</a></li>
                    <li><a href="upload.php">Upload</a></li>
                    <li><a href="user.php">User Info</a></li>
                </ul></div>
            <div class="content" >
                <div id="image" class="imagebox">
                    <?php
                    $im_id = $_GET['id'];
                    require_once '../controller/database.php';
                    $database = new Database();
                    $select = "*";
                    $table = "images";
                    $where = "WHERE id='$im_id'";
                    $extention = "";
                    $result = $database->select($select, $table, $where, $extention);
                    $row = mysqli_fetch_assoc($result);
                    $src = "../images/albumimage/" . $row['image'];
                    $albumId = $row['album_id'];
                    $select = "*";
                    $table = "album";
                    $where = "WHERE id='$albumId'";
                    $extention = "";
                    $result = $database->select($select, $table, $where, $extention);
                    $row = mysqli_fetch_assoc($result);
                    $al_name = $row['album_name'];
                    $prev = $albumId;
                    if (isset($_GET['al'])) {
                        $prev = $_GET['al'];
                    }
                    ?>
                    <form action="../controller/gellarycontrol.php" method="Post" enctype="multipart/form-data" >
                        <input type="hidden" id="prev" name="prev" value=<?php echo $prev; ?> >
                        <input type="hidden" id="al_id" name="al_id" value=<?php echo $albumId; ?> >
                        <img src=<?php echo $src ?> . width = "500px" height="300px" id="img_urlgl" alt="your image"><br>
                        <input type="file" id="photo"  name="photo" onChange="img_pathUrl(this);"><br><br>
                        <input type="hidden" id="im_id" name="im_id" value=<?php echo $im_id ?> >
                        <div class="albumselection">
                            <div class="selection">
                                <select name="album">
                                    <option value=<?php echo $al_name ?>><?php echo $al_name ?> </option>
                                    <?php
                                    $select = "album_name";
                                    $table = "album";
                                    $where = "";
                                    $extention = "";
                                    $result = $database->select($select, $table, $where, $extention);
                                    if (!empty($result)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row["album_name"] ?> "><?php echo $row["album_name"] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select><br><br><br>
                            </div>
                        </div>
                        <input type="submit" value="Confirm" class = "Submit" name="confirm_img_edit" onchange="showmsg()" >
                        <input type="submit" value="Cancel" name="cancel_img_edit" class = "Cancel" >
                    </form>
                </div>

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

                                $('#img_urlgl')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
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
        </script>
    </body>
</html>

