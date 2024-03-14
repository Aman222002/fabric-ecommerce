<!-- <template>
    <v-navigation-drawer v-model="Sidebar_drawer">
        <v-list dense nav>
            <v-list-item two-line class="px-0">
                <v-avatar>
                    <img src="https://randomuser.me/api/portraits/men/81.jpg" />
                </v-avatar>
                <v-list-item>
                    <v-list-item-title>Dohn Deo</v-list-item-title>
                    <v-list-item-subtitle class="caption">Webdesigner</v-list-item-subtitle>
                </v-list-item>
            </v-list-item>
            <v-list-item v-for="item in items" :key="item.title">
                <a :href="item.href" style="text-decoration: none; color: black;">
                    <v-list-item :class="{ 'v-list-item--active': isActiveItem(item) }" @mouseover="setHoverItem(item)"
                        @mouseleave="clearHoverItem()">
                        <v-icon>{{ item.icon }}</v-icon>
                        {{ item.title }}
                    </v-list-item>
                </a>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>
  
<script>
import { ref, onMounted } from "vue";
import eventBus from '../eventBus.js';

export default {
    name: 'SidebarComponent',
    setup() {
        const Sidebar_drawer = ref();
        const hoveredItem = ref({
            item: null,
        });

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

        const toggleSubMenu = (item) => {
            item.menuVisible = !item.menuVisible;
        };

        onMounted(() => {
            eventBus.on('sidebar-event', (payload) => {
                Sidebar_drawer.value = payload;
            });
        });

        return {
            Sidebar_drawer,
            items,
            isActiveItem,
            hoveredItem,
            setHoverItem,
            clearHoverItem,
            toggleSubMenu,
        };
    },
};
</script>
  
<style scoped>
#main-sidebar {
    box-shadow: 1px 0 20px rgba(101, 117, 163, 0.08);
    -webkit-box-shadow: 1px 0 20px rgba(106, 159, 228, 0.08);

    .v-navigation-drawer__border {
        display: none;
    }

    .v-list {
        padding: 8px 15px;
    }

    .v-list-item__icon i {
        width: 20px;
    }

    .icon-size .v-list-group__items i {
        width: 16px;
        font-size: 16px;
    }
}

.v-list-item:hover,
.v-list-item--active {
    background-color: #1976D2;
    color: white;
}
</style>
   -->
<template>
  <div>hello</div>
</template>