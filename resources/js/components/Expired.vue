<template>
    <v-container fluid>
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <v-card class="elevation-2">
                    <v-toolbar color="error" dark flat>
                        <v-toolbar-title>Sorry, Your Link Has Expired</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <p>The password reset link you used has expired.</p>
                        <p>Please request a new password reset link.</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" to="/">Go to Home</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
export default {
    name: 'ExpiredPage'
};
</script>
  
<style scoped></style>
  