<?php
session_start();
include('connect.php');
include('checkLogin.php');
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
    <style>
        #bodyid #container{
            background-image: url("Form/img/back.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        #divid{
            color: black;
            background-color: whitesmoke;
        }
        
    </style>
    <?php require_once('Form/head_section.php') ?>  
    <body id="bodyid">
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <a class="weatherwidget-io" href="https://forecast7.com/en/14d06108d28/vietnam/" data-label_1="VIET NAM" data-label_2="WEATHER" data-theme="original" >VIET NAM WEATHER</a>
        
        <?php 
        if ($role == 'Tutor' || $role == 'Student') { ?>
            </br>
            <div >
                </br>
                <?php if ($role == 'Tutor') { ?>
                    <h2 align="center">Your Student</h2>
                <?php } ?>
                <?php if ($role == 'Student') { ?>
                    <h2 align="center">Meeting for you</h2>
                    <table class="table table-bordered table-striped" style="width:70%" align="center" id="divid">
                    <tr>
                        <th width="30%">Date</th>
                        <th width="5%">Status</th>
                    </tr>
                    <?php
                    $statement1 = $conn->prepare("SELECT * FROM allocate WHERE studentid = '" . $_SESSION['id'] . "' ");

                    $statement1->execute();

                    $result1 = $statement1->fetch(PDO::FETCH_ASSOC);
                    
                    $acid = $result1['acid'];
                    $statement2 = $conn->prepare("SELECT * FROM meeting WHERE AllocateID = '$acid' ");
                                   
                    $statement2->execute();

                    $result2 = $statement2->fetch(PDO::FETCH_ASSOC);
                    if($result2){
            ?>      
                        <tr>
                            <td><?php echo $result2['Date']; ?></td>
                            <td><?php if($result2['Date_end'] != ''){ echo 'Available !';} else {echo 'End';} ?></td>
                        </tr>
                        
                <?php }?>
                </table>
                    </br>
                    <h2 align="center">Your Tutor</h2>
                <?php } ?>
                <table class="table table-bordered table-striped" style="width:70%" align="center" id="divid">
                    <tr>
                        <th width="30%">Username</th>
                        <th width="5%">Detail</th>
                    </tr>
                    <?php foreach ($result as $row) { ?>     


                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><button class="btn btn-info" ><a href="detailProfile.php?id=<?php echo $row["id"]; ?>">Detail</a></button></td>
                        </tr>
                        
                    <?php } ?>
                </table>
            </div>
        <?php } ?>

        <?php require_once('Form/footer.php') ?>
    </body>
</html>
<script>
    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://weatherwidget.io/js/widget.min.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, 'script', 'weatherwidget-io-js');
    
</script>
