function isPalindromes(str) {
  const lowerCaseStr = str.toLowerCase();
  // 因為題目的迴文的定義是唸出來，所以不會有大小寫的問題，故需要轉換成小寫作比較。
  const newStr = lowerCaseStr.split('').reverse().join('');
  if (newStr !== lowerCaseStr) {
    return false;
  }
  return true;
}

module.exports = isPalindromes;
