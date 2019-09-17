class Stack {
  constructor() {
    this.arr = [];
  }

  push(item) {
    this.arr[this.arr.length] = item;
  }

  pop() {
    const { length } = this.arr; // 取得長度
    const pop = this.arr[length - 1]; // 取出資料
    this.arr.length = this.arr.length - 1; // 把最後一個砍掉
    return pop; // 回傳取得的最後比資料
    // 取得回應相對資料，然後刪除，之後 return
  }

  now() {
    console.log(this.arr);
  }
}

class Queue {
  constructor() {
    this.arr = [];
  }

  push(item) {
    // 添加到第一個，所以要創造新的 arr 長度+1 的 arr 並把資料填入
    const newArr = new Array(this.arr.length + 1); // 創造一個多一長度的 array

    newArr[0] = item; // 把新增值填入之後，把舊值加入

    for (let i = 1; i <= newArr.length - 1; i += 1) {
      newArr[i] = this.arr[i - 1]; // 加入舊值
    }

    this.arr = newArr; // 覆蓋原值
  }

  pop() {
    const { length } = this.arr; // 取得長度
    const pop = this.arr[length - 1]; // 取出資料
    this.arr.length = this.arr.length - 1; // 把最後一個砍掉
    return pop; // 回傳取得的最後比資料
    // 取得回應相對資料，然後刪除，之後 return
  }
}

const stack = new Stack();
stack.push(10);
stack.push(5);
console.log(stack.pop()); // 5
console.log(stack.pop()); // 10

const queue = new Queue();
queue.push(1);
queue.push(2);
console.log(queue.pop()); // 1
console.log(queue.pop()); // 2
