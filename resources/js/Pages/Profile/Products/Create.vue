<script setup>
import TextInput from "../../../Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import TiptapEditor from "../../../Components/TiptapEditor.vue";

// const props = defineProps({
//     user: Object,
// })

const form = useForm({
    title: '',
    slug: '',
    description: '',
    price: 0,
    category_id: '', // или null
    is_available: true,
})

</script>

<template>
    <ProductsLayout>
        <TextInput
            id="title"
            v-model="form.title"
            :error="$page.props.errors.title"
            name="Название"
        ></TextInput>

        <TextInput
            id="slug"
            v-model="form.slug"
            :error="$page.props.errors.slug"
            name="Url"
        ></TextInput>

        <TextInput
            id="price"
            v-model="form.price"
            :error="$page.props.errors.price"
            name="Цена"
            type="number"
        ></TextInput>

        <TiptapEditor
            v-model="form.description"
            :error="$page.props.errors.description"
            name="Описание"
        />


    </ProductsLayout>
</template>

<style scoped>

</style>
