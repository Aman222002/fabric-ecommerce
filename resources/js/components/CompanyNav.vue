<template>
  <v-app-bar app class="custom-app-bar" color="primary">
   
      <v-row align="center" justify="space-between">
        <v-col class="nav-links">
          <a href="/job" class="nav-link" :class="{ 'active': isActive('/job') }">Post a Job</a>
          <a href="/findcv" class="nav-link" :class="{ 'active': isActive('/findcv') }">Find CVs</a>
          <a href="/product" class="nav-link" :class="{ 'active': isActive('/product') }">Products</a>
          
          <a href="/resource" class="nav-link" :class="{ 'active': isActive('/resource') }">Resources</a>
          
        </v-col>
        <v-btn  v-if="usersStore.isloggedin" @click="logout()" style="margin-top: 10px;">Logout</v-btn>
      </v-row>
    
  </v-app-bar>
</template>

<script>
import { reactive, onMounted } from 'vue';
import { useUsersStore } from "../store/user";

export default {
  name: "CompanyNav",
  setup() {
    const usersStore = useUsersStore();
    const state = reactive({
      activeLink: window.location.pathname
    });

    
    onMounted(() => {
      state.activeLink = window.location.pathname;
    });

    const isActive = (link) => {
      return state.activeLink === link;
    };
    const logout = () => {
      usersStore.isLogOut();
      window.location.href = '/job';
    };
    return {
      isActive,
      logout,
      usersStore
    };
  },
};
</script>

<style scoped>
.custom-app-bar {
  height: 80px;
}

.nav-links {
  display: flex;
  align-items: center;
}

.nav-link,
.btn-dashboard {
  text-decoration: none;
  color: inherit;
  margin-right: 20px;
  cursor: pointer;
  font-weight: bold;
  font-size: 18px;
  transition: color 0.3s ease-in-out;
}

.btn-dashboard {
  border-radius: 4px;
  margin-left: 10px;
  transition: background 0.3s ease-in-out;
}

.outlined {
  border: 1px solid transparent;
}

.btn-dashboard:hover {
  background: linear-gradient(45deg, #ca82e9, #8b8488);
}

.v-app-bar {
  /* background-color: #236aee; */
  border-bottom: 1px solid #161414;
}

.nav-link:hover {
  color: #ca82e9;
}

.active {
  color: #ca82e9;
}
</style>
