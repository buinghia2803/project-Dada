<template>
    <div class="main-news">
        <a-spin :spinning="loading">
            <div class="box-head-action">
                <div class="first-child">
                    <svg class="role-btn" width="13" height="19" viewBox="0 0 13 19" fill="none"
                        xmlns="http://www.w3.org/2000/svg" @click="redirectToMypage">
                        <path
                            d="M4.7915 9.49958L12.0103 16.7183L9.94817 18.7804L0.667337 9.49958L9.94817 0.21875L12.0103 2.28083L4.7915 9.49958Z"
                            fill="black" />
                    </svg>
                </div>
                <h3>お知らせ</h3>
                <div class="last-child">
                    <svg class="role-btn" width="22" height="22" viewBox="0 0 22 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg" @click="redirectToSettingNotify">
                        <path
                            d="M1.1316 12.6288C0.952227 11.5495 0.952227 10.4481 1.1316 9.36879C2.2336 9.39479 3.2236 8.86679 3.6086 7.93779C3.9936 7.00779 3.6666 5.93379 2.8686 5.17479C3.50501 4.28408 4.28416 3.50459 5.1746 2.86779C5.9346 3.66579 7.0086 3.99279 7.9386 3.60779C8.8686 3.22279 9.3956 2.23179 9.3686 1.13079C10.4485 0.951195 11.5507 0.951195 12.6306 1.13079C12.6036 2.23279 13.1316 3.22279 14.0606 3.60779C14.9906 3.99279 16.0646 3.66579 16.8236 2.86779C17.7143 3.5042 18.4938 4.28335 19.1306 5.17379C18.3326 5.93379 18.0056 7.00779 18.3906 7.93779C18.7756 8.86779 19.7666 9.39479 20.8676 9.36779C21.0472 10.4477 21.0472 11.5499 20.8676 12.6298C19.7656 12.6028 18.7756 13.1308 18.3906 14.0598C18.0056 14.9898 18.3326 16.0638 19.1306 16.8228C18.4942 17.7135 17.715 18.493 16.8246 19.1298C16.0646 18.3318 14.9906 18.0048 14.0606 18.3898C13.1306 18.7748 12.6036 19.7658 12.6306 20.8668C11.5507 21.0464 10.4485 21.0464 9.3686 20.8668C9.3956 19.7648 8.8676 18.7748 7.9386 18.3898C7.0086 18.0048 5.9346 18.3318 5.1756 19.1298C4.28489 18.4934 3.5054 17.7142 2.8686 16.8238C3.6666 16.0638 3.9936 14.9898 3.6086 14.0598C3.2236 13.1298 2.2326 12.6028 1.1316 12.6298V12.6288ZM10.9996 13.9988C11.7952 13.9988 12.5583 13.6827 13.1209 13.1201C13.6835 12.5575 13.9996 11.7944 13.9996 10.9988C13.9996 10.2031 13.6835 9.44008 13.1209 8.87747C12.5583 8.31486 11.7952 7.99879 10.9996 7.99879C10.204 7.99879 9.44089 8.31486 8.87828 8.87747C8.31567 9.44008 7.9996 10.2031 7.9996 10.9988C7.9996 11.7944 8.31567 12.5575 8.87828 13.1201C9.44089 13.6827 10.204 13.9988 10.9996 13.9988Z"
                            fill="black" />
                    </svg>
                </div>
            </div>
            <hr class="line-title" />

            <div class="list-news-service">
                <a-tabs v-model="activeKey" @change="onChange">
                    <a-tab-pane key="notify_con" tab="作品について">
                        <Notify :data="data" :active-key="activeKey" :per-page="perPage"
                            :data-pagination="dataPagination" @change-page="changePage" />
                    </a-tab-pane>
                    <a-tab-pane key="notify_sys" tab="サービスについて">
                        <Notify :data="data" :user="data" :active-key="activeKey" :per-page="perPage"
                            :data-pagination="dataPagination" @change-page="changePage" />
                    </a-tab-pane>
                </a-tabs>
            </div>
        </a-spin>
    </div>
</template>

<script>
import { mapActions } from "vuex";
const Notify = () => import("~/components/custom/news/Notify");

export default {
    layout: "main",
    components: {
        Notify,
    },

    data() {
        return {
            activeKey: "notify_sys",
            data: [],
            dataPagination: {},
            perPage: 1,
            loading: false,
            selectedId: 1,
            user: [],
        };
    },

    mounted() {
        this.getData();
    },

    methods: {
        /**
         * Redirect To Mypage
         *
         */
        redirectToMypage() {
            this.$router.push({ path: "/mypage" });
        },
        /**
         * Redirect To SettingNotify
         *
         */
        redirectToSettingNotify() {
            this.$router.push({ path: "/mypage/setting/notify" });
        },
        ...mapActions({
            actionGetAll: "notify/actionGetAll",
            actionUpdateStatusNotify: "notify/updateStatusNotificationByUser",
            getNotificationByUser: "setting-user/getNotificationByUser",
        }),
        /**
         * Get All Data Notify
         * @params page
         * @type Number
         */
        getData(page = 1) {
            this.loading = true;
            const params = { limit: 11, page, activeKey: this.activeKey };
            this.actionGetAll(params)
                .then((data) => {
                    this.data = data.data;
                    this.dataPagination = data.meta;
                    this.perPage = data.meta.per_page;
                    const filterNotifyId = this.data.map(item => item.id)
                    this.actionUpdateStatusNotify(filterNotifyId);
                })
                .finally(() => {
                    this.getNotificationByUser();
                    this.loading = false;
                });
        },
        /**
         * Transfer Page Paginate
         *
         */
        changePage(page) {
            this.getData(page);
        },

        onChange() {
            this.getData();
        },
    },
};
</script>

<style lang="less">
.main-news {
    .ant-tabs-top-bar {
        border-bottom: unset;
    }

    .ant-tabs-nav {
        width: 100%;

        & div {
            display: flex;
            justify-content: space-around;
            border-bottom: 1px solid #bcbcbc;
        }

        .ant-tabs-tab-active {
            color: black;
        }

        .ant-tabs-ink-bar {
            background-color: black;
        }
    }

    .ant-tabs-nav .ant-tabs-tab {
        width: 50%;
        font-size: 16px;
    }

    hr {
        margin-bottom: 40px;
    }

    .content-tab-2 {
        .items {
            display: block;
            border-bottom: 1px solid #cfd8dc;
            padding: 8px;
            cursor: pointer;

            .d-date {
                font-size: 12px;
            }

            p.content {
                font-size: 16px;
            }
        }

        .d-pagination {
            margin-top: 32px;
            text-align: center;
        }
    }
}

@media (max-width: 567px) {
    .main-news {
        padding: 16px;
    }
}

.tab-noti ul {
    display: flex;
    justify-content: space-around;
    list-style: none;
    padding: 0;
}

.tab-noti ul li {
    border-bottom: 1px solid #000;
    width: 49%;
    text-align: center;
}
</style>

