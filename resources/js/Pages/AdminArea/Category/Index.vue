<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import {route} from "ziggy-js";
import {Link, useForm} from "@inertiajs/vue3";
import Paginator from "../../../Components/Paginator.vue";
import {Edit, Trash2} from 'lucide-vue-next'

const props = defineProps({
    categories: {
        type: Object,
        default: () => []
    },
});

const deleteCategory = (id) => {
    if (confirm('Удалить категорию?')) {
        useForm().delete(route('categories.destroy', id))
    }
}
</script>

<template>
    <AdminLayout>
        <div class="mt-4 mb-4 w-full flex justify-between">
            <h1>Список Категорий</h1>
            <Link :href="route('categories.create')"
            >
                Создать новую категорию
            </Link>
        </div>
        <div class="w-full ">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200" role="list">
                    <li class="px-2 sm:px-6 py-4 hidden sm:flex justify-between items-center">
                        <div class="flex flex-wrap items-center">
                            <p class="text-gray-500 w-4 sm:w-16">ID</p>
                            <h3 class="text-lg font-medium">Название</h3>
                        </div>
                        <div class="space-x-2">
                            Действие
                        </div>
                    </li>
                    <li v-for="cat in props.categories.data.data" :key="cat.id"
                        class="px-2 sm:px-6 py-4 flex flex-wrap flex-col sm:flex-row justify-between sm:items-center gap-1">
                        <div class="flex flex-wrap items-center">
                            <p class="text-gray-500 w-8 sm:w-16">{{ cat.id }}</p>
                            <h3 class="font-medium">{{ cat.name }}</h3>
                        </div>
                        <div class="space-x-4 text-right flex items-center">
                            <Link :href="route('categories.edit', cat.id)"
                                  class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline whitespace-nowrap">
                                <Edit class="w-5 h-5"/>
                            </Link>
                            <button
                                aria-label="Удалить"
                                class="p-2 cursor-pointer rounded-full hover:bg-red-100 text-red-600 transition"
                                type="button"
                                @click="deleteCategory( cat.id)"
                            >
                                <Trash2 class="w-5 h-5"/>
                            </button>
                            <!-- <button @click="destroy(genre)" class="text-sm font-medium text-red-500 whitespace-nowrap cursor-pointer hover:underline">Удалить</button> -->
                        </div>
                    </li>
                </ul>
            </div>


            <!--            Пагинация-->
            <Paginator
                :navLink="false"
                :pageMeta=props.categories.meta
            />

        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
