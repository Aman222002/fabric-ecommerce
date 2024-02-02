import { defineStore } from "pinia";

export const useUsersStore = defineStore({
    id: "user-store",
    state: () => {
        return {
            cart_item: [],
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
        addToCart(item) {
            state.cart_items.push(item);
        },
        async fetchPlans() {
            const res = await fetch("http://127.0.0.1:8000/admin/get/plans");
            const items = await res.json();
            this.cart_items = items;
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
        countCartItems: (state) => state.cart_item.length,
        getCartItems() {
            return state.cartItems;
        },
    },
    persist: true,
});
