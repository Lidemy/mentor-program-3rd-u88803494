<?php
require_once('./conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {	
	if (empty($_GET['id'])) {
		$stmt = $conn->prepare("SELECT * FROM hugh_todo_list ORDER BY id DESC;");
	}
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$stmt = $conn->prepare("SELECT * FROM hugh_todo_list WHERE id = ?;");
		$stmt->bind_param("i", $id);
	}

	if ($stmt->execute()) {
		$result = $stmt->get_result();
		$todolistData = array("result" => "success"); // 用來儲存最終結果
		$arr = array();
    while($row = $result->fetch_assoc()) {
      $content = htmlspecialchars($row['content'], ENT_QUOTES, 'utf-8');
      $rows = array('id' => $row['id'], 'content' => $content,
        'done' => $row['done'], 'created_at' => $row['created_at']);
      array_push($arr, $rows);
		}
		$todolistData['todos'] = $arr;
		echo json_encode(array($todolistData), JSON_UNESCAPED_UNICODE);
	} else {
			die("failed: $conn->error");
			json_encode(array(
				"result" => "failed:$conn->error"
			  ), JSON_UNESCAPED_UNICODE);
	}
}
	
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$method = $_POST['_method'];
	if ($method === "POST") {
		// 新增
		$content = $_POST['content'];
		// 插入
		$stmt = $conn->prepare("INSERT INTO hugh_todo_list(`content`) VALUES (?);");
		$stmt->bind_param("s", $content);
	}

	if ($method === "PATCH") { // 修改
		$id = $_POST['id']; // 取得要修改的 id 之後再判斷要修改什麼
		
		// 判斷修改的位置
		if (isset($_POST['content']) && !empty($_POST['content'])) {
			$content = $_POST['content'];
			// 修改內容
			$stmt = $conn->prepare("UPDATE hugh_todo_list SET `content` = ? WHERE id = ?");
			$stmt->bind_param("si", $content, $id);
		}

		// 因為 checkbox 沒打勾會不傳資料，所以另外設置一個 undone 來處理沒打勾的部份。
		// done, undone 都設置值為 1，但是 done 的 checkbox 沒打勾就不傳上來
		if (isset($_POST['done']) && !empty($_POST['done'])) {
			$done = $_POST['done'] === 'true' ? 1 : 0;
			// 是否完成 內容
			$stmt = $conn->prepare("UPDATE hugh_todo_list SET `done` = ? WHERE id = ?");
			$stmt->bind_param("ii", $done, $id);
		}
	}

	if ($method === "DELETE") { // 刪除
		$id = $_POST['id'];
		$stmt = $conn->prepare("DELETE FROM hugh_todo_list WHERE id = ?");
		$stmt->bind_param("i", $id);
	}

	// 執行區
	if ($stmt->execute()) {
		// 執行結果要修改，改回傳 JSON
		// 這邊只需回傳成功的 JSON 資訊
		echo json_encode(array(
			"result" => "success",
			), JSON_UNESCAPED_UNICODE);
	} else {
		echo json_encode(array(
			"success" => "failed: $conn->error",
			), JSON_UNESCAPED_UNICODE);
	}
}
$stmt->close();
$conn->close();
?>