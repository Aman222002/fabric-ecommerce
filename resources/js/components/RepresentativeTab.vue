<template>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    :repaint-changes-only="true"
    :remote-operations="true"
  >
    <DxEditing :allow-updating="true" mode="popup" :use-icons="true" >
      <DxPopup
          :show-title="true"
          :width="600"
          :height="300"
          title="Representative Info"
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
    </DxFormItem>
        </DxForm>
      </DxEditing>
    <DxSearchPanel :visible="true" />
    <DxColumn data-field="name" data-type="string">
      <DxRequiredRule />
    </DxColumn>
    <DxColumn data-field="email" data-type="string">
      <DxRequiredRule />
      <DxEmailRule message="Email is invalid" />
    </DxColumn>
    <DxColumn data-field="phone" data-type="string"> </DxColumn>
    <DxColumn type="buttons" caption="Action"></DxColumn>
  </DxDataGrid>
</template>
<script>
import dxGridStore from "../composition/dxGridStore";
import axios from "axios";
export default {
  name: "RepresentativeTab",
  props: {
    userId: {
      type: Number,
      default: 0,
    },
  },
  setup(props) {
     console.log(props.userId);
    const loadURL = `/admin/company/representative/${props.userId}`;
    const updateURL = `/admin/user/update`;
    console.log(updateURL);
    const { dataSource } = dxGridStore(loadURL,null,null,updateURL,null);
    return {
      dataSource,
      updateURL
    };
  },
};
</script>
<style scoped>
#grid {
  max-height: 200px;
}

.container {
  margin-top: 15px;
  margin-left: 15px;
  margin-bottom: 15px;
  width: 95%;
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
  display: table;
  clear: both;
}

#requests #clear {
  float: right;
}

#requests ul {
  list-style: none;
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
</style>