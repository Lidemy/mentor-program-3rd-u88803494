const request = require('request');

const process = require('process');

if (process.argv[2] === 'list') {
  request('https://lidemy-book-store.herokuapp.com/books?_limit=20', (_error, _response, body) => {
    console.log(body);
  });
}

if (process.argv[2] === 'read') {
  request(`https://lidemy-book-store.herokuapp.com/books/${process.argv[3]}`, (_error, _response, body) => {
    console.log(body);
  });
}
