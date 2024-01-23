<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card class="card">
                    <v-card-title class="headline">Personal Information</v-card-title>
                    <v-form @submit.prevent="updateProfile(formData.id)">
                        <v-row>
                            <v-col cols="12">
                                <v-card>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="2">
                                                <v-avatar size="130px" class="avatar">
                                                    <div id="inspire">
                                                        <label for="fileInput" @click="openFileInput">
                                                            <span class="mdi mdi-pencil" id="icon"></span>
                                                        </label>
                                                        <input type="file" id="fileInput" ref="fileInput"
                                                            style="display: none" @change="handleImageChange" />
                                                        <img v-if="imageUrl" :src="imageUrl" alt="Selected Image"
                                                            width="130px" height="130px" />
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
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-card class="card">
                    <v-card-title class="headline">Password and Security</v-card-title>
                    <v-form @submit.prevent="updatePassword(formData.id)">
                        <v-row>
                            <v-col cols="12">
                                <v-card>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="4">
                                                <label for="Current Password" class="custom-text-field">Current
                                                    Password</label>
                                                <v-text-field v-model="formDetail.current" :rules="currentRules"
                                                    type="password" label="Current Password"></v-text-field>
                                            </v-col>
                                            <v-col cols="4">
                                                <label for="New Password" class="custom-text-field">New Password</label>
                                                <v-text-field v-model="formDetail.new" :rules="newRules" type="password"
                                                    label="New Password"></v-text-field>
                                            </v-col>
                                            <v-col cols="4">
                                                <label for="Confirm Passwprd" class="custom-text-field">Confirm
                                                    Password</label>
                                                <v-text-field v-model="formDetail.confirm" :rules="confirmRules"
                                                    type="password" label="Confirm Password"></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn type="submit" color="primary">Save</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
import { ref, nextTick, onMounted } from 'vue';

export default {
    name: 'ProfileComponent',
    setup() {
        const imageUrl = ref();
        const fileInputRef = ref();
        const formData = ref({
            id: '',
            name: '',
            email: '',
            phone: '',
        });
        const formDetail = ref({
            current: '',
            new: '',
            confirm: '',
        });
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
        const currentRules = ref([

        ]);
        const newRules = ref([
        ]);
        const confirmRules = ref([
        ]);
        const openFileInput = () => {
            fileInputRef.value.click();
        };
        const handleImageChange = () => {
            const file = fileInputRef.value.files[0];

            if (file) {
                // Validate if the selected file is an image
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    fileInputRef.value.value = null;
                    return;
                }
                // Read and display the selected image
                const reader = new FileReader();
                reader.onload = (e) => {
                    imageUrl.value = e.target.result;
                };
                reader.readAsDataURL(file);
                formData.value.image = file;
            }
        };
        const fetchProfile = () => {
            window.axios.get('./profile/getProfile').then((response) => {
                console.log(response.data.user);
                formData.value = response.data.user;
                imageUrl.value = response.data.user.image_url;
            })
        };
        onMounted(async () => {
            await nextTick();
            fileInputRef.value = document.getElementById('fileInput');
            fetchProfile();
        });
        const updateProfile = (id) => {
            console.log('Updating profile:', formData.value);
            const formDataUpload = new FormData();
            formDataUpload.append('name', formData.value.name);
            formDataUpload.append('email', formData.value.email);
            formDataUpload.append('phone', formData.value.phone);
            if (formData.value.image) {
                formDataUpload.append('user_image', formData.value.image);
            }
            formDataUpload.forEach((value, key) => {
                console.log(`Appended ${key}: ${value}`);
            });
            window.axios.post(`./user/updateProfile/${id}`, formDataUpload, {
                header: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                console.log(response.status);
            })
        };
        return {
            formData,
            formDetail,
            updateProfile,
            nameRules,
            emailRules,
            phoneRules,
            currentRules,
            newRules,
            confirmRules,
            imageUrl,
            fileInputRef,
            openFileInput,
            handleImageChange,
        };
    }
}
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

.v-avatar {
    display: flex;
    flex-direction: column-reverse;
    justify-content: flex-start;
}

#icon {
    position: absolute;
    top: 90%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    color: white;
}
</style>
  