import axios from 'axios';

export const createPost = post => axios.post('https://qootest.com/posts/', post);

export const getPosts = () => axios.get('https://qootest.com/posts?_sort=id&_order=desc'); // 逆排序改用伺服的

export const getPost = postId => axios.get(`https://qootest.com/posts/${postId}`);

export const updatePost = post => axios.put(`https://qootest.com/posts/${post.id}`, post);

export const deletePost = postId => axios.delete(`https://qootest.com/posts/${postId}`);

// wrong API
export const errorCreatePost = post => axios.post('https://qootest.com/poss/', post);

export const errorUpdatePost = post => axios.put(`https://qootest.com/poss/${post.id}`, post);

export const errorDeletePost = postId => axios.delete(`https://qootest.com/poss/${postId}`);
