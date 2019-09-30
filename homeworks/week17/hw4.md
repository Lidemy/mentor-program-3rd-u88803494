## hw4：What is this?
請說明以下程式碼會輸出什麼，以及儘可能詳細地解釋原因。
```
const obj = {
  value: 1,
  hello: function() {
    console.log(this.value)
  },
  inner: {
    value: 2,
    hello: function() {
      console.log(this.value)
    }
  }
}
  
const obj2 = obj.inner
const hello = obj.inner.hello
obj.inner.hello() // ??
obj2.hello() // ??
hello() // ??
```

---
因為 this 是看啟動的時候怎麼呼叫，所以直接進入呼叫的部份。

1. `obj.inner.hello()`
`obj.inner.hello()` => `obj.inner.hello.call(obj.inner)`。
所以 this 的就是指 `obj.inner`。所以執行 `console.log(this.value)` 就會去找 `inner` 這個物件的 value。所以會印出 2
印出的資料 2  

2. `obj2.hello()`
`obj2.hello()` => `obj2.hello.call(obj2)`。
this 就是 obj2，從 obj2 等同於 `obj.inner`。就可以找到位於 `obj.inner` 內的 function hello，所以執行之後，會執行其內部的 `console.log(this.value)` 就會去找 `inner` 這個物件的 value。所以會印出 2
印出的資料 2  2

3. `hello()`
因為題目沒要求嚴格模式，所以先寫出一般模式下的情況。嚴格模式寫在後面。

一般模式：
瀏覽器下
`hello()` => `window.hello()` => `window.hello.call(window)`
node.js下：
`hello()` => `global.hello()` => `global.hello.call(global)`

this 的值在這邊要看情況，瀏覽器下是 window，node.js 下是 global。

hello 執行之後，因為已經定義 `const hello = obj.inner.hello` 所以會執行，這邊的 hello，就會執行其內部的 `console.log(this.value)` 印出 this.value 的值。
而 this 已經是在最上層了，所以會在 globalEC(node.js)/windowEC(瀏覽器) 定義 value 的值是 undefined，然後 console.log() 印出 undefined

嚴格模式下：
嚴格模式下，因為 this 本身是 undefined，所以底下不可能有附屬的值，所以在嚴格模式下，無論是瀏覽器還是 node.js 都會處理前面兩個之後，在處理 `hello()` 的時候會報錯顯示 `TypeError: Cannot read property 'value' of undefined`


最後結果：
一般模式下：
2
2
undefined

嚴格模式：
2
2
報錯：`TypeError: Cannot read property 'value' of undefined`