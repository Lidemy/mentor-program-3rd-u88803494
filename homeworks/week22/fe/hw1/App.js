import React from 'react';
import './App.css';
import { BrowserRouter as Router, Route } from "react-router-dom";
import Nav from './nav/';
import Home from './home/';
import PostList from './post_list/';
import Posts from './posts/';

function About() {
  return (
    <div className="about">
      <h1 className="about__title">maxime quas veniam</h1>
      <div className="about__content">
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
        Omnis alias harum voluptatem nostrum vero mollitia cum,
        voluptas neque praesentium provident quasi, obcaecati enim consequatur illo.
        Hic autem minus aperiam velit.
        Ducimus corrupti iusto officia aperiam eius ad neque sit minima ut
        nostrum aliquideaque qui maxime quas veniam doloremque quaerat repellendus esse,
        rem dolorum tempora perspiciatis impedit?
        Possimus omnis pariatur et quia eum molestiae, sint unde,
        reprehenderit recusandae consequuntur iusto eos quis ipsum veritatis,
        tempore deleniti totam sunt nisi a!
        </div>
    </div>
  )
}

class App extends React.Component {
  render() {
    return (
      <Router>
        <div className="App">
          <Nav />
          <Route exact path="/" component={Home} />
          <Route exact path="/posts" component={PostList} />
          <Route path="/about" component={About} />
          <Route path="/posts/:postId" component={Posts} />
        </div>
      </Router>
    );
  }
}

export default App;
