<!DOCTYPE html>
<html>
    <title>Home</title>
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
                    ?>
                    <form action="login.php" method="Post" >
                        <input type="submit" value="Login" class = "login" name="login" > 
                    </form>
                <?php } ?>
            </header>
        </div>
        <div class="main"> 
            <div class="menu" id="menu"><ul id="sidemenu">
                    <li class="bar" ><a class="active" href="home.php">Home</a></li>
                    <li class="bar"><a href="gellary.php">Gallery</a></li>
                    <?php if ($session == 1) {
                        ?>
                        <li class="bar"><a href="regmain.php">Registration</a></li>
                        <li class="bar"><a href="upload.php">Upload</a></li>
                        <li class="bar"><a href="user.php">User Info</a></li>
                    <?php } ?>
                </ul></div>
            <div class="content" >
                <h1>Welcome</h1>
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
                        <?php } elseif ($st == 7) {
                            ?>
                            <div class="failed">Login failed !! </div><br>
                        <?php } elseif ($st == 8) {
                            ?>
                            <div class="success">login successful !! </div><br>
                        <?php } else {
                            ?>
                            <div class="failed">Failed to Delete</div><br>
                            <?php
                        }
                    }
                    ?>
                </div>
                <p>Just like your home, your home page needs to communicate your look and universe. Visitors should immediately recognize the items that compose your visual identity, from your logo to your fonts and color palette. Make sure that they align with all your other outlets, both online (social pages, etc.) and offline (business cards, brochures, etc.).
                    Making it your home also means that it should be neat and welcoming. You wouldn’t want your guests to find, at the entrance of your apartment, your cats fighting, in the middle of two months worth of plastic bottles to recycle – right? The same goes for your home page. Don’t overcrowd it with blog articles, your latest news or your Instagram feed. Although it’s tempting to put these items front and center, you have to know that they prevent your visitors from browsing your website further.
                    They nailed it: From the classy logo to the stunning background image, these radiant photographers provided some good </p>
                <P>A mistake made too often by photographers is to simply put a beautiful image on their home page, hoping that it will do all the talking. But when they only see a bride, how can you expect your visitors (and Google) to know that they have landed on a wedding photographer's portfolio - and not a wedding gown designer? One of the most important items on any home page is a strong, explicit headline that catches the eye of your newcomers. Don’t worry, it doesn’t have to be long - between 3 to 8 words maximum.
                    What should be present on your homepage? A good rule of thumb is to make sure that you’ve answered these three simple questions:
                    Who are you? Whether you go by your own name, your business name, or even a stage name, you have to write it with a large font on the top of your page. Remember that it has to be consistent with the name you use on all your other outlets, otherwise people might have a hard time finding you on Google.
                    What do you do? Your name should be immediately followed by the mention “[X] Photography” or “[X] Photographer”, where [X] is your speciality. Be crystal clear and avoid jargon that only shutterbugs would understand.
                    Where do you operate? Adding your location in the headline is not compulsory, but is still a very good practice. It will not only boost your local SEO, but also help potential clients to see in a blink if you operate within their area.</P><br>
            </div>
        </div>
        <div class="footer"><footer><br>
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
            var header = document.getElementById("menu");
            var btns = header.getElementsByClassName("bar");
            for (var i = 0; i < btns.length; i++) {
                btns[i].addEventListener("click", function () {
                    var current = document.getElementsByClassName("active");
                    if (current.length > 0) {
                        current[0].className = current[0].className.replace(" active", "");
                    }
                    this.className += " active";
                });
            }
        </script>
    </body>
</html>
