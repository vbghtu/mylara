<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import {route} from "ziggy-js";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>j
    <Head title="Вход в систему"/>
    <div class="flex justify-around">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
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

                <div class="mt-4">
                    <TextInput
                        id="password"
                        v-model="form.password"
                        :error="$page.props.errors.password"
                        name="password"
                        type="password"
                    ></TextInput>
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember" name="remember"/>
                        <span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <Link
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Забыли пароль?
                    </Link>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                        Войти
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
