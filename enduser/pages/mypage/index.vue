<template>
    <div class="main-mypage">
        <div class="mt-4 ml-2">
            <div class="box-service-wrap">
                <template v-if="!changeService">
                    <span class="fw-bold mr-2" @click="switchService">連携サービス</span>
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg"
                         @click="switchService">
                        <path
                            d="M7.49977 5.81875L12.656 0.25L14.1289 1.84075L7.49977 9.00025L0.870605 1.84075L2.34352 0.25L7.49977 5.81875Z"
                            fill="black"/>
                    </svg>
                </template>
                <template v-else>
                    <span class="fw-bold mr-2" @click="switchService">連携サービス</span>
                    <svg width="15" height="9" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"
                         @click="switchService">
                        <path
                            d="M5.00001 2.21953L1.70001 5.51953L0.757341 4.57687L5.00001 0.334198L9.24268 4.57686L8.30001 5.51953L5.00001 2.21953Z"
                            fill="black"/>
                    </svg>
                    <div class="box-service">
                        <span class="box-service_opensea">
                            <a href="https://opensea.io/" target="_blank">
                                <img class="ct-img-size-1 first" src="@/assets/images/opensea.svg" alt="opensea">
                                <img class="ct-img-size-2 second" src="@/assets/images/opensea-text.svg"
                                     alt="opensea-text">
                            </a>
                        </span>
                        <span class="box-service_metamask">
                            <a href="https://metamask.io/" target="_blank">
                                <img class="ct-img-size first" src="@/assets/images/metamask.svg" alt="metamask">
                            </a>
                        </span>
                    </div>
                </template>
            </div>
        </div>

        <div v-if="$auth.user" class="warp-profile">
            <div class="wrap-avatar">
                <div v-if="$auth.user.image_url">
                    <img :src="$nuxt.context.env.IMAGE_URL + $auth.user.image_url" alt="avatar" height="120px" width="120px"
                        style="border-radius: 50% !important;">
                </div>
                <template v-else>
                    <img class="image-avatar" src="~/assets/images/avatar.png" alt="avatar">
                </template>
            </div>
            <a-card :title="$auth.user.full_name" :bordered="false" class="content-profile">
                <p>{{ $auth.user.positions }}</p>
                <p class="bio">{{ $auth.user.description }}</p>
                <div class="card-actions">
                    <a-config-provider :autoInsertSpaceInButton="false">
                        <a-button class="" @click="visibleEditProfile = true">編集</a-button>
                    </a-config-provider>
                    <a-config-provider :autoInsertSpaceInButton="false">
                        <a-button class="btn-mypage-dad text-white" v-if="$auth.user.type === type_dad" @click="clickDadOffer">
                            契約オファーを発行
                        </a-button>
                    </a-config-provider>
                </div>
            </a-card>
        </div>

        <div class="warp-services">
            <div class="d-flex justify-content-end role-btn btn-filter-sc mb-2" @click="visibleFilter = true">
                <img class="d-filter" src="@/assets/images/c-filter.svg" alt="c-filter">
                <span>絞り込み</span>
            </div>
            <div class="list-sm-contract-sp">
                <div class="g-items" v-for="item in contractOfferData"
                     :key="item.id"
                     @click="redirectDetailArt(n)">
                    <div class="items role-btn">
                        <div class="nsft">
                            <img v-if="item.contract_nft && item.contract_nft.image_img"
                                 :src="item.contract_nft.image_url"
                                 alt="nsft">
                            <img v-else src="@/assets/images/no-image.png" alt="nsft">
                        </div>
                        <div class="content-box">
                            <p class="m-0 line-1">
                                {{ moment(item.start_date).format('YYYY.MM.DD') }} ~
                                {{ moment(item.end_date).format('YYYY.MM.DD') }}</p>
                            <p v-if="$auth.user" class="m-0 line-2">
                                <span v-if="$auth.user.type === type_dad">Artist: {{ item.dad.full_name }}</span>
                                <span v-else>Dad: {{ item.dad.full_name }}</span>
                            </p>
                            <p class="m-0 line-3">{{ item.name }}</p>
                        </div>
                        <div v-if="$auth.user" class="price-eth">
                            <span v-if="$auth.user.type === type_dad">{{ item.dad_price }}ETH</span>
                            <span v-else>{{ item.artist_price }}ETH</span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect width="24" height="24" transform="translate(0 24) rotate(-90)" fill="white"/>
                                <path
                                    d="M13.1717 12.0012L8.22168 7.05123L9.63568 5.63723L15.9997 12.0012L9.63568 18.3652L8.22168 16.9512L13.1717 12.0012Z"
                                    fill="#B3B3B3"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <a-table
                v-if="this.contractOfferData"
                :scroll="{ x: 400 }"
                :locale="{emptyText: $t('common.no_data')}"
                :columns="gcolumns"
                :dataSource="contractOfferData"
                :pagination="false"
                :class="'list-sm-contract-pc d-table-custom-user'"
                :rowClassName="(record, index) => `d-custom-${index % 2 ? 'old' : 'even'}`"
                @change="handleTableChange">
                <span slot="customTitle"><a-icon type="smile-o"/> Name</span>
                <div class="role-btn" @click="handleRedirect(record)" slot="name" slot-scope="text, record">
                    {{ text }}
                </div>
                <template slot="image" slot-scope="text, record">
                    <div v-if="record.contract_nft" style="display: flex; align-items: center">
                        <img class="ct-img-size" :src="record.contract_nft.image_url" alt="">
                    </div>
                    <div v-else>
                        <img class="ct-img-size" src="@/assets/images/no-image.png" alt="">
                    </div>
                </template>
                <div slot="dateRender" class="d-flex cuts-date" slot-scope="text, record">
                    <span class="line-1">{{ moment(record.date_start).format('YYYY.MM.DD') }}</span>
                    <span class="line-2">~</span>
                    <span class="line-3">{{ moment(record.date_end).format('YYYY.MM.DD') }}</span>
                </div>
                <div v-if="$auth.user" slot="contract_offer_price" slot-scope="text, record" class="text-center price">
                    <img src="~/assets/images/c-eth.svg" alt="eth">
                    <span v-if="$auth.user.type === type_dad">{{ record.dad_price }}</span>
                    <span v-else>{{ record.artist_price }}</span>
                </div>
                <div v-if="$auth.user" slot="dad_artist_name" class="d-flex cuts-date" slot-scope="text, record">
                    <div v-if="$auth.user.type === type_dad"><span v-if="record.artist">{{ record.artist.full_name }}</span>
                    </div>
                    <div v-else><span v-if="record.dad">{{ record.dad.full_name }}</span></div>
                </div>
                <div v-if="$auth.user && record.contract_nft" slot="status" class="d-flex cuts-date text-center" slot-scope="text, record">
                    <span v-if="record.contract_nft.status === statusContractNFT.WAIT_FOR_CONFIRM
                    || record.contract_nft.status === statusContractNFT.APPROVE">契約前</span>
                    <span v-if="record.contract_nft && record.contract_nft.status === statusContractNFT.REJECT">契約破棄</span>
                    <span
                        v-if="(record.contract_nft && record.contract_nft.status === statusContractNFT.APPROVE_OPENSEA || record.contract_nft.status === statusContractNFT.REJECT_OPENSEA)">契約中</span>
                    <span v-if="record.contract_nft && record.contract_nft.status === statusContractNFT.APPROVE_OPENSEA &&
                     record.date_end < moment().format('YYYY-MM-DD') && record.status === statusContractOffer.SOLD">契約満了</span>
                    <span v-if="record.contract_nft && record.contract_nft.status === statusContractNFT.APPROVE_OPENSEA && record.status === statusContractOffer.SOLD">契約満了</span>
                </div>


                <span slot="sellPriceRender" slot-scope="sellPrice" class="price">
                    <img src="~/assets/images/c-eth.svg" alt="eth">
                    <span>{{ sellPrice }}</span>
                </span>
            </a-table>

        </div>
        <HelpFilter :visibleFilter="visibleFilter"
                    @visibleFilterChange="funcVisibleFilterChange"/>

        <ModelGuideLine/>
        <ModelEditProfile :visibleEditProfile="visibleEditProfile"
                          @funcEditProfile="funcVisibleEditProfile"/>
        <ModalNotEnough v-if="role === 'dad'"
                        :visibleNotEnough="visibleNotEnough"
                        @eventNotEnough="funcEventNotEnough"/>
    </div>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from "vuex";
import {
    TYPE_DAD_ROLE, STATUS_NFT_OFFER, STATUS_CONTRACT_OFFER } from "@/utils/constants";

export default {
    layout: "main",
    // middleware: 'authenticated',
    components: {
        HelpFilter: () => import('~/components/custom/HelpFilter.vue'),
        ModelGuideLine: () => import('~/components/custom/modal/ModelGuideLine.vue'),
        ModelEditProfile: () => import('~/components/custom/modal/ModelEditProfile.vue'),
        ModalNotEnough: () => import('~/components/custom/modal/ModalNotEnough.vue')
    },
    data() {
        return {
            hasMoreQuotes: false,
            changeService: false,
            visibleNotEnough: false,
            visibleEditProfile: false,
            visibleFilter: false,
            ListContractOfferSp: [],
            dataUser: {},
            page: 1,
            perPage: 10,
            pages: [],
            contractOfferData: [],
            role: 'dad', // art, dad
            statusContractOffer: STATUS_CONTRACT_OFFER,
            statusContractNFT: STATUS_NFT_OFFER,
            type_dad: TYPE_DAD_ROLE,
            gcolumns: [
                {
                    title: '作品',
                    dataIndex: 'contract_nft.image_url',
                    slots: {title: 'cutsNameTitle'},
                    scopedSlots: {customRender: 'image'},
                    className: "titleColumn",
                    key: 'name',
                    width: 110,
                }, {
                    title: '作品名',
                    dataIndex: 'contract_nft.name',
                    className: "titleColumn",
                    key: 'typeVip',
                    width: 140,
                }, {
                    title: '配当',
                    dataIndex: 'artist_price',
                    scopedSlots: {customRender: 'contract_offer_price'},
                    className: "titleColumn",
                    width: 120,
                }, {
                    title: '契約期間',
                    dataIndex: 'date_start',
                    scopedSlots: {customRender: 'dateRender'},
                    defaultSortOrder: 'descend',
                    className: "titleColumn",
                    sorter: (a, b) => a.date - b.date,
                    key: 'date',
                    width: 90,
                }, {
                    title: '販売価格',
                    dataIndex: 'selling_price',
                    scopedSlots: {customRender: 'sellPriceRender'},
                    defaultSortOrder: 'descend',
                    className: "titleColumn",
                    sorter: true,
                    key: 'selling_price',
                    width: 110,
                }, {
                    title: (this.$auth.user && this.$auth.user.type === this.type_dad) ? 'Artist' : 'Dad',
                    dataIndex: 'artist',
                    className: "titleColumn",
                    scopedSlots: {customRender: 'dad_artist_name'},
                    key: 'dad',
                    width: 110,
                }, {
                    title: '契約ステータス',
                    dataIndex: 'status',
                    className: "titleColumn",
                    scopedSlots: {customRender: 'status'},
                    key: 'address 1',
                    width: 90,
                },
            ],
        };
    },

    computed: {
        ...mapGetters({
            getterListContractOfferByUser: "contract-offer/getterListContractOfferByUser",
            getterMetaContractOfferByUser: "contract-offer/getterMeta",
        }),
        moment: () => moment,
    },
    watch: {},
    mounted() {
        this.getList()
    },
    created() {
        if (process.client) {
            document.addEventListener('scroll', this.scroll)
        }
    },
    methods: {
        ...mapActions({
            actionGetListContractOfferByUser: "contract-offer/actionGetListContractOfferByUser",
        }),
        scroll() {
            const {scrollTop, scrollHeight, clientHeight} = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight && !this.hasMoreQuotes) {
                this.paramter.page = (+this.paramter.page ? +this.paramter.page : 1) + 1;
                this.getList()
            }
        },
        switchService() {
            this.changeService = !this.changeService
        },
        getList(pagination = {}, filters, sorter) {
            this.loading = true;
            const id = +this.$auth.user.id || 0
            // get contract info by id
            if (id) {
                // check pagination push to paramter
                this.paramter = {...{id: id}, ...this.paramter};
                // push parameter to router query
                this.actionGetListContractOfferByUser(this.paramter).then(response => {
                    if (!response.data.length) {
                        this.hasMoreQuotes = true
                    }
                    this.contractOfferData = this.contractOfferData.concat(this.getterListContractOfferByUser)
                }).finally(() => {
                    this.loading = false
                })
            }
        },
        handleTableChange(pagination, filters, sorter) {
            if (sorter) {
                this.paramter.sort = sorter.field.split('.').length > 1 ? sorter.field.split('.')[1] : sorter.field
                this.paramter.sortType = sorter.order == 'ascend' ? 1 : 0;
            }
            if (pagination.current) {
                this.paramter.page = pagination.current;
            }
            this.paramter = {...this.paramter, ...sorter};
            this.getList()
        },
        clickDadOffer() {
            // TODO next after check visibleNotEnough
            this.$router.push({path: '/mypage/contract/dad/offer'})
        },
        funcEventNotEnough(payload) {
            this.visibleNotEnough = false
        },
        funcVisibleFilterChange(payload) {
            this.visibleFilter = false
        },
        funcVisibleEditProfile(payload) {
            this.visibleEditProfile = false
        },
        redirectDetailArt(payload) {
            // TODO
            return this.$router.push({path: '/mypage/art/4444'})
        },
        handleRedirect(payload) {
            // TODO
            this.$router.push({path: '/mypage/art/4444'})
        }
    }
}
</script>

<style lang="less">
button.page-link {
    display: inline-block;
}

button.page-link {
    font-size: 20px;
    color: #29b3ed;
    font-weight: 500;
}

.offset {
    width: 500px !important;
    margin: 20px auto;
}

th.titleColumn,
td.titleColumn {
    text-align: center !important;
}

.price {
    display: flex;
    align-items: center;
    justify-content: center;

    & > span {
        margin-left: 2px !important;
    }
}

.ct-img-size {
    width: 100px;
    height: 100px;
}

.box-service {
    margin-top: 10px;
    display: flex;
    flex-direction: column;

    .box-service_opensea,
    .box-service_metamask {
        margin-top: 8px;

        a {
            img.first {
                height: 24px;
            }

            img.second {
                height: 18px;
                padding-top: 4px;
            }
        }
    }
}

.warp-profile {
    width: 100%;
    padding: 10px 245px;
    display: flex;
    justify-content: center;

    .wrap-avatar {
        width: clac(100% - 60px);
        display: flex;
        justify-content: center;

        img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            vertical-align: middle;
        }
    }

    .content-profile {
        width: 100%;

        .ant-card-head {
            border-bottom: unset;

            .ant-card-head-title {
                font-weight: bold;
                font-size: 24px;
                line-height: 35px;
                padding-top: 8px;
                white-space: nowrap;
                overflow: hidden !important;
                text-overflow: ellipsis;
                width: 120px;
            }
        }

        .ant-card-body {
            padding-top: 0;

            p {
                margin-bottom: 0;
                font-weight: 400;
                font-size: 16px;
            }

            p.bio {
                margin-top: 21px;
            }
        }

        .card-actions {
            background: transparent;
            border-top: unset;
            margin-top: 8px;

            .ant-btn {
                height: 40px;

                span {
                    padding: 4px 32px;
                    font-size: 16px;
                }
            }

            .btn-mypage-dad {
                background: black;
                margin-left: 12px;
            }
        }
    }
}

.warp-services {
    & > div {
        span {
            margin: 0 20px 0 12px;
        }
    }

    .list-sm-contract-sp {
        display: none !important;
    }

    .pagination-sp {
        display: none !important;
    }

    .cuts-date {
        flex-direction: column;
        justify-self: center;
        justify-content: center;

        span.line-1,
        span.line-3 {
            align-self: center;
        }

        span.line-2 {
            align-self: center;
            transform: rotate(90deg);
        }
    }
}

@media (max-width: 990px) {
    .warp-profile {
        padding: 10px 105px;

        .content-profile .card-actions .ant-btn span {
            padding: 8px 24px;
        }
    }
}

@media (max-width: 678px) {
    .warp-profile {
        padding: 10px 55px;

        .content-profile .card-actions .ant-btn span {
            padding: 8px 16px;
        }
    }

    .warp-services {
        .list-sm-contract-pc {
            display: none !important;
        }

        .list-sm-contract-sp {
            margin-top: 16px;
            display: block !important;

            .g-items {
                border-top: 1px solid #E6E6E6;

                &:last-child {
                    border-bottom: 1px solid #E6E6E6;
                }

                .items {
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                    padding: 8px 16px;


                    .nsft {
                        margin-right: 16px;

                        img {
                            height: 60px;
                            width: 60px;
                            object-fit: cover;
                        }
                    }

                    .content-box {
                        width: 100%;

                        p.line-1 {
                            color: #B3B3B3;
                            font-size: 10px;
                        }

                        p.line-2 {
                            font-size: 10px;
                        }

                        p.line-3 {
                            font-size: 14px;
                        }
                    }

                    .price-eth {
                        display: flex;

                        span {
                            margin: 0 8px 0 0;
                            font-size: 16px;
                            font-weight: bold;
                        }
                    }
                }
            }
        }

        .pagination-sp {
            margin-right: 10px;
            display: block !important;
        }
    }
}

@media (max-width: 567px) {
    .warp-profile {
        display: block;
        padding: 10px;

        .content-profile .card-actions .ant-btn span {
            padding: 8px;
            height: auto;
        }
    }
}

@media (max-width: 375px) {
    .warp-profile {
        .content-profile .card-actions .ant-btn span {
            padding: 8px 0;
            height: auto;
        }
    }
}
</style>

