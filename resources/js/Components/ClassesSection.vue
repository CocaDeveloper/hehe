<script setup>
import { ref, computed } from "vue";

const classes = [
    {
        key: "swordsman",
        title: "LORDE",
        color: "#C64E37",
        desc:
            "Levando a definição de Cavaleiro a outro nível, os Lordes são guerreiros de grande vigor e força descomunal.</br>" +
            "\n" +
            "Atuam na frente de batalha sem temer os inimigos, podendo dispersa-los em pouco tempo sem dificuldades.</br>",
        videoId: "5EeRwggCU8s",
        abilities: [
            { name: "Impacto de Tyr", icon: "/assets/images/database/skills/icons/KN_BOWLINGBASH.png", gif: "/assets/images/database/skills/gifs/KN_BOWLINGBASH.gif" },
            { name: "Perfurar", icon: "/assets/images/database/skills/icons/KN_PIERCE.png", gif: "/assets/images/database/skills/gifs/KN_PIERCE.gif" },
            { name: "Estocada", icon: "/assets/images/database/skills/icons/KN_SPEARSTAB.png", gif: "/assets/images/database/skills/gifs/KN_SPEARSTAB.gif" },
            { name: "Brandir Lança", icon: "/assets/images/database/skills/icons/KN_BRANDISHSPEAR.png", gif: "/assets/images/database/skills/gifs/KN_BRANDISHSPEAR.gif" },
            { name: "Lança Bumerangue", icon: "/assets/images/database/skills/icons/KN_SPEARBOOMERANG.png", gif: "/assets/images/database/skills/gifs/KN_SPEARBOOMERANG.gif" },
        ],
        trans: ['Espadachim', 'Lorde'],
    },
    {
        key: "assassin",
        title: "ALGOZ",
        color: "#7D31CC",
        desc:
            "Mestres do veneno e da furtividade, os Algozes eliminam alvos com golpes velozes e técnicas letais.</br>" +
            "\n" +
            "Podem amplificar o dano com toxinas e surpreender multidões com ataques em área.</br>",
        videoId: "",
        abilities: [
            { name: "Encantar com Veneno Mortal", icon: "/assets/images/database/skills/icons/ASC_EDP.png", gif: "/assets/images/database/skills/gifs/ASC_EDP.gif" },
            { name: "Lâminas Destruidoras", icon: "/assets/images/database/skills/icons/AS_SONICBLOW.png", gif: "/assets/images/database/skills/gifs/AS_SONICBLOW.gif" },
            { name: "Destruidor de Almas", icon: "/assets/images/database/skills/icons/ASC_SOULBREAKER.png", gif: "/assets/images/database/skills/gifs/ASC_SOULBREAKER.gif" },
            { name: "Impacto Meteoro", icon: "/assets/images/database/skills/icons/ASC_METEORASSAULT.png", gif: "/assets/images/database/skills/gifs/ASC_METEORASSAULT.gif" },
            { name: "Furtividade", icon: "/assets/images/database/skills/icons/AS_CLOAKING.png", gif: "/assets/images/database/skills/gifs/AS_CLOAKING.gif" },
        ],
        trans: ["Gatuno", "Algoz"],
    },
    {
        key: "wizard",
        title: "ARQUIMAGO",
        color: "#1E90FF",
        desc:
            "Arquimagos dominam magias de grande escala, controlando clima e elementos para obliterar grupos inteiros.</br>" +
            "\n" +
            "Amplificam o próprio poder e drenam a energia dos inimigos para manter a ofensiva.</br>",
        videoId: "",
        abilities: [
            { name: "Amplificação Mística", icon: "/assets/images/database/skills/icons/HW_MAGICPOWER.png", gif: "/assets/images/database/skills/gifs/HW_MAGICPOWER.gif" },
            { name: "Trovão de Júpiter", icon: "/assets/images/database/skills/icons/WZ_JUPITEL.png", gif: "/assets/images/database/skills/gifs/WZ_JUPITEL.gif" },
            { name: "Nevasca", icon: "/assets/images/database/skills/icons/WZ_STORMGUST.png", gif: "/assets/images/database/skills/gifs/WZ_STORMGUST.gif" },
            { name: "Chuva de Meteoros", icon: "/assets/images/database/skills/icons/WZ_METEORSTORM.png", gif: "/assets/images/database/skills/gifs/WZ_METEORSTORM.gif" },
            { name: "Ira de Thor", icon: "/assets/images/database/skills/icons/WZ_VERMILION.png", gif: "/assets/images/database/skills/gifs/WZ_VERMILION.gif" },
        ],
        trans: ["Mago", "Arquimago"],
    },
    {
        key: "merchant",
        title: "MESTRE-FERREIRO",
        color: "#D97706",
        desc:
            "Especialistas em engenharia de combate, Mestres-Ferreiros combinam forja e brutalidade — e o carrinho — como armas.</br>" +
            "\n" +
            "Têm acesso a poderosas técnicas de reforço de armamentos e ataques devastadores.</br>",
        videoId: "",
        abilities: [
            { name: "Choque do Carrinho", icon: "/assets/images/database/skills/icons/WS_CARTTERMINATION.png", gif: "/assets/images/database/skills/gifs/WS_CARTTERMINATION.gif" },
            { name: "Amplificar Poder", icon: "/assets/images/database/skills/icons/WS_MAXIMIZEPOWER.png", gif: "/assets/images/database/skills/gifs/WS_MAXIMIZEPOWER.gif" },
            { name: "Manejo Perfeito", icon: "/assets/images/database/skills/icons/BS_WEAPONPERFECTION.png", gif: "/assets/images/database/skills/gifs/BS_WEAPONPERFECTION.gif" },
            { name: "Aprimorar Armamento", icon: "/assets/images/database/skills/icons/BS_OVERTHRUST.png", gif: "/assets/images/database/skills/gifs/BS_OVERTHRUST.gif" },
            { name: "Adrenalina Pura", icon: "/assets/images/database/skills/icons/BS_ADRENALINERUSH.png", gif: "/assets/images/database/skills/gifs/BS_ADRENALINERUSH.gif" },
        ],
        trans: ["Mercador", "Mestre-Ferreiro"],
    },
    {
        key: "acolyte",
        title: "SUMO SACERDOTE",
        color: "#71B344",
        desc:
            "Refúgio dos aliados em campo, Sumo Sacerdotes fortalecem, protegem e exorcizam com poder sagrado.</br>" +
            "\n" +
            "Elevam a sobrevivência do grupo e ainda dispõem de milagres ofensivos contra o mal.</br>",
        videoId: "",
        abilities: [
            { name: "Assumptio", icon: "/assets/images/database/skills/icons/HP_ASSUMPTIO.png", gif: "/assets/images/database/skills/gifs/HP_ASSUMPTIO.gif" },
            { name: "Santuário", icon: "/assets/images/database/skills/icons/PR_SANCTUARY.png", gif: "/assets/images/database/skills/gifs/PR_SANCTUARY.gif" },
            { name: "Kyrie Eleison", icon: "/assets/images/database/skills/icons/PR_KYRIE.png", gif: "/assets/images/database/skills/gifs/PR_KYRIE.gif" },
            { name: "Magnus Exorcismus", icon: "/assets/images/database/skills/icons/PR_MAGNUS.png", gif: "/assets/images/database/skills/gifs/PR_MAGNUS.gif" },
            { name: "Lex Divina", icon: "/assets/images/database/skills/icons/PR_LEXDIVINA.png", gif: "/assets/images/database/skills/gifs/PR_LEXDIVINA.gif" },
        ],
        trans: ["Noviço", "Sumo Sacerdote"],
    },
    {
        key: "archer",
        title: "ATIRADOR DE ELITE",
        color: "#BA9E36",
        desc:
            "Maestria absoluta no arco: abatem inimigos à distância com precisão e apoio do falcão treinado.</br>" +
            "\n" +
            "Podem controlar o campo com armadilhas e ganhar mobilidade com técnicas do vento.</br>",
        videoId: "",
        abilities: [
            { name: "Tiro Preciso", icon: "/assets/images/database/skills/icons/SN_SHARPSHOOTING.png", gif: "/assets/images/database/skills/gifs/SN_SHARPSHOOTING.gif" },
            { name: "Assalto do Falcão", icon: "/assets/images/database/skills/icons/SN_FALCONASSAULT.png", gif: "/assets/images/database/skills/gifs/SN_FALCONASSAULT.gif" },
            { name: "Visão Real", icon: "/assets/images/database/skills/icons/SN_SIGHT.png", gif: "/assets/images/database/skills/gifs/SN_SIGHT.gif" },
            { name: "Caminho do Vento", icon: "/assets/images/database/skills/icons/SN_WINDWALK.png", gif: "/assets/images/database/skills/gifs/SN_WINDWALK.gif" },
            { name: "Armadilha Congelante", icon: "/assets/images/database/skills/icons/HT_FREEZINGTRAP.png", gif: "/assets/images/database/skills/gifs/HT_FREEZINGTRAP.gif" },
        ],
        trans: ["Arqueiro", "Atirador de Elite"],
    },
    {
        key: "paladin",
        title: "PALADINO",
        color: "#CF5C2F",
        desc:
            "Defensores sagrados que protegem aliados com o corpo e atacam usando o poder do escudo e da fé.</br>" +
            "\n" +
            "Podem entoar cânticos de batalha e sacrificar-se para guardar o grupo.</br>",
        videoId: "",
        abilities: [
            { name: "Canto de Batalha", icon: "/assets/images/database/skills/icons/PA_GOSPEL.png", gif: "/assets/images/database/skills/gifs/PA_GOSPEL.gif" },
            { name: "Redenção", icon: "/assets/images/database/skills/icons/CR_DEVOTION.png", gif: "/assets/images/database/skills/gifs/CR_DEVOTION.gif" },
            { name: "Punição Divina", icon: "/assets/images/database/skills/icons/PA_SHIELDCHAIN.png", gif: "/assets/images/database/skills/gifs/PA_SHIELDCHAIN.gif" },
            { name: "Escudo Bumerangue", icon: "/assets/images/database/skills/icons/CR_SHIELDBOOMERANG.png", gif: "/assets/images/database/skills/gifs/CR_SHIELDBOOMERANG.gif" },
            { name: "Sacrifício do Mártir", icon: "/assets/images/database/skills/icons/PA_SACRIFICE.png", gif: "/assets/images/database/skills/gifs/PA_SACRIFICE.gif" },
        ],
        trans: ["Espadachim", "Paladino"],
    },
    {
        key: "rogue",
        title: "DESORDEIRO",
        color: "#8044C2",
        desc:
            "Ladinos livres por natureza: copiam magias, caminham nas sombras e desarmam completamente seus alvos.</br>" +
            "\n" +
            "Excelentes em PvP por controle e utilidade.</br>",
        videoId: "",
        abilities: [
            { name: "Plágio", icon: "/assets/images/database/skills/icons/RG_PLAGIARISM.png", gif: "/assets/images/database/skills/gifs/RG_PLAGIARISM.gif" },
            { name: "Preservar", icon: "/assets/images/database/skills/icons/ST_PRESERVE.png", gif: "/assets/images/database/skills/gifs/ST_PRESERVE.gif" },
            { name: "Afanar", icon: "/assets/images/database/skills/icons/RG_STEALCOIN.png", gif: "/assets/images/database/skills/gifs/RG_STEALCOIN.gif" },
            { name: "Remoção Total", icon: "/assets/images/database/skills/icons/ST_FULLSTRIP.png", gif: "/assets/images/database/skills/gifs/ST_FULLSTRIP.gif" },
            { name: "Confinamento", icon: "/assets/images/database/skills/icons/RG_CLOSECONFINE.png", gif: "/assets/images/database/skills/gifs/RG_CLOSECONFINE.gif" },
        ],
        trans: ["Gatuno", "Desordeiro"],
    },
    {
        key: "sage",
        title: "PROFESSOR",
        color: "#4F40ED",
        desc:
            "Acadêmicos que manipulam o terreno, interrompem conjurações e drenam a alma do inimigo.</br>" +
            "\n" +
            "Unem controle, suporte e truques únicos para ditar o ritmo da luta.</br>",
        videoId: "",
        abilities: [
            { name: "Proteger Terreno", icon: "/assets/images/database/skills/icons/SA_LANDPROTECTOR.png", gif: "/assets/images/database/skills/gifs/SA_LANDPROTECTOR.gif" },
            { name: "Desencantar", icon: "/assets/images/database/skills/icons/SA_DISPELL.png", gif: "/assets/images/database/skills/gifs/SA_DISPELL.gif" },
            { name: "Bruma Ofuscante", icon: "/assets/images/database/skills/icons/PF_FOGWALL.png", gif: "/assets/images/database/skills/gifs/PF_FOGWALL.gif" },
            { name: "Prisão de Teia", icon: "/assets/images/database/skills/icons/PF_SPIDERWEB.png", gif: "/assets/images/database/skills/gifs/PF_SPIDERWEB.gif" },
            { name: "Lanças Duplas", icon: "/assets/images/database/skills/icons/PF_DOUBLECASTING.png", gif: "/assets/images/database/skills/gifs/PF_DOUBLECASTING.gif" },
        ],
        trans: ["Mago", "Professor"],
    },
    {
        key: "alchemist",
        title: "CRIADOR",
        color: "#BF9333",
        desc:
            "Químicos de guerra: dominam homúnculos, plantas e explosivos para controlar o campo e derreter defesas.</br>" +
            "\n" +
            "Protegem equipamentos e arremessam poções/armas químicas devastadoras.</br>",
        videoId: "",
        abilities: [
            { name: "Bomba Ácida", icon: "/assets/images/database/skills/icons/CR_ACIDDEMONSTRATION.png", gif: "/assets/images/database/skills/gifs/CR_ACIDDEMONSTRATION.gif" },
            { name: "Fogo Grego", icon: "/assets/images/database/skills/icons/AM_DEMONSTRATION.png", gif: "/assets/images/database/skills/gifs/AM_DEMONSTRATION.gif" },
            { name: "Proteção Química Total", icon: "/assets/images/database/skills/icons/CR_FULLPROTECTION.png", gif: "/assets/images/database/skills/gifs/CR_FULLPROTECTION.gif" },
            { name: "Criar Monstro Planta", icon: "/assets/images/database/skills/icons/AM_CANNIBALIZE.png", gif: "/assets/images/database/skills/gifs/AM_CANNIBALIZE.gif" },
            { name: "Arremessar Poção", icon: "/assets/images/database/skills/icons/AM_POTIONPITCHER.png", gif: "/assets/images/database/skills/gifs/AM_POTIONPITCHER.gif" },
            { name: "Despertar Homunculus", icon: "/assets/images/database/skills/icons/AM_CALLHOMUN.png", gif: "/assets/images/database/skills/gifs/AM_CALLHOMUN.gif" },
        ],
        trans: ["Mercador", "Criador"],
    },
    {
        key: "monk",
        title: "MESTRE",
        color: "#B930AA",
        desc:
            "Artistas marciais do Ki: acumulam esferas espirituais e desferem o lendário Punho Supremo de Asura.</br>" +
            "\n" +
            "Alternam entre invulnerabilidade, mobilidade e combos de alto dano.</br>",
        videoId: "",
        abilities: [
            { name: "Punho Supremo de Asura", icon: "/assets/images/database/skills/icons/MO_EXTREMITYFIST.png", gif: "/assets/images/database/skills/gifs/MO_EXTREMITYFIST.gif" },
            { name: "Corpo Fechado", icon: "/assets/images/database/skills/icons/MO_STEELBODY.png", gif: "/assets/images/database/skills/gifs/MO_STEELBODY.gif" },
            { name: "Zen", icon: "/assets/images/database/skills/icons/CH_SOULCOLLECT.png", gif: "/assets/images/database/skills/gifs/CH_SOULCOLLECT.gif" },
            { name: "Fúria Interior", icon: "/assets/images/database/skills/icons/MO_EXPLOSIONSPIRITS.png", gif: "/assets/images/database/skills/gifs/MO_EXPLOSIONSPIRITS.gif" },
            { name: "Disparo de Esferas Espirituais", icon: "/assets/images/database/skills/icons/MO_FINGEROFFENSIVE.png", gif: "/assets/images/database/skills/gifs/MO_FINGEROFFENSIVE.gif" },
        ],
        trans: ["Noviço", "Mestre"],
    },
    {
        key: "bard",
        title: "MENESTREL",
        color: "#C1AA68",
        desc:
            "Suporte musical por excelência: canções que aceleram conjurações, fortalecem aliados e controlam o campo.</br>" +
            "\n" +
            "Podem atuar solo com arco ou em duetos/ensembles poderosos.</br>",
        videoId: "",
        abilities: [
            { name: "Destino nas Cartas", icon: "/assets/images/database/skills/icons/CG_TAROTCARD.png", gif: "/assets/images/database/skills/gifs/CG_TAROTCARD.gif" },
            { name: "Poema de Bragi", icon: "/assets/images/database/skills/icons/BA_POEMBRAGI.png", gif: "/assets/images/database/skills/gifs/BA_POEMBRAGI.gif" },
            { name: "Maçãs de Idun", icon: "/assets/images/database/skills/icons/BA_APPLEIDUN.png", gif: "/assets/images/database/skills/gifs/BA_APPLEIDUN.gif" },
            { name: "Dissonância", icon: "/assets/images/database/skills/icons/BA_DISSONANCE.png", gif: "/assets/images/database/skills/gifs/BA_DISSONANCE.gif" },
            { name: "Lamento de Loki", icon: "/assets/images/database/skills/icons/BD_ROKISWEIL.png", gif: "/assets/images/database/skills/gifs/BD_ROKISWEIL.gif" },
            { name: "Piada Infame", icon: "/assets/images/database/skills/icons/BA_FROSTJOKE.png", gif: "/assets/images/database/skills/gifs/BA_FROSTJOKE.gif" },
        ],
        trans: ["Arqueiro", "Menestrel"],
    },
    {
        key: "dancer",
        title: "CIGANA",
        color: "#D99151",
        desc:
            "Dançarinas inspiradoras: seus ritmos elevam o grupo, impõem debuffs e até silenciam o campo.</br>" +
            "\n" +
            "Em duetos, ampliam ainda mais o impacto de suas performances.</br>",
        videoId: "",
        abilities: [
            { name: "Destino nas Cartas", icon: "/assets/images/database/skills/icons/CG_TAROTCARD.png", gif: "/assets/images/database/skills/gifs/CG_TAROTCARD.gif" },
            { name: "Banquete de Njord", icon: "/assets/images/database/skills/icons/BD_RICHMANKIM.png", gif: "/assets/images/database/skills/gifs/BD_RICHMANKIM.gif" },
            { name: "Não me Abandones", icon: "/assets/images/database/skills/icons/DC_DONTFORGETME.png", gif: "/assets/images/database/skills/gifs/DC_DONTFORGETME.gif" },
            { name: "Cantiga de Ninar", icon: "/assets/images/database/skills/icons/BD_LULLABY.png", gif: "/assets/images/database/skills/gifs/BD_LULLABY.gif" },
            { name: "Sibilo", icon: "/assets/images/database/skills/icons/DC_HUMMING.png", gif: "/assets/images/database/skills/gifs/DC_HUMMING.gif" },
            { name: "Beijo da Sorte", icon: "/assets/images/database/skills/icons/DC_FORTUNEKISS.png", gif: "/assets/images/database/skills/gifs/DC_FORTUNEKISS.gif" },
        ],
        trans: ["Arqueiro", "Cigana"],
    },
];

const active = ref(0);
const current = computed(() => classes[active.value]);

function select(i) { active.value = i; }

const toastVisible = ref(false);
const toastData = ref({ name: "", gif: "" });
const toastPos = ref({ x: 0, y: 0 });

function resolveGif(ab) {
    if (ab.gif) return ab.gif;
    return ab.icon.replace("/icons/", "/gifs/").replace(".png", ".gif");
}

function showSkillToast(ab, e) {
    toastData.value = { name: ab.name, gif: resolveGif(ab) };
    positionToast(e);
    toastVisible.value = true;
}

function moveSkillToast(e) {
    if (!toastVisible.value) return;
    positionToast(e);
}

function hideSkillToast() {
    toastVisible.value = false;
}

function positionToast(e) {
    const padding = 12;
    const offset = 16;
    const estWidth = 280;
    const estHeight = 180;

    let x = e.clientX + offset;
    let y = e.clientY + offset;

    const vw = window.innerWidth;
    const vh = window.innerHeight;

    if (x + estWidth + padding > vw) x = e.clientX - estWidth - offset;
    if (y + estHeight + padding > vh) y = e.clientY - estHeight - offset;
    if (x < padding) x = padding;
    if (y < padding) y = padding;

    toastPos.value = { x, y };
}


</script>

<template>
    <!-- CARD GERAL (fundo oliva escuro + borda dourada, como na imagem) -->
    <section class="bg-black py-8 md:py-16">
        <div class="container mx-auto">
            <div class="flex justify-end">
                <div class="w-[500px]">
                    <h2 class="font-sora text-end font-extrabold tracking-[2px] leading-[45px] text-white text-[28px] md:text-[40px] mb-6">
                        CONHEÇA <span class="text-[#FFB82B]">NOSSAS CLASSES</span>
                    </h2>
                </div>
            </div>

            <div
                class="rounded-[14px] overflow-hidden bg-[#FFBD0021] border border-[#CC9F5F]"
            >
                <!-- Moldura dourada fina -->
                <div class="relative rounded-[14px] p-6 md:p-10">
                    <div class="flex flex-col md:flex-row gap-8 items-stretch">
                        <!-- ESQUERDA: Título + texto + habilidades -->
                        <div class="flex-1">
                            <transition name="fadeSlide" mode="out-in">
                                <div :key="current.key">
                                    <p class="text-white font-extrabold uppercase font-barlow text-[28px] md:text-[36px] tracking-wide">
                                        {{ current.title }}
                                    </p>

                                    <p class="font-barlow text-[32px] leading-[35px] text-white max-w-2xl mt-4" v-html="current.desc"></p>

                                    <div class="mt-8">
                                        <p class="text-[#FFBD00] font-extrabold tracking-wide uppercase">Principais Habilidades</p>
                                        <div class="flex gap-4 mt-3">
                                            <div
                                                v-for="(ab,i) in current.abilities"
                                                :key="i"
                                                class="w-[50px] cursor-pointer h-[50px] bg-black/30 border border-white/15 grid place-items-center overflow-hidden"
                                                @mouseenter="(e) => showSkillToast(ab, e)"
                                                @mousemove="moveSkillToast"
                                                @mouseleave="hideSkillToast"
                                            >
                                                <img :src="ab.icon" :alt="ab.name" class="w-12 h-12 object-contain" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <!-- DIREITA: player com borda branca (igual ao mock) -->
                        <div class="w-full md:w-[600px]">
                            <transition name="fadeZoom" mode="out-in">
                                <div :key="`video-${current.key}`" class="relative">
                                    <div class="border border-white rounded-[10px] overflow-hidden">
                                        <iframe
                                            width="100%"
                                            height="315"
                                            :src="`https://www.youtube.com/embed/${current.videoId}?rel=0`"
                                            title="Preview da Classe"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen
                                        />
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- BARRA DE TRANSCLASSES -->
                    <div class="mt-8 md:mt-10">
                        <div class="flex gap-2 flex-wrap">
              <span
                  v-for="(t, i) in current.trans"
                  :key="i"
                  class="px-3 py-1 rounded-full text-sm border border-white/15 bg-white/5 text-white/90"
              >
                {{ t }}
              </span>
                        </div>
                    </div>

                    <div class="mt-10 md:mt-12">
                        <div class="relative w-full h-[64px] md:h-[72px]">
                            <!-- Linha base -->
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-[10px] md:h-[12px] rounded-full"
                                 style="background: linear-gradient(90deg,#E6536E 0%,#7D31CC 20%,#4CB0FF 40%,#3B82F6 60%,#7AA5FF 80%,#FFB020 100%); opacity:.9;">
                            </div>

                            <!-- Orbes -->
                            <div class="relative z-[1] flex justify-between">
                                <button
                                    v-for="(c, i) in classes"
                                    :key="c.key"
                                    @click="select(i)"
                                    class="h-[64px] md:h-[72px] grid place-items-center"
                                >
                                    <div
                                        class="transition-all duration-300"
                                        :class="i===active ? 'scale-110' : 'scale-100'"
                                    >
                                        <div
                                            v-if="i===active"
                                            class="w-[74px] h-[74px] md:w-[86px] md:h-[86px] rounded-full grid place-items-center shadow-lg"
                                            :style="{ background: '#111', boxShadow: `0 10px 20px ${c.color}33` }"
                                        >
                                            <div
                                                class="w-[62px] h-[62px] md:w-[72px] md:h-[72px] rounded-full grid place-items-center"
                                                :style="{ background: c.color }"
                                            >
                                                <img :src="`/assets/images/jobs_home/${c.key}.png`" :alt="c.title" class="object-contain" />
                                            </div>
                                        </div>
                                        <div
                                            v-else
                                            class="w-[56px] h-[56px] md:w-[64px] md:h-[64px] rounded-full grid place-items-center border"
                                            :style="{ background: '#0b0b0b', borderColor: '#ffffff22', boxShadow: `inset 0 0 0 3px ${c.color}66` }"
                                        >
                                            <img :src="`/assets/images/jobs_home/${c.key}.png`" :alt="c.title" class="object-contain grayscale hover:grayscale-0 transition" />
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <transition name="toastFade">
                        <div
                            v-if="toastVisible"
                            class="fixed z-[60] pointer-events-none"
                            :style="{ left: toastPos.x + 'px', top: toastPos.y + 'px' }"
                        >
                            <div class="w-[280px] max-w-[80vw] rounded-xl shadow-2xl border border-[#CC9F5F] bg-[#0b0b0b]/95 backdrop-blur-md overflow-hidden">
                                <!-- Header -->
                                <div class="px-3 py-2 border-b border-white/10 flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full" style="background:#FFBD00"></span>
                                    <p class="text-sm font-semibold text-white tracking-wide">{{ toastData.name }}</p>
                                </div>
                                <!-- GIF -->
                                <div class="p-2">
                                    <div class="w-full aspect-video bg-black/40 grid place-items-center overflow-hidden rounded-md">
                                        <!-- fallback de carregamento -->
                                        <img
                                            :src="toastData.gif"
                                            :alt="toastData.name"
                                            class="w-full h-full object-cover"
                                            @error="$event.target.style.display='none'"
                                        />
                                        <!-- Se o GIF não carregar, mostramos apenas um placeholder discreto -->
                                        <div class="text-xs text-white/60" v-if="false">Prévia indisponível</div>
                                    </div>
                                </div>
                                <!-- Rodapé opcional -->
                                <div class="px-3 py-2 border-t border-white/10">
                                    <p class="text-[11px] text-white/60">Passe o mouse pelos ícones para ver a prévia.</p>
                                </div>
                            </div>
                        </div>
                    </transition>
                    <!-- /TOAST -->

                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.fadeSlide-enter-active,.fadeSlide-leave-active { transition: opacity .25s ease, transform .25s ease; }
.fadeSlide-enter-from,.fadeSlide-leave-to { opacity:0; transform: translateY(6px); }
.fadeZoom-enter-active,.fadeZoom-leave-active { transition: opacity .25s ease, transform .25s ease; }
.fadeZoom-enter-from,.fadeZoom-leave-to { opacity:0; transform: scale(.985); }
</style>
