<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import Menu from "@/Components/Menu.vue";
import {ref, computed, nextTick, onMounted} from "vue";
import Footer from "@/Components/Footer.vue";
import EpicNavbar from "@/Components/EpicNavbar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ClassesSection from "@/Components/ClassesSection.vue";
import CommunitySection from "@/Components/CommunitySection.vue";

const props = defineProps({
    infos: Object,
    stores: Object
});

const storeRef = ref(null);

const formatBRL = (value) =>
    new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);

const scrollByCards = (dir) => {
    const el = storeRef.value;
    if (!el) return;
    const card = el.querySelector<HTMLElement>('[data-card]');
    const step = card ? card.offsetWidth + 24 : 320;
    el.scrollBy({ left: dir === 'right' ? step : -step, behavior: 'smooth' });
};

const go = (path, options = {}) => {
    router.visit(path, { preserveScroll: true, ...options })
}


</script>

<template>
    <Head title="Início" />
    <div class="bg-header bg-[length:100%_100%] bg-top md:min-h-[100vh] bg-no-repeat">
        <EpicNavbar />
        <!-- HERO SECTION -->
        <div class="container mx-auto">
            <div class="px-2 font-barlow md:px-0 md:pt-40 pt-10 flex flex-col md:flex-row items-center justify-between">
                <!-- LEFT CONTENT -->
                <div class="text-white max-w-lg md:order-1 order-2 mt-5 md:mt-0 md:mb-0 mb-20">

                    <h2 class="text-center md:hidden text-[40px] font-extrabold">
                        O GRANDE <span class="text-[#F9B701]">MOMENTO</span>
                    </h2>

                    <h2 class="text-3xl md:text-[48px] font-semibold md:block hidden uppercase leading-[45px]">
                        O GRANDE
                    </h2>
                    <h1 class="text-6xl md:text-[96px] font-extrabold md:block hidden text-[#F9B701] uppercase">
                        MOMENTO
                    </h1>
                    <p class="text-[24px] md:text-left text-center text-white max-w-md">
                        Sua jornada no mundo de Ragnarok começa aqui
                    </p>

                    <!-- BUTTONS -->
                    <div class="gap-4 pt-6 md:flex hidden">
                        <PrimaryButton class="w-[180px] !text-[100px]" @click="go('/download')">Jogar</PrimaryButton>
                        <SecondaryButton class="w-[180px] secondary-gradient" @click="go('/register')">Cadasre-se</SecondaryButton>
                    </div>

                    <!-- STATS -->
                    <div class=" md:flex hidden gap-12 pt-10 text-lg">
                        <div>
                            <p class="uppercase text-white text-[24px] font-semibold">Jogadores Online</p>
                            <p class="text-[#FFBD00] text-[48px] font-bold mt-3">
                                {{ new Intl.NumberFormat('pt-BR').format(infos.total_online ?? 0) }}
                            </p>
                        </div>
                        <div>
                            <p class="uppercase text-white text-[24px] font-semibold">Total de Jogadores</p>
                            <p class="text-[#FFBD00] text-[48px] font-bold mt-3">
                                {{ new Intl.NumberFormat('pt-BR').format(infos.total_accounts ?? 0) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT CONTENT (VIDEO PREVIEW) -->
                <div
                    class="mt-12 md:order-2 order-1 md:mt-0 md:ml-10 w-full md:w-[600px] h-[315px] bg-black/60 rounded-xl flex items-center justify-center border border-gray-600 relative"
                >
                    <div class="border-[1px] border-[#FFFFFF] rounded-[10px] w-full overflow-hidden"><iframe width="100%" height="315" src="https://www.youtube.com/embed/5EeRwggCU8s?si=5EeRwggCU8s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe></div>

                </div>
            </div>
        </div>
    </div>

    <div class="bg-black">
        <div class="container mx-auto pt-5">
            <h1 class="text-white font-sora md:text-[40px] text-[32px] font-extrabold leading-[45px] tracking-[3px]">APROVEITE O <span class="text-[#FFB82B]">MAXIMO DO <br> NOSSO SERVIDOR COM</span></h1>

            <div class="grid grid-cols-1 gap-9 md:grid-cols-2 text-white font-sora pt-10">
                <div class="info-gradient rounded-[12px] border border-[#FFFFFF] p-6 min-h-[300px]">
                    <img class="w-[120px]" src="/assets/images/poring-1.png" alt="Poring" />
                    <h1 class="text-[24px] font-extrabold leading-[45px] tracking-[3px] mt-6">RATES 3X/3X/2X</h1>
                    <h2 class="text-[20px] font-semibold leading-[24px] tracking-[1px]">Desfrute de taxas otimizadas que permitem uma progressão rápida e eficiente do seu personagem.</h2>
                </div>
                <div class="info-gradient rounded-[12px] border border-[#FFFFFF] p-6 min-h-[300px]">
                    <img class="w-[145px]" src="/assets/images/poring-2.png" alt="Poring" />
                    <h1 class="text-[24px] font-extrabold leading-[45px] tracking-[3px]">BÔNUS ALEATÓRIOS</h1>
                    <h2 class="text-[20px] font-semibold leading-[24px] tracking-[1px]">Cada equipamento pode surgir com bônus únicos, trazendo atributos poderosos, resistências reforçadas e danos mais elevados para sua jornada.</h2>
                </div>
                <div class="info-gradient rounded-[12px] border border-[#FFFFFF] p-6 min-h-[300px]">
                    <img class="w-[145px]" src="/assets/images/poring-3.png" alt="Poring" />
                    <h1 class="text-[24px] font-extrabold leading-[45px] tracking-[3px]">TALISMÃ DA GUILDA</h1>
                    <h2 class="text-[20px] font-semibold leading-[24px] tracking-[1px]">Buffs exclusivos para WoE! Sua guilda evolui o Talismã até +10 e desbloqueia bônus poderosos na Guerra do Emperium, como resistência, dano extra e redução de dano. No nível máximo, é possível ativar dois buffs ao mesmo tempo durante a batalha!</h2>
                </div>
                <div class="info-gradient rounded-[12px] border border-[#FFFFFF] p-6 min-h-[300px]">
                    <img class="w-[145px]" src="/assets/images/poring-4.png" alt="Poring" />
                    <h1 class="text-[24px] font-extrabold leading-[45px] tracking-[3px]">TALISMÃ DO GUERREIRO</h1>
                    <h2 class="text-[20px] font-semibold leading-[24px] tracking-[1px]">Buffs PvM para evoluir mais rápido!
                        Talismã pessoal que vai de +1 a +10 e concede bônus especiais para UP, farm e MVP, como EXP extra, dano elevado e mais drop. Ative um buff de 2 horas e evolua seu talismã para ganhar poderes ainda melhores!</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-black pb-20">
        <div class="container mx-auto pt-20">
            <div class="flex items-center gap-3 mb-6">
                <h2 class="font-sora font-extrabold tracking-[4px] text-white text-[40px]">
                    LOJA <span class="text-[#FFBD00]">EXCLUSIVA</span>
                </h2>

                <div class="ml-auto hidden md:flex items-center gap-2">
                    <button
                        @click="scrollByCards('left')"
                        class="rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 text-white px-3 py-2"
                        aria-label="Anterior"
                    >‹</button>
                    <button
                        @click="scrollByCards('right')"
                        class="rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 text-white px-3 py-2"
                        aria-label="Próximo"
                    >›</button>
                </div>
            </div>

            <div class="relative">
                <div class="pointer-events-none absolute left-0 top-0 h-full w-12 bg-gradient-to-r from-[#0B0B0B] to-transparent"></div>
                <div class="pointer-events-none absolute right-0 top-0 h-full w-12 bg-gradient-to-l from-[#0B0B0B] to-transparent"></div>

                <div
                    v-if="Object.values(stores).length"
                    ref="storeRef"
                    class="no-scrollbar px-5 flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-p-4 pr-4"
                >
                    <div
                        v-for="store in stores"
                        :key="store.id"
                        data-card
                        class="snap-start shrink-0 w-[260px] md:w-[290px] h-[430px]"
                    >
                        <div
                            class="shop-gradient rounded-2xl border border-white overflow-hidden h-full flex flex-col"
                        >
                            <div class="flex items-center justify-center">
                                <img
                                    :src="`/assets/images/database/items/images/${store.item.id}.png`"
                                    :alt="store.item.name" class="w-[120px] mt-5 h-auto mix-blend-multiply" />
                            </div>

                            <div class="p-6 flex flex-col justify-between h-full gap-2">
                                <div class=" flex flex-col justify-between h-[120px]">
                                    <div class="text-white">
                                        <p class="font-sora font-extrabold text-[24px] tracking-[2px] leading-[33px]">{{store.item.name}}</p>
                                    </div>

                                    <div>
                                        <p class="text-white font-sora font-extrabold text-[40px] tracking-[2px] leading-[45px]">
                                            {{ formatBRL(store.value).replace('R$', 'R$') }}
                                        </p>
                                    </div>
                                </div>

                                <Link :href="`/manager-account?tab=donate&store=${store.id}`">
                                    <PrimaryButton class="!h-[50px] w-full mt-5">Comprar</PrimaryButton>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="shrink-0 w-2"></div>
                </div>
                <div class="w-full flex justify-center mt-20" v-else>
                    <span class="text-white/[.7] text-center text-[30px] ml-5 font-sora">Sem itens na loja.</span>
                </div>
            </div>
        </div>
    </div>

    <ClassesSection />

    <CommunitySection />

</template>
