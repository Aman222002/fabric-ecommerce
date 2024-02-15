<template>
      
    <DxTabPanel>
        <DxItem title="Education" template="qualification" />
        <template #qualification>
            <QualificationTab :user-Id="qualificationInfo.id" />
        </template>
        <DxItem title="Experience" template="experience" />
        <template #experience>
            <ExperienceTab :user-Id="qualificationInfo.id" />
        </template>
    </DxTabPanel>
</template>
<script>
import QualificationTab from './QualificationTab.vue'
import ExperienceTab from './ExperienceTab.vue';
export default {
    props: {
        qualificationInfo: {
            type: Object,
            default: () => ({})
        },
    },
    setup(props) {
        console.log(props.qualificationInfo,'here');
      
    },
    components: {QualificationTab,ExperienceTab}
}
</script>
<style scoped></style>
