<?php
session_start();
require_once("connect.php");
?>
<?php
$id = -1;
if (isset($_GET["id"])) {
    $id = intval($_GET['id']);
}
$stmt = $conn->prepare("select * from account where id = $id");
$stmt->execute();
$r = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<html lang="en">
    <?php require_once('Form/head_section.php') ?>  
    <?php require_once('Form/css/style.php') ?> 
    <style>
        .form-control {
            width: 100%;
        }
        .multiselect-container {
            box-shadow: 0 3px 12px rgba(0,0,0,.175);
            margin: 0;
        }
        .multiselect-container .checkbox {
            margin: 0;
        }
        .multiselect-container li {
            margin: 0;
            padding: 0;
            line-height: 0;
        }
        .multiselect-container li a {
            line-height: 25px;
            margin: 0;
            padding:0 35px;
        }
        .custom-btn {
            width: 100% !important;
        }
        .custom-btn .btn, .custom-multi {
            text-align: left;
            width: 100% !important;
        }
        .dropdown-menu > .active > a:hover {
            color:inherit;
        }
    </style>
    <body>
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        </br>

        <div>

            <h2 align="left">Role of <?php echo $r['username']; ?> is <?php echo $r['role']; ?></h2>
            <hr  width="45%" align="left" />
            <form method="post" class="form-horizontal">
                <label>Select Role</label>
                <select name="Role" class="dropdown">
                    <option value="">Select...</option>
                    <option value="Admin">Admin</option>
                    <option value="Staff">Staff</option>
                    <option value="Tutor">Tutor</option>
                    <option value="Student">Student</option>
                </select>
                <div class="form-group">
                    </br></br>
                <div  class="col-lg-offset-2 col-lg-10">
                    <input type="submit" class="btn btn-theme" value="Update" name="submit"/>
                    <button class="btn btn-theme"><a href='profile.php'>Back</a></button>
                </div>
            </div>
            </form>
                   <hr  width="45%" align="left" />
        </div>

        <?php require_once('Form/footer.php') ?>
    </body>
</html>
 <?php
    if (isset($_POST['submit'])) {
        $role = $_POST['Role'];

        $stmt = $conn->prepare("UPDATE account  SET role = '$role' where id = '$id'");
        $pdoResult = $stmt->execute();


        if ($pdoResult) {
//            echo "<div class='alert alert-success'><a href= 'profile.php'><b>Successfully   </b></a></div>";
            $URL = "http://localhost/ASMtest/profile.php";
                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        } else
            echo "<div class='alert alert-danger'><b>error. <a href='profile.php'>Back</a></b></div>";

    }
    ?>