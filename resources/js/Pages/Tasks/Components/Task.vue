<script setup>
    import { router } from '@inertiajs/vue3';
    import { useToast } from 'vue-toast-notification';

    const { task } = defineProps({ task: Object });

    const toast = useToast();

    const handleRemove = event => {
        if (event.target.checked) {
            router.delete(`/tasks/${task.id}`);
            toast.success('Task is done!', { position: 'top' });
            return;
        }

        router.post(`/tasks/${task.id}/restore`);
        toast.info('Task is undone :(', { position: 'top' });
    };

    const id = `task${task.id}`;
</script>

<template>
    <div>
        <input class="hidden" type="checkbox" :checked="Boolean(task.deleted_at)" @change="handleRemove" :id="id">
        <label class="flex items-center h-10 px-2 rounded cursor-pointer" :for="id">
            <span class="flex items-center justify-center w-5 h-5 text-transparent border-2 border-gray-500 rounded-full">
                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </span>
            <span class="ml-4 text-sm">{{ task.description }}</span>
            <span v-if="task.time" class="ml-1 text-xs text-gray-400">({{ task.time }})</span>
        </label>
    </div>
</template>

<style scoped>
    input[type=checkbox]:checked+label span:first-of-type {
        background-color: #10B981;
        border-color: #10B981;
        color: #fff;
    }

    input[type=checkbox]:checked+label span:nth-of-type(2) {
        text-decoration: line-through;
        color: #9CA3AF;
    }
</style>
