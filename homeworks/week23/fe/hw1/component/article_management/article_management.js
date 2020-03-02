import React from 'react';
import DeleteWindow from './delete_window';
import EditingWindow from './editing_window';
import './article_management.css';

const ArticleManagement = (props) => {
  const { method } = props;
  return (
    <>
      {method === 'create' && <EditingWindow {...props} />}
      {method === 'editing' && <EditingWindow {...props} />}
      {method === 'delete' && <DeleteWindow {...props} />}
    </>
  );
};

export default ArticleManagement;
