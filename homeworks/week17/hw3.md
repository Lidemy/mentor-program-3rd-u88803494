## hw3：Hoisting
請說明以下程式碼會輸出什麼，以及儘可能詳細地解釋原因。
```
var a = 1
function fn(){
  console.log(a)
  var a = 5
  console.log(a)
  a++
  var a
  fn2()
  console.log(a)
  function fn2(){
    console.log(a)
    a = 20
    b = 100
  }
}
fn()
console.log(a)
a = 10
console.log(a)
console.log(b)
```
---
因為直式的寫，很難排版，所以我用橫的方式來寫，按照先左邊後右邊的順序。


1. 首先進入程式時，進入了 globalEC，產生 VO 並初始化變數，有`var a = 1`、`function fn`  ，所以 a 的值為 undefined，fn 是 function，產生隱藏屬性 Scope，以及 scopeChain。
```
globalEC: {
  VO {
    a: undefined,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

2. 執行階段，把 globalEC.VO 的 a 賦值成 1，進入 `fn()`。
```
globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

3. 建立一個 fnEC，產生 AO 並初始化。`var a = 5`，因為是在編譯階段，所以在 fnEC.AO 定義 a 為 undefined，後面又碰到一次 `var a` 但已經定義過，所以忽略。再後面碰到 function fn2，也定義成 function。產生隱藏屬性 Scope，以及 scopeChain。
scopeChain 的內容等於 `[fnEC.AO , fn.[[Scope]]]`，也等同於 `[fnEC.AO ,globalEC.scopeChain]`，就是 `[fnEC.AO, globalEC.VO]`
```
fnEC: {
  AO {
    a: undefined,
    fn2: func,
  }
  scopeChain: [fnEC.AO, fn.[[Scope]]] => [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

4. 執行階段。先碰到 `console.log(a)`，所以從 scopeChain index 0 開始找起，找到fnEC.AO 裡面有 a 值 undefined，所以印出 undefined。
印出的資料：undefined  
```
fnEC: {
  AO {
    a: undefined,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

5.  執行階段中。繼續往下執行。碰到 賦值 `var a = 5` 但執行階段 var 已經編譯過，所以只看 `a = 5`，所以從 scopeChain index 0 開始找起，找到fnEC.AO 裡面有 a 值，所以把 a 值改成 5
印出的資料：undefined  
```
fnEC: {
  AO {
    a: 5,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

6. 又碰到 `console.log(a)`，所以從 scopeChain index 0 開始找起，找到fnEC.AO 裡面有 a 值 5，所以印出 5。
印出的資料：undefined  5
```
fnEC: {
  AO {
    a: 5,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

7. 執行階段中。碰到 `a++`，所以從 scopeChain index 0 開始找起，找到fnEC.AO 裡面有 a 值 5，故 +1， a 的值改為 6。
印出的資料：undefined  5
```
fnEC: {
  AO {
    a: 6,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

8. 執行階段中。繼續往下碰到 `fn2()`，進入 `fn2()`。建立 fn2EC，產生 AO 並初始化。編譯階段，因為沒資料要編譯，所以 fn2EC.AO 為空。產生 ScopeChain。
scopeChain 的內容是 `[fn2EC.AO, fn2.[[Scope]]]`，等同於 `[fn2EC.AO, fnEC.scopeChain]`，也等同於 `[fn2EC.AO, fnEC.AO, globalEC.VO]`。
印出的資料：undefined  5
```
fn2EC: {
  AO {
  
  }
  scopeChain: [fn2EC.AO, fn2.[[Scope]]] => [fn2EC.AO, fnEC.scopeChain]
}

======

fnEC: {
  AO {
    a: 6,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

9. 編譯階段結束，進入執行階段。先碰到  `console.log(a)` ，所以從 scopeChain index 0 開始找起，找 fn2EC.AO 發現沒有 a 的值，所以找 index 1，fnEC.AO 找到 a 的值為 6，所以印出 6。 
印出的資料：undefined  5  6  
```
fn2EC: {
  AO {
  
  }
  scopeChain: [fn2EC.AO, fnEC.AO, globalEC.VO]
}


======

fnEC: {
  AO {
    a: 6,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

10. 執行階段中。碰到 `a = 20` ，從 scopeChain index 0 開始找起，找 fn2EC.AO 發現沒有 a 的值，所以找 index 1，fnEC.AO 找到 a ，所以把 fnEC.AO.a 的值改成 20。 
印出的資料：undefined  5  6  
```
fn2EC: {
  AO {
  
  }
  scopeChain: [fn2EC.AO, fnEC.AO, globalEC.VO]
}


======

fnEC: {
  AO {
    a: 6, => 20
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

11. 執行階段中。碰到 `b = 100`，從 scopeChain index 0 開始找起，找 fn2EC.AO 發現沒有 b 的值，所以找 index 1，fnEC.AO 一樣沒有找到 b，所以繼續找 index 2 的 globalEC.VO，依然沒看到 b。由於已經最上層了，所以就在 globalEC.VO 定義 `b = 100`，等於直接定義 b 然後賦值 100。
印出的資料：undefined  5  6  
```
fn2EC: {
  AO {
  
  }
  scopeChain: [fn2EC.AO, fnEC.AO, globalEC.VO]
}


======

fnEC: {
  AO {
    a: 20,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

12. function fn2 結束，退出 fn2EC，並抹除 fn2EC 的資料。回到 fnEC 繼續執行。
印出的資料：undefined  5  6  
```
fnEC: {
  AO {
    a: 20,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

13. fnEC 執行階段中。`fn2()` 結束後，繼續執行下方的 `console.log(a)`，從 fnEC.scopeChain index 0 開始找起，找到fnEC.AO 的 a 值為 20，所以印出 20。
印出的資料：undefined  5  6  20
```
fnEC: {
  AO {
    a: 20,
    fn2: func,
  }
  scopeChain: [fnEC.AO, globalEC.VO]
}

fn2.[[Scope]] = fnEC.scopeChain

======

globalEC: {
  VO {
    a: 1,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

14. function fn 結束，退出 fnEC，並抹除 fnEC 的資料。回到 globalEC 繼續執行。
印出的資料：undefined  5  6  20
```
globalEC: {
  VO {
    a: 1,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

15. globalEC 執行階段中。`fn()` 結束後，繼續執行下方的 `console.log(a)`，從 globalEC.scopeChain index 0 開始找起，找到globalEC.VO 的 a 值為 1，所以印出 1。
印出的資料：undefined  5  6  20  1
```
globalEC: {
  VO {
    a: 1,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

16. globalEC 執行階段中。繼續往下，碰到賦值 `a = 10`，從 globalEC.scopeChain index 0 開始找起，找到globalEC.VO 有 a ，所以把 globalEC.VO.a 改成 10。
印出的資料：undefined  5  6  20  1
```
globalEC: {
  VO {
    a: 10,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

17. globalEC 執行階段中。繼續往下執行下方的 `console.log(a)`，從 globalEC.scopeChain index 0 開始找起，找到globalEC.VO 的 a 值為 10，所以印出 10。
印出的資料：undefined  5  6  20  1  10
```
globalEC: {
  VO {
    a: 10,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

18. globalEC 執行階段中。繼續往下執行下方的 `console.log(b)`，從 globalEC.scopeChain index 0 開始找起，找到globalEC.VO 的 b 值為 100，所以印出 100。
印出的資料：undefined  5  6  20  1  10  100
```
globalEC: {
  VO {
    a: 10,
    fn: func,
    b: 100,
  }
  scopeChain: [globalEC.VO]
}
fn.[[Scope]] = globalEC.scopeChain
```

19. 全部執行結束。


最後結果：
undefined
5
6
20
1
10
100
