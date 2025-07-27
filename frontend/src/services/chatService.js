import api from './api';

export const chatService = {
  async getChatRooms() {
    const response = await api.get('/chat/rooms/');
    return response.data;
  },

  async getMessages(roomId) {
    const response = await api.get(`/chat/rooms/${roomId}/messages/`);
    return response.data;
  },

  async sendMessage(roomId, content) {
    const response = await api.post(`/chat/rooms/${roomId}/messages/`, { content });
    return response.data;
  },

  async createRoom(roomType = 'student-counselor') {
    const response = await api.post('/chat/rooms/', { room_type: roomType });
    return response.data;
  },
}; 