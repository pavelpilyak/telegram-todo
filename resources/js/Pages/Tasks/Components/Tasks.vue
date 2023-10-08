<script setup>
    import Task from './Task.vue';

    defineProps({
        date: String,
        tasks: Array,
    });
</script>

<template>
    <div class="border-b pb-4">
        <div class="flex items-center mb-2">
            <h4 class="font-semibold ml-3 text-lg">{{ date }}</h4>
        </div>
        <Task :task="task" v-for="task in tasks" :key="task.id" />
    </div>
</template>
