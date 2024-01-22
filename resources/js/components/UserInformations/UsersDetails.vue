
<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" sm="12">
                <v-col cols="12" sm="12">
                    <v-row>
                        <v-col cols="24" sm="4">
                            <v-text-field label="Name" v-model="users.name" variant="outlined"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4">
                            <v-text-field label="Email" v-model="users.email" variant="outlined"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4">
                            <v-text-field label="Phone" v-model="users.phone" variant="outlined"></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
export default {
    name: 'UserDetails',
    setup() {
        // const users = ref([]);
        const users = ref({
            name: "",
            email: "",
            phone: "",

        });

        const fetchUsers = () => {
            try {
                axios.get('/getuser').then((response) => {
                    console.log(response.data.data);
                    if (response) {
                        users.value = response.data.data;
                    }
                });
            } catch (err) {
                console.log(err);
            }
        };
        onMounted(() => {
            fetchUsers();
        });

        return {
            fetchUsers,
            users,
        };
    },
};
</script>

<style scoped>
/* v-label {
    font-weight: bold;
}

v-text-field {
    width: 100%;
} */
</style>

