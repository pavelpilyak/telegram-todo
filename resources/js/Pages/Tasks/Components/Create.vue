<script setup>
    import { reactive, ref } from 'vue';
    import dayjs from 'dayjs';
    import timezone from 'dayjs/plugin/timezone';
    import { router } from '@inertiajs/vue3';
    import Errors from '@/Components/Errors.vue';
    import Modal from '@/Components/Modal.vue';
    import Label from '@/Components/Label.vue';
    import TextInput from '@/Components/TextInput.vue';
    import VueDatePicker from '@vuepic/vue-datepicker';
    import { formatDate } from '../Lib/formatDate';
    import { formatDatePart } from '../Lib/formatDatePart';

    dayjs.extend(timezone);

    const isModalOpen = ref(false);
    const errors = ref({});
    const form = reactive({
        description: '',
        notify_at: null,
        timezone: dayjs.tz.guess(),
    });

    const handleDescriptionInput = input => {
        form.description = input.target.value;
        errors.value = {};
    };

    const notifyAtFormat = date => {
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        const hour = date.getHours();
        const minutes = date.getMinutes();

        return `Notify me on ${formatDatePart(day)}.${formatDatePart(month)}.${year} at ${formatDatePart(hour)}:${formatDatePart(minutes)}`;
    };

    const handleSubmit = () => {
        if (!form.description) {
            errors.value['description'] = 'Task description is required';
            return;
        }

        router.post('/tasks', {
            ...form,
            notify_at: form.notify_at ? formatDate(form.notify_at) : null,
        });

        isModalOpen.value = false;
        form.description = '';
        form.notify_at = null;
    };
</script>

<template>
    <button
        class="bg-gray-600 shadow-xl hover:bg-gray-700 text-white font-bold rounded-full p-2 w-48"
        @click="isModalOpen = true"
    >
        Add new task
    </button>

    <Modal :isOpen="isModalOpen" @close="isModalOpen = false">
        <TextInput label="Task Description" @input="handleDescriptionInput" :value="form.description" />
        <div>
            <Label>Notification Date</Label>
            <VueDatePicker v-model="form.notify_at" :teleport="true" teleport-center :format="notifyAtFormat" time-picker-inline />
        </div>
        <Errors :errors="errors" />
        <template v-slot:actionButton>
            <button
                @click="handleSubmit"
                type="button"
                class="inline-flex w-full justify-center rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-900 sm:ml-3 sm:w-auto"
            >
                Add
            </button>
        </template>
    </Modal>
</template>
