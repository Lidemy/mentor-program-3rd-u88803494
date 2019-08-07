<?php
  require_once('./conn.php');

  $title = $_POST['title'];
  $desc = $_POST['description'];
  $salary = $_POST['salary'];
  $link = $_POST['link'];
  $due_date = $_POST['due_date'];
  $priority = $_POST['priority'];
  $id = $_POST['id'];

  if (empty($title) || empty($desc) || empty($salary) || empty($link) || empty($due_date)) {
    die('請檢查資料');
  }

  $sql = "UPDATE hugh_jobs SET title='$title', description='$desc'
    , salary='$salary', link='$link', due_date='$due_date',
    priority='$priority'  WHERE id = " . $id;
        
  $result =$conn->query($sql); // 會回傳 true or false，就可以用來判斷有無成功。

  if ($result) {
    header('Location: ./admin.php'); 
    // 這裡的用意是給一個 header，告訴瀏覽去要去的位置，就會轉跳過去。
  } else {
    echo 'failed, ' . $conn->error ; // 顯示錯誤並印出錯誤訊息。
  }

?>
