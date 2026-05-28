<script setup>
import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import Paginator from "../../Components/Paginator.vue";
import {onMounted} from "vue";
import ReviewForm from "../../Components/ReviewForm.vue";

// defineProps({ showcase: Object, auth: Object, hasReviewed: Boolean })

const props = defineProps({
    layoutData: Array,
    auth: Array,
    products: {
        type: Object,
        required: true
    },
    seller: {
        type: Object,
        required: true
    },
    hasReviewed: Boolean,
    showcase: Object,
});

onMounted(() => {
    console.log('👤 user:', props.seller)

})
</script>

<template>
    <Head>
        <title>{{props.layoutData.metaTitle}}</title>
        <meta :content="props.layoutData.metaDescription" name="description"/>
    </Head>

    <div class="mx-auto max-w-12xl w-full px-4">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-3/12 bg-gray-100 p-4 max-h-dvh overflow-scroll">
            {{props.seller.name}}
                {{props.seller.contact_phone}}
                {{props.seller.contact_email}}
                <img :src="props.seller.avatar" >
<!--                <ul>-->
<!--                    <li v-for="cat in props.categories">-->
<!--                        <Link :href="route('category', cat.slug ) ">-->
<!--                            {{ cat.name }}-->
<!--                        </Link>-->
<!--                    </li>-->
<!--                </ul>-->
            </div>

            <div class="md:w-9/12 bg-gray-200 p-4">
                <div class="grid grid-cols-8 gap-4">
                    <Link v-for="item in props.products.data.data"
                          :key="item.id"
                          :href="route('product', item.slug)"
                          class="item max-w-40"
                    >
                        <img v-if="item.main_image_url" :alt="item.title" :src="item.main_image_url">
                        <span>{{ item.title }}</span>
                    </Link>
                </div>

<!--                <Paginator-->
<!--                    :navLink="false"-->
<!--                    :pageMeta=props.products.meta-->
<!--                />-->
            </div>
        </div>
        <ReviewForm
            v-if="!hasReviewed && auth.user && auth.user.id !== props.seller.id"
            :reviewable="props.showcase"
            type="showcase"
            route-name="slug.resolve.review.store"
            title="Оставить отзыв автору"
            placeholder="Оцените ассортимент, общение, качество обслуживания..."
            class="mt-8"
        />
        <div
            v-else-if="auth.user && hasReviewed"
            class="mt-8 p-4 bg-blue-50 rounded text-center text-blue-700"
        >
            ✓ Вы уже оставили отзыв этому автору
        </div>
    </div>
</template>

<style scoped>

</style>
