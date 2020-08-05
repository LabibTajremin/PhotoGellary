
<?php
session_start();
$user = $_SESSION["username"];
$photo = $_SESSION['photo'];
$fname = $_SESSION["fname"];
$lname = $_SESSION["lname"];
$mail = $_SESSION["mail"];
$phone = $_SESSION["phone"];
$divition = $_SESSION["divition"];
$district = $_SESSION["district"];
$thana = $_SESSION["thana"];
$address = $_SESSION["address"];
$id = $_SESSION['id'];
$src = "../images/images/" . $photo;
$targetedit = "editprf.php?id=" . $id;
?>


<!DOCTYPE html>
<html>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <body>
        <div class="header"><header>
                <?php
                if (isset($_SESSION["username"])) {
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
                <h2>User profile</h2>
                <div class="profileimage">
                    <img src=<?php echo $src ?> >
                </div>
                <p><strong>First name : </strong><?php echo $fname ?></p>
                <p><strong>last name : </strong><?php echo $lname ?></p>
                <p><strong>Username : </strong><?php echo $user ?></p>
                <p><strong>Email address : </strong><?php echo $mail ?></p>
                <p><strong>Phone number : </strong><?php echo $phone ?></p>
                <p><strong>division : </strong><?php echo $divition ?></p>
                <p><strong>District : </strong><?php echo $district ?></p>
                <p><strong>Thana : </strong><?php echo $thana ?></p>
                <p><strong>Address : </strong><?php echo $address ?></p>

                <button class="btn" onclick="window.location.href = '<?php echo $targetedit ?>'"> <i class="fa fa-edit">   Edit profile</i></button>

            </div>
        </div>

        <div class="footer"><footer>
                <br>
                <pr>© Labib Tajremin</pr><br>
                2020
            </footer></div>

    </body>
</html>
