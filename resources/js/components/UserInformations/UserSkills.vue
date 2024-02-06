<!-- 
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
   -->

   
<template>
    <v-card-title class="pl-0">
        Add your skills
    </v-card-title>
    <v-row>
        <v-col cols="12" md="12">
            <v-select v-model="selectedSkills" :items="skills" item-title="skill_name" item-value="id"
                label="Select Multiple Skills" chips multiple @update:modelValue="updateSkills"></v-select>
        </v-col>
    </v-row>
</template>
  
<script>
import { ref, onMounted } from 'vue';
import { useMyStore } from "../../store";
import axios from 'axios';
export default {
    name: 'UserSkills',
    setup() {
        const store = useMyStore();
        const selectedSkills = ref(store.selectedSkills ?? []);
        // const selectedSkill = ref(null);
        const skills = ref([]);
        onMounted(async () => {
            try {
                const response = await axios.get('/skills');
                skills.value = response.data.skills;

            } catch (error) {
                console.error('Error fetching skills:', error);
            }
        });

        // const addSkill = () => {
        //     if (selectedSkills.value) {
        //         store.addSkill(selectedSkills.value);
        //         selectedSkills.value = null;
        //     }
        // };

        // const submitForm = () => {
        //     const userId = 1;
        //     const skillIds = useMyStore.selectedSkills.map(skill => skill.id);

        //     axios.post('/user-skills', { user_id: userId, skill_ids: skillIds })
        //         .then(response => {
        //             console.log(response.data.message);
        //             useMyStore.clearSelectedSkills();
        //         })
        //         .catch(error => {
        //             console.error('Error saving skills:', error);
        //         });
        // };

        const updateSkills = () => {
            store.updateSkills(selectedSkills.value);
        }

        return {
            updateSkills,
            selectedSkills,
            //useMyStore,
            skills,
            // addSkill,

        };
    },
};
</script>
  
<style scoped>
.container-center {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
