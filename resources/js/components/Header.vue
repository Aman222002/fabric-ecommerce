
<template>
  <v-app-bar  class="custom-app-bar" color="primary">
  
  
    <v-row align="center" justify="space-between">
   
      <v-col class="nav-links">
       
          <v-avatar size="60" style="margin-left: 30px;" >
            <img src="/storage/assest/26.png" alt="Logo" class="logo" />
          
          </v-avatar>
          <a href="/login" style="margin-left:10px; font-size: 30px; text-decoration: none; color: white;">JOBS</a>
         
        <a href="/jobs-detail" class="nav-link" :class="{ 'active': isActive('/companypost') }" style="margin-left: 70px;">Home</a>
       
        <a href="/job-apply" v-if="usersStore.isloggedin" class="nav-link"
          :class="{ 'active': isActive('/job-apply') }">Jobs Applied</a>
        <a href="/savedjobs" v-if="usersStore.isloggedin" class="nav-link"
          :class="{ 'active': isActive('/savedjobs') }">Jobs Saved</a>
      

      </v-col>
      <v-menu class="profile" v-if="!usersStore.isloggedin">
      <template v-slot:activator="{ props }">
      <v-icon color="white">mdi-login</v-icon>
         <a href="#" class="nav-link" v-bind="props"
          :class="{ 'active': isActive('#')}">Login</a>
      </template>

      <v-list>
        <v-list-item v-for="(item, i) in loginItems" :key="i">
          
            <a :href="item.href" style="text-decoration: none; color: black;">
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
   
        <a href="/registration" v-if="!usersStore.isloggedin" class="nav-link"
          :class="{ 'active': isActive('/registration')}"> <v-icon color="white">mdi-account-plus</v-icon>Register</a>
      
    </v-row>
    <v-menu class="profile" v-if="usersStore.isloggedin">
            <template v-slot:activator="{ props }">
                <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
            </template>

            <v-list>
                <v-list-item v-for="(item, i) in items" :key="i">
                    <v-btn @click="logout(item.title)">
                        <a :href="item.href" style="text-decoration: none; "><span>
                                <v-list-item>
                                    <v-icon>{{ item.icon }}</v-icon>
                                    {{ item.title }}
                                </v-list-item>
                            </span></a>
                    </v-btn>
                </v-list-item>
            </v-list>
        </v-menu>
      
  </v-app-bar>
  
</template>

<script>
import { ref } from 'vue';
import { reactive, onMounted } from 'vue';
import { useUsersStore } from "../store/user";
import axios from 'axios';

export default {
  name: "Header",
  setup() {
    const items = ref([
           
            {
                title: 'Logout',
                icon: 'mdi-logout',
            },
        ]);
        const loginItems = ref([
      {
        title: 'Login as User',
        icon: 'mdi-login',
        href: '/login'
      },
      {
        title: 'Login as Company',
        icon: 'mdi-office-building',
        href: '/job'
      },
    ]);
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
   
    const logout = (item) => {
            if (item === 'Logout') {
                axios.get('/logout').then((response) => {
                    console.log(response.data);
                    if (response.data.status === true) {
                        console.log('changed');
                        usersStore.isLogOut();
                        window.location.href = '/login';
                    }
                })

            } else {
                console.log('not found');
            }
        }
       
    
    return {
      isActive,
      logout,
      usersStore,
      items,
   
      loginItems
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
  font-weight: bold;
  font-size: 15px;
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
  background: linear-gradient(45deg,   #ca82e9, #8b8488);
}

.v-app-bar {

  border-bottom: 1px solid #161414;
}

.nav-link:hover {
  color: #ca82e9;
}

.nav-link:hover {
  color: #ca82e9;
}

.active {
  color:  #ca82e9;
}

</style>

