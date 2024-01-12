<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer v-model="drawer">
                <v-list-item nav prepend-icon="mdi-home" title="Home"></v-list-item>
                <v-divider></v-divider>
                <v-list density="compact" nav>
                    <v-list-item prepend-icon="mdi-account" title="User" value="User" @click.stop="show_user = !show_user"
                        :disabled="show_user"></v-list-item>
                    <v-list-item prepend-icon="mdi-domain" title="Companies" value="about" color="blue"></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main>
                <AllUser v-if="show_user"></AllUser>
            </v-main>
        </v-layout>
    </v-card>
</template>
<script>
import AllUser from './AllUser.vue';
export default {
    data() {
        return {
            drawer: true,
            show_user: false,
        };
    },
    components: { AllUser }
}
</script>