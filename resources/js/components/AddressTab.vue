<template>
    <div class="container">
        <h3>here</h3>
        {{ value }}
        <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true">
        </DxDataGrid>
    </div>
</template>
<script>
import dxGridStore from '../composition/dxGridStore';
import { ref } from "vue";
export default {
    name: 'CompaniesComponent',
    props: {
        addressId: {
            type: Number,
            default: 0
        }
    },
    setup(props) {
        console.log('here', props.addressId);
        const loadURL = `/admin/company/address/${props.addressId}`;
        const { dataSource } = dxGridStore(loadURL);
        return {
            dataSource,
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
  