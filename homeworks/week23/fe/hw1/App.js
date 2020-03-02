import React from 'react';
import './App.css';
import { HashRouter as Router, Route } from 'react-router-dom';
import PostList from './containers/PostsListContainer';
import ArticleManagement from './containers/ArticleManagementContainer';
import Nav from './component/nav';
import Home from './component/home';
import Posts from './component/posts';
import About from './component/about';
import Footer from './component/footer';

const App = () => (
  <Router>
    <div className="App">
      <Nav />
      <ArticleManagement />
      <Route exact path="/" component={Home} />
      <Route exact path="/posts" component={PostList} />
      <Route path="/about" component={About} />
      <Route path="/posts/:postId" component={Posts} />
      <Footer />
    </div>
  </Router>
);


export default App;
