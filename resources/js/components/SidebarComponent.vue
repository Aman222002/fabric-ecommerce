<template>
    <v-card>
        <v-navigation-drawer v-model="drawer" id="nav">
            <v-list-item nav prepend-icon="mdi-home" title="Home" id="nav"></v-list-item>
            <v-divider></v-divider>
            <v-list density="compact" nav>
                <v-list-item prepend-icon="mdi-account" title="User" value="User"
                    @click="show_user = !show_user"></v-list-item>
                <v-list-item prepend-icon="mdi-domain" title="Companies" value="about" color="blue"></v-list-item>
            </v-list>
        </v-navigation-drawer>
    </v-card>
    <v-main>
        <AllUser v-if="show_user"></AllUser>
    </v-main>
</template>
<script>
import AllUser from './AllUser.vue';
import { ref } from "vue";
export default {
    name: 'SidebarComponent',
    setup() {
        const drawer = ref(true);
        const show_user = ref(false);
        return {
            drawer, show_user
        }
    },
    components: { AllUser }
}
</script>
<style scoped>
.nav {
    background-color: bs-blue;
}
</style>