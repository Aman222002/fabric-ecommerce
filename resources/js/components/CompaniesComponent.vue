<template>
   <v-dialog v-model="dialog" max-width="500"  >
   
    
    <v-card>
      <v-card-title>
        <span class="headline">Add New Company
          <v-icon style="float: right" @click="dialog = false" >mdi-close</v-icon>
        </span>
      </v-card-title>
      <v-card-text>
        <v-form @submit.prevent="addUser" ref="form">
        <v-text-field v-model="newCompany.company_name" label="Company Name"   density="compact"  variant="outlined" :rules="nameRules" style="margin-top: 10px"></v-text-field>
   
        <v-text-field v-model="newCompany.company_email" label="Company Email" density="compact"  variant="outlined"  :rules="emailRules" style="margin-top: 10px"></v-text-field>
        <vue-tel-input
              variant="outlined"
              v-model="newCompany.phone_number"
              @validate="teluser"
              style="margin-top: 10px"
              label="Phone"
              type="phone"
              density="compact"
              mask="##########"
              hide-details="auto"
              mode="international"
            ></vue-tel-input>
            <span v-if="newCompany.phoneErrors" class="error-message" >{{ newCompany.phoneErrors }}</span><br>
        <v-text-field  v-model="newCompany.name" label="User Name" density="compact"  variant="outlined" :rules="nameRules" style="margin-top: 10px"></v-text-field>
       
        <v-text-field  v-model="newCompany.email" label="User Email" density="compact"  variant="outlined" :rules="emailRules" style="margin-top: 10px"></v-text-field>
    
        <v-text-field  v-model="newCompany.password" label="User Password" type="password" density="compact"  variant="outlined" :rules="passwordRules" style="margin-top: 10px"></v-text-field>
      
     
        <vue-tel-input
        style="margin-top: 10px"
              variant="outlined"
              v-model="newCompany.phone"
              @validate="telval"
              label="Company Phone"
              type="phone"
              density="compact"
              mask="##########"
              hide-details="auto"
              mode="international"
            ></vue-tel-input>
            <span v-if="newCompany.phoneError" class="error-message">{{ newCompany.phoneError }}</span><br>
        <v-btn color="primary" type="submit" @click="addUser" style="margin-top: 10px">Add Company</v-btn>
      </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
  <p style="text-align: center; font-size: 30px; margin-top: 20px">Companies</p>
  <DxDataGrid
    :remote-operations="true"
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
    @content-ready="onContentReady"
    @row-expanding="onRowExpanding"
    :onEditingStart="EditStart"
    @init-new-row="initNewRow"
    @row-inserted="rowInserted"
  >
    <DxEditing
      :allow-adding="true"
      :allow-updating="true"
      :allow-deleting="true"
      mode="popup"
      :use-icons="true"
    >
    <DxPopup
          :show-title="true"
          :width="700"
          :height="400"
          title="Company Info"
        />
        <DxForm>
          <DxFormItem
            :col-count="2"
            :col-span="2"
            item-type="group"
          >
            <DxFormItem data-field="company_name"/>
            <DxFormItem data-field="company_email"/>
            <DxFormItem data-field="phone_number"/>
        
           
    </DxFormItem>
        </DxForm>
      </DxEditing>
    <DxSearchPanel :visible="true" />
    <DxToolbar>
        <DxGridItem template="addButton" :location="'after'"></DxGridItem>
     
        <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
      </DxToolbar>
    <DxColumn data-field="company_name" data-type="string">
      <DxRequiredRule />
    </DxColumn>
    <DxColumn data-field="company_email" data-type="string">
      <DxRequiredRule />
    </DxColumn>
   
    <DxColumn data-field="phone_number" data-type="string" />
    <DxColumn
      caption="Options"
      cell-template="ButtonTemplate"
    ></DxColumn>
    <template #ButtonTemplate="{ data }">
       
        <v-btn 
          color="primary" 
          @click="approve(data)" 
          
        >
         Block
        </v-btn>
        <v-btn 
    color="secondary" 
    @click="unblock(data)"
   
  >
    Unblock
  </v-btn>
    
    </template>
    <DxColumn type="buttons" caption="Action"></DxColumn>
  
    <DxMasterDetail :enabled="true" template="masterDetailTemplate" />
    <template #masterDetailTemplate="{ data: cellInfo }">
      <masterDetailTemplate :company-info="cellInfo.data" />
    </template>
    <DxPaging :page-size="pageSize" />
    <DxPager
      :visible="true"
      :allowed-page-sizes="[15, 20, 30]"
      :display-mode="'compact'"
      :show-page-size-selector="true"
      :show-navigation-buttons="true"
      :show-info="true"
    />
    <template #addButton>
        <DxButton icon="add" @click="openDialog"></DxButton>
      </template>
    <DxSummary>
      <DxTotalItem column="id" summary-type="count" />
    </DxSummary>
  </DxDataGrid>
</template>
<script>
import {
  DxPaging,
  DxRequiredRule,
  DxToolbarItem,
} from "devextreme-vue/data-grid";
import dxGridStore from "../composition/dxGridStore";
import { ref } from "vue";
import masterDetailTemplate from "./MasterdetailView.vue";
import axios from "axios";
export default {
  name: "CompaniesComponent",
  setup() {
    const form = ref(null);
    const showColumn = ref(false);
    const namePattern = ref(/^[a-zA-Z\s][a-zA-Z0-9_\s]{2,20}$/);
    const emailPattern = ref(/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/);
    const phonePattern = ref("^[0-9]{9,13}$");
    const paswordPattern = ref(/^.{8,}$/);
    const loadURL = `/admin/company/getCompanies`;
    const insertURL = `/admin/company/store`;
    const updateURL = `/admin/company/update`;
    const deleteUrl = `/admin/company/destroy`;
    const pageSize = ref(15);
    const { dataSource } = dxGridStore(
      loadURL,
      null,
      insertURL,
      updateURL,
      deleteUrl
    );
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const passwordRules = [(v) => !!v || "Password is required"];
    const dialog = ref(false);
    const newCompany = ref({
      company_name: "",
      company_email: "",
      phone_number: "",
      name: "",
      email: "",
      password: "",
      phone: "",
      phoneErrors:"",
      phoneError:"",

    });
    const openDialog = () => {
      dialog.value = true;
    };

   
    const onRowExpanding = (e) => {
      e.component.collapseAll(-1);
    };
    const onContentReady = (e) => {
      if (!e.component.getSelectedRowKeys().length) {
        e.component.selectRowsByIndexes(0);
      }
    };
    const initNewRow = (e) => {
      e.data.status = "1";
      showColumn.value = true;
    };
    const EditStart = (e) => {
      showColumn.value = false;
    };
    const rowInserted = (e) => {
      showColumn.value = false;
    };
    const teluser = (telnumber) => {
      if (telnumber && telnumber.valid) {
        newCompany.value.phone_number = telnumber.number;
        if (/[a-zA-Z]/.test(telnumber.number)) {
          console.log("Alphabets detected in phone number");
          newCompany.value.phoneErrors = "Phone number cannot contain alphabets";
        } else {
          newCompany.value.phoneErrors = "";
        }
      } else {
        newCompany.value.phone_number= null;
        newCompany.value.phoneErrors = "Enter a valid phone number";
      }
    };
    const telval = (telnumber) => {
      if (telnumber && telnumber.valid) {
        newCompany.value.phone = telnumber.number;
        if (/[a-zA-Z]/.test(telnumber.number)) {
          console.log("Alphabets detected in phone number");
          newCompany.value.phoneError = "Phone number cannot contain alphabets";
        } else {
          newCompany.value.phoneError = "";
        }
      } else {
        newCompany.value.phone = null;
        newCompany.value.phoneError = "Enter a valid phone number";
      }
    };
const addUser = async () => {
  try {
    teluser({ valid: true, number: newCompany.value.phone_number });
    if (newCompany.value.phoneErrors) {
      return;
    }
    telval({ valid: true, number: newCompany.value.phone });
    if (newCompany.value.phoneError) {
      return;
    }

    form.value.validate().then((valid) => {
      if (!valid.valid) {
        const errors = JSON.parse(JSON.stringify(valid.errors));
        let errorField = form.value[errors[0].id];
        errorField = Array.isArray(errorField) ? errorField[0] : errorField;
        errorField.scrollIntoView({
          behavior: "smooth",
          block: "center",
          inline: "center",
        });
      } else {
        axios
          .post("/admin/company/store", newCompany.value)
          .then(() => {
            dialog.value = false;
            window.Swal.fire({
              toast: true,
              position: "top-end",
              timer: 2000,
              showConfirmButton: false,
              icon: "success",
              title: "Company Added",
            });
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      }
    });
  } catch (error) {
    console.error("Error:", error);
  }
};
const approve = (data) => {
    console.log(data);
    const userId = data.data.id;
    const requestData = {
        id:data.data.id,
        company_name: data.data.company_name,
        company_email: data.data.company_email,
        phone_number: data.data.phone_number
    };
    console.log('Company:', requestData);
    axios.post(`/block-company/${userId}`, requestData)
        .then(response => {
         
            console.log('API Response:', response.data);
             window.location.reload();
        })
       
        .catch(error => {
            console.error('API Error:', error);
        });
};
const unblock = (data) => {
    console.log(data);
    const userId = data.data.id;
    const requestData = {
        id:data.data.id,
        company_name: data.data.company_name,
        company_email: data.data.company_email,
        phone_number: data.data.phone_number
    };
    console.log('Company:', requestData);
    axios.post(`/unblock-company/${userId}`, requestData)
        .then(response => {
         
            console.log('API Response:', response.data);
            window.location.reload();
        })
       
        .catch(error => {
            console.error('API Error:', error);
        });
};

    return {
      form,
      dataSource,
      showColumn,
      EditStart,
      initNewRow,
      rowInserted,
      namePattern,
      emailPattern,
      phonePattern,
      onRowExpanding,
      paswordPattern,
      onContentReady,
      pageSize,newCompany,dialog,openDialog,addUser,teluser,telval,passwordRules,emailRules,nameRules,approve,unblock
    };
  },
  components: { DxRequiredRule, masterDetailTemplate, DxPaging, DxToolbarItem },
};
</script>
<style scoped>
.container {
  margin-top: 15px;
  margin-left: 90px;
  width: 90%;
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
  content: "";
  display: table;
  clear: both;
}

#requests #clear {
  float: right;
}

#requests ul {
  list-style: none;
  max-height: 100px;
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
  color: rgb(204, 65, 65);
  font-size: 13px;
}
</style>
