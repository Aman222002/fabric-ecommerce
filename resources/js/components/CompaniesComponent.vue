<template>
  <v-dialog v-model="dialog" max-width="500">
    <v-alert
      v-if="warningMessage"
      :value="true"
      type="warning"
      dense
      outlined
      color="blue"
    >
      {{ warningMessage }}
    </v-alert>
    <v-card>
      <v-card-title>
        <span class="headline"
          >Add New Company
          <v-icon style="float: right" @click="dialog = false"
            >mdi-close</v-icon
          >
        </span>
      </v-card-title>
      <v-card-text>
        <v-form @submit.prevent="addUser" ref="form">
          <v-text-field
            v-model="newCompany.company_name"
            label="Company Name"
            density="compact"
            variant="outlined"
            :rules="nameRules"
            style="margin-top: 10px"
          ></v-text-field>

          <v-text-field
            v-model="newCompany.company_email"
            label="Company Email"
            density="compact"
            variant="outlined"
            :rules="emailRules"
            style="margin-top: 10px"
          ></v-text-field>
          <vue-tel-input
            variant="outlined"
            v-model="newCompany.phone_number"
            @validate="teluser"
            style="margin-top: 10px"
            label="Phone"
            type="phone"
            :inputOptions="tel_company"
            density="compact"
            mask="##########"
            hide-details="auto"
            mode="international"
            :autoDefaultCountry='false'
            :class="{'error-border': formSubmitted && newCompany.phoneErrors}"
          ></vue-tel-input>
          <span
            v-if="formSubmitted && newCompany.phoneErrors"
            class="error-message"
            >{{ newCompany.phoneErrors }}</span
          ><br />
          <v-text-field
            v-model="newCompany.name"
            label="User Name"
            density="compact"
            variant="outlined"
            :rules="nameRules"
            style="margin-top: 10px"
          ></v-text-field>

          <v-text-field
            v-model="newCompany.email"
            label="User Email"
            density="compact"
            variant="outlined"
            :rules="emailRules"
            style="margin-top: 10px"
          ></v-text-field>

          <v-text-field
            v-model="newCompany.password"
            label="User Password"
            type="password"
            density="compact"
            variant="outlined"
            :rules="passwordRules"
            style="margin-top: 10px"
          ></v-text-field>

          <vue-tel-input
            style="margin-top: 10px"
            variant="outlined"
            v-model="newCompany.phone"
            @validate="telval"
            label="Company Phone"
            type="phone"
            :inputOptions="tel_options"
            density="compact"
            mask="##########"
            hide-details="auto"
            mode="international"
            :autoDefaultCountry='false'
            :class="{'error-border': formSubmitted && newCompany.phoneError}"
          ></vue-tel-input>
          <span
            v-if="formSubmitted && newCompany.phoneError"
            class="error-message"
            >{{ newCompany.phoneError }}</span
          ><br />
          <v-btn
            color="primary"
            type="submit"
            @click="addUser"
            style="margin-top: 10px"
            >Add Company</v-btn
          >
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
  <v-dialog v-model="editDialog" max-width="500">
    <v-card>
      <v-card-title>
        <span class="headline"
          >Edit Company
          <v-icon style="float: right" @click="editDialog = false"
            >mdi-close</v-icon
          >
        </span>
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="editCompanyData.company_name"
          label="Company Name"
          dense
          outlined
          :rules="nameRules"
          style="margin-top: 10px"
        ></v-text-field>
        <v-text-field
          v-model="editCompanyData.company_email"
          label="Company Email"
          dense
          outlined
          :rules="emailRules"
          style="margin-top: 10px"
        ></v-text-field>

        <vue-tel-input
          style="margin-top: 10px"
          variant="outlined"
          @input="handlePhoneInput"
          :value="editCompanyData.phone_number"
          @validate="telvalidate"
          label="Company Phone"
          type="phone"
          density="compact"
          mask="##########"
          hide-details="auto"
          mode="international"
         
        ></vue-tel-input>
        <span v-if="formSubmitted && phoneVal" class="error-message">{{
          phoneVal
        }}</span
        ><br />

        <v-btn
          color="primary"
          @click="saveChanges(updateId)"
          style="margin-top: 10px"
          >Save Changes</v-btn
        >
      </v-card-text>
    </v-card>
  </v-dialog>
  <p style="text-align: center; font-size: 30px; margin-top: 20px">Companies</p>
  <DxDataGrid
    :remote-operations="true"
    :show-borders="true"
    :data-source="dataSource"
    @content-ready="onContentReady"
    @row-expanding="onRowExpanding"
    :onEditingStart="EditStart"
    @init-new-row="initNewRow"
    @row-inserted="rowInserted"
  >
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
      :allow-editing="false"
    ></DxColumn>
    <template #ButtonTemplate="{ data }">
      <v-btn
        color="primary"
        @click="approve(data)"
        :disabled="data.data.status === 0"
      >
        Block
      </v-btn>
      <v-btn
        color="secondary"
        @click="unblock(data)"
        :disabled="data.data.status === 1"
      >
        Unblock
      </v-btn>
    </template>

    <DxColumn cell-template="Dxbutton" width="auto"></DxColumn>
    <template #Dxbutton="{ data }">
      <v-btn
        prepend-icon="mdi-pencil"
        class="edit-btn"
        @click="editCompany(data.data)"
      ></v-btn>

      <v-btn
        prepend-icon="mdi-delete"
        class="btn_delete"
        @click="deleteCompany(data.data.id)"
      ></v-btn>
    </template>
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
import { Sweetalert } from "../utils/sweetalert";
export default {
  name: "CompaniesComponent",
  setup() {
    const form = ref(null);
    const showColumn = ref(false);
    const warningMessage = ref("");
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
    const formSubmitted = ref(false);
    const editDialog = ref(false);
    const editCompanyData = ref({
      company_name: "",
      company_email: "",
      phone_number: "",
    });
    const tel_company = {
      placeholder: "Enter Company phone number...",
    };
    const phoneVal = ref("");
    const updateId = ref();
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
      phoneErrors: "",
      phoneError: "",
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
    const handlePhoneInput = (event) => {
      try {
        if (typeof event === "string") {
          editCompanyData.value.phone_number = event;
        } else if (event && event.target && event.target.value) {
          editCompanyData.value.phone_number = event.target.value;
        } else {
          console.error("Invalid event:", event);
        }
      } catch (error) {
        console.error("Error handling phone input:", error);
      }
    };
    const telvalidate = (isValid) => {
      console.log("Is Valid:", isValid);

      if (isValid.valid === true) {
        console.log(isValid.value, "Valid Phone Number");
        phoneVal.value = "";
        return true;
      } else {
        console.log("Invalid Phone Number");
        phoneVal.value = "Enter a valid phone number";
        return false;
      }
    };
    const editCompany = (data) => {
      console.log(data);
      editDialog.value = true;
      editCompanyData.value.company_name = data.company_name;
      editCompanyData.value.company_email = data.company_email;
      editCompanyData.value.phone_number = data.phone_number;
      updateId.value = data.id;
    };
    //     const saveChanges = () => {
    //   console.log("Saving changes...");

    // };
    const saveChanges = (id) => {
      if (phoneVal.value) {
        telvalidate({
          isValid: false,
          number: editCompanyData.value.phone_number,
        });
        return;
      }
      axios
        .post(`/admin/company/update/${id}`, editCompanyData.value)
        .then((response) => {
          console.log("Update response:", response.data);

          editDialog.value = false;
          window.location.reload();
        })
        .catch((error) => {
          console.error("Update error:", error);
        });
    };
    const teluser = (telnumber) => {
      if (telnumber && telnumber.valid) {
        newCompany.value.phone_number = telnumber.number;
        if (/[a-zA-Z]/.test(telnumber.number)) {
          console.log("Alphabets detected in phone number");
          newCompany.value.phoneErrors =
            "Phone number cannot contain alphabets";
        } else {
          newCompany.value.phoneErrors = "";
        }
      } else {
        newCompany.value.phone_number = null;
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
        formSubmitted.value = true;
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
              .post("/company/check", {
                company_name: newCompany.value.company_name,
                company_email: newCompany.value.company_email,
              })
              .then((response) => {
                if (response.data.exists) {
                  warningMessage.value =
                    "Company Email And Company Name Already Exist.";
                } else {
                  axios
                    .post("/admin/company/store", newCompany.value)
                    .then(() => {
                      dialog.value = false;

                      Sweetalert.success("Company Added");
                    })
                    .catch((error) => {
                      console.error("Error:", error);
                    });
                }
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
        id: data.data.id,
        company_name: data.data.company_name,
        company_email: data.data.company_email,
        phone_number: data.data.phone_number,
      };
      console.log("Company:", requestData);
      axios
        .post(`/block-company/${userId}`, requestData)
        .then((response) => {
          console.log("API Response:", response.data);
          window.location.reload();
        })

        .catch((error) => {
          console.error("API Error:", error);
        });
    };
    const unblock = (data) => {
      console.log(data);
      const userId = data.data.id;
      const requestData = {
        id: data.data.id,
        company_name: data.data.company_name,
        company_email: data.data.company_email,
        phone_number: data.data.phone_number,
      };
      console.log("Company:", requestData);
      axios
        .post(`/unblock-company/${userId}`, requestData)
        .then((response) => {
          console.log("API Response:", response.data);
          window.location.reload();
        })

        .catch((error) => {
          console.error("API Error:", error);
        });
    };
    const deleteCompany = (id) => {
      Sweetalert.confirm("Are you sure?").then((result) => {
        if (result.isConfirmed) {
          try {
            axios.delete(`/admin/company/destroy/${id}`).then((response) => {
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
    const tel_options = {
      placeholder: "Enter User phone number...",
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
      warningMessage,
      editCompany,
      editDialog,
      editCompanyData,
      telvalidate,
      saveChanges,
      updateId,
      handlePhoneInput,
      pageSize,
      newCompany,
      dialog,
      openDialog,
      addUser,
      teluser,
      telval,
      passwordRules,
      emailRules,
      nameRules,
      approve,
      unblock,
      phoneVal,
      deleteCompany,
      tel_company,
      tel_options,
      formSubmitted,
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
  color: #b00020;
  font-size: 12px;
  font-family: Roboto, sans-serif;
  margin-left: 13px;
}
.error-border {
  border-color: #B00020 !important; 
}
</style>
