<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="font-bebas text-[18px] tracking-wide ml-1 mb-1 font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
