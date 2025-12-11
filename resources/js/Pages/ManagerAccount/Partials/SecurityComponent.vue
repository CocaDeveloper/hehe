<script setup>
import {computed} from 'vue';
import {useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import {useToast} from "vue-toastification";

const toast = useToast();

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: ''
});

const submit = async () => {
    try {

        form.processing = true;
        form.clearErrors();

        const response = await axios.patch(route('personal-data.password.update'), form.data());

        form.reset();

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

</script>

<template>
    <div class="mt-5">

        <h1 class="font-bebas mb-5 lg:text-[40px] text-[30px] uppercase text-center text-white leading-[25px]">
            Alterar <span class="text-[#FA8315]">Sua Senha!</span>
        </h1>

        <form @submit.prevent="submit">
            <div class="flex flex-col gap-5 bg-[#F5F5F5] rounded-[28px] lg:p-10 p-5">
                <div>
                    <InputLabel value="Senha Atual" />
                    <TextInput type="password" class="w-full" placeholder="Digite sua senha atual" v-model="form.current_password" />
                    <InputError class="mt-2" :message="form.errors.current_password" />
                </div>

                <div>
                    <InputLabel value="Nova Senha" />
                    <TextInput type="password" class="w-full" placeholder="Digite sua nova senha" v-model="form.password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel value="Repita a Nova Senha" />
                    <TextInput type="password" class="w-full" placeholder="Digite novamente a sua nova senha" v-model="form.password_confirmation" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="w-full mt-2 flex justify-end">
                    <PrimaryButton :disabled="form.processing">Alterar Senha</PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>