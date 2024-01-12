<template>
    <v-container>
        <div class="div1">
            <h1>User Profile</h1>
            <h2>Personal Information</h2>
        </div>
        <v-form ref="form" @submit.prevent="submitForm">
            <v-row align="center" justify="center">
                <div class="div1">
                    <v-col>
                        <v-avatar size="150">
                            <v-img v-if="form.profileImage" :src="form.profileImage"
                                :alt="`Profile Image - ${form.name}`"></v-img>
                            <v-icon :icon="`mdiSvg:${mdiPencil}`"></v-icon>
                        </v-avatar>
                        <input type="file" @change="handleImageChange" accept="image/*" />
                    </v-col>
                </div>
            </v-row>
            <!-- Name Input -->
            <v-row>
                <v-col>
                    <v-text-field v-model="form.name" label="Name" required :rules="nameRules"></v-text-field>
                    <v-text-field v-model="form.lastName" label="Last Name" required :rules="nameRules"></v-text-field>
                </v-col>
            </v-row>

            <!-- Last Name Input -->
            <!-- <v-row>
                <v-col>
                    <v-text-field v-model="form.lastName" label="Last Name" required :rules="nameRules"></v-text-field>
                </v-col>
            </v-row> -->

            <!-- Email Input -->
            <v-row>
                <v-col>
                    <v-text-field v-model="form.email" label="Email" required :rules="emailRules"></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-row>
                        <v-col>
                            <v-select v-model="form.countryCode" :items="countryCodes" label="Country Code"></v-select>
                        </v-col>
                        <v-col>
                            <v-text-field v-model="form.phone" label="Phone" required :rules="phoneRules"></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <!-- Submit Button -->
            <v-row>
                <v-col>
                    <v-btn type="submit" color="primary">Save</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </v-container>
    <v-container>
        <div class="div1">
            <h2>Password and Security</h2>
        </div>
        <v-form ref="form" @submit.prevent="submitForm">
            <!-- Current Password Input -->
            <v-row>
                <v-col>
                    <v-text-field v-model="form.currentPassword" label="Current Password" type="password" required
                        :rules="currentPasswordRules"></v-text-field>
                </v-col>
            </v-row>

            <!-- New Password Input -->
            <v-row>
                <v-col>
                    <v-text-field v-model="form.newPassword" label="New Password" type="password" required
                        :rules="newPasswordRules"></v-text-field>
                </v-col>
            </v-row>

            <!-- Confirm Password Input -->
            <v-row>
                <v-col>
                    <v-text-field v-model="form.confirmPassword" label="Confirm Password" type="password" required
                        :rules="confirmPasswordRules"></v-text-field>
                </v-col>
            </v-row>

            <!-- Submit Button -->
            <v-row>
                <v-col>
                    <v-btn type="submit" color="primary">Save</v-btn>
                </v-col>
            </v-row>
        </v-form>

    </v-container>
</template>
  
<script>
export default {
    data() {
        return {
            form: {
                name: '',
                lastName: '',
                email: '',
                currentPassword: '',
                newPassword: '',
                confirmPassword: '',

                profileImage: null,
                countryCode: '+1',
                phone: '',

            },
            countryCodes: [
                '+1 (US)',
                '+44 (UK)',
                '+91 (INDIA)',
                // Add more country codes as needed
            ],

        };
    },
    computed: {
        nameRules() {
            return [
                (v) => !!v || 'Name is required',
                (v) => /^[a-zA-Z ]*$/.test(v) || 'Name must only contain letters and spaces',
            ];
        },
        emailRules() {
            return [
                (v) => !!v || 'E-mail is required',
                (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ];
        },
        phoneRules() {
            return [
                (v) => !!v || 'Phone number is required',
                (v) => /^\d{10}$/.test(v) || 'Phone number must be 10 digits',
            ];
        },
        currentPasswordRules() {
            return [
                (v) => !!v || 'Current Password is required',
            ];
        },
        newPasswordRules() {
            return [
                (v) => !!v || 'New Password is required',
                (v) => v.length >= 8 || 'New Password must be at least 8 characters',
            ];
        },
        confirmPasswordRules() {
            return [
                (v) => !!v || 'Confirm Password is required',
                (v) => v === this.form.newPassword || 'Passwords do not match',
            ];
        },


    },
    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {
                // Form is valid, you can submit the data or perform other actions
                console.log('Form submitted:', this.form);
            } else {
                console.log('Form validation failed');
            }
        },
        handleImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.form.profileImage = reader.result;
                };
                reader.readAsDataURL(file);
            }
        },
    },
};
</script>
import {
    mdiPencil,
}
<style scoped>
.div1 {
    text-align: center;
}

.v-text-field:hover {
    background-color: #e0f7fa;
    /* Change to your desired hover color */
}

/* Add custom styles if needed */
</style>
  