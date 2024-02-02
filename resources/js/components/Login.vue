
<template>
    <v-container fluid class="div1">

<<<<<<< HEAD
      <v-card-text>
        <v-form @submit.prevent="submitForm()">
          <v-text-field v-model="formData.email" label="Email" type="email" :rules="emailRules"></v-text-field>
          <v-text-field v-model="formData.password" label="Password" type="password"
            :rules="passwordRules"></v-text-field>
=======
        <div class="register-form">
            <v-col cols="12" sm="6" md="6">
                <v-col class="mt-5"
                    style="background-color:#9a6a4f; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <v-card-title class="text-center">Login</v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="submitForm">
                            <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules"
                                required variant="outlined"></v-text-field>
                            <v-text-field v-model="formData.password" id="password" label="Password" type="password"
                                :rules="passwordRules" required variant="outlined"></v-text-field>
                            <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <div class="text-hint">Don't have an account? <a href="/registration">Register</a>
                        </div>
                    </v-card-actions>
>>>>>>> 970323addb3a7f2552311484f205d30a74e0bc7e

                </v-col>
            </v-col>
        </div>
    </v-container>
</template>
  
<script>

export default {
<<<<<<< HEAD
  name: 'Login',
  setup() {
    const formData = ref({
      email: '',
      password: '',
    });

    const emailRules = [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
    ];

    const passwordRules = [
      v => !!v || 'Password is required',
      v => (v && v.length >= 6) || 'Password must be at least 6 characters',
    ];

    const submitForm = async () => {
      try {
        const response = await window.axios.post('/login/check', formData.value);
        const data = response.data;
        console.log(data.data);

        if (data.status === true) {
          console.log(data.data.roles[0].name);
          alert('Login successful');

          if (data.data.roles[0].name == 'Admin') {
            window.location.href = './admin/dashboard';
          } else {
            window.location.href = './resume';
          }
        } else {
          alert('Login failed');
        }
      } catch (error) {
        console.error(error);
        alert('An error occurred during login');
      }
    };

    return {
      formData,
      emailRules,
      passwordRules,
      submitForm,
    };
  },
=======
    name: 'Login',
    data() {
        return {
            formData: {
                email: '',
                password: '',
            },

            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 6) || 'Password must be at least 6 characters',
            ],
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await window.axios.post('/login', this.formData);
                const data = response.data;

                if (data.status === true) {
                    alert('Login successful');

                    window.location.href = './resume';
                } else {
                    alert('Login failed');
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred during login');
            }
        },
    },
>>>>>>> 970323addb3a7f2552311484f205d30a74e0bc7e
};
</script>
  
<style scoped>
.register-form {
<<<<<<< HEAD
  background-size: cover;
  padding: 5vh;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-repeat: no-repeat;
  background-position: center;
  color: "#006400";
=======
    background-image: url('/storage/assets/p.jpg');
    background-size: cover;
    padding: 5vh;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-repeat: no-repeat;
    background-position: center;
    color: "#006400";

>>>>>>> 970323addb3a7f2552311484f205d30a74e0bc7e
}
</style>
  