<template>
    <v-app-bar app clipped-left clipped-right color="white" light>
        <v-toolbar-title class="align-center d-flex">
            <span class="logo-icon">
                <img src="@/assets/logo-icon.png" />
            </span>
            <span class="logo-text ml-2">
                <img src="@/assets/logo-text.png" class="mt-2" />
            </span>
        </v-toolbar-title>
        <v-app-bar-nav-icon class="d-block d-md-none" @click="toggleSidebar" />
        <v-spacer />
        <!---right part -->
        <v-btn dark color="primary" class="elevation-0"
            href="https://www.wrappixel.com/templates/adminpro-vuetify-dashboard/">Upgrade to Pro</v-btn>
        <v-menu bottom left transition="scale-transition">
            <template v-slot:activator="{ on }">
                <v-btn light icon v-on="on">
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
  
<script>
import { ref } from 'vue';

export default {
    name: 'Header',
    props: {
        value: {
            type: Boolean,
            default: false,
        },
    },
    setup(props) {
        const userprofile = ref([
            { title: "My Profile" },
            { title: "My Balance" },
            { title: "Inbox" },
            { title: "Account Setting" },
            { title: "Logout" },
        ]);

        const toggleSidebar = () => {
            if (isSmallScreen()) {
                // Call your logic to toggle the sidebar
            } else {
                // Emit the input event to toggle the sidebar in parent component
                props.$emit('input', !props.value);
            }
        };

        const handleItemClick = (item) => {
            // Implement logic for handling menu item clicks
            // For example, navigate to a specific route or perform an action
        };

        const isSmallScreen = () => {
            // Replace this with your own logic to determine if it's a small screen
            // You can use $vuetify.breakpoint or window.innerWidth, etc.
            return window.innerWidth <= 600; // Adjust the breakpoint as needed
        };

        return { userprofile, toggleSidebar, handleItemClick };
    },
};
</script>
  