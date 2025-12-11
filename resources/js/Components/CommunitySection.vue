<script setup lang="ts">
const props = defineProps<{
    discordUrl?: string
    instagramUrl?: string
    socials?: Array<{ name: string; href: string; svg: string }>
}>()

const socials = props.socials ?? [
    { name: 'WhatsApp', href: '#', svg: 'whatsapp' },
    { name: 'Discord',  href: '#', svg: 'discord' },
    { name: 'Facebook',  href: '#', svg: 'facebook' },
    { name: 'Instagram',href: '#', svg: 'instagram' },
    { name: 'TikTok',   href: '#', svg: 'tiktok' },
]
</script>

<template>
    <section class="relative overflow-hidden bg-social bg-[length:100%_100%] bg-no-repeat">
        <!-- container -->
        <div class="relative container mx-auto px-4 md:px-6 py-12 md:py-16">
            <!-- título -->
            <h2 class="text-center font-sora font-extrabold uppercase tracking-[2px] text-white text-[28px] md:text-[40px]">
                ENTRE NA <br><span class="text-[#FFB82B]">NOSSA COMUNIDADE</span>
            </h2>

            <!-- CTAs -->
            <div
                class="mt-8 md:mt-10 flex flex-col md:flex-row items-stretch md:items-center
               gap-4 md:gap-8 justify-center"
            >
                <!-- Discord -->
                <a
                    :href="discordUrl || '#'"
                    class="group relative flex items-center justify-start md:justify-center overflow-hidden w-[380px]">
                    <img src="/assets/images/discord-button.png" class="w-[380px]" alt="Discord Button" />
                </a>

                <!-- Instagram -->
                <a
                    :href="instagramUrl || '#'"
                    class="group relative flex items-center justify-start md:justify-center overflow-hidden w-[380px]">
                    <img src="/assets/images/instagram-button.png" alt="Instagram Button" />
                </a>
            </div>

            <!-- logo central -->
            <div class="mt-10 md:mt-12 flex justify-center">
                <img
                    src="/assets/images/logo-menu.png"
                    alt="Epic Midgard"
                    class="w-[130px]"
                />
            </div>

            <!-- socials row -->
            <div class="mt-6 flex items-center justify-center gap-5 md:gap-7">
                <a v-for="s in socials" :key="s.name" :href="s.href" class="group w-[50px]" :aria-label="s.name">
                    <img :src="`/assets/images/social-icons/${s.svg}.png`" :name="s.svg" class="opacity-80 group-hover:opacity-100 transition" />
                </a>
            </div>
        </div>

        <!-- personagens laterais (fora do fluxo) -->
        <img
            src="/assets/images/social-left.png"
            alt=""
            class="hidden md:block pointer-events-none select-none absolute left-3 md:left-6 bottom-0 w-[210px] md:w-[270px]"
        />
        <img
            src="/assets/images/social-right.png"
            alt=""
            class="hidden md:block pointer-events-none select-none absolute right-0 md:right-2 bottom-0 w-[320px] md:w-[380px]"
        />
    </section>
</template>

<style scoped>
a.group:hover { transform: translateY(-1px); transition: transform .15s ease; }
</style>