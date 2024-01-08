<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("module.payment") }}
                </template>

                <div class="box-filters pt-2 pb-4">
                    <div class="contract-search-group">
                        <a-config-provider :locale="localeDateTime">
                            <a-date-picker :placeholder="'作成日'" class="ct-range-with" @change="onChangeDuration"
                                format="YYYY.MM.DD">
                                <a-icon slot="suffixIcon" type="calendar" />
                            </a-date-picker>
                        </a-config-provider>
                        <input type="text" class="ct-input-search ant-input shorten-name" :placeholder="'Dad名'"
                            v-model="search.full_name_dad" maxLength="200" />
                        <input type="text" class="ct-input-search ant-input shorten-name" :placeholder="'Artist名'"
                            v-model="search.full_name_artist" maxLength="200" />
                        <input type="text" class="ct-input-search ant-input shorten-name" :placeholder="'契約ID'"
                            v-model="search.contract_id" maxLength="200">
                        <a-select class="ct-input-search" ref="select" v-model="search.status" style="width: 120px"
                            :placeholder="'状況'">
                            <a-select-option value="">すべて</a-select-option>
                            <a-select-option v-for="(item, index) in statusPayments" :key="index" :value="item.value">
                                {{ item.label }}
                            </a-select-option>
                        </a-select>
                        <button size="large" @click="onSearch()" class="btn-back ct-search-btn">
                            {{ $t('common.search') }}
                        </button>
                    </div>
                </div>
                <a-table :columns="columns" :row-key="record => record.id" :data-source="getterListPayment"
                    :pagination="getterMetaPayment && getterMetaPayment.total && getterMetaPayment.total > 1 ? getterMetaPayment : false" :scroll="{ x: 400 }" :locale="{ emptyText: 'データがありません。' }"
                    @change="getList">
                    <template slot="contract_nft_id" slot-scope="text, record">
                        <span>{{ record.contract_nft_id }}</span>
                    </template>
                    <template slot="name" slot-scope="text, record">
                        <nuxt-link :to="{ name: 'contract-detail-id', params: { id: record.contract_nft_id } }">
                            <div class="shorten-name">{{ record ? record.name : '' }}</div>
                        </nuxt-link>
                        <div class="shorten-name">
                            Dad: {{ record ? record.full_name_dad : '' }}
                        </div>
                        <div class="shorten-name">
                            Artist: {{ record ? record.full_name_artist : '' }}
                        </div>
                    </template>
                    <template slot="selling_price" slot-scope="text, record">
                        <img class="eth-size" style="margin-top: -3px;" src="@/assets/images/eth-icon.svg">
                        <span>{{ record ? record.selling_price - 0 : '' }}</span>
                    </template>
                    <template slot="dividend" slot-scope="text, record">
                        <img class="eth-size" style="margin-top: -3px;" src="@/assets/images/eth-icon.svg">
                        <span>{{ record ? record.dividend - 0 : '' }}</span>
                    </template>
                    <template slot="dad_price" slot-scope="text, record">
                        <img class="eth-size" style="margin-top: -3px;" src="@/assets/images/eth-icon.svg">
                        <span>{{ record ? record.dad_price - 0 : '' }}</span>
                    </template>
                    <template slot="artist_price" slot-scope="text, record">
                        <img class="eth-size" style="margin-top: -3px;" src="@/assets/images/eth-icon.svg">
                        <span>{{ record ? record.artist_price - 0 : '' }}</span>
                    </template>
                    <template slot="status" slot-scope="text, record">
                        {{ getStatus(record) }}
                    </template>
                    <template slot="action" slot-scope="text, record">
                        <nuxt-link :to="{ name: 'payment-detail-id', params: { id: record.id } }">
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
import { mapActions, mapGetters } from "vuex";
import BaseComponent from "~/mixins/BaseComponent";
import moment from 'moment';
import { STATUS_PAYMENT } from '~/utils/constants';
import 'moment/locale/ja';
moment.locale('ja');
import ja_JP from 'ant-design-vue/es/locale/ja_JP';

export default {
    name: 'paymentIndex',
    components: {},

    mixins: [BaseComponent],

    data() {
        return {
            localeDateTime: ja_JP,
            visible: true,
            currentId: 0,
            loading: false,
            statusPayments: STATUS_PAYMENT,
            search: {
                duration: [],
                full_name_artist: '',
                full_name_dad: '',
                name: '',
                created_at: null
            }
        };
    },
    head() {
        return {
            title: `${this.$t('menu.payment.default')}`,
            bodyAttrs: {
                class: 'current-page-payment-index'
            }
        }
    },
    computed: {
        ...mapGetters({
            getterListPayment: "payments/getterList",
            getterMetaPayment: "payments/getterMeta"
        }),
        moment: () => moment,
        columns() {
            return [
                {
                    title: this.$t("payment.contract_nft_id"),
                    dataIndex: "contract_nft_id",
                    scopedSlots: { customRender: "contract_nft_id" },
                    sorter: true,
                    width: 100,
                },
                {
                    title: this.$t("payment.name"),
                    dataIndex: "name",
                    scopedSlots: { customRender: "name" },
                    width: 220,
                },
                {
                    title: this.$t("payment.contract_offers"),
                    dataIndex: "selling_price",
                    scopedSlots: { customRender: "selling_price" },
                    sorter: true,
                    width: 150,
                },
                {
                    title: this.$t("payment.opensea"),
                    dataIndex: "dividend",
                    scopedSlots: { customRender: "dividend" },
                    sorter: true,
                    width: 150,
                },
                {
                    title: this.$t("payment.dad_price"),
                    dataIndex: "dad_price",
                    scopedSlots: { customRender: "dad_price" },
                    sorter: true,
                    width: 150,
                },
                {
                    title: this.$t("payment.artist_price"),
                    dataIndex: "artist_price",
                    scopedSlots: { customRender: "artist_price" },
                    sorter: true,
                    width: 150,
                },
                {
                    title: this.$t("payment.status"),
                    dataIndex: "status",
                    scopedSlots: { customRender: "status" },
                    width: 120,
                    sorter: true,
                },
                {
                    title: this.$t("payment.label"),
                    dataIndex: "label",
                    scopedSlots: { customRender: "action" },
                    width: 100,
                },
            ];
        }
    },
    watch: {},
    mounted() {
        this.getList();
    },
    methods: {
        ...mapActions({
            actionGetAllPayments: "payments/actionGetAll",
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
            // check pagination push to paramter
            if (sorter) {
                this.paramter.sort = sorter.field
                this.paramter.sortType = sorter.order == 'ascend' ? 0 : 1;
            }
            if (pagination.current) {
                this.paramter.page = pagination.current;
            }
            this.paramter = { ...this.paramter };
            // push parameter to router query
            this.paramter = this.replaceQuery(this.paramter);
            this.actionGetAllPayments(this.paramter).finally(() => {
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
                this.paramter = { ...this.paramter, ...this.search };
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
            this.search.created_at = dateString ? moment(dateString, 'YYYY.MM.DD').format('YYYY-MM-DD') : null;
        },

        /**
         * GetStatus
         * @param record
         */
        getStatus(record) {
            if (record.status) {
                return this.$t('payment.status_1')
            } else {
                return this.$t('payment.status_0')
            }
        }
    },
    created() {
        const self = this;
        if (process.browser) {
            window.addEventListener('keydown', (e) => {
                if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13)
                    self.onSearch()
            }, true);
        }
    },
};
</script>
<style lang="less" src="assets/admin/custom.less"></style>
