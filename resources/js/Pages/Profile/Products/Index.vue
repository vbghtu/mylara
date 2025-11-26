<script setup>
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";

const props = defineProps({
    products: {
        type: Array,
        default: () => []
    },
});
</script>

<template>
    <ProductsLayout>
        <h1>Список продуктов</h1>
        <div class="w-100 flex gap-4">
            <div v-for="item in props.products"
                 :key="item.id"
                 class="item"
            >
                <img v-if="item.main_image_url" :alt="item.title" :src="item.main_image_url">
                <span>
                    {{ item.title }}
                </span>

            </div>
        </div>
    </ProductsLayout>
</template>

<style scoped>

</style>
