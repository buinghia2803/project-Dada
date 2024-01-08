<template>
    <div class="d-container d-wrapper-main" >
        <TopHeader />

        <div class="d-container d-box-wrapper-main">
            <Nuxt/>
        </div>
        <div class="layout-footer">
            <Footer/>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        TopHeader: () => import('~/components/custom/common/Top/Header.vue'),
        Footer: () => import('~/components/custom/common/Footer.vue')
    },
    data() {
        return {
            locale: null,
        };
    },
    methods: {}
}
</script>

