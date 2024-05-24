<template>
  <div class="container">
    <DxDataGrid
      :show-borders="true"
      :data-source="dataSource"
      :repaint-changes-only="true"
      :column-auto-width="true"
      :allow-column-resizing="true"
    >
      <DxSearchPanel :visible="true" />
      <DxColumn
        data-field="company_name"
        caption="Company Name"
        data-type="string"
      />
      <DxColumn data-field="start_date" caption="Starting Year" data-type="int">
      </DxColumn>
      <DxColumn data-field="end_date" caption="Passing Year" :calculate-cell-value="calculateEndDate">
      </DxColumn>
    </DxDataGrid>
  </div>
</template>
<script>
import dxGridStore from "../composition/dxGridStore";
import { ref } from "vue";
export default {
  name: "ExperienceTab",
  props: {
    userId: {
      type: Number,
      default: 0,
    },
  },
  setup(props) {
    console.log(props.userId);
    const loadURL = `/jobs/experience/${props.userId}`;
    const { dataSource } = dxGridStore(loadURL, null, null, null);
    const calculateEndDate = (rowData) => {
      return rowData.end_date ? rowData.end_date : "Currently Working";
    };
    return {
      dataSource,
      calculateEndDate
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
