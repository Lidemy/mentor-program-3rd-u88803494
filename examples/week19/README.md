# 注意事項

提示：在寫完作業之後看效果最佳，沒寫作業前請不要看

## 關於 API 網址

有同學問說，為什麼我們之前串的 API 網址都是 `/xxx/todos`，結尾都沒有東西，不像這一週寫出來會變成 `/xxx/todos.php`。

這是因為不同的伺服器處理方式不一樣，以最簡單的 PHP + Apache 預設設定來說，就是以檔案結構的方式來執行。你打網址就像是你平常在找檔案那樣，很直覺很方便，一個檔案就對應到一個路徑。

但這其實是可以調整的，例如說之後教 Express，就會發現它的架構完全不一樣，不是一個檔案對應一個頁面，而是對應到部分功能。

所以這邊你要知道的是這些網址的規則都是由伺服器決定的，都是可以更改的。不一樣只是因為我們用的是 PHP + Apache 的預設設定。如果你想知道怎麼改，請 Google `.htaccess php 教學`。


## Todo list 與 XSS

記得防 XSS 阿！使用者有可能輸入個惡意字串，你的網站就被駭了。SPA 也是要防止 XSS 的。

那要防在哪邊呢？有些同學會在寫入資料庫時做 escape，這其實是不太正確的。因為那是你的 raw data，應該要是原始資料才對，基本上不做任何加工。

原因是未來你可能不是唯一需要這些資料的人。假設有了 Android 或是 iOS App，他們也需要這些資料，而且他們不需要 escape。若是你先 escape 再存進資料庫，這樣他們拿到的資料就會是錯誤的資料，跟使用者輸入的不一樣。

所以防止 XSS 應該要在「顯示」的時候防，而不是去對資料動手腳。

還記得我們在 PHP 裡面用的 escape function 叫什麼嗎？htmlspecialchars。

例如說使用者輸入`<script>`，輸出會變成`&lt;script&gt;`，原理是在 HTML 裡面 `&lt;` 會被顯示為 `<` 的符號。這樣子就可以避免掉 XSS，因為你不是以`<script>`的語法去解析它，只是顯示起來是這樣而已。

但若是你在寫進資料庫以前就做這件事，那 APP 端（Android 與 iOS）拿到資料的時候就會拿到`&lt;script&gt;`，顯示出來就會顯示`&lt;script&gt;`，因為 APP 沒有什麼「`&lt;` 會被顯示為 `<` 的符號」這種東西，它是 APP，不是 HTML。

所以這就是為什麼我說應該要在顯示的時候才做跳脫，而不是寫進資料庫裡面的時候。

## 示範

改寫自 [Ponchimeow 同學的作業](https://github.com/Lidemy/mentor-program-3rd-Ponchimeow/pull/28/files)：


``` php
require_once 'sql.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
header('Access-Control-Content-Type: application/json,charset=utf-8');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Max-Age: 86400');
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            get($conn, $_GET['id']);
        } else {
            getALL($conn);
        }
        break;
    case 'POST':
        create($conn, $_POST['content']);
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            del($conn, $_GET['id']);
        }
        break;
    case 'PATCH':
        $res = array();
        $data = file_get_contents('php://input');
        parse_str($data, $res);
        extract($res);
        var_dump($res);
        if ($case === 'edit') {
            update($conn, $id, $content);
        }
        if ($case === 'status') {
            switchStatus($conn, $id);
        }
        break;
    case 'OPTIONS':
        header("HTTP/1.1 200 OK");
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        break;
}
```

這邊重點是如果你想實作 RESTful 那種風格的話，PHP 內建只有 GET 與 POST 可以利用 `$_GET` 或是 `$_POST` 的方式拿到資料，其他的你要利用 `file_get_contents('php://input')` 來拿到 request body，然後再去解析它

只要能拿到 input 跟 http method，其他就好辦了，就跟 13 週一樣。

