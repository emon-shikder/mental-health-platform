import api from './api';

export const resourceService = {
  async getResources() {
    const response = await api.get('/resources/');
    return response.data;
  },

  async getResourcesByType(type) {
    const response = await api.get(`/resources/?type=${type}`);
    return response.data;
  },

  async getResource(id) {
    const response = await api.get(`/resources/${id}/`);
    return response.data;
  },
}; 