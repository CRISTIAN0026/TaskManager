<template>
    <div style="margin-top: 10px;">
        <div v-for="attachment in attachments" :key="attachment.id" class="card">
            <div class="card-body">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <p class="card-text">Archivo subido por: {{ attachment.user.name }}</p>
                <div class="button-group">
                    <a :href="'/storage/' + attachment.file_path" target="_blank" class="btn btn-primary">Ver
                        archivo</a>
                    <button v-if="$page.props.auth.user.id == attachment.user.id || $page.props.auth.user.is_super_admin" @click="deleteFile(attachment)" class="btn btn-danger">Eliminar</button>
                </div>
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
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: 0.3s;
    width: 80%;
    /* Aumentamos el ancho de la tarjeta */
    border-radius: 5px;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 2px 16px;
}

.button-group {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    /* Permite que los botones se envuelvan si no hay suficiente espacio */
}

.btn {
    margin: 10px;
    /* Aumentamos el margen alrededor de los botones */
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
    flex: 1 1 auto;
    /* Permite que los botones se expandan para llenar el espacio disponible */
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn:hover {
    opacity: 0.7;
}
</style>
