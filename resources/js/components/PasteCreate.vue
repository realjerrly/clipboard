<template>
    <form @submit.prevent="submit">
        <input v-model="title" placeholder="Title (optional)" />
        <textarea v-model="content" placeholder="Paste your content here"></textarea>
        <button type="submit">Create Paste</button>
    </form>
</template>
<script>
export default {
    data() { return { title: '', content: '' }; },
    methods: {
        submit() {
            axios.post('/pastes', { title: this.title, content: this.content })
                .then(response => window.location = `/pastes/${response.data.slug}`);
        }
    }
};
</script>