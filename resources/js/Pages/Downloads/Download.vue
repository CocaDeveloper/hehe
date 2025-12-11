<script setup>
import Layout from "@/Layouts/Layout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const page = usePage();
const downloads = computed(() => page.props.downloads);

</script>

<template>
    <Layout>
        <Head title="Download" />

        <div class="flex flex-col lg:p-10 mt-[40px]">
            <h1 class="font-bebas lg:text-[40px] text-[24px] uppercase lg:mb-8 mb-5 text-white leading-[25px]">Baixe o Jogo</h1>
            <div>

                <div class="flex gap-3">
                    <a :href="downloads.google_drive" target="_blank">
                        <img class="w-[200px]" src="/assets/images/downloads/google-drive.png" alt="Google Drive" />
                    </a>
                    <a :href="downloads.mega" target="_blank">
                        <img class="w-[200px]" src="/assets/images/downloads/mega.png" alt="Mega" />
                    </a>
                    <a :href="downloads.media_fire" target="_blank">
                        <img class="w-[200px]" src="/assets/images/downloads/media-fire.png" alt="Media Fire" />
                    </a>
                </div>

            </div>

        </div>

    </Layout>
</template>

<style scoped>

</style>