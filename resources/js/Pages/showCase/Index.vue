<script setup>
import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import Paginator from "../../Components/Paginator.vue";
import {onMounted} from "vue";

const props = defineProps({
    layoutData: Array,
    // user: Array,
    products: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: true
    }
});

//@todo вывести лого, баннер и в зависмостиот активности подписки  что то еще
onMounted(() => {
    console.log('👤 user:', props.user)

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
            {{props.user.name}}
                {{props.user.contact_phone}}
                {{props.user.contact_email}}
                <img :src="props.user.avatar" >
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
    </div>
</template>

<style scoped>

</style>
