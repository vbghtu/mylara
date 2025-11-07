<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed, ref} from "vue";
import {route} from "ziggy-js";

const navigation = [
    {name: 'Главная', href: '/'},
    {name: 'Профиль', href: '/profile'},
    // {name: 'Админка', href: '/adminarea'},
    // {name: 'Вход', href: '/login'},
    {name: 'Регистрация', href: '/register'},
];
const page = usePage();
const {auth} = usePage().props
const user = auth.user
const open = ref(false)
// const layoutData = page.props.layoutData || {};
const layoutData = computed(() => page.props.layoutData || {});
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">{{ layoutData.h1 }}</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link
                            v-for="link in navigation"
                            :key="link.name"
                            :class="{ 'bg-gray-200': $page.url === link.href }"
                            :href="link.href"
                            class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"
                        >
                            {{ link.name }}
                        </Link>
                        <div class="relative">
                            <!-- Кнопка-триггер -->
                            <button
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none"
                                @click="open = !open"
                            >
                                <span>Меню</span>
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          fill-rule="evenodd"/>
                                </svg>
                            </button>

                            <!-- Выпадающее меню -->
                            <div
                                v-show="open"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                            >
                                <!-- Приватные пункты (только для авторизованных) -->
                                <!--                                <template >-->
                                <Link
                                    v-if="user"
                                    :href="route('profile.show')"
                                    class="cursor-pointer text-gray-700
                                    font-medium px-4 py-2"
                                >
                                    Создать товар
                                </Link>
                            </div>
                        </div>
                        <Link
                            v-if="user"
                            :href="route('logout')"
                            as="button"
                            class="cursor-pointer text-gray-700 font-medium hover:text-indigo-600 transition duration-300 transform hover:scale-105"
                            method="post"
                            type="button"
                        >
                            Выход ({{ user ? user.name : "" }})
                        </Link>
                        <Link
                            v-else
                            :href="route('login')"
                            class="cursor-pointer text-gray-700 font-medium hover:text-indigo-600 transition duration-300 transform hover:scale-105"
                        >
                            Вход
                        </Link>

                    </div>
                </div>
            </div>
        </nav>

        <main>
            <slot/>
        </main>
    </div>
</template>

<style scoped>

</style>
