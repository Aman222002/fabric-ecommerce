<template>
    <v-container class="custom-container">
        <v-btn @click="openDialog">Add User</v-btn>
        <h2 class="text-center">Users List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
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
                        <v-btn color="primary" @click="open_editDialog(user.id)">Edit</v-btn>
                        <v-btn color="error" @click="deleteUser(user.id)">Delete</v-btn>
                    </td>
                    <v-row justify="center">
                        <v-dialog v-model="dialog_edit" width="500">
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">Edit User</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <v-text-field v-model="editFormdata.name" label="Name" :rules="nameRules"
                                                    maxlength="100" class="custom-text-field"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <v-text-field v-model="editFormdata.email" label="Email" :rules="emailRules"
                                                    maxlength="100" class="custom-text-field"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <v-text-field v-model="editFormdata.phone" label="phone" :rules="phoneRules"
                                                    type="phone"></v-text-field><br />
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <small>*indicates required field</small>
                                    <v-card-actions>
                                        <v-btn color="blue-darken-1" variant="text"
                                            @click="close_editDialog()">Close</v-btn>
                                        <v-btn color="blue-darken-1" variant="text"
                                            @click="editUser(editFormdata.id)">Save</v-btn>
                                    </v-card-actions>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-row>
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
                                    <v-text-field v-model="formdata.name" id="name" label="Name" :rules="nameRules"
                                        maxlength="100" class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.email" id="email" label="Email" :rules="emailRules"
                                        maxlength="100" class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.phone" id="phone" label="phone" type="phone"
                                        :rules="phoneRules"></v-text-field><br />
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.password" id="passwoprd" label="Password"
                                        type="password" :rules="passwordRules" maxlength="100"
                                        class="custom-text-field"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field v-model="formdata.confirm_password" id="confirm-password"
                                        label="Confirm Password" type="password"
                                        :rules="[v => !!v || 'Confirm Password is required', v => v === formdata.password || 'Passwords must match']"
                                        maxlength="100" class="custom-text-field"></v-text-field>
                                    <div v-if="passwordMismatch" class="error">Password should match.</div>
                                </v-col>
                            </v-row>
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
    </v-container>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';

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
        const editFormdata = ref({
            name: '',
            email: '',
            phone: '',
        });
        const dialog = ref(false);
        const dialog_edit = ref(false);
        const users = ref({});
        const open_editDialog = (id) => {
            dialog_edit.value = true;
            axios.get(`./user/edit/${id}`)
                .then((response) => {
                    // console.log(response);
                    editFormdata.value = response.data.users;
                }, (error) => {
                    console.log(error);
                });
        };
        const close_editDialog = () => {
            dialog_edit.value = false;
        };
        const openDialog = () => {
            dialog.value = true;

        };
        const closeDialog = () => {
            dialog.value = false;
        };
        const nameRules = ref([
            v => !!v || 'Full Name is required',
            v => (v && v.length >= 3) || 'Full Name must be at least 3 characters',
        ]);
        const emailRules = ref([
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ]);
        const passwordRules = ref([
            v => !!v || 'Password is required',
            v => (v && v.length >= 6) || 'Password must be at least 6 characters',
        ]);
        const phoneRules = ref([
            v => !!v || 'Phone number is required',
            v => (v && v.length >= 10) || 'Phone number must be a valid 10-digit number',
        ]);

        const fetchUser = () => {
            axios.get('./user/index')
                .then(response => {
                    users.value = response.data.users;
                });
        };
        const deleteUser = (id) => {
            window.Swal({
                icon: "success",
                title: "Login Successful!",
                text: "You have successfully logged in.",
            });
            axios.delete(`./user/destroy/${id}`)
                .then(response => {
                    users.value = users.value.filter(user => user.id !== id);
                });
        };
        const editUser = (id) => {
            axios.post(`./user/update/${id}`, editFormdata.value)
                .then(response => {
                    console.log(response);
                })

        };

        const saveUser = () => {
            if (formdata.value.password !== formdata.value.confirm_password) {
                passwordMismatch.value = true;
                return;
            }
            else {
                axios.post(`./user/store`, formdata.value)
                    .then(response => {
                        alert("success");
                    })
                dialog.value = false;
            };
        };
        onMounted(() => {
            fetchUser();
        });
        return {
            formdata,
            editFormdata,
            dialog,
            users,
            close_editDialog,
            open_editDialog,
            dialog_edit,
            openDialog,
            closeDialog,
            passwordMismatch,
            deleteUser,
            editUser,
            saveUser,
            nameRules,
            emailRules,
            passwordRules,
            phoneRules,
        };
    }
}
</script>
<style>
.error {
    color: red;
    margin-top: 5px;
}
</style>