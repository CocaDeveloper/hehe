<script setup>
import {inject} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const chars = inject('chars');

</script>

<template>
    <div class="mt-5">

        <h1 class="font-bebas mb-5 lg:text-[40px] text-[30px] uppercase text-center text-white leading-[25px]">
            Seus <span class="text-[#FA8315]">Personagens!</span>
        </h1>

        <div class="grid grid-cols-4 gap-5">
            <div class="bg-black/[.5] p-5 rounded-lg mb-3" v-for="char in chars">
                <div>
                    <div class="flex items-center flex-col">
                        <div class="mb-2">
                            <img :title="char.class_name" :src="`/assets/images/jobs/${char.class_id}.png`" :alt="char.class_name" />
                        </div>
                        <span class="font-bebas text-white text-[20px]">Nome: <span class="text-[#FA8315]">{{char.name}}</span></span>
                        <span class="font-bebas text-white text-[20px]">Level: <span class="text-[#FA8315]">{{char.level}}</span></span>
                        <span class="font-bebas text-white text-[20px]">Classe: <span class="text-[#FA8315]">{{char.class_name}}</span></span>
                        <span class="font-bebas text-white text-[20px]">Último Acesso: <span class="text-[#FA8315]">{{char.last_login}}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>