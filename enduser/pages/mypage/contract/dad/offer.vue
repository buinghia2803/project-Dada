<template>
    <div style="height:100%">
        <div v-if="step == 1" class="main-contract-dad-offer">
            <div class="warp-contract">
                <div class="box-avatar">
                    <div class="icon-change d-flex">
                        <img class="image-avatar" v-if="!this.$auth.user.image_url" src="~/assets/images/avatar.png" alt="">
                        <template v-else>
                            <img class="image-avatar" :src="this.$nuxt.context.env.IMAGE_URL + this.$auth.user.image_url" alt="logo">
                        </template>
                    </div>
                </div>

                <div class="info-author mt-2">
                    <div class="title-sub">契約実績：{{ this.getCountContractUser.count_contract }}</div>
                    <div class="title fw-bold">{{ this.$auth.user.full_name }}名</div>
                </div>

                <div class="info-bio mt-1 mb-1">
                    <p class="m-0">{{ this.$auth.user.positions }}</p>
                    <p class="decoration-under wallet-color">{{ this.$auth.user.public_address_main }}</p>
<!--                    <div class="m-0 bio" v-html="this.$auth.user.description"></div>-->
                    <div class="m-0 bio" v-html="getDescription"></div>

                </div>

                <h2 class="title fw-bold">契約依頼内容</h2>

                <div class="warp-contract-create">
                    <ValidationObserver ref="observer">
                        <a-form
                            id="formCreateContract"
                            ref="formState"
                            :label-col="{ md: 4 }"
                            slot-scope="{ handleSubmit }"
                            @submit.prevent="handleSubmit(createOffer)"
                        >
                            <a-spin :spinning="false">
                                <div class="py-3">
                                    <a-row>
                                        <div class="mb-1 label-custom">契約期間</div>
                                        <a-col :span="11" :xl="30" class="col-date-start">
                                            <ValidationProvider name="date_start" rules="required">
                                                <a-form-item slot-scope="{ errors }"
                                                             :validateStatus="errors[0] ? 'error' : 'success'"
                                                             :help="errors[0]"
                                                >
                                                    <div class="d-flex">
                                                        <a-config-provider :locale="localeDateTime">
                                                        <a-date-picker v-model="formState.date_start"
                                                                       class="ant-col-20"
                                                                       placeholder="開始日"
                                                                       :locale="'ja_JP'"
                                                                       :format="'YYYY.MM.DD'"
                                                                       :disabled-date="disabledStartDate"
                                                                       size="large"/>
                                                        </a-config-provider>
                                                    </div>
                                                </a-form-item>
                                            </ValidationProvider>
                                        </a-col>
                                        <a-col :span="1" :xl="30" class="mt-1">~</a-col>
                                        <a-col :span="11" :xl="30">
                                            <ValidationProvider name="date_end" rules="required">
                                                <a-form-item slot-scope="{ errors }"
                                                             :validateStatus="errors[0] ? 'error' : 'success'"
                                                             :help="errors[0]"
                                                >
                                                    <a-config-provider :locale="localeDateTime">
                                                    <a-date-picker v-model="formState.date_end"
                                                                   class="ant-col-20"
                                                                   :locale="'ja_JP'"
                                                                   placeholder="終了日"
                                                                   :disabled-date="disabledEndDate"
                                                                   :format="'YYYY.MM.DD'"
                                                                   size="large"/>
                                                    </a-config-provider>
                                                </a-form-item>
                                            </ValidationProvider>
                                        </a-col>
                                    </a-row>
                                    <a-row>
                                        <div class="mb-1 label-custom">販売金額</div>
                                        <a-col>
                                            <ValidationProvider
                                                name="selling_price"
                                                rules="required|selling_price"
                                            >
                                                <a-form-item slot-scope="{ errors }"
                                                             :validateStatus="errors[0] ? 'error' : 'success'"
                                                             :help="errors[0]"
                                                             class="ant-col-25"
                                                >
                                                    <a-input v-model="formState.selling_price" placeholder="0.1" size="large">
                                                        <img src="~/assets/images/c-eth.svg" alt="eth" slot="prefix">
                                                    </a-input>
                                                    <p class="m-0 notice-high">※販売金額は後から変更できますが、値下げのみ可能となっています。</p>
                                                </a-form-item>
                                            </ValidationProvider>
                                        </a-col>
                                    </a-row>
                                    <a-row>
                                        <div class="mb-1 label-custom">販売配当率</div>
                                        <a-col>
                                            <ValidationProvider
                                                name="artist_percent"
                                                rules="required|isPercent"
                                            >
                                                <a-form-item  slot-scope="{ errors }"
                                                              :validateStatus="errors[0] ? 'error' : 'success'"
                                                              :help="errors[0]"
                                                >
                                                    <div class="d-flex black">
                                                        <div class="label">Artist</div>
                                                        <a-input v-model="formState.artist_percent"
                                                                 class="ant-col-5 ml-2 pl-1 mr-2"
                                                                 placeholder="" size="large"
                                                                 @change="updateDadPercent($event)"
                                                                 addon-after="%"/>
                                                        <div class="label ml-3">Dad</div>
                                                        <div class="ml-2">{{formState.dad_percent}}%</div>
                                                    </div>
                                                </a-form-item>
                                            </ValidationProvider>
                                        </a-col>
                                    </a-row>
                                    <a-row>
                                        <div class="mb-1 label-custom">参考例</div>
                                        <a-col>
                                            <ValidationProvider
                                                name="responsibility"
                                                rules="max:2000"
                                            >
                                                <a-form-item  slot-scope="{ errors }"
                                                              :validateStatus="errors[0] ? 'error' : 'success'"
                                                              :help="errors[0]"
                                                >
                                                    <template>
                                                        <a-textarea v-model="formState.responsibility" :rows="5"
                                                                    placeholder="私が運営するメディアにて作品を掲載させていただきます。"/>
                                                    </template>
                                                </a-form-item>
                                            </ValidationProvider>
                                        </a-col>
                                    </a-row>
                                    <a-row>
                                        <div class="mb-1 label-custom">コメント</div>
                                        <a-col>
                                            <ValidationProvider
                                                name="contact_info"
                                                rules="max:1000"
                                            >
                                                <a-form-item slot-scope="{ errors }"
                                                             :validateStatus="errors[0] ? 'error' : 'success'"
                                                             :help="errors[0]"
                                                >
                                                    <template>
                                                        <a-textarea v-model="formState.contact_info" :rows="5"
                                                                    placeholder="よろしくお願いしたします！ご不明な点がありましたらいつでもご連絡ください！"/>
                                                    </template>
                                                </a-form-item>
                                            </ValidationProvider>
                                        </a-col>
                                    </a-row>
                                </div>
                                <h3 class="title-policy-1">プライバシーポリシー</h3>
                                <div class="warp-policy-1">
                                    <div class="item-policy" v-for="n of 5" :key="n">
                                        <p class="label-policy m-0">プライバシー</p>
                                        <p class="value-policy m-0">
                                            プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。
                                        </p>
                                    </div>
                                </div>
                                <div class="agree-policy">
                                    <a-checkbox v-model="formState.accept_policy">
                                        プライバシーポリシーに同意します
                                    </a-checkbox>
                                </div>
                                <h3 class="title-policy-2 fw-bold">利用規約</h3>
                                <div class="warp-policy-2">
                                    <div class="item-policy" v-for="n of 5" :key="n">
                                        <p class="label-policy m-0">利用規約</p>
                                        <p class="value-policy m-0">
                                            利用規約が入ります。利用規約が入ります。利用規約が入ります。利用規約が入ります。利用規約が入ります。利用規約が入ります。
                                        </p>
                                    </div>
                                </div>
                                <div class="agree-policy">
                                    <a-checkbox v-model="formState.accept_term">
                                        利用規約に同意します
                                    </a-checkbox>
                                </div>
                                <div class="pb-3">
                                    <a-row type="flex" :gutter="20">
                                        <a-col :span="24" :xl="30">
                                            <a-row :gutter="0">
                                                <a-col :span="24" :md="4"></a-col>
                                                <a-col :span="24" :md="14">
                                                    <a-form-item style="margin-top: 24px">
                                                        <div class="btn-action-offer">
                                                            <a-config-provider :autoInsertSpaceInButton="false">
                                                                <a-button html-type="submit" class="bg-green-txt-white">
                                                                    契約オファーを送信
                                                                </a-button>
                                                            </a-config-provider>
                                                        </div>
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>
                                        </a-col>
                                    </a-row>
                                </div>

                            </a-spin>
                        </a-form>
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <div v-if="step == 2" class="main-contract-dad-offer-email">
            <div class="warp-contract">
                <div class="info-about mt-2">
                    <p class="title-sub m-0">契約オファーを送る連絡先を</p>
                    <p class="title-sub m-0">入力してください。</p>
                </div>

                <ValidationObserver ref="observer">
                    <a-form
                        id="formSendMail"
                        ref="formState"
                        :label-col="{ md: 4 }"
                        slot-scope="{ handleSubmit }"
                        @submit.prevent="handleSubmit(sendMail)"
                    >
                        <div class="warp-contract-create">
                            <div class="warp-content-grid">
                                <div class="mb-1 label-bold label-mail">メールアドレス</div>
                                <ValidationProvider name="email" rules="required|email_trimmed_no_dash">
                                    <a-form-item slot-scope="{ errors }"
                                                 :validateStatus="errors[0] ? 'error' : 'success'"
                                                 :help="errors[0]"
                                                 class="label-bold"
                                    >
                                        <a-input v-model="formState.email" placeholder="" size="large"/>
                                    </a-form-item>
                                </ValidationProvider>
                            </div>
                            <div class="btn-action-offer d-flex justify-content-center mt-9">
                                <a-button class="btn-default btn-back mr-2" @click="backToCreateOffer">
                                    戻る
                                </a-button>
                                <a-config-provider :autoInsertSpaceInButton="false">
                                    <a-button html-type="submit" class="bg-green-txt-white">
                                        送信する
                                    </a-button>
                                </a-config-provider>
                            </div>
                        </div>
                    </a-form>
                </ValidationObserver>
            </div>
        </div>
        <div v-if="step == 3" class="main-contract-dad-finish">
            <div class="warp-contract-finish">
                <h3>契約オファーが送信されました。</h3>
                <p class="role-btn decoration-under r2-mypage text-center" @click="r2Mypage">myページへ</p>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import {mapActions, mapGetters} from "vuex";
    import 'moment/locale/ja';
    moment.locale('ja');
    import ja_JP from 'ant-design-vue/es/locale/ja_JP';
    import {TYPE_ARTIST_ROLE, TYPE_DAD_ROLE} from "@/utils/constants";

    export default {
        layout: "main",
        components: {
        },
        data() {
            return {
                labelCol: {span: 4},
                formState: {
                    dad_id: '',
                    date_start: '',
                    date_end: '',
                    selling_price: '',
                    artist_percent: '',
                    dad_percent: '',
                    responsibility: '',
                    contact_info: '',
                    accept_policy: false,
                    accept_term: false,
                    email: ''
                },
                localeDateTime: ja_JP,
                step: 1 // 1: create offer, 2: send mail, 3: finish
            };
        },
        async fetch() {
            // Init check role of Dad
            await this.initCheckRoleOfDad()
        },
        computed: {
            ...mapGetters('user', [
                'getCountContractUser'
            ]),
            getDescription(){
                return this.$auth.user.description ? this.$auth.user.description.replaceAll('\n','<br>') : '';
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
        mounted() {
            this.countContractUser();
        },
        methods: {
            ...mapActions({
                actionGetCountContract: "user/actionGetNumberContractUser",
                actionAdd: "offer/actionAdd",
            }),
            initCheckRoleOfDad() {
                if (!this.$auth || !this.$auth.user || !this.$auth.user.type || this.$auth.user.type !== TYPE_DAD_ROLE) {
                    this.$nuxt.context.redirect('/mypage')
                    this.$toast.info('続行するにはDad役割の切り替えの必要です。')
                    return;
                }
            },
            /**
             * Get count contract of current user
             * @returns {Promise<void>}
             */
            async countContractUser() {
                this.loading = true;
                //get count contract of current user
                await this.actionGetCountContract(this.$auth.id);
                this.loading = false;
            },
            /**
             * validate disabled start date
             * @param startValue
             * @returns {boolean}
             */
            disabledStartDate(startValue) {
                const endValue = this.formState.date_end;

                if (!startValue) {
                    return false;
                }
                if (startValue.format('YYYYMMDD') < moment().add(1, 'days').format('YYYYMMDD')) {
                    return true
                }

                if (startValue.format('YYYYMMDD') > moment().add(6, 'months').format('YYYYMMDD')) {
                    return true;
                }

                if (!endValue) {
                    return false;
                }

                return startValue.valueOf() > endValue.valueOf();
            },
            /**
             * validate disable end date
             * @param endValue
             * @returns {boolean}
             */
            disabledEndDate(endValue) {
                const startValue = this.formState.date_start ? this.formState.date_start : moment(new Date());
                if (!startValue) {
                    return true;
                }
                if (endValue.format('YYYYMMDD') > moment().add(6, 'months').add(1, 'days').format('YYYYMMDD')) {
                    return true;
                }
                return startValue.valueOf() > endValue.valueOf();
            },
            /**
             * update dad percent from artist percent
             */
            updateDadPercent() {
                this.formState.dad_percent = (!isNaN(this.formState.artist_percent) && this.formState.artist_percent >= 0 &&  this.formState.artist_percent <= 100)
                    ? (100 - this.formState.artist_percent) : '';
            },
            /**
             * next to step write email
             * @returns {Promise<boolean>}
             */
            async createOffer() {
                if (!this.formState.accept_policy || !this.formState.accept_term) {
                    this.$toast.error(this.$t('messages.error.approve_policy'));
                    return false;
                }
                this.step = 2; // send mail
                this.$forceUpdate();
            },
            /**
             * Send data to create offer and send mail for artist
             * next to screen finish
             * @returns {Promise<void>}
             */
            async sendMail() {
                this.loading = true;
                let dataSend = this.formState;

                //dad create offer and send mail for artist
                dataSend.date_start = this.formState.date_start.format('YYYY-MM-DD HH:mm:ss')
                dataSend.date_end = this.formState.date_end.format('YYYY-MM-DD HH:mm:ss')
                dataSend.dad_id = this.getCountContractUser.id;
                delete dataSend.accept_policy
                delete dataSend.accept_term

                this.actionAdd(dataSend).then((response) => {
                    if (response.data) {
                        this.step = 3; // finish
                    } else {
                        this.$toast.error('error!')
                    }
                }).catch((error) => {
                    console.log(error);
                });

                this.loading = false;
            },
            /**
             * back to screen create offer
             */
            backToCreateOffer() {
                this.step = 1; // back to create offer
            },
            /**
             * back to my page
             */
            r2Mypage() {
                this.$router.push({path: '/mypage'})
            }
        }
    };
</script>

<style lang="less" src="assets/less/user/contract-offer.less"></style>

<style lang="less">
.col-date-start {
    margin: 0px -23px 0 0;
}

@media (max-width: 567px) {
    .col-date-start {
        margin: 0px -19px 0 0;
    }
}
</style>
