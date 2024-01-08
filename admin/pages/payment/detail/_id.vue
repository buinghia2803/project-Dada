<template>
    <a-card class="col-md-12 d-card-no-border d-head-title">
        <template slot="title">
            <div>
                <nuxt-link :to="{ name: 'payment', params: {} }">
                    <span class="breadcrumb-txt">支払い管理</span>
                </nuxt-link>
                <span> ＞ 詳細</span>
            </div>
        </template>
        <admin-payment-detail/>
    </a-card>
</template>
<script>


export default {
    name: 'payment-detail-id',
    components: {
        AdminPaymentDetail: () => import('~/components/organisms/payment/AdminPaymentDetail.vue')
    },
    head() {
        return {
            title: `${this.$t('menu.payment.default')} | 詳細`,
            bodyAttrs: {
                class: 'current-page-payment-detail'
            }
        }
    },
    methods: {}
}
</script>
