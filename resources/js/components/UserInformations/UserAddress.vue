<template>
    <v-card-title>
        Address Information
        <div>
            <v-row>
                <v-col md="6">
                    <v-text-field class="map-input" v-model="address.address1" :rules="[v => !!v || 'Address is required']"
                        label="Street address line1" id="address1" required variant="outlined"
                        prepend-inner-icon="mdi-map-marker"></v-text-field>
                </v-col>
                <v-col md="6">
                    <v-text-field class="map-input" v-model="address.address2" label="Street address line2" id="address2"
                        variant="outlined" prepend-inner-icon="mdi-map-marker"></v-text-field>
                </v-col>
            </v-row>
            <input type="hidden" v-model="address.latitude" id="latitude" />
            <input type="hidden" v-model="address.longitude" id="longitude" />
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field v-model="address.city" :rules="[v => !!v || 'City is required']" label="City" required
                        variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field v-model="address.state" :rules="[v => !!v || 'State is required']" label="State" required
                        variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field v-model="address.zip_code"
                        :rules="[v => !!v || 'Zip Code is required', v => /^\d{5}$/.test(v) || 'Invalid Zip Code']"
                        label="Zip Code" variant="outlined"></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field v-model="address.country" :rules="[v => !!v || 'Country is required']" label="Country"
                        required variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="address.county" label="County" variant="outlined"></v-text-field>
                </v-col>
            </v-row>

        </div>
    </v-card-title>
</template>
  
<script>
import { ref } from 'vue';
import { useMyStore } from '@/store';
export default {
    name: "UserAddress",
    setup() {
        const myStore = useMyStore();
        const address = ref(myStore.address)
        const userDetails = ref(myStore.userDetails);
        return {
            address,
            userDetails
        };
    },
    methods: {
        submitForm() {
            const formData = {
                address: myStore.address,
                name: myStore.name,
                email: myStore.email,
                phone: myStore.phone,
            };
            axios.post('/user-address', formData)
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
    }
};
</script>
  
<style scoped>
.container-center {
    display: flex;
    justify-content: center;
    align-items: center;

}
</style>
