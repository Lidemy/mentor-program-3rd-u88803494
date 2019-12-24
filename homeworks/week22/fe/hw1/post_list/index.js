import React, { Component } from 'react';
import { withRouter } from 'react-router-dom';
import axios from 'axios';

class Posts extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
    }
  }

  componentDidMount() {
    axios.get('https://qootest.com/posts')
      .then(res => {
        this.setState({
          data: res.data.filter(({ title, author }) => title && author),
        }); // 太多無用資料，決定先篩選，才使用。
      });
  }

  // 待刪除
  post = (data, page) => (
    <div className="blog__post">
      <ul className="blog__title">{data[page]['title']}</ul>
      <hr />
      <div className="blog__article">{data[page]['body']}</div>
    </div>
  )

  render() {
    const { data } = this.state;
    const { history } = this.props;
    return (
      <div className="blog">部落格文章
          <div className="blog__posts">
          {
            data.map(post => (
              <ul
                className="blog__title"
                key={post.id}
                onClick={() => history.push("/posts/" + post.id)}
              >
                {post.title}
              </ul>
            ))
          }
        </div>
      </div>
    )
  }
}

export default withRouter(Posts);
