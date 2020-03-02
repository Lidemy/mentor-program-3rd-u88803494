import React, { useState, useEffect } from 'react';
import { Button, Modal, Form } from 'react-bootstrap';
import * as webAPI from '../../WebAPI';

const EditingWindow = ({
  show, method, postId, posts, onHide, changePosts,
}) => {
  /** show: 彈出視窗顯示與否，method: 文章送出要用的方法，postId、posts: 用來編輯的資料
   * onHide: 關閉視窗用，changePosts: 上傳文章用 */

  const newPost = { title: '', author: '', body: '' }; // 新增文章用的預設值
  const editingPost = posts.find(post => post.id === postId); // 取得資料
  const defaultEmpty = { title: false, author: false, body: false }; // 偵測文章是否為空的預設狀態
  const defaultSubmitType = { canSubmit: true, status: '' }; // 是否可以提交的預設狀態

  const [thisPost, setThisPost] = useState(postId ? editingPost : newPost);
  const [isEmpty, setEmpty] = useState(defaultEmpty); // 為了一開始不偵測
  const [submitType, setSubmitType] = useState(defaultSubmitType); // 一開始先不偵測

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
      setSubmitType({ canSubmit: false, status: '資料不全，無法送出，繼續完成資料才可送出' });
      return;
    }

    const whichAPI = () => (method === 'create'
      ? webAPI.createPost(thisPost) : webAPI.updatePost(thisPost));

    const submitPost = () => { // 像這個想詢問一下，可以往上獲取資料，我還需要特別傳入嗎？
      changePosts({ method, thisPost }); // 改變 redux 上的 store
      onHide(); /** 進一步可優化顯示傳送中，成功後顯示成功 */
    };

    const onError = (err) => {
      setSubmitType({ canSubmit: false, status: `發生問題無法送出 ${err}` });
    };

    whichAPI(thisPost, method)
      .then(res => res.status <= 300 && submitPost(method, thisPost))
      .catch(err => onError(err)); // .then .catch 是否會自己判斷 status?
    /** 可加上 google CAPTCHA 驗證
     * 之前曾經用過，之後可以加上個驗證功能
    */
  };

  useEffect(() => { // 相當於 componenDidUpdate
    if (thisPost.title && thisPost.author && thisPost.body) {
      setSubmitType({ canSubmit: true, status: '' });
    } // render 檢測值是否為空
  }, [thisPost]);

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
              <Form.Label>內文</Form.Label>
              <Form.Text className="form__empty">
                {isEmpty.body && '內容不能為空'}
              </Form.Text>
            </div>
            <Form.Control
              name="body"
              as="textarea"
              rows="5"
              placeholder="輸入內文"
              value={thisPost && thisPost.body}
              onChange={changePost}
            />
          </Form.Group>
          <Form.Text className="form__empty form__empty--submit">
            {submitType.status}
          </Form.Text>
        </Modal.Body>
        <Modal.Footer>
          <Button
            variant="outline-secondary"
            onClick={onHide}
          >
            Close
          </Button>
          <Button
            variant="outline-primary"
            onClick={handleSubmit}
            disabled={!submitType.canSubmit}
          >
            {method === 'editing' ? '儲存文章' : '新增文章'}
          </Button>
        </Modal.Footer>
      </Form>
    </Modal>
  );
};

export default EditingWindow;
