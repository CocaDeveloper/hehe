<script setup>
import {useToast} from "vue-toastification";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {computed, inject, onMounted, ref} from "vue";
import InputError from "@/Components/InputError.vue";
import { VideoCameraIcon } from '@heroicons/vue/24/solid'
import SecondaryButton from "@/Components/SecondaryButton.vue";

const toast = useToast();
const showQrCode = ref(false);
const showModalPayment = ref(false);
const qrCode = ref('');
const selectedPack = ref(null);

const packs = inject('packs');
const stores = inject('stores');

const cashpointsPack = {
    id: 'cashpoints-custom',
    name: 'COMPRAR CASHPOINTS',
    isCustomCash: true,
    items: [],
    price: null,
};

const packsWithCash = computed(() => {
    const base = Array.isArray(packs) ? packs : (packs?.value ?? []);
    return [...base, cashpointsPack];
})

const formatBRL = (value) =>
    new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);

let responsePix = null;

const form = useForm({
    value: '',
    payment_method: '',
    type: '',
    name: '',
    email: '',
    tax_id: '',
    tag: '',
    store_id: null,
    pack_id: null,
});

const paymentMethodOptions = [
    {
        label: 'PIX',
        value: 'pix'
    }
]

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

const cashpoints = computed(() => {
    if (!form.value) return '0';

    const numericValue = parseFloat(form.value.replace(/[^\d,]/g, '').replace(',', '.'));
    return Math.round(numericValue * 10000).toString();
});

const submit = async () => {
    try {

        form.clearErrors();

        if (selectedPack.value) {
            if (selectedPack.value.fromStore){
                form.store_id = selectedPack.value.id;
                form.value = selectedPack.value.price;
            } else if(!selectedPack.value.isCustomCash){
                form.pack_id = selectedPack.value.id;
                form.value = selectedPack.value.price;
            }
        }

        const response = await axios.post(route('payment.store'), form.data())

        showQrCode.value = true;
        qrCode.value = response.data.qrCode;

        verifyPaymentPixResponse(response.data.reference);

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

    }
};

const verifyPaymentPixResponse = (referenceId) => {
    responsePix = setInterval(async () => {
        try {
            const response = await axios.get(route('payment.verify', referenceId));

            if (response.data.status === 'approved') {
                showModalPayment.value = true;
                form.reset();
                clearInterval(responsePix);
            }
        } catch (e){}
    }, 5000);
};

const backToDonation = () => {
    showQrCode.value = false;
    showModalPayment.value = false;
    qrCode.value = '';
    selectedPack.value = null;

    const url = new URL(window.location.href);
    url.searchParams.delete('store');
    window.history.replaceState({}, '', url);
}

const resolveStores = () => Array.isArray(stores) ? stores : (stores?.value ?? []);

const storeToPack = (store) => ({
    id: store.id,
    name: store.item?.name ?? `Pacote #${store.id}`,
    isCustomCash: false,
    fromStore: true,
    items: [
        {
            id: store.item.id,
            quantity: store.quantity,
            item: {
                id: store.item.id,
                name: store.item.name,
            },
        },
    ],
    price: store.value,
});

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const storeId = params.get('store');

    if (!storeId) return;

    const list = resolveStores();
    const found = list.find((s) => String(s.id) === String(storeId));

    if (found) {
        selectedPack.value = storeToPack(found);
    }
});

</script>

<template>
    <div class="mt-10">

        <div class="mb-10">
            <h1 class="font-bebas lg:text-[40px] text-[30px] uppercase text-center text-white leading-[25px]">
                Faça uma doação e ajude o <span class="text-[#FA8315]">EpicMidgard!</span>
            </h1>
        </div>

        <div class="grid grid-cols-3 gap-10" v-if="selectedPack">
            <div class="col-span-2">
                <div class="mt-5 bg-[#F5F5F5] rounded-[28px] lg:p-10 p-5">

                    <div class="my-2 text-center flex flex-col items-center justify-center" v-if="showModalPayment">
                        <h5 class="font-bebas text-[30px]">Parabéns, seu pagamento foi aprovado!</h5>
                        <div class="confirm text-center">
                            <img src="/assets/images/success.png" alt="Payment Success">
                        </div>
                        <h5>Os seus CASHPOINTS já foram <strong>creditados na sua conta</strong>.</h5>
                        <h5>Caso esteja logado, relogue para receber.</h5>

                        <PrimaryButton class="mt-5" @click="backToDonation">Voltar</PrimaryButton>

                    </div>
                    <div class="text-center" v-else-if="showQrCode">
                        <h5 class="font-bebas text-[30px]">Para realizar o pagamento, siga os passos abaixo:</h5>

                        <p><b>1º</b> Abra o aplicativo do seu banco em seu celular.</p>
                        <p><b>2º</b> Selecione a opção Pagar com Pix e capture o código abaixo com a câmera.</p>
                        <div class="mx-auto w-72 my-2">
                            <img :src="`data:image/jpeg;base64,${qrCode}`" alt="QrCode">
                        </div>

                        <div class="my-2">
                            <span class="loader"></span>
                        </div>

                        <p><b>3º</b> Capture o código e confirme o pagamento.</p>
                        <p><b>4º</b> Após a confirmação do pagamento você vai receber os cashpoints automaticamente em sua conta(caso esteja logado, relogue para receber).</p>

                    </div>

                    <form @submit.prevent="submit" v-else>
                        <div class="flex flex-col gap-5">
                            <div class="flex flex-col gap-5">

                                <div class="bg-green-100 p-4 rounded-lg shadow-md">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <VideoCameraIcon class="w-5 text-green-800" />
                                        <h3 class="text-green-800 font-semibold">Streamer Parceiro:</h3>
                                    </div>
                                    <input
                                        type="text"
                                        v-model="form.tag"
                                        placeholder="Digite a tag do seu streamer favorito aqui."
                                        class="w-full p-2 border border-gray-300 rounded-md focus:border-[1px] focus:ring-0 focus:border-green-400"
                                    />
                                </div>

                                <div class="flex flex-col" v-if="!selectedPack.isCustomCash">
                                    <InputLabel value="Valor" />
                                    <TextInput  disabled="true" v-model="selectedPack.price" v-money3="moneyConfig" />
                                </div>

                                <div>
                                    <InputLabel value="Método de Pagamento" />
                                    <SelectInput class="w-full" v-model="form.payment_method" :options="paymentMethodOptions" selected-option-default="Selecione o método de pagamento" />
                                    <InputError class="mt-2" :message="form.errors.payment_method" />
                                </div>

                                <div class="flex flex-col" v-if="selectedPack.isCustomCash">
                                    <InputLabel value="Digite o valor que deseja" />
                                    <TextInput v-model="form.value" v-money3="moneyConfig" />
                                    <InputError class="mt-2" :message="form.errors.value" />
                                </div>

                                <div class="flex flex-col" v-if="selectedPack.isCustomCash">
                                    <InputLabel value="CASHPOINTS" />
                                    <TextInput disabled="true" v-model="cashpoints" />
                                </div>

                                <div class="flex flex-col">
                                    <InputLabel value="CPF" />
                                    <TextInput v-mask="'###.###.###-##'" v-model="form.tax_id" />
                                    <InputError class="mt-2" :message="form.errors.tax_id" />
                                </div>

                                <div class="flex flex-col">
                                    <InputLabel value="Nome completo" />
                                    <TextInput v-model="form.name" />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div class="flex flex-col">
                                    <InputLabel value="E-mail" />
                                    <TextInput type="email" v-model="form.email" />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                            </div>

                            <div class="flex w-full justify-between">
                                <SecondaryButton class="w-[200px]" @click="backToDonation">Voltar</SecondaryButton>
                                <PrimaryButton>Gerar QR CODE</PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Selected Pack  -->
            <div>
                <div class="mt-5">
                    <div class="bg-[#374151] rounded-[28px] relative">
                        <div class="text-center flex justify-center items-center h-12 border-b border-gray-500 shadow-md">
                            <span class="text-xl uppercase text-white">{{selectedPack.name}}</span>
                        </div>
                        <div class="flex my-3 mb-16 flex-col w-full justify-center items-start flex-grow">
                            <div
                                v-if="!selectedPack.isCustomCash"
                                v-for="pack in selectedPack.items" :key="pack.id"
                                 class="relative flex gap-2 text-white mx-5 cursor-pointer">
                                <span>{{ pack.quantity }}x</span>
                                <img class="w-6 h-6" :src="`/assets/images/database/items/icons/${pack.item.id}.png`" :alt="pack.name" />
                                <span>{{ pack.item.name }}</span>
                            </div>
                            <div
                                v-else
                                class="flex my-3 flex-col w-full justify-center items-center flex-grow px-5 text-center text-white"
                            >
                                <p class="text-sm">
                                    Escolha o valor que deseja comprar.
                                </p>
                                <p class="text-sm mt-2">
                                    A cada <strong>R$ 1,00</strong> você ganha
                                    <strong>1.000 CASHPOINTS</strong>.
                                </p>
                            </div>
                            <div class="w-full py-5 pr-3">
                                <div class="flex w-full flex-col items-center">
                                    <span
                                        v-if="!selectedPack.isCustomCash"
                                        class="text-[#FA8315] text-[20px] font-bold">{{formatBRL(selectedPack.price)}}</span>
                                    <span
                                        v-else
                                        class="text-[#FA8315] text-[20px] font-bold"
                                    >
                                        Escolha o valor
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="grid grid-cols-4 gap-10">
                <div
                    class="bg-[#374151] rounded-[28px] relative flex flex-col justify-between"
                    v-for="pack in packsWithCash"
                    :key="pack.id"
                >
                    <div class="text-center flex justify-center items-center h-12 border-b border-gray-500 shadow-md">
                        <span class="text-xl uppercase text-white">{{ pack.name }}</span>
                    </div>

                    <div
                        class="flex my-3 flex-col w-full justify-start items-start flex-grow"
                        v-if="!pack.isCustomCash"
                    >
                        <div
                            v-for="packItem in pack.items"
                            :key="packItem.id"
                            class="flex gap-2 text-white mx-5"
                        >
                            <span>{{ packItem.quantity }}x</span>
                            <img
                                class="w-6 h-6"
                                :src="`/assets/images/database/items/icons/${packItem.item.id}.png`"
                                :alt="packItem.name"
                            />
                            <span>{{ packItem.item.name }}</span>
                        </div>
                    </div>

                    <div
                        v-else
                        class="flex my-3 flex-col w-full justify-center items-center flex-grow px-5 text-center text-white"
                    >
                        <p class="text-sm">
                            Escolha o valor que deseja comprar.
                        </p>
                        <p class="text-sm mt-2">
                            A cada <strong>R$ 1,00</strong> você ganha
                            <strong>1.000 CASHPOINTS</strong>.
                        </p>
                    </div>

                    <div class="w-full py-5 pr-3 mt-auto">
                        <div class="flex w-full flex-col items-center">
                            <span
                                v-if="!pack.isCustomCash"
                                class="text-[#FA8315] text-[30px] font-bold"
                            >
                                {{ formatBRL(pack.price) }}
                            </span>
                            <span
                                v-else
                                class="text-[#FA8315] text-[20px] font-bold"
                            >
                                Escolha o valor
                            </span>
                        </div>
                        <div class="flex justify-center">
                            <PrimaryButton class="mt-5" @click="selectedPack = pack">Comprar</PrimaryButton>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>
<style>
.loader {
    width: 48px;
    height: 48px;
    border: 5px solid #FFF;
    border-bottom-color: #000;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>