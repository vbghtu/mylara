<script setup>
import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";

defineProps({
    user: Array,
    categories: Object,
    products: Object
});
// console.log(props.products);
</script>

<template>
    <!--    <div v-if="user?.name">{{ user.name }}</div>-->
    <div class="mx-auto max-w-12xl w-full px-4">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-3/12 bg-gray-100 p-4">
                <ul>
                    <li v-for="cat in categories">
                        <Link :href="route('category', cat.slug ) ">
                            {{ cat.name }}
                        </Link>
                    </li>
                </ul>

            </div>
            <div class="md:w-9/12 bg-gray-200 p-4">
                <div class="w-full flex gap-4">
                    <Link v-for="item in products"
                          :key="item.id"
                          :href="route('product', item.slug)"
                          class="item max-w-40"
                    >
                        <img v-if="item.image_path" :alt="item.title" :src="item.image_path">
                        <span>{{ item.title }}</span>

                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
