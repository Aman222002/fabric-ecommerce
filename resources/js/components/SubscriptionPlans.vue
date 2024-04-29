<template>
  <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true"
    :column-auto-width="true" :allow-column-resizing="true">
    <DxEditing :allow-updating="true" :use-icons="true" />
    <DxColumn data-field="Name">
      <DxPatternRule :pattern="namePattern" message="Name Should be more than 3 character or less than 10" />
    </DxColumn>
    <DxColumn data-field="Duration of Job-Post" :allowEditing="false"></DxColumn>
    <DxColumn data-field="Number of Job-Post" data-type="integer" :allowEditing="false"></DxColumn>
    <DxColumn data-field="Price" :allowEditing="false"></DxColumn>
    <DxColumn type="buttons" caption="Action"></DxColumn>
    <DxMasterDetail :enabled="true" template="masterDetailTemplate" />
    <template #masterDetailTemplate="{ data: cellInfo }">
      <masterDetailTemplate :plan-id="cellInfo.data.id" />
    </template>
  </DxDataGrid>
</template>
<script>
import { DxColumn, DxEditing } from "devextreme-vue/data-grid";
import dxGridStore from "../composition/dxGridStore";
import masterDetailTemplate from "./MasterdetailPlan.vue";
import { ref } from "vue";
export default {
  name: "SubscriptionPlans",
  setup() {
    const namePattern = ref("[a-zA-Z]{3,30}");
    const loadURL = `/get/plans`;
    const updateURL = `/admin/update/plans`;
    const { dataSource } = dxGridStore(loadURL, null, null, updateURL);
    return {
      dataSource,
      namePattern,
    };
  },
  components: { DxColumn, DxEditing, masterDetailTemplate },
};
</script>