## 交作業流程
1. 在寫作業的時候，必須要先開一個 branch (分支)，取個方便了解到這是什麼樣的作業的名字即可，例如：本周是第一周就取名 week1。
指令 `git branch week1`，即可建立一個新的 branch (分支)。
2. 接著切換到該分支。指令`git checkout week1`
3. 接下來就可以寫作業了。
4. 作業完成之後，可以輸入指令檢查 `git status`  如果出現有更改的作業有呈現 `modified: `  那就表示作業已經修改過了，還沒 commit。所以輸入 `git commit -am "Week1完成"` 就可以 add 且 commit 作業了。
5. push 作業：指令 `git push origin week1` 就可以把作業傳到 GitHub。
6. 這時候 GitHub 的 repository 就會出現可以 merge 的選項：Compare & pull request。
7. 點下之後，就可以輸入標題跟內文，然後點選 Create pull request。
8. 接著到 [交作業專用 repository](https://github.com/Lidemy/homeworks-3rd/i) 開一個新的 Issues 標題打[Week1]，內文輸入作業網址。
9. 接著等批改作業，批改完成之後，就會被老師 merge，然後該 branch 也會被刪除。Issues 也會被關閉。如果作業有些地方要修改，老師也會先 merge，但這時候我們就需要另外在開新的 branch 來寫作業，所以就要回到步驟 1 重新開始寫了之後在依序做到這個步驟。
10. 作業完成之後，回到本機，使用指令`git checkout master` 切回主分支。 
11. 然後把完成的作業 pull 下來，輸入`git pull origin master` 
12. 接著刪除本機上面的其他 branch，輸入`git branch -d week1`，如果要檢查，輸入`git branch` 就會顯示當前有哪些 branch，只剩下 master 那就是大功告成了。
13. 然後再把[學習系統](https://lidemy-learning-center.netlify.com/) 的第一周給按下完成。
14. 其他周就是按照上述流程提交作業。