<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import FormComment from '@/Pages/Comment/FormComment.vue';
import Comment from '@/Pages/Comment/Comment.vue';
import FileUpload from '@/Components/FileUpload.vue';
import Files from '@/Components/Files.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';

dayjs.extend(relativeTime);

const props = defineProps({
    task: Object,
    users: Array
});

const { task, users } = toRefs(props);

const comments = task.value.comments;
const attachments = task.value.attachments;

dayjs.extend(relativeTime);


const form = useForm({
    title: props.task.title,
    user_id: props.task.user_id,
    status: props.task.status,
    description: props.task.description,
});

const editing = ref(false);
</script>

<template>
    <div class="p-6 flex space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 4v16m8-16v16m8-16v16m2-14a6 6 0 00-6 6v6a6 6 0 006-6 6 6 0 00-6-6 6 6 0 00-6 6v6a6 6 0 006-6 6 6 0 00-6-6z">
            </path>
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">Empleado asignado: {{ task.user.name.toLowerCase() }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(task.created_at).fromNow() }}</small>
                    <small v-if="task.created_at !== task.updated_at" class="text-sm text-gray-600"> &middot;
                        edited</small>
                </div>
                <Dropdown v-if="task.user_id == $page.props.auth.user.id || $page.props.auth.user.is_super_admin">

                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                            @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('tasks.destroy', task.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing && $page.props.auth.user.is_super_admin"
                @submit.prevent="form.put(route('tasks.update', task.id), { onSuccess: () => editing = false })">
                <input v-model="form.title"
                    class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <InputError :message="form.errors.title" class="mt-2" />
                <select v-model="form.user_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" disabled>Seleccionar empleado</option>
                    <option v-for="user in users" :value="user.id" :key="user.id">{{ user.name }}</option>
                </select>
                <InputError :message="form.errors.user_id" class="mt-2" />
                <select v-model="form.status"
                    class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" disabled>Seleccionar estado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Bloqueado">Bloqueado</option>
                    <option value="Completado">Completado</option>
                </select>
                <InputError :message="form.errors.status" class="mt-2" />

                <textarea v-model="form.description"
                    class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.description" class="mt-2" />

                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <form v-else-if="editing && $page.props.auth.user.id == task.user_id"
                @submit.prevent="form.put(route('tasks.updateStatus', task.id), { onSuccess: () => editing = false })">
                <select v-model="form.status"
                    class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" disabled>Seleccionar estado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Bloqueado">Bloqueado</option>
                    <option value="Completado">Completado</option>
                </select>
                <InputError :message="form.errors.status" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <p v-else class="mt-4 text-lg text-gray-900 font-bold">Tarea: {{ task.title }}</p>
            <p class="mt-4 text-lg text-gray-700">Descripción: {{ task.title }}</p>
            <FormComment :task="task" />
            <Comment v-for="comment in comments" :key="comment.id" :comment="comment" />
            <FileUpload :task="task" />
            <Files :attachments="attachments" />
        </div>

    </div>
</template>