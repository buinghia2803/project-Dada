<template>
    <a-card class="mb-6 d-card-no-border d-head-title">
        <template slot="title">
            {{ $t('menu.change_password.default') }}
        </template>
        <admin-change-password-form/>
    </a-card>
</template>
<script>


export default {
    components: {
        AdminChangePasswordForm: () => import('~/components/organisms/admin/AdminChangePasswordForm.vue'),
    },
    head() {
        return {
            title: this.$t('module.setting'),
            bodyAttrs: {
                class: 'current-page-change-password'
            }
        }
    },
    methods: {
        /**
         * Go to list
         */
    }
}
</script>
