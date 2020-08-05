<!DOCTYPE html>
<html>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <body>
        <div class="header"><header>
            </header></div>
        <div class="main"> 
            <div class="menu"><ul id="sidemenu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="gellary.php">Gallery</a></li>

                </ul></div>
            <div class="content" >
                <h2>Login</h2>
                <div class="logincard">

                    <form action="../controller/actionpagelogin.php" method="Post"  >
                        <label for="uname" id="unamel" >Username</label><br>
                        <input type="text" id="uname" name="uname" placeholder="username" required><br><br>
                        <label for="lname" id="unamel">Password</label><br>
                        <input type="password" id="pass" name="password"  required><br><br>


                        <input type="submit" value="login" class = "log"  >
                    </form>
                </div>
            </div>
        </div>
        <div class="footer"><footer>
                <br>
                <pr>© Labib Tajremin</pr><br>
                2020
            </footer></div>
    </body>
</html>
