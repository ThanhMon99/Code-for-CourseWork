<html>  
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Login</title>

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
        
    </style>
</head>
<body>
    </br></br></br></br>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="user_card">
                <h4>Welcome to <br>High University</h4>
                <div class="d-flex justify-content-center form_container">
                    <form action="#" method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="txtUsername" placeholder="Username" class="form-control input_user">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="txtPassword" placeholder="Password" class="form-control input_pass">
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="login" class="btn login_btn">Login</button>
                       </div>
                    </form>
                </div>
        
                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        Don't have an account? <a href="register.php" class="ml-2">Sign Up</a>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
if (isset($_POST['txtUsername'])) {

    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];

    include('connect.php');

    $stmt = $conn->prepare("SELECT id, username, password, role FROM account WHERE username='$username'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        echo "<div class='alert alert-danger'><b>Username not exist. </b></div>";
        exit;
    }

    $password = md5($password);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($password != $row['password']) {
        echo "<div class='alert alert-danger'><b>Wrong password. </b></div>";
        exit;
    }
    $role = $row['role'];
    $id = $row['id'];
    $_SESSION['role'] = $role;
    $_SESSION['username'] = $username;
    $_SESSION['id'] = $id;
    $statement = $conn->prepare("INSERT INTO login_details (user_id) VALUES ('{$id}')");
    $statement->execute();
    $_SESSION['login_details_id'] = $conn->lastInsertId();

    echo "<div class='alert alert-success'><b>Hello " . $username . ". You login successfully. <a href='index.php'>Continue</a></b></div>";
    die();
}
?>

