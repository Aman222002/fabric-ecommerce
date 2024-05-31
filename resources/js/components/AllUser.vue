
<template>
  <div>
    <v-dialog v-model="modalOpen" max-width="700">
      <v-card>
        <v-card-title>
          <span class="headline">Add User
            <v-icon style="float: right" @click="closeModal">mdi-close</v-icon>
          </span>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="addUser"  ref="form">
            <v-text-field v-model="newUser.name" label="Name" :rules="nameRules"></v-text-field>
            <v-text-field v-model="newUser.email" label="Email" :rules="emailRules"></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="newUser.password"
              label="Password"
              :rules="passwordRules"
              density="compact"
              outlined
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              @click:append="showPassword = !showPassword"
              :type="showPassword ? 'text' : 'password'"
            ></v-text-field>
            <v-select
              v-model="newUser.role"
              :items="roles"
              label="Role"
              dense
            ></v-select>
            <v-text-field
              v-if="newUser.role === 'Company Admin'"
              v-model="newUser.companyName"
              label="Company Name"
              :rules="nameRules"
            ></v-text-field>
            <v-text-field
              v-if="newUser.role === 'Company Admin'"
              v-model="newUser.companyEmail"
              label="Company Email"
              :rules="emailRules"
            ></v-text-field>
            <vue-tel-input
              v-if="newUser.role === 'Company Admin'"
              variant="outlined"
              v-model="newUser.companyPhone"
              @validate="telval"
              label="Company Phone"
              type="phone"
              density="compact"
              mask="##########"
              hide-details="auto"
              mode="international"
            ></vue-tel-input>
            <span v-if="newUser.phoneError" class="error-message">{{ newUser.phoneError }}</span><br>
            <v-select
              v-if="newUser.role === 'Company Subadmin'"
              variant="solo"
              v-model="newUser.companyId"
              :items="companies"
              item-title="company_name"
              item-value="id"
              label="Select Company"
              density="compact"
            ></v-select>
            <v-select
              v-if="newUser.role === 'Company Subadmin'"
              v-model="newUser.permission"
              :items="userPermissions"
              item-value="id"
              item-text="name"
              label="Permission"
              multiple
              chips
              :rules="permissionRules"
              variant="solo"
              density="compact"
              small-chips
            ></v-select>
            <vue-tel-input
              variant="outlined"
              v-model="newUser.phone"
              @validate="teluser"
             
              label="Phone"
              type="phone"
              density="compact"
              mask="##########"
              hide-details="auto"
              mode="international"
            ></vue-tel-input>
            <span v-if="newUser.phoneErrors" class="error-message">{{ newUser.phoneErrors }}</span><br>
            <v-btn type="submit" color="primary">Add User</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <p style="text-align: center; font-size: 30px; margin-top: 20px">Users</p>
    <DxDataGrid
      :show-borders="true"
      :data-source="dataSource"
      :allow-column-resizing="true"
      ref="dataGridRef"
      @init-new-row="initNewRow" @row-inserted="rowInserted"
        @editing-start="logEvent" @edit-canceled="cancelEdit" @saving="saveEvent"
    >
      <DxEditing
        :allow-adding="true"
        :allow-updating="true"
        :allow-deleting="true"
        :use-icons="true"
        mode="popup"
      >
      <DxPopup
          :show-title="true"
          :width="600"
          :height="400"
          title="User Info"
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
            <!-- <DxFormItem  edit-cell-template="phone-template"/> -->
          <!-- <DxFormItem data-field="roles"/>
          <DxFormItem caption="company"  :visible="isCompanyAdmin" />
          <DxFormItem caption="company Email"  :visible="isCompanyAdmin"/>
          <DxFormItem caption="company Phone"  :visible="isCompanyAdmin"/> -->
    </DxFormItem>
        </DxForm>
        </DxEditing>
      <DxSearchPanel :visible="true" :placeholder="'Search'" :width="300" />
      <DxToolbar>
        <DxGridItem template="addButton" :location="'after'"></DxGridItem>
        <DxGridItem template="dropDown2" :location="'before'" />
        <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
      </DxToolbar>
      <DxSearchPanel :visible="true" />
      <DxColumn data-field="name" data-type="string">
        <DxRequiredRule />
      </DxColumn>
      <DxColumn data-field="email" data-type="string">
        <DxRequiredRule />
        <DxEmailRule message="Email is invalid" />
      </DxColumn>
      <DxColumn data-field="phone" data-type="phone">
        
      </DxColumn>
      <!-- <DxColumn data-field="company" data-type="string"></DxColumn>
        <DxColumn data-field="company_email" data-type="string"></DxColumn>
          <DxColumn data-field="phone_number" data-type="phone" >
      </DxColumn> -->
      <!-- <DxColumn data-field="roles" data-type="string" cell-template="role-template" edit-cell-template="rolesdropdown"></DxColumn>
      <template #rolesdropdown>
            <DxDropDownBox :accept-custom-value="true" label="Select Role" labelMode="floating"
                v-model:value="selectedRoleType" v-model:opened="roletypedropdown">
                <DxList :data-source="roleTypes" selection-mode="single" @item-click="selectRoleType" />
            </DxDropDownBox>
        </template>
        <template #role-template="{ data: cell }">
            <span >
                <span v-for="(roles, index) in cell.data.roles" :key="index">
                    {{ roles }}
                </span>
            </span>
        </template> -->
      <DxColumn type="buttons" caption="Action">
        <DxButton name="edit"></DxButton>
        <DxButton name="delete"></DxButton>
      </DxColumn>
      <DxPaging :page-size="pageSize" />
      <template #addButton>
        <DxButton icon="add" @click="openModal"></DxButton>
      </template>
      <template #dropDown2>
        <DxDropDownBox
          :accept-custom-value="true"
          @value-change="selectStatus"
          label="Select status"
          labelMode="floating"
          v-model:value="selectedStatus"
          v-model:opened="DropDown2"
        >
          <DxList
            :data-source="items"
            selection-mode="single"
            @item-click="selectStatus"
          ></DxList>
        </DxDropDownBox>
      </template>
      <DxPager
        :visible="true"
        :allowed-page-sizes="[15, 20, 30]"
        :display-mode="'compact'"
        :show-page-size-selector="true"
        :show-navigation-buttons="true"
        :show-info="true"
      />
      <DxSummary>
        <DxTotalItem column="id" summary-type="count" />
      </DxSummary>
<!--     
      <template #phone-template="{ data, setValue }">
    
      <vue-tel-input
        v-model="data.phone"
        @input="(value) => setValue(value)"
        label="Phone"
        type="phone"
        mask="##########"
        mode="international"
       
      ></vue-tel-input>
    </template> -->

    </DxDataGrid>

    
  </div>
</template>

<script>
import dxGridStore from "../composition/dxGridStore";
import { ref, onMounted,watch,computed } from "vue";
import axios from "axios";

export default {
  name: "CompaniesComponent",
  setup() {
    const form = ref(null);
    const modalOpen = ref(false);
    const newUser = ref({
      name: "",
      email: "",
      phone: "",
      phoneErrors: "",
      password: "",
      role: "User",
      companyEmail: "",
      companyName: "",
      companyPhone: "",
      phoneError: "",
      companyId: "",
      permission: [],
    });

    const loadURL = `/admin/user/index`;
    const updateURL = `/admin/user/updated`;
    const insertURL = `/admin/user/store`;
    const deleteUrl = `/admin/user/destroy`;

    const nameRules = [
      (v) => !!v || "Full Name is required",
      (v) => (v && v.length >= 3) || "Full Name must be at least 3 characters",
    ];
    const emailRules = [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ];
    const passwordRules = [
      (v) => !!v || "Password is required",
      (v) => (v && v.length >= 6) || "Password must be at least 6 characters",
    ];
    const permissionRules = [(v) => (!!v && v.length > 0) || "Permission is required"];
    const userPermissions = ref([]);

    const fetchPermissions = async () => {
      try {
        const response = await axios.get("/permission");
        userPermissions.value = response.data.map((data) => data.name);
        console.log(userPermissions.value);
      } catch (error) {
        console.error("Error fetching permissions:", error);
      }
    };
    const isCompanyAdmin = computed(() => newUser.value.role === "Company Admin");
   
    const userId = ref();
    const pageSize = ref(15);
    const DropDown2 = ref(false);
    const params = ref({});
    const selectedStatus = ref("All");
    const dataGridRef = ref(null);
    const { dataSource, refreshTable } = dxGridStore(loadURL,  params, insertURL, updateURL, deleteUrl);
    const showPassword = ref(false);
    const showColumn = ref(false);
    const selectStatus = (e) => {
      const value = e.itemData.text;
      params.value = { type: value };
      console.log('After assignment - params:', params.value);
      selectedStatus.value = value;
      DropDown2.value = false;
      refreshTable(dataGridRef);
    };
    const roleTypes = ref([
            'Company Admin',
            'Company Subadmin',
            'User',
        ]);
        const roletypedropdown = ref(false);
        const selectedRoleType = ref("");
        const selectRoleType = (e) => {
            let value = e.itemData;
            selectedRoleType.value = value;
            params.value = { ...params.value, roleType: selectedRoleType.value };
            roletypedropdown.value = false;
        };
        const saveEvent = (e) => {

if (e.changes == 0) {
    if (params.value.roleType) {
       
        axios.post(`/admin/user/updated/${userId.value}`, {
            roleType: params.value,
        }).then((response) => {
            const keys = Object.keys(params.value);
            for (let i = 1; i < keys.length; i++) {
                delete params.value[keys[i]];
            }
            // console.log(params.value);
            refreshTable(dataGridRef);
        })

    };
}
}
const initNewRow = (e) => {
            selectedRoleType.value = null
            showColumn.value = true;
        };
        const rowInserted = (e) => {
            showColumn.value = false;
        };

const logEvent = (e) => {
  userId.value = e.data.id;
  showColumn.value = false;
  if (e.data.roles && e.data.roles.length > 0) {
    selectedRoleType.value = e.data.roles[0]; 
  } else {
    selectedRoleType.value = ""; 
  }
};


        const cancelEdit = (e) => {
            showColumn.value = false;
        }

    const items = ref([
      { text: "All", value: 1 },
      { text: "Company Admin", value: 2 },
      { text: "User", value: 3 },
      { text: "Company Subadmin", value: 4 },
    ]);

    const roles = ["User", "Company Admin", "Company Subadmin"];

    const openModal = () => {
      modalOpen.value = true;
    };

    const companies = ref([]);
    const fetchCompany = async () => {
      try {
        const response = await axios.get("/admin/user/companies");
        companies.value = response.data;
      } catch (error) {
        console.error("Error fetching companies:", error);
      }
    };

    const teluser = (telnumber) => {
      if (telnumber && telnumber.valid) {
        newUser.value.phone = telnumber.number;
        if (/[a-zA-Z]/.test(telnumber.number)) {
          console.log("Alphabets detected in phone number");
          newUser.value.phoneErrors = "Phone number cannot contain alphabets";
        } else {
          newUser.value.phoneErrors = "";
        }
      } else {
        newUser.value.phone = null;
        newUser.value.phoneErrors = "Enter a valid phone number";
      }
    };

    const telval = (telnumber) => {
      if (telnumber && telnumber.valid) {
        newUser.value.companyPhone = telnumber.number;
        if (/[a-zA-Z]/.test(telnumber.number)) {
          console.log("Alphabets detected in phone number");
          newUser.value.phoneError = "Phone number cannot contain alphabets";
        } else {
          newUser.value.phoneError = "";
        }
      } else {
        newUser.value.companyPhone = null;
        newUser.value.phoneError = "Enter a valid phone number";
      }
    };

    const fetchJobs = (value) => {
      console.log(value);
      params.value = { type: value };
      console.log(params.value);
      refreshTable(dataGridRef);
      DropDown2.value = false;
    };

    const closeModal = () => {
      modalOpen.value = false;
      newUser.value = {
        name: "",
        email: "",
        phone: "",
        phoneErrors: "",
        password: "",
        role: "",
        companyEmail: "",
        companyName: "",
        companyPhone: "",
        phoneError: "",
        companyId: "",
        permission: [],
      };
    };

    const addUser = async () => {
  try {
    teluser({ valid: true, number: newUser.value.phone });
         if (newUser.value.phoneErrors) {
           return;
         }
         telval({ valid: true, number: newUser.value.companyPhone });
         if (newUser.value.phoneError) {
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
          .post("/admin/user/storing", newUser.value)
          .then(() => {
            closeModal();
            window.Swal.fire({
              toast: true,
              position: "top-end",
              timer: 2000,
              showConfirmButton: false,
              icon: "success",
              title: "User Added",
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
watch(selectedRoleType, (newVal) => {
  console.log(selectedRoleType);
      if (newVal === "Company Admin") {
        newUser.value.role = "Company Admin";
      } else if (newVal === "Company Subadmin") {
        newUser.value.role = "Company Subadmin";
      } else {
        newUser.value.role = "User";
      }
    });

    onMounted(() => {
      fetchCompany();
      fetchPermissions();
    });
    return {
      modalOpen,
      newUser,
      dataSource,
      openModal,
      closeModal,
      addUser,
      teluser,
      showPassword,
      nameRules,
      emailRules,
      passwordRules,
      selectedStatus,
      items,
      selectStatus, 
      params,
      DropDown2,
      dataGridRef,
      pageSize,
      fetchJobs,
      roles,
      telval,
      companies,
      fetchPermissions,
      userPermissions,
      permissionRules,form,
      initNewRow,
            rowInserted,
            roleTypes,
            selectRoleType,
            selectedRoleType,
            roletypedropdown,
            logEvent,
            cancelEdit,
            saveEvent,userId, showColumn,isCompanyAdmin
    };
  },
};
</script>

<style scoped>
.error-message {
  color: rgb(204, 65, 65);
  font-size: 13px;
}
</style>

