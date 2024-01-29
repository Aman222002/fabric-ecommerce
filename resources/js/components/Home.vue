<template>
    <v-container>
        <div class="job-search-card">
            <v-card-title class="text-center">
                <h1>Find your dream job</h1>
                <h2>5 Lakh +jobs for you to explore</h2>
            </v-card-title>
            <SearchComponent />
        </div>
        <v-card>
            <v-container>
                <v-row align="center" justify="center">
                    <v-btn @click="openComponent('Mncs')" class="custom-btn">
                        <v-icon>mdi-domain</v-icon>
                        MNCs
                    </v-btn>
                    <v-btn @click="openComponent('Internships')" class="custom-btn">
                        <v-icon>mdi-briefcase-outline</v-icon>
                        Internships
                    </v-btn>

                    <v-btn @click="openComponent('Hr')" class="custom-btn">
                        <v-icon>mdi-account-tie</v-icon>
                        HR
                    </v-btn>

                    <v-btn @click="openComponent('Data Science')" class="custom-btn">
                        <v-icon>mdi-chart-bubble</v-icon>
                        Data Science
                    </v-btn>

                    <v-btn @click="openComponent('Project Management')" class="custom-btn">
                        <v-icon>mdi-view-dashboard</v-icon>
                        Project Management
                    </v-btn>

                    <v-btn @click="openComponent('Engineering')" class="custom-btn">
                        <v-icon>mdi-cogs</v-icon>
                        Engineering
                    </v-btn>
                    <v-btn @click="openComponent('Marketing')" class="custom-btn">
                        <v-icon>mdi-chart-line-variant</v-icon>
                        Marketing
                    </v-btn>

                    <v-btn @click="openComponent('Banking')" class="custom-btn">
                        <v-icon>mdi-bank</v-icon>
                        Banking
                    </v-btn>

                    <v-btn @click="openComponent('Fresher')" class="custom-btn">
                        <v-icon>mdi-school</v-icon>
                        Fresher
                    </v-btn>
                </v-row>
                <component :is="activeComponent" />
            </v-container>
        </v-card>
        <v-card-title class="text-center">
            <h1>Top Companies Hiring now</h1>
            <Hiring />
        </v-card-title>
    </v-container>
</template>
<script>
import { defineComponent } from 'vue';
import MncCompany from '@/components/MncCompany.vue';
import SearchComponent from '@/components/SearchComponent.vue';
import Hiring from '@/components/Hiring.vue';
// import Internships from '@/components/Internships.vue';
import { ref } from 'vue';

export default defineComponent({
    name: 'Home',
    components: {
        MncCompany,
        Hiring,
        // Internships,
        SearchComponent
    },
    setup() {
        const activeComponent = ref(null);
        const openComponent = (componentName) => {
            activeComponent.value = componentName;
        };

        return {
            activeComponent,
            openComponent,
        };
    },
});
</script>
<!-- <style scoped>
.job-search-card {
    /* margin: auto; */
    /* height: 5%;
    padding: 2px; */
    border: 2px solid black;
    border-radius: 25px;
    background-color: cadetblue;
}

.error-message {
    color: crimson;
    font-size: large;
}

.custom-btn {
    background-color: burlywood;
    margin: 20px;
    /* Add margin for spacing between buttons */
}

.search-button {
    background-color: black;
    font-size: 20px;
    padding: 30px 40px;
}
</style>
   -->