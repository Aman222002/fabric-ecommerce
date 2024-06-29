<template>
  <v-navigation-drawer
    class="left_side_bar"
    location="left"
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
        :href="item.href"
      >
        <v-list-item-title v-if="!rail">{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
  <v-app-bar height="45" id="header" class="dah_header-bar">
    <v-app-bar-nav-icon
      variant="text"
      @click.stop="rail = !rail"
    ></v-app-bar-nav-icon>
    <v-spacer></v-spacer>
    <v-menu transition="slide-y-transition" class="log_and_reg_drop">
      <template v-slot:activator="{ props }">
        <!-- <v-icon v-bind="props" id="account" size="40"
          >mdi-account-circle</v-icon
        > -->
        <span>  <v-img :src="imageUrl" alt="" v-if="imageUrl" style="
    width: 35px;
    border-radius: 15px;
    overflow: hidden;
" />
<v-icon style="
    width: 35px;
    border-radius: 15px;
    overflow: hidden;
" v-else>mdi-account-circle</v-icon></span>

        <v-icon v-bind="props" class="menu" size="35"> mdi-menu-down</v-icon>
      </template>
      <v-list>
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
    const imageUrl = ref();
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
        icon: "mdi-cash-plus",
        href: "/admin/plans",
      },
      {
        title: "Jobs",
        icon: "mdi-gesture-tap-box",
        href: "/admin/jobs",
      },
      {
        title: "Blogs",
        icon: "mdi-post",
        href: "/admin/blog/view",
      },
      {
        title: "Partner",
        icon: "mdi-handshake-outline",
        href: "/admin/parteners",
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
      window.location.href = "/login";
    };
    const fetchProfile = () => {
      axios
        .get("profile/getProfile")
        .then((response) => {
       
          imageUrl.value = response.data.user.user_image;
        })
        .catch((err) => {
          console.log(err);
        });
    };
    onMounted(() => {
      window.addEventListener("popstate", updateRoute);
      fetchProfile();
    });

    return {
      users,
      usersStore,
      currentRoute,
      drawer,imageUrl,
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
  background-color: #0146a6 !important;
  color: #fff !important;
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
  color: #0146a6 !important;
  background: #0146a61a;
}

.main {
  margin-bottom: 0px;
}

.title {
  color: black;
  margin-top: 15px;
  font-family: Georgia, "Times New Roman", Times, serif;
  text-align: center;
}

.v-list-item:hover,
.v-list-item--active {
  color: #0146a6;
  background: #0146a61a;
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
  color: #0146a6;
  background: #0146a61a;
}
.img{
  border-radius: 50%;
}
</style>
