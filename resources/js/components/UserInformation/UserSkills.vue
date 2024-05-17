<template>
  <v-card-title class="pl-0"> Add your skills </v-card-title>
  <v-row>
    <v-col cols="12" md="12">
      <v-select
        v-model="selectedSkills"
        :items="skills"
        item-title="skill_name"
        item-value="id"
        label="Select Multiple Skills"
        chips
        multiple
        @update:modelValue="updateSkills"
        variant="outlined"
      ></v-select>
    </v-col>
  </v-row>
</template>
<script>
import { ref, onMounted } from "vue";
import { useMyStore } from "../../store";
import axios from "axios";
export default {
  name: "UserSkills",
  setup() {
    const store = useMyStore();
    const selectedSkills = ref(store.selectedSkills ?? []);
    const skills = ref([]);
    const fetchSkills = async () => {
      try {
        const response = await axios.get("/user/skills");
        const userSkills = response.data.map((skill, index) => ({
          id: skill.skill_id,
          skill_name: skill.skill[0].skill_name,
        }));
        console.log(userSkills);
        skills.value = userSkills;
        console.log(skills.value);
        selectedSkills.value = userSkills.map((skill) => skill.id);
      } catch (error) {
        console.error("Error fetching user skills:", error);
        return [];
      }
    };
    onMounted(async () => {
      try {
        await fetchSkills();
        console.log(selectedSkills.value);
        console.log(skills.value);
        // return;
        const response = await axios.get("/skills");
        skills.value = response.data;

        console.log(skills.value);
      } catch (error) {
        console.error("Error fetching skills:", error);
      }
    });
    const updateSkills = () => {
      console.log("Selected skills:", selectedSkills.value);
      store.updateSkills(selectedSkills.value);
    };
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
