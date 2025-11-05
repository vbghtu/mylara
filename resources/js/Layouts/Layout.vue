<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import {route} from "ziggy-js";

const navigation = [
    {name: 'Главная', href: '/'},
    {name: 'Профиль', href: '/profile'},
    {name: 'Админка', href: '/adminarea'},
    // {name: 'Вход', href: '/login'},
    {name: 'Регистрация', href: '/register'},
];
const page = usePage();
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

                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('logout')"
                            as="button"
                            class="cursor-pointer text-gray-700 font-medium hover:text-indigo-600 transition duration-300 transform hover:scale-105"
                            method="post"
                            type="button"
                        >
                            Выход ({{
                                $page.props.auth.user
                                    ? $page.props.auth.user.name
                                    : ""
                            }})
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
