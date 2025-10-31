<script setup>
import {Link} from '@inertiajs/vue3';

const navigation = [
    {name: 'Главная', href: '/'},
    {name: 'Профиль', href: '/users'},
    {name: 'Админка', href: '/adminarea'},
    {name: 'Вход', href: '/login'},
];


</script>

<template>
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold"></h1>
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

                </div>
            </div>
        </div>
    </nav>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <div>
            <!--            <Link href="/">-->
            <!--                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>-->
            <!--            </Link>-->
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot/>
        </div>
    </div>
</template>

<style scoped>

</style>
