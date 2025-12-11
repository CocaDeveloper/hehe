<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="primary-button secondary-button"
    >
        <span class="uppercase text-[20px] leading-[24px] text-white font-bold text-center w-full">
            <slot />
        </span>
    </button>
</template>
