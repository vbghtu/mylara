<script setup>

import AdminLayout from "../../../Layouts/AdminLayout.vue";
import TextInput from "../../../Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import TiptapEditor from "../../../Components/TiptapEditor.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import SelectInput from "../../../Components/SelectInput.vue";

const props = defineProps({
    category: {
        type: Object,
        default: () => []
    },
    categories: {
        type: Array,
        default: () => []
    }
});

const form = useForm({
    name: props.category?.name || '',
    slug: props.category?.slug || '',
    description: props.category?.description || '',
    meta_description: props.category?.meta_description || '',
    meta_title: props.category?.meta_title || '',
    parent_id: props.category?.parent_id || '',

})

const submit = () => {
    form.post(route("categories.store"));
};

</script>

<template>
    <AdminLayout>
        <form enctype="multipart/form-data" @submit.prevent="submit">
            <TextInput
                id="title"
                v-model="form.name"
                :error="$page.props.errors.name"
                name="Название"
            ></TextInput>
            <TextInput
                id="title"
                v-model="form.slug"
                :error="$page.props.errors.slug"
                name="slug"
            ></TextInput>

            <SelectInput
                v-model="form.parent_id"
                :data="props.categories"
                placeholder="Без родителя (корневая)"
            />

            <TiptapEditor
                v-model="form.description"
                :error="$page.props.errors.description"
                name="Описание"
            />
            <TextInput
                id="title"
                v-model="form.meta_title"
                :error="$page.props.errors.meta_title"
                name="Meta заголовок"
            ></TextInput>
            <TextInput
                id="title"
                v-model="form.meta_description"
                :error="$page.props.errors.meta_description"
                name="Meta описание"
            ></TextInput>
            <div class="flex flex-wrap gap-3">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    Сохранить
                </PrimaryButton>
                <Link :href="route('categories.index')" class="btn-secondary">
                    Отмена
                </Link>
            </div>
        </form>
    </AdminLayout>
</template>

<style scoped>

</style>
