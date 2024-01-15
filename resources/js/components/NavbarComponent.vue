<template>
    <v-card class="mx-auto" max-width="448">
        <v-app-bar color="dark" density="compact">
            <template v-slot:prepend>
                <v-app-bar-nav-icon color="white"></v-app-bar-nav-icon>
            </template>
            <v-app-bar-title style="color:azure">Admin</v-app-bar-title>
            <template v-slot:append>
                <v-btn icon="mdi-dots-vertical"></v-btn>
            </template>
        </v-app-bar>
    </v-card>
</template>
<script>
import { ref } from "vue";
export default {
    name: 'NavbarComponent',
    setup() {
    },
}
</script>
