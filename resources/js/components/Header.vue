<template>
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


    <!-- Your main content goes here -->
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
/* .v-app-bar {
    background-color: #ADD8E6;  
    border-bottom: 1px solid #ccc;
} */
</style>