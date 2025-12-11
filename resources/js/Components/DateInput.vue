<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
    default: ''
});

const date = ref(null);

onMounted(() => {
    if (date.value.hasAttribute('autofocus')) {
        date.value.focus();
    }
});

defineExpose({ focus: () => date.value.focus() });
</script>

<template>
    <input
        type="date"
        class="input"
        v-model="model"
        ref="date"
    />
</template>