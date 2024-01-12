<template>
    <div>
        <v-btn @click="addUser()">Add User</v-btn>
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
                    {{ user }}
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <a href="/"><v-btn color="primary" v-model="dialog" @click="dialog = !dialog">Edit</v-btn></a>
                        <v-btn color="error" @click="deleteUser(user.id)">Delete</v-btn>
                    </td>
                </tr>
            </tbody>
        </table>
        <v-row justify="center">
            <v-dialog v-model="dialog" width="500">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">User Profile</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="12" md="12">
                                    <v-text-field label="Legal Name*" required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Email*" required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Password*" type="password" required></v-text-field>
                                </v-col>
                                <v-col cols="8" sm="5">
                                    <v-select :items="['0-17', '18-29', '30-54', '54+']" label="Age*" required></v-select>
                                </v-col>
                                <v-col cols="8" sm="3">
                                    <v-autocomplete
                                        :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                                        label="Interests" multiple></v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-container>
                        <small>*indicates required field</small>
                    </v-card-text>
                    <v-card-actions>

                        <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                            Close
                        </v-btn>
                        <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
 
<script>
export default {
    data() {
        return {
            dialog: false,
            users: {},
        }
    },
    created() {
        axios
            .get('./users')
            .then(response => {
                this.users = response.data.users;
            });
    },
    methods: {
        deleteUser(id) {
            axios
                .delete(`./users/${id}`)
                .then(response => {
                    let i = this.users.map(data => data.id).indexOf(id);
                    this.users.splice(i, 1);
                });
        },
        addUser() {
            axios
                .post(`./users/${id}`, this.FormData)
                .then(response => {
                    let i = this.users.map(data => data.id).indexOf(id);
                    this.users.splice(i, 1);
                });
        }
    }
}
</script>