<?php
session_start();
include('connect.php');
include('checkLogin.php');
?>
<html lang="en">
    <?php require_once('Form/head_section.php') ?>  
    <body>
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        </br>
        <br />
        <div class="table-responsive">
            <h4 align="center">Edit your profile</h4>
        </div>
        <br />
        <?php
        $id = $_SESSION['id'];
        $stmt = $conn->prepare("SELECT * FROM account WHERE id ='$id'");
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <form method="post" class="form-horizontal">
<!--          <div class="form-group">
                <label class="col-lg-2 control-label"> Avatar</label>
                <div class="col-lg-6">
                    <input type="file" name="files" value="">
                </div>
            </div>-->
            <div class="form-group">
                <label class="col-lg-2 control-label">Date of birth</label>
                <div class="col-lg-6">
                    <input type="date" name="date" class="form-control" value="<?php echo $r['Dob']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Full Name</label>
                <div class="col-lg-6">
                    <input type="text" name="fullname" class="form-control"  value="<?php echo $r['fullname']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Email</label>
                <div class="col-lg-6">
                    <input type="text" name="email" class="form-control"  value="<?php echo $r['Email']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Lives In</label>
                <div class="col-lg-6">
                    <input type="text" name="address" class="form-control" value="<?php echo $r['Address']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Description</label>
                <div class="col-lg-10">
                    <textarea rows="10" cols="20" class="form-control" name="description" ><?php echo $r['Description']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <input type="submit" class="btn btn-theme" value="Update" name="submit"/>
                </div>
            </div>
        </form>
        <?php
    if (isset($_POST['submit'])) {

        $dob = $_POST['date'];
        $mail = $_POST['email'];
        $add = $_POST['address'];
        $name = $_POST['fullname'];
        $des = $_POST['description'];

        $stmt = $conn->prepare("UPDATE account  SET Dob = '$dob',Email = '$mail',Address = '$add',fullname = '$name',Description= '$des' where id = '$id'");
        $pdoResult = $stmt->execute();


        if ($pdoResult) {
            echo "<div class='alert alert-success'><a href= 'profile.php'><b>Successfully   </b></a></div>";
    //        $URL = "http://localhost/ASMtest/profile.php";
    //            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    //            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        } else
            echo "<div class='alert alert-danger'><b>error. <a href='profile.php'>Back</a></b></div>";

    }
    ?>
            <?php require_once('Form/footer.php') ?>
    </body>
</html>
