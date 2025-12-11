<script setup>
const props = defineProps({
    drop: Object,
    rate: Number
});
</script>

<template>
    <div class="font-bebas text-[20px]" v-if="drop">
        <div class="py-2">
            <div class="flex gap-2 items-center">
                <img :src="`/assets/images/database/items/icons/${drop.id}.png`" :alt="drop.name" />
                <span>{{drop.name}} ({{rate / 100}}%)</span>
            </div>
        </div>
    </div>
    <div v-if="drop" class="w-full border-b border-[#4d3416]/[.1]"></div>
</template>

<style scoped>

</style>