<template>
    <DxTabPanel>
        <DxItem title="Orders" template="representatives-tab" />
        <template #representatives-tab>
            <RepresentativesTab />
        </template>
        <DxItem title="Address" template="address-tab" />
        <template #address-tab>
            <AddressTab :address-id="companyInfo.id" />
        </template>
    </DxTabPanel>
</template>
<script>

import RepresentativesTab from './RepresentativeTab.vue';
import AddressTab from './AddressTab.vue';
export default {
    props: {
        companyInfo: {
            type: Object,
            default: () => ({})
        },
    },
    setup(props) {
        console.log("here I am", props.companyInfo);
        // const masterDetailData = ref({
        //     key: 0,
        // });
        // // Access the props directly
        // const { masterDetailData: propsMasterDetailData } = this;
        // // Update the masterDetailData ref when props change
        // if (propsMasterDetailData) {
        //     masterDetailData.value = propsMasterDetailData;
        // }
        // return {
        //     masterDetailData,
        // }
    },
    components: { RepresentativesTab, AddressTab }
}
</script>
<style scoped></style>
