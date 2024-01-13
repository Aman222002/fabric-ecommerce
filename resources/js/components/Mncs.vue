<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card class="mt-5" style="background-color: #1976D2; color: #fff;">
                    <v-card-title class="text-center">Welcome to MNCs Company</v-card-title>
                    <v-card-subtitle class="text-center">Explore Opportunities with Global Leaders</v-card-subtitle>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <v-img class="image-with-transition" src="/storage/assets/mncs.png" alt="MNCs Image"
                                        height="300"></v-img>
                                </v-col>
                                <v-col cols="4">
                                    <v-img class="image-with-transition" src="/storage/assets/google.jfif" alt="MNCs Image"
                                        height="300"></v-img>
                                </v-col>
                                <v-col cols="4">
                                    <v-img class="image-with-transition" src="/storage/assets/ibm.jfif" alt="MNCs Image"
                                        height="300"></v-img>
                                </v-col>
                                <v-col cols="4">
                                    <v-img class="image-with-transition" src="/storage/assets/microsoft.jfif"
                                        alt="MNCs Image" height="300"></v-img>
                                </v-col>
                                <v-col cols="4">
                                    <v-img class="image-with-transition" src="/storage/assets/infosis.jfif" alt="MNCs Image"
                                        height="300"></v-img>
                                </v-col>
                                <v-col cols="4">
                                    <v-img class="image-with-transition" src="/storage/assets/deloitte.jfif"
                                        alt="MNCs Image" height="300"></v-img>
                                </v-col>
                            </v-row>

                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row class="mt-5">
            <v-col cols="12" md="4" v-for="company in companies" :key="company.id">
                <v-card class="company-card">
                    <v-card-title>{{ company.name }}</v-card-title>
                    <v-card-subtitle>{{ company.industry }}</v-card-subtitle>
                    <v-card-text>
                        {{ company.description }}
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary">Explore Careers</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import { ref } from 'vue';
export default {
    setup() {
        const companies = ref([
            {
                id: 1,
                name: 'Company A',
                industry: 'Technology',
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            },
            {
                id: 2,
                name: 'Company B',
                industry: 'Finance',
                description: 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            },

        ]);

        return {
            companies,
        };
    },
};
</script>

<style scoped>
.company-card:hover {
    background-color: red;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

}

.image-with-transition {
    transition: transform 0.3s ease-in-out;
}

.image-with-transition:hover {
    transform: scale(1.1);
    /* Adjust the scale factor as needed */
}

.vertical-line {
    border-left: 2px solid #fff;
    height: 200px;
    /* Adjust the height according to your needs */
    margin: 0 auto;
}
</style>
  