import React, { useEffect } from 'react';
import DeleteWindow from './delete_window';
import EditingWindow from './editing_window';
import './article_management.css';

const ArticleManagement = (props) => {
  const { method, posts, postId, onHide, shouldGetPosts } = props;
  const newPost = { title: '', author: '', body: '' }; // 新增文章用的預設值
  const editingPost = posts.find(post => post.id === postId); // 取得資料
  const defaultState = { // 寫好的預設值用來傳入編輯視窗
    post: postId ? editingPost : newPost,
    empty: { title: false, author: false, body: false },
    submitType: { canSubmit: true, status: '' , button: '送出'},
  }

  useEffect(() => {  // 當 shouldGetPosts 變化且為真時，就是表示送出成功    
    shouldGetPosts && setTimeout(onHide, 1000);
  }, [onHide, shouldGetPosts]);

  return (
    <>
      {method === 'create' && <EditingWindow {...props} {...{ defaultState }} />}
      {method === 'editing' && <EditingWindow {...props} {...{ defaultState }} />}
      {method === 'delete' && <DeleteWindow {...props} {...{ defaultState }} />}
    </>
  );
};

export default ArticleManagement;
