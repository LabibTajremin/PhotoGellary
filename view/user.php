<!DOCTYPE html>
<html>
    <title>User Details</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
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
                    <li><a href="regmain.php">Registration</a></li>
                    <li><a href="gellary.php">Gallery</a></li>
                    <li><a href="upload.php">Upload</a></li>
                    <li><a class="active" href="user.php">User Info</a></li>
                </ul></div>


            <div class="content" >
                <h1>User Details</h1><br>
                <form  action="regmain.php">
                    <input type="submit" value="Create New User" name="Create"  class = "Create" >
                </form>
                <div id="msg" class="msg">
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

                <div class="usertable">
                    <?php
                    require_once '../controller/database.php';
                    $database = new Database();
                    $limit = 3;
                    if (isset($_GET["page"])) {
                        $pn = $_GET["page"];
                    } else {
                        $pn = 1;
                    };
                    $previous_page = $pn - 1;
                    $next_page = $pn + 1;
                    $start_from = ($pn - 1) * $limit;
                    $sl_no = ($pn - 1) * $limit;

                    $select = "*";
                    $table = "reg";
                    $where = "";
                    $extention = "LIMIT $start_from, $limit";
                    $result = $database->select($select, $table, $where, $extention);
                    ?>

                    <table>
                        <tr>
                            <th>Serial No.</th>
                            <th>Photo</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Address</th>

                            <th colspan="2" >Action</th>
                        </tr>
                        <?php
                        if (!empty($result)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sl_no = $sl_no + 1;
                                $fname = $row['firstname'];
                                $lname = $row['lastname'];
                                $mail = $row['mail'];
                                $pnum = $row['phonenum'];
                                $user = $row['username'];
                                $add = $row['address'];
                                $id = $row['id'];
                                if ($row['photo'] == "") {
                                    $src = "../images/images/nophoto.jpeg";
                                } else {
                                    $src = "../images/images/" . $row['photo'];
                                }

                                $targetdel = "../controller/usercontrol.php?id=" . $id . "&flag=1";
                                $targetedit = "editprf.php?id=" . $id;
                                ?>
                                <tr>
                                    <td><?php echo $sl_no ?></td>
                                    <td><img src=<?php echo $src ?> . width = "50px"  height="52px"></td>
                                    <td><?php echo $fname ?></td>
                                    <td><?php echo $lname ?></td>
                                    <td><?php echo $mail ?></td>
                                    <td><?php echo $user ?></td>
                                    <td><?php echo $pnum ?></td>
                                    <td><?php echo $add ?></td>

                                    <td> <button class="btn" onclick="window.location.href = '<?php echo $targetedit ?>'"> <i class="fa fa-edit"></i></button></td>

                                    <td><button class="dltbtn"  onclick="window.location.href = '<?php echo $targetdel ?>'" ><i class="fa fa-trash"></i></button></td>

                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>   


                </div><br>



                <?php
                $select = " COUNT(*) AS num";
                $table = "reg";
                $where = "";
                $extention = "";
                $rs_result = $database->select($select, $table, $where, $extention);
                $row = mysqli_fetch_assoc($rs_result);
                $total_records = $row['num'];

                // Number of pages required. 
                $total_pages = ceil($total_records / $limit);
                ?>
                <div class="center-content">
                    <div class = "pagination">

                        <?php
                        $next = $pn + 1;
                        $prev = $pn - 1;
                        $tprev = "user.php?page=" . $prev;
                        $tnext = "user.php?page=" . $next;
                        $ex = 0;

                        if ($pn > 1) {
                            ?>
                            <!--for printing  previous button-->
                            <a href=<?php echo $tprev; ?>> <i class='fas fa-caret-square-left' style='font-size:10px'> </i> Previous</a> 

                            <?php
                        }
                        if ($pn > 2) {
                            $tf = "user.php?page=1";
                            ?>
                            <!--for printing  front ......  button-->
                            <a href=<?php echo $tf ?>>First</a>
                            <a>.....</a>

                            <?php
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $pn) {
                                $t = "user.php?page=" . $i;
                                ?>
                                <a class="active" href=<?php echo $t; ?>><?php echo $i ?></a>
                                <?php
                            } elseif ($i == ($pn + 1) || $i == ($pn - 1)) {

                                $t = "user.php?page=" . $i;
                                ?>
                                <a href=<?php echo $t ?>><?php echo $i ?></a>
                                <?php
                            } elseif ($i <= $total_pages && $i > $pn) {

                                $ex = 1;
                            }
                        }
                        if ($ex == 1 && ($pn != $total_pages || $pn != $total_pages - 1)) {
                            $t = "user.php?page=" . $total_pages;
                            ?>
                            <!--for printing  last ......  button-->
                            <a>.....</a>
                            <a href=<?php echo $t ?>>Last</a>
                            <?php
                        }

                        if ($pn != $total_pages) {
                            ?>  
                            <!--for printing  last next button-->
                            <a href=<?php echo $tnext; ?>>Next  <i class='fas fa-caret-square-right' style='font-size:10px'> </i></a>  
                            <?php
                        }
                        ?>

                    </div>
                    <div class="pagenumber">
                        <strong>Page <?php echo $pn . " of " . $total_pages; ?></strong>
                    </div>
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

