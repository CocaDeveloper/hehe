<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: [String, Number],
    required: true,
});

defineProps({
    options: {
        type: Array,
        required: true,
        default: () => [],
    },
    selectedOptionDefault: {
        type: String,
        required: true,
    }
});

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select
        class="input"
        v-model="model"
        ref="select"
    >
        <option value="" disabled>{{ selectedOptionDefault }}</option>
        <option
            v-for="(option, index) in options"
            :key="index"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>