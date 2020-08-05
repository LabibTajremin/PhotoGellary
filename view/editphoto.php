<!DOCTYPE html>
<html>
    <title>Edit Photo</title>
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
                <form  action="upload.php">
                    <input type="submit" value="Add new photo" name="Create"  class = "Create" >
                </form>
                <div class="photo_table">
                    <?php
                    require_once '../controller/database.php';
                    $database = new Database();
                    $limit = 2;
                    if (isset($_GET["page"])) {
                        $pn = $_GET["page"];
                    } else {
                        $pn = 1;
                    };
                    $next = $pn + 1;
                    $prev = $pn - 1;
                    $start_from = ($pn - 1) * $limit;
                    $sl_no = ($pn - 1) * $limit;
                    $pre = 0;
                    if (isset($_GET['al'])) {
                        $id = $_GET['al'];
                        if (isset($_GET['imid'])) {
                            $pre = $_GET['imid'];
                        }
                    } else {
                        $id = $_GET['al_id'];
                    }
                    $nxtal = $id;
                    $tprev = "editphoto.php?page=" . $prev . "&al=" . $id;
                    $tnext = "editphoto.php?page=" . $next . "&al=" . $id;
                    $select = "*";
                    $table = "images";
                    $where = "where album_id= '$id' OR id='$pre'";
                    $extention = "LIMIT $start_from, $limit";
                    $result = $database->select($select, $table, $where, $extention);
                    ?>
                    <table>
                        <tr>
                            <th>Serial No.</th>
                            <th>Photo</th>
                            <th>Album Name</th>
                            <th colspan="2" >Action</th>
                        </tr>
                        <?php
                        if (!empty($result)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $alid = $row['album_id'];
                                $select = "album_name";
                                $table = "album";
                                $where = "where id= '$alid'";
                                $extention = "";
                                $result2 = $database->select($select, $table, $where, $extention);
                                $row2 = mysqli_fetch_assoc($result2);
                                $alname = $row2['album_name'];
                                $sl_no = $sl_no + 1;
                                $src = "../images/albumimage/" . $row['image'];
                                $im_id = $row['id'];
                                $targetdel = "../controller/gellarycontrol.php?id=" . $im_id . "&flagimg=1";
                                if ($alid != $nxtal) {
                                    $targetedit = "editimg.php?id=" . $im_id . '&al=' . $nxtal;
                                } else {
                                    $targetedit = "editimg.php?id=" . $im_id;
                                }
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
                $table = "images";
                $where = "where album_id= '$id' OR id='$pre'";
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
                            $tf = "editphoto.php?page=1" . "&al=" . $id;
                            ?>
                            <a href=<?php echo $tf ?>>First</a>
                            <a>.....</a>

                            <?php
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $pn) {
                                $t = "editphoto.php?page=" . $i . "&al=" . $id;
                                ?>
                                <a class="active" href=<?php echo $t; ?>><?php echo $i ?></a>
                                <?php
                            } elseif ($i == ($pn + 1) || $i == ($pn - 1)) {
                                $t = "editphoto.php?page=" . $i . "&al=" . $id;
                                ?>
                                <a href=<?php echo $t ?>><?php echo $i ?></a>
                                <?php
                            } elseif ($i <= $total_pages && $i > $pn) {

                                $ex = 1;
                            }
                        }
                        if ($ex == 1 && ($pn != $total_pages || $pn != $total_pages - 1)) {
                            $tl = "editphoto.php?page=" . $total_pages . "&al=" . $id;
                            ?>
                            <a>.....</a>
                            <a href=<?php echo $tl ?>>Last</a>
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

    </body>
</html>
