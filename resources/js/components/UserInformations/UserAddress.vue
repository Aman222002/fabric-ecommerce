<template>
    <v-container class="container-center">

        <v-card-text>
            <v-form ref="form" @submit.prevent="submitForm">
                <v-row align="center" justify="center">
                    <v-col cols="12" md="6">
                        <v-text-field v-model="address1" :rules="[v => !!v || 'Address is required']"
                            label="Permanent address" required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="address2" label="Correspondence Address"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-btn @click="getGeolocation">Get Geolocation</v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="latitude" label="Latitude"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="longitude" label="Longitude"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="city" :rules="[v => !!v || 'City is required']" label="City"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="state" :rules="[v => !!v || 'State is required']" label="State"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="zip_code"
                            :rules="[v => !!v || 'Zip Code is required', v => /^\d{5}$/.test(v) || 'Invalid Zip Code']"
                            label="Zip Code"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="country" :rules="[v => !!v || 'Country is required']" label="Country"
                            required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="county" label="County"></v-text-field>
                    </v-col>
                </v-row>
                <v-btn type="submit">Save Address</v-btn>
            </v-form>
        </v-card-text>

    </v-container>
</template>
  
<script>
import { ref } from 'vue';
export default {
    name: "UserAddress",
    setup() {
        const address1 = ref("");
        const address2 = ref("");
        const latitude = ref("");
        const longitude = ref("");
        const city = ref("");
        const state = ref("");
        const zip_code = ref("");
        const country = ref("");
        const county = ref("");

        const getGeolocation = () => {
            navigator.geolocation.getCurrentPosition((position) => {
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;
            });
        };

        const submitForm = () => {
            const formData = {
                address1: address1.value,
                address2: address2.value,
                latitude: latitude.value,
                longitude: longitude.value,
                city: city.value,
                state: state.value,
                zip_code: zip_code.value,
                country: country.value,
                county: county.value,
            };
            axios.post('/user-address', formData)
                .then(response => {
                    // Handle successful response
                })
                .catch(error => {
                    // Handle validation errors or other errors
                    if (error.response && error.response.status === 422) {
                        // Handle validation errors, e.g., display them to the user
                        console.log(error.response.data); // Log validation errors
                    } else {
                        // Handle other errors
                        console.error(error.message);
                    }
                });
        }
        //     axios.post('/user-address', formData)
        //         .then(response => {
        //             console.log(formData);
        //             // Handle success, e.g., show a success message
        //             console.log('Form submitted successfully', response.data);
        //         })
        //         .catch(error => {
        //             // Handle error, e.g., show an error message
        //             console.error('Error submitting form', error);
        //         });
        // };


        return {
            address1,
            address2,
            latitude,
            longitude,
            city,
            state,
            zip_code,
            country,
            county,
            getGeolocation,
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