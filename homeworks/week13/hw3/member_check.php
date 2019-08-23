<?php
  // 寫成 function 就不會跟其他的干擾了
  function memberCheck($conn, $id) {
    $sql = "SELECT `user_id` FROM hugh_comments WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ("$row[user_id]" !== "$_SESSION[login_id]") {
      // 外面包雙引號保持字串，因為兩種資料型態不一樣
      return die(json_encode(array("success" => "你沒有權限",), JSON_UNESCAPED_UNICODE));
    }
  }

  memberCheck($conn, $id);
?>