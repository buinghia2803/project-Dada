<template>
    <a-card class="col-md-12 d-card-no-border d-head-title">
        <template slot="title">
            <div>
                <nuxt-link :to="{ name: 'offer', params: {} }">
                    <span class="breadcrumb-txt">オファー詳細</span>
                </nuxt-link>
                <span>  ＞  詳細</span>
            </div>
        </template>
        <admin-offer-detail/>
    </a-card>
</template>
<script>


export default {
    components: {
        AdminOfferDetail: () => import('~/components/organisms/offer/AdminOfferDetail.vue')
    },
    head() {
        return {
            title: `${this.$t('menu.offer.default')} | ${this.$t('module.notice')}`,
            bodyAttrs: {
                class: 'current-page-offer-detail'
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
