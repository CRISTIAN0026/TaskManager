<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    task: Object,
});

const form = useForm({
    file: null,
});
let fileInput = ref(null);

const handleFileUpload = (e) => {
    form.file = e.target.files[0];
};

const submitFiles = () => {
    let formData = new FormData();
    formData.append('file', form.file);

    form.post(route('attachments.store', props.task.id), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onSuccess: () => {
            form.reset();
        }
    });

    setTimeout(()=>{
        location.reload();
    },2000)
};

</script>

<template>
    <form @submit.prevent="submitFiles">
        <input type="file" id="file" ref="fileInput" v-on:change="e => handleFileUpload(e)">
        <InputError :message="form.errors.file" class="mt-2" />
        <PrimaryButton class="mt-4">Subir Archivo</PrimaryButton>
    </form>
</template>
