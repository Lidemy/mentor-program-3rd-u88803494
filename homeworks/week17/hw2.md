## hw2： Event Loop + Scope
請說明以下程式碼會輸出什麼，以及儘可能詳細地解釋原因。
```
for(var i=0; i<5; i++) {
  console.log('i: ' + i)
  setTimeout(() => {
    console.log(i)
  }, i * 1000)
}
```
---
因為直式的寫，很難排版，所以我用橫的方式來寫，按照先左邊後右邊的順序。

#### 1. 首先進入程式時，進入了 global EC， `global()` 放入 stack，產生 VO 並初始化變數，有`var i` ，所以 i 的值為 undefined
stack： `global()`
```
globalEC: {
  VO {
    i: undefined,
  }
  scopeChain: [globalEC.VO]
}
```

#### 2. 進入執行階段，i = 0 
stack： `global()`
```
globalEC: {
  VO {
    i: 0,
  }
  scopeChain: [globalEC.VO]
}
```

#### 3.  for 迴圈 判斷 i < 5 是 true。所以進入迴圈，`console.log('i: ' + i)`，所以把 `console.log('i: ' + i)` 放入 stack。
stack： `global()`、 `console.log('i: ' + i)` 
```
globalEC: {
  VO {
    i: 0,
  }
  scopeChain: [globalEC.VO]
}
```

#### 4. 執行 `console.log('i: ' + i)`，找尋 globalEC.VO 找 i ，找到 i 值為 0，所以印出 `i: 0`，並把 `console.log('i: ' + i)` 移出 stack
stack： `global()`
印出的資料：`i: 0`
```
globalEC: {
  VO {
    i: 0,
  }
  scopeChain: [globalEC.VO]
}
```

#### 5. `setTimeout(cb, i * 1000)`，找尋 globalEC.VO 找 i ，找到 i 值為 0，所以把設置 i 整體變成  `setTimeout(cb, 0)`（用 cb 來標示 setTimeout 的 callback），並把 `setTimeout(cb, 0)` 放入 stack。
stack： `global()`、`setTimeout(cb, 0)`
印出的資料：`i: 0`
```
globalEC: {
  VO {
    i: 0,
  }
  scopeChain: [globalEC.VO]
}
```

#### 6. 執行 `setTimeout(cb, 0)`，呼叫 web APIs，`setTimeout(cb, 0)` 放到 web APIs 零秒後呼叫 cb 並把  `setTimeout(cb, 0)` 移出 stack
stack： `global()`
印出的資料：`i: 0`
web APIs：cb_timer(0秒)
```
globalEC: {
  VO {
    i: 0,
  }
  scopeChain: [globalEC.VO]
}
```

#### 7. 第 0 圈迴圈到底，執行 `i++`，找到 globalEC.VO 內的 i ，並將值改為 1。
stack： `global()`
印出的資料：`i: 0`
web APIs：cb_timer(0秒)
```
globalEC: {
  VO {
    i: 1,
  }
  scopeChain: [globalEC.VO]
}
```

#### 8. 回到迴圈開始處繼續執行。for 迴圈 判斷 i < 5 是 true。所以繼續迴圈，`console.log('i: ' + i)`，所以把 `console.log('i: ' + i)` 放入 stack。
stack： `global()`、`console.log('i: ' + i)`
印出的資料：`i: 0`
web APIs：cb_timer(0秒)
```
globalEC: {
  VO {
    i: 1,
  }
  scopeChain: [globalEC.VO]
}
```

#### 9. 執行 `console.log('i: ' + i)`，找尋 globalEC.VO 找 i ，找到 i 值為 1，所以印出 `i: 1`，並把 `console.log('i: ' + i)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`
web APIs：cb_timer(0秒)
```
globalEC: {
  VO {
    i: 1,
  }
  scopeChain: [globalEC.VO]
}
```

#### 10.  `setTimeout(cb, i * 1000)`，找尋 globalEC.VO 找 i ，找到 i 值為 1，所以設置 i 把整體變成  `setTimeout(cb, 1000)`，並把 `setTimeout(cb, 1000)` 放入 stack。
stack： `global()`、`setTimeout(cb, 1000)`
印出的資料：`i: 0`    `i: 1`
web APIs：cb_timer(0秒)
```
globalEC: {
  VO {
    i: 1,
  }
  scopeChain: [globalEC.VO]
}
```

#### 11. 執行 `setTimeout(cb, 1000)`，呼叫 web APIs，`setTimeout(cb, 1000)` 放到 web APIs 一秒後呼叫 cb 並把  `setTimeout(cb, 1000)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`
web APIs：cb_timer(0秒)、cb_timer(1秒)
```
globalEC: {
  VO {
    i: 1,
  }
  scopeChain: [globalEC.VO]
}
```

#### 12. 第 1 圈迴圈到底，執行 `i++`，找到 globalEC.VO 內的 i ，並將值改為 2。
stack： `global()`
印出的資料：`i: 0`    `i: 1`
web APIs：cb_timer(0秒)、cb_timer(1秒)
```
globalEC: {
  VO {
    i: 2,
  }
  scopeChain: [globalEC.VO]
}
```

#### 13. 回到迴圈開始處繼續執行。for 迴圈 判斷 i < 5 是 true。所以繼續迴圈，`console.log('i: ' + i)`，所以把 `console.log('i: ' + i)` 放入 stack。
stack： `global()`、`console.log('i: ' + i)` 
印出的資料：`i: 0`    `i: 1`
web APIs：cb_timer(0秒)、cb_timer(1秒)
```
globalEC: {
  VO {
    i: 2,
  }
  scopeChain: [globalEC.VO]
}
```

#### 14. 執行 `console.log('i: ' + i)`，找尋 globalEC.VO 找 i ，找到 i 值為 2，所以印出 `i: 2`，並把 `console.log('i: ' + i)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`
web APIs：cb_timer(0秒)、cb_timer(1秒)
```
globalEC: {
  VO {
    i: 2,
  }
  scopeChain: [globalEC.VO]
}
```

#### 15.  `setTimeout(cb, i * 1000)`，找尋 globalEC.VO 找 i ，找到 i 值為 2，所以設置 i 把整體變成  `setTimeout(cb, 2000)`，並把 `setTimeout(cb, 2000)` 放入 stack。
stack： `global()`、`setTimeout(cb, 2000)`
印出的資料：`i: 0`    `i: 1`    `i: 2`
web APIs：cb_timer(0秒)、cb_timer(1秒)
```
globalEC: {
  VO {
    i: 2,
  }
  scopeChain: [globalEC.VO]
}
```

#### 16. 執行 `setTimeout(cb, 2000)`，呼叫 web APIs，`setTimeout(cb, 2000)` 放到 web APIs 兩秒後呼叫 cb 並把  `setTimeout(cb, 2000)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)
```
globalEC: {
  VO {
    i: 2,
  }
  scopeChain: [globalEC.VO]
}
```

#### 17. 第 2 圈迴圈到底，執行 `i++`，找到 globalEC.VO 內的 i ，並將值改為 3。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)
```
globalEC: {
  VO {
    i: 3,
  }
  scopeChain: [globalEC.VO]
}
```

#### 18. 回到迴圈開始處繼續執行。for 迴圈 判斷 i < 5 是 true。所以繼續迴圈，`console.log('i: ' + i)`，所以把 `console.log('i: ' + i)` 放入 stack。
stack： `global()`、`console.log('i: ' + i)`
印出的資料：`i: 0`    `i: 1`    `i: 2`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)
```
globalEC: {
  VO {
    i: 3,
  }
  scopeChain: [globalEC.VO]
}
```

#### 19. 執行 `console.log('i: ' + i)`，找尋 globalEC.VO 找 i ，找到 i 值為 2，所以印出 `i: 3`，並把 `console.log('i: ' + i)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)
```
globalEC: {
  VO {
    i: 3,
  }
  scopeChain: [globalEC.VO]
}
```

#### 20.  `setTimeout(cb, i * 1000)`，找尋 globalEC.VO 找 i ，找到 i 值為 3，所以設置 i 把整體變成  `setTimeout(cb, 3000)`，並把 `setTimeout(cb, 3000)` 放入 stack。
stack： `global()`、`setTimeout(cb, 3000)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)
```
globalEC: {
  VO {
    i: 3,
  }
  scopeChain: [globalEC.VO]
}
```

#### 21. 執行 `setTimeout(cb, 3000)`，呼叫 web APIs，`setTimeout(cb, 3000)` 放到 web APIs 三秒後呼叫 cb 並把  `setTimeout(cb, 3000)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)
```
globalEC: {
  VO {
    i: 3,
  }
  scopeChain: [globalEC.VO]
}
```

#### 22. 第 3 圈迴圈到底，執行 `i++`，找到 globalEC.VO 內的 i ，並將值改為 4。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)
```
globalEC: {
  VO {
    i: 4,
  }
  scopeChain: [globalEC.VO]
}
```

#### 23. 回到迴圈開始處繼續執行。for 迴圈 判斷 i < 5 是 true。所以繼續迴圈，`console.log('i: ' + i)`，所以把 `console.log('i: ' + i)` 放入 stack。
stack： `global()`、`console.log('i: ' + i)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)
```
globalEC: {
  VO {
    i: 4,
  }
  scopeChain: [globalEC.VO]
}
```

#### 24. 執行 `console.log('i: ' + i)`，找尋 globalEC.VO 找 i ，找到 i 值為 2，所以印出 `i: 3`，並把 `console.log('i: ' + i)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)
```
globalEC: {
  VO {
    i: 4,
  }
  scopeChain: [globalEC.VO]
}
```

#### 25.  `setTimeout(cb, i * 1000)`，找尋 globalEC.VO 找 i ，找到 i 值為 4，所以設置 i 把整體變成  `setTimeout(cb, 4000)`，並把 `setTimeout(cb, 4000)` 放入 stack。
stack： `global()`、`setTimeout(cb, 4000)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)
```
globalEC: {
  VO {
    i: 4,
  }
  scopeChain: [globalEC.VO]
}
```

#### 26. 執行 `setTimeout(cb, 4000)`，呼叫 web APIs，`setTimeout(cb, 4000)` 放到 web APIs 四秒後呼叫 cb 並把  `setTimeout(cb, 4000)` 移出 stack。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
```
globalEC: {
  VO {
    i: 4,
  }
  scopeChain: [globalEC.VO]
}
```

#### 27. 第 4 圈迴圈到底，執行 `i++`，找到 globalEC.VO 內的 i ，並將值改為 5。
stack： `global()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 28. 回到迴圈開始處繼續執行。for 迴圈 需要判斷 i < 5，所以通過 `globalEC.VO.i` 取得 i = 5， 結果是 false。所以結束迴圈。所以整個主程式流程都走完了，就把 `global()` 移出 stack。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(0秒)、cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 29. stack 清空。同時 webAPIs 也在處理那些 Timer 需求。所以 0 秒後返回 cb_timer(0秒) 到 call queue。cb_timer(0秒) 在 webAPIs 結束。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：cb
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 30. 因為 stack 已清空，所以 event loop 繼續查找待執行。找到 call queue 有待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call queue
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 31.  call queue 發現有個待執行。於是把 call queue 的內容，移到 stack。把 cb 放入 stack 且因為 cb 是 function，所以進入 cbEC，產生 AO 並初始化。因為沒有需要編譯的部份，所以 AO 為空。產生一個 cb.[[Scope]] 內容等於 globalEC.scopeChain 會等於 globalEC.VO。cbEC 的 scopeChain 等於 `[cbEC.AO,  cb.[[Scope]]]`，實際上等同於 `[cbEC.AO, globalEC.VO]`。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 32. cb 裡面，有 `console.log(i)`，把 `console.log(i)` 放入 stack。
stack：`cb()`、`console.log(i)` 
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`
web APIs：cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 33. 執行 `console.log(i)`，於是開始找尋變數 i 的值，通過 cbEC.scopeChain 開始找，`[cbEC.AO, globalEC.VO]` 先找尋 cbEC.AO，裡面沒有。所以找往後找，找尋 globalEC.VO，裡面有 i 值，於是取出 i 值為 5。`console.log(5)`，印出 5 並把 `console.log(5)` 移出 stack。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5
web APIs：cb_timer(1秒)、cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
```

#### 34. 因為 `cb()` 已經執行完畢，所以 `cb()` 移出 stack，同時清除 cbEC。stack 已清空。同時 webAPIs 也在處理那些 Timer 需求。所以 1 秒後返回 cb_timer(1秒) 到 call queue。cb_timer(1秒) 在 webAPIs 結束。call queue 多了一個 cb 待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5
web APIs：cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call stack
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 35. stack 已清空。所以 event loop 繼續查找待執行。找到 call queue 有待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5
web APIs：cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call queue
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 



#### 36. call queue 發現有個待執行。於是把 call queue 的內容，移到 stack。把 cb 放入 stack 且因為 cb 是 function，所以進入 cbEC，產生 AO 並初始化。因為沒有需要編譯的部份，所以 AO 為空。產生一個 cb.[[Scope]] 內容等於 globalEC.scopeChain 會等於 globalEC.VO。cbEC 的 scopeChain 等於 `[cbEC.AO,  cb.[[Scope]]]`，實際上等同於 `[cbEC.AO, globalEC.VO]`。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5
web APIs：cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 37. cb 裡面，有 `console.log(i)`，把 `console.log(i)` 放入 stack。
stack：`cb()`、`console.log(i)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5
web APIs：cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 38. 執行 `console.log(i)`，於是開始找尋變數 i 的值，通過 cbEC.scopeChain 開始找，`[cbEC.AO, globalEC.VO]` 先找尋 cbEC.AO，裡面沒有。所以找往後找，找尋 globalEC.VO，裡面有 i 值，於是取出 i 值為 5。`console.log(5)`，印出 5 並把 `console.log(5)` 移出 stack。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5
web APIs：cb_timer(2秒)、cb_timer(3秒)、cb_timer(4秒)
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 39. 因為 `cb()` 已經執行完畢，所以 `cb()` 移出 stack，同時清除 cbEC。stack 已清空。同時 webAPIs 也在處理那些 Timer 需求。所以 2 秒後返回 cb_timer(2秒) 到 call queue。cb_timer(2秒) 在 webAPIs 結束。call queue 多了一個 cb 待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5
web APIs：cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call stack
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 40. stack 已清空。所以 event loop 繼續查找待執行。找到 call queue 有待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5
web APIs：cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call queue
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 41. call queue 發現有個待執行。於是把 call queue 的內容，移到 stack。把 cb 放入 stack 且因為 cb 是 function，所以進入 cbEC，產生 AO 並初始化。因為沒有需要編譯的部份，所以 AO 為空。產生一個 cb.[[Scope]] 內容等於 globalEC.scopeChain 會等於 globalEC.VO。cbEC 的 scopeChain 等於 `[cbEC.AO,  cb.[[Scope]]]`，實際上等同於 `[cbEC.AO, globalEC.VO]`。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5
web APIs：cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 42. cb 裡面，有 `console.log(i)`，把 `console.log(i)` 放入 stack。
stack：`cb()`、`console.log(i)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5
web APIs：cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 43. 執行 `console.log(i)`，於是開始找尋變數 i 的值，通過 cbEC.scopeChain 開始找，`[cbEC.AO, globalEC.VO]` 先找尋 cbEC.AO，裡面沒有。所以找往後找，找尋 globalEC.VO，裡面有 i 值，於是取出 i 值為 5。`console.log(5)`，印出 5 並把 `console.log(5)` 移出 stack。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5
web APIs：cb_timer(3秒)、cb_timer(4秒)
call queue：cb
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 44. 因為 `cb()` 已經執行完畢，所以 `cb()` 移出 stack，同時清除 cbEC。stack 已清空。同時 webAPIs 也在處理那些 Timer 需求。所以 3 秒後返回 cb_timer(3秒) 到 call queue。cb_timer(3秒) 在 webAPIs 結束。call queue 多了一個 cb 待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5
web APIs：cb_timer(4秒)
call queue：cb
event loop → call stack
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 45. stack 已清空。所以 event loop 繼續查找待執行。找到 call queue 有待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5
web APIs：cb_timer(4秒)
call queue：cb
event loop → call queue
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 46. call queue 發現有個待執行。於是把 call queue 的內容，移到 stack。把 cb 放入 stack 且因為 cb 是 function，所以進入 cbEC，產生 AO 並初始化。因為沒有需要編譯的部份，所以 AO 為空。產生一個 cb.[[Scope]] 內容等於 globalEC.scopeChain 會等於 globalEC.VO。cbEC 的 scopeChain 等於 `[cbEC.AO,  cb.[[Scope]]]`，實際上等同於 `[cbEC.AO, globalEC.VO]`。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5
web APIs：cb_timer(4秒)
call queue：cb
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 47. cb 裡面，有 `console.log(i)`，把 `console.log(i)` 放入 stack。
stack：`cb()`、`console.log(i)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5
web APIs：cb_timer(4秒)
call queue：cb
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 48. 執行 `console.log(i)`，於是開始找尋變數 i 的值，通過 cbEC.scopeChain 開始找，`[cbEC.AO, globalEC.VO]` 先找尋 cbEC.AO，裡面沒有。所以找往後找，找尋 globalEC.VO，裡面有 i 值，於是取出 i 值為 5。`console.log(5)`，印出 5 並把 `console.log(5)` 移出 stack。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5
web APIs：cb_timer(4秒)
call queue：cb
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 49. 因為 `cb()` 已經執行完畢，所以 `cb()` 移出 stack，同時清除 cbEC。stack 已清空。同時 webAPIs 也在處理那些 Timer 需求。所以 4 秒後返回 cb_timer(4秒) 到 call queue。cb_timer(4秒) 在 webAPIs 結束。call queue 多了一個 cb 待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5
web APIs：
call queue：cb
event loop → call stack
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 50. stack 已清空。所以 event loop 繼續查找待執行。找到 call queue 有待執行。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5
web APIs：
call queue：cb
event loop → call queue
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 51. call queue 發現有個待執行。於是把 call queue 的內容，移到 stack。把 cb 放入 stack 且因為 cb 是 function，所以進入 cbEC，產生 AO 並初始化。因為沒有需要編譯的部份，所以 AO 為空。產生一個 cb.[[Scope]] 內容等於 globalEC.scopeChain 會等於 globalEC.VO。cbEC 的 scopeChain 等於 `[cbEC.AO,  cb.[[Scope]]]`，實際上等同於 `[cbEC.AO, globalEC.VO]`。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5
web APIs：
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 


#### 52. cb 裡面，有 `console.log(i)`，把 `console.log(i)` 放入 stack。
stack：`cb()`、`console.log(i)`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5
web APIs：
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 53. 執行 `console.log(i)`，於是開始找尋變數 i 的值，通過 cbEC.scopeChain 開始找，`[cbEC.AO, globalEC.VO]` 先找尋 cbEC.AO，裡面沒有。所以找往後找，找尋 globalEC.VO，裡面有 i 值，於是取出 i 值為 5。`console.log(5)`，印出 5 並把 `console.log(5)` 移出 stack。
stack：`cb()`
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5    5
web APIs：
call queue：
event loop → call stack
```
cbEC: {
  AO {
  
  }
  scopeChain: [cbEC.AO, globalEC.VO]
}

cb.[[Scope]] = globalEC.scopeChain => [globalEC.VO]

======

globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 54. 因為 `cb()` 已經執行完畢，所以 `cb()` 移出 stack，同時清除 cbEC。stack 已清空。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5    5
web APIs：
call queue：
event loop → call stack
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

#### 55. stack 已清空。所以 event loop 繼續查找待執行。發現都沒有要執行的，所以程式結束。但 event loop 持續查找中。
stack：
印出的資料：`i: 0`    `i: 1`    `i: 2`    `i: 3`    `i: 4`    5    5    5    5    5
web APIs：
call queue：
event loop：checking
```
globalEC: {
  VO {
    i: 5,
  }
  scopeChain: [globalEC.VO]
}
``` 

最後結果
`i: 0`
`i: 1`
`i: 2`
`i: 3`
`i: 4`
5
（間隔一秒）
5
（間隔一秒）
5
（間隔一秒）
5
（間隔一秒）
5