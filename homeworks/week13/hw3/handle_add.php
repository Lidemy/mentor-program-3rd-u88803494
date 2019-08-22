<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  $comment = $_POST['comment'];
  $parent_id = $_POST['parent_id'];

  if (empty($comment)) {
    die(json_encode(array(
      "success"=> "內容沒有輸入，不要留空",
    )));
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
      WHERE comment = ? ORDER BY M.`created_at` DESC LIMIT 1");
    $stmt_result->bind_param("s", $comment);
    $stmt_result->execute();

    $result = $stmt_result->get_result();
    if ($result->num_rows>0) {
      $row = $result->fetch_assoc();
      echo json_encode($row); // 把伺服器取得的資料回傳
    } else {
      die(json_encode(array(
        "success" => "伺服器錯誤，請重新整理網頁",
        ))); // 雖然覺得不太可能上傳成功卻抓不到資料，但還是設置一下
      $stmt_result->close();
    }
  } else {
    echo json_encode(array(
      "success" => "failed: $conn->error",
      ));
  }

  $conn->close();
?>
