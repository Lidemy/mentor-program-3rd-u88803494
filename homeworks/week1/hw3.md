## 教你朋友 CLI
### 什麼是 Command line Interface？
在了解之前，先了解什麼是 GUI。GUI 就是 Graphical User Interface 也就是圖形使用介面。在我們一般日常使用的電腦都是圖形化介面，像是電腦畫面顯示的視窗、圖示、按鈕等圖形都是。像按鈕的存在就是讓我們可以對電腦下指令。那麼什麼是 Command line Interface 呢？Command line Interface 縮寫 CLI，中文為命令列介面，是在圖形化介面出現之前最為通用的形式，像是古早的 MS-DOS 就是只能使用 Command line 來操作。而 Command line 也跟圖形化介面一樣，目的就是在針對電腦下指令，只是他的形式不一樣。

### Command line Interface 如何使用？
以我來說是使用 Windows，最簡單的就是打開開始列，接著輸入 CMD 按下 enter。

![CMD](https://i.imgur.com/wCVgCXa.jpg)

就會出現這樣的頁面。但是這個是功能最陽春的版本很多指令都沒有，所以推薦使用 Cmder，這是更好用的工具。可以到[這邊](https://cmder.net/)下載，下載 Full 的版本功能會比較豐富，下載好安裝之後開啟。

![Cmder](https://i.imgur.com/4nUlUvS.jpg)

介面就會長這樣。
就可以在介面之下輸入指令：
`pwd` = **p**rint **w**orking **d**irectory 印出目前所在資料夾

`ls ` = **l**i**s**t 印出所有的檔案與資料夾

`MKDIR` = **M**a**k**e **dir**ectory 建立資料夾

`touch` 就是摸一下檔案，是一個被用於更改文件訪問和修改時間的指令，它也被用於創建新檔案。

`cd `=  **c**hange  **d**irectory 可以變更目錄 後面加入資料夾名稱，就可以進入資料夾 
- `cd ..` 則是回上一層資料夾


如圖：
![Imgur](https://i.imgur.com/Mc8qDTp.png)


### 為什麼要用 Command line Interface？
在現代因為大家都使用圖形化介面的關係，其實 Command line 沒有很便利，所以一般人並不會使用。而 Command line 的好處是很省資源，一個伺服器常常會同時有很多人連線，資源可能就不太夠用，所以這時候使用在連上一些伺服器要做操作的時候，可能就只剩下 Command line 可以使用。另外，如果要自動化執行的話，很難做到去點擊什麼，所以就可以使用 Command line 來自動化。

### 如何用 command line 建立一個叫做 wifi 的資料夾，並且在裡面建立一個叫 afu.js 的檔案

1. 輸入 `mkdir wifi`  創建 wift 資料夾
2. 輸入 `cd wifi` 切換到該資料夾
3. 輸入 `touch afu.js` 就可以在 /wifi 底下創建 afu.js 的檔案了
4. 輸入 `ls` 就可以確認是否創建成功


如圖：
![Imgur](https://i.imgur.com/IZkHCs5.png)

