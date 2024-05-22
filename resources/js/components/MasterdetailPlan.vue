<template>

    <DxDataGrid :show-borders="true" :data-source="dataSource" :repaint-changes-only="true">
        <DxColumn data-field="name" data-type="string">
            <DxRequiredRule />
        </DxColumn>
        <DxColumn data-field="email" data-type="string">
            <DxRequiredRule />
            <DxEmailRule message="Email is invalid" />
        </DxColumn>
        <DxColumn data-field="phone" data-type="string">
        </DxColumn>
        <DxColumn
      caption="Action"
      cell-template="ButtonTemplate"
    ></DxColumn>
    <template #ButtonTemplate="{ data }">
        <div>
        <!-- <v-btn   color="primary" @click="approve(data)" :disabled="data.data.subscription_status === 'active'">Approve</v-btn> -->
        <v-btn 
          color="primary" 
          @click="approve(data)" 
          :disabled="data.data.subscription_status === 'active' || isApproved[data.data.id]">
          {{ isApproved[data.data.id] ? 'Approved' : 'Approve' }}
        </v-btn>
        
    </div>
    </template>

    </DxDataGrid>
</template>
<script>
import dxGridStore from '../composition/dxGridStore';
import axios from 'axios';
import { reactive } from 'vue';
export default {
    name: 'RepresentativeTab',
    props: {
        planId: {
            type: Number,
            default: 0,
        },
    },
    setup(props) {
        // console.log(props.planId);
        const loadURL = `/admin/company/plan/${props.planId}`;
        // const updateURL = `/admin/user/update`;
        const isApproved = reactive({});
        const approve = (data) => {
    console.log(data);
    const userId = data.data.id;
    const requestData = {
        id:data.data.id,
        name: data.data.name,
        email: data.data.email,
        phone: data.data.phone
    };
    console.log('Approved:', requestData);
    axios.post(`/subscription-plan/${userId}`, requestData)
        .then(response => {
            console.log('API Response:', response.data);
            isApproved[userId] = false;
            // refreshTable(dataGridRef);
            window.location.reload();
        })
       
        .catch(error => {
            console.error('API Error:', error);
        });
};
const { dataSource,refreshTable } = dxGridStore(loadURL);
        return {
            dataSource,
            approve,
            isApproved,
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