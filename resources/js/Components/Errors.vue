<script setup>
    import Alert from '@/Components/Alert.vue';

    defineProps({
        errors: Object,
    });
</script>

<template>
    <div v-if="Object.keys(errors).length" class="flex flex-col justify-center items-center space-y-2">
        <Alert
            :text="errors[key]"
            type="danger"
            v-for="key in Object.keys(errors || {})" :key="key"
        />
    </div>
</template>
