<template>
    <div v-if="offerData">
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">オファーID:</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    {{offerData.id}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail lb-split">
            <a-col flex="130px">
                <div class="ct-detail-title lb-highlight">Dad情報</div>
            </a-col>
            <a-col flex="auto">
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('user.avatar') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    <img class="ct-offer-detail rounded-img" :src="(offerData.dad && offerData.dad.image_url ? $nuxt.context.env.IMAGE_URL + offerData.dad.image_url : require('assets/images/avatar.png'))" alt="">
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('offer.name') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content" v-if="offerData.dad && offerData.dad.full_name">{{offerData.dad.full_name}}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('user.positions') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content" v-if="offerData.dad && offerData.dad.positions">{{offerData.dad.positions}}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('user.id_metamask') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content" v-if="offerData.dad && offerData.dad.public_address_main">{{offerData.dad.public_address_main}}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail lb-split">
            <a-col flex="130px">
                <div class="ct-detail-title lb-highlight">契約情報</div>
            </a-col>
            <a-col flex="auto">
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('offer.contract term') }}: </div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content" v-if="offerData.date_start && offerData.date_end">{{moment(offerData.date_start).format('YYYY.MM.DD') }} ~ {{moment(offerData.date_end).format('YYYY.MM.DD') }}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('offer.price') }}:</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content flex-item" v-if="offerData.selling_price">
                    <img class="eth-size" src="@/assets/images/eth-icon.svg">
                    <div>
                        <span class="content__detail">{{Number(offerData.selling_price)}}</span>
                    </div>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.rate') }}: </div>
            </a-col>
            <a-col flex="auto">
                <div style="display: block" v-if="offerData.artist_percent != null">
                    <div class="ct-content">Dad: {{100 - offerData.artist_percent}}%</div>
                    <div class="ct-content">Artist: {{offerData.artist_percent}}%</div>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail txt-area" v-if="offerData.responsibility">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('offer.example') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="text-scroll">
                    {{offerData.responsibility}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail txt-area" v-if="offerData.contact_info">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('offer.comment') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="text-scroll">
                    {{offerData.contact_info}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('offer.status') }}: </div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    {{ getOfferStatus(offerData)}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail lb-split">
            <a-col flex="130px">
                <div class="ct-detail-title lb-highlight">メールアドレスへ</div>
            </a-col>
            <a-col flex="auto">
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('user.email') }}:</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content" v-if="offerData.email">{{offerData.email}}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px" class="detail-btn">
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    <a-form-item style="margin-top: 24px">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button
                                size="large"
                                @click="back()"
                                class="btn-action btn-cancel-lg">
                                戻る
                            </a-button>
                        </a-config-provider>
                    </a-form-item>
                </div>
            </a-col>
        </a-row>
    </div>
</template>
<script>
import {mapActions} from "vuex";
import moment from "moment";
import BaseComponent from "~/mixins/BaseComponent";

export default {
    mixins: [BaseComponent],
    components: {
    },
    data() {
        return {
            offerData: {},
            listOrganization: [],
            loading: false,
        }
    },

    computed: {
        moment: () => moment,
    },

    mounted() {
        // get id from uri
        const id = +this.$route.params.id || 0
        // get contract info by id
        if (id) {
            this.loading = true
            this.actionGetOffer({ id }).then(response => {
                this.offerData = response.data
            }).finally(() => {
                this.loading = false
            })
        }
    },

    methods: {
        ...mapActions({
            actionGetOffer: "offer/actionShow",
        }),
        back() {
            this.$router.push('/offer')
        },
        /**
         * submit
         */
        submit() {
        },
    },
}
</script>
<!--<style lang="less" src="assets/admin/custom.less"></style>-->
