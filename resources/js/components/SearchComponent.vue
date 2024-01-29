<template>
    <v-container class="search-container">
        <v-row align="center" justify="center">
            <v-col class="search-bar">
                <v-text-field v-model="combinedQuery" @input="search" label="Search" outlined dense
                    append-icon="mdi-magnify" placeholder="Enter skills, experience, or locations"
                    class="highlight-placeholder"></v-text-field>
            </v-col>
        </v-row>

        <v-row align="center" justify="center">
            <v-col class="validation-message" v-if="validationMessage">
                {{ validationMessage }}
            </v-col>
        </v-row>

        <v-row align="center" justify="center">
            <v-col class="search-results" v-if="!validationMessage">
                <v-list>
                    <v-list-item v-for="result in searchResults" :key="result.id">
                        <v-list-item-content>
                            <v-list-item-title>{{ result.name }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </v-container>
</template>
 
<script>
import { ref } from 'vue';
import axios from 'axios';
export default {
    name: 'SearchComponent',
    setup() {
        const skillsQuery = ref('');
        const experienceQuery = ref('');
        const locationsQuery = ref('');
        const searchResults = ref([]);
        const validationMessage = ref('');
        const search = async () => {
            if (!skillsQuery.value || !experienceQuery.value || !locationsQuery.value) {
                validationMessage.value = 'Please fill in all fields';
                return;
            }
            const combinedQuery = `${skillsQuery.value} ${experienceQuery.value} ${locationsQuery.value}`.trim();
            try {
                const response = await axios.get('/company', {
                    params: {
                        query: combinedQuery,
                    },
                });
                searchResults.value = response.data;
                validationMessage.value = '';
            } catch (error) {
                console.error('Error searching:', error);
                validationMessage.value = 'Error searching. Please try again.';
            }
        };

        return {
            searchResults,
            search,
            validationMessage,
        };
    },
};
</script>

<style scoped>
.search-bar {
    margin: 20px 0;
    height: 100px;
}

.search-container {
    background-color: cadetblue;
    border-radius: 10px;
    padding: 20px;

}

.validation-message {
    color: red;
    margin-top: 10px;
}

.search-results {
    margin-top: 20px;
}

.highlight-placeholder ::placeholder {
    color: brown;
    opacity: 1;

}
</style>
  