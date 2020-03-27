## Redux 如何解決非同步（例如說 call API 拿資料）的問題
在 Redux 中，是利用 middleware 的方式去解決這個問題的。

Redux-middleware 又稱為中間件，方式是使用 action 呼叫 middleware，然後 middleware 會在呼叫處理回傳結果的 action 就會把的結果送到 reducer。

這樣稱為 action-in、action-out。