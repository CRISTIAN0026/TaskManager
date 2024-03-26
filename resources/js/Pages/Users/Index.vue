<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import User from '@/Components/User.vue';
import Register from '@/Pages/Auth/Register.vue';
import { Head } from '@inertiajs/vue3';

const as = defineProps(['users']);
</script>

<template>

    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>
        </template>
        <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 flex">
            <div class="w-full mt-6 bg-white shadow-sm rounded-lg divide-y pr-4"
                style="max-height: 200px; overflow-y: auto;">
                <User v-for="user in users" :key="user.id" :user="user" />
            </div>
            <div class="w-full pl-4">
                <Register />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
