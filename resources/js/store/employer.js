import { defineStore } from "pinia";

export const useEmployerStore = defineStore({
    id: "employer-store",
    state: () => {
        return {
            user: null,
            isLoggedIN: false,
            company: {
                company_name: "",
                company_email: "",
                phone: "",
            },
            previousRoute: null,
        };
    },
    actions: {
        isLogIn() {
            this.isLoggedIN = true;
        },
        isLogOut() {
            this.isLoggedIN = false;
        },
        setPreviousRoute(route) {
            this.previousRoute = route;
        },
        removePreviousRoute() {
            this.previousRoute = null;
        },
    },
    getters: {
        Company: (state) => state.company,
        isloggedin: (state) => state.isLoggedIN,
        getPreviousRoute: (state) => state.previousRoute,
    },
    persist: true,
});
