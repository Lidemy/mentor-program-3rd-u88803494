function printStars(n) {
  if (n >= 1 && n <= 30) {
    for (let i = 1; i <= n; i += 1) { console.log('*'); }
  } else if (n < 1 || n > 30) {
    console.log('輸入範圍是1~30喔!');
  }
}

printStars(6);
