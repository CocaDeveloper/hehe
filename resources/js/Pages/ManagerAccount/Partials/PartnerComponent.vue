<script setup>
import {useToast} from "vue-toastification";
import {useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const toast = useToast();

import { useClipboard } from "@vueuse/core";
import { ClipboardIcon, CheckIcon } from "@heroicons/vue/24/outline";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {computed, ref} from "vue";
import WithdrawBalanceModal from "@/Pages/ManagerAccount/Partials/WithdrawBalanceModal.vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const isModalWithdrawBalanceOpen = ref(false);

const form = useForm({
    tag: user.value.tag,
});

const { copy, copied } = useClipboard();

const copyTag = () => {
    if (form.tag) {
        copy(form.tag);
    }
};

const submit = async () => {
    try {

        form.clearErrors();

        const response = await axios.post(route('partner.saveTag'), form.data());

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

    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
}


const openWithdrawBalanceModal = () => {
    isModalWithdrawBalanceOpen.value = true;
};

const closeWithdrawBalanceModal = () => {
    isModalWithdrawBalanceOpen.value = false;
};

</script>

<template>
    <div class="mt-10">
        <h1 class="font-bebas lg:text-[40px] text-[30px] uppercase text-center text-white leading-[25px]">
            Parceria <span class="text-[#FA8315]">RagnaFrost!</span>
        </h1>
        <h2 class="lg:text-[20px] text-[16px] mt-1 text-white text-center leading-[25px]">
            Compartilhe sua tag! Se os jogadores fizerem doações utilizando-a, você receberá <span class="text-[#FA8315]">20% do valor dos cashpoints</span>.
        </h2>

        <form @submit.prevent="submit">
            <div class="mt-5 bg-[#F5F5F5] rounded-[28px] lg:p-10 p-5">
                <InputLabel value="#Tag" />
                <div class="flex items-center space-x-3">
                   <div class="flex flex-col flex-grow">
                       <TextInput v-model="form.tag" />
                       <InputError class="mt-2" :message="form.errors.tag" />
                   </div>
                    <button
                        @click.stop="copyTag"
                        type="button"
                        class="p-2 bg-gray-200 hover:bg-gray-300 transition rounded-lg"
                    >
                        <CheckIcon v-if="copied" class="w-6 h-6 text-green-600" />
                        <ClipboardIcon v-else class="w-6 h-6 text-gray-600" />
                    </button>
                </div>
                <div class="mt-5 flex justify-end">
                    <PrimaryButton>Salvar Tag</PrimaryButton>
                </div>
            </div>
        </form>

<!--        <h1 class="font-bebas lg:text-[40px] text-[30px] mt-10 uppercase text-center text-white leading-[25px]">-->
<!--            Você possui <span class="text-[#FA8315]">{{formatCurrency(user.payout_balance)}}</span> para resgatar.-->
<!--        </h1>-->

<!--        <div class="flex justify-center mt-5">-->
<!--            <PrimaryButton @click="openWithdrawBalanceModal">Resgatar Saldo</PrimaryButton>-->
<!--            <WithdrawBalanceModal :isOpen="isModalWithdrawBalanceOpen" @close="closeWithdrawBalanceModal" />-->
<!--        </div>-->

    </div>
</template>