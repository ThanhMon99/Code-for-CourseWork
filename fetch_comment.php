<?php
session_start();
require_once("connect.php"); 
$post_id = $_SESSION['postid'];
$query = "SELECT * FROM comment WHERE post_id = $post_id ORDER BY comment_id DESC";

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
$user_id = $row['user_id'];
$statement = $conn->prepare("SELECT username FROM account WHERE id='$user_id'");

$statement->execute();

$r = $statement->fetch(PDO::FETCH_ASSOC);

 $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>'.$r["username"].'</b> on <i>'.$row["date"].'</i></div>
  <div class="panel-body">'.$row["comment"].'</div>
 </div>
 ';
}
echo $output;

?>