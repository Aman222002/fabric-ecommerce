<template>
    <div class="container">
        <DxDataGrid :show-borders="true" :data-source="dataSource" :repaint-changes-only="true"
            :column-auto-width="true" :allow-column-resizing="true">
            <DxEditing :allow-updating="true" mode="row" :use-icons="true" />
            <DxSearchPanel :visible="true" />
            <DxColumn data-field="first_line_address" caption="First Line Address" data-type="string" />
            <DxColumn data-field="street" caption="Street" data-type="string">
                <DxRequiredRule />
            </DxColumn>
            <DxColumn data-field="state" caption="State" data-type="string">
                <DxRequiredRule />
            </DxColumn>
            <DxColumn data-field="postal_code" data-type="int">
            </DxColumn>
        </DxDataGrid>
    </div>
</template>
<script>
import dxGridStore from '../composition/dxGridStore';
import { ref } from "vue";
export default {
    name: 'AddressTab',
    props: {
        addressId: {
            type: Number,
            default: 0,
        }
    },
    setup(props) {
        const loadURL = `/admin/company/address/${props.addressId}`;
        const updateURL = `/admin/company/address/update`;
        const { dataSource } = dxGridStore(loadURL, null, updateURL, null);
        return {
            dataSource,
        };
    },
}
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