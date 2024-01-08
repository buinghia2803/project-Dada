<template>
    <div v-if="contractData">
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.offer_id') }}:</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    <nuxt-link :to="{ name: 'offer-detail-id', params: { id: contractData.contract_offer_id } }">
                        <span style="text-decoration: underline">{{contractData.contract_offer_id}}</span>
                    </nuxt-link>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.img_detail') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    <img
                        class="ct-img-detail"
                        :src="(contractData.image_url ? $nuxt.context.env.IMAGE_URL + contractData.image_url : require('assets/images/no-image.png'))"
                        alt="">
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.name') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">{{contractData.name}}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail txt-area" v-if="contractData.description">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.description') }}：</div>
            </a-col>
            <a-col flex="auto">
                <div class="text-scroll">
                    {{contractData.description}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">Dad:</div>
            </a-col>
            <a-col flex="auto">
                <div class="user-inf">
                    <div class="ct-content" v-if="contractData.contractOffer.dad && contractData.contractOffer.dad.full_name">{{contractData.contractOffer.dad.full_name}}</div>
                    <div class="ct-content" v-if="contractData.contractOffer.dad && contractData.contractOffer.dad.full_name">メタマスクID:
                        <span class="addr-font">{{contractData.contractOffer.dad.public_address_main}}</span>
                    </div>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">Artist:</div>
            </a-col>
            <a-col flex="auto">
                <div class="user-inf">
                    <div class="ct-content" v-if="contractData.contractOffer.artist && contractData.contractOffer.artist.full_name">{{contractData.contractOffer.artist.full_name}}</div>
                    <div class="ct-content" v-if="contractData.contractOffer.artist && contractData.contractOffer.artist.full_name">メタマスクID:
                        <span class="addr-font">{{contractData.contractOffer.artist.public_address_main}}</span>
                    </div>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.duration') }}: </div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">{{moment(contractData.contractOffer.date_start).format('YYYY.MM.DD') }} ~ {{moment(contractData.contractOffer.date_end).format('YYYY.MM.DD') }}</div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.price') }}:</div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content flex-item">
                    <img class="eth-size" src="@/assets/images/eth-icon.svg">
                    <div v-if="contractData.contractOffer.selling_price">
                        <span class="content__detail">{{+contractData.contractOffer.selling_price}}</span>
                    </div>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.receive_amount') }}: </div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    <img class="eth-size" src="@/assets/images/eth-icon.svg" style="margin-bottom: 5px">
                    {{ calculateReceiveAmount(contractData.contractOffer) }}  {{$t('contract.receive_amount_explain')}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.rate') }}: </div>
            </a-col>
            <a-col flex="auto">
                <div style="display: block">
                    <div class="ct-content">Dad: {{100 -contractData.contractOffer.artist_percent}}%
                        <span class="pd-left">
                        <img class="detail-rate" src="@/assets/images/eth-icon.svg">
                        {{+contractData.contractOffer.dad_price}}
                    </span>
                    </div>
                    <div class="ct-content">Artist: {{contractData.contractOffer.artist_percent}}%
                        <span class="pd-left">
                        <img class="detail-rate" src="@/assets/images/eth-icon.svg">
                        {{+contractData.contractOffer.artist_price}}
                    </span>
                    </div>
                    <div class="ct-content">システム : {{contractData.contractOffer.system_percent}}%
                        <span class="pd-left">
                        <img class="detail-rate" src="@/assets/images/eth-icon.svg">
                        {{+contractData.contractOffer.system_price}}
                    </span>
                    </div>
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px">
                <div class="ct-detail-title">{{ $t('contract.status') }} : </div>
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    {{ getContractStatus(contractData)}}
                </div>
            </a-col>
        </a-row>
        <a-row type="flex" class="marg-detail" v-if="contractData.contractOffer">
            <a-col flex="130px" class="detail-btn">
            </a-col>
            <a-col flex="auto">
                <div class="ct-content">
                    <a-form-item style="margin-top: 24px">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button
                                :autoInsertSpaceInButton="false"
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
            contractData: {},
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
            this.actionGetContract({ id }).then(response => {
                this.contractData = response.data
            }).finally(() => {
                this.loading = false
            })
        }
    },

    methods: {
        ...mapActions({
            actionGetContract: "contracts/actionShow",
        }),
        back() {
            this.$router.push('/contract')
        },

        /**
         * calculateReceiveAmount
         *
         * @param contractOffer
         * @returns {number}
         */
        calculateReceiveAmount (contractOffer = {}) {
            let sellingPrice = contractOffer.selling_price ? contractOffer.selling_price : 0;
            let openseaPrice = contractOffer.opensea_price ? contractOffer.opensea_price : 0;
            return +(sellingPrice - openseaPrice);
        },

        calculatePriceByRate (contractOffer = {}, rate) {
            return +(contractOffer.selling_price*(rate/100));
        }
    }
}
</script>
<!--<style lang="less" src="../../../assets/admin/custom.less"></style>-->
