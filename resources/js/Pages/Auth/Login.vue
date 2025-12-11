<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import InputError from "@/Components/InputError.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Entrar" />

        <form @submit.prevent="submit">
            <div class="flex flex-col lg:w-1/2 lg:p-10 lg:pt-40 pt-20">

                <h1 class="font-barlow font-semibold text-[40px] lg:text-start text-center uppercase mb-8 text-white leading-[25px]">Acesse <span class="text-[#FFBD00]">sua conta</span></h1>

                <TextInput
                    id="login"
                    placeholder="Digite o seu usuário"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login"
                    required
                    autofocus
                    autocomplete="login"
                />
                <InputError class="mt-1" :message="form.errors.login" />

                <TextInput
                    id="password"
                    placeholder="Digite a sua senha"
                    type="password"
                    class="mt-5 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-1" :message="form.errors.password" />

                <div class="mt-5">
                    <div class="flex justify-between">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember"/>
                            <span class="ms-2 text-sm text-[20px] font-semibold text-white"
                            >Lembrar-me</span
                            >
                        </label>
                        <div>
                            <Link href="/forgot-password"><span class="text-[16px] font-semibold leading-[21.79px] text-[#FFFFFF]/[.7] hover:text-[#FFA500]">Esqueceu sua senha?</span></Link>
                        </div>
                    </div>
                </div>

                <PrimaryButton
                    class="mt-5"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.login || !form.password"
                >
                    Acessar
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>
