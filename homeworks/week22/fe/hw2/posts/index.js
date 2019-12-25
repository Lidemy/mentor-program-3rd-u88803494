import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

class Post extends Component {
  constructor(props) {
    super(props);
    this.state = {
      post: {},
    }
  }

  componentDidMount() {
    const { postId } = this.props.match.params;
    axios.get('https://qootest.com/posts/' + postId)
      .then(res => {
        this.setState({
          post: res.data,
        })
      })
  }

  render() {
    const { post } = this.state;
    return (
      <div>
        <h1>POST</h1>
        <Link to="/posts"><button> back</button> </Link>
        <div>
          <h1>{post.title ? post.title : 'Loading'}</h1>
          <hr />
          <p className="blog__article">{post.body}</p>
        </div>
      </div>
    );

  }
}

export default Post;
