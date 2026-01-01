<template>
  <div>
    <nav :class="navClasses">
      <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <!-- Logo -->
        <Link href="/" class="flex items-center gap-2 text-2xl font-bold">
          <span class="text-gray-800 dark:text-white">clipboard.lol</span>
        </Link>

        <!-- Right Side Buttons -->
        <div class="flex items-center gap-4">
          <Link
            href="/"
            class="px-4 py-2 text-sm font-medium rounded transition"
            :class="isHome ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800'"
          >
            Home
          </Link>
          <Link
            href="/pastes/create"
            class="px-4 py-2 text-sm font-medium rounded transition text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800"
          >
            Create
          </Link>
          <button
            @click="toggleTheme"
            :class="themeButtonClasses"
            class="px-4 py-2 text-sm font-medium rounded transition"
            :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
          >
            <i :class="isDark ? 'fas fa-sun' : 'fas fa-moon'"></i>
          </button>
        </div>
      </div>
    </nav>
    
    <!-- Footer -->
    <footer :class="footerClasses">
      <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm">
        <Link href="/tos" class="text-blue-600 dark:text-blue-400 hover:underline">
          Terms of Service
        </Link>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useTheme } from '../composables/useTheme';

const page = usePage();
const { isDark, toggleTheme } = useTheme();

const isHome = computed(() => {
  return page.url === '/';
});

const navClasses = computed(() => [
  'border-b transition-colors',
  isDark.value
    ? 'bg-gray-950 border-gray-800 text-white'
    : 'bg-white border-gray-200 text-gray-900'
]);

const themeButtonClasses = computed(() =>
  isDark.value
    ? 'bg-gray-800 text-white hover:bg-gray-700'
    : 'bg-gray-200 text-gray-900 hover:bg-gray-300'
);

const footerClasses = computed(() => [
  'border-t transition-colors text-center',
  isDark.value
    ? 'bg-gray-900 border-gray-800 text-gray-400'
    : 'bg-gray-100 border-gray-200 text-gray-600'
]);
</script>
