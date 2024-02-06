
<template>
    <div>
        <v-card-title class=" mb-2">
            Basic Information
        </v-card-title>
        <v-row class="px-4">
            <v-col cols="12">
                <v-text-field label="Name" v-model="users.name" name="name" variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-text-field label="Email" v-model="users.email" name="email" variant="outlined"></v-text-field>

            </v-col>
            <v-col cols="12">
                <v-text-field label="Phone" v-model="users.phone" name="phone" variant="outlined"></v-text-field>

            </v-col>
        </v-row>
    </div>
</template>
<script>
import axios from 'axios';
import { ref, onMounted } from "vue";
import { useMyStore } from "../../store";
export default {
    name: 'UsersDetails',
    setup() {
        const store = useMyStore();
        const users = ref(store.userDetails);



        return {
            users,
        };
    },
};
</script>

<style scoped></style>

