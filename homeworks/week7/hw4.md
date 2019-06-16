## 什麼是 DOM？
DOM 就是 Document Object Mothed。是一種把 HTML 結構轉換成物件的方法。有提供一些 API，用於跟 JavaScript 或是其他的程式溝通。透過這樣的方法，我們可以輕易的選取到我們要選取的標籤。進而去修改那些標籤。DOM 有很多種物件屬性跟方法可以使用。可以透過物件的方式去使用那些屬性跟方法，就可以得到資料進而去控制。而更上層還有一層式瀏覽器的模式，名字是 Browser Object Mothed, BOM，它是瀏覽器的 API，而 DOM 是這裏面的其中一個分支。最上層是 window 再來才是 document，所以 BOM 又被稱為 level 0 DOM。

### DOM 方法與屬性
方法是我們可以在節點（HTML 元素）上執行的動作。屬性是節點（HTML 元素）的值，能夠獲取或設置。可通過 JavaScript （以及其他程式語言）對 HTML DOM 進行訪問。
所有 HTML 元素被定義為物件，而程式介面則是物件方法和物件屬性。

方法是能夠執行的動作（比如添加或修改元素）。
屬性是能夠獲取或設置的值（比如節點的名稱或內容）。

舉個例子來說：某個人是一個物件。
人的方法可能是 eat (), sleep (), work (), play () 等等。
所有人都有這些方法，但會在不同時間執行。
一個人的屬性包括姓名、身高、體重、年齡、性別等等。
所有人都有這些屬性，但它們的值因人而異。
參考資料：[W3School HTML DOM 方法](http://www.w3school.com.cn/htmldom/dom_methods.asp)

### DOM 的樹狀結構
根據 DOM 的機制。我們得到個物件，會看起來像是一個樹狀圖。以 DOM 的部分來說，最上層是 document，document 的底下是 `<html>`，`<html>` 的底下分別是 `<head>`、`<body>`，然後在來是我們寫網頁的時候設置的那些標籤跟內容。這些標籤跟內容形成一個樹狀圖。如同下圖所示。 ![image](https://d1dwq032kyr03c.cloudfront.net/upload/images/20171214/20065504rULoAa69HV.png)
 [圖源](https://ithelp.ithome.com.tw/articles/10191666)
 
 
## 事件傳遞機制的順序是什麼；什麼是冒泡，什麼又是捕獲？
根據上一題所寫的，事件傳遞的機制就是根據 DOM 的樹狀圖來傳遞。以下圖來說明。
![img](https://cdn-images-1.medium.com/max/720/1*wINo5blPb3Tc4A9s5JrjQg.png)
[圖源](https://www.w3.org/TR/DOM-Level-3-Events/#event-flow)

當點擊一個元素之後，由最上面開始經過 `document`、`<html>` 一路往下，最後到達指定的元素，這部分就是捕獲階段(Capture phase)，也就是圖片紅色 (1) 的路徑。接著就會進入目標階段(target phase)，也就是圖片藍色的 (2) 的階段，也就是點擊的元素的執行階段。接著就會進入冒泡階段(Bubbling phase)，就是圖片中綠色的(3)的路徑，把事件依照原路徑一層層的傳上去。**一個重點就是先捕獲在冒泡**。

  
## 什麼是 event delegation，為什麼我們需要它？
event delegation 就是事件代理的意思。
delegation 意思是（工作、職務或權力等）分配；委派；授權 [劍橋](https://dictionary.cambridge.org/zht/%E8%A9%9E%E5%85%B8/%E8%8B%B1%E8%AA%9E-%E6%BC%A2%E8%AA%9E-%E7%B9%81%E9%AB%94/delegation)
所以在這邊用作為事件委派。它是一種受惠於 Event Bubbling 而能減少監聽器數目的方法，利用的是事件會冒泡到它的上層元素。可以把很多個需要執行的事情，委派給一個事件監聽集中管理就好。這樣做的好處使可以減少監聽器的數目，當然撰寫也就比較難一些了，因為監聽的可能不再只是一個按鈕，而是很多的按鈕集中在一起。那就必須要透過判斷來確定是按了甚麼按鈕。
#### 為什麼會需要它呢？
因為它可以有效的減少撰寫監聽器，而且還可以更有效的管理，可以使用一個監聽器就可以監聽很多的事件。
1. 減少了新增很多的監聽函式
2. 可以很方便的新增或修改元素
3. 不會因為一些改動就導致需要修改監聽事件或函式。  

## `event.preventDefault()` 跟 `event.stopPropagation()` 差在哪裡，可以舉個範例嗎？
`event.preventDefault()` 是用來阻止預設的行為。而 `event.stopPropagation()` 則是會阻止事件的傳遞。

`event.prevnetDefault() `的用意是在阻止事件的預設行為。假設今天有設置一個連結連到 Google，連結的預設行為是點了就會打開網址，所以我們另外設置監聽這個連結的點擊行為，接著在 function 裡面使用 `event.preventDefault()` 。那麼點擊之後就不會連結去 Google 了。為了方便呈現效果，另外在多加一個把背景變成紅色的指令，是直接把 style 添加進標籤內。
```
<body>
  <a id="test" href="http://google.com" target="_blank">Google</a>
  <script>
    const test = document.querySelector("#test")
    test.addEventListener('click', (e) => {
      e.preventDefault();
      test.setAttribute('style','background:red')
    });
  </script>
</body>
```
這樣在點了那個連結的時候，就不會連結出去。因為只會阻止預設行為，所以背景顏色還是一樣會變成紅色。
![Imgur](https://i.imgur.com/fjgfODf.gif)

`event.stopPropagation()` 則是會阻止事件往上傳遞。也就是說，如果只有單一事件的話，其實不會有影響，但是當如果有兩種事件在同一個位置，依照捕獲與冒泡的原理來說，就會把事件傳遞給別層，所以當一個位置有兩個事件的時候，就會一起執行。但是我不希望兩個事件一起執行怎麼辦呢？就是使用 `event.stopPropagation()` 就可以了。
用上面的例子，另外用 `div` 包起來，然後設置高度跟顏色以方便觀看結果。然後設置監聽這個 `div`，當點擊之後就把背景給消除。先試試看不使用 `event.stopPropagation()` 的結果。
```
<body>
  <div id="test2" style="height:100px; background: gray;">
    <a id="test" href="http://google.com" target="_blank">Google</a>
  </div>
  
  <script>
    const changeTest = document.querySelector("#test")
    changeTest.addEventListener('click', (e) => {
      e.preventDefault();
      changeTest.setAttribute('style', 'background:red');
    });
    
    const changeTest2 = document.querySelector("#test2")
    changeTest2.addEventListener('click', (e) => {
      changeTest2.removeAttribute('style', 'background: gray');
    })
  </script>
</body>
```
![Imgur](https://i.imgur.com/n8eYobB.gif)
可以看到灰色背景被刪除，連結的背景顏色也變了。這就是點擊的事件冒泡了，所以兩邊都有了反應。
如果不希望點了連結之後，連背景都有反應。就只要在`<a id="test">`的 callback function 使用 `event.stopPropagation()`即可。

```
<body>
  <div id="test2" style="height:100px; background: gray;">
    <a id="test" href="http://google.com" target="_blank">Google</a>
  </div>

  <script>
    const changeTest = document.querySelector("#test")
    changeTest.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      changeTest.setAttribute('style', 'background:red');
    });

    const changeTest2 = document.querySelector("#test2")
    changeTest2.addEventListener('click', (e) => {
      changeTest2.removeAttribute('style', 'background: gray');
    })
  </script>
</body>
```
![Imgur](https://i.imgur.com/UQnbv49.gif)
可以發現，點了連結只有連結的背景變色，而不會上一層的 `<div id="test2">` 也一起對事件產生反應。也就是說被阻止往上冒泡了。然後再去點了旁邊的灰色區域，才會發現觸發了另外一個事件，所以 `<div id="test2">` 的背景顏色就被去掉了。

所以當不希望標籤產生預設行為的時候，我們就可以使用 `event.preventDefault()`，去阻止它發生預設的行為。而如果有好幾個事件在同個位置，又不希望所有的事件都被觸發了，就可以使用 `event.stopPropagation()` 去阻止事件的傳遞。