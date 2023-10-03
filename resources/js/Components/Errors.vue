<script setup>
    defineProps({ errors: Object });
</script>

<template>
    <p v-for="key in Object.keys(errors || {})">
        {{ errors[key] }}
    </p>
</template>
