<!-- <template>
    <v-container>
        <v-card-text>Hobbies</v-card-text>
        <v-row>
            <v-col cols="10" sm="50">
                <v-textarea v-model="hobbies" label="Hobbies"></v-textarea></v-col>
            <v-col cols="10" sm="50"><v-textarea v-model="strengths" label="Strengths"></v-textarea></v-col>

        </v-row>
    </v-container>
</template>

<script>
import { ref, onMounted } from 'vue';
export default {
    name: 'UserProfile',
    setup() {
        const hobbies = ref('');
        const strengths = ref('');
        const submitForm = () => {
            const formData = {
                hobbies: hobbies.value,
                strengths: strengths.value,

            };
            axios.post('/user-profile', formData)
                .then(response => {

                })
                .catch(error => {

                    if (error.response && error.response.status === 422) {

                        console.log(error.response.data);
                    } else {

                        console.error(error.message);
                    }
                });
        }

        return {
            hobbies,
            strengths,
            submitForm,
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
userprofile -->

<template>
    <div>
        <v-card-title class="text-left">
            Hobbies
        </v-card-title>
        <v-row v-for="(field, index) in fields" :key="index">
            <v-col cols="10" sm="50">
                <v-textarea v-model="field.hobbies" label="Hobbies"></v-textarea>
            </v-col>
            <v-col cols="10" sm="50">
                <v-textarea v-model="field.strengths" label="Strengths"></v-textarea>
            </v-col>

        </v-row>
        <v-btn @click="addField" color="blue">Add More</v-btn>
        <v-col v-if="fields.length > 1" cols="2">
            <v-btn @click="removeField(index)" color="red">Remove</v-btn>
        </v-col>

    </div>
</template>

<script>
import { ref } from 'vue';
import { useMyStore } from '../../store';
export default {
    setup() {
        const store = useMyStore();
        const fields = ref(store.fields);


        // const addField = () => {
        //     fields.value.push({ hobbies: '', strengths: '' });
        // };

        // const removeField = (index) => {

        //     if (fields.value.length > 1) {
        //         fields.value.splice(index, 1);
        //     }
        // };

        const submitForm = () => {
            const formData = {
                fields: fields.value,
            };
            axios.post('/user-profile', formData)
                .then(response => {
                    // Handle success
                })
                .catch(error => {
                    // Handle error
                    if (error.response && error.response.status === 422) {
                        console.log(error.response.data);
                    } else {
                        console.error(error.message);
                    }
                });
        };

        return {
            fields,
            addField: store.addField,
            removeField: store.removeField,
            submitForm,
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
