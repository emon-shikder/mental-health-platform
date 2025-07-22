export const MOOD_OPTIONS = [
  { value: 'happy', label: '😊 Happy', color: 'bg-green-500' },
  { value: 'sad', label: '😢 Sad', color: 'bg-blue-500' },
  { value: 'anxious', label: '😰 Anxious', color: 'bg-yellow-500' },
  { value: 'angry', label: '😠 Angry', color: 'bg-red-500' },
  { value: 'excited', label: '🤩 Excited', color: 'bg-purple-500' },
  { value: 'tired', label: '😴 Tired', color: 'bg-gray-500' },
  { value: 'stressed', label: '😤 Stressed', color: 'bg-orange-500' },
  { value: 'calm', label: '😌 Calm', color: 'bg-teal-500' },
];

export const RESOURCE_TYPES = [
  { value: 'article', label: 'Article' },
  { value: 'video', label: 'Video' },
  { value: 'podcast', label: 'Podcast' },
  { value: 'book', label: 'Book' },
  { value: 'app', label: 'App' },
];

export const NAVIGATION_ITEMS = [
  { path: '/', label: 'Home', icon: '🏠' },
  { path: '/forum', label: 'Forum', icon: '📝' },
  { path: '/mood-tracker', label: 'Mood Tracker', icon: '📈' },
  { path: '/chat', label: 'Chat', icon: '💬' },
  { path: '/resources', label: 'Resources', icon: '📚' },
  { path: '/profile', label: 'Profile', icon: '👤' },
];

export const COUNSELOR_NAVIGATION_ITEMS = [
  { path: '/', label: 'Dashboard', icon: '🏠' },
  { path: '/counselor/students', label: 'Students', icon: '👥' },
  { path: '/counselor/chat', label: 'Chat', icon: '💬' },
  { path: '/counselor/resources', label: 'Resources', icon: '📚' },
  { path: '/counselor/profile', label: 'Profile', icon: '👤' },
];

export const USER_TYPES = {
  STUDENT: 'student',
  COUNSELOR: 'counselor',
  PSYCHOLOGIST: 'psychologist'
}; 