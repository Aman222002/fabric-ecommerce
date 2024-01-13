<template>
    <v-layout>
        <v-card>
            <v-navigation-drawer v-model="drawer">
                <v-list-item nav prepend-icon="mdi-home" title="Home"></v-list-item>
                <v-divider></v-divider>
                <v-list density="compact" nav>
                    <v-list-item prepend-icon="mdi-account" title="User" value="User" @click.stop="show_user = !show_user"
                        :disabled="show_user"></v-list-item>
                    <v-list-item prepend-icon="mdi-domain" title="Companies" value="about" color="blue"></v-list-item>
                </v-list>
            </v-navigation-drawer>
        </v-card>
        <v-main>
            <AllUser v-if="show_user"></AllUser>
        </v-main>
    </v-layout>
</template>
<script>
import AllUser from './AllUser.vue';
import { ref } from "vue";
export default {
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