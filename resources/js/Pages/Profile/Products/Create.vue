<script setup>
import TextInput from "../../../Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import TiptapEditor from "../../../Components/TiptapEditor.vue";
import ProductImageUpload from "../../../Components/ProductImageUpload.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";

const form = useForm({
    title: '',
    slug: '',
    description: '',
    price: 0,
    category_id: '', // или null
    is_available: true,
    material: '',
    is_customizable: true,
    main_image: null,
    gallery: [],
})

const handleMainImage = (file) => {
    form.main_image = file;
};

const handleGallery = (files) => {
    form.gallery = files;
};

// Отправка формы
const submit = () => {
    form.post(route('products.store'), {
        // Важно: чтобы Inertia правильно обработал файлы
        preserveScroll: true,
    });
};

</script>

<template>
    <ProductsLayout>
        <form enctype="multipart/form-data" @submit.prevent="submit">
            <div class="w-full flex flex-row justify-between">
                <div class="w-1/2 flex flex-col  items-start">
                    <ProductImageUpload
                        :existing-gallery="existingGallery"
                        :existing-main-image="existingMainImage"
                        @update:main-image="handleMainImage"
                        @update:gallery="handleGallery"
                    />
                </div>
                <div class="w-1/2 flex flex-col  items-start">
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

                    <TextInput
                        id="material"
                        v-model="form.material"
                        :error="$page.props.errors.material"
                        name="Материал"
                        type="text"
                    ></TextInput>
                </div>
            </div>

            <TiptapEditor
                v-model="form.description"
                :error="$page.props.errors.description"
                name="Описание"
            />

            <div class="w-full flex flex-row items-start">
                <TextInput
                    id="is_customizable"
                    v-model="form.is_customizable"
                    :error="$page.props.errors.is_customizable"
                    name="Можно под заказ"
                    type="checkbox"
                ></TextInput>
                <TextInput
                    id="is_available"
                    v-model="form.is_available"
                    :error="$page.props.errors.is_available"
                    name="Доступно"
                    type="checkbox"
                ></TextInput>
            </div>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                Создать
            </PrimaryButton>
        </form>
        <!--@todo сделать компонент чекбокса а лучше кнопки свича -->
    </ProductsLayout>
</template>

<style scoped>

</style>
