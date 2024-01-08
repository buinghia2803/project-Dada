<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("module.contract") }}
                </template>

                <div class="box-filters pt-2 pb-4">
                    <div class="contract-search-group">
                        <div>
                            <label class="lb-duration hide-label">{{ $t("contract.search_date") }}</label>
                            <a-config-provider :locale="localeDateTime">
                                <a-range-picker
                                    :default-value="defaultDuration"
                                    :locale="localeDateTime"
                                    :placeholder="['開始日', '終了日']"
                                    class="ct-range-with"
                                    @change="onChangeDuration"
                                    format="YYYY.MM.DD">
                                    <a-icon slot="suffixIcon" type="calendar"/>
                                </a-range-picker>
                            </a-config-provider>
                        </div>
                        <div class="res-marg">
                            <input
                                type="text"
                                class="ct-input-search ant-input shorten-name"
                                :placeholder="$t('contract.search_dad_artist')"
                                v-model="search.username"
                                maxLength="200"
                            />
                        </div>
                        <div class="res-marg">
                            <input
                                type="text"
                                class="ct-input-search ant-input shorten-name"
                                :placeholder="$t('contract.search_name')"
                                v-model="search.name"
                                maxLength="200"
                            >
                        </div>
                        <div class="res-marg">
                            <a-select
                                class="ct-input-search"
                                ref="select"
                                v-model="search.status"
                                style="width: 120px"
                            >
                                <a-select-option value="" disabled hidden>すべて</a-select-option>
                                <a-select-option v-for="(item, index) in contractStatus" :key="index" :value="item.id">
                                    {{ item.label }}
                                </a-select-option>
                            </a-select>
                        </div>
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button @click="onSearch()"
                                      class="btn-info res-marg">
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
                    :data-source="getterListContract"
                    :pagination="paginate"
                    :scroll="{ x: 400 }"
                    :locale="{emptyText: 'データがありません。'}"
                    @change="getList"
                >
                    <template slot="offer_id" slot-scope="text, record">
                        <nuxt-link :to="{ name: 'offer-detail-id', params: { id: record.contract_offer_id } }">
                            <span>{{ record.contract_offer_id }}</span>
                        </nuxt-link>
                    </template>
                    <template slot="image" slot-scope="text, record">
                        <img
                            class="ct-img-size"
                            :src="(record.image_url ? $nuxt.context.env.IMAGE_URL + record.image_url : require('assets/images/no-image.png'))"
                            alt="">
                    </template>
                    <template slot="cus-name" slot-scope="text, record">
                        <div class="shorten-name"> {{ record.name }}</div>
                        <div class="shorten-name"
                             v-if="record.contractOffer && record.contractOffer.artist && record.contractOffer.artist.full_name">
                            Artist: {{ record.contractOffer.artist.full_name }}
                        </div>
                        <div class="shorten-name" v-else> Artist:</div>
                        <div class="shorten-name"
                             v-if="record.contractOffer && record.contractOffer.dad && record.contractOffer.dad.full_name">
                            Dad: {{ record.contractOffer.dad.full_name }}
                        </div>
                        <div class="shorten-name" v-else> Dad:</div>
                    </template>
                    <template slot="duration" slot-scope="text, record">
                        <div v-if="record.contractOffer && record.contractOffer.date_start">
                            {{ moment(record.contractOffer.date_start).format('YYYY.MM.DD') }}
                        </div>
                        <div v-else>----------</div>
                        <div class="ct-duration"> ~</div>
                        <div v-if="record.contractOffer && record.contractOffer.date_end">
                            {{ moment(record.contractOffer.date_end).format('YYYY.MM.DD') }}
                        </div>
                        <div v-else>----------</div>
                    </template>
                    <template slot="price" slot-scope="text, record">
                        <div class="flex-item">
                            <img class="eth-size" src="@/assets/images/eth-icon.svg">
                            <div v-if="record.contractOffer && record.contractOffer.selling_price">
                                {{ +record.contractOffer.selling_price }}
                            </div>
                            <div v-else>-</div>
                        </div>
                    </template>
                    <template slot="rate" slot-scope="text, record">
                        <div v-if="record.contractOffer">
                            Dad: {{ 100 - record.contractOffer.artist_percent }}%
                        </div>
                        <div v-if="record.contractOffer">
                            Artist: {{ record.contractOffer.artist_percent }}%
                        </div>
                    </template>
                    <template slot="status" slot-scope="text, record">
                        {{ getContractStatus(record) }}
                    </template>
                    <template slot="action" slot-scope="text, record">
                        <nuxt-link :to="{ name: 'contract-detail-id', params: { id: record.id } }">
                            <a-config-provider :autoInsertSpaceInButton="false">
                                <a-button class="btn-action" type="primary">詳細</a-button>
                            </a-config-provider>
                        </nuxt-link>
                    </template>
                </a-table>
                <!-- end main-table -->
            </a-card>
        </a-spin>
        <!-- end modal-detail -->
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import BaseComponent from "~/mixins/BaseComponent";
import moment from 'moment';
import {CONTRACT_STATUS} from '~/utils/constants';
import 'moment/locale/ja';
import ja_JP from 'ant-design-vue/es/locale/ja_JP';

moment.locale('ja');

export default {
    components: {},

    mixins: [BaseComponent],

    data() {
        return {
            localeDateTime: ja_JP,
            visible: true,
            currentId: 0,
            loading: false,
            contractStatus: CONTRACT_STATUS,
            search: {
                duration: [],
                username: '',
                name: '',
                status: '',
            },
            defaultDuration: null,
        };
    },
    head() {
        return {
            title: `${this.$t('menu.contract.default')}`,
            bodyAttrs: {
                class: 'current-page-contract-index'
            }
        }
    },
    computed: {
        ...mapGetters({
            getterListContract: "contracts/getterList",
            getterMetaContract: "contracts/getterMeta"
        }),
        moment: () => moment,
        columns() {
            return [
                {
                    title: "ID",
                    dataIndex: "id",
                    sorter: true,
                    scopedSlots: {customRender: "no"},
                    width: 70,
                },
                {
                    title: this.$t("contract.offer_id"),
                    dataIndex: "contract_offer_id",
                    scopedSlots: {customRender: "offer_id"},
                    width: 100,
                },
                {
                    title: this.$t("contract.image"),
                    dataIndex: "image_url",
                    scopedSlots: {customRender: "image"},
                    width: 150,
                },
                {
                    title: this.$t("contract.name"),
                    dataIndex: "name",
                    scopedSlots: {customRender: "cus-name"},
                    width: 220,
                },
                {
                    title: this.$t("contract.duration"),
                    dataIndex: "",
                    scopedSlots: {customRender: "duration"},
                    width: 100,
                },
                {
                    title: this.$t("contract.price"),
                    dataIndex: "selling_price",
                    scopedSlots: {customRender: "price"},
                    sorter: true,
                    width: 120,
                },
                {
                    title: this.$t("contract.rate"),
                    dataIndex: "",
                    scopedSlots: {customRender: "rate"},
                    width: 100,
                },
                {
                    title: this.$t("contract.status"),
                    dataIndex: "status",
                    scopedSlots: {customRender: "status"},
                    sorter: true,
                    width: 80,
                },
                {
                    title: this.$t("contract.action"),
                    scopedSlots: {customRender: "action"},
                    width: 90,
                }
            ];
        },
        paginate() {
            if (this.getterMetaContract && this.getterMetaContract.last_page && this.getterMetaContract.last_page < 2) {
                return false
            }
            return {
                ...this.getterMetaContract,
                showLessItems: true
            }
        }
    },
    watch: {},
    mounted() {
        this.getList();
    },
    methods: {
        ...mapActions({
            actionGetAllContract: "contracts/actionGetAll",
        }),

        /**
         * get list contracts
         *
         * @param pagination
         * @param filters
         * @param sorter
         */
        getList(pagination = {}, filters, sorter) {
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
            this.actionGetAllContract(this.paramter).finally(() => {
                this.loading = false;
            });
        },

        /**
         * search
         *
         * @param string value
         */
        onSearch() {
            if (this.search) {
                this.paramter = {...this.paramter, ...this.search};
                this.paramter.page = 1
                this.getList();
            }
        },

        /**
         * Onchange duration param
         *
         * @param date
         * @param dateString
         */
        onChangeDuration(date, dateString) {
            this.search.duration = dateString;
        },
    },
    created() {
        const self = this;
        if (process.browser) {
            window.addEventListener('keydown', (e) => {
                if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13)
                    self.onSearch()
            }, true);
        }
        const {query} = this.$route

        this.search.status = Object.prototype.hasOwnProperty.call(query, 'status') && query.status ? +query.status : 6;
        this.search.username = Object.prototype.hasOwnProperty.call(query, 'username') && query.username ? query.username : '';
        this.search.name = Object.prototype.hasOwnProperty.call(query, 'name') && query.name ? query.name : '';
        try {
            const duration = Object.prototype.hasOwnProperty.call(query, 'duration') && query.duration ? query.duration : null
            if (duration) {
                let range = []
                if (duration.length) {
                    range.push(moment(duration[0]))
                }
                if (duration.length === 2) {
                    range.push(moment(duration[1]))
                }

                this.defaultDuration = range
            }
        } catch (e) {
            this.defaultDuration = null
        }
    },
};
</script>
