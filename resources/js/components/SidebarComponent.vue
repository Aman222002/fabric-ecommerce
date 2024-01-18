<template>
    <v-navigation-drawer v-model="Sidebar_drawer">
        <v-list dense nav>
            <!---USer Area -->
            <v-list-item two-line class="px-0">
                <v-avatar>
                    <img src="https://randomuser.me/api/portraits/men/81.jpg" />
                </v-avatar>
                <v-list-item>
                    <v-list-item-title>Dohn Deo</v-list-item-title>
                    <v-list-item-subtitle class="caption">Webdesigner</v-list-item-subtitle>
                </v-list-item>
            </v-list-item>
            <!---USer Area -->
            <!---Sidebar Items -->
            <v-list-item v-for="item in items" :key="item.title" :to="item.to">
                <a :href="item.href" style="text-decoration: none;"><span>
                        <v-list-item>
                            <v-icon>{{ item.icon }}</v-icon>
                            {{ item.title }}
                        </v-list-item>
                    </span></a>
            </v-list-item>
            <!---Sidebar Items -->
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
        const sidebar_event = (payload) => {
            Sidebar_drawer.value = payload;
        };
        onMounted(() => {
            eventBus.on('sidebar-event', sidebar_event);
        });
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
                to: '/admin/profile',
                href: '/admin/profile'
            },
            {
                title: 'Companies',
                icon: 'mdi-office-building',
                to: '/admin/profile',
                href: '/admin/companies'
            },

            {
                title: 'Basic Table',
                icon: 'mdi-table-column-width',
            },
        ]);
        return {
            Sidebar_drawer, items
        }
    },
}
</script>
<style lang="scss">
#main-sidebar {
    box-shadow: 1px 0 20px rgba(0, 0, 0, 0.08);
    -webkit-box-shadow: 1px 0 20px rgba(0, 0, 0, 0.08);

    .v-navigation-drawer__border {
        display: none;
    }

    .v-list {
        padding: 8px 15px;
    }

    .v-list-item {
        min-height: 35px;

        &__icon--text,
        &__icon:first-child {
            justify-content: center;
            text-align: center;
            width: 20px;
        }
    }

    .v-list-item__icon i {
        width: 20px;
    }

    .icon-size .v-list-group__items i {
        width: 16px;
        font-size: 16px;
    }

    .profile-bg {
        &.theme--dark.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
            opacity: 1;
        }

        .v-avatar {
            padding: 15px 0;
        }
    }

    .theme--dark.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
        opacity: 0.5;

        &:hover {
            opacity: 1;
        }
    }
}

.v-list-item--active {
    background-color: red;
}

.theme--dark.v-navigation-drawer {
    background-color: #242a33 !important;
}
</style>
