import React, { useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { ListGroup, Button, Spinner } from 'react-bootstrap';
import './post_list.css';

const RenderPosts = ({ data, history, showManagementWindow }) => {
  const handleShow = (e) => {
    const { id, name } = e.target.dataset;
    showManagementWindow({ method: name, postId: parseInt(id, 10) }); // event 接收的是 string
  };

  return (
    <>
      {data.map(post => (
        <ListGroup.Item
          key={post.id}
          className="blog__post"
        >
          <div
            className="blog__title"
            onClick={() => history.push(`/posts/${post.id}`)}
          >
            {post.title}
          </div>
          <div className="blog__controller">
            <Button
              variant="outline-success"
              data-name="editing"
              data-id={post.id}
              onClick={handleShow}
            >
              編輯
            </Button>
            <Button
              variant="outline-danger"
              data-name="delete"
              data-id={post.id}
              onClick={handleShow}
            >
              刪除
            </Button>
          </div>
        </ListGroup.Item>
      ))}
    </>
  );
};

const Posts = ({
  history, postsListData, showManagementWindow, getPosts, shouldGetPosts
}) => {
  const handleShowWindows = e => showManagementWindow({ method: e.target.name });

  useEffect(() => {
    if (shouldGetPosts) getPosts();
  }, [getPosts, shouldGetPosts]); // 一開始 ture 會取得值，然後後續修改成功之後也會取得值

  return (
    <div className="blog">
      <header className="header">
        <div className="header__title">部落格文章</div>
        <div className="header__newpost">
          <Button variant="outline-primary" onClick={handleShowWindows} name="create">
            新增文章
          </Button>
        </div>
      </header>{ console.log(postsListData)}
      <main className="blog__posts">
        {/** 判斷是否讀取中 */
          postsListData.length
            ? <RenderPosts data={postsListData} {...{ history, showManagementWindow }} />
            : <Spinner animation="border" />
        }
      </main>
    </div>
  );
};

export default withRouter(Posts);
