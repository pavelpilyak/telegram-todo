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
    <div class="w-full min-h-screen flex flex-col gap-4 bg-gray-800 shadow-lg text-gray-200 tgBgColor tgTextColor">
        <ul
            class="flex list-none flex-row flex-wrap border-b-0 pl-0"
            role="tablist"
            data-te-nav-ref
        >
            <li class="flex-auto text-center">
                <Link
                    href="/tasks"
                    :only="['tasks']"
                    :class="`block border-primary-400 border-b-2 px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:bg-blue-400 hover:text-white focus:isolate focus:border-transparent text-primary-400 ${isArchive ? 'border-transparent' : ''} tgButtonColor tgButtonTextColor`"
                >
                    Active
                </Link>
            </li>
            <li class="flex-auto text-center">
                <Link
                    href="/tasks/archive"
                    :only="['tasks']"
                    :class="`block border-x-0 border-b-2 border-t-0 px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:bg-blue-400 hover:text-white focus:isolate focus:border-transparent  ${!isArchive ? 'border-transparent' : ''} tgButtonColor tgButtonTextColor`"
                >
                    Archive
                </Link>
            </li>
        </ul>
        <Create />
        <p v-if="tasks.length === 0" class="text-lg">There's nothing here yet</p>
        <p v-if="tasks.length === 0 && !isArchive" class="text-lg">To add a task, click the button on the bottom right</p>
        <DayTasks :date="date" :tasks="tasks" v-for="[date, tasks] in sortTasksByDate(tasks, timezone, isArchive)" />
    </div>
</template>
