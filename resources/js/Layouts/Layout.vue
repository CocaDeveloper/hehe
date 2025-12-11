<script setup>
import Menu from "@/Components/Menu.vue";
import Footer from "@/Components/Footer.vue";
import {computed, watch} from "vue";
import {useToast} from "vue-toastification";
import {usePage} from "@inertiajs/vue3";
import EpicNavbar from "@/Components/EpicNavbar.vue";

const toast = useToast();
const page = usePage();

const flash = computed(() => page.props.flash);

watch(flash, function (flash){
    if(flash.message) {
        toast.success(flash.message);
    }

    if(flash.error){
        toast.error(flash.error);
    }
})

</script>

<template>
    <div class="bg-header 3xl:min-h-[1000px] 3xl:bg-[length:100%_100%] bg-cover min-h-[100vh] bg-no-repeat">
        <EpicNavbar />
        <div class="container mx-auto">
            <slot />
        </div>
    </div>
</template>
