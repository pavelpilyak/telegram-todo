<script setup>
    import Label from './Label.vue';

    defineProps({
        label: String,
        placeholder: String,
        type: {
			type: String,
			default: 'text',
		},
		value: String,
    });
</script>

<template>
    <div class="w-full">
        <Label v-if="label">{{ label }}</Label>
        <div class="relative">
            <input
                class="px-2 h-9 leading-normal block w-full text-gray-800 bg-gray-100 font-sans rounded text-left appearance-none outline-none"
                :placeholder="placeholder"
                :type="type"
                :value="value"
            />
        </div>
    </div>
</template>
