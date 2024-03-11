<template>
    <v-navigation-drawer location="left" id="div" v-model="drawer" :rail="rail">
        <span>
            <h3 class="title" v-if="!rail">JOBS</h3>
            <v-avatar v-if="rail">
                <img src="/storage/assets/15.jpg" alt="" />
            </v-avatar>
        </span>
        <v-list>
            <v-list-item v-for="item in items" :key="item.title">
                <a :href="item.href" style="text-decoration: none; color: black;">
                    <v-list-item :class="{ 'v-list-item--active': isActiveItem(item) }" @mouseover="setHoverItem(item)"
                        @mouseleave="clearHoverItem()" :prepend-icon="item.icon">
                        <v-list-item-title v-if="!rail">{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </a>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
    <v-app-bar height="56" id="header">
        <v-app-bar-nav-icon variant="text" @click.stop="rail = !rail"></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <v-menu transition="slide-y-transition">
            <template v-slot:activator="{ props }">
                <v-icon v-bind="props" id="account" size="40">mdi-account-circle</v-icon>
                <v-icon v-bind="props" class="menu" size="35"> mdi-menu-down</v-icon>
            </template>
            <v-list>
                <v-list-item prepend-icon="mdi-account" title="Login as User" value="Login as User" href="/login"
                    class="dropdown"></v-list-item>
                <v-list-item class="dropdown" prepend-icon="mdi-logout" title="Logout" value="Dashboard"
                    @click="logout()"></v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>
  
<script>
import { ref, onMounted } from "vue";
import { useUsersStore } from "@/store/user";
import axios from "axios";

export default {
    name: "navbar-component",
    setup() {
        const usersStore = useUsersStore();

        const users = ref([]);
        const currentRoute = ref(window.location.pathname);
        const drawer = ref(true);
        const rail = ref(false);
        const hoveredItem = ref({
            item: null,
        });
        const requests = ref([]);

        const updateRoute = () => {
            currentRoute.value = window.location.pathname;
        };
        const items = ref([
            {
                title: 'Dashboard',
                icon: 'mdi-view-dashboard',
                href: '/admin/dashboard',
            },
            {
                title: 'Users',
                icon: 'mdi-account',
                href: '/admin/users'
            },
            {
                title: 'Companies',
                icon: 'mdi-office-building',
                href: '/admin/companies',
            },
            {
                title: 'Profile',
                icon: 'mdi-account-circle',
                href: '/admin/profile'
            },
            {
                title: 'Subscription Plans',
                icon: 'mdi-list-box',
                href: '/admin/plans'
            },
        ]);
        const isActiveItem = (item) => {
            return window.location.pathname === item.href;
        };

        const setHoverItem = (item) => {
            hoveredItem.item = item;
        };

        const clearHoverItem = () => {
            hoveredItem.item = null;
        };

        const logout = () => {
            usersStore.isLogOut();
            axios.get("/admin/logout");
            window.location.href = "/job";
        };

        onMounted(() => {
            window.addEventListener("popstate", updateRoute);
        });

        return {
            users,
            usersStore,
            currentRoute,
            drawer,
            rail,
            requests,
            updateRoute,
            logout,
            items,
            isActiveItem,
            setHoverItem,
            clearHoverItem,

        };
    },
};
</script>
<style scoped>
.v-list-item--density-default:not(.v-list-item--nav).v-list-item--one-line {
    padding-inline: 8px;
}

.v-list-item--density-default.v-list-item--one-line {
    min-height: 40px;
    padding-top: 4px;
    padding-bottom: 4px;
}

.v-list-item__prepend>.v-badge~.v-list-item__spacer,
.v-list-item__prepend>.v-icon~.v-list-item__spacer,
.v-list-item__prepend>.v-tooltip~.v-list-item__spacer {
    width: 11px;
}

a {
    text-decoration: none;
}

#logoheading {
    font-size: 35px;
    margin-top: 7px;
    color: black;
    font-family: "Lemon", serif;
    letter-spacing: 2px;
}

.cursor {
    color: black;
    text-decoration: none;
    font-family: "Kanit", sans-serif;
    cursor: pointer;
}

#user {
    margin: 6px;
    font-size: 15px;
    font-family: "Kanit", sans-serif;
    color: #0b0c0c;
    text-transform: capitalize;
}

.dropdown {
    cursor: pointer;
    font-family: "Kanit", sans-serif;
    color: #0a0c0c;
}

.dropdown:hover {
    color: #175e56;
}

.menu {
    color: #030303;
}



#header {
    background-color: #1976D2;
}

.links {
    font-size: 5px;
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 200;
    color: black;
    text-decoration: none;
}

.group {
    font-size: 20px;
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 200;
    color: black;
    text-decoration: none;
}

.main {
    margin-bottom: 0px;
}


.title {
    color: black;
    margin-top: 15px;
    margin-left: 32%;
    font-family: Georgia, "Times New Roman", Times, serif;
}

.v-list-item:hover,
.v-list-item--active {
    background-color: #1976D2;
    color: white;
}

#div {
    background-color: white;
    ;
}
</style>
  
  