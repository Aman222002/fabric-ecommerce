
  <template>
  <div>
    <v-card-title class="text-left"> Work Experience </v-card-title>
    <v-row
      class="achiev_work_exp"
      v-for="(experiences, index) in experience"
      :key="index"
    >
      <v-col cols="12" v-if="index === 0">
        <v-checkbox
          v-model="experience[index].currently_working"
          label="Currently Working"
          dense
          color="#0146a6"
          @change="handleCurrentlyWorkingChange(index)"
        
        ></v-checkbox>
      </v-col>
      <v-col cols="12" md="3">
        <v-text-field
      
        v-model="experience[index].company_name"
          :name="'company_' + index"
          label="Company Name"
          required
          variant="outlined"
          :rules="index === 0 ? [] : [(v) => !!v || 'Company Name is required']"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3">
        <v-text-field
          v-model="experience[index].position"
          :name="'position_' + index"
          label="Position"
          required
          variant="outlined"
          :rules="
            index === 0 ? [] : [(v) => !!v || 'Company Position is required']
          "
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3">
        <VueDatePicker
          format="yyy/MM/dd"
          calendar-class="my_calendar"
          input-class="textfield"
          v-model="experience[index].start_date"
          :name="'start_date_' + index"
          @internal-model-change="(e) => dateClicked(index, 'start_date', e)"
          :rules="index === 0 ? [] : [(v) => !!v || 'start date  is required']"
          class="vue_date_picker_ct"
        />
      </v-col>
      <v-col cols="10" md="3">
        <VueDatePicker
          format="yyyy/MM/dd"
          calendar-class="my_calendar"
          input-class="textfield"
          v-if="!experience[index].currently_working"
          v-model="experience[index].end_date"
          :name="'end_date' + index"
          @internal-model-change="(e) => dateClicked(index, 'end_date', e)"
          :rules="index === 0 ? [] : [(v) => !!v || 'end date  is required']"
          class="vue_date_picker_ct"
        />
      </v-col>
      <v-col cols="12" md="50">
        <v-textarea
          v-model="experience[index].description"
          :name="'description_' + index"
          label="Description"
          variant="outlined"
          :rules="index === 0 ? [] : [(v) => !!v || 'description  is required']"
        ></v-textarea>
      </v-col>
      <div class="button_plus_delete">
        <span md="2">
          <v-btn
            @click="removeWorkExperience(index)"
            color="red"
            class="custom-button"
            ><v-icon>mdi-trash-can-outline </v-icon></v-btn
          >
        </span>
        <span cols="12" class="flex-end" md="2" v-if="index == 0">
          <v-btn @click="addWorkExperience" color="blue" class="custom-button">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </span>
      </div>
    </v-row>
  </div>
</template>
<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useMyStore } from "@/store";
export default {
  name: "WorkExperience",
  setup() {
    const store = useMyStore();
    const experience = ref(store.experience ?? []);
    
    const removeWorkExperience = async (index) => {
      const workExperience = experience.value[index];
      const experienceId = workExperience.id;
      console.log("Removing experienceId:", workExperience.id);
      if (
        !workExperience.company_name &&
        !workExperience.position &&
        !workExperience.start_date &&
        !workExperience.end_date &&
        !workExperience.description
      ) {
        console.warn("Cannot remove empty work experience entry");
        store.removeWorkExperience(index);
        return;
      }
      try {
        store.removeWorkExperience(index);
        await axios.post(`/removedExperience/${experienceId}`);
        const updatedExperience = experience.value.filter(
          (exp) => exp.id !== experienceId
        );
        experience.value = updatedExperience;
        console.log("Work experience removed successfully");
      } catch (error) {
        console.error("Error deleting work experience detail:", error);
        experience.value = store.experience ?? [];
      }
    };
    const dateClicked = (index, type, date) => {
      const x = new Date(date);
      experience.value[index][type] = x.toJSON().split("T")[0];
    };
    const handleCurrentlyWorkingChange = (index) => {
      const experienceItem = experience.value[index];
      if (experienceItem.currently_working) {
        experienceItem.end_date = null;
        experience.value.forEach((exp, i) => {
          if (i !== index) {
            exp.currently_working = false;
            exp.end_date = null;
          }
        });
      } else {
        experience.value.forEach((exp, i) => {
          if (i !== index && exp.currently_working) {
            exp.currently_working = false;
          }
        });
      }
    };
    const addWorkExperience = () => {
      experience.value.push({
        company_name: null,
        position: null,
        start_date: null,
        end_date: null,
        description: null,
      });
    };
    onMounted(() => {
      experience.value.forEach((exp) => {
        if (exp.end_date === null) {
          exp.currently_working = true;
        } else {
          exp.currently_working = false;
        }
      });
    });
    return {
      experience,
      removeWorkExperience,
      dateClicked,
      handleCurrentlyWorkingChange,
      addWorkExperience,
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

.textfield {
  width: 100px !important;
  height: 100px;
}

.my_calendar {
  width: 100px !important;
  height: 100px;
}
</style>