<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("menu.revenue.default") }}
                </template>

                <div class="box-filters pt-2 pb-4">
                    <a-row :gutter="24">
                        <a-col :xl="12" :span="24">
                        </a-col>
                        <a-col :xl="12" :span="24">
                            <div class="search-group">
                                <a-input
                                    type="text"
                                    class="input-search"
                                    style="width: 300px"
                                    v-model="search.full_name"
                                    :placeholder="$t('pages.revenue.full_name')"
                                />
                                <a-config-provider :locale="localeDateTime">
                                    <a-month-picker
                                        :locale="localeDateTime"
                                        class="input-search ml-2"
                                        v-model="search.datetime"
                                        format="YYYY.MM"
                                        style="width: 280px"/>
                                </a-config-provider>

                                <a-config-provider :autoInsertSpaceInButton="false">
                                    <a-button class="btn-info" html-type="button" @click="onSearch()">
                                        {{ $t("common.search") }}
                                    </a-button>
                                </a-config-provider>
                            </div>
                        </a-col>
                    </a-row>
                </div>
                <div class="revenue_detail">
                    <div><b>{{$t("pages.revenue.total_revenue")}} : </b>¥{{ getterListOverViewRevenue.sum_total_price ? getterListOverViewRevenue.sum_total_price : 0 }}</div>
                    <div><b>{{$t("pages.revenue.number_contract_complete")}} : </b>{{ getterListOverViewRevenue.count_contract ? getterListOverViewRevenue.count_contract : 0 }}</div>
                    <div><b>{{$t("pages.revenue.artist_revenue")}} : </b>¥{{ getterListOverViewRevenue.sum_price_artist ? getterListOverViewRevenue.sum_price_artist : 0 }}</div>
                    <div><b>{{$t("pages.revenue.dad_revenue")}} : </b>¥{{ getterListOverViewRevenue.sum_price_dad ? getterListOverViewRevenue.sum_price_dad : 0 }}</div>
                    <div><b>{{$t("pages.revenue.system_revenue")}} : </b>¥{{ getterListOverViewRevenue.sum_price_system ? getterListOverViewRevenue.sum_price_system : 0 }}</div>
                </div>
                <a-table :locale="{emptyText: $t('common.no_data')}"
                    :columns="columns"
                    :row-key="record => record.id"
                    :data-source="getterRevenue"
                    :pagination="getterPaginateRevenue"
                    :scroll="{ x: 400 }"
                    @change="handleTableChange"
                    :class="'d-table-custom-1'"
                    :rowClassName="(record, index) => `d-custom-tr d-custom-${index % 2 ? 'old' : 'even'}`"
                >

                    <template slot="total_revenue_user" slot-scope="text, record">
                       ¥{{ record.sum_total_price }}
                    </template>
                    <template slot="number_contract_complete" slot-scope="text, record">
                       {{ record.count_contract }}
                    </template>
                    <template slot="artist_revenue" slot-scope="text, record">
                       ¥{{ record.sum_price_artist }}
                    </template>
                    <template slot="dad_revenue" slot-scope="text, record">
                       ¥{{ record.sum_price_dad }}
                    </template>
                    <template slot="system_revenue" slot-scope="text, record">
                       ¥{{ record.sum_price_system }}
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
import moment from "moment";
import 'moment/locale/ja';
import ja_JP from 'ant-design-vue/es/locale/ja_JP';
moment.locale('ja');

export default {
    components: {},

    mixins: [BaseComponent],

        data() {
            return {
                localeDateTime: ja_JP,
                visible: false,
                currentId: 0,
                loading: false,
                search: {
                    full_name: '',
                    datetime: moment(new Date()).format('YYYY.MM')
                }
            };
        },
    head() {
        return {
            title: `${this.$t('menu.revenue.default')}`,
            bodyAttrs: {
                class: 'current-page-revenue-index'
            }
        }
    },
        computed: {
            ...mapGetters({
                getterListOverViewRevenue: "revenue/getterOverViewRevenue",
                getterRevenue: "revenue/getterRevenue",
                getterPaginateRevenue: "revenue/getterPaginateRevenue"
            }),
            columns() {
                return [
                    {
                        title: this.$t('pages.revenue.id'),
                        dataIndex: "id",
                        sorter: true,
                        width: 120
                    },
                    {
                        title: this.$t('pages.revenue.full_name'),
                        dataIndex: "full_name",
                        scopedSlots: { customRender: "full_name" },
                    },
                    {
                        title: this.$t('pages.revenue.total_revenue_user'),
                        dataIndex: "sum_total_price",
                        scopedSlots: { customRender: "total_revenue_user" },
                        sorter: true,
                        width: 200
                    },
                    {
                        title: this.$t('pages.revenue.number_contract_complete'),
                        dataIndex: "count_contract",
                        scopedSlots: { customRender: "number_contract_complete" },
                        sorter: true,
                        width: 200
                    },
                    {
                        title: this.$t('pages.revenue.artist_revenue'),
                        dataIndex: "sum_price_artist",
                        scopedSlots: { customRender: "artist_revenue" },
                        sorter: true,
                        width: 200
                    },
                    {
                        title: this.$t('pages.revenue.dad_revenue'),
                        dataIndex: "sum_price_dad",
                        scopedSlots: { customRender: "dad_revenue" },
                        sorter: true,
                        width: 200
                    },
                    {
                        title: this.$t('pages.revenue.system_revenue'),
                        dataIndex: "sum_price_system",
                        scopedSlots: { customRender: "system_revenue" },
                        width: 200
                    },
                ];
            }
        },
        watch: {},
        mounted() {
            this.getOverView();
            this.getList();
            if (this.paramter.month && this.paramter.year) {
                this.search.datetime = this.paramter.year + '.' + this.paramter.month
            }
        },
        methods: {
            ...mapActions({
                actionGetOverViewRevenue: "revenue/actionGetOverViewRevenue",
                actionGetDetailRevenue: "revenue/actionGetDetailRevenue",
            }),

            /**
             * get list user
             *
             * @param object pagination
             */
            async getOverView() {
                this.loading = true;
                // check pagination push to paramter
                this.paramter = { ...this.paramter };
                // push paramter to router query
                this.paramter = this.replaceQuery(this.paramter);
                await this.actionGetOverViewRevenue(this.paramter);
                this.loading = false;
            },

            /**
             * get list user
             *
             * @param object pagination
             */
            async getList(pagination = {}) {
                let dateDefault = {};
                this.loading = true;

                // check pagination push to paramter
                if (pagination.current) {
                    this.paramter.page = pagination.current;
                }
                if (!this.paramter.month || !this.paramter.year) {
                    dateDefault.month = moment(new Date()).format('MM');
                    dateDefault.year = moment(new Date()).format('YYYY');
                }
                this.paramter = { ...this.paramter, ...dateDefault };
                console.log(this.paramter);
                // push paramter to router query
                this.paramter = this.replaceQuery(this.paramter);
                await this.actionGetDetailRevenue(this.paramter);
                this.loading = false;
            },

            /**
             * search
             *
             * @param string value
             */
            onSearch() {
                let dataPost = {};
                if (this.search.datetime) {
                    if (typeof this.search.datetime === 'string') {
                        let dateTime = this.search.datetime.split('.')
                        dataPost['month'] = dateTime[1];
                        dataPost['year'] = dateTime[0];
                    } else {
                        dataPost['month'] = this.search.datetime.format('MM');
                        dataPost['year'] = this.search.datetime.format('YYYY');
                    }
                }
                if (this.search.full_name) {
                    dataPost['full_name'] = this.search.full_name;
                }
                this.paramter = { ...this.paramter, ...dataPost };
                this.getOverView();
                this.getList();
            },

            /**
             * change pagination and sorter
             */
            handleTableChange(pagination, filters, sorter) {
                if (sorter) {
                    this.paramter.sort = sorter.field
                    this.paramter.sortType = sorter.order == 'ascend' ? 1 : 0;
                }
                if (pagination.current) {
                    this.paramter.page = pagination.current;
                }
                this.paramter = { ...this.paramter, ...sorter };
                this.getList()

            },
        }
    };
</script>
<style lang="less" src="../../assets/admin/revenue.less"></style>
