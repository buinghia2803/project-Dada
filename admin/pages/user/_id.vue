<template>
    <a-card class="mb-4 d-card-no-border d-head-title">
        <template slot="title">
            {{ $t('menu.user.default') }} > {{ $t('user.update_user') }}
        </template>

        <user-admin-form
            @save="goBack"
            @cancel="goBack"
        />
    </a-card>
</template>
<script>


export default {
    components: {
        UserAdminForm: () => import('~/components/organisms/user/UserAdminForm.vue')
    },
    head() {
        return {
            title: `${this.$t('menu.user.default')} | ${this.$t('user.update_user')}`,
            bodyAttrs: {
                class: 'current-page-user-detail'
            }
        }
    },
    methods: {
        /**
         * Go to list
         */
        goBack() {
            this.$router.push({
                path: '../',
                append: true
            })
        }
    }
}
</script>
