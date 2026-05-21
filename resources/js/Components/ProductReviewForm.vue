<script setup>
import { useForm } from '@inertiajs/vue3'
// import StarRating from '@/Components/UI/StarRating.vue' // см. ниже
import { computed } from 'vue'

const props = defineProps({
    product: { type: Object, required: true }
})
// console.log(props.product.data.slug);
const form = useForm({
    rating: 0,
    comment: ''
})

const canSubmit = computed(() => form.rating > 0 && !form.processing)

const submit = () => {
    form.post(route('product.review.store', props.product.data.slug), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-semibold mb-4">Оставить отзыв о товаре</h3>

        <!-- 🔹 Сообщения об успехе/ошибке -->
        <div v-if="$page.props.flash?.success" class="mb-4 p-3 bg-green-50 text-green-700 rounded">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="form.errors.rating || form.errors.comment" class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            {{ form.errors.rating || form.errors.comment }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Звёзды -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ваша оценка</label>
                <input
                    v-model="form.rating"
                    id="rating"
                    type="number"
                    >
<!--                <label class="block text-sm font-medium text-gray-700 mb-1">Ваша оценка</label>-->
<!--                <StarRating v-model="form.rating" />-->
            </div>

            <!-- Комментарий -->
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Комментарий</label>
                <textarea
                    id="comment"
                    v-model="form.comment"
                    rows="4"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Расскажите, что понравилось или не понравилось..."
                ></textarea>
            </div>

            <!-- Кнопка -->
            <button
                type="submit"
                :disabled="!canSubmit"
                :class="{'opacity-50 cursor-not-allowed': !canSubmit}"
                class="w-full md:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
            >
                {{ form.processing ? 'Отправка...' : 'Опубликовать отзыв' }}
            </button>
        </form>
    </div>
</template>

<style scoped>

</style>
