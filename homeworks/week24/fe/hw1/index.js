import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import { Provider } from 'react-redux';
import { createStore, combineReducers, applyMiddleware } from 'redux';
import promise from 'redux-promise-middleware';
import ReduxThunk from 'redux-thunk';
import logger from 'redux-logger';
import App from './App';
import * as serviceWorker from './serviceWorker';
import { postsReducer, windowReducer } from './reducer';

const reducers = combineReducers({
  posts: postsReducer,
  postState: windowReducer,
});

const store = createStore(reducers, applyMiddleware(promise, ReduxThunk, logger));

ReactDOM.render(
  <Provider store={store}>
    <App name="hugh" />
  </Provider>, document.getElementById('root'),
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
