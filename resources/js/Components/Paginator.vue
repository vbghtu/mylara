<script setup>


const {pageMeta} = defineProps({
    pageMeta: {
        type: Object,
        default: null,
    },
    navLink: {
        type: Boolean,
        default: false,
    }
    // 'current_page' => $products->currentPage(),
    // 'last_page' => $products->lastPage(),
    // 'per_page' => $products->perPage(),
    // 'total' => $products->total(),
    // 'from' => $products->firstItem(),
    // 'to' => $products->lastItem(),
    // 'path' => $basePath, // ← критически важно!
});

const goToPage = (page) => {
    return page === 1 ? pageMeta.path : `${pageMeta.path}/page/${page}`


}

</script>

<template>
    <nav class="flex justify-around pt-4">
        <ul class="flex gap-2 flex-row">
            <li v-if="(navLink===true && pageMeta.current_page!== 1) ">
                <Link
                    :href="goToPage(pageMeta.current_page - 1)"
                    class="pagination-link p-1 text-base"
                    preserve-scroll
                >
                    Назад
                </Link>
            </li>

            <li v-for="page in pageMeta.last_page"
                class=" bg-gray-300 hover:bg-gray-400"
            >
                <Link
                    v-if="page != pageMeta.current_page"
                    :href="goToPage(page)"
                    class="pagination-link p-1 text-base"
                    preserve-scroll
                    v-text="page"
                />
                <span v-else
                      class="disabled pagination-link p-1 text-base}" v-html="page"/>
            </li>

            <li v-if="(navLink===true && pageMeta.current_page!== pageMeta.total)">
                <Link
                    :href="goToPage(pageMeta.current_page + 1)"
                    class="pagination-link p-1 text-base"
                    preserve-scroll
                >
                    Вперед
                </Link>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
