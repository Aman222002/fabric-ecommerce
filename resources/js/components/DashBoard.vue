<template>
    <v-container>
        <DxBox :height="75" direction="row" width="100%">
            <DxItem :ratio="1">
                <template #default>
                    <div class="box-item orange">ratio = 1</div>
                </template>
            </DxItem>
            <DxItem :ratio="1">
                <template #default>
                    <div class="box-item yellow">ratio = 2</div>
                </template>
            </DxItem>
            <DxItem :ratio="1">
                <template #default>
                    <div class="box-item green">ratio = 1</div>
                </template>
            </DxItem>
        </DxBox>
    </v-container>
</template>
<script>

</script>
<style>
.box-item {
    text-align: center;
    padding-top: 34px;
    font-size: 16px;
}

.orange {
    background: #f39e6c
}

.yellow {
    background: #f5e5a6
}

.green {
    background: #94d7c7
}
</style>