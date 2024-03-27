<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RegisterLayout from '@/Layouts/RegisterLayout.vue';
import Task from '@/Components/Task.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

const props = defineProps(['tasks', 'users']);

const form = useForm({
    title: '',
    description: '',
    status: 'Pendiente',
    user_id: '',
});

</script>


<template>

    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tareas</h2>
        </template>
        <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 flex">
            <div class="w-full mt-6 bg-white shadow-sm rounded-lg divide-y pr-4">
                <Task v-for="task in tasks" :key="task.id" :task="task" :users="users"/>
            </div>
            <div v-if="$page.props.auth.user.is_super_admin" class="w-full pl-4">
                <RegisterLayout>
                <form @submit.prevent="form.post(route('tasks.store'), { onSuccess: () => form.reset() })">
                    <select v-model="form.user_id" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="" disabled>Seleccionar empleado</option>
                        <option v-for="user in users" :value="user.id" :key="user.id">{{ user.name }}</option>
                    </select>
                    <input v-model="form.title" placeholder="Title"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                    <textarea v-model="form.description" placeholder="Description"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <PrimaryButton class="mt-4">Crear tarea</PrimaryButton>
                </form>
            </RegisterLayout>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
