<template>
    <div class="container">
        <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true"
            :onEditingStart="EditStart" @init-new-row="initNewRow" @row-inserted="rowInserted">
            <DxEditing :allow-adding="true" :allow-updating="true" :allow-deleting="true" mode="row" />
            <DxSearchPanel :visible="true" />
            <DxColumn data-field="company_name" data-type="string">
                <DxRequiredRule />
            </DxColumn>
            <DxColumn data-field="company_email" data-type="string">
                <DxRequiredRule />
            </DxColumn>
            <DxColumn data-field="description" data-type="string" />
            <DxColumn data-field="phone_number" data-type="string" />
            <DxColumn data-field="name" data-type="string" caption="User Name" :visible="showColumn">
                <DxPatternRule :pattern="namePattern" message="Name should of min 3 and max 10 word" />
            </DxColumn>
            <DxColumn data-field="email" data-type="string" caption="User Email" :visible="showColumn">
                <DxPatternRule :pattern="emailPattern" message="Email should be in email format" />
            </DxColumn>
            <DxColumn data-field="password" data-type="string" caption="User Password" :visible="showColumn">
                <DxPatternRule :pattern="paswordPattern"
                    message="Pasword should be of min. 8 words and contain one uppercase and one lowercase alphabet with a specila character" />
            </DxColumn>
            <DxColumn data-field="phone" data-type="string" caption="User Phone" :visible="showColumn">
                <DxPatternRule :pattern="phonePattern" message="Phone number should be in proper format" />
            </DxColumn>
            <DxMasterDetail :enabled="true" template="masterDetailTemplate" />
            <template #masterDetailTemplate="{ data: representative }">
                <DetailTemplate :template-data="representative" />
            </template>
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
    DxMasterDetail,
    DxSearchPanel,
    DxTotalItem,
    DxRequiredRule,
} from 'devextreme-vue/data-grid';
import dxGridStore from '../composition/dxGridStore';
import { ref } from "vue";
export default {
    name: 'CompaniesComponent',
    setup() {
        const showColumn = ref(false);
        const namePattern = ref(/^[a-zA-Z][a-zA-Z0-9_]{2,9}$/);
        const emailPattern = ref(/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/);
        const phonePattern = ref("^[0-9]{9,13}$");
        const paswordPattern = ref(/^.{8,}$/);
        const loadURL = `/admin/company/getCompanies`;
        const insertURL = `/admin/company/store`;
        const updateURL = `/admin/company/update`;
        const deleteUrl = `/admin/company/destroy`;
        const { dataSource } = dxGridStore(loadURL, insertURL, updateURL, deleteUrl);
        const initNewRow = (e) => {
            console.log(showColumn.value);
            e.data.status = '1';
            showColumn.value = true;
        };
        const EditStart = (e) => {
            showColumn.value = false;
            console.log('started Editting', e.data);
        };
        const rowInserted = (e) => {
            showColumn.value = false;
        };
        return {
            dataSource, showColumn, EditStart, initNewRow, rowInserted, namePattern, emailPattern, phonePattern, paswordPattern,
        };
    },

    components: { DxRequiredRule, }
}
</script>
<style scoped>
#grid {
    height: 400px;
}

.container {
    margin-top: 15px;
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
  