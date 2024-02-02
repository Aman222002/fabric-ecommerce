import { defineStore } from "pinia";

export const useUsersStore = defineStore({
    id: "user-store",
    state: () => {
        return {
            user: null,
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
        async fetchUser() {
            const res = await fetch(
                "http://127.0.0.1:8000/admin/profile/getProfile"
            );
            const user = await res.json();
            this.user = user;
        },
    },
    getters: {
        isloggedin: (state) => state.isLoggedIN,
    },
    persist: true,
});
