<!DOCTYPE html>
<html>
    <title>Images</title>
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
                    ?>
                    <form action="login.php" method="Post" >
                        <input type="submit" value="Login" class = "login" name="login" > 
                    </form>
                <?php } ?>
            </header></div>
        <div class="main"> 
            <div class="menu"><ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <?php if ($session == 1) {
                        ?>
                        <li><a href="regmain.php">Registration</a></li>
                        <li><a href="upload.php">Upload</a></li>
                        <li><a href="user.php">User Info</a></li>
                    <?php } ?>
                </ul></div>
            <div class="content" >
                <?php
                require_once '../controller/database.php';
                $database = new Database();
                $id = $_GET['id'];
                $select = "*";
                $table = "album";
                $where = "WHERE id= '$id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                $row = mysqli_fetch_assoc($result);
                $alname = $row['album_name'];
                $id = $_GET['id'];
                $select = "*";
                $table = "images";
                $where = "WHERE album_id= '$id'";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                ?>
                <div class="pagetitle">
                    <h1><?Php echo $alname ?></h1>
                </div>
                <?php if ($session == 1) { ?>
                    <form  action="editphoto.php">
                        <input type="submit" value="Edit" name="Create"  class = "Edit" >
                        <input type="hidden" value=<?php echo $id ?> name="al_id"></input>
                    </form>


                <?php } ?>


                <div class="al_images">

                    <?php
                    if (!empty($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $target = "../images/albumimage/" . $row['image'];
                            ?>
                            <img src=<?php echo $target ?> . width = "275px" height="200px">    
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <footer><br>
            <pr>© Labib Tajremin</pr><br>
            2020

        </footer>
    </div>
</body>
</html>