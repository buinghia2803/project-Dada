<template>
    <div class="d-container d-wrapper-top">
        <TopHeader />

        <div class="d-container d-box-wrapper-top">
            <Nuxt/>
        </div>

        <TopFooter />
    </div>
</template>

<script>

export default {
    name: 'top',
    components: {
        TopHeader: () => import('~/components/custom/common/Top/Header.vue'),
        TopFooter: () => import('~/components/custom/common/Top/Footer.vue')
    },

    data() {
        return {};
    },

    methods: {}
}
</script>

