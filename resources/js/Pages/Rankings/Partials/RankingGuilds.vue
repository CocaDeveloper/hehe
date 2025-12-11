<script setup>
const props = defineProps({
    guilds: Object
});

</script>

<template>
    <div class=" text-white overflow-hidden shadow-lg pb-20">
        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-[3px] min-w-[800px]">
                <thead>
                <tr class="bg-[#685CCB] text-center">
                    <th class="p-4 first:rounded-tl-[16px]">Posição</th>
                    <th class="p-4">Clãn</th>
                    <th class="p-4">Level</th>
                    <th class="p-4">Experiência</th>
                    <th class="p-4 last:rounded-tr-[16px]">Membros</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(guild, index) in guilds" :key="index" class="text-center bg-[#685CCB]">
                    <td class="p-4"
                        :class="index === guilds.length - 1 ? 'first:rounded-bl-[16px]' : ''"
                    >{{ index+1 }}º</td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <img v-if="guild.emblem" :src="guild.emblem" alt="Guild Emblem">
                            {{ guild.name }}
                        </div>
                    </td>
                    <td class="p-4">
                        {{guild.level}}
                    </td>
                    <td class="p-4">
                        {{guild.exp}}
                    </td>
                    <td
                        :class="index === guilds.length - 1 ? 'last:rounded-br-[16px]' : ''"
                        class="p-4"
                    >
                        <span>{{ guild.total_members }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>