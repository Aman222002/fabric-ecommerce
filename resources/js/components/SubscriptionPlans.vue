<template>
    <v-container>
        <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true"
            :column-auto-width="true" :allow-column-resizing="true">
            <DxEditing :allow-updating='true' />
            <DxColumn data-field='name'>
                <DxPatternRule :pattern="namePattern" message="Name Should be more than 3 character or less than 10" />
            </DxColumn>
            <DxColumn data-field='duration' :allowEditing="false"></DxColumn>
            <DxColumn data-field='price' :allowEditing="false"></DxColumn>
            <DxColumn data-field='Posts_Allowed' data-type='integer' :allowEditing="false"></DxColumn>
        </DxDataGrid>
    </v-container>
</template>
<script>
import { DxColumn, DxEditing } from 'devextreme-vue/data-grid';
import dxGridStore from '../composition/dxGridStore';
import { ref } from "vue";
export default {
    name: 'SubscriptionPlans',
    setup() {
        const namePattern = ref("^[0-9]{9,13}$");
        const loadURL = `/admin/get/plans`;
        const updateURL = `/admin/update/plans`;
        const { dataSource } = dxGridStore(loadURL, null, updateURL);
        return {
            dataSource, namePattern,
        };
    },
    components: { DxColumn, DxEditing }
}
</script>