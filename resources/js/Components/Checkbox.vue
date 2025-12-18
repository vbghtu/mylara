<script setup>
const field = defineModel({
    required: true,
    type: Boolean,
    default: false,
});
defineProps({
    id: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text'
    },
    error: String
})

</script>

<template>
    <div class="mb-6 w-full flex-row flex">
        <label :for="id" class="pointer w-8/12 block mb-2 text-sm font-medium text-gray-900  ">{{ name }}</label>
        <input
            :id="id"
            :checked="field"
            :class="['border','w-4/12','pointer' ,{'!ring-red-500': error}]"
            type="checkbox"
        >
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <small v-if="error" class="error block mt-1 text-sm">
                {{ error }}
            </small>
        </transition>
    </div>
</template>

<style scoped>

</style>
