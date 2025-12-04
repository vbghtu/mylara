<script setup>
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import Paginator from "../../../Components/Paginator.vue";

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
            <Paginator
                :navLink="false"
                :pageMeta=props.products.meta
            />

        </div>
    </ProductsLayout>
</template>

<style scoped>

</style>
