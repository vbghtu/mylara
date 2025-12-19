<script setup>
import {useForm} from "@inertiajs/vue3";
import ProductsLayout from "../../../Layouts/ProductsLayout.vue";
import TextInput from "../../../Components/TextInput.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import TiptapEditor from "../../../Components/TiptapEditor.vue";
import ProductImageUpload from "../../../Components/ProductImageUpload.vue";
import Checkbox from "../../../Components/Checkbox.vue";

const props = defineProps({
    product: {
        type: Object,
        default: () => []
    },
});

const form = useForm({
    category_id: 1, // пока что как дефолтное значение @todo добавить в миграцию дефолтное, добавить в сидер какинить категории, протащить их сюда
    title: props.product?.title || '',
    slug: props.product?.slug || '',
    description: props.product?.description || '',
    price: props.product?.price || 0,
    is_available: props.product?.is_available || true,
    material: props.product?.material || '',
    is_customizable: props.product?.is_customizable || true,
    main_image: props.product?.main_image || null,
    existingGallery: props.product?.gallery || null,
    removed_gallery_ids: [],
    gallery: [],
})

const handleMainImage = (file) => {
    form.main_image = file;
};

const handleGallery = (files) => {
    form.gallery = files;
};
const handleRemoveGalleryImage = (ids) => {
    form.removed_gallery_ids = ids;
};

const submit = () => {
    form.put(route("products.update", props.product.id));
};

</script>

<template>
    <ProductsLayout>
        <form enctype="multipart/form-data" @submit.prevent="submit">
            <div class="w-full flex flex-row justify-between">
                <div class="w-1/2 flex flex-col  items-start">
                    <ProductImageUpload
                        :errors="form.errors"
                        :existingGallery="form.existingGallery"
                        :existingMainImage="form.main_image"
                        @update:mainImage="handleMainImage"
                        @update:gallery="handleGallery"
                        @update:removedImageIds="handleRemoveGalleryImage"
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

                <Checkbox
                    id="is_customizable"
                    v-model="form.is_customizable"
                    :error="$page.props.errors.is_customizable"
                    name="Можно под заказ"
                    type="checkbox"
                ></Checkbox>
                <Checkbox
                    id="is_available"
                    v-model="form.is_available"
                    :error="$page.props.errors.is_available"
                    name="Доступно"
                    type="checkbox"
                ></Checkbox>
            </div>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                Сохранить
            </PrimaryButton>
            <Link :href="route('products.index')" class="btn-secondary">
                Отмена
            </Link>

        </form>
    </ProductsLayout>
</template>

<style scoped>

</style>
