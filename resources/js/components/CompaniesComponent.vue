<template>
    <div class="container">
        <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true">
            <DxEditing :allow-adding="true" :allow-updating="true" :allow-deleting="true" mode="popup" />
            <DxColumn data-field="id" caption="UserID">
                <DxLookup :data-source="dataSource" value-expr="Value" display-expr="Text" />
            </DxColumn>
            <DxColumn data-field="name" data-type="string" />
            <DxPatternRule :pattern="namePattern" message="Should be numeric value only" />
            <DxColumn data-field="email" data-type="string" />
            <DxPatternRule :pattern="emailPattern" message="Should be numeric value only" />
            <DxColumn data-field="phone" data-type="string" />
            <DxPatternRule :pattern="phonePattern" message="Should be numeric value only" />
            <DxColumn :visible="showPasswordColumn" data-field="password" data-type="password" />
            <DxScrolling mode="virtual" />
            <DxSummary>
                <DxTotalItem column="id" summary-type="count" />
            </DxSummary>
        </DxDataGrid>
    </div>
</template>
<script>
import {
    DxDataGrid,
    DxColumn,
    DxEditing,
    DxScrolling,
    DxSummary,
    DxLookup,
    DxTotalItem,
} from 'devextreme-vue/data-grid';
import dxGridStore from '../composition/dxGridStore';
import { ref } from "vue";
export default {
    name: 'CompaniesComponent',
    setup() {
        const showPasswordColumn = ref(false);
        const loadURL = `/admin/user/index`;
        const insertURL = `/admin/user/store`;
        const updateURL = `/admin/user/update`;
        const deleteUrl = `/admin/user/destroy`;
        const { dataSource } = dxGridStore(loadURL, insertURL, updateURL, deleteUrl);
        return {
            dataSource, showPasswordColumn
        };
    },
    watch: {
        'DxEditing.allowAdding': function () {
            showPasswordColumn.value = true;
        },
    }
}
</script>
<style scoped>
#grid {
    height: 400px;
}

.container {
    margin-top: 5px;
    margin-left: 90px;
    width: fit-content;
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

.option>span {
    position: relative;
    top: 2px;
    margin-right: 10px;
}

.option>.dx-widget {
    display: inline-block;
    vertical-align: middle;
}

#requests .caption {
    float: left;
    padding-top: 7px;
}

#requests>div {
    padding-bottom: 5px;
}

#requests>div::after {
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
</style>
  