<script setup>
import {Link} from '@inertiajs/vue3';
import {route} from "ziggy-js";

const props = defineProps({
    data: Array,
});

</script>

<template>
    <div class="flex  justify-center h-screen py-4">
        <nav class="container px-4  flex justify-end-safe">

            <Link
                v-for="item in data"
                :key="item.url"
                :href="route(item.url)"
                class="text-xl px-1 font-bold text-gray-800 hover:text-indigo-600 transition duration-300"
            >
                {{ item.name }}
            </Link>

        </nav>
    </div>
</template>

<style scoped>

</style>
