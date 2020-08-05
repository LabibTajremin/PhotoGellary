<!DOCTYPE html>
<html>
    <title>Gallery</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <header class="header">
            <div class="container">
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
            </div>
        </header>
        <div class="main"> 
            <div class="menu">
                <ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a class="active" href="gellary.php">Gallery</a></li>
                    <?php if ($session == 1) {
                        ?>
                        <li><a href="regmain.php">Registration</a></li>
                        <li><a href="upload.php">Upload</a></li>
                        <li><a href="user.php">User Info</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="content" >
                <div class="pagetitle">
                    <h1>Gallery</h1>
                </div>
                <?php if ($session == 1) { ?>
                    <form  action="editgellary.php">
                        <input type="submit" value="Edit" name="Create"  class = "Edit" >
                    </form>
                <?php } ?>
                <div class="msg" id="msg">
                    <?php
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
                            <div class="success">Updated successfully !! </div><br>
                        <?php } elseif ($st == 4) {
                            ?>
                            <div class="success">Deleted successfully !! </div><br>
                        <?php } elseif ($st == 6) {
                            ?>
                            <div class="failed">Failed to update !! </div><br>
                        <?php } else {
                            ?>
                            <div class="failed">Failed to Delete</div><br>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
                require_once '../controller/database.php';
                $database = new Database();
                $select = "*";
                $table = "album";
                $where = "";
                $extention = "";
                $result = $database->select($select, $table, $where, $extention);
                if (!empty($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="imageshow">
                            <?php
                            $id = $row['id'];
                            $select = "*";
                            $table = "images";
                            $where = "where album_id= '$id'";
                            $extention = "LIMIT 1";
                            $result2 = $database->select($select, $table, $where, $extention);
                            $row2 = mysqli_fetch_assoc($result2);
                            $source = "../images/albumimage/" . $row2['image'];
                            $target = "showphotos.php?id=" . $id;
                            ?>
                            <a href = <?php echo $target ?> > <img src=<?php echo $source ?> . width = "30%"> </a>
                            <div class="imagelabel"><?php echo $row['album_name']; ?></div>
                        </div>
                        <?PHP
                    }
                }
                ?>
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