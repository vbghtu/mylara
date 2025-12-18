<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        // onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Регистрация"/>
    <div class="flex justify-around">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <form @submit.prevent="submit">
                <div>
                    <TextInput
                        id="name"
                        v-model="form.name"
                        :error="$page.props.errors.name"
                        name="Имя"
                    ></TextInput>
                </div>

                <div>
                    <TextInput
                        id="email"
                        v-model="form.email"
                        :error="$page.props.errors.email"
                        name="Email"
                    ></TextInput>
                </div>

                <div>
                    <TextInput
                        id="password"
                        v-model="form.password"
                        :error="$page.props.errors.password"
                        name="Пароль"
                        type="password"
                    ></TextInput>
                </div>

                <div>
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        :error="$page.props.errors.password_confirmation"
                        name="Подтверждение пароля"
                        type="password"
                    ></TextInput>
                </div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    Зарегистрироваться
                </PrimaryButton>

            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
