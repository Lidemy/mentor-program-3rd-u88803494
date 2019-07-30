<?php
require_once('./conn.php');
require_once('./security_check.php');

$comment = $_POST['comment'];

$sql = "INSERT INTO hugh_comments(`user_id`, `comment`) VALUES ('$user', '$comment')";
  
$result = $conn->query($sql); 

if ($result) {
  header('Location: ./index.php');
} else {
  echo 'failed, ' . $conn->error;
}

?>
