
   <template>
  <p style="text-align: center; font-size: 20px; margin-top: 20px;">My Jobs</p>
 
  <DxDataGrid
    id="grid"
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
  >
    <DxEditing :allow-updating="true" :allow-deleting="true" mode="row">
      
      </DxEditing>
    <DxSearchPanel :visible="true" />
    <DxScrolling mode="virtual" row-rendering-mode="virtual" />
    <DxColumn data-field="title" data-type="string"> </DxColumn>
    <DxColumn data-field="location" data-type="string"></DxColumn>
      <DxColumn data-field="vacancy" data-type="string">
       </DxColumn>
     <!-- <DxColumn caption="Applicants" cell-template="customButtonTemplate">
    </DxColumn>
     <template #customButtonTemplate="{data}">
      <DxButton @click="checkItem(data.row.data.id)" text=" Applicants"></DxButton>
      </template> -->
      <DxMasterDetail :enabled="true" template="masterTemplate" />
      <template #masterTemplate="{ data: cellInfo }">
                <masterTemplate :application-info="cellInfo.data" />
            </template>
           
  </DxDataGrid>
</template>
    <script >
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
    const { dataSource } = dxGridStore(loadUrl, null, updateURL, deleteUrl);
    // const checkItem = (id) => {
    //   window.location.href = `/jobs/application/${id}`;
    // };
    return {
      dataSource,   
    };
  },
};
</script>