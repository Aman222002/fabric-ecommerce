<template>
    <DxTabPanel>
       
        <DxItem title="Applicant" template="application" />
        <template #application>
            <ApplicantTab :job-Id="applicationInfo.id" />
        </template>
       
    </DxTabPanel>
   
</template>
<script>


import ApplicantTab from './ApplicantTab.vue';

export default {
    props: {
        applicationInfo: {
            type: Object,
            default: () => ({})
        },
    },
    setup(props) {
        console.log(props.applicationInfo,'here');
      
    },
    components: { ApplicantTab}
}
</script>
<style scoped></style>
