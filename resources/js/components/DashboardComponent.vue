<template>
    <v-app>
        <Navbar :sidebarVisible="sidebarVisible" :onToggleSidebar="toggleSidebar" />
        <Sidebar :sidebarVisible="sidebarVisible" />
        <v-main>
            <!-- Your main content goes here -->
        </v-main>
    </v-app>
</template>
  
<script>
import { ref } from 'vue';
import Navbar from './components/Navbar.vue';
import Sidebar from './components/Sidebar.vue';

export default {
    name: 'DashboardComponent',
    components: {
        Navbar,
        Sidebar,
    },
    setup() {
        const sidebarVisible = ref(false);

        const toggleSidebar = () => {
            sidebarVisible.value = !sidebarVisible.value;
        };

        return { sidebarVisible, toggleSidebar };
    },
};
</script>