<html>  
    <head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Register</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/small logo.png">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-image: url("form/img/back.jpg");      
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        .divider-text {
            position: relative;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .divider-text span {
            padding: 7px;
            font-size: 12px;
            position: relative;   
            z-index: 2;
        }
        .divider-text:after {
            content: "";
            position: absolute;
            width: 100%;
            border-bottom: 1px solid #ddd;
            top: 55%;
            left: 0;
            z-index: 1;
        }
        .register_form {
          height: 470px;
          width: 350px;
          margin-top: auto;
          margin-bottom: auto;
          background: #46a5e8;
          position: relative;
          display: flex;
          justify-content: center;
          flex-direction: column;
          padding: 30px;
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          border-radius: 5px;
        }
        .register_form p{
            color: black;
        }
    </style>
    </head>  
    <body>  
        </br></br></br></br>
        <div class="bg-img">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="register_form">
                    <h4>Register</h4>
                    <form method="post">
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input class="form-control" placeholder="Full name" type="text" name="txtFullname">
                        </div> <!-- form-group// -->
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input class="form-control" placeholder="Username" type="text" name="txtUsername">
                        </div> <!-- form-group// -->
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                             </div>
                            <input class="form-control" placeholder="Email address" type="email" name="txtEmail">
                        </div> <!-- form-group// -->                                         
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            <input class="form-control" placeholder="Create password" type="password" name="txtPassword">
                        </div> <!-- form-group// -->
<!--                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            <input class="form-control" placeholder="Repeat password" type="password">
                        </div>  form-group//                                       -->
                        <div class="form-group">
                            <button type="submit" name="register" class="btn btn-danger btn-block"> Create Account  </button>
                        </div> <!-- form-group// --> 
                        
                        <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>                                                                 
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>  
</html>




<?php
if (!isset($_POST['txtUsername'])) {
    die('');
}

include('connect.php');

$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];
$fullname = $_POST['txtFullname'];
//$role = $_POST['formRole'];

$Email = $_POST['txtEmail'];



if (!$username || !$password || !$fullname) {
    echo "<div class='alert alert-danger'><b>Enter the space. <a href='javascript: history.go(-1)'>back</a></b></div>";
    exit;
}

$password = md5($password);

$stmt = $conn->prepare("SELECT username FROM account WHERE username='$username'");
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<div class='alert alert-danger'><b>Username exist.</b></div>";
    exit;
}



//if (empty($role)) {
//    echo"You forgot to select the role!.";
//    exit;
//}


$stmt = $conn->prepare("INSERT INTO account (username,password,role,fullname,Email) VALUE ('{$username}','{$password}','Student','{$fullname}','{$Email}')");
$pdoResult = $stmt->execute();


if ($pdoResult) {
    echo "<div class='alert alert-success'><a href='login.php' ><b>Successfully</b></a></div>";
} else
    echo "<div class='alert alert-danger'><b>error. <a href='register.php'>Back</a></b></div>";
?>