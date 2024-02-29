
<template>
  <p style="text-align: center; font-size: 20px; margin-top: 20px;">My Jobs</p>


  <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true">
    <DxEditing :allow-updating="true" :allow-deleting="true" mode="row" :use-icons="true">

    </DxEditing>
    <DxSearchPanel :visible="true" />
    <DxScrolling mode="virtual" row-rendering-mode="virtual" />
    <DxColumn data-field="title" data-type="string"> </DxColumn>
    <DxColumn data-field="location" data-type="string"></DxColumn>
    <DxColumn data-field="vacancy" data-type="string">
    </DxColumn>
    <DxColumn data-field="salary" data-type="string">
    </DxColumn>
    <DxColumn data-field="description" data-type="string">
    </DxColumn>

    <DxColumn caption="Duplicate" cell-template="customButtonTemplate">
    </DxColumn>
    <template #customButtonTemplate="{ data }">
      <DxButton @click="checkItem(data.row.data.id)" text="Duplicate"></DxButton>
    </template>
    <DxMasterDetail :enabled="true" template="masterTemplate" />
    <template #masterTemplate="{ data: cellInfo }">
      <masterTemplate :application-info="cellInfo.data" />
    </template>

  </DxDataGrid>
</template>
<script >

import axios from "axios";
import DxButton from "devextreme-vue/button";
import dxGridStore from "../composition/dxGridStore";
import masterTemplate from './MasterdetailApplicant.vue'
export default {
  name: "JobCrud",
  components: {
    DxButton,
    masterTemplate
  },
  setup() {


    const loadUrl = `/post/jobs`;
    const deleteUrl = `/post/delete`;
    const updateURL = `/post/jobs`;
    const { dataSource } = dxGridStore(loadUrl, null, null, updateURL, deleteUrl);

    const checkItem = async (id) => {
      try {
        const response = await axios.post(`/jobs/application/${id}`);
        console.log(response.data);
        // window.location.reload();
      } catch (error) {
        console.error('Error duplicating item:', error);
      }
    };

    return {
      dataSource,
      checkItem,

    };
  },
};
</script>