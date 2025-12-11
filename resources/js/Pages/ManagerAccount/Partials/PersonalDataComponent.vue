<script setup>
import {computed} from 'vue';
import {useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import DateInput from "@/Components/DateInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const genderOptions = [
    {
        label: 'Masculino',
        value: 'M'
    },
    {
        label: 'Feminino',
        value: 'F'
    },
]

const form = useForm({
    gender: user.value.sex,
    birthdate: user.value.birthdate ?? ''
});

const submit = () => {
    form.patch(route('personal-data.update'));
};

</script>

<template>
    <div class="mt-5">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-5 bg-[#F5F5F5] rounded-[28px] lg:p-10 p-5">
                <div>
                    <InputLabel value="Login" />
                    <TextInput class="w-full" placeholder="Login" disabled="true" :model-value="user.login" />
                </div>
                <div>
                    <InputLabel value="Email" />
                    <TextInput class="w-full" placeholder="Email" disabled="true" :model-value="user.email" />
                </div>
                <div>
                    <InputLabel value="Gênero" />
                    <SelectInput class="w-full" :options="genderOptions" v-model="form.gender" selectedOptionDefault="Selecione o Gênero" />
                    <InputError class="mt-2" :message="form.errors.gender" />
                </div>
                <div>
                    <InputLabel value="Data de Nascimento" />
                    <DateInput class="w-full" v-model="form.birthdate" />
                    <InputError class="mt-2" :message="form.errors.birthdate" />
                </div>

                <div class="w-full mt-2 flex justify-end">
                    <PrimaryButton :disabled="!form.birthdate || !form.gender">Salvar</PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>