<template>
    <div>
        <v-btn @click="openDialog">Add User</v-btn>
        <h2 class="text-center">Users List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>
                        <a href="/">
                            <v-btn color="primary" @click="editUser(user)">Edit</v-btn>
                        </a>
                        <v-btn color="error" @click="deleteUser(user.id)">Delete</v-btn>
                    </td>
                </tr>
            </tbody>
        </table>
        <v-row justify="center">
            <v-dialog v-model="dialog" width="500">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Add User</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.name" label="Name"
                                        :rules="[v => !!v || 'Name is required']" maxlength="100"
                                        class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.email" label="Email"
                                        :rules="[v => !!v || 'Email is required', v => /.+@.+\..+/.test(v) || 'Email must be valid']"
                                        maxlength="100" class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <vue-tel-input v-model="formdata.phone" mode="international"></vue-tel-input>
                                    <br />
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.password" label="Password" type="password"
                                        :rules="[v => !!v || 'Password is required']" maxlength="100"
                                        class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.confirm_password" label="Confirm Password"
                                        type="password"
                                        :rules="[v => !!v || 'Confirm Password is required', v => v === password || 'Passwords must match']"
                                        maxlength="100" class="custom-text-field"></v-text-field>
                                    <div v-if="passwordMismatch" class="error">Passwords do not match.</div>
                                </v-col>
                            </v-row>
                            <!-- Your form fields go here -->
                        </v-container>
                        <small>*indicates required field</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="blue-darken-1" variant="text" @click="closeDialog">Close</v-btn>
                        <v-btn color="blue-darken-1" variant="text" @click="saveUser">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <v-row justify="center">
            <v-dialog v-model="dialog_edit" width="500">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Add User</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.name" label="Name"
                                        :rules="[v => !!v || 'Name is required']" maxlength="100"
                                        class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.email" label="Email"
                                        :rules="[v => !!v || 'Email is required', v => /.+@.+\..+/.test(v) || 'Email must be valid']"
                                        maxlength="100" class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <vue-tel-input v-model="formdata.phone" mode="international"></vue-tel-input>
                                    <br />
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'AllUser',
    setup() {
        const passwordMismatch = ref(false);
        const formdata = ref({
            name: '',
            email: '',
            phone: '',
            password: '',
            confirm_password: '',
        });
        const dialog = ref(false);
        const dialog_edit = ref(false);
        const users = ref({});

        const openDialog = () => {
            dialog.value = true;

        };
        const closeDialog = () => {
            dialog.value = false;
        };

        const deleteUser = (id) => {
            axios.delete(`./users/${id}`)
                .then(response => {
                    users.value = users.value.filter(user => user.id !== id);
                    let i = this.users.map(data => data.id).indexOf(id);
                    users.value.splice(i, 1);
                });
        };

        const editUser = (user) => {
            // Handle editing logic here
            dialog_edit.value = true;

        };

        const saveUser = () => {
            if (formdata.value.password !== formdata.value.confirm_password) {
                passwordMismatch.value = true;
                return;
            }
            else {
                axios.post(`./user/store`, formdata.value)
                    .then(response => {
                        console.log(data);
                        alert("success");
                    })
            }
        };

        return {
            formdata,
            dialog,
            users,
            dialog_edit,
            openDialog,
            closeDialog,
            passwordMismatch,
            deleteUser,
            editUser,
            saveUser,
        };
    },
    onCreated() {
        axios.get('./users')
            .then(response => {
                users.value = response.data.users;
            });
    },
};
</script>
<style>
.error {
    color: red;
    margin-top: 5px;
}
</style>