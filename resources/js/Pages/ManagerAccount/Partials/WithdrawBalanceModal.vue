<script setup>
import {defineProps, defineEmits, watch, computed} from 'vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import {useToast} from "vue-toastification";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    isOpen: Boolean,
});

const toast = useToast();

const emit = defineEmits(['close']);

watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

const form = useForm({
    value: '',
    type_key: '',
    key: '',
});

const moneyConfig = {
    prefix: 'R$ ',
    suffix: '',
    thousands: '.',
    decimal: ',',
    precision: 2,
    disableNegative: false,
    disabled: false,
    min: null,
    max: null,
    allowBlank: false,
    minimumNumberOfCharacters: 0,
    shouldRound: true,
    focusOnRight: false,
}

const typeKeyOptions = [
    {
        label: 'CPF',
        value: 'cpf'
    },
    {
        label: 'Telefone',
        value: 'phone'
    },
    {
        label: 'E-mail',
        value: 'email'
    },
];


const submit = async () => {
    try {

        form.processing = true;
        form.clearErrors();

        const response = await axios.post(route('partner.withdraw.store'), form.data());

        toast.success(response.data.message);

    } catch (error) {
        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;

            for (let field in errors) {
                form.setError(field, errors[field][0]);
            }
        } else {
            toast.error(error.response.data.message);
        }
    } finally {
        form.processing = false;
    }
};

const maskType = computed(() => {
    if (form.type_key === 'phone') {
        return '(##) # ####-####';
    } else if (form.type_key === 'cpf') {
        return '###.###.###-##';
    } else {
        return '';
    }
});

</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60">
        <div class="bg-[#F5F5F5] p-5 relative rounded-lg shadow-lg w-1/3">
            <h2 class="font-bebas text-[30px]">Solicitar Resgate de Saldo</h2>

            <button
                class="text-gray-700 absolute top-0 right-5 hover:text-gray-900 text-[30px]"
                @click="emit('close')"
                aria-label="Fechar"
            >
                &times;
            </button>

            <div class="bg-orange-100 border-l-4 mb-3 border-orange-500 text-orange-700 p-4" role="alert">
                <p class="font-bold">Importante!</p>
                <p>Só é possível realizar uma solicitação por semana.</p>
                <p>O dinheiro deve cair na conta em até 5 minutos.</p>
                <p>Confira os dados, valores para chave pix incorretas não podem ser reembolsados.</p>
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel>Valor</InputLabel>
                    <TextInput class="w-full" v-model="form.value" v-money3="moneyConfig" placeholder="Informe o valor para resgatar." />
                    <InputError class="mt-2" :message="form.errors.value" />
                </div>

                <div class="mt-5">
                    <InputLabel>Tipo de chave pix</InputLabel>
                    <SelectInput class="w-full" selected-option-default="Selecione o tipo de chave PIX" :options="typeKeyOptions" v-model="form.type_key" />
                    <InputError class="mt-2" :message="form.errors.type_key" />
                </div>

                <div class="mt-5">
                    <InputLabel>Chave Pix</InputLabel>

                    <TextInput v-if="!maskType"
                               class="w-full"
                               v-model="form.key"
                               placeholder="Digite a chave PIX" />

                    <TextInput v-else
                               class="w-full"
                               v-model="form.key"
                               v-mask="maskType"
                               placeholder="Digite a chave PIX" />

                    <InputError class="mt-2" :message="form.errors.key" />
                </div>

                <div class="flex justify-center gap-3 mt-4">
                    <PrimaryButton :disabled="form.processing">
                        Solicitar Resgate de Saldo
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>