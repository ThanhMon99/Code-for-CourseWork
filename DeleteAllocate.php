<?php
if(isset($_POST['acid'])){    
    
    include('connect.php'); 
    
    $stmt = $conn->prepare("DELETE FROM allocate WHERE acid = :acid");
    $stmt->bindValue(':acid', $_POST['acid'], PDO::PARAM_INT);
    $pdoResult = $stmt->execute();
                          
    
    if ($pdoResult){
        header( 'Location: allocate.php');
    }
    else
        echo "error. <a href='javascript: history.go(-1)'>back</a>";
}
?>