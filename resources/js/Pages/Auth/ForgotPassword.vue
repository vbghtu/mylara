<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

</script>

<template>
    <Head title="Восстановление пароля"/>
    <div class="flex justify-around">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                Забыли пароль? Не проблема. Просто укажите свой email адрес, и мы вышлем вам ссылку для сброса пароля.
            </div>

            <!-- Сообщения -->
            <div v-if="status"
                 :class="messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                 class="mb-4 p-4 rounded">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <TextInput
                        id="email"
                        v-model="form.email"
                        :error="$page.props.errors.email"
                        name="Email"
                    ></TextInput>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <Link
                        :href="route('login')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Вернуться к входу
                    </Link>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Отправить ссылку для сброса
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
