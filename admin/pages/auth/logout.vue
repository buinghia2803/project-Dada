<template>
    <a-spin size="large"></a-spin>
</template>

<script>
// import { auth } from '~/api/admin'

export default {
    layout: 'blank',
    async mounted() {
        this.$store.commit('logout')
            await this.$auth.logout();
            await localStorage.clear();
            await this.$forceUpdate()
            this.$router.push('/login')
    },
}
</script>

<style lang="less" scoped>
.ant-spin {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
