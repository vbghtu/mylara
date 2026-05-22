<script setup>
import { useForm } from '@inertiajs/vue3'
// import StarRating from '@/Components/UI/StarRating.vue' // см. ниже
import { computed } from 'vue'

const props = defineProps({
    reviewable: { type: Object, required: true },
    type: { type: String, required: true, validator: v => ['product', 'showcase'].includes(v) },
    routeName: { type: String, required: true },
    title: { type: String, default: 'Оставить отзыв' },
    placeholder: { type: String, default: 'Расскажите, что понравилось или не понравилось...' }
})
// console.log(props.product.data.slug);
const form = useForm({
    rating: 0,
    comment: ''
})

const canSubmit = computed(() => form.rating > 0 && !form.processing)

const submit = () => {
    if (!props.reviewable.data?.slug) {
        console.error('❌ reviewable.slug is missing:', props.reviewable)
        return
    }

    // 🔹 Формируем параметры под имя маршрута
    const params = props.type === 'product'
        ? { productSlug: props.reviewable.data.slug }  // Для товара: {productSlug}
        : { slug: props.reviewable.slug }          // Для витрины: {slug}

    form.post(route(props.routeName, params), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => console.error('Form errors:', errors)
    })
}
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-sm border mt-8">
        <h3 class="text-lg font-semibold mb-2">{{ title }}</h3>

        <!-- Успех -->
        <div v-if="$page.props.flash?.success" class="mb-4 p-3 bg-green-50 text-green-700 rounded">
            {{ $page.props.flash.success }}
        </div>

        <!-- Ошибки (поле review или валидация) -->
        <div v-if="form.errors?.review || $page.props.errors?.review" class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            {{ form.errors?.review || $page.props.errors?.review }}
        </div>
        <div v-if="form.errors?.rating || form.errors?.comment" class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            {{ form.errors.rating || form.errors.comment }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ваша оценка</label>
                <input
                    v-model="form.rating"
                    id="rating"
                    type="number"
                >
            </div>

            <textarea
                v-model="form.comment"
                rows="3"
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                :placeholder="placeholder"
            ></textarea>

            <button
                type="submit"
                :disabled="form.rating === 0 || form.processing"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ form.processing ? 'Отправка...' : 'Опубликовать отзыв' }}
            </button>
        </form>
    </div>

</template>

<style scoped>

</style>
