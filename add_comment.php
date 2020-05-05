<?php
session_start();
require_once("connect.php"); 

$error = '';
$user_id = $_SESSION['id'];
$post_id = $_SESSION['postid'];
$comment_content = '';

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if($error == '')
{
 $query = "
 INSERT INTO comment 
 (comment, user_id, post_id) 
 VALUES (:comment, :user_id, :post_id)
 ";
 $statement = $conn->prepare($query);
 $statement->execute(
  array(
   ':comment'=> $comment_content,
   ':user_id' => $user_id,
   ':post_id' => $post_id
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
