<template>
  <div :class="pageClasses">
    <Navbar />
    <div class="max-w-7xl mx-auto py-8 px-4">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Create Paste Form -->
        <div class="lg:col-span-1">
          <div class="sticky top-20">
            <h2 class="text-2xl font-bold mb-6" :class="sectionTitleClasses">Create Paste</h2>
            
            <form @submit.prevent="submit" class="space-y-4">
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
                  rows="16"
                  :class="inputClasses"
                ></textarea>
                <p v-if="errors.content" class="mt-2 text-red-500 text-xs">{{ errors.content }}</p>
              </div>

              <div>
                <label for="expiration-home" class="block text-sm font-medium mb-2" :class="labelClasses">Expiration (Optional)</label>
                <input
                  id="expiration-home"
                  v-model="form.expiration_date"
                  type="date"
                  :class="inputClasses"
                />
              </div>

              <button
                type="submit"
                :disabled="processing"
                :class="submitButtonClasses"
              >
                {{ processing ? 'Creating...' : 'Create Paste' }}
              </button>

              <div v-if="lastPasteSlug" :class="successCardClasses">
                <p :class="successTextClasses">✓ Paste created!</p>
                <Link :href="`/pastes/${lastPasteSlug}`" :class="successLinkClasses">
                  View your paste
                </Link>
              </div>
            </form>
          </div>
        </div>

        <!-- Right: Recent Pastes -->
        <div class="lg:col-span-2">
          <h2 class="text-2xl font-bold mb-6" :class="sectionTitleClasses">Recent Pastes</h2>
          
          <div v-if="pastes.length === 0" :class="emptyStateClasses">
            <p :class="emptyTextClasses">No pastes yet. Create one to get started!</p>
          </div>

          <div v-else class="space-y-3">
            <div
              v-for="paste in pastes"
              :key="paste.id"
              @click="navigateToPaste(paste.slug)"
              :class="pasteCardClasses"
              class="cursor-pointer"
            >
              <div class="flex items-start justify-between mb-2">
                <h3 class="text-lg font-bold flex-1" :class="pasteTitleClasses">{{ paste.title || 'Untitled Paste' }}</h3>
                <span class="text-xs ml-2 whitespace-nowrap" :class="dateClasses">{{ formatDate(paste.created_at) }}</span>
              </div>
              <p class="text-sm mb-2 line-clamp-2 font-mono" :class="contentPreviewClasses">{{ paste.content.substring(0, 120) }}{{ paste.content.length > 120 ? '...' : '' }}</p>
              <div class="flex items-center gap-3 text-xs" :class="metaClasses">
                <span 
                  :class="[slugClasses, 'cursor-pointer hover:opacity-80 transition']"
                  @click.stop="copySlug(paste.slug)"
                  :title="copiedSlug === paste.slug ? 'Copied!' : 'Click to copy'"
                >
                  {{ copiedSlug === paste.slug ? '✓ Copied' : paste.slug }}
                </span>
                <span>{{ paste.views || 0 }} views</span>
                <span v-if="paste.user_id">by User #{{ paste.user_id }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { useTheme } from '../../composables/useTheme';
import Navbar from '../../components/Navbar.vue';

const props = defineProps({
  pastes: Array,
});

const { isDark } = useTheme();

const form = useForm({
  title: '',
  content: '',
  expiration_date: '',
});

const processing = ref(false);
const errors = ref({});
const lastPasteSlug = ref(null);
const copiedSlug = ref(null);

// Computed classes
const pageClasses = computed(() => [
  'min-h-screen transition-colors',
  isDark.value ? 'bg-gray-950 text-gray-100' : 'bg-gray-50 text-gray-900'
]);

const titleClasses = computed(() =>
  isDark.value ? 'text-white' : 'text-gray-900'
);

const sectionTitleClasses = computed(() =>
  isDark.value ? 'text-white' : 'text-gray-900'
);

const labelClasses = computed(() =>
  isDark.value ? 'text-gray-300' : 'text-gray-700'
);

const inputClasses = computed(() => [
  'w-full px-3 py-2 rounded text-sm font-mono border transition-colors focus:outline-none focus:border-blue-500',
  isDark.value
    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
]);

const submitButtonClasses = computed(() => [
  'w-full px-4 py-2 disabled:opacity-50 text-white font-medium rounded transition text-sm bg-blue-600 hover:bg-blue-700'
]);

const successCardClasses = computed(() => [
  'mt-4 p-3 rounded text-sm border transition-colors',
  isDark.value
    ? 'bg-green-950 border-green-800'
    : 'bg-green-100 border-green-300'
]);

const successTextClasses = computed(() =>
  isDark.value ? 'text-green-200' : 'text-green-800'
);

const successLinkClasses = computed(() =>
  isDark.value
    ? 'text-green-300 hover:text-green-200 underline text-xs'
    : 'text-green-700 hover:text-green-600 underline text-xs'
);

const emptyStateClasses = computed(() => [
  'text-center py-12 rounded border transition-colors',
  isDark.value
    ? 'bg-gray-900 border-gray-800'
    : 'bg-white border-gray-200'
]);

const emptyTextClasses = computed(() =>
  isDark.value ? 'text-gray-400' : 'text-gray-600'
);

const pasteCardClasses = computed(() => [
  'block p-4 rounded border transition-all',
  isDark.value
    ? 'bg-gray-900 border-gray-800 hover:border-blue-500 hover:bg-gray-800'
    : 'bg-white border-gray-200 hover:border-blue-500 hover:bg-gray-50'
]);

const pasteTitleClasses = computed(() =>
  isDark.value ? 'text-white' : 'text-gray-900'
);

const contentPreviewClasses = computed(() =>
  isDark.value ? 'text-gray-400' : 'text-gray-600'
);

const dateClasses = computed(() =>
  isDark.value ? 'text-gray-500' : 'text-gray-500'
);

const metaClasses = computed(() =>
  isDark.value ? 'text-gray-500' : 'text-gray-600'
);

const slugClasses = computed(() => [
  'px-2 py-1 rounded transition-colors',
  isDark.value
    ? 'bg-gray-800 text-gray-300'
    : 'bg-gray-100 text-gray-700'
]);

const submit = () => {
  processing.value = true;
  errors.value = {};
  lastPasteSlug.value = null;
  
  form.post('/pastes', {
    onError: (err) => {
      errors.value = err;
      processing.value = false;
    },
    onSuccess: (response) => {
      processing.value = false;
      if (response.props && response.props.lastPaste) {
        lastPasteSlug.value = response.props.lastPaste.slug;
        form.title = '';
        form.content = '';
      }
    },
  });
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

const navigateToPaste = (slug) => {
  router.visit(`/pastes/${slug}`);
};

const copySlug = async (slug) => {
  try {
    const fullUrl = `${window.location.origin}/pastes/${slug}`;
    await navigator.clipboard.writeText(fullUrl);
    copiedSlug.value = slug;
    setTimeout(() => (copiedSlug.value = null), 2000);
  } catch (err) {
    console.error('Failed to copy:', err);
  }
};
</script>
