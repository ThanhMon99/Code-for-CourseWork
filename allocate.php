<?php
session_start();
include('connect.php');
include('checkLogin.php');

?>
<html>  
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
    <body >  
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <div class="container">
            <br />
            <div class="table-responsive">
                <h4 align="center">Allocate</h4>
            </div>
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">Selecting</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group" id ="mainselection" >
                            <label>Select Tutor</label>
                            <select name="Tutor" class="dropdown">
                                <option value="">Select...</option>
                                <?php
                                $query = "SELECT * FROM account WHERE role = 'tutor'";

                                $statement = $conn->prepare($query);

                                $statement->execute();

                                $result = $statement->fetchAll();
                                foreach ($result as $row) {
                                    $Tutorid = $row['id'];
                                    $Tutorname = $row['username'];
                                    echo "<option value='$Tutorid'>$Tutorname</option>";
                                }
                                ?>
                            </select>    
                        </div>
                        <div class="form-group">
                            <label>Select Student</label>
                            <select name="Student[]" multiple="multiple" class="multiselect" role="multiselect">

                                <?php
                                $query = "SELECT * FROM account WHERE role = 'student'";

                                $statement = $conn->prepare($query);

                                $statement->execute();

                                $result = $statement->fetchAll();
                                $i = 0;
                                foreach ($result as $row) {
                                    $Studentid = $row['id'];
                                    $stat = $conn->prepare("SELECT * FROM allocate WHERE studentid = '$Studentid'");
                                    $stat->execute();
                                    if ($stat->rowCount() == 0) {
                                    $Studentname = $row['username'];
                                    echo "<option value='$Studentid'>$Studentname</option>";
                                    }
                                }
                                ?>
                            </select>    
                        </div>


                        <div class="form-group">
                            <input type="submit" name="add" class="btn btn-info" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['Tutor']) && isset($_POST['Student'])) {
            include('connect.php');

//            $Studentid = $_POST['Student'];
            $Tutorid = $_POST['Tutor'];

            foreach ($_POST['Student'] as $id) {
                $Studentid = $id;
                $statement1 = $conn->prepare("SELECT * FROM allocate WHERE studentid = '$Studentid' and tutorid = '$Tutorid' ");

               
                $statement1->execute();
               
                $check = 'yes';
        
                if ($statement1->rowCount() > 0) {
                    $check = 'no';
                }
                
                $st = $conn->prepare("SELECT * FROM account WHERE id = '$Studentid'");
                $st->execute();
                $res = $st->fetch(PDO::FETCH_ASSOC);
                $stname = $res['username'];
                $stEmail = $res['Email'];       

                $st1 = $conn->prepare("SELECT * FROM account WHERE id = '$Tutorid'");
                $st1->execute();
                $res1 = $st1->fetch(PDO::FETCH_ASSOC);
                $ttname = $res1['username'];

                if ($check == 'yes') {
//                            $to_email = "thanhnguyenduy2610@gmail.com";
//                            $subject = "Simple Email Test via PHP";
//                            $body = "Hi,nn This is test email send by PHP Script";
//                            $headers = "From: sender\'s email";
//
//                            if (mail($to_email, $subject, $body, $headers)) {
//                                echo "Email successfully sent to $to_email...";
//                            } else
//                                echo "Email sending failed...";
                            
                    
                            $stmt = $conn->prepare("INSERT INTO allocate (studentid, tutorid) VALUE ('{$Studentid}', '{$Tutorid}')");
                            $pdoResult = $stmt->execute();
                        
                        if ($pdoResult)
                            echo "<div class='alert alert-success'><b>Adding success</b></div>";
                        else
                            echo "<div class='alert alert-danger'><b>Adding error</b></div>";
                 
                } else {
                    echo"<div class='alert alert-danger'><b>Already have this allocate</b></div>";
                }
            }
        }

        $query1 = "SELECT * FROM allocate";

        $statement = $conn->prepare($query1);

        $statement->execute();

        $result = $statement->fetchAll();

        $output = '
<table class="table table-bordered table-striped">
 <tr>
  <th width="30%">Numerical order</td>
  <th width="30%">Tutor</td>
  <th width="30%">student</td>
  <th width="10%">Option</td>
 </tr>
';
        $i = 0;
        foreach ($result as $row) {
            $i ++;
// get student name
            $stmt = $conn->prepare("SELECT * FROM account where id = '" . $row['studentid'] . "'");
            $stmt->execute();
            $row1 = $stmt->fetch(PDO::FETCH_ASSOC);

/// get tutor name

            $stmt1 = $conn->prepare("SELECT * FROM account where id = '" . $row['tutorid'] . "'");
            $stmt1->execute();
            $row2 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $output .= '
 <tr>
  <td>' . $i . ' </td>
  <td>' . $row2['username'] . ' </td>
  <td>' . $row1['username'] . ' </td>
  <td>
            <form action="DeleteAllocate.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="acid" value= ' . $row['acid'] . '/>
                <input type="submit" value="Delete" />
            </form>
        </td>
</tr>
 ';
        }

        $output .= '</table>';

        echo $output;
        ?>
        <?php require_once('Form/footer.php') ?>
    </body>  
</html>

<?php require_once('Form/AllocateScript.js') ?>