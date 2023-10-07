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
        @click="isModalOpen = true"
        class="fixed bottom-4 right-4 p-0 w-12 h-12 bg-gray-600 rounded-full hover:bg-blue-600 hover:text-white active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none tgButtonColor tgButtonTextColor"
    >
        <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-6 h-6 inline-block">
            <path fill="#FFFFFF" d="M16,10c0,0.553-0.048,1-0.601,1H11v4.399C11,15.951,10.553,16,10,16c-0.553,0-1-0.049-1-0.601V11H4.601
                                    C4.049,11,4,10.553,4,10c0-0.553,0.049-1,0.601-1H9V4.601C9,4.048,9.447,4,10,4c0.553,0,1,0.048,1,0.601V9h4.399
                                    C15.952,9,16,9.447,16,10z" />
        </svg>
    </button>

    <Modal :isOpen="isModalOpen" @close="isModalOpen = false">
        <TextInput label="Task Description" @input="handleDescriptionInput" :value="form.description" />
        <div>
            <Label>Notification Date</Label>
            <VueDatePicker v-model="form.notify_at" dark :teleport="true" teleport-center :format="notifyAtFormat" time-picker-inline />
        </div>
        <Errors :errors="errors" />
        <template v-slot:actionButton>
            <button
                @click="handleSubmit"
                type="button"
                class="inline-flex w-full justify-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-blue-600 hover:text-white sm:ml-3 sm:w-auto tgButtonColor tgButtonTextColor"
            >
                Add
            </button>
        </template>
    </Modal>
</template>
