<script setup>
defineProps({
    user: Array,
});

</script>

<template>
    <h1>Главная</h1>

    {{ user.name }}
</template>

<style scoped>

</style>
