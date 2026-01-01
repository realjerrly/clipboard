import { ref, watch, onMounted } from 'vue';

const isDark = ref(false);

export function useTheme() {
  const toggleTheme = () => {
    isDark.value = !isDark.value;
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
    applyTheme();
  };

  const applyTheme = () => {
    if (isDark.value) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  };

  onMounted(() => {
    // Check localStorage first
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      isDark.value = savedTheme === 'dark';
    } else {
      // Check system preference
      isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    applyTheme();
  });

  watch(isDark, () => {
    applyTheme();
  });

  return {
    isDark,
    toggleTheme,
  };
}
