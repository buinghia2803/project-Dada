<template>
    <div class="d-container d-wrapper-main" >
        <div class="layout-header">
            <TheHeader/>
        </div>
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
    name: 'login',
    // middleware: 'notAuthenticated',
    components: {
        TheHeader: () => import('~/components/organisms/common/TheHeader.vue'),
        Footer: () => import('~/components/custom/common/Footer.vue')
    },

    data() {
        return {};
    },

    methods: {}
}
</script>

