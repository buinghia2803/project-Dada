<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("module.notice") }}
                </template>

                <div class="box-filters pt-2 pb-4">
                    <a-col :xl="12" :span="24">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button class="button btn-primary ant-btn ant-btn-primary" html-type="button" @click="gotoNew()">
                                {{ $t("common.register") }}
                            </a-button>
                        </a-config-provider>
                    </a-col>
                    <div class="contract-search-group">
                        <label class="lb-duration">公開日</label>
                        <a-config-provider :locale="localeDateTime">
                        <a-range-picker
                            :placeholder="['始める', '終わり']"
                            class="ct-range-with"
                            @change="onChangeDatePublic"
                        >
                            <a-icon slot="suffixIcon" type="calendar"/>
                        </a-range-picker>
                        </a-config-provider>
                        <input
                            type="text"
                            class="ct-input-search input-search ant-input"
                            :placeholder="$t('notice.title')"
                            v-model="search.title"
                            maxlength="255"
                        />
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button class="button btn-info" html-type="button" @click="onSearch()">
                                {{ $t("common.search") }}
                            </a-button>
                        </a-config-provider>
                    </div>
                </div>

                <a-table
                    :locale="{emptyText: 'データがありません。'}"
                    :columns="columns"
                    :row-key="record => record.id"
                    :data-source="getterListNotification"
                    :pagination="paginate"
                    :scroll="{ x: 400 }"
                    :class="'d-table-custom-1'"
                    :rowClassName="(record, index) => `d-custom-tr d-custom-${index % 2 ? 'old' : 'even'}`"
                    @change="handleTableChange"
                >
                    <template slot="id" style="width: 50px"></template>
                    <template slot="title" slot-scope="text, record">
                        <div v-if="record" class="text-two-line">{{ record.title }}</div>
                    </template>
                    <template slot="content" slot-scope="text, record">
                        <div v-if="record" class="text-two-line" v-html="record.content"></div>
                    </template>
                    <template slot="type" slot-scope="text, record">
                        {{ getTypeNotice(record) }}
                    </template>
                    <template  slot="date_public" slot-scope="text, record">
                        {{ moment(record.date_public).format('YYYY.MM.DD HH:mm') }}
                    </template>
                    <template slot="action" slot-scope="text, record">
                        <nuxt-link v-if="record.status === 0" :to="{ name: 'notice-edit-id', params: { id: record.id } }">
                            <a-config-provider :autoInsertSpaceInButton="false">
                                <a-button class="button btn-action" html-type="button" type="primary">
                                    編集
                                </a-button>
                            </a-config-provider>
                        </nuxt-link>
                        <a-config-provider v-if="record.status === 0" :autoInsertSpaceInButton="false">
                            <a-button  class="button btn-action"
                                      type="danger"
                                      @click="confirmToDelete(record)">
                                削除
                            </a-button>
                        </a-config-provider>
                    </template>
                </a-table>
                <!-- end main-table -->
            </a-card>
        </a-spin>
        <a-modal
            ref="detail"
            :visible="visible"
            :width="1300"
            :footer="null"
            @cancel="visible = false"
        >
            <template slot="title">
                {{ currentId ? $t("common.edit") : $t("common.create") }}
                {{ $t("module.user") }}
            </template>

            <a-spin>
                <user-form
                    :id="currentId"
                    @save="closeDialog(true)"
                    @cancel="closeDialog(false)"
                />
            </a-spin>
        </a-modal>
        <!-- end modal-detail -->
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
            paramter: {},
            visible: false,
            localeDateTime: ja_JP,
            currentId: 0,
            loading: false,
            data: [],
            listRoles: [],
            search: {
                title: '',
                date_public: ''
            }
        };
    },
    head() {
        return {
            title: `${this.$t('menu.notice.default')}`,
            bodyAttrs: {
                class: 'current-page-notice-index'
            }
        }
    },
    computed: {
        ...mapGetters({
            getterListNotification: "notification/getterList",
            getterMetaNotification: "notification/getterMeta"
        }),
        moment: () => moment,
        columns() {
            return [
                {
                    title: this.$t("notice.id"),
                    dataIndex: "id",
                    sorter: true,
                    scopedSlots: {customRender: "id"},
                    width: 100,
                },
                {
                    title: this.$t("notice.title"),
                    dataIndex: "title",
                    scopedSlots: {customRender: "title"},
                    width: 350,
                },
                {
                    title: this.$t("notice.content"),
                    dataIndex: "content",
                    scopedSlots: {customRender: "content"},
                    width: 190
                },
                {
                    title: this.$t("notice.dad/artist"),
                    dataIndex: "type",
                    scopedSlots: {customRender: "type"},
                    width: 150,
                },
                {
                    title: this.$t("notice.release date"),
                    dataIndex: "date_public",
                    scopedSlots: {customRender: "date_public"},
                    width: 150,
                },
                {
                    title: this.$t("offer.action"),
                    dataIndex: "action",
                    scopedSlots: {customRender: "action"},
                    width: 200
                }
            ];
        },
        paginate() {
            if (this.getterMetaNotification && this.getterMetaNotification.total && this.getterMetaNotification.total > 1) {
                return false
            }
            return {
                ...this.getterMetaNotification,
                showLessItems: true
            }
        }
    },
    created() {
        this.getList()
    },
    methods: {
        ...mapActions({
            actionGetAllNotify: "notification/actionGetAll",
            actionDeleteNotify: "notification/actionDelete",
            actionShowNotify: "notification/actionShow",
        }),

        /**
         * get typeNotice
         * @params type - type notify
         */
        getTypeNotice(item) {
            let typeNotice = ''
            switch (item.type) {
                case 1:
                    typeNotice = 'Dad'
                    // code block
                    break;
                case 2:
                    typeNotice = 'Artist'
                    // code block
                    break;
                case 3:
                    typeNotice = 'DadとArtist'
                    break;
                default:
                    typeNotice = ''
                // code block
            }
            return typeNotice
        },
        /**
         * confirm delete
         */
        confirmToDelete(item) {
            this.$confirm({
                mask: false,
                title: this.$t("text.confirm_to_delete"),
                okText: this.$t("common.delete"),
                okType: "danger",
                cancelText: this.$t("common.cancel"),
                onOk: () => this.deleteItem(item)
            });
        },

        /**
         * delete notification
         *
         * @param object item
         */
        deleteItem(item) {
            this.loading = true;
            // update user
            this.actionDeleteNotify(item).finally(() => {
                this.getList();
            });
        },

        /**
         * get List notification
         *
         * @param object item
         */

        getList() {
            this.paramter = this.replaceQuery(this.paramter);
            this.actionGetAllNotify(this.paramter).finally(() => {
                this.loading = false;
            });
        },

        /**
         * go to create notice page
         //  */
        gotoNew() {
            this.$router.push({name: "notice-create"});
        },

        /**
         * search
         *
         * @param string value
         */
        onSearch() {
            this.paramter.page = 1
            this.paramter = {...this.paramter, ...this.search};
            this.getList();
        },
        /**
         * change date_public and get data
         *
         * @param string value
         */
        onChangeDatePublic(value, dateString) {
            this.search.date_public = dateString
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
    }
};
</script>
<style scoped lang="less">
.text-two-line {
    //font-size: 17px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>
