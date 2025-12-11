<script setup>

import {Skeleton} from "@brayamvalero/vue3-skeleton";
</script>

<template>
    <div class="col-span-3 h-[80vh]">
        <div class="flex flex-col items-center justify-center gap-3 w-full">
            <div
                class="w-full h-full"
                v-for="n in 10" :key="n"
            >
                <Skeleton width="100" height="48px" borderRadius="8px" />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>