<template>
 
  <div class="full-screen-image-container">
    <v-card  class="custom-card">
      <v-card-title style="font-size: 40px; font-weight: bolder; text-align: center; margin-top: 30px; color: rgb(139, 238, 144);">{{ job.title }}</v-card-title>
      <v-card-text>
        <div style="font-size: 20px;margin-top: 30px; color: red;  ">Location:<span style="color: black;margin-left: 140px;"> {{ job.location }}</span></div><br>
        <div style="font-size: 20px; color: red;  ">Experience:<span style="color: black;margin-left: 140px;"> {{ job.experience }}</span></div><br>
        <div style="font-size: 20px;color: red;  ">Description:<span style="color: black;margin-left: 140px;"> {{ job.description }}</span></div><br>
        <div style="font-size: 20px; color: red;  ">Vacancy:<span style="color: black;margin-left: 140px;"> {{ job.vacancy }}</span></div>
      </v-card-text>
      <v-card-actions style="justify-content: center;">
          <v-btn  color="white" class="bg-primary" v-if="usersStore.isloggedin"  @click="apply(job.id)" >Apply</v-btn>
          <v-btn  color="white" class="bg-success">Save</v-btn>
         
      </v-card-actions>
    </v-card>
  </div>

</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useUsersStore } from '../store/user';
export default {
  name: 'PostDetail',
  props:{
            data:{
                type:Array,
                default: ()=>{[]},
            }
        },
  setup(props) {
   
    const usersStore = useUsersStore();
    const job = ref([]

    );
    const jobTitle = ref('');
    job.value=props.data;
      const apply = async(id) => {
 try{
 await axios.post(`/apply-job/${id}`) . then((response)=>{
  if (response.data.success) {

    window.Swal.fire({
              icon: 'success',
              title: 'Applied Successfully',
              text: 'Applied successfully ',
              confirmButtonText: 'OK',
            })
  }
 });
  
 }catch(err){
  console.error(err);
 }
      };

   
    return {
    
      jobTitle,
    
    usersStore,
    apply,
    job

   
    };
  },
};
</script>

<style scoped>
.custom-card {

  border: 1px solid rgb(7, 5, 5);
  width: 100vw;
 
}




</style>
