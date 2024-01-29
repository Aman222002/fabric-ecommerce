
<template>
    <div>
        <v-card-title class="text-left">
            Hobbies
        </v-card-title>
        <v-row v-for="(field, index) in fields" :key="index">
            <v-col cols="10" sm="50">
                <v-textarea v-model="field.hobbies" label="Hobbies"
                    :rules="[v => !!v || 'hobbies  is required']"></v-textarea>
            </v-col>
            <v-col cols="10" sm="50">
                <v-textarea v-model="field.strengths" label="Strengths"
                    :rules="[v => !!v || 'strengths  is required']"></v-textarea>
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
    name: 'UserProfile',
    setup() {
        const store = useMyStore();
        const fields = ref(store.fields);

        const submitForm = () => {
            const formData = {
                fields: fields.value,
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
        };

        return {
            fields,
            addField: store.addFields,
            removeField: store.removeFields,
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
