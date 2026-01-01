<template>
  <div :class="pageClasses">
    <Navbar />
    <div class="max-w-4xl mx-auto py-12 px-4">
      <div class="mb-8">
        <Link href="/" :class="linkClasses">← Back to Home</Link>
        <h1 :class="titleClasses">{{ paste.title || 'Untitled Paste' }}</h1>
        <p :class="metaClasses">
          Created {{ formatDate(paste.created_at) }}
          <span v-if="paste.user_id" class="ml-4">by User #{{ paste.user_id }}</span>
          <span v-if="paste.expiration_date" class="ml-4">Expires {{ formatDate(paste.expiration_date) }}</span>
          <span class="ml-4">👁️ {{ paste.views }} {{ paste.views === 1 ? 'view' : 'views' }}</span>
        </p>
      </div>

      <!-- Share URL -->
      <div :class="cardClasses">
        <p class="text-sm mb-2" :class="labelClasses">Share this paste:</p>
        <div class="flex gap-2">
          <input
            type="text"
            :value="shareUrl"
            readonly
            :class="inputClasses"
          />
          <button
            @click="copyShareUrl"
            :class="copyButtonClasses"
          >
            {{ shareCopied ? '✓ Copied' : 'Copy Link' }}
          </button>
        </div>
      </div>

      <!-- Paste Content -->
      <div :class="contentCardClasses">
        <pre class="font-mono text-sm overflow-x-auto"><code>{{ paste.content }}</code></pre>
      </div>

      <!-- Actions -->
      <div class="flex gap-4">
        <button
          @click="copyToClipboard"
          :class="[primaryButtonClasses, 'bg-green-600 hover:bg-green-700']"
        >
          {{ copied ? '✓ Copied' : 'Copy Content' }}
        </button>
        <Link
          href="/"
          :class="[primaryButtonClasses, 'bg-blue-600 hover:bg-blue-700 text-white text-center']"
        >
          Create New
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useTheme } from '../../composables/useTheme';
import Navbar from '../../components/Navbar.vue';

const props = defineProps({
  paste: Object,
});

const page = usePage();
const { isDark } = useTheme();
const copied = ref(false);
const shareCopied = ref(false);

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
  isDark.value ? 'text-4xl font-bold text-white mb-2' : 'text-4xl font-bold text-gray-900 mb-2'
);

const metaClasses = computed(() =>
  isDark.value ? 'text-gray-400' : 'text-gray-600'
);

const cardClasses = computed(() => [
  'rounded p-4 mb-6 border transition-colors',
  isDark.value
    ? 'bg-gray-900 border-gray-800'
    : 'bg-white border-gray-200'
]);

const labelClasses = computed(() =>
  isDark.value ? 'text-gray-400' : 'text-gray-600'
);

const inputClasses = computed(() => [
  'flex-1 px-3 py-2 rounded text-sm font-mono border transition-colors',
  isDark.value
    ? 'bg-gray-800 border-gray-700 text-white'
    : 'bg-gray-100 border-gray-300 text-gray-900'
]);

const copyButtonClasses = computed(() => [
  'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition text-sm'
]);

const contentCardClasses = computed(() => [
  'rounded p-6 mb-6 border transition-colors',
  isDark.value
    ? 'bg-gray-900 border-gray-800 text-gray-300'
    : 'bg-white border-gray-200 text-gray-800'
]);

const primaryButtonClasses = computed(() =>
  'px-6 py-2 font-medium rounded transition text-white'
);

const shareUrl = computed(() => {
  if (typeof window !== 'undefined') {
    return `${window.location.origin}/pastes/${props.paste.slug}`;
  }
  return '';
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};

const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(props.paste.content);
    copied.value = true;
    setTimeout(() => (copied.value = false), 2000);
  } catch (err) {
    console.error('Failed to copy:', err);
  }
};

const copyShareUrl = async () => {
  try {
    await navigator.clipboard.writeText(shareUrl.value);
    shareCopied.value = true;
    setTimeout(() => (shareCopied.value = false), 2000);
  } catch (err) {
    console.error('Failed to copy:', err);
  }
};
</script>
