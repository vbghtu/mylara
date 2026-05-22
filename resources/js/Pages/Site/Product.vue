<script setup>

import {route} from "ziggy-js";
import {Link} from "@inertiajs/vue3";
import ReviewForm from "../../Components/ReviewForm.vue";
// @todo вывести рейтинг и количетсов отзывов в обект товара
const props = defineProps({
    layoutData: Object,
    categories: Object,
    product: {
        type: Object,
        required: true
    },
    auth: Object,
    reviews: Object,
    avg_rating: Number,
    reviews_count: Number,
    hasReviewed: Boolean,
});
console.log(props.product.data.author)
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
                        <p>средний рейтинг товара: {{ props.avg_rating }}</p>
                        <p>Количество отзывов: {{ props.reviews_count }}</p>


                        <p>Категория:
                            <Link :href="route('slug.resolve', props.product.data.category.slug ) ">
                                {{ props.product.data.category.name }}
                            </Link>

                        </p>

                    </div>
                </div>


            </div>
        </div>

        <ReviewForm
            v-if="!hasReviewed && auth.user"
            :reviewable="props.product"
            type="product"
            route-name="product.review.store"
            title="Оставить отзыв о товаре"
            placeholder="Оцените ассортимент, общение, качество обслуживания..."
            class="mt-8"
        />

        <!-- Если пользователь уже отзывался -->
        <div
            v-else-if="auth.user && hasReviewed"
            class="mt-8 p-4 bg-blue-50 rounded text-center text-blue-700"
        >
            ✓ Вы уже оставили отзыв к этому товару
        </div>
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
