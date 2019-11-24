hw1 這部份就是以 week19 為準，連編輯功能也有做出來，作到一度有點想放棄...

因為 CSS 要沿用，所以就在 index.html 引用 bootstrap 

這邊提交就只提交必要檔案而已。

### 提交方面有兩個問題
一個是 is missing in props validationeslint(react/prop-types)，看了同學的作業，老師也提到可以先忽略。

另一個是 JSX not allowed in files with extension '.js'eslint(react/jsx-filename-extension)
查半天還是不知道為什麼不能使用，而看起來也不是什麼大問題，所以也略過。

### 可優化方向
把那些分散的檔案改用同一個 function，然後透過 indexOf 來判斷關鍵字決定要呼叫哪個 function，甚至呼叫的 main component 的 function 也可以寫在一起。