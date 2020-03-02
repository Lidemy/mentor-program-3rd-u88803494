import React, { useState, useEffect } from 'react';
import { Button, Modal } from 'react-bootstrap';
import * as webAPI from '../../WebAPI';

const DeleteWindow = ({
  onHide, show, postId, method, changePosts,
}) => {
  const [loadingState, setLoadingState] = useState('是的，我要刪除');

  useEffect(() => {
    const changePostsSucess = () => {
      changePosts({ method, postId });
      onHide();
    };

    const isSuccess = success => (success ? setLoadingState('刪除成功！') : setLoadingState('刪除失敗！'));
    const deleteReset = success => (success ? changePostsSucess() : setLoadingState('是的，我要刪除'));

    const finalExecution = (success) => {
      isSuccess(success);
      setTimeout(() => { deleteReset(success); }, 1000);
    }; /** 放內部就不用使用 useCallback */

    if (loadingState === '刪除中........') {
      webAPI.deletePost(postId) // 改變伺服器
        .then(res => res.status < 300 && finalExecution(true))
        .catch(() => finalExecution(false));
    }
  }, [loadingState, changePosts, postId, method, onHide]);

  const handleDelete = () => setLoadingState('刪除中........');

  return (
    <Modal size="lg" aria-labelledby="contained-modal-title-vcenter" centered {...{ onHide, show }}>
      <Modal.Header closeButton>
        <Modal.Title id="contained-modal-title-vcenter">
          警告！你正在刪除文章
        </Modal.Title>
      </Modal.Header>
      <Modal.Body>
        你確定要刪除文章嗎？
      </Modal.Body>
      <Modal.Footer>
        <Button variant="outline-secondary" onClick={onHide}>
          不了，我不要刪除
        </Button>
        <Button variant="outline-danger" onClick={handleDelete} disabled={loadingState !== '是的，我要刪除'}>
          {loadingState}
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default DeleteWindow;
