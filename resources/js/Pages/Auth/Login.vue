<script setup>
    import { router } from '@inertiajs/vue3';
    import Errors from '@/Components/Errors.vue';

    defineProps({ errors: Object });

    const webApp = window.Telegram?.WebApp;

    // TODO: loading spinner
    router.post('/auth', {
        initData: webApp?.initData,
        chatId: webApp?.initDataUnsafe?.chat?.id,
    });
</script>

<template>
    <Errors :errors="errors" />
</template>
