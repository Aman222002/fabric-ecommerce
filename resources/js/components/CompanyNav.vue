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
      <v-list-item
        :class="{ group: true, active: currentRoute === '/company-dashboard' }"
        href="/company-dashboard"
        prepend-icon="mdi-view-dashboard-variant"
        title="Dashboard"
      >
      </v-list-item>
      <v-list-item
        v-if="hasPermission('View Users') || hasrole('Company Admin')"
        :class="{ group: true, active: currentRoute === '/company-users' }"
        href="/company-users"
        prepend-icon="mdi-account"
        title="Users"
      >
      </v-list-item>
      <v-list-group value="Jobs" class="group">
        <template v-slot:activator="{ props }">
          <v-list-item
            v-bind="props"
            prepend-icon="mdi-view-dashboard-outline"
            title="Jobs"
          ></v-list-item>
        </template>
        <!-- <v-list-item v-if="hasPermission('Edit Job') || hasrole('Company Admin')"
          :class="{ main: true, active: currentRoute === '/posted-jobs' }" href="/posted-jobs" title=" My Jobs">
        </v-list-item>
        <v-list-item v-if="hasPermission('Post Job') || hasrole('Company Admin')"
          :class="{ main: true, active: currentRoute === '/postjob' }" href="/postjob" title="Post a Job">
        </v-list-item> -->
        <v-list-item
          v-if="hasPermission('Edit Job') || hasrole('Company Admin')"
          :class="{ main: true, active: currentRoute === '/posted-jobs' }"
          href="/posted-jobs"
          title=" My Jobs"
          prepend-icon="mdi-post"
        >
        </v-list-item>
        <v-list-item
          v-if="hasPermission('Post Job') || hasrole('Company Admin')"
          :class="{ main: true, active: currentRoute === '/postjob' }"
          href="/postjob"
          title="Post a Job"
          prepend-icon="mdi-note-edit"
        >
        </v-list-item>
        <!-- <v-list-item :class="{ 'main': true, 'active': currentRoute === '/draft' }" href="/draft" title="Draft Jobs">
        </v-list-item> -->
      </v-list-group>

      <v-list-item
        v-if="hasPermission('Buy Subscription') || hasrole('Company Admin')"
        :class="{ group: true, active: currentRoute === '/plans' }"
        href="/plans"
        prepend-icon="mdi-format-list-bulleted"
        title="Plans"
      >
      </v-list-item>
      <v-list-item
        v-if="hasPermission('Change Plan') || hasrole('Company Admin')"
        :class="{ group: true, active: currentRoute === '/company/subscription' }"
        href="/company/subscription"
        prepend-icon="mdi-cash-sync"
        title="Subscription details"
      >
      </v-list-item>
      <v-list-item
        :class="{ group: true, active: currentRoute === '/company/profile' }"
        href="/company/profile"
        prepend-icon="mdi-account-circle"
        title="Profile"
      >
      </v-list-item>
      <!-- <v-list-item
        v-if="hasPermission('Create Users') || hasrole('Company Admin')"
        :class="{ group: true, active: currentRoute === '/add-user' }"
        href="/add-user"
        prepend-icon="mdi-account-plus-outline"
        title="Add User"
      >
      </v-list-item> -->
    </v-list>
  </v-navigation-drawer>

  <v-app-bar height="46" id="header">
    <v-app-bar-nav-icon
      variant="text"
      @click.stop="rail = !rail"
      style="color: white"
    ></v-app-bar-nav-icon>
    <v-spacer></v-spacer>
    <v-menu class="log_and_reg_drop" transition="slide-y-transition">
      <template v-slot:activator="{ props }">
        <!-- <v-icon v-bind="props" id="account" size="40"
          >mdi-account-circle</v-icon
        >
        <v-icon v-bind="props" class="menu" size="35"> mdi-menu-down</v-icon> -->

        <v-icon v-bind="props" id="account" size="40" style="color: white"
          >mdi-account-circle</v-icon
        >
        <v-icon v-bind="props" class="menu" size="35" style="color: white">
          mdi-menu-down</v-icon
        >
      </template>

      <v-list>
        <!-- <v-list-item
          prepend-icon="mdi-account"
          title="Login as User"
          value="Login as User"
          href="/login"
          class="dropdown"
        ></v-list-item> -->
        <v-list-item
          v-if="usersStore.isloggedin || employerStore.isloggedin"
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
import { useEmployerStore } from "../store/employer";

import axios from "axios";

export default {
  name: "CompanyNav",
  setup() {
    const usersStore = useUsersStore();
    const employerStore = useEmployerStore();
    const users = ref([]);
    const currentRoute = ref(window.location.pathname);
    const drawer = ref(true);
    const rail = ref(false);

    const requests = ref([]);

    const updateRoute = () => {
      currentRoute.value = window.location.pathname;
    };
    const logout = () => {
      if (usersStore.isloggedin) {
        usersStore.isLogOut();
      } else {
        employerStore.isLogOut();
        employerStore.removePreviousRoute();
      }
      axios.get("/company/logout");
      window.location.href = "/company/login";
    };
    const fetchUserData = async () => {
      try {
        const response = await axios.get("/user/data");
        users.value = response.data;
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };
    const hasPermission = (permission) => {
      if (users.value && users.value.permissions) {
        return users.value.permissions.includes(permission);
      }
      return false;
    };
    const hasrole = (role) => {
      if (users.value && users.value.roles) {
        return users.value.roles.includes(role);
      }
      return false;
    };

    onMounted(() => {
      fetchUserData();
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
      hasPermission,
      hasrole,
      employerStore,
    };
  },
};
</script>
<style >
header.dah_header-bar {
  box-shadow: 0 6px 15px rgba(64, 79, 104, 0.05);
  border-bottom: 1px solid #ecedf2;
  background-color: #0146a6 !important;
  color: #fff !important;
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
  background-color: #0146a6;
  color: #fff;
}

.v-app-bar {
  border-bottom: 1px solid #161414;
}

#header {
  background-color: #0146a6;
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
  text-align: center;
  font-family: Georgia, "Times New Roman", Times, serif;
}

.log_and_reg_drop .v-list {
  width: 160px;
}

#div {
  background-color: white;
}

.log_and_reg_drop .v-list .v-list-item:hover {
  background-color: #0146a6;
  color: #fff;
}
</style>
