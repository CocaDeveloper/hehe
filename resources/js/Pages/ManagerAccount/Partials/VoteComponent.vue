<script setup>
import {inject, reactive, ref} from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {useToast} from "vue-toastification";

const toast = useToast();

const voteSites = inject('voteSites');
const user = inject('user');

const loadingVote = ref('');

const vote = async (voteSiteId) => {
    loadingVote.value = voteSiteId;
    try {
        const response = await axios.post(`/vote/${voteSiteId}`);
        window.open(response.data.url, '_blank');
        user.value.votes += 1;
    } catch (error) {
        toast.error(error.response.data.message);
    } finally {
        loadingVote.value = '';
    }
};
</script>

<template>
    <div class="mt-10">
        <h1 class="font-bebas lg:text-[40px] text-[30px] uppercase text-center text-white leading-[25px]">
            Você possui <span class="text-[#FA8315]">{{ user.votes }}</span> pontos de votos.
        </h1>
        <h2 class="lg:text-[20px] text-[16px] mt-1 text-white text-center leading-[25px]">
            A cada voto você ganha 3 ponto.
        </h2>

        <div class="grid mt-10 gap-5 lg:grid-cols-3 mb-10">
            <div
                v-for="(voteSite, index) in voteSites"
                :key="index"
                class="bg-[#F5F5F5] flex flex-col justify-center items-center px-10 pt-10 rounded-[28px]"
            >
                <h1 class="font-bebas text-[40px] text-center uppercase mb-2 text-[#FA8315] leading-[25px]">
                    {{ voteSite.name }}
                </h1>
                <h2 class="text-[20px] text-[#374151] text-center font-semibold leading-[25px]">
                    Você pode votar a cada {{ voteSite.time }} hora(s).
                </h2>

                <PrimaryButton
                    @click="vote(voteSite.id)"
                    :disabled="loadingVote === voteSite.id"
                    class="my-5"
                >
                    VOTAR
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>