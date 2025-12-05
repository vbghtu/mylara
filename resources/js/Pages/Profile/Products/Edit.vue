<script setup>
import {useForm} from "@inertiajs/vue3";
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import TextInput from "../../../Components/TextInput.vue";

const props = defineProps({
    product: {
        type: Object,
        default: () => []
    },
});

const form = useForm({
    category_id: 1, // пока что как дефолтное значение @todo добавить в миграцию дефолтное, добавить в сидер какинить категории, протащить их сюда
    title: props.product?.title || '',
    slug: '',
    description: '',
    price: 0,
    is_available: true,
    material: '',
    is_customizable: true,
    main_image: null,
    gallery: [],
})


</script>

<template>
    <ProductsLayout>
        <form enctype="multipart/form-data" @submit.prevent="submit">
            <div class="w-1/2 flex flex-col  items-start">

            </div>
            <div class="w-1/2 flex flex-col  items-start">
                <TextInput
                    id="title"
                    v-model="form.title"
                    :error="$page.props.errors.title"
                    name="Название"
                ></TextInput>
            </div>
        </form>
    </ProductsLayout>
</template>

<style scoped>

</style>
