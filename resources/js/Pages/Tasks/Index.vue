<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Task from '@/Components/Task.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['tasks']);

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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task</h2>
        </template>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('tasks.store'), { onSuccess: () => form.reset() })">
                <input v-model="form.title" placeholder="Title" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                <textarea v-model="form.description" placeholder="Description" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                
                <input v-model="form.user_id" placeholder="User ID" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Tasks</PrimaryButton>
            </form>
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Task
                    v-for="task in tasks"
                    :key="task.id"
                    :task="task"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
