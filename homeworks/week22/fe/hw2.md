## React Router 背後的原理你猜是怎麼實作的？
React Router 的原理，我覺得應該就像是影片上面介紹的那樣使用指令去取得網址上面的路由狀態，來判斷該是去到哪個頁面。

另外因為有實作 history 的功能，所以從這裡可以感覺到，他的 history 就是用來記錄使用過的路由的部分。所以當按下上一頁的時候，就可以去找尋 history 的紀錄。

進而達成路由的效果。

## SDK 與 API 的差別是什麼？
根據[這篇](https://www.zhihu.com/question/21691705)的內容。
SDK 跟 API 最大的區別在於，SDK 是一個工具包。SDK 主要是針對某一個方面打包起來的工具包，裡面可能含有開發文件、各種 API 等，就是方便開發的一個工具包。

而 API 就是一個提供別人使用這些內容的接口，跟 SDK 的關係就像是從 SDK 中拉出一條線，用來連接 SDK 可以使用 SDK 裡面的內容這樣。

## 在用 Ajax 的時候，預設是不會把 Cookie 帶上的，要怎麼樣才能把 Cookie 一起帶上？
根據查詢的[內容](https://zhuanlan.zhihu.com/p/28818954)
Ajax 是針對跨域的內容，不會主動帶上 cookie，只有同源的才會自動帶上 cookie。
而如果要帶上 cookie 的話，就需要通過設置在發出 request 這邊設置 `withCredentials: true`，伺服器那邊也需要開通，這樣就可以自動帶上 cookie 了。