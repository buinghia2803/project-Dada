<template>
    <a-spin :spinning="statusOffer === 'CONTRACT_OFFER_INIT'"
            :class="[
                'd-content-offer',
                 {'d-content-offer-handler': statusOffer === 'CONTRACT_OFFER_HANDLER'},
                 {'d-content-offer-loading': statusOffer === 'CONTRACT_OFFER_INIT'}
            ]">
        <div class="main-contract-offer" v-if="statusOffer === 'CONTRACT_OFFER'">
            <div class="show-more-offer mt-4 role-btn" @click="showMore = !showMore">
                <span class="fw-bold mr-2">DadAとは？</span>
                <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"
                     v-if="showMore">
                    <path fill="black"
                          d="M5.00019 2.21856L1.70019 5.51856L0.757524 4.57589L5.00019 0.333222L9.24286 4.57589L8.30019 5.51855L5.00019 2.21856Z"/>
                </svg>
                <svg v-else width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="black"
                          d="M4.99981 3.78145L8.29981 0.481445L9.24248 1.42411L4.99981 5.66678L0.757141 1.42411L1.69981 0.481445L4.99981 3.78145Z"/>
                </svg>
            </div>

            <div class="more-detail mt-2 mb-4" v-if="showMore">
                <p class="m-0">
                    アーティスト保護を目的とした、「デジタルアートディーラー（美術商）」というアクターを追加することのできるサービス。デジタルアートをNFT化し、ブロックチェーン上に刻み込む際に作品別に売上げの配当を、初期に設定したもので自動分配されるようにできるスマートコントラクトシステム。</p>
            </div>

            <div class="warp-contract">
                <div class="box-avatar">
                    <div class="icon-change d-flex icon-change-svg-default">
                        <svg class="default" v-if="1" width="35" height="35" viewBox="0 0 35 35" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.78673 27.3076H28.6681C29.0901 27.3076 29.4778 27.0737 29.6743 26.7009C29.8687 26.327 29.841 25.8752 29.6017 25.5291L24.8742 18.6868C24.4427 18.063 23.7271 17.6945 22.9666 17.7094C22.2061 17.7244 21.5033 18.1175 21.0952 18.7594L19.7473 20.8774L15.9992 15.4525C15.5677 14.8255 14.851 14.4592 14.0905 14.473C13.33 14.4869 12.6272 14.8811 12.2192 15.523L5.8297 25.5654C5.60754 25.9147 5.59256 26.3569 5.7934 26.719C5.99206 27.0822 6.37234 27.3076 6.78673 27.3076Z"
                                fill="white"/>
                            <path
                                d="M22.0572 15.3066C23.6765 15.3066 24.9913 13.9928 24.9913 12.3725C24.9913 10.7532 23.6765 9.43945 22.0572 9.43945C20.4368 9.43945 19.123 10.7533 19.123 12.3725C19.123 13.9929 20.4368 15.3066 22.0572 15.3066Z"
                                fill="white"/>
                            <path
                                d="M0 1.34766V33.6539H35V31.9235V1.34766H0ZM31.5393 30.1932H3.46069V4.80835H31.5393V30.1932Z"
                                fill="white"/>
                        </svg>
                        <template v-else>
                            <img class="image-avatar" src="~/assets/images/logo.png" alt="logo">
                        </template>
                    </div>
                </div>

                <div class="info-author mt-2">
                    <div class="title-sub">契約実績：5</div>
                    <div class="title fw-bold">
                        {{
                            contractInfo && contractInfo.dad && contractInfo.dad.full_name ? contractInfo.dad.full_name : ''
                        }}名
                    </div>
                </div>

                <div class="info-bio mt-1 mb-1">
                    <p class="m-0">
                        {{
                            contractInfo && contractInfo.dad && contractInfo.dad.positions ? contractInfo.dad.positions : ''
                        }}
                    </p>
                    <p class="decoration-under wallet-color">
                        {{
                            contractInfo && contractInfo.dad && contractInfo.dad.public_address_main ? contractInfo.dad.public_address_main : ''
                        }}
                    </p>
<!--                    <p class="m-0 bio">-->
<!--                        {{ contractInfo && contractInfo.dad && contractInfo.dad.description ? contractInfo.dad.description : ''}}-->
<!--                    </p>-->
                    <div class="m-0 bio" v-html="contactInfoDescription"></div>
                </div>

                <h2 class="title fw-bold">契約依頼内容</h2>

                <div class="wrap-items">
                    <div class="item">
                        <p class="label-cs m-0">契約期間</p>
                        <p class="value-cs m-0">
                            <span>{{ dateStartConvert }}</span>
                            <span class="div-date">~</span>
                            <span>{{ dateEndConvert }}</span>
                        </p>
                    </div>
                    <div class="item">
                        <p class="label-cs m-0">販売価格ご提案</p>
                        <p class="value-cs m-0 d-flex">
                            <img src="~/assets/images/c-eth.svg" alt="eth">
                            <span class="pl-1">{{ contractInfo.selling_price }}</span>
                        </p>
                    </div>
                    <div class="item">
                        <p class="label-cs m-0">販売配当率</p>
                        <div class="value-cs d-flex">
                            <div class="art">Artist <span class="ml-1">{{ contractInfo.artist_percent }}%</span></div>
                            <div class="dad ml-7">Dad <span class="ml-1">{{ contractInfo.dad_percent }}%</span></div>
                        </div>
                    </div>
                    <div class="item" v-if="responsibility.length">
                        <p class="label-cs m-0">参考例</p>
                        <p class="value-cs m-0">
                            {{ responsibility }}
                        </p>
                    </div>
                    <div class="item" v-if="contactInfo.label">
                        <p class="label-cs m-0">コメント</p>
                        <p class="value-cs m-0">
                            {{ contactInfo }}
                        </p>
                    </div>
                </div>
                <ValidationObserver ref="observer">
                    <a-form
                        class="d-form-art-offer"
                        id="formCreateContract"
                        ref="formState"
                        :label-col="{ md: 4 }"
                        slot-scope="{ handleSubmit }"
                        @submit.prevent="handleSubmit(clickOffer)"
                    >
                        <h3 class="title-policy-1 fw-bold">プライバシーポリシー</h3>
                        <div class="warp-policy-1">
                            <div class="item-policy" v-for="n of 5" :key="n">
                                <p class="label-policy m-0">プライバシー</p>
                                <p class="value-policy m-0">
                                    プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。
                                </p>
                            </div>
                        </div>
                        <ValidationProvider name="policy1" rules="required">
                            <a-form-item slot-scope="{ errors }"
                                         :validateStatus="errors[0] ? 'error' : 'success'"
                            >
                                <div class="agree-policy">
                                    <a-checkbox-group v-model="policy1">
                                        <a-checkbox value="1">
                                            プライバシーポリシーに同意します
                                        </a-checkbox>
                                    </a-checkbox-group>
                                </div>
                            </a-form-item>
                        </ValidationProvider>

                        <h3 class="title-policy-2 fw-bold">利用規約</h3>
                        <div class="warp-policy-2">
                            <div class="item-policy" v-for="n of 5" :key="n">
                                <p class="label-policy m-0">利用規約</p>
                                <p class="value-policy m-0">
                                    利用規約が入ります。利用規約が入ります。利用規約が入ります。利用規約が入ります。利用規約が入ります。利用規約が入ります。
                                </p>
                            </div>
                        </div>
                        <ValidationProvider name="policy2" rules="required">
                            <a-form-item slot-scope="{ errors }"
                                         :validateStatus="errors[0] ? 'error' : 'success'"
                            >
                                <div class="agree-policy">
                                    <a-checkbox-group v-model="policy2">
                                        <a-checkbox value="1">
                                            利用規約に同意します
                                        </a-checkbox>
                                    </a-checkbox-group>
                                </div>
                            </a-form-item>
                        </ValidationProvider>
                        <div class="btn-action-offer">
                            <a-config-provider :autoInsertSpaceInButton="false">
                                <a-button html-type="submit" class="bg-green-txt-white">
                                    確認する
                                </a-button>
                            </a-config-provider>
                        </div>
                    </a-form>
                </ValidationObserver>
            </div>
        </div>

        <ContractFinish v-if="statusOffer === 'CONTRACT_OFFER_HANDLER'" :type="typeOffer"/>
    </a-spin>
</template>

<script>
import {mapActions} from "vuex";
import offerUser from "@/mixins/offerUser";
import role from "@/mixins/role";
import {TYPE_ARTIST_ROLE} from "@/utils/constants";

export default {
    layout: "mainNo",
    components: {
        ContractFinish: () => import('~/components/custom/contract/finish.vue'),
    },
    validate({params}) {
        const isToken = params.token && params.token.length // string

        return isToken
    },
    asyncData({params}) {
        return {
            token: params.token
        }
    },
    async fetch() {
        // Init check role of Art
        await this.initCheckRoleOfArt()
        // Check validate of Offer
        await this.initValidateOffer({token: this.token})
    },
    mixins: [
        offerUser,
        role
    ],
    data() {
        return {
            showMore: false,
            policy1: [],
            policy2: [],
            typeOffer: '',
            statusOffer: 'CONTRACT_OFFER_INIT',
            visibleTemplate: false,
            token: '',
            contractInfo: {}
        };
    },
    head() {
        return {
            title: `Offer | Dada`,
            bodyAttrs: {
                class: 'current-page-offer'
            }
        }
    },
    created() {
        if (process.client) {
            this.$root.$on('eventChangeRoleArtistOrDad', payload => {
                if (!payload || !Object.prototype.hasOwnProperty.call(payload, "type")) {
                    return;
                }

                window.location.href = '/mypage'
            })
        }
    },
    methods: {
        ...mapActions({
            confirmOfferForArt: "offer-art/confirmOfferForArt",
        }),
        async clickOffer() {
            const {policy1, policy2} = this
            const isValid = await this.$refs.observer.validate();
            if (!isValid) {
                return
            }

            // Check login
            if (!this.$auth || !this.$auth.user || !this.$auth.user.id || !this.$auth.user.type) {
                this.$router.push({path: '/login'})
                return
            }

            // Check role Artist
            if (this.$auth.user.type !== TYPE_ARTIST_ROLE) {
                await this.switchAccount(TYPE_ARTIST_ROLE, {action: 'update_page'})
            }
            await this.$forceUpdate()

            await this.confirmOfferForArt({token_contract_offer: this.token})
                .then(data => {
                    const result = Object.prototype.hasOwnProperty.call(data, 'result')
                    && Object.prototype.hasOwnProperty.call(data.result, 'data') ? data.result.data : {}

                    if (!Object.keys(result).length || !Object.prototype.hasOwnProperty.call(result, 'token_confirm')) {
                        throw new Error('Map data contract fail');
                    }

                    this.$router.push({path: `/mypage/contract/${this.token}/${result.token_confirm}`})
                }).catch(err => {
                    console.error('CF contract:fall', err)
                    this.$toast.error('エラーが発生しました。再度お試しください。')
                })
        },
        funcCancelTemplate(payload) {
            this.visibleTemplate = false
            setTimeout(() => {
                this.$router.push({path: '/'})
            }, 100)
        }
    }
};
</script>

<style lang="less" src="assets/less/user/contract-offer.less"></style>

