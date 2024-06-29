<template>
  <p style="text-align: center; font-size: 30px; margin-top: 20px">Users</p>
  <!-- <v-btn @click="dialog = true" style="position: absolute; top: 90px; right: 150px;">
      <v-icon>mdi-plus</v-icon>
    </v-btn> -->
  <v-dialog v-model="dialog" max-width="600px">
    <v-card>
      <v-card-title>
        <span class="headline"
          >Add User :
          <v-icon style="float: right" @click="dialog = false"
            >mdi-close</v-icon
          >
        </span>
      </v-card-title>
      <v-card-text>
        <v-alert
          v-if="errorMessage"
          :value="true"
          type="warning"
          dense
          outlined
          color="blue"
        >
          {{ errorMessage }}
        </v-alert>

        <v-form @submit.prevent="addUser" ref="form">
          <v-row>
            <v-col cols="12">
              <v-text-field
                v-model="userData.name"
                label="Name"
                dense
                :rules="nameRules"
                variant="solo"
            density="compact"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="userData.email"
                label="Email"
                dense
                :rules="emailRules"
                variant="solo"
            density="compact"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <vue-tel-input
                v-model="userData.phone"
                @validate="telValidate"
                variant="solo"
                density="compact"
                mode="international"
                :autoDefaultCountry='false'
                :class="{'error-border': formSubmitted && userData.phoneError}"
              ></vue-tel-input>
              <span v-if="formSubmitted && userData.phoneError" class="error-message">
                {{ userData.phoneError }}
              </span>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="userData.permission"
                :items="userPermissions"
                item-value="id"
                item-text="name"
                label="Permission"
                multiple
                chips
                dense
                small-chips
                :rules="permissionRules"
                variant="solo"
            density="compact"
              ></v-select>
            </v-col>
          </v-row>
          <v-btn type="submit" color="primary"> Send Invitation </v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
    :remote-operations="true"
    ref="dataGridRef"
  >
    <DxToolbar>
      <DxGridItem template="addButton" :location="'after'"></DxGridItem>
      <DxGridItem template="dropDown2" :location="'before'" />
      <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
    </DxToolbar>
    <DxEditing mode="row" :use-icons="true" :allow-deleting="true"> </DxEditing>
    <DxSearchPanel :visible="true" />
    <DxColumn
      v-if="selectedStatus === 'All'"
      data-field="name"
      data-type="string"
    ></DxColumn>
    <DxColumn
      v-if="selectedStatus === 'All'"
      data-field="email"
      data-type="string"
    ></DxColumn>
    <DxColumn
      v-if="selectedStatus !== 'All'"
      data-field="user_email"
      data-type="string"
    ></DxColumn>
    <DxColumn
      v-if="selectedStatus === 'All'"
      data-field="phone"
      data-type="string"
    ></DxColumn>
    <DxColumn
      v-if="selectedStatus !== 'All'"
      data-field="status"
      data-type="string"
    ></DxColumn>
    <DxPaging :page-size="pageSize" />
    <DxPager
      :visible="true"
      :allowed-page-sizes="[5, 10, 15]"
      :display-mode="'compact'"
      :show-page-size-selector="true"
      :show-navigation-buttons="true"
      :show-info="true"
    />
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
        >
        </DxList>
      </DxDropDownBox>
    </template>
    <DxPaging :page-size="pageSize" />
    <DxPager
      :visible="true"
      :allowed-page-sizes="[10, 15, 20]"
      :display-mode="'compact'"
      :show-page-size-selector="true"
      :show-navigation-buttons="true"
      :show-info="true"
    />
    <DxSummary>
      <DxTotalItem column="id" summary-type="count" />
    </DxSummary>
    <template #addButton>
      <DxButton icon="add" @click="dialog = true"></DxButton>
    </template>
  </DxDataGrid>
</template>

<script>
import axios from "axios";
import dxGridStore from "../composition/dxGridStore";
import { ref, onMounted, computed } from "vue";
import {Sweetalert} from '../utils/sweetalert';

export default {
  name: "companyusers",

  setup() {
    const dataGridRef = ref(null);
    const DropDown2 = ref(false);
    const params = ref({});
    const pageSize = ref(5);
    const selectedStatus = ref("All");
    const selectStatus = (e) => {
      const value = e.itemData.text;
      params.value = { type: value };
      selectedStatus.value = value;
      DropDown2.value = false;
      refreshTable(dataGridRef);
    };
    const formSubmitted = ref(false);
    const items = ref([
      {
        text: "All",
        value: 1,
      },
      {
        text: "Invited",
        value: 2,
      },
      {
        text: "Rejected",
        value: 3,
      },
    ]);
    const loadUrl = `/fetch-user`;
    const deleteUrl = `/destroy`;
    const { dataSource, refreshTable } = dxGridStore(
      loadUrl,
      params,
      null,
      null,
      deleteUrl
    );
    const userData = ref({
      name: "",
      email: "",
      phone: "",
      permission: [],
      phoneError: "",
    });
    const dialog = ref(false);
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const permissionRules = [
      (v) => (!!v && v.length > 0) || "Permission is required",
    ];

    const form = ref(null);

    const phoneRules = [
      (v) => !!v || "Phone number is required",
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];
    const errorMessage = ref("");

    const telValidate = (telnumber) => {
      if (telnumber && telnumber.valid) {
        if (!telnumber.number || telnumber.number.trim() === "") {
          userData.value.phone = null;
      userData.value.phoneError = "Phone number is required";
    } else{
        userData.value.phone = telnumber.number;
        if (/[a-zA-Z]/.test(telnumber.number)) {
          userData.value.phoneError = "Enter a valid phone number";
        } else {
          userData.value.phoneError = "";
        }
      }
      } else {
        userData.value.phone = null;
        userData.value.phoneError = "Enter a valid phone number";
      }
    };
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
    const selectCategory = (selectedCategory) => {
      userData.permission = selectedCategory.name;
    };
    const checkUsername = async () => {
      try {
        const response = await axios.post("/check-username", {
          username: userData.value.name,
        });
        return response.data.available;
      } catch (error) {
        console.error("Error checking username availability:", error);
        return false;
      }
    };

    onMounted(fetchPermissions);

    const addUser = async () => {
      formSubmitted.value = true;
      telValidate({ valid: true, number: userData.value.phone });
      if (userData.value.phoneError) {
        return;
      }
      try {
        const usernameAvailable = await checkUsername();
        if (!usernameAvailable) {
          errorMessage.value = "Username already exist.";
          return;
        }
        const valid = await form.value.validate();
        if (!valid.valid) {
          const errors = JSON.parse(JSON.stringify(valid.errors));
          let errorField = form.value[errors[0].id];
          errorField = Array.isArray(errorField) ? errorField[0] : errorField;
          errorField.scrollIntoView({
            behavior: "smooth",
            block: "center",
            inline: "center",
          });
        
          Sweetalert.error('use valid data')
        } else {
          await axios.post("/admin/user/addnewuser", userData.value);
          userData.value.permission.forEach((permission) => {
            //console.log(permission);
          });
        
          Sweetalert.success('Invitation sent Successfully to the user Email')
          dialog.value = false;
        }
      } catch (error) {
        console.error("Error during invitation:", error);
      }
    };

    return {
      dataSource,
      items,
      selectStatus,
      selectedStatus,
      DropDown2,
      dataGridRef,
      params,
      pageSize,
      userData,
      userPermissions,
      addUser,
      nameRules,
      emailRules,
      permissionRules,
      telValidate,
      errorMessage,
      dialog,
      form,
      checkUsername,
      phoneRules,formSubmitted,
    };
  },
};
</script>
<style scoped>
.error-message {
  color:#B00020;
  font-size: 12px ;
  font-family: Roboto,sans-serif;
  margin-left: 13px;
}
.error-border {
  border-color: #B00020 !important; 
}
</style>
