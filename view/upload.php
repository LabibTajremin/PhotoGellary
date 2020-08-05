<!DOCTYPE html>
<html>
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <?php
        require_once '../controller/database.php';
        $database = new Database();
        ?>

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
        <div class=" msg"></div>
        <div class="main"> 
            <div class="menu"><ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <li><a href="regmain.php">Registration</a></li>
                    <li><a class="active" href="upload.php">Upload</a></li>
                    <li><a href="user.php">User Info</a></li>
                </ul></div>

            <div class="content" >
                <h1>Upload Photos</h1>
                <div id="msg" class="msg"> 
                    <?php
                    if (isset($_GET['status1']) == 1) {
                        $st = $_GET['status1'];
                        if ($st == 1) {
                            ?>
                            <div class="success">Uploaded successfully</div><br>
                        <?php } else {
                            ?>
                            <div class="failed">Failed to Upload</div><br>
                            <?php
                        }
                    }
                    if (isset($_GET['status2']) == 1) {
                        $st = $_GET['status2'];
                        if ($st == 1) {
                            ?>
                            <div class="success">Album created successfully</div><br>
                        <?php } else {
                            ?>
                            <div class="failed">Album creation failed</div><br>
                            <?php
                        }
                    }
                    ?>
                </div>


                <form action="../controller/gellarycontrol.php" method="Post" enctype="multipart/form-data" >
                    <div class="selection">
                        <select name="album" required>
                            <option value="">Select a album </option>
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

                        <label for="al_name" style="font-family:sans-serif; font-size:30px;   ">Upload image</label><br><br>
                        <input type="file" name="image[]" multiple><br><br><br>
                        <input type="submit" class = "Submit" value="Upload" name="upoad_photo"><br><br><br>

                    </div>
                </form><br><br>
                <form action="../controller/gellarycontrol.php" method="Post" >
                    <label for="al_name" style="font-family:sans-serif; font-size:30px;   ">Create an album</label><br><br>
                    <input type="text" id="al_name" name="al_name" placeholder="Enter album name"><br><br><br>
                    <input type="submit" class = "Submit" value="Create" name="upload_album" >
                </form>
            </div>
        </div>
        <div class="footer"><footer><br>
                <pr>© Labib Tajremin</pr><br>
                2020
            </footer></div>
    </body>
</html>
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

