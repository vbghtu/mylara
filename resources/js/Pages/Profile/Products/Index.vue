<script setup>
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import Paginator from "../../../Components/Paginator.vue";
import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";

const props = defineProps({
    products: {
        type: Object,
        default: () => []
    },
});


</script>

<template>
    <ProductsLayout>
        <h1>Список продуктов</h1>
        <div class="w-full ">
            <div class="w-full flex gap-4">
                <Link v-for="item in props.products.data.data"
                      :key="item.id"
                      :href="route('products.edit', item.id)"
                      class="item max-w-40"
                >
                    <img v-if="item.main_image_url" :alt="item.title" :src="item.main_image_url">
                    <span>{{ item.title }}</span>

                </Link>
            </div>


            <!-- Пагинация -->
            <Paginator
                :navLink="false"
                :pageMeta=props.products.meta
            />

        </div>
    </ProductsLayout>
</template>

<style scoped>

</style>
