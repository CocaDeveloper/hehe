<script setup>
const props = defineProps({
    zenys: Object
});

const formatZeny = (num) => new Intl.NumberFormat('pt-BR').format(num);

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
                    <th class="p-4 last:rounded-tr-[16px]">Zenys</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(zeny, index) in zenys" :key="index" class="text-center bg-[#685CCB]">
                    <td class="p-4"
                        :class="index === zenys.length - 1 ? 'first:rounded-bl-[16px]' : ''"
                    >{{ index+1 }}º</td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <img :src="`/assets/images/jobs/${zeny.class_id}.png`" :alt="zeny.class_name" :title="zeny.class_name">
                            {{ zeny.name }}
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <img v-if="zeny.guild && zeny.guild.emblem" :src="zeny.guild.emblem" alt="Guild Emblem">
                            {{ zeny.guild ? zeny.guild.name : 'Sem Clãn' }}
                        </div>
                    </td>
                    <td class="p-4">
                                      <span
                                          class="px-3 py-1 rounded-[6px] text-white text-sm"
                                          :class="zeny.status? 'bg-[#25B700]' : 'bg-[#656565]'"
                                      >
                                        {{ zeny.status? 'Online' : 'Offline' }}
                                      </span>
                    </td>
                    <td
                        :class="index === zenys.length - 1 ? 'last:rounded-br-[16px]' : ''"
                        class="p-4"
                    >
                        <span>{{ formatZeny(zeny.zenys) }}z</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>