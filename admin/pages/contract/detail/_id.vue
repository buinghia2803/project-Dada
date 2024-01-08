<template>
    <a-card class="col-md-12 d-card-no-border d-head-title">
        <template slot="title">
            <div>
                <nuxt-link :to="{ name: 'contract', params: {} }">
                    <span class="breadcrumb-txt">契約管理</span>
                </nuxt-link>
                <span>  ＞  詳細</span>
            </div>
        </template>
        <admin-contract-detail/>
    </a-card>
</template>
<script>


export default {
    components: {
        AdminContractDetail: () => import('~/components/organisms/contract/AdminContractDetail.vue'),
    },
    head() {
        return {
            title: `${this.$t('menu.contract.default')} | 詳細`,
            bodyAttrs: {
                class: 'current-page-contract-detail'
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
