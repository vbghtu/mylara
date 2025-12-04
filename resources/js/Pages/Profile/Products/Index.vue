<script setup>
import {Link} from '@inertiajs/vue3';
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";

const props = defineProps({
    products: {
        type: Object,
        default: () => []
    },
});

const goToPage = (page) => {
    const path = props.products.meta.path // например: "/profile/products"
    const url = page === 1
        ? path
        : `${path}/page/${page}`
    return url;

}


</script>

<template>
    <ProductsLayout>
        <h1>Список продуктов</h1>
        <div class="w-full ">
            <div class="w-full flex gap-4">
                <div v-for="item in props.products.data.data"
                     :key="item.id"
                     class="item"
                >
                    <img v-if="item.main_image_url" :alt="item.title" :src="item.main_image_url">
                    <span>{{ item.title }}</span>

                </div>
            </div>
            <!-- Пагинация -->
            <div v-if="props.products.data.links" class="pagination w-full flex gap-3">
                <!--                <template v-for="(link, key) in props.products.links" :key="key">-->
                <Link
                    v-for="page in props.products.meta.last_page"
                    :key="page"
                    :class="{
                            'active': page === products.meta.current_page,
                            'pagination-link': true
                        }"
                    :href="goToPage(page)"
                    preserve-scroll
                    v-html="page"
                />
                <!--                <span v-else :class="{ 'disabled': true, 'pagination-link': true }" v-html="link.label"/>-->
                <!--                </template>-->
            </div>
        </div>
    </ProductsLayout>
</template>

<style scoped>

</style>
