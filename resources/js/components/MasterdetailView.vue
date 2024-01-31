<template>
    <DxTabPanel>
        <DxItem title="Representative" template="representativesTab" />
        <template #representativesTab>
            <RepresentativesTab :user-id="companyInfo.user_id" />
        </template>
        <DxItem title="Address" template="addressTab" />
        <template #addressTab>
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
