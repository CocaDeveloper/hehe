<script setup>
import {ref, computed} from "vue";
import {usePage, Link} from "@inertiajs/vue3";
import { ChevronUpIcon } from "@heroicons/vue/24/solid";
import { ChevronDownIcon } from "@heroicons/vue/24/solid";

const page = usePage();
const user = computed(() => page.props.auth.user);

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const menuItems = ref([
    {label: "Início", url: "/", type: "internal", active: true},
    {label: "Informações", url: "https://ragnafrost.wiki/index.php/Informa%C3%A7%C3%B5es_Geral", type: "external"},
    {label: "Download", url: "/download", type: "internal"},
    {label: "Doar", url: "/manager-account?tab=donate", type: "internal"},
    {
        label: "Database",
        type: "dropdown",
        active: false,
        children: [
            { label: "Items", url: "/database/items", type: "internal" },
            { label: "Monstros", url: "/database/monsters", type: "internal" },
        ],
    },
    {label: "Ranking", url: "/rankings", type: "internal"},
    {label: "Wiki", url: "https://ragnafrost.wiki", type: "external"},
]);


const activeDropdown = ref(null);
let closeTimeout = null;

const openDropdown = (index) => {
    clearTimeout(closeTimeout);
    activeDropdown.value = index;
};

const closeDropdown = () => {
    closeTimeout = setTimeout(() => {
        activeDropdown.value = null;
    }, 200);
};

const activeDropdownMobile = ref(null);

const toggleDropdownMobile = (index) => {
    activeDropdownMobile.value = activeDropdownMobile.value === index ? null : index;
};

</script>

<template>
    <header class="relative bg-black w-full mx-auto">
        <div class="flex gap-10 md:justify-between items-center container mx-auto py-2">
            <div class="flex gap-10">
                <div class="flex gap-3">
                    <button @click="toggleMenu" class="lg:hidden">
                <span
                    class="block w-6 h-0.5 bg-white mb-1 transition-transform"
                    :class="isMenuOpen ? 'rotate-45 translate-y-1' : ''"
                ></span>
                        <span
                            class="block w-6 h-0.5 bg-white mb-1"
                            :class="isMenuOpen ? 'opacity-0' : ''"
                        ></span>
                        <span
                            class="block w-6 h-0.5 bg-white transition-transform"
                            :class="isMenuOpen ? '-rotate-45 -translate-y-1' : ''"
                        ></span>
                    </button>

                    <!-- Logo -->
                    <Link href="/">
                        <img class="lg:max-h-[90px] max-h-[50px]" src="/assets/images/logo-menu.png" alt="Logo"/>
                    </Link>
                </div>

                <!-- Menu Links (Desktop) -->
                <nav class="hidden lg:flex gap-10 justify-center items-center">
                    <template v-for="(item, index) in menuItems" :key="index">
                        <div
                            v-if="item.type === 'dropdown'"
                            class="relative"
                            @mouseenter="openDropdown(index)"
                            @mouseleave="closeDropdown"
                        >
                        <span
                            :class="['menu-text-item cursor-pointer', item.active ? 'active' : 'opacity-50']"
                        >
                            {{ item.label }}
                        </span>
                            <div
                                v-if="activeDropdown === index"
                                class="absolute top-full left-0 mt-2 bg-white shadow-md z-50"
                            >
                                <template v-for="(child, childIndex) in item.children" :key="childIndex">
                                    <Link
                                        v-if="child.type === 'internal'"
                                        :href="child.url"
                                        class="block bg-[#FFA500] hover:bg-[#E59400] text-white uppercase font-bold leading-[21.79px] tracking-[0.1em] px-4 py-2"
                                    >
                                        {{ child.label }}
                                    </Link>
                                    <a
                                        v-else
                                        :href="child.url"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="block px-4 py-2 bg-[#FFA500] hover:bg-[#E59400] text-white uppercase font-bold leading-[21.79px] tracking-[0.1em]"
                                    >
                                        {{ child.label }}
                                    </a>
                                </template>
                            </div>
                        </div>
                        <Link v-else-if="item.type === 'internal'" :href="item.url">
                            <span :class="['menu-text-item', item.active ? 'active' : 'opacity-50']">{{ item.label }}</span>
                        </Link>
                        <a v-else :href="item.url" target="_blank" rel="noopener noreferrer">
                            <span :class="['menu-text-item', item.active ? 'active' : 'opacity-50']">{{ item.label }}</span>
                        </a>
                    </template>
                </nav>
            </div>

            <!-- User/Actions -->
            <div>
                <div class="flex gap-3" v-if="user">
                    <Link href="/manager-account" class="bg-[#FFA500] md:rounded-[33px] !rounded-lg hover:bg-[#E59400] button-menu">
                        <img src="/assets/images/login-icon.png" alt="Login Icon"/>
                        <span>{{ user.login }}</span>
                    </Link>
                </div>
                <div v-else class="flex gap-3">
                    <Link href="/login" class="bg-[#FFA500] md:rounded-[33px] !rounded-lg hover:bg-[#E59400] button-menu">
                        <img src="/assets/images/login-icon.png" alt="Login Icon"/>
                        <span>Entrar</span>
                    </Link>
                    <Link href="/register" class="bg-[#374151]  md:rounded-[33px] !rounded-lg hover:bg-[#646D7B] button-menu">
                        <span>Cadastre-se</span>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Menu Links (Mobile) -->
        <nav
            :class="{
                    hidden: !isMenuOpen,
                    'absolute top-full left-0 w-auto p-3 bg-black lg:hidden': true,
                  }"
            class="z-50"
        >
            <template v-for="(item, index) in menuItems" :key="index">
                <div v-if="item.type === 'dropdown'">
                    <button @click="toggleDropdownMobile(index)" class="w-full text-left py-2 px-4 flex items-center">
                        <span :class="['menu-text-item', item.active ? 'active' : 'opacity-50']">{{ item.label }}</span>
                        <span v-if="activeDropdownMobile === index"><ChevronUpIcon class="w-5 ml-1 text-white opacity-50 font-bold" /></span>
                        <span v-else><ChevronDownIcon class="w-5 ml-1 text-white opacity-50 font-bold" /></span>
                    </button>
                    <div v-if="activeDropdownMobile === index" class="pl-6">
                        <template v-for="(child, childIndex) in item.children" :key="childIndex">
                            <Link v-if="child.type === 'internal'" :href="child.url" class="block py-2 px-4">
                                <span class="menu-text-item">{{ child.label }}</span>
                            </Link>
                            <a v-else :href="child.url" target="_blank" rel="noopener noreferrer" class="block py-2 px-4">
                                <span class="menu-text-item">{{ child.label }}</span>
                            </a>
                        </template>
                    </div>
                </div>
                <Link v-else-if="item.type === 'internal'" :href="item.url" class="block py-2 px-4">
                    <span :class="['menu-text-item', item.active ? 'active' : 'opacity-50']">{{ item.label }}</span>
                </Link>
                <a v-else :href="item.url" target="_blank" rel="noopener noreferrer" class="block py-2 px-4">
                    <span :class="['menu-text-item', item.active ? 'active' : 'opacity-50']">{{ item.label }}</span>
                </a>
            </template>
        </nav>
    </header>
</template>

<style scoped>
</style>