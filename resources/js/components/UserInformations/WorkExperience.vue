<!-- <template>
  <div>
    <v-card-title class="text-left">
      Work Experience
    </v-card-title>

    <v-row v-for="(experience, index) in experiences" :key="index">
      <v-col cols="12">
        <v-checkbox v-model="experience.currently_working" label="Currently Working" dense color="success" @change="handleCurrentlyWorkingChange(index)"></v-checkbox>
      </v-col>
      <v-col cols="12" md="3">
        <v-text-field v-model="experience.company_name" :name="'company_' + index" label="Company Name"
          required variant="outlined"
          :rules="index === 0 ? [] : [v => !!v || 'Company Name is required']"></v-text-field>
      </v-col>
      <v-col cols="12" md="3">
        <v-text-field v-model="experience.position" :name="'position_' + index" label="Position" required
          variant="outlined"
          :rules="index === 0 ? [] : [v => !!v || 'Company Position is required']"></v-text-field>
      </v-col>
      <v-col cols="12" md="3">
        <VueDatePicker format="yyyy/MM/dd" calendar-class="my_calendar" input-class="textfield"
          v-model="experience.start_date" :name="'start_date_' + index"
          @internal-model-change="(e) => dateClicked(index, 'start_date', e)"
          :rules="index === 0 ? [] : [v => !!v || 'Start date is required']" />
      </v-col>
      <v-col cols="12" md="3">
        <VueDatePicker v-if="!experience.currently_working" format="yyyy/MM/dd" calendar-class="my_calendar" input-class="textfield"
          v-model="experience.end_date" :name="'end_date' + index"
          @internal-model-change="(e) => dateClicked(index, 'end_date', e)"
          :rules="index === 0 ? [] : [v => !!v || 'End date is required']" />
      </v-col>
      <v-col cols="12" md="6">
        <v-textarea v-model="experience.description" :name="'description_' + index" label="Description"
          variant="outlined"
          :rules="index === 0 ? [] : [v => !!v || 'Description is required']"></v-textarea>
      </v-col>
      <v-col v-if="index > 0" md="2">
        <v-btn @click="removeWorkExperience(index)" color="red" class="custom-button">Remove</v-btn>
      </v-col>
      <v-col cols="12" class="flex-end" md="2" v-else>
        <v-btn @click="addWorkExperience" color="blue" class="custom-button">Add More</v-btn>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useMyStore } from '../../store';

export default {
  name: 'WorkExperience',
  setup() {
    const store = useMyStore();
    const experiences = ref([]);

    const removeWorkExperience = async (index) => {
      const workExperience = experiences.value[index];
      const experienceId = workExperience.id;
      console.log('Removing experienceId:',  workExperience.id);

      if (!workExperience.company_name && !workExperience.position && !workExperience.start_date && !workExperience.end_date && !workExperience.description) {
        console.warn('Cannot remove empty work experience entry');
        store.removeWorkExperience(index);
        return;
      }

      try {
        store.removeWorkExperience(index);
        await axios.post(`/removedExperience/${experienceId}`);
        const updatedExperience = experiences.value.filter(exp => exp.id !== experienceId);
        experiences.value = updatedExperience;

        console.log('Work experience removed successfully');
      } catch (error) {
        console.error('Error deleting work experience detail:', error);
        experiences.value = store.experience ?? [];
      }
    };

    const dateClicked = (index, type, date) => {
      const x = new Date(date);
      experiences.value[index][type] = x.toJSON().split('T')[0];
    };

    const handleCurrentlyWorkingChange = (index) => {
      const experience = experiences.value[index];
      if (experience.currently_working) {
        experience.end_date = null;
      }
    };

    const addWorkExperience = () => {
      experiences.value.push({
        company_name: '',
        position: '',
        start_date: '',
        end_date: null,
        description: '',
        currently_working: false 
      });
    };

    const fetchData = async () => {
      try {
        const response = await axios.get('/work-experiences');
        experiences.value = response.data;
        experiences.value.forEach((experience) => {
          if (experience.end_date === null) {
            experience.currently_working = true;
          }
        });
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };

    onMounted(fetchData);

    return {
      experiences,
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
</style> -->

  
  

  <template>
  <div>
    <v-card-title class="text-left"> Work Experience </v-card-title>
    <v-row class="achiev_work_exp" v-for="(experiences, index) in experience" :key="index">
      <v-col cols="12" v-if="index === 0">
        <v-checkbox
          v-model="experience[index].currently_working"
          label="Currently Working"
          dense
          color="success"
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
        <span  md="2">
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
        company_name: "",
        position: "",
        start_date: "",
        end_date: "",
        description: "",
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