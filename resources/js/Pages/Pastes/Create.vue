<template>
  <div :class="pageClasses">
    <Navbar />
    <div class="max-w-4xl mx-auto py-12 px-4">
      <Link href="/" :class="linkClasses">← Back to Home</Link>
      <h1 class="text-4xl font-bold mb-8" :class="titleClasses">Create New Paste</h1>
      
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="title" class="block text-sm font-medium mb-2" :class="labelClasses">Title (Optional)</label>
          <input
            id="title"
            v-model="form.title"
            type="text"
            placeholder="Give your paste a title..."
            :class="inputClasses"
          />
        </div>

        <div>
          <label for="content" class="block text-sm font-medium mb-2" :class="labelClasses">Content</label>
          <textarea
            id="content"
            v-model="form.content"
            placeholder="Paste your content here..."
            rows="20"
            :class="textareaClasses"
          ></textarea>
          <p v-if="errors.content" class="mt-2 text-red-500 text-sm">{{ errors.content }}</p>
        </div>

        <div>
          <label for="expiration" class="block text-sm font-medium mb-2" :class="labelClasses">Expiration Date (Optional)</label>
          <input
            id="expiration"
            v-model="form.expiration_date"
            type="date"
            :class="inputClasses"
          />
          <p class="mt-1 text-xs" :class="isDark ? 'text-gray-400' : 'text-gray-600'">Leave empty for no expiration</p>
        </div>

        <div class="flex gap-4">
          <button
            type="submit"
            :disabled="processing"
            :class="submitButtonClasses"
          >
            {{ processing ? 'Creating...' : 'Create Paste' }}
          </button>
          <Link
            href="/"
            :class="cancelButtonClasses"
          >
            Cancel
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { useTheme } from '../../composables/useTheme';
import Navbar from '../../components/Navbar.vue';

const form = useForm({
  title: '',
  content: '',
  expiration_date: '',
});

const { isDark } = useTheme();
const processing = ref(false);
const errors = ref({});

const pageClasses = computed(() => [
  'min-h-screen transition-colors',
  isDark.value ? 'bg-gray-950 text-gray-100' : 'bg-gray-50 text-gray-900'
]);

const linkClasses = computed(() =>
  isDark.value
    ? 'text-blue-400 hover:text-blue-300 mb-4 inline-block'
    : 'text-blue-600 hover:text-blue-700 mb-4 inline-block'
);

const titleClasses = computed(() =>
  isDark.value ? 'text-white' : 'text-gray-900'
);

const labelClasses = computed(() =>
  isDark.value ? 'text-gray-300' : 'text-gray-700'
);

const inputClasses = computed(() => [
  'w-full px-4 py-2 rounded border transition-colors focus:outline-none focus:border-blue-500',
  isDark.value
    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
]);

const textareaClasses = computed(() => [
  'w-full px-4 py-2 rounded border font-mono text-sm transition-colors focus:outline-none focus:border-blue-500',
  isDark.value
    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
]);

const submitButtonClasses = computed(() =>
  'px-6 py-2 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-medium rounded transition'
);

const cancelButtonClasses = computed(() => [
  'px-6 py-2 font-medium rounded transition text-center',
  isDark.value
    ? 'bg-gray-800 hover:bg-gray-700 text-white'
    : 'bg-gray-200 hover:bg-gray-300 text-gray-900'
]);

const submit = () => {
  processing.value = true;
  errors.value = {};
  
  form.post('/pastes', {
    onError: (err) => {
      errors.value = err;
      processing.value = false;
    },
  });
};
</script>
