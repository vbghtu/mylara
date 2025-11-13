<script setup>
import {EditorContent, useEditor} from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import {onBeforeUnmount} from "vue";

const field = defineModel({
    required: true,
});

defineProps({
    name: {
        type: String,
        required: true,
    },
    error: String,
});

// Инициализация Tiptap-редактора
const editor = useEditor({
    content: field.value,
    extensions: [
        StarterKit.configure({
            link: {
                openOnClick: true,
                autolink: true,
                HTMLAttributes: {
                    target: "_blank",
                    rel: "noopener noreferrer",
                },
            },
        }),
    ],
    editorProps: {
        attributes: {
            class: "block w-full rounded-b-md border-0 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-500 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm bg-white p-2 rounded-b min-h-[12rem] max-h-[12rem] overflow-y-auto outline-none",
        },
    },
    onUpdate: ({editor}) => {
        field.value = editor.getHTML();
    },
});

// Функция для добавления/редактирования ссылки
const setLink = () => {
    const previousUrl = editor.value?.getAttributes("link").href || "";
    const url = window.prompt("Введите URL ссылки", previousUrl);

    // Удаляем протокол, если пользователь не ввёл его
    if (url === null) return; // отмена

    // Валидация: если пусто — удаляем ссылку
    if (url === "") {
        editor.value?.chain().focus().unsetLink().run();
        return;
    }

    // Добавляем https:// если не указан протокол
    let finalUrl = url;
    if (!url.startsWith("http://") && !url.startsWith("https://")) {
        finalUrl = "https://" + url;
    }

    editor.value?.chain().focus().setLink({href: finalUrl}).run();
};

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div class="block mb-2 text-sm font-medium text-gray-900">
        {{ name }}
    </div>
    <div v-if="editor" class="editor pb-2">
        <!-- Buttons and functionality -->
        <section
            class="buttons flex items-center flex-wrap gap-x-1 border-0 text-slate-900 shadow-sm p-2 rounded-t bg-white ring-1 ring-inset ring-slate-300"
        >
            <button
                :class="{ 'bg-gray-200 rounded': editor.isActive('bold') }"
                :disabled="!editor.can().chain().focus().toggleBold().run()"
                class="py-1 px-2 font-bold"
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
            >
                B
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('italic'),
                }"
                :disabled="!editor.can().chain().focus().toggleItalic().run()"
                class="py-1 px-2 italic"
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
            >
                I
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('underline'),
                }"
                class="py-1 px-2 underline"
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
            >
                U
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 1,
                    }),
                }"
                class="py-1 px-2"
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 1 }).run()
                "
            >
                H1
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 2,
                    }),
                }"
                class="py-1 px-2"
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 2 }).run()
                "
            >
                H2
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 3,
                    }),
                }"
                class="py-1 px-2"
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 3 }).run()
                "
            >
                H3
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 4,
                    }),
                }"
                class="py-1 px-2"
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 4 }).run()
                "
            >
                H4
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 5,
                    }),
                }"
                class="py-1 px-2"
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 5 }).run()
                "
            >
                H5
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 6,
                    }),
                }"
                class="py-1 px-2"
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 6 }).run()
                "
            >
                H6
            </button>
            <button
                :class="{
                    'bg-gray-200 rounded': editor.isActive('bulletList'),
                }"
                class="py-1 px-2"
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
            >
                Список
            </button>

            <!-- Кнопка ссылки -->
            <button
                :class="{
                    'bg-blue-200 rounded': editor.isActive('link'),
                }"
                class="py-1 px-2"
                title="Ссылка"
                type="button"
                @click="setLink"
            >
                🔗
            </button>

            <!-- Опционально: кнопка удаления ссылки -->
            <button
                :disabled="!editor.isActive('link')"
                class="py-1 px-2 text-red-600 disabled:text-gray-400"
                title="Удалить ссылку"
                type="button"
                @click="editor.chain().focus().unsetLink().run()"
            >
                ✕
            </button>
        </section>
        <EditorContent :editor="editor"/>

        <!-- Errors -->
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <small v-if="error" class="error block mt-1 text-sm">
                {{ error }}
            </small>
        </transition>
    </div>
</template>

<style scoped>
/* Стили для содержимого редактора — оборачиваем в :deep() */
:deep(.ProseMirror) {
    /* List styles */

    ul {
        list-style-type: disc;
        padding: 0 1rem;
        margin: 1.25rem 1rem 1.25rem 0.4rem;
    }

    ul li p,
    ol li p {
        margin-top: 0.25em;
        margin-bottom: 0.25em;
    }

    /* Heading styles */

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        line-height: 1.1;
        margin-top: 1rem;
        text-wrap: pretty;
    }

    h1,
    h2 {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    h1 {
        font-size: 1.4rem;
    }

    h2 {
        font-size: 1.2rem;
    }

    h3 {
        font-size: 1.1rem;
    }

    h4,
    h5,
    h6 {
        font-size: 1rem;
    }

    /* Стили для ссылок */

    a {
        color: #3b82f6; /* tailwind blue-500 */
        text-decoration: underline;
        font-weight: 500;
        cursor: pointer;
    }

    a:hover {
        color: #2563eb; /* tailwind blue-600 */
        text-decoration: underline;
    }

    a:visited {
        color: #8b5cf6; /* tailwind violet-500 */
    }
}

button {
    cursor: pointer;
}
</style>
