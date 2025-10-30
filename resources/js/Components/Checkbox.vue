<script setup>
const field = defineModel({
    required: true,
    type: Boolean,
    default: false,
});

// defineProps({
//     modelValue: {
//         type: Boolean,
//         default: false,
//     },
// });
</script>

<template>
    <input
        :checked="field"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
        type="checkbox"
    >
</template>

<style scoped>

</style>
