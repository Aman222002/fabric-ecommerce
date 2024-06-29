<template>
   <v-dialog v-model="editDialog" max-width="500">
    <v-card>
      <v-card-title>
        <span class="headline">Edit Representative
          <v-icon style="float: right" @click="editDialog = false">mdi-close</v-icon>
        </span>
      </v-card-title>
      <v-card-text>
      
          <v-text-field v-model="editCompanyData.name" label=" Name" dense outlined :rules="nameRules" style="margin-top: 10px"></v-text-field>
          <v-text-field v-model="editCompanyData.email" label="Email" dense outlined :rules="emailRules" style="margin-top: 10px"></v-text-field>
     
          <vue-tel-input
        style="margin-top: 10px"
              variant="outlined"
              @input="handlePhoneInput"
              :value="editCompanyData.phone"
              @validate="telvalidate"
              label=" Phone"
              type="phone"
              density="compact"
              mask="##########"
              hide-details="auto"
              mode="international"
            ></vue-tel-input>
            <span v-if="formSubmitted && phoneVal" class="error-message">{{ phoneVal }}</span><br>
        
          <v-btn color="primary" @click="saveChanges(updateId)" style="margin-top: 10px">Save Changes</v-btn>
  
      </v-card-text>
    </v-card>
  </v-dialog>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
    :remote-operations="true"
  >
    <!-- <DxEditing :allow-updating="true" mode="popup" :use-icons="true" >
      <DxPopup
          :show-title="true"
          :width="600"
          :height="300"
          title="Representative Info"
        />
        <DxForm>
          <DxFormItem
            :col-count="2"
            :col-span="2"
            item-type="group"
          >
            <DxFormItem data-field="name"/>
            <DxFormItem data-field="email"/>
            <DxFormItem data-field="phone"/>
    </DxFormItem>
        </DxForm>
      </DxEditing> -->
    <DxSearchPanel :visible="true" />
    <DxColumn data-field="name" data-type="string">
      <DxRequiredRule />
    </DxColumn>
    <DxColumn data-field="email" data-type="string">
      <DxRequiredRule />
      <DxEmailRule message="Email is invalid" />
    </DxColumn>
    <DxColumn data-field="phone" data-type="string"> </DxColumn>
    <!-- <DxColumn type="buttons" caption="Action"></DxColumn> -->
    <DxColumn cell-template="Dxbutton" width="auto"></DxColumn>
    <template #Dxbutton="{ data }">
      <v-btn
        prepend-icon="mdi-pencil"
        class="edit-btn"
        @click="editUser(data.data)"
      ></v-btn>

     
    </template>
  </DxDataGrid>
</template>
<script>
import dxGridStore from "../composition/dxGridStore";
import axios from "axios";
import { ref } from 'vue';
export default {
  name: "RepresentativeTab",
  props: {
    userId: {
      type: Number,
      default: 0,
    },
  },
  setup(props) {
     console.log(props.userId);
    const loadURL = `/admin/company/representative/${props.userId}`;
    const updateURL = `/admin/user/update`;
    const editDialog = ref(false);
    const editCompanyData = ref({
      name: '',
    email: '',
      phone: '',
     
    });
    const formSubmitted = ref(false);
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const phoneVal = ref("");
    const updateId = ref();
    console.log(updateURL);
    const { dataSource } = dxGridStore(loadURL,null,null,updateURL,null);
    const handlePhoneInput = (event) => {
      try {
        if (typeof event === "string") {
          editCompanyData.value.phone = event;
        } else if (event && event.target && event.target.value) {
          editCompanyData.value.phone = event.target.value;
        } else {
          console.error("Invalid event:", event);
        }
      } catch (error) {
        console.error("Error handling phone input:", error);
      }
    };
    const telvalidate = (isValid) => {
    console.log("Is Valid:", isValid);
  
    if (isValid.valid===true) {
console.log( isValid.value,"Valid Phone Number");
phoneVal.value = "";
return true;
    } else {
    
      console.log("Invalid Phone Number");
       phoneVal.value = "Enter a valid phone number";
      return false
    }
   
};
   
    const editUser = (data) => {
     console.log(data)
      editDialog.value = true;
      editCompanyData.value.name=data.name;
      editCompanyData.value.email=data.email;
      editCompanyData.value.phone=data.phone;
      updateId.value = data.id;
    };
//     const saveChanges = () => {
//   console.log("Saving changes...");
 
// };
const saveChanges = (id) => {
  formSubmitted.value = true;
  if (phoneVal.value) {
    telvalidate({ isValid: false, number: editCompanyData.value.phone });
        return;
      }
  axios.post(`/admin/user/update/${id}`, editCompanyData.value)
    .then(response => {
      console.log('Update response:', response.data); 
   
      editDialog.value = false;
      window.location.reload();
    })
    .catch(error => {
      console.error('Update error:', error); 
   
    });
};
    return {
      dataSource,formSubmitted,
      updateURL,editCompanyData,editDialog,updateId,phoneVal,saveChanges,editUser,handlePhoneInput,telvalidate,emailRules ,nameRules
    };
  },
};
</script>
<style scoped>
#grid {
  max-height: 200px;
}

.container {
  margin-top: 15px;
  margin-left: 15px;
  margin-bottom: 15px;
  width: 95%;
}

.options {
  padding: 10px;
  margin-top: 10px;
  background-color: rgba(191, 191, 191, 0.15);
}

.caption {
  margin-bottom: 10px;
  font-weight: 500;
  font-size: 18px;
}

.option {
  margin-bottom: 10px;
}

.option > span {
  position: relative;
  top: 2px;
  margin-right: 10px;
}

.option > .dx-widget {
  display: inline-block;
  vertical-align: middle;
}

#requests .caption {
  float: left;
  padding-top: 7px;
}

#requests > div {
  padding-bottom: 5px;
}

#requests > div::after {
  display: table;
  clear: both;
}

#requests #clear {
  float: right;
}

#requests ul {
  list-style: none;
  overflow: auto;
  margin: 0;
}

#requests ul li {
  padding: 7px 0;
  border-bottom: 1px solid #ddd;
}

#requests ul li:last-child {
  border-bottom: none;
}
.error-message {
  color:#B00020;
  font-size: 12px ;
  font-family: Roboto,sans-serif;
  margin-left: 13px;
}
</style>