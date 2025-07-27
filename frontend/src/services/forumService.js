import api from './api';

export const forumService = {
  async getPosts() {
    const response = await api.get('/forum/posts/');
    return response.data;
  },

  async createPost(title, content) {
    const response = await api.post('/forum/posts/', { title, content });
    return response.data;
  },

  async likePost(postId) {
    const response = await api.post(`/forum/posts/${postId}/like/`);
    return response.data;
  },

  async getComments(postId) {
    const response = await api.get(`/forum/posts/${postId}/comments/`);
    return response.data;
  },

  async addComment(postId, content) {
    const response = await api.post(`/forum/posts/${postId}/comments/`, { content });
    return response.data;
  },
}; 