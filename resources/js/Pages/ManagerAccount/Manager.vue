<script setup>

import Layout from "@/Layouts/Layout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {computed, ref, watch, provide} from "vue";
import VoteComponent from "@/Pages/ManagerAccount/Partials/VoteComponent.vue";
import PersonalDataComponent from "@/Pages/ManagerAccount/Partials/PersonalDataComponent.vue";
import DonateComponent from "@/Pages/ManagerAccount/Partials/DonateComponent.vue";
import PartnerComponent from "@/Pages/ManagerAccount/Partials/PartnerComponent.vue";
import SecurityComponent from "@/Pages/ManagerAccount/Partials/SecurityComponent.vue";
import CharsComponent from "@/Pages/ManagerAccount/Partials/CharsComponent.vue";

const props = defineProps({
    voteSites: Object,
    chars: Object,
    packs: Object,
    stores: Object,
    tab: String
});

const page = usePage();

const user = computed(() => page.props.auth.user);

provide('voteSites', props.voteSites);
provide('chars', props.chars);
provide('packs', props.packs);
provide('stores', props.stores);
provide('user', user);

const tabs = [
    { id: "personal-data", name: "Dados Pessoais", icon: "/assets/images/personal-data-icon.png" },
    { id: "chars", name: "Personagens", icon: "/assets/images/chars-icon.png" },
    { id: "donate", name: "Fazer Doação", icon: "/assets/images/donate-icon.png" },
    { id: "vote-points", name: "Vote por Pontos", icon: "/assets/images/vote-points-icon.png" },
    { id: "security", name: "Segurança", icon: "/assets/images/security-icon.png" },
    { id: "logout", name: "Sair da Conta", icon: "/assets/images/logout-icon.png" },
];

if(user.value.has_partner){
    tabs.push({ id: "partner", name: "Parceria", icon: "/assets/images/partner-icon.png" });
}

const setUrlTab = (tabId) => {
    const url = new URL(window.location.origin + page.url);
    url.searchParams.set('tab', tabId);

    router.get(url.toString(), {}, { replace: true });
}
const getDefaultTab = () => {
    const tabParam = props.tab;

    if(!tabParam){
        setUrlTab('personal-data');
    }

    return tabs.some(tab => tab.id === tabParam) ? tabParam : 'personal-data';
};

const selectedTab = ref(getDefaultTab());

const selectTab = (tabId) => {
    selectedTab.value = tabId;

    setUrlTab(tabId);
};

watch(selectedTab, function (tab){
    if(tab === 'logout'){
        router.post('logout');
    }
})

</script>

<template>
    <Layout>
        <Head title="Gerenciar Conta" />

        <div class="flex flex-col lg:p-10 mt-[40px]">
            <h1 class="font-bebas lg:text-[40px] text-[24px] uppercase lg:mb-8 text-white leading-[25px]">Olá, <span class="text-[#FA8315]">{{user.login}}.</span></h1>
            <h2 class="lg:text-[32px] text-[14px] text-white font-semibold leading-[25px]">Fique á vontade para gerenciar sua conta.</h2>

            <div class="grid lg:mt-10 mt-3 gap-2 2xl:grid-cols-6 lg:grid-cols-4 grid-cols-2">
                <div
                    v-for="tab in tabs"
                    :key="tab.id"
                    :class="['manager-account-item', { 'manager-account-active': selectedTab === tab.id }]"
                    @click="selectTab(tab.id)"
                >
                    <img :src="tab.icon" :alt="`${tab.name} Icon`" />
                    <span>{{ tab.name }}</span>
                </div>
            </div>

            <PersonalDataComponent v-if="selectedTab === 'personal-data'" />
            <VoteComponent v-if="selectedTab === 'vote-points'" />
            <DonateComponent v-if="selectedTab === 'donate'" />
            <PartnerComponent v-if="selectedTab === 'partner' && user.has_partner" />
            <SecurityComponent v-if="selectedTab === 'security'" />
            <CharsComponent v-if="selectedTab === 'chars'" />
        </div>
    </Layout>
</template>

<style scoped>

</style>