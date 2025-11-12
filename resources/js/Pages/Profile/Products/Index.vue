<script setup>
import NavBar from "../../../Components/NavBar.vue";

const props = defineProps({
    user: Object,
})
const navigation = [
    {name: 'Добавить', url: 'products.create'},
    {name: 'тест', url: 'products.index'},
];
</script>

<template>
    <NavBar :data="navigation"/>
</template>

<style scoped>

</style>
