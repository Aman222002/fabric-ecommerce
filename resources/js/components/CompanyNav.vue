<template>
  <v-navigation-drawer
    location="left"
    class="left_side_bar"
    v-model="drawer"
    :rail="rail"
  >
    <h3 class="title" v-if="!rail">JOBS</h3>
    <v-avatar style="margin-left: 10%" v-if="rail">
      <img src="/storage/assest/15.jpg" alt="" />
    </v-avatar>
    <v-list>
      <v-list-group value="Jobs" class="group" v-if="usersStore.isloggedin">
        <template v-slot:activator="{ props }">
          <v-list-item
            v-bind="props"
            prepend-icon="mdi-view-dashboard-outline"
            title="Jobs"
          ></v-list-item>
        </template>
        <v-list-item
          :class="{ main: true, active: currentRoute === '/posted-jobs' }"
          href="/posted-jobs"
          prepend-icon="mdi-bag-checked"
          title=" My Jobs"
        >
        </v-list-item>
        <v-list-item
          :class="{ main: true, active: currentRoute === '/postjob' }"
          href="/postjob"
          prepend-icon="mdi-post"
          title="Post a Job"
        >
        </v-list-item>
      </v-list-group>
      <!-- <v-list-item :class="{ 'group': true, 'active': currentRoute === '/job' }" href="/job" v-if="!usersStore.isloggedin" prepend-icon="mdi-note" title="Post a Job">
       
      </v-list-item> -->
      <v-list-item
        :class="{ group: true, active: currentRoute === '/findcv' }"
        href="/findcv"
        prepend-icon="mdi-magnify"
        title="Find CV"
      >
      </v-list-item>
      <v-list-item
        :class="{ group: true, active: currentRoute === '/product' }"
        href="/product"
        prepend-icon="mdi-format-list-bulleted"
        title="Products"
      >
      </v-list-item>
      <v-list-item
        v-if="usersStore.isloggedin"
        :class="{ group: true, active: currentRoute === '/company/profile' }"
        href="/company/profile"
        prepend-icon="mdi-account-circle"
        title="Profile"
      >
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
  <v-app-bar height="70" id="header" class="dah_header-bar">
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
          v-if="usersStore.isloggedin"
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

    const requests = ref([]);

    const updateRoute = () => {
      currentRoute.value = window.location.pathname;
    };

    const logout = () => {
      usersStore.isLogOut();
      axios.get("/company/logout");
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
    };
  },
};
</script>
<style >
header.dah_header-bar {
  box-shadow: 0 6px 15px rgba(64, 79, 104, 0.05);
  border-bottom: 1px solid #ecedf2;
}
a {
  text-decoration: none;
}
nav.left_side_bar .v-list-group--open {
  margin-bottom: 10px;
}
nav.left_side_bar .v-list-group--open a.v-list-item {
  padding-inline-start: unset !important;
  font-size: 15px;
  padding-left: 13px !important;
}
nav.left_side_bar {
  border-color: transparent;
  box-shadow: -1px 2px 4px -1px;
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

.v-app-bar {
  border-bottom: 1px solid #161414;
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

/* padding: 0 25px; */
</style>

