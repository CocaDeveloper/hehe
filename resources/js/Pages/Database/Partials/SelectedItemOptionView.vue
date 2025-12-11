<script setup>
const props = defineProps({
    label: String,
    value: String
});
</script>

<template>
    <div class="font-bebas text-[20px]">
        <div class="py-2">
            <span>{{ label }}: </span>{{value}}
        </div>
    </div>
    <div class="w-full border-b border-[#4d3416]/[.1]"></div>
</template>

<style scoped>

</style>