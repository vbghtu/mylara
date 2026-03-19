<script setup>
const field = defineModel({
    required: false,
    default: null
});

defineProps({
    placeholder: {
        type: String,
        default: 'Выберите  категорию',
    },
    data: {
        type: Array,
        required: true,
        validator: (val) => val.every(item => 'id' in item && 'name' in item),
    }
});

</script>

<template>
    <select
        v-model="field"
        :disabled="disabled"
        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"

    >
        <option value="">{{ placeholder }}</option>
        <option
            v-for="item in data"
            :key="item.id"
            :value="String(item.id)"
        >
            {{ item.name }}
        </option>
    </select>
</template>
