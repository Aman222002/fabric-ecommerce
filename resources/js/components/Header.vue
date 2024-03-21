<template>
  <v-toolbar app fixed class="toolbar nav_bar custom-app-bar header_bar">
    <v-container>
      <v-row align="center" justify="space-between">
        <v-col class="nab_burger_menu">
          <button class="burger_menu" @click="showSection()">
            <v-icon @click="showMenu = !showMenu" icon>{{
            !showMenu ? "mdi-menu" : "mdi-menu"
          }}</v-icon>
          </button>
          <mySection class="NavBar" v-show="isOpen">
            <button class="close_btn" @click="showSection()">
              <v-icon @click="showMenu = !showMenu" icon>{{
            !showMenu ? "mdi-close" : "mdi-close"
          }}</v-icon>

            </button>
            <v-row>
              <v-col class="nav-links">
                <a href="/" class="nav-link" :class="{ active: isActive('/') }">Home</a>
                <a href="/jobs-detail" class="nav-link" :class="{ active: isActive('/jobs-detail') }">Jobs</a>
                <a href="/about" class="nav-link" :class="{ active: isActive('/about') }">About</a>
                <a href="/contact" class="nav-link" :class="{ active: isActive('/contact') }">Contact</a>
                <a href="/job-apply" v-if="usersStore.isloggedin" class="nav-link"
                  :class="{ active: isActive('/job-apply') }">Jobs Applied</a>
                <a href="/savedjobs" v-if="usersStore.isloggedin" class="nav-link"
                  :class="{ active: isActive('/savedjobs') }">Jobs Saved</a>
                <a href="/userprofile" v-if="usersStore.isloggedin" class="nav-link"
                  :class="{ active: isActive('/userprofile') }">Profile</a>
              </v-col>
            </v-row>
          </mySection>
        </v-col>

        <v-menu class="log_and_reg" v-if="!usersStore.isloggedin && !employerStore.isloggedin">
          <template v-slot:activator="{ props }">
            <a href="#" class="nav-link" v-bind="props" :class="{ active: isActive('#') }"
              style="margin-right: 40px">Login <v-icon color="white">mdi-login</v-icon></a>
          </template>

          <ul>
            <li v-for="(item, i) in loginItems" :key="i">
              <a :href="item.href" style="text-decoration: none">
                <v-icon>{{ item.icon }}</v-icon>
                {{ item.title }}
              </a>
            </li>
          </ul>
        </v-menu>

        <v-menu class="log_and_reg" v-if="!usersStore.isloggedin && !employerStore.isloggedin">
          <template v-slot:activator="{ props }">
            <a href="#" class="nav-link" v-bind="props" :class="{ active: isActive('#') }"
              style="margin-right: 40px">Register <v-icon color="white">mdi-account-plus</v-icon></a>
          </template>

          <ul>
            <li v-for="(item, i) in registerItems" :key="i">
              <a :href="item.href" style="text-decoration: none">
                <v-icon>{{ item.icon }}</v-icon>
                {{ item.title }}
              </a>
            </li>
          </ul>
        </v-menu>

        <v-menu class="profile user_drop_down" v-if="usersStore.isloggedin || employerStore.isloggedin"
          transition="slide-x-transition">
          <template v-slot:activator="{ props }">
            <span style="margin-right: 20px">
              <v-btn icon="mdi-account" v-bind="props"></v-btn></span>
          </template>

          <v-list>
            <v-list-item v-for="(item, i) in items" :key="i">
              <v-btn @click="logout(item.title)">
                <a :href="item.href" style="text-decoration: none">
                  <v-icon>{{ item.icon }}</v-icon> {{ item.title }}
                </a>
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-row>
    </v-container>
  </v-toolbar>
</template>

<script>
import { ref } from "vue";
import { reactive, onMounted } from "vue";
import { useUsersStore } from "../store/user";

import axios from "axios";
import { useEmployerStore } from "../store/employer";

export default {
  name: "Header",
  setup() {
    const user = ref([]);
    const items = ref([
      {
        title: "Logout",
        icon: "mdi-logout",
      },
    ]);
    const loginItems = ref([
      {
        title: "Login as User",
        icon: "mdi-login",
        href: "/login",
      },
      {
        title: "Login as Company",
        icon: "mdi-office-building",
        href: "/job",
      },
    ]);
    const registerItems = ref([
      {
        title: "Register as User",
        icon: "mdi-account-plus",
        href: "/registration",
      },
      {
        title: "Register as Company",
        icon: "mdi-account-plus",
        href: "/company/register",
      },
    ]);
    const usersStore = useUsersStore();
    const employerStore = useEmployerStore();
    const state = reactive({
      activeLink: window.location.pathname,
    });

    onMounted(() => {
      state.activeLink = window.location.pathname;
    });
    const isActive = (link) => {
      return state.activeLink === link;
    };

    const logout = (item) => {
      if (item === "Logout") {
        axios.get("/logout").then((response) => {
          console.log(response.data);
          if (response.data.status === true) {
            console.log("changed");
            if (usersStore.isloggedin) {
              usersStore.isLogOut();
            } else {
              employerStore.isLogOut();
              employerStore.removePreviousRoute();
            }
            window.location.href = "/";
          }
        });
      } else {
        console.log("not found");
      }
    };

    return {
      isActive,
      logout,
      usersStore,
      items,
      user,
      loginItems,
      employerStore,
      showMenu: false,
      registerItems,
    };
  },

  data() {
    return {
      sideNav: false,
      loggedIn: true,
      isOpen: false,
      show: false,
    };
  },
  methods: {
    showSection() {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>

<style scoped>
.custom-app-bar {
  height: 65px;
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
  background: linear-gradient(45deg, #1967d2, #8b8488);
}

.v-app-bar {
  border-bottom: 1px solid #161414;
}

header.header_bar a.nav-link:hover i {
  color: #1967d2 !important;
}

.v-list-item a {
  text-decoration: none;
  color: black;
}

.v-btn {
  cursor: pointer;
}

header.header_bar a.nav-link i {
  color: #000 !important;
}

.log_and_reg ul {
  width: 230px;
  background: #fff;
  margin: 5px 0;
}

.log_and_reg ul li {
  margin: 5px 5px;
}

.log_and_reg ul li a {
  width: 100%;
  height: 100%;
  display: table;
  padding: 15px 15px;
  background: #e2eaf8;
  color: #1967d2;
}

.log_and_reg ul li:hover a {
  background: #1967d2;
  color: #fff;
}

@media screen and (min-width: 1201px) {
  .nab_burger_menu button.burger_menu {
    display: none;
  }

  .NavBar button.close_btn {
    display: none;
  }

  .NavBar {
    display: block !important;
  }
}

@media screen and (max-width: 1200px) {
  .NavBar {
    position: fixed;
    width: 100%;
    height: 100vh;
    background: #000;
    z-index: 2;
    left: 0;
    top: 0;
    padding-top: 25px;
  }

  .NavBar .v-toolbar-items {
    height: auto !important;
    width: 100%;
    margin-top: 60px;
    flex-direction: column;
  }

  .NavBar .nav-links a.nav-link {
    color: #fff;
  }

  mysection.NavBar button.close_btn {
    position: absolute;
    color: #fff;
    right: 2%;
    top: 5px;
  }

  .NavBar .nav-links a.nav-link {
    color: #fff;
    margin-left: 30px;
  }

  .NavBar .nav-links {
    align-items: flex-start;
    flex-direction: column;
  }
}
</style>
