<?php
  session_start(); // session 機制

  require_once('./conn.php');
  require_once('./security_check.php');
  include_once('./utils.php');

  $comment = $_POST['comment'];
  $parent_id = $_POST['parent_id'];

  if (empty($comment)) {
    die(json_encode(array(
      "success"=> "內容沒有輸入，不要留空",
    ), JSON_UNESCAPED_UNICODE));
  }

  // SQL Injection 處理
  $stmt = $conn->prepare("INSERT INTO hugh_comments(`user_id`, `parent_id`, `comment`) 
    VALUES (?, ?, ?);");
  $stmt->bind_param("sss", $_SESSION['login_id'], $parent_id, $comment);
  
  if ($stmt->execute()) {
    $stmt->close();
    // 成功就把 id 撈下來
    $stmt_result = $conn->prepare(
      "SELECT C.id, C.user_id, C.parent_id, C.comment, C.created_at, M.nickname 
      FROM `hugh_comments` AS C LEFT JOIN `hugh_member` AS M ON C.user_id = M.id 
      WHERE comment = ? ORDER BY C.`created_at` DESC LIMIT 1");
    $stmt_result->bind_param("s", $comment);
    $stmt_result->execute();

    $result = $stmt_result->get_result();
    if ($result->num_rows>0) {
      $row = $result->fetch_assoc();
      $row['session'] = $_SESSION; // 添加取得 session 的資料
      // 撈取 parent_id 文章的 user_id，成功就回傳需顯示的 classname，失敗則否
      $row['is_main'] = getParentUser($conn, $parent_id); // 引入傳入的父留言 id 
      echo json_encode($row, JSON_UNESCAPED_UNICODE); // 把伺服器取得的資料回傳
    } else {
      die(json_encode(array(
        "success" => "伺服器錯誤，請重新整理網頁",
        ), JSON_UNESCAPED_UNICODE)); // 雖然覺得不太可能上傳成功卻抓不到資料，但還是設置一下
    }
    $stmt_result->close();
  } else {
    echo json_encode(array(
      "success" => "failed: $conn->error",
      ), JSON_UNESCAPED_UNICODE); // 不加後面也可以，加了降低傳輸量且方便 debug
  }

  $conn->close();
?>
