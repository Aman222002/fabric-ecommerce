<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card class="card">
                    <v-card-title class="bg-primary text-center">Personal Information</v-card-title>
                    <v-form @submit.prevent="updateProfile(formData.id)">
                        <v-row>
                            <v-col cols="12">
                                <v-card>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="2">
                                                <v-avatar size="130px" class="avatar">
                                                    <label for="fileInput" @click="openFileInput">
                                                        <span class="mdi mdi-pencil" id="icon"></span>
                                                    </label>
                                                    <input type="file" id="fileInput" ref="fileInput" style="display: none"
                                                        @change="handleImageChange" />
                                                    <img v-if="imageUrl" :src="imageUrl" alt="Selected Image" width="150px"
                                                        height="150px" />
                                                </v-avatar>
                                            </v-col>
                                            <v-col cols="3">
                                                <label for="name" class="custom-text-field">Name</label>
                                                <v-text-field v-model="formData.name" :rules="nameRules"></v-text-field>
                                            </v-col>
                                            <v-col cols="3">
                                                <label for="email" class="custom-text-field">Email</label>
                                                <v-text-field v-model="formData.email" :rules="emailRules"></v-text-field>
                                            </v-col>
                                            <v-col cols="3">
                                                <label for="phone" class="custom-text-field">Contact No.</label>
                                                <v-text-field v-model="formData.phone" :rules="phoneRules"></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn class="bg-primary mx-auto" color="white" type="submit">Update</v-btn>
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
                    <v-card-title class="bg-primary text-center">Password and Security</v-card-title>
                    <v-form @submit.prevent="updatePassword()">
                        <v-row>
                            <v-col cols="12">
                                <v-card>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="4">
                                                <label for="Current Password" class="custom-text-field">Current
                                                    Password</label>
                                                <v-text-field v-model="formDetail.current"
                                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show1 ? 'text' : 'password'" :rules="currentRules"
                                                    @click:append="show1 = !show1"></v-text-field>
                                            </v-col>
                                            <v-col cols="4">
                                                <label for="New Password" class="custom-text-field">New Password</label>
                                                <v-text-field v-model="formDetail.new" :rules="newRules"
                                                    :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show2 ? 'text' : 'password'"
                                                    @click:append="show2 = !show2"></v-text-field>
                                            </v-col>
                                            <v-col cols="4">
                                                <label for="Confirm Passwprd" class="custom-text-field">Confirm
                                                    Password</label>
                                                <v-text-field :rules="confirmRules"
                                                    :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show3 ? 'text' : 'password'"
                                                    @click:append="show3 = !show3"></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn class="bg-primary mx-auto" type="submit" color="white">Save</v-btn>
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
import axios from 'axios';
import { ref, nextTick, onMounted } from 'vue';
import { useUsersStore } from "../store/user";
export default {
    name: 'ProfileComponent',
    setup() {
        const userStore = useUsersStore();
        const show1 = ref(false);
        const show2 = ref(false);
        const show3 = ref(false);
        const imageUrl = ref();
        const fileInput = ref();
        const formData = ref({
            id: '',
            name: '',
            email: '',
            phone: '',
        });
        const formDetail = ref({
            current: '',
            new: '',
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
            value => !!value || 'Password is required',
        ]);
        const newRules = ref([
            value => !!value || 'Password is required',
            value => (value && value.length >= 8) || 'Password must be at least 8 characters',
        ]);
        const confirmRules = ref([
            value => !!value || 'Confirm Password is required',
            value => (value === formDetail.value.new) || 'Passwords do not match',
        ]);
        const openFileInput = () => {
            fileInput.value.click();
        };
        const handleImageChange = () => {
            const file = fileInput.value.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    fileInput.value.value = null;
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    imageUrl.value = e.target.result;
                };
                reader.readAsDataURL(file);
                formData.value.image = file;
            }
        };
        const fetchProfile = () => {
            userStore.fetchUser();
            formData.value = userStore.user.user;
            imageUrl.value = userStore.user.user.user_image;
        };
        onMounted(async () => {
            await nextTick();
            fileInput.value = document.getElementById('fileInput');
            fetchProfile();
        });
        const updateProfile = (id) => {
            const formDataUpload = new FormData();
            formDataUpload.append('name', formData.value.name);
            formDataUpload.append('email', formData.value.email);
            formDataUpload.append('phone', formData.value.phone);
            if (formData.value.image) {
                formDataUpload.append('user_image', formData.value.image);
            }
            axios.post(`./user/update-profile/${id}`, formDataUpload, {
                header: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                console.log(response.data);
                if (response.data.status === true) {
                    window.Swal.fire({
                        toast: true,
                        position: 'top-end',
                        timer: 2000,
                        showConfirmButton: false,
                        icon: 'success',
                        title: 'User Profile updated successfully!',
                    });
                    // window.location.reload();
                }
            }).catch((error) => {
                console.log('here');
                window.Swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false,
                    icon: 'error',
                    title: 'Incoreect Password!',
                });
            })
        };
        const updatePassword = () => {
            console.log(formDetail.value);
            axios.post(`./user/update-password`, formDetail.value).then((response) => {
                console.log(response);
                if (response.data.status === true) {
                    window.Swal.fire({
                        toast: true,
                        position: 'top-end',
                        timer: 2000,
                        showConfirmButton: false,
                        icon: 'success',
                        title: 'Password updated successfully!',
                    });
                }
            }).catch((error) => {
                console.log('here');
                window.Swal.fire({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false,
                    icon: 'error',
                    title: 'Incoreect Password!',
                });
            })
        }
        return {
            userStore,
            show1,
            show2,
            show3,
            formData,
            formDetail,
            updateProfile,
            updatePassword,
            nameRules,
            emailRules,
            phoneRules,
            currentRules,
            newRules,
            confirmRules,
            imageUrl,
            fileInput,
            openFileInput,
            handleImageChange,
        };
    }

}
</script>
  
<style>
.v-card-text {
    flex: 1 1 auto;
    font-size: 0.875rem;
    font-weight: 400;
    letter-spacing: 0.0178571429em;
    padding: 3rem;
    text-transform: none;
}

.custom-text-field {
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 20px;
    /* color: black */
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
    top: 89%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    color: black;
    cursor: pointer;
}

.v-input--horizontal .v-input__append {
    margin-inline-start: -28px;
}
</style>
  