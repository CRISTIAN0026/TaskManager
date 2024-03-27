<!-- <script setup>
import axios from "axios";
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';

export default {
    data() {
        return {
            start_date: '',
            end_date: ''
        }
    },
    methods: {
        async generateReport() {
            const response = await axios.get('/tasks/report', {
                params: {
                    start_date: this.start_date,
                    end_date: this.end_date
                },
                responseType: 'json'
            });

            const tasks = response.data;

            const pdf = new jsPDF();
            pdf.setFontSize(22);
            pdf.text('Informe de Tareas', 10, 10);

            const tableData = tasks.map(task => {
                return [
                    task.task_name,
                    task.status,
                    task.time,
                    task.user
                ];
            });

            pdf.autoTable({
                head: [['Nombre de la tarea', 'Estado', 'Tiempo', 'Usuario']],
                body: tableData,
                styles: { halign: 'center' },
            });

            pdf.save('Reporte de tareas.pdf');
        }
    }
}

import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <div>
        <h1>Generar informe de tareas</h1>

        <form @submit.prevent="generateReport">
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" id="start_date" v-model="start_date">

            <label for="end_date">Fecha de finalización:</label>
            <input type="date" id="end_date" v-model="end_date">
            <PrimaryButton class="mt-4">Generar informe</PrimaryButton>
        </form>
    </div>
</template> -->

<script setup>
import axios from "axios";
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';

let start_date = '';
let end_date = '';

async function generateReport() {
    const response = await axios.get('/tasks/report', {
        params: {
            start_date: start_date,
            end_date: end_date
        },
        responseType: 'json'
    });

    const tasks = response.data;

    const pdf = new jsPDF();
    pdf.setFontSize(22);
    pdf.text('Informe de Tareas', 10, 10);

    const tableData = tasks.map(task => {
        return [
            task.task_name,
            task.status,
            task.time,
            task.user
        ];
    });

    pdf.autoTable({
        head: [['Nombre de la tarea', 'Estado', 'Tiempo', 'Usuario']],
        body: tableData,
        styles: { halign: 'center' },
    });

    pdf.save('Reporte de tareas.pdf');
}

import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: space-between;">
        <h1>Generar informe de tareas</h1>

        <form @submit.prevent="generateReport"
            style="display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
            <div>
                <label for="start_date">Fecha de Inicio:</label>
                <input type="date" id="start_date" v-model="start_date">
            </div>

            <div>
                <label for="end_date">Fecha de Finalización:</label>
                <input type="date" id="end_date" v-model="end_date">
            </div>

            <PrimaryButton class="mt-4">Generar informe</PrimaryButton>
        </form>
    </div>

</template>
