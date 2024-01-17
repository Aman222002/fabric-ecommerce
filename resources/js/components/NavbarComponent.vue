<template>
    <v-app-bar app clipped-left clipped-right color="white" light>
        <v-app-bar-nav-icon class="d-block d-md-hemburgur" @click="toggleSidebar" />
        <v-toolbar-title class="align-center d-flex">
            <span class="logo-icon">
                <img src="\storage\assets\logo-icon.png" />
            </span>
            <span class="logo-text ml-2">
                <img src="\storage\assets\logo-text.png" class="mt-2" />
            </span>
        </v-toolbar-title>
        <v-spacer />
        <!---right part -->
        <v-menu bottom left transition="scale-transition">
            <template>
                <v-btn light icon>
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>

            <v-list>
                <v-list-item v-for="(item, i) in userprofile" :key="i" @click="handleItemClick(item)">
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>
<script setup>
import { ref } from 'vue';
// import { EventBus } from '../event-bus';
const toggleSidebar = () => {
    EventBus.value.$emit('toggle-sidebar');
};
</script>