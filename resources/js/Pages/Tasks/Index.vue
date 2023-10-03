<script setup>
    defineProps({ userId: String });
</script>

<template>
    <p class="userId">{{ userId }}</p>
</template>

<style>
    .userId {
        color: white;
    }
</style>
