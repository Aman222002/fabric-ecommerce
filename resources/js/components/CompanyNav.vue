<template>
  <v-navigation-drawer location="left" id="div" v-model="drawer" :rail="rail">
    <h3 class="title" v-if="!rail">JOBS</h3>
    <v-avatar style="margin-left: 10%;" v-if="rail">
      <img src="/storage/assest/15.jpg" alt="" />
    </v-avatar>
    <v-list>
      <v-list-group value="Jobs" class="group" v-if="usersStore.isloggedin">
        <template v-slot:activator="{ props }">
          <v-list-item v-bind="props" prepend-icon="mdi-view-dashboard-outline" title="Jobs"></v-list-item>
        </template>
        <v-list-item v-if=" hasPermission('Edit Job')|| hasrole('Company Admin')" :class="{ 'main': true, 'active': currentRoute === '/posted-jobs' }" href="/posted-jobs"
          title=" My Jobs">
        </v-list-item>
        <v-list-item v-if=" hasPermission('Post Job')|| hasrole('Company Admin')" :class="{ 'main': true, 'active': currentRoute === '/postjob' }" href="/postjob" title="Post a Job">
        </v-list-item>
        <!-- <v-list-item :class="{ 'main': true, 'active': currentRoute === '/draft' }" href="/draft" title="Draft Jobs">
        </v-list-item> -->
      </v-list-group>
      
      <v-list-item :class="{ 'group': true, 'active': currentRoute === '/findcv' }" href="/findcv"
        prepend-icon="mdi-magnify" title="Find CV">
      </v-list-item>
      <v-list-item v-if="usersStore.isloggedin && hasPermission('Buy Subscription')|| hasrole('Company Admin')" :class="{ 'group': true, 'active': currentRoute === '/product' }" href="/product"
        prepend-icon="mdi-format-list-bulleted" title="Plans">
      </v-list-item>
      <v-list-item v-if="usersStore.isloggedin && hasPermission('Change Plan')|| hasrole('Company Admin')" :class="{ 'group': true, 'active': currentRoute === '/company/plan' }" href="/company/plan"
        prepend-icon="mdi-cash-sync" title="Subscription details">
      </v-list-item>
      <v-list-item v-if="usersStore.isloggedin && hasPermission('Change Profile')|| hasrole('Company Admin')"
        :class="{ 'group': true, 'active': currentRoute === '/company/profile' }" href="/company/profile"
        prepend-icon="mdi-account-circle" title="Profile">
      </v-list-item>


      <v-list-item v-if="usersStore.isloggedin && hasPermission('create users')|| hasrole('Company Admin')" :class="{ 'group': true, 'active': currentRoute === '/add-user' }"
        href="/add-user" prepend-icon="mdi-account-plus-outline" title="Add User">
      </v-list-item>
      <v-list-item v-if="usersStore.isloggedin && hasPermission('view users')|| hasrole('Company Admin') " :class="{ 'group': true, 'active': currentRoute === '/users' }"
        href="/users" prepend-icon="mdi-account-plus-outline" title="Users">
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
  
  <v-app-bar height="46" id="header">
    <v-app-bar-nav-icon variant="text" @click.stop="rail = !rail"  style="color: white;"></v-app-bar-nav-icon>
    <v-spacer></v-spacer>
    <v-menu transition="slide-y-transition">

      <template v-slot:activator="{ props }">
        <v-icon v-bind="props" id="account" size="40" style="color: white;">mdi-account-circle</v-icon>
        <v-icon v-bind="props" class="menu" size="35" style="color: white;"> mdi-menu-down</v-icon>
      </template>
      <v-list>
        <v-list-item prepend-icon="mdi-account" title="Login as User" value="Login as User" href="/login"
          class="dropdown"></v-list-item>
        <v-list-item v-if="usersStore.isloggedin" class="dropdown" prepend-icon="mdi-logout" title="Logout"
          value="Dashboard" @click="logout()"></v-list-item>
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
    const fetchUserData = async () => {
      try {
        const response = await axios.get("/user/data"); 
      
        users.value = response.data; 
     
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };
    const hasPermission = ( permission) => {
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
      hasPermission,hasrole
    };
  },
};
</script>

<style scoped>
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
  background-color: #1976D2;
}

.v-app-bar {

  border-bottom: 1px solid #161414;
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
.active {
  background-color: #1976D2;
  color: white;
}

#div {
  background-color: white;
  ;
}
</style>
