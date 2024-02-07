<template>
  <div style="text-align: center; margin-top: 20px">
    <h1>Jobs <span style="color: red">Applied</span></h1>
  </div>
  <v-btn color="success" style="margin-top: 20px"
    ><a href="/companypost" style="text-decoration: none"
      >Apply For New Job</a
    ></v-btn
  >
  <v-table>
    <thead>
      <tr style="font-size: 30px">
        <th class="text-left">Job Title</th>
        <th class="text-left">Location</th>
        <th class="text-left">Salary</th>
        <th class="text-left">Applied At</th>
        <th class="text-left">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="jobApplications in jobApplication"
        :key="jobApplications.job.id"
        style="font-size: 23px"
      >
        <td>{{ jobApplications.job.title }}</td>
        <td>{{ jobApplications.job.location }}</td>
        <td>{{ jobApplications.job.salary }}</td>
        <td>{{ jobApplications.job.created_at }}</td>
        <td>
          <v-btn @click="deleteItem(jobApplications.id)" color="error"
            >Delete</v-btn
          >
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
    <script>
import { onMounted, ref } from "vue";

export default {
  name: "JobApplied",
  props: {
    data: {
      type: Array,
      default: () => {
        [];
      },
    },
  },
  setup(props) {
    console.log(props.data);
    const jobApplication = ref([]);
    jobApplication.value = props.data;

    const deleteItem = (id) => {
      window.Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          window.Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
          try {
            axios.post(`/removeappliedjobs/${id}`).then((response) => {
              if (response.data.status == true) {
                window.location.reload();
              } else {
                console.log(
                  "Request was not successful:",
                  response.data.message
                );
              }
            });
          } catch (err) {
            console.log(err);
          }
        }
      });
    };
    return {
      jobApplication,
      deleteItem,
    };
  },
};
</script>