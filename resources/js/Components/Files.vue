<template>
    <div>
        <div v-for="attachment in attachments" :key="attachment.id" class="card">
            <img src="path/to/your/file-icon.png" alt="File Icon" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">{{ attachment.file_path }}</h5>
                <p class="card-text">Subido por: {{ attachment.user.name }}</p>
                <a :href="'/storage/' + attachment.file_path" target="_blank" class="btn btn-primary">Ver archivo</a>
                <button @click="deleteFile(attachment)" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['attachments'],
    methods: {
        deleteFile(attachment) {
            axios.delete(`/attachments/${attachment.id}`)
                .then(() => {
                    this.attachments = this.attachments.filter(a => a.id !== attachment.id);
                })
                .catch(error => {
                    console.error(error);
                });
                location.reload()
        },
    },
}
</script>

<style scoped>
.card {
    width: 18rem;
}
</style>
