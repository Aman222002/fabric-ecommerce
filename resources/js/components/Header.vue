
<template>
  <v-app-bar class="custom-app-bar header_bar">
    <v-row align="center" justify="space-between">
      <v-col class="nav-links">
        <a
          href="/jobs-detail"
          class="nav-link"
          :class="{ active: isActive('/jobs-detail') }"
          style="margin-left: 70px"
          >Home</a
        >
        <a
          href="/job-apply"
          v-if="usersStore.isloggedin"
          class="nav-link"
          :class="{ active: isActive('/job-apply') }"
          >Jobs Applied</a
        >
        <a
          href="/savedjobs"
          v-if="usersStore.isloggedin"
          class="nav-link"
          :class="{ active: isActive('/savedjobs') }"
          >Jobs Saved</a
        >
        <a
          href="/userprofile"
          v-if="usersStore.isloggedin"
          class="nav-link"
          :class="{ active: isActive('/userprofile') }"
          >Profile</a
        >
      </v-col>
      <v-menu class="profile" v-if="!usersStore.isloggedin">
        <template v-slot:activator="{ props }">
          <a
            href="#"
            class="nav-link"
            v-bind="props"
            :class="{ active: isActive('#') }"
            style="margin-right: 40px"
            >Login <v-icon color="white">mdi-login</v-icon></a
          >
        </template>

        <v-list>
          <v-list-item
            v-for="(item, i) in loginItems"
            :key="i"
            style="display: inline"
          >
            <a :href="item.href" style="text-decoration: none; color: black">
              <span>
                <v-list-item>
                  <v-icon>{{ item.icon }}</v-icon>
                  {{ item.title }}
                </v-list-item>
              </span>
            </a>
          </v-list-item>
        </v-list>
      </v-menu>

      <a
        href="/registration"
        v-if="!usersStore.isloggedin"
        class="nav-link"
        :class="{ active: isActive('/registration') }"
        >Register <v-icon color="white">mdi-account-plus</v-icon></a
      >
    </v-row>
    <v-menu
      class="profile"
      v-if="usersStore.isloggedin"
      transition="slide-x-transition"
    >
      <template v-slot:activator="{ props }">
        <span style="margin-right: 20px">
          <v-btn icon="mdi-account" v-bind="props"></v-btn
        ></span>
      </template>

      <v-list>
        <v-list-item v-for="(item, i) in items" :key="i">
          <v-btn @click="logout(item.title)">
            <a :href="item.href" style="text-decoration: none"
              ><span>
                <v-list-item>
                  <v-icon>{{ item.icon }}</v-icon>
                  {{ item.title }}
                </v-list-item>
              </span></a
            >
          </v-btn>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
import { ref } from "vue";
import { reactive, onMounted } from "vue";
import { useUsersStore } from "../store/user";
import axios from "axios";

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
    const usersStore = useUsersStore();
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
            usersStore.isLogOut();
            window.location.href = "/login";
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
    };
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

.nav-link:hover,
.active {
  color: #1967d2;
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
</style>

