<?php 
/*
$pw = 'memem';

$hash = password_hash($pw, PASSWORD_DEFAULT);
echo $hash . '<br>';
#$hash = '$2y$10$ChNC/Ah3VeARBnXO4KMUXupzUSi5yZIaG3xaqwlVZxGshdbux719.';
if (password_verify($pw, $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}*/

require_once('./conn.php');

$sql = "SELECT * FROM `hugh_member` WHERE `id` = '20'";
$result = $conn->query($sql);
$nickname = $result->fetch_assoc()['nickname'];
echo $nickname;

?>