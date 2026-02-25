<script setup>
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import Paginator from "../../../Components/Paginator.vue";

const props = defineProps({
    products: {
        type: Object,
    },
});


</script>

<template>
    <ProductsLayout>
        <div class="mx-auto max-w-12xl w-full px-4">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-3/12 bg-gray-100 p-4 max-h-dvh overflow-scroll">
                    <!--      asdasdasd-->
                </div>
                <div class="md:w-9/12 bg-gray-200 p-4">
                    <div class="grid grid-cols-8 gap-4">
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
            </div>
        </div>

    </ProductsLayout>
</template>

<style scoped>

</style>
