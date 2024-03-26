<template>
  <v-navigation-drawer
    location="left"
    class="left_side_bar"
    v-model="drawer"
    :rail="rail"
  >
    <span>
      <h3 class="title" v-if="!rail">JOBS</h3>
      <v-avatar v-if="rail">
        <img src="/storage/assets/15.jpg" alt="" />
      </v-avatar>
    </span>
    <v-list>
      <v-list-item
        :class="{ 'v-list-item--active': isActiveItem(item) }"
        @mouseover="setHoverItem(item)"
        @mouseleave="clearHoverItem()"
        :prepend-icon="item.icon"
        v-for="item in items"
        :key="item.title"
      >
        <a :href="item.href" style="text-decoration: none; color: black">
          <v-list-item-title v-if="!rail">{{ item.title }}</v-list-item-title>
        </a>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
  <v-app-bar height="45" id="header" class="dah_header-bar">
    <v-app-bar-nav-icon
      variant="text"
      @click.stop="rail = !rail"
    ></v-app-bar-nav-icon>
    <v-spacer></v-spacer>
    <v-menu transition="slide-y-transition">
      <template v-slot:activator="{ props }">
        <v-icon v-bind="props" id="account" size="40"
          >mdi-account-circle</v-icon
        >
        <v-icon v-bind="props" class="menu" size="35"> mdi-menu-down</v-icon>
      </template>
      <v-list>
        <v-list-item
          prepend-icon="mdi-account"
          title="Login as User"
          value="Login as User"
          href="/login"
          class="dropdown"
        ></v-list-item>
        <v-list-item
          class="dropdown"
          prepend-icon="mdi-logout"
          title="Logout"
          value="Dashboard"
          @click="logout()"
        ></v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
import { ref, onMounted } from "vue";
import { useUsersStore } from "@/store/user";
import axios from "axios";
export default {
  name: "CompanyNav",
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
        title: "Dashboard",
        icon: "mdi-view-dashboard",
        href: "/admin/dashboard",
      },
      {
        title: "Users",
        icon: "mdi-account",
        href: "/admin/users",
      },
      {
        title: "Companies",
        icon: "mdi-office-building",
        href: "/admin/companies",
      },
      {
        title: "Profile",
        icon: "mdi-account-circle",
        href: "/admin/profile",
      },
      {
        title: "Subscription Plans",
        icon: "mdi-list-box",
        href: "/admin/plans",
      },
      {
        title: "Blogs",
        icon: "mdi-post",
        href: "/admin/blog/view",
      },
      // {
      //   title: "Add New Blog",
      //   icon: "mdi-post",
      //   href: "/admin/add/blog",
      // },
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

<style>
header.dah_header-bar {
  box-shadow: 0 6px 15px rgba(64, 79, 104, 0.05);
  border-bottom: 1px solid #ecedf2;
}

.v-list-item--density-default:not(.v-list-item--nav).v-list-item--one-line {
  padding-inline: 8px;
}

.v-list-item__prepend > .v-badge ~ .v-list-item__spacer,
.v-list-item__prepend > .v-icon ~ .v-list-item__spacer,
.v-list-item__prepend > .v-tooltip ~ .v-list-item__spacer {
  width: 11px;
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

.links {
  font-size: 5px;
  font-family: Georgia, "Times New Roman", Times, serif;
  font-weight: 200;
  color: black;
  text-decoration: none;
}

nav.left_side_bar .v-list--one-line .group {
  font-size: 20px;
  font-family: Georgia, "Times New Roman", Times, serif;
  font-weight: 200;
  color: #696969;
  text-decoration: none;
  border-radius: 7px;
}

nav.left_side_bar .v-list--one-line .group:hover,
nav.left_side_bar .group a.active,
nav.left_side_bar .group.active {
  color: #1967d2;
  background: #1967d21a;
}

.main {
  margin-bottom: 0px;
}

.title {
  color: black;
  margin-top: 15px;
  font-family: Georgia, "Times New Roman", Times, serif;
}

.v-list-item:hover,
.v-list-item--active {
  color: #1967d2;
  background: #1967d21a;
}

nav.left_side_bar .v-list--one-line {
  width: 85%;
  margin: 0 auto;
}
nav.left_side_bar .v-list .v-list-item {
  font-size: 20px;
  font-family: Georgia, "Times New Roman", Times, serif;
  font-weight: 200;
  color: #696969;
  text-decoration: none;
  border-radius: 7px;
}
nav.left_side_bar .v-list .v-list-item.v-list-item--active,
nav.left_side_bar .v-list .v-list-item:hover {
  color: #1967d2;
  background: #1967d21a;
}
</style>
  
  
