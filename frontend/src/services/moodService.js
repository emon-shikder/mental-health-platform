import api from './api';

export const moodService = {
  async submitMood(mood, notes = '') {
    const response = await api.post('/mood/entries/', { mood, notes });
    return response.data;
  },

  async getMoodHistory() {
    const response = await api.get('/mood/entries/');
    return response.data;
  },

  async getMoodStats() {
    const response = await api.get('/mood/stats/');
    return response.data;
  },
}; 