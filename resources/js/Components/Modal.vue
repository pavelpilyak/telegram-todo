<script setup>
    defineProps({
        isOpen: Boolean,
    });
    const emit = defineEmits(['close']);

    const close = () => emit('close');
</script>

<template>
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-if="isOpen">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                >
                    <div class="bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 text-white">
                        <div class="flex flex-col gap-4">
                            <slot />
                        </div>
                    </div>
                    <div class="bg-gray-900 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <slot name="actionButton" />
                        <button
                            type="button"
                            class="mt-3 m-l-auto inline-flex w-full justify-center rounded-md bg-transparent px-3 py-2 text-sm font-semibold text-white hover:bg-gray-200 hover:text-black sm:mt-0 sm:w-auto"
                            @click="close"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
