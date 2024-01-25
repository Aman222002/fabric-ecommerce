
<template>
    <div>
        <v-card-title class="text-left">
            Basic Information
        </v-card-title>
        <v-row>
            <v-col cols="12" sm="10">
                <v-text-field label="Name" v-model="users.name" variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" sm="10">
                <v-text-field label="Email" v-model="users.email" variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" sm="10">
                <v-text-field label="Phone" v-model="users.phone" variant="outlined"></v-text-field>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import { ref, onMounted } from "vue";
import { useMyStore } from "../../store";
export default {
    name: 'UserDetails',
    setup() {
        const store = useMyStore();
        const users = ref(store.userDetails);

        const fetchUsers = () => {
            try {
                axios.get('/getuser').then(({ data }) => {

                    if (data.status) {
                        store.setUser({ name: data.data.name, email: data.data.email, phone: data.data.phone });
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

