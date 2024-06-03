<template>
  <DxTabPanel>
    <DxGridItem title="Representative" template="representativesTab" />
    <template #representativesTab>
      <RepresentativesTab :user-id="companyInfo.user_id" />
    </template>
    <DxGridItem title="Company Address" template="addressTab" />
    <template #addressTab>
      <AddressTab :address-id="companyInfo.id" />
    </template>
    <DxGridItem title="Company Subadmin" template="subadminTab" />
    <template #subadminTab>
      <SubadminTab :subadmin-id="companyInfo.id" />
    </template>
  </DxTabPanel>
</template>
<script>
import RepresentativesTab from "./RepresentativeTab.vue";
import AddressTab from "./AddressTab.vue";
import SubadminTab from "./SubadminTab.vue";
export default {
  props: {
    companyInfo: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    // console.log(props.companyInfo);
  },
  components: { RepresentativesTab, AddressTab, SubadminTab},
};
</script>
<style scoped></style>
