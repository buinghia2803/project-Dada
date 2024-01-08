<template>
    <a-spin :spinning="loading" class="d-content">
        <template>
            <InfoBlock1/>
            <InfoBlock2/>
            <InfoBlock3/>
            <InfoBlock4/>
            <InfoBlock5/>
        </template>
    </a-spin>
</template>

<script>

export default {
    name: 'index',
    components: {
        InfoBlock1: () => import('~/components/custom/Top/InfoBlock1.vue'),
        InfoBlock2: () => import('~/components/custom/Top/InfoBlock2.vue'),
        InfoBlock3: () => import('~/components/custom/Top/InfoBlock3.vue'),
        InfoBlock4: () => import('~/components/custom/Top/InfoBlock4.vue'),
        InfoBlock5: () => import('~/components/custom/Top/InfoBlock5.vue')
    },
    layout: "top",
    data() {
        return {
            admin: false,
            loading: true,
        }
    },
    mounted() {
        this.$nextTick(() => this.loading = false)
    },
    methods: {},
}
</script>

<style lang="sass" scoped>
</style>
