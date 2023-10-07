<script setup>
    import { router } from '@inertiajs/vue3';
    import Errors from '@/Components/Errors.vue';
    import Spinner from '@/Components/Spinner.vue';

    defineProps({ errors: Object });

    const webApp = window.Telegram?.WebApp;

    router.post('/auth', {
        initData: webApp?.initData,
        chatId: webApp?.initDataUnsafe?.chat?.id,
    });
</script>

<template>
    <div class="flex items-center justify-center min-h-screen tgBgColor">
        <Spinner />
        <div class="p-2">
            <Errors :errors="errors" />
        </div>
    </div>
</template>
