import api from './api';

export const authService = {
  async login(email, password, userType = 'student') {
    const response = await api.post('/auth/login/', { 
      email, 
      password,
      user_type: userType 
    });
    if (response.data.token) {
      localStorage.setItem('token', response.data.token);
      localStorage.setItem('user', JSON.stringify(response.data.user));
      localStorage.setItem('userType', response.data.user.user_type || userType);
    }
    return response.data;
  },

  async register(email, password, firstName, lastName, userType = 'student', additionalData = {}) {
    const response = await api.post('/auth/register/', {
      email,
      password,
      first_name: firstName,
      last_name: lastName,
      user_type: userType,
      ...additionalData
    });
    if (response.data.token) {
      localStorage.setItem('token', response.data.token);
      localStorage.setItem('user', JSON.stringify(response.data.user));
      localStorage.setItem('userType', response.data.user.user_type || userType);
    }
    return response.data;
  },

  async registerCounselor(email, password, firstName, lastName, license, specialization, experience) {
    return this.register(email, password, firstName, lastName, 'counselor', {
      license_number: license,
      specialization,
      years_of_experience: experience
    });
  },

  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    localStorage.removeItem('userType');
  },

  getCurrentUser() {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
  },

  getUserType() {
    return localStorage.getItem('userType') || 'student';
  },

  isAuthenticated() {
    return !!localStorage.getItem('token');
  },

  isCounselor() {
    const userType = this.getUserType();
    return userType === 'counselor' || userType === 'psychologist';
  },

  isStudent() {
    return this.getUserType() === 'student';
  },
}; 