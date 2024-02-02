<template>
    <div class="container">
        <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true"
            :column-auto-width="true" :allow-column-resizing="true" @init-new-row="initNewRow" @row-inserted="rowInserted">
            <DxEditing :allow-adding="true" :allow-updating="true" :allow-deleting="true" mode="row" />
            <DxSearchPanel :visible="true" />
            <DxColumn data-field="name" data-type="string">
                <DxRequiredRule />
            </DxColumn>
            <DxColumn data-field="email" data-type="string">
                <DxRequiredRule />
                <DxEmailRule message="Email is invalid" />
            </DxColumn>
            <DxColumn data-field="phone" data-type="string">
                <DxPatternRule :pattern="phonePattern" message="Should be numeric value only" />
            </DxColumn>
            <DxColumn data-field="password" data-type="password" :visible="showColumn">
                <DxPatternRule :pattern="passwordPattern"
                    message="Should be of min. seven charcter and must contains a special character only" />
            </DxColumn>
            <DxScrolling mode="virtual" />
            <DxSummary>
                <DxTotalItem column="id" summary-type="count" />
            </DxSummary>
        </DxDataGrid>
    </div>
</template>
<script>
import dxGridStore from '../composition/dxGridStore';
import { ref } from "vue";
export default {
    name: 'CompaniesComponent',
    setup() {
        const phonePattern = ref("^[0-9]{9,13}$");
        const passwordPattern = ref(/^.{7,}$/);
        const showColumn = ref(false);
        const loadURL = `/admin/user/index`;
        const insertURL = `/admin/user/store`;
        const updateURL = `/admin/user/update`;
        const deleteUrl = `/admin/user/destroy`;
        const { dataSource } = dxGridStore(loadURL, insertURL, updateURL, deleteUrl);
        const initNewRow = (e) => {
            e.data.status = '1';
            showColumn.value = true;
        };
        const rowInserted = (e) => {
            showColumn.value = false;
        };
        return {
            dataSource, showColumn, phonePattern, passwordPattern, initNewRow, rowInserted
        };
    },
}
</script>
<style scoped>
#grid {
    height: 400px;
}

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
  