function alphaSwap(str) {
  let result = '';
  for (let i = 0; i < str.length; i += 1) {
    if (str[i] >= 'A' && str[i] <= 'Z') {
      result += str[i].toLowerCase();
    } else {
      result += str[i].toUpperCase();
    }
  }
  return result;
}

module.exports = alphaSwap;
