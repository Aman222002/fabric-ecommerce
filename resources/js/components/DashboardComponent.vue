<template>
    <v-app>
        <v-layout class="overflow-visible" style="height: 56px;">
            <v-navigation active color="primary">
                <v-btn @click="display = !display">
                    <v-icon>mdi-account</v-icon>
                    Users
                </v-btn>
                <v-btn>
                    <v-icon>mdi-account</v-icon>
                    Providers
                </v-btn>
            </v-navigation>
            <AllUser v-if="display"></AllUser>
        </v-layout>
    </v-app>
</template>
<script >
import AllUser from './AllUser.vue';
export default {
    name: 'DashboardCompoent',
    componenets: {
        AllUser,
    },
    data() {
        return {
            display: false,
        }
    },
    components: { AllUser }
}
</script>