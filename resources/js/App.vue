<template>
    <a-flex gap="middle" vertical>
        <a-flex gap="middle" vertical>
            <a-layout-header class="header-style">Test task</a-layout-header>
        </a-flex>
        <a-flex gap="middle" vertical>
            <router-view />
        </a-flex>
    </a-flex>

</template>
<script>
export default {

    setup() {

    }
}
</script>
<style>
.header-style{
    text-align: center;
    color: #fff;
    height: 64px;
    padding-inline: 50px;
    line-height: 64px;
    background-color: #000;
}
</style>
