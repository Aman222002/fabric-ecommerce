<!-- 
   <template>
  <p style="text-align: center; font-size: 20px; margin-top: 20px">Add User</p>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
    :remote-operations="true"
    @init-new-row="initNewRow"
    @row-inserted="rowInserted"
  >
    <DxEditing
      mode="row"
      :allow-updating="true"
      :allow-deleting="true"
      :allow-adding="true"
      :use-icons="true"
    >
    </DxEditing>
    <DxSearchPanel :visible="true" />

    <DxScrolling mode="virtual" row-rendering-mode="virtual" />

    <DxColumn data-field="name" data-type="string"> </DxColumn>
    <DxColumn data-field="email" data-type="string"></DxColumn>
    
    <DxColumn data-field="phone" data-type="string"> </DxColumn>
    <DxColumn
      data-field="permission"
      data-type="string"
      cell-template="demodropdown"
      edit-cell-template="demodropdown"
    >
    </DxColumn>
    <template #demodropdown>
     
      <DxDropDownBox
        label="Permission"
        labelMode="floating"
        mode="multiple"
        :accept-custom-value="true"
        @value-change="selectStatus"

      >
        <DxList
          :data-source="userpermission"
          selection-mode="multiple"
          @item-click="selectStatus"
        >
        
        </DxList>
      </DxDropDownBox> 
    </template>
   
     
  </DxDataGrid>
</template>
      <script >
import axios from "axios";

import dxGridStore from "../composition/dxGridStore";

import { ref, onMounted } from "vue";

export default {
  name: "user",
  components: {},
  setup() {
    const showColumn = ref(false);
    const loadUrl = `/fetch-user`;
    const params = ref({});
    const insertURL = `/admin/user/addnewuser`;
    const selectedStatus = ref([]);
    const selectStatus = (e) => {
      const value = e.itemData;
      console.log(value);
      params.value = { permision: value };
      console.log(params.value);
      selectedStatus.value = value;
    };
    const { dataSource } = dxGridStore(loadUrl, params, insertURL, null, null);
    const userpermission = ref([]);
    const fetchJobSkill = async () => {
      try {
        axios.get("/permission").then((response) => {
          userpermission.value = response.data.map((data) => data.name);
        });
      } catch (error) {
        console.error("Error fetching job types:", error);
      }
    };
    const initNewRow = (e) => {
      e.data.status = "1";
      showColumn.value = true;
    };
    const rowInserted = (e) => {
      showColumn.value = false;
    };
    onMounted(() => {
      fetchJobSkill();
    });
    
    return {
      dataSource,
      userpermission,
      params,
      initNewRow,
      rowInserted,
      showColumn,
       selectStatus,
      selectedStatus,
    };
  },
};
</script> -->
<template>
  <v-container fluid style="margin-top: 30px;">
    <v-row justify="center">
      <v-col cols="12" sm="8">
        <v-form @submit.prevent="addUser">
          <v-row>
            <v-col cols="7">
              <v-text-field v-model="userData.name" label="Name" variant="outlined" density="compact"></v-text-field>
            </v-col>
            <v-col cols="7">
              <v-text-field v-model="userData.email" label="Email" variant="outlined" density="compact"></v-text-field>
            </v-col>
            <v-col cols="7">
              <v-text-field v-model="userData.phone" label="Phone" variant="outlined" density="compact"></v-text-field>
            </v-col>
            <v-col cols="7">
              <v-select
                v-model="userData.permission"
                :items="userPermissions"
                item-value="id"
                item-text="name"
                label="Permission"
                multiple
                chips
                variant="outlined"
                density="compact"
                small-chips
              ></v-select>
            </v-col>
          </v-row>
          <v-row justify="center">
            <v-col cols="12">
              <v-btn type="submit" color="primary" style="text-align: center;">Send Invitation</v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "UserForm",
  setup() {
    const userData = ref({
      name: "",
      email: "",
      phone: "",
      permission:[]
    });

    const userPermissions = ref([]);

    const fetchPermissions = async () => {
      try {
        const response = await axios.get("/permission");
        userPermissions.value = response.data.map(data => data.name);
        console.log( userPermissions.value)
      } catch (error) {
        console.error("Error fetching permissions:", error);
      }
    };
    const selectCategory = (selectedCategory) => {
      userData.permission = selectedCategory.name; 
    };

    onMounted(fetchPermissions);

    const addUser = async () => {
      try {
        await axios.post("/admin/user/addnewuser", userData.value);
        userData.value.permission.forEach(permission => {
      console.log(permission);
    });
        userData.value = {
          name: "",
          email: "",
          phone: "",
          permission: []
        };
      } catch (error) {
        console.error("Error adding user:", error);
      }
    };

    return {
      userData,
      userPermissions,
      addUser,selectCategory 
    };
  }
};
</script>
