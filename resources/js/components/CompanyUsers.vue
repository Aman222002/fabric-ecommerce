
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
      
      :allow-deleting="true"
   
      :use-icons="true"
    >
    </DxEditing>
    <DxSearchPanel :visible="true" />

    <DxScrolling mode="virtual" row-rendering-mode="virtual" />

    <DxColumn data-field="name" data-type="string"> </DxColumn>
    <DxColumn data-field="email" data-type="string"></DxColumn>
    
    <DxColumn data-field="phone" data-type="string"> </DxColumn>
    <!-- <DxColumn
      data-field="permission"
      data-type="string"
      cell-template="demodropdown"
      edit-cell-template="demodropdown"
    >
    </DxColumn> -->
    <!-- <template #demodropdown>
     
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
    </template> -->
   
     
  </DxDataGrid>
</template>
      <script >
import axios from "axios";

import dxGridStore from "../composition/dxGridStore";

import { ref, onMounted } from "vue";

export default {
  name: "companyusers",
 
  setup() {
   
    const loadUrl = `/fetch-user`;
    const { dataSource } = dxGridStore(loadUrl, null, null, null, null);
    
 
    
    return {
      dataSource,
     
 
  
     
     
    };
  },
};
</script> 