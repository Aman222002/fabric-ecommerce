<template>
  <div>
    <v-card-title class="mb-2"> Address Information </v-card-title>
    <div class="px-4">
      <v-row>
        <v-col>
          <v-text-field
            class="map-input"
            v-model="address.address1"
            :rules="[(v) => !!v || 'Address is required']"
            label="Street address line1"
            id="address1"
            name="address1"
            required
            variant="outlined"
            prepend-inner-icon="mdi-map-marker"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            class="map-input"
            v-model="address.address2"
            label="Street address line2"
            id="address2"
            name="address2"
            variant="outlined"
            prepend-inner-icon="mdi-map-marker"
          ></v-text-field>
        </v-col>
      </v-row>
      <input type="hidden" v-model="address.latitude" id="latitude" />
      <input type="hidden" v-model="address.longitude" id="longitude" />
      <v-row>
        <v-col cols="12" md="6">
          <v-select
            v-model="address.country"
            :items="countries"
            :rules="[(v) => !!v || 'Country is required']"
            item-title="name"
            item-value="isoCode"
            label="Country"
            clearable
            searchable
            placeholder="Select Country"
            variant="outlined"
          ></v-select>
        </v-col>
        <v-col cols="12" md="6">
          <!-- <v-text-field v-model="address.zip_code"
                        :rules="[v => !!v || 'Zip Code is required', v => /^[0-9]{6}$/.test(v) || 'Invalid Zip Code (must be 6 digits and numeric)']"
                        name="Zip_code" label="Zip Code" variant="outlined">
                    </v-text-field> -->
          <v-select
            v-model="address.state"
            :items="filteredStates"
            :rules="[(v) => !!v || 'State is required']"
            item-title="name"
            item-value="isoCode"
            label="State"
            clearable
            searchable
            placeholder="Select State"
            variant="outlined"
          ></v-select>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            v-model="address.city"
            :rules="[(v) => !!v || 'City is required']"
            label="City"
            required
            name="City"
            variant="outlined"
          ></v-text-field>
        </v-col>
        <v-col>
          <!-- <v-select v-model="address.state" :items="filteredStates" :rules="[v => !!v || 'State is required']"
                        item-title="name" item-value="isoCode" label="state" clearable searchable
                        placeholder="Select State"></v-select> -->
          <v-text-field
            v-model="address.zip_code"
            :rules="[(v) => !!v || 'Zip Code is required']"
            name="Zip_code"
            label="Zip Code"
            variant="outlined"
          >
          </v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            v-model="address.county"
            label="County"
            variant="outlined"
          ></v-text-field>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
import { ref, computed } from "vue";
import { useMyStore } from "@/store";
import { Country, State } from "country-state-city";

export default {
  name: "UserAddress",
  setup() {
    const store = useMyStore();
    const address = ref(store.address);

    const countries = Country.getAllCountries().map((country) => ({
      name: country.name,
      isoCode: country.isoCode,
    }));

    const state = State.getAllStates().map((state) => ({
      name: state.name,
      isoCode: state.isoCode,
    }));

    const filteredStates = computed(() => {
      if (address.value.country) {
        return State.getStatesOfCountry(address.value.country).map((state) => ({
          name: state.name,
          isoCode: state.isoCode,
        }));
      } else {
        return [];
      }
    });
    return {
      address,
      countries,
      state,
      filteredStates,
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
