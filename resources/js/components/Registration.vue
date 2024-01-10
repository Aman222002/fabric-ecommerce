
<template>
    <v-container>
        <div class="div1">
            <h1 style="color: #000;">SIGN UP</h1>
        </div>
        <!-- Buttons to switch between customer and provider registration -->
        <v-row>

            <div class="div2">
                <v-btn @click="selectedType = 'customer'" :color="selectedType === 'customer' ? 'primary' : ''">
                    Customer Registration
                </v-btn>

                <v-btn @click="selectedType = 'provider'" :color="selectedType === 'provider' ? 'primary' : ''">
                    Provider Registration
                </v-btn>
            </div>
        </v-row>

        <!-- Render the selected registration form -->
        <v-row>
            <v-col>
                <customer-registration v-if="selectedType === 'customer'" />
                <provider-registration v-if="selectedType === 'provider'" />
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
import CustomerRegistration from '@/components/CustomerRegistration.vue';
import ProviderRegistration from '@/components/ProviderRegistration.vue';

export default {
    components: {
        CustomerRegistration,
        ProviderRegistration,
    },
    data() {
        return {
            selectedType: 'customer', // Set the default registration type
        };
    },
};
</script>
<style scoped>
.div1 {
    text-align: center;
}

.div2 {
    text-align: center;
}
</style>
  