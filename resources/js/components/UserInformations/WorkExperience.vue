<template>
    <div>
        <v-card-title class="text-left">
            Work Experience
        </v-card-title>
        <v-row v-for="(experiences, index) in experience" :key="index">

            <v-col cols="12" md="3">
                <v-text-field v-model="experience[index].company_name" :name="'company_' + index" label="Company Name"
                    required variant="outlined"
                    :rules="index === 0 ? [] : [v => !!v || 'Company Name is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="experience[index].position" :name="'position_' + index" label="Position" required
                    variant="outlined"
                    :rules="index === 0 ? [] : [v => !!v || 'Company Position is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">

                <VueDatePicker format="yyy/MM/dd" calendar-class="my_calendar" input-class="textfield"
                    v-model="experience[index].start_date" :name="'start_date_' + index"
                    @internal-model-change="(e) => dateClicked(index, 'start_date', e)"
                    :rules="index === 0 ? [] : [v => !!v || 'start date  is required']" />

            </v-col>
            <v-col cols="10" md="3">

                <VueDatePicker format="yyyy/MM/dd" calendar-class="my_calendar" input-class="textfield"
                    v-model="experience[index].end_date" :name="'end_date' + index"
                    @internal-model-change="(e) => dateClicked(index, 'end_date', e)"
                    :rules="index === 0 ? [] : [v => !!v || 'end date  is required']" />

            </v-col>
            <v-col cols="12" md="50">
                <v-textarea v-model="experience[index].description" :name="'description_' + index" label="Description"
                    variant="outlined"
                    :rules="index === 0 ? [] : [v => !!v || 'description  is required']"></v-textarea>
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
import { ref } from 'vue';
import { useMyStore } from '@/store';

export default {
    name: 'WorkExperience',
    setup() {
        const store = useMyStore();
        const experience = ref(store.experience?? []);
        // const removeWorkExperience = async (index) => {
        //     store.removeWorkExperience;
        //     const experienceId = experience.value[index].id;
        //     try {
        //         console.log(experienceId, 'experienceId ')
        //         axios.post(`/removedExperience/${experienceId}`);
        //         experience.value.splice(index, 1);
        //     } catch (error) {
        //         console.error('Error deleting experience detail:', error);
        //     }
        // };
        const removeWorkExperience = async (index) => {
    const workExperience = experience.value[index];
    const experienceId = workExperience.id;
    console.log('Removing experienceId:',  workExperience.id);

    if (!workExperience.company_name && !workExperience.position && !workExperience.start_date && !workExperience.end_date && !workExperience.description) {
        console.warn('Cannot remove empty work experience entry');
        return;
    }

    try {
       
        await axios.post(`/removedExperience/${experienceId}`);
        
      
        store.removeWorkExperience(index);

      
        const updatedExperience = [
            ...experience.value.slice(0, index),
            ...experience.value.slice(index + 1)
        ];
        experience.value = updatedExperience;
        
        console.log('Work experience removed successfully');
    } catch (error) {
     
        console.error('Error deleting work experience detail:', error);
    
        experience.value = store.experience ?? [];
    }
};



        const dateClicked = (index, type, date) => {
            const x = new Date(date);
            //console.log("date", date, x.toJSON().split('T')[0])
            experience.value[index][type] = x.toJSON().split('T')[0];
        }
        const addWorkExperience = () => {
    experience.value.push({
        company_name: '',
        position: '',
        start_date: '',
        end_date: '',
        description: ''
    });
};
        return {
            experience,
            removeWorkExperience,
           
            dateClicked,
           
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