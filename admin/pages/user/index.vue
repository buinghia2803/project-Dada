<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("module.user") }}
                </template>

                <div class="box-filters pt-2 pb-4">
                    <a-row :gutter="24">
                        <a-col :xl="20" :span="24">
                            <a-config-provider :autoInsertSpaceInButton="false">
                                <a-button class="button btn-primary" type="primary" @click="gotoNew()">
                                    {{ $t("user.create_user") }}
                                </a-button>
                            </a-config-provider>
                        </a-col>
                        <a-col :xl=4 :span="24">
                            <div class="search-group">
                                <select v-model="form.status" id="status" class="select-search select">
                                    <option key="1" value="">{{$t('user.status.all')}}</option>
                                    <option key="2" value="1" :selected="form.status == 1 ? 'true' : null">{{$t('user.status.active')}}</option>
                                    <option key="3" value="0" :selected="form.status == 0 ? 'true' : null">{{$t('user.status.deactive')}}</option>
                                </select>
                                <a-config-provider :autoInsertSpaceInButton="false">
                                    <a-button class="button btn-info" @click="onSearch(form.status)">
                                        {{ $t("common.search") }}
                                    </a-button>
                                </a-config-provider>
                            </div>
                        </a-col>
                    </a-row>
                </div>

                <a-table :locale="{emptyText: $t('common.no_data')}"
                         :columns="columns"
                         :row-key="record => record.id"
                         :data-source="getterListUser"
                         :pagination="(getterMetaUser.last_page && getterMetaUser.last_page != 1) ? getterMetaUser : false"
                         :scroll="{ x: 400 }"
                         :class="'d-table-custom-1'"
                         :rowClassName="(record, index) => `d-custom-tr d-custom-${index % 2 ? 'old' : 'even'}`"
                         @change="handleTableChange">
                    <template>
                        <span slot="public_address_main" slot-scope="text, record">
                            {{ record.public_address_main }}
                        </span>
                    </template>
                    <template slot="image_url" slot-scope="text, record">
                        <img :alt="$t('user.avatar')"
                             :src="(record.image_url ? $nuxt.context.env.IMAGE_URL + record.image_url : require('assets/images/avatar.png'))"
                             width="80px"
                             height="80px"
                             class="border-radius-50">
                    </template>
                    <template slot="full_name" slot-scope="text, record">
                        {{ formatText(record.full_name, 20) }}
                    </template>
                    <template slot="positions" slot-scope="text, record">
                        <span class="text-overflow-2">
                            {{ record.positions }}
                        </span>
                    </template>
                    <template slot="status" slot-scope="text, record">
                        {{ listStatus[record.status] }}
                    </template>
                    <template slot="created_at" slot-scope="text, record">
                        {{ formatDate(record.created_at) }}
                    </template>
                    <template slot="action" slot-scope="text, record">
                        <nuxt-link :to="{ name: 'user-id', params: { id: record.id } }">
                            <a-config-provider :autoInsertSpaceInButton="false">
                                <a-button class="button btn-action" size="small" type="primary">
                                    {{ $t("common.edit") }}
                                </a-button>
                            </a-config-provider>
                        </nuxt-link>
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button class="button btn-action"
                                      type="danger"
                                      @click="confirmToDelete(record)">

                                {{ $t("common.delete") }}
                            </a-button>
                        </a-config-provider>
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

export default {
    components: {},

    mixins: [BaseComponent],

    data() {
        return {
            visible: false,
            currentId: 0,
            loading: false,
            form: {
                status: ''
            },
            listStatus: {
                '': this.$t('user.status.all'),
                1: this.$t('user.status.active'),
                0: this.$t('user.status.deactive')
            },

        };
    },
    head() {
        return {
            title: `${this.$t('menu.user.default')}`,
            bodyAttrs: {
                class: 'current-page-user-index'
            }
        }
    },
    computed: {
        ...mapGetters({
            getterListUser: "user/getterList",
            getterMetaUser: "user/getterMeta"
        }),
        columns() {
            return [
                {
                    title: this.$t('user.id_metamask'),
                    dataIndex: "public_address_main",
                    scopedSlots: {customRender: "public_address_main"},
                    width: 190
                },
                {
                    title: this.$t('user.avatar'),
                    dataIndex: "image_url",
                    scopedSlots: {customRender: "image_url"},
                    width: 190
                },
                {
                    title: this.$t('user.full_name'),
                    dataIndex: "full_name",
                    scopedSlots: {customRender: "full_name"},
                    width: 190
                },
                {
                    title: this.$t('user.positions'),
                    dataIndex: "positions",
                    scopedSlots: {customRender: "positions"},
                    width: 190
                },
                {
                    title: this.$t('user.status.default'),
                    dataIndex: "status",
                    scopedSlots: {customRender: "status"},
                    sorter: true,
                    width: 100
                },
                {
                    title: this.$t('user.created_at'),
                    dataIndex: "created_at",
                    scopedSlots: {customRender: "created_at"},
                    sorter: true,
                    width: 150
                },
                {
                    title: this.$t('common.action'),
                    dataIndex: "action",
                    scopedSlots: {customRender: "action"},
                    width: 180
                }
            ];
        }
    },
    watch: {},
    mounted() {
        this.getList();
        this.form.status = this.paramter.status ? this.paramter.status : '';
    },
    methods: {
        ...mapActions({
            actionGetAllUser: "user/actionGetAll",
            actionDeleteUser: "user/actionDelete",
        }),

        /**
         * delete user
         *
         * @param object item
         */
        async deleteItem(item) {
            this.loading = true;
            // delete user
            await this.actionDeleteUser(item);
            this.loading = false;
            this.getList();
        },

        /**
         * get list user
         *
         * @param object pagination
         */
        async getList(pagination = {}) {
            this.loading = true;
            // check pagination push to paramter
            if (pagination.current) {
                this.paramter.page = pagination.current;
            }
            this.paramter = {...this.paramter};
            // push paramter to router query
            this.paramter = this.replaceQuery(this.paramter);
            let listData = await this.actionGetAllUser(this.paramter);
            this.loading = false;
        },

        /**
         * search
         *
         * @param string value
         */
        onSearch(value) {
            this.paramter = {...this.paramter, status: value};
            this.getList();
        },

        /**
         * confirm delete
         */
        confirmToDelete(item) {
            this.$confirm({
                mask: false,
                title: this.$t('user.title_delete'),
                okText: this.$t('common.delete'),
                okType: "danger",
                cancelText: this.$t('common.cancel'),
                onOk: () => this.deleteItem(item)
            });
        },

        /**
         * Close dialog
         *
         * @param {boolean} fetch - fetch status
         */
        closeDialog(fetch) {
            this.visible = false;
        },

        /**
         * go to new page
         */
        gotoNew() {
            this.$router.push({name: "user-new"});
        },

        /**
         * Format date
         */
        formatDate(date) {
            return moment(date).format('YYYY.MM.DD')
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
            this.paramter = {...this.paramter, ...sorter};
            this.getList()

        },
        formatText(text, length) {
            return (text && text.length > length) ? (text.slice(0, length) + '...') : text;
        }
    }
};
</script>
<style scoped lang="less">
.search-group {
    display: flex;
    justify-content: flex-end;
}

.select-search {
    margin-right: 10px;
}

.box-filters {
    margin-bottom: 20px;
}

.text-overflow-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.text-overflow-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
