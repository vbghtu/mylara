<script setup>
import {computed} from "vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
})
// const navigation = [
//     {name: 'Добавить', url: 'products.create'},
//     {name: 'Мои товары', url: 'products.index'},
// ];

const flash = computed(() => usePage().props.flash);


</script>

<template>
    <!--    <NavBar :data="navigation"/>-->
    <div class="max-w-7xl mx-auto flex justify-start flex-col py-4 content">
        <div v-if="flash.success" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ flash.success }}
        </div>
        <!-- Сюда вставится конкретная страница: Index.vue, Create.vue и т.д. -->
        <slot/>
    </div>
</template>

<style scoped>

</style>
