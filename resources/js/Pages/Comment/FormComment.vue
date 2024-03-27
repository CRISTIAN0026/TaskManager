<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    task: Object,
});

const form = useForm({
    content: '',
});

const submitComment = () => {
    form.post(route('comments.store', props.task.id), {
        onSuccess: () => {
            form.reset();
            location.reload();
        }
    });
};

</script>


<template>
    <form @submit.prevent="submitComment">
        <textarea v-model="form.content"
            class="w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
        <InputError :message="form.errors.body" class="mt-2" />
        <PrimaryButton class="mt-4">Comentar</PrimaryButton>
    </form>
</template>