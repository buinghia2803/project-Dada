<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("module.offer") }}
                </template>

                <div class="box-filters pt-2 pb-4">
                    <div class="offer-search-group">
                        <div class="res-marg-offer">
                            <a-config-provider :locale="localeDate">
                                <a-date-picker
                                    :default-value="defaultCreatedAt"
                                    :locale="localeDate"
                                    placeholder="作成日"
                                    class="ct-with-offer-index"
                                    :format="'YYYY.MM.DD'"
                                    @change="onChangeDate">
                                    <a-icon slot="suffixIcon" type="calendar"/>
                                </a-date-picker>
                            </a-config-provider>
                        </div>
                        <div class="res-marg-offer">
                            <input
                                type="text"
                                class="ct-input-search-offer ant-input shorten-name"
                                placeholder="Dad名"
                                v-model="search.dad_name"
                                maxLength="200"
                            />
                        </div>
                        <div class="res-marg-offer">
                            <a-select
                                class="ct-input-search-offer"
                                ref="select"
                                v-model="search.status"
                                style="width: 120px"
                            >
                                <a-select-option value="" disabled hidden>すべて</a-select-option>
                                <a-select-option v-for="(item, index) in offerStatus" :key="index" :value="item.id">
                                    {{ item.label }}
                                </a-select-option>
                            </a-select>
                        </div>
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button @click="onSearchOffer()"
                                      class="btn-info res-marg-offer">
                                {{ $t('common.search') }}
                            </a-button>
                        </a-config-provider>
                    </div>
                </div>

                <a-table
                    :class="'d-table-custom-1'"
                    :rowClassName="(record, index) => `d-custom-tr d-custom-${index % 2 ? 'old' : 'even'}`"
                    :columns="columns"
                    :row-key="record => record.id"
                    :data-source="getterListOffer"
                    :pagination="paginate"
                    :scroll="{ x: 400 }"
                    :locale="{emptyText: 'データがありません。'}"
                    @change="getOfferList"
                >
                    <template slot="dad_name" slot-scope="text, record">
                        <div class="flex-item">
                            <div class="shorten-name" v-if="record.dad && record.dad.full_name">
                                {{ record.dad.full_name }}
                            </div>
                        </div>
                    </template>
                    <template slot="duration" slot-scope="text, record">
                        <div v-if="record.date_start">
                            {{ moment(record.date_start).format('YYYY.MM.DD') }}
                        </div>
                        <div v-else>----------</div>
                        <div class="ct-duration"> ~</div>
                        <div v-if="record.date_end">
                            {{ moment(record.date_end).format('YYYY.MM.DD') }}
                        </div>
                        <div v-else>----------</div>
                    </template>
                    <template slot="price" slot-scope="text, record">
                        <div class="flex-item">
                            <img class="eth-size" src="@/assets/images/eth-icon.svg">
                            <div v-if="record.selling_price">
                                {{ Number(record.selling_price) }}
                            </div>
                            <div class="ct-duration" v-else>-</div>
                        </div>
                    </template>
                    <template slot="rate" slot-scope="text, record">
                        <div>
                            Dad: {{ 100 - record.artist_percent }}%
                        </div>
                        <div>
                            Artist: {{ record.artist_percent }}%
                        </div>
                    </template>
                    <template slot="status" slot-scope="text, record">
                        {{ getOfferStatus(record) }}
                    </template>
                    <template slot="created_at" slot-scope="text, record">
                        {{ moment(record.created_at).format('YYYY.MM.DD') }}
                    </template>
                    <template slot="action" slot-scope="text, record">
                        <nuxt-link :to="{ name: 'offer-detail-id', params: { id: record.id } }">
                            <a-config-provider :autoInsertSpaceInButton="false">
                                <a-button class="btn-action" type="primary">詳細</a-button>
                            </a-config-provider>
                        </nuxt-link>
                    </template>
                </a-table>
                <!-- end main-table -->
            </a-card>
        </a-spin>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import BaseComponent from "~/mixins/BaseComponent";
import {OFFER_STATUS} from "~/utils/constants";
import moment from "moment";
import 'moment/locale/ja';
import jaJP from 'ant-design-vue/es/locale/ja_JP';

moment.locale('ja');

export default {
    components: {},

    mixins: [BaseComponent],

    data() {
        return {
            localeDate: jaJP,
            visible: false,
            currentId: 0,
            loading: false,
            listRoles: [],
            offerStatus: OFFER_STATUS,
            defaultCreatedAt: null,
            search: {
                created_at: '',
                dad_name: '',
                status: '',
            }
        };
    },
    head() {
        return {
            title: `${this.$t('menu.offer.default')}`,
            bodyAttrs: {
                class: 'current-page-offer-index'
            }
        }
    },
    computed: {
        ...mapGetters({
            getterListOffer: "offer/getterList",
            getterMetaOffer: "offer/getterMeta"
        }),
        moment: () => moment,
        columns() {
            return [
                {
                    title: this.$t("offer.id"),
                    dataIndex: "id",
                    sorter: true,
                    width: 80,
                },
                {
                    title: this.$t("offer.dad name"),
                    dataIndex: "",
                    scopedSlots: {customRender: "dad_name"},
                    width: 120,
                },
                {
                    title: this.$t("offer.email address"),
                    dataIndex: "email",
                    scopedSlots: {customRender: "email"},
                    width: 200,
                },
                {
                    title: this.$t("offer.contract term"),
                    dataIndex: "",
                    scopedSlots: {customRender: "duration"},
                    width: 100,
                },
                {
                    title: this.$t("offer.price"),
                    dataIndex: "selling_price",
                    scopedSlots: {customRender: "price"},
                    sorter: true,
                    width: 120,
                },
                {
                    title: this.$t("offer.Dividend rate"),
                    dataIndex: "",
                    scopedSlots: {customRender: "rate"},
                    width: 100,
                },
                {
                    title: this.$t("offer.status"),
                    dataIndex: "status",
                    scopedSlots: {customRender: "status"},
                    sorter: true,
                    width: 80,
                },
                {
                    title: this.$t("offer.created_at"),
                    dataIndex: "",
                    scopedSlots: {customRender: "created_at"},
                    width: 100,
                },
                {
                    title: this.$t("offer.action"),
                    dataIndex: "action",
                    scopedSlots: {customRender: "action"},
                    width: 90
                }
            ];
        },
        paginate() {
            if (this.getterMetaOffer && this.getterMetaOffer.last_page && this.getterMetaOffer.last_page < 2) {
                return false
            }
            return {
                ...this.getterMetaOffer,
                showLessItems: true
            }
        }
    },
    watch: {},
    mounted() {
        this.getOfferList();
    },
    methods: {
        ...mapActions({
            actionGetAllOffer: "offer/actionGetAll",
        }),
        /**
         * get list offers
         *
         * @param pagination
         * @param filters
         * @param sorter
         */
        getOfferList(pagination = {}, filters = null, sorter = null) {
            this.loading = true;
            // check pagination push to parameter
            if (sorter) {
                this.paramter.sort = sorter.field
                this.paramter.sortType = sorter.order == 'ascend' ? 1 : 0;
            }
            if (pagination.current) {
                this.paramter.page = pagination.current;
            }
            this.paramter = {...this.paramter};
            // push parameter to router query
            this.paramter = this.replaceQuery(this.paramter);

            this.actionGetAllOffer(this.paramter).finally(() => {
                this.loading = false;
            });
        },

        /**
         * Onchange duration param
         *
         * @param date
         * @param dateString
         */
        onChangeDate(date, dateString) {
            this.search.created_at = dateString;
        },

        /**
         * Search offer
         */
        onSearchOffer() {
            if (this.search) {
                this.paramter = {...this.paramter, ...this.search};
                this.paramter.page = 1
                this.getOfferList();
            }
        },
    },
    created() {
        const self = this;
        if (process.browser) {
            window.addEventListener('keydown', (e) => {
                if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13)
                    self.onSearchOffer()
            }, true);
            const {query} = this.$route

            this.search.status =  Object.prototype.hasOwnProperty.call(query, 'status') && query.status ? +query.status : 1;
            this.search.dad_name = Object.prototype.hasOwnProperty.call(query, 'dad_name') && query.dad_name ? query.dad_name : '';
            try {
                const created_at = Object.prototype.hasOwnProperty.call(query, 'created_at') && query.created_at ? query.created_at : ''
                if (created_at){
                    this.defaultCreatedAt = moment(created_at)
                }
            } catch (e) {
                this.defaultCreatedAt = null
            }
        }
    },
};
</script>
