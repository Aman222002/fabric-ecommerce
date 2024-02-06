<template>
    <div>
        <v-card-title class=" mb-2">
            Address Information
        </v-card-title>
        <div class="px-4">
            <v-row>
                <v-col>
                    <v-text-field class="map-input" v-model="address.address1" :rules="[v => !!v || 'Address is required']"
                        label="Street address line1" id="address1" name="address1" required variant="outlined"
                        prepend-inner-icon="mdi-map-marker"></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field class="map-input" v-model="address.address2" label="Street address line2" id="address2"
                        name="address2" variant="outlined" prepend-inner-icon="mdi-map-marker"></v-text-field>
                </v-col>
            </v-row>
            <input type="hidden" v-model="address.latitude" id="latitude" />
            <input type="hidden" v-model="address.longitude" id="longitude" />
            <v-row>
                <v-col>
                    <v-text-field v-model="address.city" :rules="[v => !!v || 'City is required']" label="City" required
                        name="city" variant="outlined"></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field v-model="address.state" :rules="[v => !!v || 'State is required']" label="State" required
                        name="state" variant="outlined"></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field v-model="address.county" label="County" variant="outlined"></v-text-field>

                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-select v-model="address.country" :items="countries" :rules="[v => !!v || 'Country is required']"
                        item-title="country_name" item-value="id" label="country" clearable searchable></v-select>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="address.zip_code"
                        :rules="[v => !!v || 'Zip Code is required', v => /^[0-9]{6}$/.test(v) || 'Invalid Zip Code (must be 6 digits and numeric)']"
                        name="Zip_code" label="Zip Code" variant="outlined">
                    </v-text-field>
                </v-col>
            </v-row>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { countries } from "../../utils/countries"
import { ref, onMounted } from 'vue';
import { useMyStore } from '@/store';

export default {
    name: "UserAddress",
    setup() {
        const store = useMyStore();
        const address = ref(store.address);
        const countriesList = ref(countries);
        onMounted(() => {
            try {
                axios.get('/getcountry').then(({ data }) => {
                    console.log(data.countries, "dbvdbgvcdgcvg")
                    countries.value = data.countries ?? [];

                });
            } catch (err) {
                console.log(err);
            }
        });


        return {
            address,
            countries: countriesList,
        };
    },

};
</script>
  
<style scoped>
.container-center {
    display: flex;

    align-items: center;

}
</style>
