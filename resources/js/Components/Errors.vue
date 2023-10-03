<script setup>
    defineProps({ errors: Object });
</script>

<template>
    <p class="error" v-for="key in Object.keys(errors || {})" :key="key">
        {{ errors[key] }}
    </p>
</template>

<style>
    .error {
        color: red;
    }
</style>
