import { defineStore } from "pinia";

export const useUsersStore = defineStore({
    id: "user-store",

    state: () => {
        return {
            isLoggedIN: false,
        };
    },

    actions: {
        isLogIn() {
            this.isLoggedIN = true;
        },

        isLogOut() {
            this.isLoggedIN = false;
        },
    },
    getters: {
        isloggedin: (state) => state.isLoggedIN,
    },
    persist: true,
});
