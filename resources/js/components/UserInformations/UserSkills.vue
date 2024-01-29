
<template>
    <v-card-title class="pl-0">
        Add your skills
    </v-card-title>
    <v-row>
        <v-col cols="12" md="12">
            <v-select v-model="localSkills" :items="allSkills" item-title="skill_name" item-value="id"
                label="Select Multiple Skills" chips multiple></v-select>

        </v-col>
    </v-row>
</template>
  
<script>
import { ref, onMounted } from 'vue';
import { useMyStore } from "../../store";
export default {
    name: 'UserSkills',
    setup() {
        const store = useMyStore();

        const localSkills = ref([]);


        return {
            store,
            localSkills,
            allSkills: store.allSkills,
            skills: store.userSkills,
        };
    },
    onMounted() {
        this.store.fetchSkills()
    },
    methods: {
        checkSkills() {
            this.store.userSkills = this.localSkills;
            console.log("here", this.localSkills)
        }
    }
};
</script>
  
<style scoped>
.container-center {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
  