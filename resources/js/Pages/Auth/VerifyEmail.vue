<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <Layout>
        <Head title="Verificação de E-mail" />

        <div class="flex flex-col lg:w-1/2 lg:p-10 lg:pt-40 pt-10">

            <h1 class="font-bebas text-[40px] uppercase mb-8 lg:text-start text-center text-white leading-[25px]">Esqueceu sua Senha</h1>

            <div class="mb-4 text-white lg:text-start text-center">
                Obrigado pelo cadastro em nosso servidor!<br>
                Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, ficaremos felizes em enviar outro.
            </div>

            <div
                class="mb-4 font-bold text-green-600 mt-1 lg:text-start text-center"
                v-if="verificationLinkSent"
            >
                Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o cadastro.
            </div>

            <form @submit.prevent="submit">
                <div class="mt-4 flex lg:flex-row flex-col lg:gap-0 gap-5 items-center justify-between">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Reenviar e-mail de confirmação
                    </PrimaryButton>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="rounded-md bg-gray-600 px-5 py-1 ml-5 text-sm text-white hover:bg-gray-700 uppercase font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >Sair</Link
                    >
                </div>
            </form>
        </div>
    </Layout>
</template>
