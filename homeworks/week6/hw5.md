## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
<b>粗體的文字</b> 如同意思，只要把需要的文字用這個標籤包住就會變成粗體
<I>斜體字</I>同上，變成斜體。
<u>文字加底線</u>同上，加底線。
<sub>文字下標</sbu>把文字變成下標。

## 請問什麼是盒模型（box model）
box model 就是一個把區塊的概念更加進化的工具。讓我們可以把元素看成一個盒子，去控制一些設定，讓版面變成我們想要的樣子。
可以從 chrome dev tools 可以看到一個盒子。
[box model](https://i.imgur.com/StnuzMU.png)
這就是用來乘載元素所使用的盒模型，利用這個盒模型可以定義 margin border padding。分別是外距、邊框、內距。利用這幾個屬性可以讓我們很輕易的排版出我們要的樣子。

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
inline：在排版的時候，會按照順序排列在同一行上面，也因為如此，也有一些設定值不能更動，所以靈活性會少一些。
block：排版的時候，如果 display 設置的屬性是 block，他會每個 block 都會換行。幾乎所有的設定都可以設置。
inlin-block：這個屬性就是 inline + block 的屬性，既有 inline 的特性，又有 block 的特性。inline-block 可以不用換行，而且又可以使用所有的屬性， margin. border. padding 都可以使用，所以是最靈活的 display 屬性。

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
static 是瀏覽器的預設的。不會被特別的定位，就是按照排版出現。
relative 跟 static 類似，relative 是相對定位，意思是可以相對於原始的位置來做移動。
absolute 絕對定位，需要有個參考點，所以 absolute 會參照上一層有無定位，如果有就會按照該層來做絕對定位，如果沒有就往上找，最後如果都沒有就會以 body 來做定位。
fixed 是按照瀏覽器的位置來做相對定位。所以可以設置到任何地方，而且 fixed 不會跟其他的元素干擾。