<script setup>
defineProps({
    user: Array,
});

</script>

<template>
    <div v-if="user?.name">{{ user.name }}</div>
    <!--    {{ user.name }}-->
</template>

<style scoped>

</style>
