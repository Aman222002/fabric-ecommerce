<template>
  <p style="text-align: center; font-size: 20px; margin-top: 20px"> Users</p>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
    :remote-operations="true"
    ref="dataGridRef"
  >
  <DxToolbar>
      <DxGridItem template="dropDown2" :location="'before'" />
      <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
    </DxToolbar>
    <DxEditing
      mode="row"
     
      :use-icons="true"
    >
    </DxEditing>
    <DxSearchPanel :visible="true" />
    <DxScrolling mode="virtual" row-rendering-mode="virtual" />
    <DxColumn v-if="selectedStatus === 'All'" data-field="name" data-type="string"></DxColumn>
    <DxColumn v-if="selectedStatus === 'All'" data-field="email" data-type="string"></DxColumn>
    <DxColumn v-if="selectedStatus !== 'All'" data-field="user_email" data-type="string"></DxColumn>
    <DxColumn v-if="selectedStatus === 'All'" data-field="phone" data-type="string"></DxColumn>
    <DxColumn v-if="selectedStatus !== 'All'" data-field="status" data-type="string"></DxColumn>
    <template #dropDown2>
      <DxDropDownBox :accept-custom-value="true" @value-change="selectStatus" label="Select status" labelMode="floating"
        v-model:value="selectedStatus" v-model:opened="DropDown2">
        <DxList :data-source="items" selection-mode="single" @item-click="selectStatus">
        </DxList>
      </DxDropDownBox>
    </template>
  </DxDataGrid>
</template>

<script>
import axios from "axios";
import dxGridStore from "../composition/dxGridStore";
import { ref, onMounted, computed } from "vue";

export default {
  name: "companyusers",
 
  setup() {
    const dataGridRef = ref(null);
    const DropDown2 = ref(false);
    const params = ref({});
    const selectedStatus = ref("All");
    const selectStatus = (e) => {
      const value = e.itemData.text;
      params.value = { type: value };
      selectedStatus.value = value;
      DropDown2.value = false;
      refreshTable(dataGridRef);
    };
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
    const deleteUrl = `/admin/user/destroy`;
    const { dataSource , refreshTable } = dxGridStore(loadUrl, params, null, null, deleteUrl);
    
    return {
      dataSource, items, selectStatus, selectedStatus,
      DropDown2, dataGridRef, params
    };
  },
};
</script>
