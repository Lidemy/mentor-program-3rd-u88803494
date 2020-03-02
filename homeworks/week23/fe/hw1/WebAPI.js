// eslint-disable-next-line import/no-unresolved
import axios from 'axios';

export const createPost = post => axios.post('https://qootest.com/posts/', post);

export const getPosts = () => axios.get('https://qootest.com/posts?_sort=id&_order=desc'); // 逆排序改用伺服的

export const getPost = postId => axios.get(`https://qootest.com/posts/${postId}`);

export const updatePost = post => axios.put(`https://qootest.com/posts/${post.id}`, post);

export const deletePost = postId => axios.delete(`https://qootest.com/posts/${postId}`);

/**
 * 當需要展示的時候，可以加上錯誤的 API，並加上按鈕。
 * 跟實際有作用的按鈕分開，這樣就可以很方便的展示。
 * 另外撈資料就可以改排序
 */
