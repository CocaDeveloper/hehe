<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Layout>
        <Head title="Esqueceu sua senha" />

        <div class="">

            <form @submit.prevent="submit">

                <div class="flex flex-col lg:w-1/2 lg:p-10 lg:pt-40 pt-20">

                    <h1 class="font-bebas text-[40px] uppercase mb-8 text-white lg:text-start text-center leading-[25px]">Esqueceu sua Senha</h1>

                    <span class="text-white lg:text start text-center">Esqueceu sua senha? Sem problemas. Apenas informe seu endereço de e-mail que enviaremos um link que permitirá definir uma nova senha.</span>

                    <div
                        v-if="status"
                        class="mb-4 font-bold lg:text start text-center text-green-600 mt-3"
                    >
                        {{ status }}
                    </div>

                <div>
                    <TextInput
                        placeholder="Digite o seu e-mail"
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="email"
                    />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>

                <div class="mt-4 flex lg:justify-start justify-center">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Enviar link para e-mail
                    </PrimaryButton>
                </div>
                </div>
            </form>
        </div>
    </Layout>
</template>
