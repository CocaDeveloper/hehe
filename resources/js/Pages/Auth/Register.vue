<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const form = useForm({
    login: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone: '',
});

const submit = () => {
    form.post(route('register'));
};
</script>

<template>
    <AuthLayout>
        <Head title="Criar Conta" />

        <form @submit.prevent="submit">
            <div class="flex flex-col lg:w-1/2 lg:p-10 lg:pt-40 pt-20">
                <h1 class="font-bebas text-[40px] lg:text-start text-center uppercase mb-8 text-white leading-[25px]">Crie <span class="text-[#FFBD00]">sua conta</span></h1>
                <div class="md:grid md:grid-cols-2 flex flex-col gap-5">
                    <div>
                        <TextInput
                            id="login"
                            type="text"
                            class="block w-full"
                            v-model="form.login"
                            required
                            autofocus
                            autocomplete="login"
                            placeholder="Digite o seu login"
                        />
                        <InputError class="mt-1" :message="form.errors.login" />
                    </div>

                    <div>
                        <TextInput
                            id="email"
                            type="email"
                            class="block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Digite o seu e-mail"
                        />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>

                    <div>
                        <TextInput
                            id="password"
                            type="password"
                            class="block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            placeholder="Digite a sua senha"
                        />
                        <InputError class="mt-1" :message="form.errors.password" />
                    </div>

                    <div>
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Repita a sua senha"
                        />
                    </div>

                    <div class="col-span-2">
                        <TextInput
                            id="phone"
                            type="text"
                            class="block w-full"
                            v-model="form.phone"
                            autocomplete="phone"
                            v-mask="'(##) # ####-####'"
                            placeholder="Digite o seu telefone (opcional)"
                        />
                        <InputError class="mt-1" :message="form.errors.phone" />
                    </div>
                </div>

                <PrimaryButton
                    class="mt-5"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.login || !form.email || !form.password || !form.password_confirmation"
                >
                    Criar Conta
                </PrimaryButton>

                <Link href="/login">
                    <SecondaryButton class="mt-5 w-full">Voltar para o Login</SecondaryButton>
                </Link>

            </div>
        </form>
    </AuthLayout>
</template>
