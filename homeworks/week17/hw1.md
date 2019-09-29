## hw1:
在 JavaScript 裡面，一個很重要的概念就是 Event Loop，是 JavaScript 底層在執行程式碼時的運作方式。請你說明以下程式碼會輸出什麼，以及儘可能詳細地解釋原因。
```
console.log(1)
setTimeout(() => { // 當作 cb1
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => { // 當作 cb2
  console.log(4)
}, 0)
console.log(5)
```
因為直式的寫，很難排版，所以我用橫的方式來寫，按照先左邊後右邊的順序。

1. 首先進入程式時，先把主要區域的 `main()` 放入 stack 
stack： `main()`

2. `console.log(1)` 放入 stack
stack： `main()`、`console.log(1)`

3. 執行 `console.log(1)` 印出 1 ，然後從 stack 拿掉
stack： `main()`
印出的資料：1  

4. `setTimeout(cb1)` 放入 stack
stack： `main()`、`setTimeout(cb1)`
印出的資料：1  

5. 執行 `setTimeout(cb1)`，呼叫 web APIs ，0 秒後執行 cd1，並從 stack 拿掉 `setTimeout(cb1)`。0 秒到了，web APIs 把 cb1 放入 callback queue。
stack： `main()`
印出的資料：1
callback queue：cb1

6. `console.log(3)` 放入 stack。
stack： `main()`、`console.log(3)` 
印出的資料：1  
callback queue：cb1

7. `console.log(3)` 執行，印出 3，然後從 stack 拿掉  `console.log(3)` 
stack： `main()`
印出的資料：1    3
callback queue：cb1

8.  `setTimeout(cb2)` 放入 stack
stack： `main()`、`setTimeout(cb2)`
印出的資料：1    3
callback queue：cb1

9. 執行 `setTimeout(cb2)`，呼叫 web APIs ，0 秒後執行 cd1，並從 stack 拿掉 `setTimeout(cb2)`。0 秒到了，web APIs 把 cb2 放入 callback queue。
stack： `main()`
印出的資料：1    3
callback queue：cb1、cb2

10. `console.log(5)` 放入 stack。
stack： `main()`、`console.log(5)` 
印出的資料：1    3
callback queue：cb1、cb2

11. `console.log(5)` 執行，印出 5，然後從 stack 拿掉  `console.log(5)` 
stack： `main()`
印出的資料：1    3    5
callback queue：cb1、cb2

12. `main()` 全部執行完畢。stack 移出 `main()`。
stack： 
印出的資料：1    3    5
callback queue：cb1、cb2

13. stack 沒資料了，所以 event loop 去 callback queue 找尋資料。找到有 cb1，所以把 cb1 放進 stack，並進入 cb1。
stack： cb1
印出的資料：1    3    5
callback queue：cb2

14. cb1 裡面有內容 `console.log(2)` ，把  `console.log(2)` 放入 stack。
stack： cb1、`console.log(2)` 
印出的資料：1    3    5
callback queue：cb2

15. 執行 `console.log(2)` 印出 2，把  `console.log(2)` 移出 stack。
stack： cb1
印出的資料：1    3    5    2
callback queue：cb2

16. cd1 執行結束，退出 cb1，把 cb1 移出 stack。
stack： 
印出的資料：1    3    5    2
callback queue：cb2

17. stack 以清空，所以 event loop 去找尋 callback queue，發現有 cb2。於是把 cb2 放入 stack 並進入 cb2
stack： cb2
印出的資料：1    3    5    2
callback queue：

18.  cb2 裡面有內容 `console.log(4)` ，把  `console.log(4)` 放入 stack。
stack： cb2、`console.log(4)` 
印出的資料：1    3    5    2
callback queue：

19. 執行 `console.log(4)` 印出 4，把  `console.log(4)` 移出 stack。
stack： cb2
印出的資料：1    3    5    2    4
callback queue：

20. cd2 執行結束，退出 cb2，把 cb2 移出 stack。
stack： 
印出的資料：1    3    5    2    4
callback queue：

全部執行結束，結果是印出了
1
3
5
2
4

