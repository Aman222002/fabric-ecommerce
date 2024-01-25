<template>
    <div class="div1">
        <h1>HIRING</h1>
        <v-row>
            <v-col v-for="company in companies" :key="company.id" cols="12" md="6" lg="4">
                <v-card class="company-card">
                    <v-img :src="company.logo" height="200"></v-img>
                    <v-card-title>{{ company.name }}</v-card-title>
                    <v-card-subtitle>{{ company.industry }}</v-card-subtitle>
                    <v-card-text>{{ company.address }}</v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import { ref, onMounted } from 'vue';
export default {
    name: 'Hiring',
    setup() {
        const companies = ref([]);

        // const fetchCompanies = async () => {
        //     try {
        //         const response = await axios.get('http://your-laravel-api.com/api/companies');
        //         companies.value = response.data;
        //     } catch (error) {
        //         console.error('Error fetching companies:', error);
        //     }
        // };

        // onMounted(fetchCompanies);

        return {
            companies,
        };
    },
};
</script>
<!--   
<style scoped>
.div1 {
    background-color: chocolate;
    height: 100%;
    width: 100%;
}

.company-card {
    margin: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
}

.company-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}
</style> -->
  