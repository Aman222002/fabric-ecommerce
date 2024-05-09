
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
                <v-text-field label="Email" v-model="users.email" name="email" variant="outlined" ></v-text-field>

            </v-col>
            <v-col cols="12">
                <v-text-field label="Phone" v-model="users.phone" name="phone" variant="outlined"></v-text-field>

            </v-col>
            <v-col cols="12">
                <v-file-input label="Image"  name="user_image" variant="outlined" @change="handleImage"></v-file-input>
            </v-col>
           
        </v-row>
    </div>
</template>
<script>
import axios from 'axios';
import { ref, onMounted } from "vue";
import { useMyStore } from "../../store";
export default {
    name: 'UserDetails',
    setup() {
        const store = useMyStore();
        const users = ref(store.userDetails);
        const handleImage = (e)=>{
            console.log( e.target.files[0].name)
            store.userDetails.user_image = e.target.files[0];
            console.log(e)
        }
        return {
            users,
            handleImage,
            
        };
    },
};
</script>

<style scoped></style>

