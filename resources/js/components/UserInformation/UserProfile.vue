
<template>
  <div>
    <v-card-title class="pl-0"> Hobbies And Strengths </v-card-title>
    <v-row>
      <v-col cols="8" md="5">
        <v-textarea
          v-model="userProfile.hobbies"
          label="Hobbies"
          variant="outlined"
        ></v-textarea>
      </v-col>

      <v-col cols="8" md="5">
        <v-textarea
          v-model="userProfile.strengths"
          label="Strengths"
          variant="outlined"
        ></v-textarea>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { ref } from "vue";
import { useMyStore } from "../../store";

export default {
  name: "UserProfile",
  setup() {
    const store = useMyStore();
    const userProfile = ref(store.userProfile);
    return {
      userProfile,
      // addField: store.addFields,
      // removeField: store.removeFields,
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
