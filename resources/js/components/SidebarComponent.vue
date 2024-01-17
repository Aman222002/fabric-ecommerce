<template>
    <v-navigation-drawer v-model="Sidebar_drawer" :dark="SidebarColor !== 'dark'" :color="SidebarColor"
        mobile-break-point="960" clipped :right="$vuetify.rtl" mini-variant-width="70" :expand-on-hover="expandOnHover" app
        id="main-sidebar">
        <v-list dense nav>
            <!---USer Area -->
            <v-list-item two-line class="px-0">
                <v-list-item-avatar>
                    <img src="https://randomuser.me/api/portraits/men/81.jpg" />
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>Dohn Deo</v-list-item-title>
                    <v-list-item-subtitle class="caption">Webdesigner</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <!---USer Area -->
            <!---Sidebar Items -->
            <v-list-item v-for="item in items" :key="item.title" :to="item.to" :active-class="`primary--text`" link>
                <span>
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <a :href="item.href"> {{ item.title }}</a>
                    </v-list-item-title>
                </span>
            </v-list-item>
            <!---Sidebar Items -->
        </v-list>
    </v-navigation-drawer>
</template>
<script>
import { ref, onMounted } from "vue";
export default {
    name: 'SidebarComponent',
    setup() {
        const drawer = ref(true);
        const Sidebar_drawer = ref(true);
        const show_user = ref(false);
        const items = ref([
            {
                title: 'Dashboard',
                icon: 'mdi-view-dashboard',
                to: '/dashboard/basic-dashboard',

            },
            {
                title: 'Users',
                icon: 'mdi-account',
                to: '/admin/user/index',
                href: '/admin/users'
            },
            {
                title: 'Profile',
                icon: 'mdi-account-circle',
            },
            {
                title: 'Alerts',
                icon: 'mdi-alert',
            },
            {
                title: 'Icons',
                icon: 'mdi-emoticon',
            },
            {
                title: 'Basic Table',
                icon: 'mdi-table-column-width',
            },
        ]);
        return {
            drawer, show_user, Sidebar_drawer, items
        }
    },
}
</script>
