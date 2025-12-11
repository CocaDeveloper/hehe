<script setup>
import Layout from "@/Layouts/Layout.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";
import RankingZenys from "@/Pages/Rankings/Partials/RankingZenys.vue";
import RankingChars from "@/Pages/Rankings/Partials/RankingChars.vue";
import RankingGuilds from "@/Pages/Rankings/Partials/RankingGuilds.vue";

const props = defineProps({
    zenys: Object,
    chars: Object,
    guilds: Object,
});

const selectedTab = ref('zenys');

const tabs = [
    { id: "zenys", name: "Zenys" },
    { id: "chars", name: "Personagens" },
    { id: "guilds", name: "Clãns" },
];

const selectTab = (tabId) => {
    selectedTab.value = tabId;
};

</script>

<template>
    <Layout>
        <Head title="Rankings" />

        <div class="grid lg:mt-40 mt-3 gap-2 2xl:grid-cols-6 lg:grid-cols-4 grid-cols-2">
            <div
                :class="['manager-account-item', { 'manager-account-active': selectedTab === tab.id }]"
                class="flex justify-center w-full" v-for="tab in tabs"
                @click="selectTab(tab.id)"
            >
                <div>
                    <span>{{ tab.name }}</span>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <RankingZenys v-if="selectedTab === 'zenys'" :zenys="props.zenys" />
            <RankingChars v-if="selectedTab === 'chars'" :chars="props.chars" />
            <RankingGuilds v-if="selectedTab === 'guilds'" :guilds="props.guilds" />
        </div>



    </Layout>
</template>

<style scoped>

</style>