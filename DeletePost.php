<?php
if(isset($_POST['id'])){    
    
    $postid = $_POST['id'];
    include('connect.php'); 
    
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $pdoResult = $stmt->execute();
    
    $stmt2 = $conn->prepare("select * from upload_file WHERE post_id = '$postid'");
    $stmt2->execute();
    $result = $stmt2->fetchAll();
    foreach ($result as $row) 
    {
       $path = $row['fileUrl']; 
       unlink($path);
    }
    $stmt1 = $conn->prepare("DELETE FROM upload_file WHERE post_id = :id");
    $stmt1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $pdoResult1 = $stmt1->execute();
    
    if ($pdoResult && $pdoResult1){
        header( 'Location: showPost.php');
    }
    else
        echo "error. <a href='javascript: history.go(-1)'>back</a>";
}
?>