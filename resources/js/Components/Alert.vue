<script setup>
    defineProps({
        text: String,
        type: String, // primary | secondary | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark'
    });
</script>

<template>
    <div class="w-full p-5 rounded-lg border border-blue-400 bg-blue-300 text-blue-900" v-if="type === 'primary'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-gray-500 bg-gray-400 text-gray-900" v-if="type === 'secondary'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-green-400 bg-green-300 text-green-900" v-if="type === 'success'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-red-400 bg-red-300 text-red-900" v-if="type === 'danger'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-yellow-400 bg-yellow-300 text-yellow-900" v-if="type === 'warning'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-blue-300 bg-blue-200 text-blue-900" v-if="type === 'info'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-gray-200 bg-gray-100 text-gray-600" v-if="type === 'light'">
        {{ text }}
    </div>
    <div class="w-full p-5 rounded-lg border border-gray-600 bg-gray-500 text-gray-900" v-if="type === 'dark'">
        {{ text }}
    </div>
</template>
