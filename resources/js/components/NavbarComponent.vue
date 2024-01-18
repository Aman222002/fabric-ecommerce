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
        <v-menu class="profile">
            <template v-slot:activator="{ props }">
                <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
            </template>

            <v-list>
                <v-list-item v-for="(item, i) in items" :key="i">
                    <v-btn>
                        <a :href="item.href" style="text-decoration: none;"><span>
                                <v-list-item>
                                    <v-icon>{{ item.icon }}</v-icon>
                                    {{ item.title }}
                                </v-list-item>
                            </span></a>
                    </v-btn>
                </v-list-item>
            </v-list>
        </v-menu>

        <!-- <v-list>
            <v-list-item v-for="(item, i) in userprofile" :key="i" @click="handleItemClick(item)">
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
        </v-list>
        </v-menu> -->
    </v-app-bar>
</template>
<script >
import { ref } from 'vue';
import eventBus from '../eventBus.js';
export default {
    name: 'NavbarComponent',
    setup() {
        const items = ref([
            {
                title: 'Profile',
                icon: 'mdi-account',
                href: '/admin/profile',
            },
            {
                title: 'Logout',
                icon: 'mdi-logout'
            },
        ]);
        const Sidebar = ref(false);
        const toggleSidebar = () => {
            Sidebar.value = !Sidebar.value;
            eventBus.emit('sidebar-event', Sidebar.value);
        };
        return {
            Sidebar, toggleSidebar, items
        };
    },
};
</script>
<style scoped>
.profile {
    margin-right: 5px;
}
</style>