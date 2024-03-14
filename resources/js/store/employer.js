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
        Company: (state) => state.company,
        isloggedin: (state) => state.isLoggedIN,
        countCartItems: (state) => state.cart_item.length,
    },
    persist: true,
});
