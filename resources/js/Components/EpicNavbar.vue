<script setup>
import {computed, nextTick, ref} from "vue";
import {Link, usePage} from "@inertiajs/vue3";

const open = ref(false);

const page = usePage();
const user = computed(() => page.props.auth.user);

const openDropdown = ref(null);
const mobileDropdownOpen = ref({});

const leftItems = [
    { label: 'Início', href: '/' },
    { label: 'Informações', href: '#' },
    { label: 'Download', href: '/download' },
    { label: 'Doar', href: '/manager-account?tab=donate' }
]

const rightItems = [
    { label: 'Wiki', href: 'https://epicmidgard.wiki/index.php/Main_Page' },
    { label: 'Ranking', href: '/rankings' },
    {
        label: "Database",
        type: "dropdown",
        active: false,
        children: [
            { label: "Items", url: "/database/items", type: "internal" },
            { label: "Monstros", url: "/database/monsters", type: "internal" },
        ],
    },
];

const allItems = computed(() => [...leftItems, ...rightItems]);

const slug = (s) => s.toLowerCase().replace(/\s+/g, "-").replace(/[^\w-]/g, "");

function openDesktopDropdown(label) {
    openDropdown.value = label;
}

function closeDesktopDropdown() {
    openDropdown.value = null;
}

function toggleMobileDropdown(label) {
    mobileDropdownOpen.value[label] = !mobileDropdownOpen.value[label];
}

function onParentKeydown(e, item) {
    if (e.key === "Escape") {
        closeDesktopDropdown();
        e.currentTarget.blur?.();
    }
    if ((e.key === "Enter" || e.key === " ") && item.type === "dropdown") {
        e.preventDefault();
        openDesktopDropdown(item.label === openDropdown.value ? null : item.label);
        nextTick(() => {
            const first = document.querySelector(`#menu-${slug(item.label)} [role="menuitem"]`);
            first?.focus?.();
        });
    }
}

</script>

<template>
    <header class="relative z-50 w-full md:bg-epic-navbar bg-epic-navbar-mobile bg-contain h-[100px] text-white">

        <!-- mobile: hamburger -->
        <button @click="open = !open" class="inline-flex items-center justify-center rounded-md px-5 pt-5 text-white md:hidden" aria-label="Open menu">
            <svg v-if="!open" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- mobile menu -->
        <transition enter-active-class="transition duration-200" enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="open" class="md:hidden relative z-20 border-t mx-5 rounded-lg border-white/10 bg-neutral-950/70 backdrop-blur">
                <nav class="mx-auto max-w-7xl px-4 py-4 space-y-3" role="navigation" aria-label="Mobile">
                    <div class="grid grid-cols-1 gap-1">
                        <!-- LEFT ITEMS (todos simples) -->
                        <template v-for="item in leftItems" :key="'m-left-' + item.label">
                            <a
                                :href="item.href"
                                class="rounded-md px-3 py-3 text-sm font-semibold uppercase tracking-wide hover:bg-white/5 transition flex justify-between"
                                :class="{ 'text-[#FFBD00]': item.label === 'Início' }"
                            >
                                {{ item.label }}
                            </a>
                        </template>

                        <!-- RIGHT ITEMS (com dropdown) -->
                        <template v-for="item in rightItems" :key="'m-right-' + item.label">
                            <!-- item sem dropdown -->
                            <a
                                v-if="item.type !== 'dropdown'"
                                :href="item.href"
                                class="rounded-md px-3 py-3 text-sm font-semibold uppercase tracking-wide hover:bg-white/5 transition flex justify-between"
                            >
                                {{ item.label }}
                            </a>

                            <!-- item COM dropdown (acordeão) -->
                            <div v-else class="rounded-md">
                                <button
                                    type="button"
                                    class="w-full px-3 py-3 text-left text-sm font-semibold uppercase tracking-wide hover:bg-white/5 transition flex items-center justify-between"
                                    :aria-expanded="mobileDropdownOpen[item.label] ? 'true' : 'false'"
                                    :aria-controls="'menu-' + slug(item.label)"
                                    @click="toggleMobileDropdown(item.label)"
                                >
                                    <span>{{ item.label }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              :d="mobileDropdownOpen[item.label] ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" />
                                    </svg>
                                </button>

                                <div
                                    v-show="mobileDropdownOpen[item.label]"
                                    :id="'menu-' + slug(item.label)"
                                    class="pl-4 pb-2"
                                    role="menu"
                                >
                                    <template v-for="child in item.children" :key="'m-child-' + child.label">
                                        <component
                                            :is="child.type === 'internal' ? Link : 'a'"
                                            :href="child.url"
                                            class="block rounded-md px-3 py-2 text-sm tracking-wide hover:bg-white/5 transition"
                                            role="menuitem"
                                        >
                                            {{ child.label }}
                                        </component>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- Ações/Login -->
                    <div class="flex w-full justify-center items-center gap-3 pt-2">
                        <div class="flex gap-3" v-if="user">
                            <Link href="/manager-account" class="bg-[#FFA500] !rounded-lg hover:bg-[#E59400] button-menu">
                                <img src="/assets/images/login-icon.png" alt="Login Icon" />
                                <span>{{ user.login }}</span>
                            </Link>
                        </div>
                        <div v-else class="flex gap-3">
                            <Link href="/login" class="bg-[#FFA500] !rounded-lg hover:bg-[#E59400] button-menu">
                                <img src="/assets/images/login-icon.png" alt="Login Icon" />
                                <span>Entrar</span>
                            </Link>
                            <Link href="/register" class="bg-[#374151] !rounded-lg hover:bg-[#646D7B] button-menu">
                                <span>Cadastre-se</span>
                            </Link>
                        </div>
                    </div>
                </nav>
            </div>
        </transition>

        <!-- top bar -->
        <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 md:h-20 md:px-6">
            <!-- left items -->
            <ul class="hidden gap-10 md:flex">
                <li v-for="item in leftItems" :key="item.label">
                    <a
                        :href="item.href"
                        class="font-barlow text-[20px] font-semibold tracking-wide uppercase transition hover:text-[#FFBD00]"
                        :class="{ 'text-yellow-400': item.label === 'Início' }"
                    >
                        {{ item.label }}
                    </a>
                </li>
            </ul>

            <div class="flex items-center md:w-auto w-full justify-center -mt-4 md:-mt-6">
                <img
                    src="/assets/images/logo-navbar.png"
                    alt="logo"
                    class="md:h-[250px] h-[150px] absolute top-[10px] z-10 md:z-[1000] select-none"
                />
            </div>

            <!-- right items + actions -->
            <div class="hidden items-center gap-6 md:flex">
                <ul class="flex gap-8">
                    <!-- loop dos itens da direita -->
                    <li
                        v-for="item in rightItems"
                        :key="'d-right-' + item.label"
                        class="relative"
                        @mouseenter="item.type === 'dropdown' && openDesktopDropdown(item.label)"
                        @mouseleave="item.type === 'dropdown' && closeDesktopDropdown()"
                    >
                        <!-- Item SEM dropdown -->
                        <a
                            v-if="item.type !== 'dropdown'"
                            :href="item.href"
                            class="font-barlow text-[20px] font-semibold uppercase transition hover:text-[#FFBD00]"
                        >
                            {{ item.label }}
                        </a>

                        <!-- Item COM dropdown -->
                        <div v-else class="inline-block">
                            <button
                                type="button"
                                class="font-barlow text-[20px] font-semibold uppercase transition hover:text-[#FFBD00] inline-flex items-center gap-1"
                                :aria-haspopup="'menu'"
                                :aria-expanded="openDropdown === item.label ? 'true' : 'false'"
                                :aria-controls="'menu-' + slug(item.label)"
                                @focus="openDesktopDropdown(item.label)"
                                @keydown="onParentKeydown($event, item)"
                            >
                                <span>{{ item.label }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-[2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Menu dropdown -->
                            <transition
                                enter-active-class="transition ease-out duration-150"
                                enter-from-class="opacity-0 translate-y-1"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition ease-in duration-100"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 translate-y-1"
                            >
                                <div
                                    v-show="openDropdown === item.label"
                                    :id="'menu-' + slug(item.label)"
                                    class="absolute right-0 mt-2 w-56 rounded-lg bg-neutral-900/95 backdrop-blur border border-white/10 shadow-lg focus:outline-none"
                                    role="menu"
                                    @keydown.esc.stop.prevent="closeDesktopDropdown()"
                                >
                                    <div class="py-2">
                                        <template v-for="child in item.children" :key="'d-child-' + child.label">
                                            <component
                                                :is="child.type === 'internal' ? Link : 'a'"
                                                :href="child.url"
                                                class="block px-4 py-2 text-sm hover:bg-white/5 focus:bg-white/10 outline-none"
                                                role="menuitem"
                                                tabindex="0"
                                                @keydown.enter.prevent
                                            >
                                                {{ child.label }}
                                            </component>
                                        </template>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </li>
                </ul>

                <!-- User/Actions -->
                <div>
                    <div class="flex gap-3" v-if="user">
                        <Link href="/manager-account" class="bg-[#FFA500] hover:bg-[#E59400] button-menu opacity-50 pointer-events-none">
                            <img src="/assets/images/login-icon.png" alt="Login Icon"/>
                            <span>{{ user.login }}</span>
                        </Link>
                    </div>
                    <div v-else class="flex gap-3">
                        <Link href="/login" class="bg-[#FFA500] hover:bg-[#E59400] button-menu opacity-50 pointer-events-none">
                            <img src="/assets/images/login-icon.png" alt="Login Icon"/>
                            <span>Entrar</span>
                        </Link>
                        <Link href="/register" class="bg-[#374151] hover:bg-[#646D7B] button-menu opacity-50 pointer-events-none">
                            <span>Cadastre-se</span>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
<style scoped>

</style>