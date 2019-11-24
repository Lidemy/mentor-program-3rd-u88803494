## 為什麼我們需要 React？可以不用嗎？
有了 React 之後，需要煩惱的東西就少了很多了，因為只需要管狀態就好，修改狀態，就會同步界面。

所以寫的時候就只需要寫狀態跟畫面的指令即可，其他的要怎麼控制，如何操作 DOM 等的指令就會少很多了。

當然可以不用 React，利用原生的還是可以寫，或是也可以參考 React 的模式來寫原生。


## React 的思考模式跟以前的思考模式有什麼不一樣？
原本的思考模式可能較雜亂，需要顧慮 HTML + CSS，然後在轉化到 JavaScript。而 JavaScript 的部份，思考的方向也很多，需要操作 DOM，然後控制元素，方法也是五花八門。可以用取代的，可以用清空的，可以精準變動部份的這樣。

而 React 的部份就是比較固定的，由狀態改變畫面，只需要變動狀態，畫面就變了。所以思考的流程就很固定，從 state 出發，然後建構畫面以及事件監聽，事件監聽改變 state，然後在改變畫面。  


## state 跟 props 的差別在哪裡？
state 就是 component 的狀態，裡面儲存了資料的狀態，而 props 則是另外一個 component 去接收了相對而言是主要的 component 在使用的命名，使用 props 就可以街收到另外一個 component 的 state 上面的資料。
  

## 請列出 React 的 lifecycle 以及其代表的意義
React 的 lifecycle 分為三大類：Mounting、Updating、Unmounting。
Mounting：可以視為掛載中，之前在查資料的時候發現這個是虛擬光碟的用語，所以我覺得算是掛載的意思。這邊有 componentDidMount() 照字面的意思就是，當 component 掛載好之後，就會呼叫這個 function，可以在這邊做一些處理，像是載入資料等。

Updating：更新的意思，也就是當資料被更新的時候，就會使用到屬於這一類的 function，像是 componentDidUpdate，當 component 被更新資料的時候，就會呼叫這個 function，所以我想這邊應該是可以放一些發送資料的指令。

Unmounting：當 component 被移除的時候，就會調用這個狀態，裡面的 function 有 componentWillUnmount() 這個 function 是當 component 要被移除之前，會呼叫的，在這裡可以取消一些用不到的資料函式等。
