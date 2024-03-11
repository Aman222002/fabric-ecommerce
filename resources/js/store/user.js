import { defineStore } from "pinia";

export const useUsersStore = defineStore({
    id: "user-store",
    state: () => {
        return {
            cart_item: [],
            user: null,
            isLoggedIN: false,
            company:{
                company_name:'',
                company_email:'',
                phone:'',
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
        addToCart(item, quant) {
            let index = this.cart_item.findIndex(
                (product) => product.id === item.id
            );
            if (index !== -1) {
                const quantity = parseInt(this.cart_item[index].quantity);
                this.cart_item[index].quantity = quantity + parseInt(quant);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your item has been updated",
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else {
                item.quantity = quant;
                this.cart_item.push(item);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your item has been saved",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        },
        async fetchUser() {
            const res = await fetch(
                "http://127.0.0.1:8000/admin/profile/getProfile"
            );
            console.log(res.json());
            const user = await res.json();
            this.user = user;
        },
    },
    getters: {
        Company:(state)=> state.company,
        isloggedin: (state) => state.isLoggedIN,
        countCartItems: (state) => state.cart_item.length,
        getCartItems(state) {
            return state.cart_item;
        },
        getPrice: (state) => {
            return state.cart_item.price * state.cart_item.quantity;
        },
    },
    persist: true,
});
