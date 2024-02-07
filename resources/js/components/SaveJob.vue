<template>
    <div style="text-align: center; margin-top: 20px;">
        <h1>Jobs <span style="color: red;">Saved</span></h1>
    </div>
    <v-btn color="success" style="margin-top: 20px;"><a href="/companypost" style="text-decoration: none;">Check New Job</a></v-btn>
      <v-table>
        <thead>
          <tr style="font-size: 30px;">
          
            <th class="text-left">Job Title</th>
            <th class="text-left">Location</th>
            <th class="text-left">Salary</th>
         
            <th class="text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="savedJobs in savedJob" :key="savedJobs.job.id" style="font-size: 23px;">
           
            <td>{{ savedJobs.job.title }}</td>
            <td>{{ savedJobs.job.location }}</td>
            <td>{{ savedJobs.job.salary }}</td>
          
            <td>
              <v-btn
              color="white"
              class="bg-primary"
           
              @click="apply(savedJobs.job.id)"
              >Apply</v-btn
            >
                <v-btn @click="deleteItem(savedJobs.id)" color="error">Delete</v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </template>
    <script>

    import { onMounted, ref } from 'vue';
      
      export default {
        name: 'SaveJob',
        props:{
            data:{
                type:Array,
                default: ()=>{[]},
            }
        },
        setup(props) {
            console.log(props.data);
          const savedJob = ref([]);
          savedJob.value=props.data;
          const deleteItem = (id) => {
            window.Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {
    window.Swal.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success",
    });
    try{
         axios.post(`/removesavedjobs/${id}`).then((response)=>{
          if (response.data.status ==true) {
            window.location.reload();
      } 
      else {
        console.log('Request was not successful:', response.data.message);
      }
         })
      }catch(err){
        console.log(err);
      }
  }
});
    
    };
    const apply = async (id) => {
      try {
        await axios.post(`/apply-job/${id}`).then((response) => {
          if (response.data.status == true) {
           
            window.Swal.fire({
              icon: "success",
              title: "Applied Successfully",
              text: "Applied successfully ",
              confirmButtonText: "OK",
            });
          }
        });
      } catch (err) {
        console.error(err);
      
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already apply on this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };
              return {
                savedJob,
            deleteItem,
          apply
          };
        
        },
      };
      </script>