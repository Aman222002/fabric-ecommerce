<template>
    <v-container>
        <v-card class="mx-auto my-8" elevation="16" width="75rem">
            <v-card-item>
                <h2>Cart</h2>
                <v-row row="12">
                    <v-col col="2">
                        <v-card-title>
                            Item Name
                        </v-card-title>
                    </v-col>
                    <v-col col="2">
                        <v-card-title class="heading">
                            Validity
                        </v-card-title>
                    </v-col>
                    <v-col col="2">
                        <v-card-title class="heading">
                            Quantity
                        </v-card-title>
                    </v-col>
                    <v-col col="2">
                        <v-card-title>
                            Price
                        </v-card-title>
                    </v-col>
                    <v-col col="2">
                        <v-card-title>
                            Sub Total
                        </v-card-title>
                    </v-col>
                    <v-col col="2">
                        <v-card-title>
                            Posts
                        </v-card-title>
                    </v-col>
                    <v-col col="2">
                        <v-card-title>
                            Action
                        </v-card-title>
                    </v-col>
                </v-row>
                <v-row row="12" v-for="item in cart_items">
                    <v-col col="2">
                        {{ item.name }}
                    </v-col>
                    <v-col col="2">
                        {{ item.duration }}
                    </v-col>
                    <v-col col="2">
                        <v-text-field v-model="item.quantity" type="number" style="width: 80px;"></v-text-field>
                    </v-col>
                    <v-col col="2">
                        ${{ item.price }}
                    </v-col>
                    <v-col col="2">
                        ${{ item.price * item.quantity }}
                    </v-col>
                    <v-col col="2">
                        {{ item.Posts_Allowed }}
                    </v-col>
                    <v-col col="2">
                        <v-btn class="bg-error">
                            Remove Item
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
        <v-card class="my-8" elevation="16" max-width="500">
            <v-card-title>Checkout</v-card-title>
            <v-card-subtitle>Total Price</v-card-subtitle>
        </v-card>
    </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
import { useUsersStore } from "../store/user";
export default {
    name: "Cart",
    setup() {
        const cart_items = ref({});
        const usersStore = useUsersStore();
        onMounted(() => {
            cart_items.value = usersStore.getCartItems;
        });
        return {
            cart_items,
        }
    }
}
</script>