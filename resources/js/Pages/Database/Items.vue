<script setup>
import Layout from "@/Layouts/Layout.vue";
import {Head} from "@inertiajs/vue3";
import {nextTick, ref} from "vue";
import SelectedItemOptionView from "@/Pages/Database/Partials/SelectedItemOptionView.vue";
import TextInput from "@/Components/TextInput.vue";

import DatabaseItemsSkeleton from "@/Components/Skeletons/DatabaseItemsSkeleton.vue";
import {Skeleton} from "@brayamvalero/vue3-skeleton";

const props = defineProps({
    items: Object
});

const items = ref(props.items.data);
const selectedItem = ref('');
const page = ref(props.items.meta.current_page);
const search = ref('');
const loading = ref(false);

const setSelectedItem = (item) => {
    selectedItem.value = item;
}

const nextPage = async () => {
    const scrollContainer = document.querySelector('.items-container');
    page.value++;

    try {
        const response = await axios.get(route('database.items'), {
            params: {
                page: page.value,
                search: search.value
            }
        });

        items.value = [...items.value, ...response.data.items];

        await nextTick();

        setSelectedItem(response.data.items[0]);

        const firstNewItem = document.getElementById(`item-${response.data.items[0].id}`);

        if (firstNewItem) {
            scrollContainer.scrollTo({ top: firstNewItem.offsetTop, behavior: 'smooth' });
        }

    } catch (error) {}
};

const searchItems = async () => {
    loading.value = true;
    page.value = 1;
    items.value = [];

    try {
        const response = await axios.get(route('database.items'), {
            params: {
                page: page.value,
                search: search.value
            }
        });

        items.value = response.data.items;

        if(response.data.items.length) {
            setSelectedItem(response.data.items[0]);
        }

    } catch (e) {

    } finally {
        loading.value = false;
    }
};

let timeout;
const debouncedSearch = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        searchItems();
    }, 500);
};

setSelectedItem(items.value[0]);

</script>

<template>
    <Layout>
        <Head title="Database de Items" />

        <div class="flex flex-col lg:p-10 mt-[40px]">
            <h1 class="font-bebas lg:text-[40px] text-[24px] uppercase lg:mb-8 mb-5 text-white leading-[25px]">Database de Itens</h1>
            <div>
                <div class="grid lg:grid-cols-12 grid-cols-1 lg:gap-10 gap-6">
                    <div class="lg:col-span-3 h-[30vh] lg:h-[80vh] overflow-y-auto items-container scrollbar-hidden">
                        <DatabaseItemsSkeleton v-if="loading" />
                        <div v-else class="flex flex-col items-center justify-center gap-3 w-full">
                            <div
                                :class="item.id === selectedItem.id ? 'bg-black/[.7]' : 'bg-black/[.5]'"
                                class="w-full h-full text-center py-1.5 cursor-pointer rounded-lg bg-black/[.5] hover:bg-black/[.7]"
                                 v-for="item in items" :key="item.id" :id="`item-${item.id}`"
                                 @click="setSelectedItem(item)"
                            >
                                <div class="flex justify-center gap-2 items-center">
                                    <img class="h-[24px]" :src="`/assets/images/database/items/icons/${item.id}.png`" :alt="item.name" />
                                    <span class=" text-white font-bebas text-[24px]">
                                        {{ item.name }} <span v-if="item.slots > 0">[{{ item.slots }}]</span>
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-center gap-2 items-center">
                                <span @click="nextPage" class=" text-white font-bebas cursor-pointer text-[24px]">Ver Mais Itens</span>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-7" v-if="loading">
                        <Skeleton height="625px" borderRadius="8px" />
                    </div>
                    <div class="lg:col-span-7" v-else>
                        <div class="relative w-full mb-4">
                            <TextInput v-model="search" class="w-full pl-10 pr-4 py-2 border rounded-lg"
                                       placeholder="Pesquisar item"
                                       @input="debouncedSearch"
                            />
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />
                            </svg>
                        </div>

                        <div class="w-full h-[560px] overflow-y-auto p-5 bg-white rounded-lg" v-if="selectedItem">
                            <div class="flex flex-col mb-5 justify-center items-center">
                                <img :src="`/assets/images/database/items/images/${selectedItem.id}.png`" :alt="selectedItem.name" />
                                <span class="font-bebas text-[25px]">{{selectedItem.name}} ({{selectedItem.id}})</span>
                            </div>
                            <div class="w-full border-b border-[#4d3416]/[.1]"></div>

                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma'" label="Tipo" :value="selectedItem.subtype" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma'" label="Slots" :value="selectedItem.slots ?? 0" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma'" label="Ataque" :value="selectedItem.attack ?? 0" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma'" label="Defesa" :value="selectedItem.defense ?? 0" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma'" label="Refinável" :value="selectedItem.refinable ? 'Sim' : 'Não'" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma'" label="Nível da Arma" :value="selectedItem.weapon_level ?? 0" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Equipamento'" label="Nível do Equipamento" :value="selectedItem.armor_level ?? 0" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma' || selectedItem.type === 'Equipamento' " label="Equipa em" :value="selectedItem.locations.join(', ')" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma' || selectedItem.type === 'Equipamento' " label="Classes" :value="selectedItem.jobs.length ? selectedItem.jobs.join(', ') : 'Todas as Classes'" />
                            <SelectedItemOptionView v-if="selectedItem.type === 'Arma' || selectedItem.type === 'Equipamento' " label="Level Mínimo" :value="selectedItem.equip_level ?? 0" />
                            <SelectedItemOptionView label="Peso" :value="selectedItem.weight.toString()" />
                            <SelectedItemOptionView label="Preço de Compra" :value="selectedItem.price_buy +'z'" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </Layout>
</template>

<style scoped>

</style>