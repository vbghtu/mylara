<script setup>
import {ref} from 'vue'
import {useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";
import TextInput from "../../Components/TextInput.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";

const props = defineProps({
    user: Object,
})
const photoInput = ref(null)
// const {auth} = usePage().props
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    photo: null,
})
const handlePhotoChange = (e) => {
    const file = e.target.files[0]
    form.photo = file
}
const submit = () => {
    console.log(form);
    form.post(route('profile.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            // Сброс input после загрузки
            if (photoInput.value) photoInput.value.value = ''
        },
    })
}

// const submit = () => {
//     const file = event.target.files[0]
//     if (!file) return
//
//     const formData = new FormData()
//     formData.append('photo', file)
//
//     form.post(route('profile.store'), {
//         preserveScroll: true,
//         forceFormData: true,
//
//         // onFinish: () => form.reset('password'),
//     });
// };
// const updatePhoto = (event) => {
//     const file = event.target.files[0]
//     if (!file) return
//
//     const formData = new FormData()
//     formData.append('photo', file)
//
//     router.post(route('profile.store'), formData, {
//         preserveScroll: true,
//         onSuccess: () => {
//             // Сброс input после успешной загрузки
//             photoInput.value.value = ''
//         },
//     })
// }
</script>

<template>
    <div v-if="$page.props.flash.success" class="mt-2 text-sm text-green-600">
        {{ $page.props.flash.success }}
    </div>
    <div class="w-full flex px-8 py-4 ">
        <form class="w-full flex" @submit.prevent="submit">
            <div class="w-1/3 flex flex-col  items-center">
                <img
                    v-if="user.profile_photo"
                    :src="'/storage/'+user.profile_photo"
                    alt="Profile"
                    class="h-16 w-16 rounded-full object-cover "
                />
                <div
                    v-else
                    class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center "
                >
                    <span class="text-gray-500">Нет фото</span>
                </div>
                <div class="ml-4">
                    <input
                        ref="photoInput"
                        accept="image/*"
                        class="hidden"
                        type="file"
                        @change="handlePhotoChange"
                    />
                    <button
                        class="inline-flex cursor-pointer items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        type="button"
                        @click="$refs.photoInput.click()"
                    >
                        Выбрать новое фото
                    </button>
                </div>
            </div>
            <div class="w-2/3">

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
                        id="Имя"
                        v-model="form.name"
                        :error="$page.props.errors.name"
                        name="name"
                        type="text"
                    ></TextInput>
                </div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    Сохранить
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
