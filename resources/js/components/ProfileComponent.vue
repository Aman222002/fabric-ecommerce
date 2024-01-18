<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card class="card">
                    <v-card-title class="headline">Personal Information</v-card-title>
                    <v-form @submit.prevent="updateProfile">
                        <v-row>
                            <v-col cols="12">
                                <v-card>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="2">
                                                <v-avatar size="130px" class="avatar">
                                                    <img alt="Avatar" src="">
                                                    <div id="inspire">
                                                        <v-file-input class="hidden-input"
                                                            label="Choose a file"></v-file-input>
                                                    </div>
                                                </v-avatar>
                                            </v-col>
                                            <v-col cols="3">
                                                <label for="name" class="custom-text-field">Name</label>
                                                <v-text-field v-model="formData.name" :rules="nameRules"
                                                    label="Name"></v-text-field>
                                            </v-col>
                                            <v-col cols="3">
                                                <label for="email" class="custom-text-field">Email</label>
                                                <v-text-field v-model="formData.email" :rules="emailRules"
                                                    label="Email"></v-text-field>
                                            </v-col>
                                            <v-col cols="3">
                                                <label for="phone" class="custom-text-field">Contact No.</label>
                                                <v-text-field v-model="formData.phone" :rules="phoneRules"
                                                    label="Contact No."></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn type="submit" color="primary">Update</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <!-- Add more sections or cards for additional information -->
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
import { ref } from 'vue';

export default {
    name: 'ProfileComponent',
    setup() {
        const showFileInput = ref(false);
        const formData = ref({
            name: '',
            email: '',
            phone: '',
        });
        const updateProfile = () => {
            console.log('Updating profile:', formData.value);
        };
        const nameRules = ref([
            v => !!v || 'Full Name is required',
            v => (v && v.length >= 3) || 'Full Name must be at least 3 characters',
        ]);
        const emailRules = ref([
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ]);
        const phoneRules = ref([
            v => !!v || 'Phone number is required',
            v => (v && v.length >= 10) || 'Phone number must be a valid 10-digit number',
        ]);

        return {
            updateProfile,
            formData,
            showFileInput,
            nameRules,
            emailRules,
            phoneRules,
        };
    },
};
</script>
  
<style scoped>
.headline {
    background-color: #5d5f61;
}

.card {
    background-color: rgb(235, 235, 198);
}

.hidden-input {
    display: none;
}

.custom-text-field {
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 20px;
    color: black
}

.avatar {
    border: 1px solid black;
}
</style>
  