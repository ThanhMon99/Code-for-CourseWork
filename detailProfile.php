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
$date = $r['Dob'];
$dob = date('j F, Y', strtotime($date));
?>
<html lang="en">
    <?php require_once('Form/head_section.php') ?>  
    <body>
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        </br>

        <div>

            <h2 align="left">General Info</h2>
            <hr  width="45%" align="left" />
            <ul align="left" style="font-size: 20px">
                <li><span>Full Name: </span><?php echo $r['fullname']; ?></li>
                <li><span>Date of Birth: </span><?php echo $dob; ?></li>
                <li><span>Address: </span><?php echo $r['Address']; ?></li>
                <li><span>E-mail: </span><?php echo $r['Email']; ?></li>
                <li><span>Description: </span><?php echo $r['Description']; ?></li>
            </ul>
            <hr  width="45%" align="left" />
            <button class="btn btn-info"><a href='profile.php'>Back</a></button>

        </div>

        <?php require_once('Form/footer.php') ?>
    </body>
</html>
