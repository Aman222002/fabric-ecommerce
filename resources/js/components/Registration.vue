
  <template>
    <v-container>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="10">
          <v-card class="elevation-6 mt-3" style="margin-bottom: 10px;">
           
                <v-row>
                  <v-col cols="12" md="6" class="blue rounded-bl-xl">
                    <div style="text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text">
                       
                        <p class="text-center" style="font-size: 20px;">Already Sign up?</p>
                        <p class="text-center" style="font-size: 13px;">
                          Log in to your account so you can continue building and
                          <br> editing your onboarding flows
                        </p>
                        <v-btn
                    color="primary"
                    tile
                    outlined
                    
                    dark
                    @click="login()"
                    style="margin-top: 20px"
                    >Login</v-btn
                  >
                      </v-card-text>
                    </div>
                  </v-col>
  
                  <v-col cols="12" md="6">
                    <v-card-text class="mt-8">
                      <v-form ref="form" @submit.prevent="submitForm">
                      <p class="text-center" style="font-size: 20px">Sign Up for an Account</p>
                      
                      <v-row align="center" justify="center">
                        <v-col cols="12" sm="12">
                        
                              <v-text-field
                                label="First Name"
                                variant="outlined"
                                density="compact"
                                
                                color="blue"
                                autocomplete="false"
                                class="mt-4"
                                v-model="formData.name"
                                :rules="nameRules"
                                style="margin-bottom: 10px;"
                              />
                          
                        
                          <v-text-field
                            label="Email"
                            variant="outlined"
                            density="compact"
                            
                            color="blue"
                            autocomplete="false"
                            v-model="formData.email"
                            :rules="emailRules"
                            style="margin-bottom: 10px;"
                          />
                          <v-text-field
                            label="Password"
                            variant="outlined"
                            density="compact"
                            
                            color="blue"
                            autocomplete="false"
                            type="password"
                            v-model="formData.password"
                            :rules="passwordRules"
                            style="margin-bottom: 10px;"
                          />
                          <v-text-field v-model="formData.phone"  :rules="phoneRules" color="blue"  density="compact"  style="margin-bottom: 10px;"
                      variant="outlined" label="Phone"></v-text-field>
                   
                          <v-checkbox
                            label="Remember Me"
                            class="mt-n1"
                            color="blue"
                          >
                          </v-checkbox>
                         
                      <v-btn type="submit" dark block tile color="primary" 
                        >Register</v-btn
                      >
                        </v-col>
                      </v-row>
                    </v-form>
                    </v-card-text>
                  </v-col>
                </v-row>
             
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
<script>
import { ref } from 'vue';
import axios from 'axios';
export default {
    name: 'Registration',
    setup() {
        const valid = ref(false);
        const response = ref({});
        const formData = ref({
            name: '',
            email: '',
            password: '',
            phone: '',
        });

        const nameRules = [
            v => !!v || 'Full Name is required',
            v => (v && v.length >= 3) || 'Full Name must be at least 3 characters',
        ];
        const emailRules = [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ];
        const passwordRules = [
            v => !!v || 'Password is required',
            v => (v && v.length >= 6) || 'Password must be at least 6 characters',
        ];
        const phoneRules = [
            v => !!v || 'Phone number is required',
            v => (v && v.length >= 10) || 'Phone number must be a valid 10-digit number',
        ];
        const submitForm = () => {
            if (this.$refs.form.validate()) {
                console.log(formData.value.phone);
                axios.post('/registration', formData.value)
                    .then((data) => {
                        console.log(data);
                        alert('success');
                    });
            }
        };
        const login = async () => {
      window.location.href = "/login";
    };
        return {
            valid,
            response,
            formData,
            nameRules,
            emailRules,
            passwordRules,
            phoneRules,
            submitForm,
            login
        };
    },
    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {

                console.log(this.formData.phone);
                axios.post('/registration', this.formData)
                    .then((data) => {
                        if (data.status = true) {
                            
                            window.location.href = './login';
                        } else {
                            
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                       
                    })

            }
        },
    },
}
</script>

<style scoped>

.blue {
  background-color: rgb(54, 194, 250);
}

.rounded-bl-xl {
  border-bottom-right-radius: 250px;
}
</style> 
 
 

  
   
