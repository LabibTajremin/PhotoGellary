<!DOCTYPE html>
<html>
    <title>Edit Gallery</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../style/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
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
                <form  action="upload.php">
                    <input type="submit" value="Create New Album" name="Create"  class = "Create" >
                </form>
                <div class="photo_table">

                    <table>
                        <tr>
                            <th>Serial No.</th>
                            <th>Photo</th>
                            <th>Album Name</th>
                            <th colspan="2" >Action</th>
                        </tr>
                        <?php
                        require_once '../controller/database.php';
                        $database = new Database();
                        $limit = 1;
                        if (isset($_GET["page"])) {
                            $pn = $_GET["page"];
                        } else {
                            $pn = 1;
                        };
                        $next = $pn + 1;
                        $prev = $pn - 1;
                        $tprev = "editgellary.php?page=" . $prev;
                        $tnext = "editgellary.php?page=" . $next;
                        $start_from = ($pn - 1) * $limit;
                        $sl_no = ($pn - 1) * $limit;
                        $select = "*";
                        $table = "album";
                        $where = "";
                        $extention = "LIMIT $start_from, $limit";
                        $result = $database->select($select, $table, $where, $extention);
                        if (!empty($result)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sl_no = $sl_no + 1;
                                $alname = $row['album_name'];
                                $id = $row['id'];
                                $select = "*";
                                $table = "images";
                                $where = "where album_id= '$id'";
                                $extention = "LIMIT 1";
                                $result2 = $database->select($select, $table, $where, $extention);
                                $row2 = mysqli_fetch_assoc($result2);
                                $src = "../images/albumimage/" . $row2['image'];
                                $im_id = $row2['id'];
                                $targetdel = "../controller/gellarycontrol.php?id=" . $id . "&flag=1";
                                $targetedit = "editgelform.php?id=" . $id;
                                ?>
                                <tr>
                                    <td><?php echo $sl_no ?></td>
                                    <td><img src=<?php echo $src ?> . width = "150px"  height="100px"></td>
                                    <td> <?php echo $alname ?> </td>
                                    <td> <button class="btn" onclick="window.location.href = '<?php echo $targetedit ?>'"> <i class="fa fa-edit"></i></button></td>  
                                    <td><button class="dltbtn"  onclick="window.location.href = '<?php echo $targetdel ?>'"><i class="fa fa-trash"></i></button></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div><br>
                <?php
                $select = "COUNT(*) AS num";
                $table = "album";
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
                        $ex = 0;
                        if ($pn > 1) {
                            ?>
                            <a href=<?php echo $tprev; ?>> <i class='fas fa-caret-square-left' style='font-size:10px'> </i> Previous</a>
                            <?php
                        }
                        if ($pn > 2) {
                            $tf = "editgellary.php?page=1";
                            ?>
                            <a href=<?php echo $tf ?>>First</a>
                            <a>.....</a>
                            <?php
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $pn) {
                                $t = "editgellary.php?page=" . $i;
                                ?>
                                <a class="active" href=<?php echo $t; ?>><?php echo $i ?></a>
                                <?php
                            } elseif ($i == ($pn + 1) || $i == ($pn - 1)) {
                                $t = "editgellary.php?page=" . $i;
                                ?>
                                <a href=<?php echo $t ?>><?php echo $i ?></a>
                                <?php
                            } elseif ($i <= $total_pages && $i > $pn) {

                                $ex = 1;
                            }
                        }
                        if ($ex == 1 && ($pn != $total_pages || $pn != $total_pages - 1)) {
                            $t = "editgellary.php?page=" . $total_pages;
                            ?>
                            <a>.....</a>
                            <a href=<?php echo $t ?>>Last</a>
                            <?php
                        }
                        if ($pn != $total_pages) {
                            ?>       
                            <a href=<?php echo $tnext; ?>>Next  <i class='fas fa-caret-square-right' style='font-size:10px'> </i></a>  
                        <?php }
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