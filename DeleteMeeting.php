<?php
if(isset($_POST['MeetingID'])){    
    
    include('connect.php'); 
    $id = $_POST['MeetingID'];
    
    $stmt = $conn->prepare("Update meeting SET Date_end = now() where MeetingID = ' $id '");

    $pdoResult = $stmt->execute();
                          
    
    if ($pdoResult){
        header( 'Location: Meeting.php');
    }
    else
        echo "error. <a href='javascript: history.go(-1)'>back</a>";
}
?>