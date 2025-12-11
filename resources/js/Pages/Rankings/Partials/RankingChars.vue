<script setup>
const props = defineProps({
    chars: Object
});

</script>

<template>
    <div class=" text-white overflow-hidden shadow-lg pb-20">
        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-[3px] min-w-[800px]">
                <thead>
                <tr class="bg-[#685CCB] text-center">
                    <th class="p-4 first:rounded-tl-[16px]">Posição</th>
                    <th class="p-4">Personagem</th>
                    <th class="p-4">Clãn</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 last:rounded-tr-[16px]">Level</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(char, index) in chars" :key="index" class="text-center bg-[#685CCB]">
                    <td class="p-4"
                        :class="index === chars.length - 1 ? 'first:rounded-bl-[16px]' : ''"
                    >{{ index+1 }}º</td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <img :src="`/assets/images/jobs/${char.class_id}.png`" :alt="char.class_name" :title="char.class_name">
                            {{ char.name }}
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <img v-if="char.guild && char.guild.emblem" :src="char.guild.emblem" alt="Guild Emblem">
                            {{ char.guild ? char.guild.name : 'Sem Clãn' }}
                        </div>
                    </td>
                    <td class="p-4">
                                      <span
                                          class="px-3 py-1 rounded-[6px] text-white text-sm"
                                          :class="char.status? 'bg-[#25B700]' : 'bg-[#656565]'"
                                      >
                                        {{ char.status? 'Online' : 'Offline' }}
                                      </span>
                    </td>
                    <td
                        :class="index === chars.length - 1 ? 'last:rounded-br-[16px]' : ''"
                        class="p-4"
                    >
                        <span>{{ char.level }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>