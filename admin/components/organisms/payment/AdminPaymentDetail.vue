<template>
    <div v-if="paymentData">
        <div class="row-detail">
            <div class="ct-detail-title">{{ $t('contract.img_detail') }}：</div>
            <div class="ct-content">
                <div v-if="paymentData.contractNft && paymentData.contractNft.image_url">
                    <img class="ct-img-detail" :src="($nuxt.context.env.IMAGE_URL + paymentData.contractNft.image_url)"
                        alt="">
                </div>
                <div v-else>
                    <img class="ct-img-detail" src="@/assets/images/no-image.png" alt="">
                </div>
            </div>
        </div>
        <div class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.name') }}：</div>
            <div class="ct-content"></div>
            <nuxt-link :to="{ name: 'contract-detail-id', params: { id: paymentData.contract_nft_id } }">
                <span>{{ paymentData.contractNft ? paymentData.contractNft.name : '' }}</span>
            </nuxt-link>
        </div>
        <div v-if="paymentData.contractOffer" class="row-detail">
            <div class="ct-detail-title">Dad: </div>
            <div class="user-inf">
                <div class="ct-content" v-if="paymentData.contractOffer.dad && paymentData.contractOffer.dad.full_name">
                    {{ paymentData.contractOffer.dad.full_name }}</div>
            </div>
        </div>
        <div v-if="paymentData.contractOffer && paymentData.contractOffer.artist" class="row-detail">
            <div class="ct-detail-title">Artist: </div>
            <div class="user-inf">
                <div class="ct-content"
                    v-if="paymentData.contractOffer.artist && paymentData.contractOffer.artist.full_name">
                    {{ paymentData.contractOffer.artist.full_name }}</div>
            </div>
        </div>
        <div v-if="paymentData.contractOffer" class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.contract_offers') }}: </div>
            <div class="ct-content">
                <img class="eth-size" src="@/assets/images/eth-icon.svg" style="margin-bottom: 5px">
                <span v-if="paymentData.contractOffer.selling_price">
                    {{ paymentData.contractOffer.selling_price - 0 }}
                </span>
            </div>
        </div>
        <div v-if="paymentData.contractOffer" class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.opensea') }}: </div>
            <div class="ct-content">
                <img class="eth-size" src="@/assets/images/eth-icon.svg" style="margin-bottom: 5px">
                {{ calculateReceiveAmount(paymentData.contractOffer).toFixed(5) - 0 }}
                {{ $t('contract.receive_amount_explain') }}
            </div>
        </div>
        <div v-if="paymentData.contractOffer" class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.artist_price') }}: </div>
            <div class="ct-content">{{ paymentData.contractOffer ? paymentData.contractOffer.artist_percent : ''
            }}%
                <span class="pd-left">
                    <img class="detail-rate" src="@/assets/images/eth-icon.svg">
                    {{ paymentData.contractOffer ? paymentData.contractOffer.artist_price - 0 : '' }}
                </span>
            </div>
        </div>
        <div v-if="paymentData.contractOffer" class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.dad_price') }}: </div>
            <div class="ct-content">{{ paymentData.contractOffer ? 100 - paymentData.contractOffer.artist_percent :
                    ''
            }}%
                <span class="pd-left">
                    <img class="detail-rate" src="@/assets/images/eth-icon.svg">
                    {{ paymentData.contractOffer ? paymentData.contractOffer.dad_price - 0 : '' }} （ガス代が加算されした）
                </span>
            </div>
        </div>
        <div v-if="paymentData.contractOffer" class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.system_price') }}: </div>
            <div class="ct-content">{{ paymentData.contractOffer ? paymentData.contractOffer.system_percent : ''
            }}%
                <span class="pd-left">
                    <img class="detail-rate" src="@/assets/images/eth-icon.svg">
                    {{ paymentData.contractOffer ? paymentData.contractOffer.system_price - 0 : '' }}
                </span>
            </div>
        </div>
        <div v-if="paymentData.contractNft && paymentData.contractNft.gas_fee" class="row-detail">
            <div class="ct-detail-title">ガス代 : </div>
            <div class="ct-content">
                <span class="content__detail">{{ paymentData.contractNft.gas_fee ? paymentData.contractNft.gas_fee : ''
                }}</span>
            </div>
        </div>
        <div v-if="paymentData.contractOffer && paymentData.contractOffer.artist" class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.public_address_sub') }} : </div>
            <div class="ct-content">
                <span class="content__detail">{{ paymentData.contractOffer.artist ?
                        paymentData.contractOffer.artist.public_address_sub : ''
                }}</span>
            </div>
        </div>
        <div class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.contract_nft_id') }} : </div>
            <div class="ct-content">
                <span class="content__detail">{{ paymentData ? paymentData.contract_nft_id : '' }}</span>
            </div>
        </div>
        <div class="row-detail">
            <div class="ct-detail-title">{{ $t('payment.status') }} : </div>
            <div class="ct-content">
                <a-select ref="select" style="width: 115px" v-model="paymentData.status"
                    :options="STATUS_UPDATE_PAYMENT" />
            </div>
        </div>
        <div class="row-detail">
            <div class="ct-detail-title"></div>
            <div class="ct-content">
                <a-config-provider :autoInsertSpaceInButton="false">
                    <a-button style="width: 120px; height: 30px; font-size: initial;"
                        class="ant-btn ant-btn-primary size-xs" @click="submit">
                        変更
                    </a-button>
                </a-config-provider>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions } from "vuex";
import moment from "moment";
import BaseComponent from "~/mixins/BaseComponent";
import { STATUS_UPDATE_PAYMENT } from '~/utils/constants';

export default {
    props: {
        create: {
            type: Boolean
        }
    },
    mixins: [BaseComponent],
    components: {
    },
    data() {
        return {
            paymentData: {},
            listOrganization: [],
            defaultOption: {
                label: this.$t('common.default_option'),
                value: 0
            },
            loading: false,
            STATUS_UPDATE_PAYMENT,
            listRoles: []
        }
    },

    computed: {
        moment: () => moment,
    },

    mounted() {
        // get id from uri
        const id = +this.$route.params.id || 0
        // get payment info by id
        if (id) {
            this.loading = true
            this.actionGetPayment({ id }).then(response => {
                this.paymentData = response.data
            }).finally(() => {
                this.loading = false
            })
        }
    },

    methods: {
        ...mapActions({
            actionGetPayment: "payments/actionShow",
            actionUpdateStatus: "payments/actionUpdate"
        }),

        /**
         * calculateReceiveAmount
         *
         * @param contractOffer
         * @returns {number}
         */
        calculateReceiveAmount(contractOffer = {}) {
            let sellingPrice = contractOffer.selling_price ? contractOffer.selling_price : 0;
            let openseaPrice = contractOffer.opensea_price ? contractOffer.opensea_price : 0;
            return sellingPrice - openseaPrice;
        },

        /**
         * updateStautsPayment
         */
        submit() {
            this.actionUpdateStatus(this.paymentData)
        }

    }
}
</script>
