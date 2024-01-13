<template>
    <v-app>
        <v-app-bar app>
            <v-container>
                <v-row align="center" justify="space-between">
                    <v-col>
                        <v-btn text to="/">Jobs</v-btn>
                        <v-btn text to="/">Companies</v-btn>
                        <v-btn text to="/">Services</v-btn>
                        <v-btn text to="/">Companies</v-btn>

                    </v-col>

                    <v-btn to="/" outlined class="btn-dashboard">

                        <a href="login">Login</a>
                    </v-btn>
                    <v-btn to="/" outlined class="btn-dashboard">
                        <a href="/registration"> Registration </a> </v-btn>
                    <v-btn to="/" outlined class="btn-dashboard">
                        <a href="/registration"> For employers</a> </v-btn>

                </v-row>
            </v-container>
        </v-app-bar>

        <!-- Your main content goes here -->

    </v-app>
</template>
  
<script>
export default {

};
</script>

<style scoped>
.btn-dashboard {
    border-radius: 4px;
}

.btn-dashboard:hover {
    background: linear-gradient(45deg, #e7cff1, #f14cad);
    color: #fff;
}

/* Adjust background color and border for the navigation bar */
.v-app-bar {
    background-color: #ADD8E6;
    /* Set your desired background color */
    border-bottom: 1px solid #ccc;
    /* Set your desired border style */
}
</style>