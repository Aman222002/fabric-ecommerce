import AllProduct from "./components/AllUser.vue";
import CreateProduct from "./components/AddUser.vue";
import EditProduct from "./components/EditUser.vue";

export const routes = [
    {
        name: "home",
        path: "/",
        component: AllProduct,
    },
    {
        name: "create",
        path: "/create",
        component: CreateProduct,
    },
    {
        name: "edit",
        path: "/edit/:id",
        component: EditProduct,
    },
];
