<script setup>
import {computed, ref} from 'vue';

const props = defineProps({
    // Главное изображение (может быть null или строкой)
    existingMainImage: {
        type: String,
        default: null,
    },
    // Дополнительные фото: массив объектов ИЛИ пустой массив
    existingGallery: {
        type: Array,
        default: () => [],
        validator: (value) => {
            return value.every(item => typeof item === 'object' && item.full_url);
        }
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

// Ошибки для главного изображения
const mainImageError = computed(() => props.errors.main_image);

// Ошибки для галереи: соберём все, что начинается с "gallery."
const galleryErrors = computed(() => {
    const errs = [];
    for (const key in props.errors) {
        if (key.startsWith('gallery.')) {
            errs.push(props.errors[key]);
        }
    }
    return errs;
});


const emit = defineEmits(['update:mainImage', 'update:gallery', 'remove:existingImage']);


const mainPreview = ref(null);// Главное изображение
const mainFile = ref(null);

const newGalleryFiles = ref([]);
const removedImageIds = ref([]);// ID удалённых существующих изображений
const totalImages = computed(() => { // Общее количество изображений
    return props.existingGallery.length - removedImageIds.value.length + newGalleryFiles.value.length;
});

const displayedImages = computed(() => {
    // Существующие (без удалённых)
    const existing = props.existingGallery
        .filter(img => !removedImageIds.value.includes(img.id))
        .map(img => ({
            type: 'existing',
            id: img.id,
            url: img.full_url
        }));

    // Новые
    const news = newGalleryFiles.value.map((file, index) => ({
        type: 'new',
        index,
        url: URL.createObjectURL(file)
    }));

    return [...existing, ...news];
});
const canUploadMore = computed(() => totalImages.value < 5);

// Загрузка новых файлов
const handleGalleryImageChange = (e) => {
    const files = Array.from(e.target.files);
    const allowed = 5 - totalImages.value;
    for (let i = 0; i < files.length && i < allowed; i++) {
        newGalleryFiles.value.push(files[i]);
    }
    emit('update:gallery', newGalleryFiles.value);
    emit('update:removedImageIds', removedImageIds.value);
};
const handleMainImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        mainFile.value = file;
        mainPreview.value = URL.createObjectURL(file);
        emit('update:mainImage', file);
    }
};

const removeImage = (image) => {
    if (image.type === 'existing') {
        removedImageIds.value.push(image.id);
        emit('update:removedImageIds', [...removedImageIds.value]);
    } else {
        // Удаляем новое изображение и пересоздаём массив для реактивности
        newGalleryFiles.value.splice(image.index, 1);
        newGalleryFiles.value = [...newGalleryFiles.value];
        emit('update:gallery', newGalleryFiles.value);
    }
};

const removeExistingGalleryImage = (index) => {
    emit('remove:existingImage', index);
};
</script>


<!-- resources/js/Components/ProductImageUpload.vue -->
<template>
    <div class="space-y-6">
        <!-- Главное изображение -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Главная фотография</label>
            <div class="mt-1 flex items-center space-x-4">
                <img
                    v-if="mainPreview"
                    :src="mainPreview"
                    alt="Главное изображение"
                    class="h-24 w-24 object-cover rounded border"
                />
                <img
                    v-else-if="existingMainImage"
                    :src="existingMainImage"
                    alt="Текущее главное изображение"
                    class="h-24 w-24 object-cover rounded border"
                />
                <input
                    accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    type="file"
                    @change="handleMainImageChange"
                />
            </div>
            <p class="mt-1 text-sm text-gray-500">JPG, PNG до 2 МБ</p>
            <p v-if="mainImageError" class="mt-1 text-sm text-red-600">
                {{ mainImageError }}
            </p>
        </div>

        <!-- Галерея (до 5 изображений) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Дополнительные фотографии (до 5)</label>
            <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                <!-- Существующие изображения -->
                <div
                    v-for="(image, index) in displayedImages"
                    :key="image.type === 'existing' ? `e-${image.id}` : `n-${image.index}`"
                    class="relative group"
                >
                    <img
                        :src="image.url"
                        class="h-20 w-20 object-cover rounded border"
                    />
                    <button
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                        type="button"
                        @click="removeImage(image)"
                    >
                        ×
                    </button>
                </div>

                <!-- Кнопка + для загрузки -->
                <div v-if="canUploadMore">
                    <label
                        class="flex items-center justify-center h-20 w-20 border-2 border-dashed border-gray-300 rounded cursor-pointer hover:border-indigo-400"
                    >
                        <span class="text-2xl text-gray-400">+</span>
                        <input
                            :disabled="!canUploadMore"
                            accept="image/*"
                            class="hidden"
                            multiple
                            type="file"
                            @change="handleGalleryImageChange"
                        />
                    </label>
                </div>
            </div>
            <p class="mt-1 text-sm text-gray-500">Можно загрузить до 5 изображений</p>
            <div v-if="galleryErrors.length" class="mt-1 space-y-1">
                <p v-for="(error, i) in galleryErrors" :key="i" class="text-sm text-red-600">
                    {{ error }}
                </p>
            </div>
        </div>
    </div>
</template>
