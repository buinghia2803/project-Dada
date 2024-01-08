<template>
    <a-card class="col-md-12 d-card-no-border d-head-title">
        <template slot="title">
            {{ $t('module.notice') }} > 内容変更
        </template>
        <admin-notice-form/>
    </a-card>
</template>
<script>


export default {
    components: {
        AdminNoticeForm: () => import('~/components/organisms/notice/AdminNoticeForm.vue')
    },
    head() {
        return {
            title: `${this.$t('menu.notice.default')} | 内容変更`,
            bodyAttrs: {
                class: 'current-page-notice-detail'
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
