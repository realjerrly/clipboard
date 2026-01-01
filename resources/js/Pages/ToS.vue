<template>
  <div :class="pageClasses">
    <Navbar />
    <div class="max-w-4xl mx-auto py-12 px-4">
      <div class="mb-8">
        <Link href="/" :class="linkClasses">← Back to Home</Link>
        <h1 :class="titleClasses">Terms of Service</h1>
      </div>

      <!-- ToS Content -->
      <div :class="contentClasses">
        <div class="space-y-6">
          <section>
            <h2 :class="sectionTitleClasses">1. Agreement to Terms</h2>
            <p :class="textClasses">By accessing and using this Pastebin service, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">2. Use License</h2>
            <p :class="textClasses">Permission is granted to temporarily download one copy of the materials (information or software) on clipboard.lol for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
            <ul :class="listClasses">
              <li>Modify or copy the materials</li>
              <li>Use the materials for any commercial purpose or for any public display</li>
              <li>Attempt to decompile or reverse engineer any software contained on the service</li>
              <li>Remove any copyright or other proprietary notations from the materials</li>
              <li>Transfer the materials to another person or 'mirror' the materials on any other server</li>
            </ul>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">3. Disclaimer</h2>
            <p :class="textClasses">The materials on clipboard.lol are provided 'as is'. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">4. Limitations</h2>
            <p :class="textClasses">In no event shall clipboard.lol or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on clipboard.lol, even if we or our authorized representative has been notified orally or in writing of the possibility of such damage.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">5. Accuracy of Materials</h2>
            <p :class="textClasses">The materials appearing on clipboard.lol could include technical, typographical, or photographic errors. We do not warrant that any of the materials on the service are accurate, complete, or current. We may make changes to the materials contained on the service at any time without notice.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">6. Links</h2>
            <p :class="textClasses">We have not reviewed all of the sites linked to our website and are not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by us of the site. Use of any such linked website is at the user's own risk.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">7. Modifications</h2>
            <p :class="textClasses">We may revise these terms of service for our website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">8. Governing Law</h2>
            <p :class="textClasses">These terms and conditions are governed by and construed in accordance with the laws of the jurisdiction in which the service is provided, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">9. User Content</h2>
            <p :class="textClasses">Users are responsible for the content they paste on clipboard.lol. We do not endorse or take responsibility for any user-generated content. Users agree not to post content that is illegal, offensive, or violates any third-party rights.</p>
          </section>

          <section>
            <h2 :class="sectionTitleClasses">10. Contact</h2>
            <p :class="textClasses">If you have any questions about these Terms of Service, please contact us. None.</p>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useTheme } from '../composables/useTheme';
import Navbar from '../components/Navbar.vue';

const { isDark } = useTheme();

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

const contentClasses = computed(() => [
  'rounded p-6 border transition-colors',
  isDark.value
    ? 'bg-gray-900 border-gray-800 text-gray-300'
    : 'bg-white border-gray-200 text-gray-800'
]);

const sectionTitleClasses = computed(() =>
  isDark.value ? 'text-2xl font-semibold text-white mb-3' : 'text-2xl font-semibold text-gray-900 mb-3'
);

const textClasses = computed(() =>
  isDark.value ? 'text-gray-400 leading-relaxed' : 'text-gray-700 leading-relaxed'
);

const listClasses = computed(() =>
  isDark.value ? 'list-disc list-inside text-gray-400 space-y-2 pl-4' : 'list-disc list-inside text-gray-700 space-y-2 pl-4'
);
</script>
