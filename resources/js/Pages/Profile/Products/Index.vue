<script setup>
import {Link} from '@inertiajs/vue3';
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";

const props = defineProps({
    products: {
        type: Object,
        default: () => []
    },
});
console.log(props.products.links);
</script>

<template>
    <ProductsLayout>
        <h1>Список продуктов</h1>
        <div class="w-full ">
            <div class="w-full flex gap-4">
                <div v-for="item in props.products.data"
                     :key="item.id"
                     class="item"
                >
                    <img v-if="item.main_image_url" :alt="item.title" :src="item.main_image_url">
                    <span>{{ item.title }}</span>

                </div>
            </div>
            <!-- Пагинация -->
            <div v-if="props.products.links" class="pagination w-full flex gap-3">
                <template v-for="(link, key) in props.products.links" :key="key">
                    <Link
                        v-if="link.url"
                        :class="{
                            'active': link.active,
                            'pagination-link': true
                        }"
                        :href="link.url"
                        preserve-scroll
                        v-html="link.label"
                    />
                    <span v-else :class="{ 'disabled': true, 'pagination-link': true }" v-html="link.label"/>
                </template>
            </div>
        </div>
    </ProductsLayout>
</template>

<style scoped>

</style>
