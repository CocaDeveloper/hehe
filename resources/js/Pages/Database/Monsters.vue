<script setup>
import Layout from "@/Layouts/Layout.vue";
import {nextTick, ref} from "vue";
import {Head} from "@inertiajs/vue3";
import SelectedItemOptionView from "@/Pages/Database/Partials/SelectedItemOptionView.vue";
import DatabaseItemsSkeleton from "@/Components/Skeletons/DatabaseItemsSkeleton.vue";
import {Skeleton} from "@brayamvalero/vue3-skeleton";
import TextInput from "@/Components/TextInput.vue";
import SelectedMonsterItemOptionView from "@/Pages/Database/Partials/SelectedMonsterItemOptionView.vue";

const props = defineProps({
    monsters: Object
});

const monsters = ref(props.monsters.data);
const selectedMonster = ref('');
const page = ref(props.monsters.meta.current_page);
const search = ref('');
const loading = ref(false);

const setSelectedMonster = (item) => {
    selectedMonster.value = item;
}

const nextPage = async () => {
    const scrollContainer = document.querySelector('.items-container');
    page.value++;

    try {
        const response = await axios.get(route('database.monsters'), {
            params: {
                page: page.value,
                search: search.value
            }
        });

        monsters.value = [...monsters.value, ...response.data.monsters];

        await nextTick();

        setSelectedMonster(response.data.monsters[0]);

        const firstNewItem = document.getElementById(`monster-${response.data.monsters[0].id}`);

        if (firstNewItem) {
            scrollContainer.scrollTo({ top: firstNewItem.offsetTop, behavior: 'smooth' });
        }

    } catch (error) {}
};

const searchMonsters = async () => {
    loading.value = true;
    page.value = 1;
    monsters.value = [];

    try {
        const response = await axios.get(route('database.monsters'), {
            params: {
                page: page.value,
                search: search.value
            }
        });

        monsters.value = response.data.monsters;

        if(response.data.monsters.length) {
            setSelectedMonster(response.data.monsters[0]);
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
        searchMonsters();
    }, 500);
};

setSelectedMonster(monsters.value[0]);

</script>

<template>
    <Layout>
        <Head title="Database de Monstros" />

        <div class="flex flex-col lg:p-10 mt-[40px]">
            <h1 class="font-bebas lg:text-[40px] text-[24px] uppercase lg:mb-8 mb-6 text-white leading-[25px]">Database de Monstros</h1>
            <div>
                <div class="grid lg:grid-cols-12 grid-cols-1 lg:gap-10 gap-6">
                    <div class="lg:col-span-3 h-[30vh] lg:h-[80vh] overflow-y-auto items-container scrollbar-hidden">
                        <DatabaseItemsSkeleton v-if="loading" />
                        <div v-else class="flex flex-col items-center justify-center gap-3 w-full">
                            <div
                                :class="monster.id === selectedMonster.id ? 'bg-black/[.7]' : 'bg-black/[.5]'"
                                class="w-full h-full text-center py-1.5 cursor-pointer rounded-lg bg-black/[.5] hover:bg-black/[.7]"
                                v-for="monster in monsters" :key="monster.id" :id="`monster-${monster.id}`"
                                @click="setSelectedMonster(monster)"
                            >
                                <div class="flex justify-center gap-2 items-center">
                                    <span class=" text-white font-bebas text-[24px]">
                                        {{ monster.name }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-center gap-2 items-center">
                                <span @click="nextPage" class=" text-white font-bebas cursor-pointer text-[24px]">Ver Mais Monstros</span>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-7" v-if="loading">
                        <Skeleton height="625px" borderRadius="8px" />
                    </div>
                    <div class="lg:col-span-7" v-else>
                        <div class="relative w-full mb-4">
                            <TextInput v-model="search" class="w-full pl-10 pr-4 py-2 border rounded-lg"
                                       placeholder="Pesquisar Monstro"
                                       @input="debouncedSearch"
                            />
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />
                            </svg>
                        </div>

                        <div class="w-full p-5 bg-white rounded-lg" v-if="selectedMonster">
                            <div class="flex flex-col mb-5 justify-center items-center">
                                <img :src="`/assets/images/database/monsters/${selectedMonster.id}.gif`" :alt="selectedMonster.name" />
                                <span class="font-bebas text-[25px]">{{selectedMonster.name}} ({{selectedMonster.id}})</span>
                            </div>
                            <div class="w-full border-b border-[#4d3416]/[.1]"></div>

                            <SelectedItemOptionView label="Level" :value="selectedMonster.level.toString()" />
                            <SelectedItemOptionView label="Vida" :value="selectedMonster.hp.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.sp" label="Mana" :value="selectedMonster.sp.toString()" />
                            <SelectedItemOptionView label="Experiência de Base" :value="selectedMonster.base_exp.toString()" />
                            <SelectedItemOptionView label="Experiência de Classe" :value="selectedMonster.job_exp.toString()" />
                            <SelectedItemOptionView label="Ataque" :value="selectedMonster.attack.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.defense" label="Defesa" :value="selectedMonster.defense.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.magic_defense" label="Defesa Mágica" :value="selectedMonster.magic_defense.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.size" label="Tamanho" :value="selectedMonster.size.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.race" label="Raça" :value="selectedMonster.race.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.element" label="Elemento" :value="`${selectedMonster.element} (${selectedMonster.element_level})`" />
                            <SelectedItemOptionView v-if="selectedMonster.modes.length" label="IA" :value="selectedMonster.modes.join(', ')" />
                        </div>

                        <div class="w-full mt-5 p-5 bg-white rounded-lg" v-if="selectedMonster">
                            <h1 class="font-bebas text-[25px]">Atributos</h1>
                            <SelectedItemOptionView v-if="selectedMonster.str" label="Força" :value="selectedMonster.str.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.agi" label="Agilidade" :value="selectedMonster.agi.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.dex" label="Destreza" :value="selectedMonster.dex.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.int" label="Inteligência" :value="selectedMonster.int.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.dex" label="Destreza" :value="selectedMonster.dex.toString()" />
                            <SelectedItemOptionView v-if="selectedMonster.luk" label="Sorte" :value="selectedMonster.luk.toString()" />
                        </div>

                        <div class="w-full mt-5 p-5 bg-white rounded-lg" v-if="selectedMonster">
                            <h1 class="font-bebas text-[25px]">Drops</h1>
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.mvpdrop1_item"
                                :rate="selectedMonster.mvpdrop1_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.mvpdrop2_item"
                                :rate="selectedMonster.mvpdrop2_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.mvpdrop3_item"
                                :rate="selectedMonster.mvpdrop3_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop1_item"
                                :rate="selectedMonster.drop1_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop2_item"
                                :rate="selectedMonster.drop2_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop3_item"
                                :rate="selectedMonster.drop3_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop4_item"
                                :rate="selectedMonster.drop4_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop5_item"
                                :rate="selectedMonster.drop5_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop6_item"
                                :rate="selectedMonster.drop6_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop7_item"
                                :rate="selectedMonster.drop7_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop8_item"
                                :rate="selectedMonster.drop8_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop9_item"
                                :rate="selectedMonster.drop9_rate"
                            />
                            <SelectedMonsterItemOptionView
                                :drop="selectedMonster.drop10_item"
                                :rate="selectedMonster.drop10_rate"
                            />
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </Layout>
</template>

<style scoped>

</style>