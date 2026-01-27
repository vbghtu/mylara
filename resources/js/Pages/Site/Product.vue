<script setup>

import {route} from "ziggy-js";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    layoutData: Array,
    categories: Object,
    product: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <Head>
        <title>{{props.layoutData.metaTitle}}</title>
        <meta :content="props.layoutData.metaDescription" name="description"/>
    </Head>

    <div class="mx-auto max-w-12xl w-full px-4">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-3/12 bg-gray-100 p-4 max-h-dvh overflow-scroll">
                <ul>
                    <li v-for="cat in props.categories">
                        <Link :href="route('category', cat.slug ) ">
                            {{ cat.name }}
                        </Link>
                    </li>
                </ul>
            </div>

            <div class="md:w-9/12 bg-gray-200 p-4">
                <div class="w-full flex gap-4">

                </div>


            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
