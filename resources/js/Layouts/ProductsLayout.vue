<script setup>
import NavBar from "../Components/NavBar.vue";

const props = defineProps({
    user: Object,
})
const navigation = [
    {name: 'Добавить', url: 'products.create'},
    {name: 'Мои товары', url: 'products.index'},
];
</script>

<template>
    <NavBar :data="navigation"/>
    <div class="max-w-7xl mx-auto flex justify-start flex-col py-4 content">
        <!-- Сюда вставится конкретная страница: Index.vue, Create.vue и т.д. -->
        <slot/>
    </div>
</template>

<style scoped>

</style>
