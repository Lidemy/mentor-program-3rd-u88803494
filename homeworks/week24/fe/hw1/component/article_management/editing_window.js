import React, { useState, useEffect } from 'react';
import { Button, Modal, Form } from 'react-bootstrap';

const EditingWindow = ({
  show, method, onHide, error, defaultState, createPost, updatePost, shouldGetPosts, errorCreatePost, errorUpdatePost,
}) => {
  const [thisPost, setThisPost] = useState(defaultState.post);
  const [isEmpty, setEmpty] = useState(defaultState.empty); // 為了一開始不偵測
  const [submitType, setSubmitType] = useState(defaultState.submitType); // 一開始先不偵測

  const changePost = (e) => {
    if (!e.target.value) { // 輸入時確認是否為空
      setEmpty({ ...isEmpty, [e.target.name]: true });
    } else {
      setEmpty({ ...isEmpty, [e.target.name]: false });
    }
    setThisPost({ ...thisPost, [e.target.name]: e.target.value });
  };

  const handleSubmit = () => {
    if (!thisPost.title || !thisPost.author || !thisPost.body) {
      setSubmitType({ canSubmit: false, status: '資料不全，無法送出，繼續完成資料才可送出', button: '無法送出' });
      return;
    }
    setSubmitType({ canSubmit: false, status: '', button: '傳送中' });
  }; // 可加上 google CAPTCHA 驗證

  const handleErrorSubmit = () => {
    if (!thisPost.title || !thisPost.author || !thisPost.body) {
      setSubmitType({ canSubmit: false, status: '資料不全，無法送出，繼續完成資料才可送出', button: '無法送出' });
      return;
    }
    setSubmitType({ canSubmit: false, status: '', button: '傳送中.' });
  }; // 可加上 google CAPTCHA 驗證

  useEffect(() => {
    if (submitType.button === '傳送中') {
      if (method === 'create') createPost(thisPost);
      if (method === 'editing') updatePost(thisPost);
    }
    if (submitType.button === '傳送中.') {
      if (method === 'create') errorCreatePost(thisPost);
      if (method === 'editing') errorUpdatePost(thisPost);
    }
  }, [
    submitType.button, createPost, updatePost, method, thisPost, errorCreatePost, errorUpdatePost,
  ]);

  useEffect(() => {
    if (shouldGetPosts) setSubmitType({ ...submitType, button: '傳送成功' });
  }, [shouldGetPosts, submitType]);

  useEffect(() => {
    if (thisPost.title && thisPost.author && thisPost.body) {
      setSubmitType({ canSubmit: true, status: '', button: '送出' });
    }
  }, [thisPost]); // render 後檢測值是否為空

  useEffect(() => {
    if (error) { // 有錯誤的值就顯示出來
      setSubmitType({ canSubmit: false, status: `發生問題無法送出 ${error}`, button: '無法送出' });
      setTimeout(() => setSubmitType({ canSubmit: true, status: '', button: '送出' }), 2000);
    }
  }, [error]);

  return (
    <Modal
      size="lg"
      aria-labelledby="contained-modal-title-vcenter"
      centered
      {...{ onHide, show }}
    >
      <Modal.Header closeButton>
        <Modal.Title id="contained-modal-title-vcenter">
          {method === 'editing' ? '你正在編輯文章' : '你正在新增文章'}
        </Modal.Title>
      </Modal.Header>
      <Form>
        <Modal.Body>
          <Form.Group>
            <div className="form__datatype">
              <Form.Label>標題</Form.Label>
              <Form.Text className="form__empty">
                {isEmpty.title && '標題不能為空'}
              </Form.Text>
            </div>
            <Form.Control
              name="title"
              type="text"
              placeholder="Enter title"
              value={thisPost && thisPost.title}
              onChange={changePost}
            />
          </Form.Group>
          <Form.Group>
            <div className="form__datatype">
              <Form.Label>作者</Form.Label>
              <Form.Text className="form__empty">
                {isEmpty.author && '作者不能為空'}
              </Form.Text>
            </div>
            <Form.Control
              name="author"
              type="text"
              placeholder="author/作者"
              value={thisPost && thisPost.author}
              onChange={changePost}
            />
          </Form.Group>
          <Form.Group>
            <div className="form__datatype">
              <Form.Label>
                內文
              </Form.Label>
              <Form.Text className="form__empty">
                {isEmpty.body && '內容不能為空'}
              </Form.Text>
            </div>
            <Form.Control
              name="body"
              as="textarea"
              rows="5"
              placeholder="輸入內文 支援 markdown 格式"
              value={thisPost && thisPost.body}
              onChange={changePost}
            />
          </Form.Group>
          <div className="form__datatype">
            <Form.Text className="form__notice">
              支援 markdown 格式
            </Form.Text>
            <Form.Text className="form__empty form__empty--submit">
              {submitType.status}
            </Form.Text>
          </div>
        </Modal.Body>
        <Modal.Footer>
          <Button variant="outline-secondary" onClick={onHide}>
            Close
          </Button>
          <Button
            variant="outline-primary"
            onClick={handleSubmit}
            disabled={!submitType.canSubmit}
          >
            {submitType.button}
          </Button>
          <Button
            variant="outline-primary"
            onClick={handleErrorSubmit}
            disabled={!submitType.canSubmit}
          >
            {`${submitType.button === '送出' ? '錯誤' : ''}${submitType.button}`}
          </Button>
        </Modal.Footer>
      </Form>
    </Modal>
  );
};

export default EditingWindow;
