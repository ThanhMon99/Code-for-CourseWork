<?php
session_start();
include('connect.php');
include('checkLogin.php');

$id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM account WHERE id ='$id'");
$stmt->execute();
$r = $stmt->fetch(PDO::FETCH_ASSOC);
$date = $r['Dob'];
$dob = date('j F, Y', strtotime($date));

$role = $_SESSION['role'];

if ($role == 'Admin' || $role == 'Staff') {
    $query = "SELECT * FROM account WHERE id != '" . $_SESSION['id'] . "' ";
}

if ($role == 'Tutor') {

    $query = "SELECT id, username, Email FROM account, allocate WHERE id != '" . $_SESSION['id'] . "'  and allocate.tutorid = '" . $_SESSION['id'] . "' and allocate.studentid = id ";
}

if ($role == 'Student') {

    $query = "SELECT id, username, Email FROM account, allocate WHERE id != '" . $_SESSION['id'] . "'  and allocate.studentid = '" . $_SESSION['id'] . "' and allocate.tutorid = id ";
}

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
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
            <button class="btn btn-info"><a href='edit_profile.php'>Edit your's profile</a></button>

        </div>
        </br>
        <div>
            <hr  width="100%" align="left" />
            <h2 align="left">Another user Info</h2>
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="30%">Username</th>
                    <?php if ($_SESSION['role'] == "Admin") { ?>
                        <th width="10%">Role</th>
                    <?php } ?>
                    <th width="5%">Detail</th>
                </tr>
                <?php foreach ($result as $row) { ?>     


                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <?php if ($_SESSION['role'] == "Admin") { ?>
                            <td><?php echo $row['role']; ?></td>
                        <?php } ?>
                        <td>
                            <button class="btn btn-info" ><a href="detailProfile.php?id=<?php echo $row["id"]; ?>">Detail</a></button>
                            <?php if ($_SESSION['role'] == "Admin") { ?>
                                <button class="btn btn-info" ><a href="editrole.php?id=<?php echo $row["id"]; ?>">Set Role</a></button>
                            <?php } ?>
                        </td>
                    </tr>

                <?php } ?>
            </table>
        </div>

        <?php require_once('Form/footer.php') ?>
    </body>
</html>