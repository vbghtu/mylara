<script setup>

import {route} from "ziggy-js";
import {Link} from "@inertiajs/vue3";
import ProductReviewForm from "../../Components/ProductReviewForm.vue";

const props = defineProps({
    layoutData: Array,
    categories: Object,
    product: {
        type: Object,
        required: true
    },
    auth: Object,
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
                        <Link :href="route('slug.resolve', cat.slug ) ">
                            {{ cat.name }}
                        </Link>
                    </li>
                </ul>
            </div>

            <div class="md:w-9/12 bg-gray-200 p-4">
                <div class="w-full flex gap-4 flex-col">
                    <div class="gallery">
                        <div v-for="image in props.product.data.gallery" :key="image.id || 'main'"
                             class="gallery__item">
                            <img :alt="image.alt" :src="image.full_url">
                        </div>
                    </div>

                    <div class="description" v-html="props.product.data.description">

                    </div>
                    <div class="parametrs">
                        <p>Материал: {{ props.product.data.material }}</p>
                        <p>Доступен для заказа: {{ props.product.data.is_available }}</p>
                        <p>Можно ли изменить комплектацию: {{ props.product.data.is_customizable }}</p>
                        <p>Цена: {{ props.product.data.price }}</p>
                        <!--@todo категории со ссылкой-->
                        <p>Категория:
                            <Link :href="route('slug.resolve', props.product.data.category.slug ) ">
                                {{ props.product.data.category.name }}
                            </Link>

                        </p>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <ProductReviewForm
        v-if="props.auth"
        :product="props.product"
        class="mt-8"
    />
    <!-- Если пользователь не авторизован -->
    <div v-else class="mt-8 p-4 bg-gray-50 rounded text-center">
        <p class="text-gray-600 mb-2">Чтобы оставить отзыв, пожалуйста, войдите в аккаунт</p>
        <a href="/login" class="text-blue-600 hover:underline">Войти →</a>
    </div>
</template>

<style scoped>
.gallery {
    height: 200px;
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.gallery__item {
    max-width: 200px;
    min-width: 0;
    position: relative;
    display: flex;
}

.gallery__item img {
    width: 100%
}
</style>
