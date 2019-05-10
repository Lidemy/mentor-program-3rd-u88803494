function isPrime(n) {
  if (n === 1) return false;
  const primeTestTimes = Math.sqrt(n);
  for (let i = 2; i <= primeTestTimes; i += 1) {
    if (n % i === 0) {
      return false;
    }
  }
  return true;
}

module.exports = isPrime;
