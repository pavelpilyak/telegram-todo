<script setup>
    import { Link, router } from '@inertiajs/vue3';
    import Create from './Components/Create.vue';
    import DayTasks from './Components/DayTasks.vue';
    import { sortTasksByDate } from './Lib/sortTasksByDate';

    const { tasks, timezone } = defineProps({
        errors: Object,
        tasks: Array,
        timezone: String,
    });

    const isArchive = router.page.url !== '/tasks';
</script>

<template>
    <div class="w-full min-h-screen p-4 flex flex-col gap-4 bg-gray-800 shadow-lg text-gray-200">
        <ul
            class="flex list-none flex-row flex-wrap border-b-0 pl-0"
            role="tablist"
            data-te-nav-ref
        >
            <li>
                <Link
                    href="/tasks"
                    :only="['tasks']"
                    :class="`my-2 block border-primary-400 border-b-2 px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:bg-neutral-100 focus:isolate focus:border-transparent dark:text-neutral-400 dark:hover:bg-transparent text-primary-400 ${isArchive ? 'border-transparent' : ''}`"
                >
                    Active
                </Link>
            </li>
            <li>
                <Link
                    href="/tasks/archive"
                    :only="['tasks']"
                    :class="`my-2 block border-x-0 border-b-2 border-t-0 px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:bg-neutral-100 focus:isolate focus:border-transparent dark:text-neutral-400 dark:hover:bg-transparent ${!isArchive ? 'border-transparent' : ''}`"
                >
                    Archive
                </Link>
            </li>
        </ul>
        <Create />
        <DayTasks :date="date" :tasks="tasks" v-for="[date, tasks] in sortTasksByDate(tasks, timezone, isArchive)" />
    </div>
</template>
